<?php
/**
 * Narasumber Hukum Admin Dashboard Panel:
 * 1. One-Click Seeder (Pages, Services, Default Articles, Permalinks)
 * 2. Full-Stack External API Article Importer (Import articles from existing backend API)
 * 3. Easy Visual Content Editor (Edit FAQ, Testimonials, Why Us, About Us without touching code)
 * 4. SMTP Email Configuration (mail.narasumberhukum.com)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', 'nh_register_admin_menu');
function nh_register_admin_menu() {
    add_menu_page(
        'Narasumber Hukum Panel',
        'Narasumber Hukum',
        'manage_options',
        'nh-admin-panel',
        'nh_render_admin_panel',
        'dashicons-welcome-learn-more',
        2
    );
}

function nh_seed_initial_data($force = false) {
    if (!$force && get_option('nh_initial_seed_done')) {
        return ['status' => 'skipped', 'message' => 'Data awal sudah pernah di-generate.'];
    }

    $created_pages = 0;
    $created_services = 0;
    $created_articles = 0;

    // 1. Create Core Pages (/tentang, /services, /artikel, /kontak) & Homepage
    $pages = [
        'beranda'  => ['title' => 'Beranda', 'template' => ''],
        'tentang'  => ['title' => 'Tentang Kami', 'template' => 'page-tentang.php'],
        'services' => ['title' => 'Layanan', 'template' => 'page-services.php'],
        'artikel'  => ['title' => 'Artikel & Edukasi', 'template' => 'page-artikel.php'],
        'kontak'   => ['title' => 'Hubungi Kami', 'template' => 'page-kontak.php'],
    ];

    $beranda_id = 0;
    foreach ($pages as $slug => $p) {
        $existing = get_page_by_path($slug, OBJECT, 'page');
        if (!$existing) {
            $page_id = wp_insert_post([
                'post_title'   => $p['title'],
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            ]);
            if ($page_id && !is_wp_error($page_id)) {
                if (!empty($p['template'])) {
                    update_post_meta($page_id, '_wp_page_template', $p['template']);
                }
                $created_pages++;
                if ($slug === 'beranda') {
                    $beranda_id = $page_id;
                }
            }
        } else {
            if ($slug === 'beranda') {
                $beranda_id = $existing->ID;
            }
        }
    }

    if ($beranda_id) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $beranda_id);
    }

    // 2. Seed Services (nh_service)
    $services = nh_get_services_data();
    foreach ($services as $slug => $srv) {
        $existing = get_page_by_path($slug, OBJECT, 'nh_service');
        if (!$existing) {
            $srv_id = wp_insert_post([
                'post_title'   => $srv['title_id'],
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'nh_service',
                'post_content' => $srv['content_id'],
                'post_excerpt' => $srv['short_id'],
            ]);
            if ($srv_id && !is_wp_error($srv_id)) {
                update_post_meta($srv_id, '_nh_service_icon', $srv['icon']);
                update_post_meta($srv_id, '_nh_service_image', $srv['image']);
                update_post_meta($srv_id, '_nh_service_short_id', $srv['short_id']);
                update_post_meta($srv_id, '_nh_service_title_en', $srv['title_en']);
                update_post_meta($srv_id, '_nh_service_short_en', $srv['short_en']);
                update_post_meta($srv_id, '_nh_service_content_en', $srv['content_en']);
                $created_services++;
            }
        }
    }

    // 3. Seed 5 Default Legal Education Articles
    $articles = nh_get_default_seed_articles();
    foreach ($articles as $art) {
        $existing = get_page_by_path($art['slug'], OBJECT, 'post');
        if (!$existing) {
            $cat_term = term_exists($art['category'], 'category');
            if (!$cat_term) {
                $cat_term = wp_insert_term($art['category'], 'category');
            }
            $cat_id = is_array($cat_term) ? intval($cat_term['term_id']) : intval($cat_term);

            $post_id = wp_insert_post([
                'post_title'    => $art['title'],
                'post_name'     => $art['slug'],
                'post_status'   => 'publish',
                'post_type'     => 'post',
                'post_excerpt'  => $art['excerpt'],
                'post_content'  => $art['content'],
                'post_category' => $cat_id ? [$cat_id] : [],
            ]);

            if ($post_id && !is_wp_error($post_id)) {
                update_post_meta($post_id, '_nh_image_url', $art['image']);
                update_post_meta($post_id, '_nh_author_name', 'Admin NH');
                if (!empty($art['supporting_images'])) {
                    update_post_meta($post_id, '_nh_supporting_images', $art['supporting_images']);
                }
                $created_articles++;
            }
        }
    }

    update_option('nh_initial_seed_done', 1);
    flush_rewrite_rules();

    return [
        'status'  => 'success',
        'message' => sprintf('Berhasil membuat %d Halaman Utama, %d Layanan, dan %d Artikel Hukum Awal!', $created_pages, $created_services, $created_articles),
    ];
}

function nh_import_articles_from_api($api_base_url) {
    $api_base_url = rtrim(trim($api_base_url), '/');
    if (empty($api_base_url)) {
        return ['status' => 'error', 'message' => 'URL API tidak boleh kosong.'];
    }

    $endpoint = $api_base_url . '/api/articles?per_page=100';
    $response = wp_remote_get($endpoint, ['timeout' => 25, 'sslverify' => false]);

    if (is_wp_error($response)) {
        return ['status' => 'error', 'message' => 'Gagal menghubungi API: ' . $response->get_error_message()];
    }

    $body = wp_remote_retrieve_body($response);
    $json = json_decode($body, true);
    $items = isset($json['data']) && is_array($json['data']) ? $json['data'] : (is_array($json) ? $json : []);

    if (empty($items)) {
        return ['status' => 'error', 'message' => 'Tidak ada data artikel yang ditemukan dari respons API (' . esc_html($endpoint) . ').'];
    }

    $imported = 0;
    $updated  = 0;

    foreach ($items as $item) {
        if (empty($item['title'])) {
            continue;
        }
        $slug = !empty($item['slug']) ? sanitize_title($item['slug']) : sanitize_title($item['title']);
        $cat_name = !empty($item['category']['name']) ? sanitize_text_field($item['category']['name']) : 'Hukum';

        $cat_term = term_exists($cat_name, 'category');
        if (!$cat_term) {
            $cat_term = wp_insert_term($cat_name, 'category');
        }
        $cat_id = is_array($cat_term) ? intval($cat_term['term_id']) : intval($cat_term);

        // Resolve image URL
        $img_url = '';
        if (!empty($item['image_url'])) {
            $img_url = $item['image_url'];
        } elseif (!empty($item['image']) && is_string($item['image'])) {
            if ( strpos($item['image'], 'http') === 0 ) {
                $img_url = $item['image'];
            } else {
                $clean = ltrim($item['image'], '/');
                $img_url = (strpos($clean, 'storage/') === 0) ? $api_base_url . '/' . $clean : $api_base_url . '/storage/' . $clean;
            }
        }

        // Fix inline storage images in content
        $content = isset($item['content']) ? $item['content'] : '';
        $content = preg_replace('/src="(\/?)storage\/([^"]+)"/', 'src="' . $api_base_url . '/storage/$2"', $content);

        $existing = get_page_by_path($slug, OBJECT, 'post');
        $post_data = [
            'post_title'    => sanitize_text_field($item['title']),
            'post_name'     => $slug,
            'post_status'   => 'publish',
            'post_type'     => 'post',
            'post_content'  => $content,
            'post_category' => $cat_id ? [$cat_id] : [],
        ];

        if (!empty($item['published_at'])) {
            $post_data['post_date'] = date('Y-m-d H:i:s', strtotime($item['published_at']));
        }

        if ($existing) {
            $post_data['ID'] = $existing->ID;
            $post_id = wp_update_post($post_data);
            $updated++;
        } else {
            $post_id = wp_insert_post($post_data);
            $imported++;
        }

        if ($post_id && !is_wp_error($post_id)) {
            if ($img_url) {
                update_post_meta($post_id, '_nh_image_url', esc_url_raw($img_url));
            }
            if (!empty($item['author']['name'])) {
                update_post_meta($post_id, '_nh_author_name', sanitize_text_field($item['author']['name']));
            }
            if (!empty($item['supporting_images']) && is_array($item['supporting_images'])) {
                $supp = [];
                foreach ($item['supporting_images'] as $s) {
                    $s_path = is_string($s) ? $s : (isset($s['image']) ? $s['image'] : '');
                    $s_cap  = is_array($s) && isset($s['caption']) ? $s['caption'] : '';
                    if ($s_path) {
                        if (strpos($s_path, 'http') !== 0) {
                            $clean_s = ltrim($s_path, '/');
                            $s_path = (strpos($clean_s, 'storage/') === 0) ? $api_base_url . '/' . $clean_s : $api_base_url . '/storage/' . $clean_s;
                        }
                        $supp[] = ['image' => esc_url_raw($s_path), 'caption' => sanitize_text_field($s_cap)];
                    }
                }
                update_post_meta($post_id, '_nh_supporting_images', $supp);
            }
        }
    }

    return [
        'status'  => 'success',
        'message' => sprintf('Sinkronisasi API selesai! %d artikel baru diimpor, %d artikel diperbarui.', $imported, $updated),
    ];
}

function nh_render_admin_panel() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $notice = null;

    // Handle Form Actions
    if (isset($_POST['nh_admin_action']) && check_admin_referer('nh_admin_panel_nonce')) {
        $action = sanitize_text_field($_POST['nh_admin_action']);

        if ($action === 'seed_defaults') {
            $notice = nh_seed_initial_data(true);
        } elseif ($action === 'import_api') {
            $api_url = isset($_POST['nh_api_base_url']) ? sanitize_text_field($_POST['nh_api_base_url']) : '';
            update_option('nh_api_base_url', $api_url);
            $notice = nh_import_articles_from_api($api_url);
        } elseif ($action === 'save_custom_content') {
            // Save editable Testimonials & FAQs & SMTP
            if (isset($_POST['nh_faq_q']) && is_array($_POST['nh_faq_q'])) {
                $faqs = [];
                foreach ($_POST['nh_faq_q'] as $idx => $q) {
                    $q_clean = sanitize_text_field($q);
                    $a_clean = isset($_POST['nh_faq_a'][$idx]) ? sanitize_textarea_field($_POST['nh_faq_a'][$idx]) : '';
                    if (!empty($q_clean)) {
                        $faqs[] = ['q' => $q_clean, 'a' => $a_clean];
                    }
                }
                update_option('nh_custom_faqs', $faqs);
            }

            if (isset($_POST['nh_testi_name']) && is_array($_POST['nh_testi_name'])) {
                $testis = [];
                foreach ($_POST['nh_testi_name'] as $idx => $name) {
                    $n_clean = sanitize_text_field($name);
                    $r_clean = isset($_POST['nh_testi_role'][$idx]) ? sanitize_text_field($_POST['nh_testi_role'][$idx]) : 'Klien';
                    $t_clean = isset($_POST['nh_testi_text'][$idx]) ? sanitize_textarea_field($_POST['nh_testi_text'][$idx]) : '';
                    if (!empty($n_clean) && !empty($t_clean)) {
                        $testis[] = ['name' => $n_clean, 'role' => $r_clean, 'text' => $t_clean];
                    }
                }
                update_option('nh_custom_testimonials', $testis);
            }

            if (isset($_POST['nh_smtp_host'])) {
                update_option('nh_smtp_host', sanitize_text_field($_POST['nh_smtp_host']));
                update_option('nh_smtp_port', intval($_POST['nh_smtp_port']));
                update_option('nh_smtp_user', sanitize_text_field($_POST['nh_smtp_user']));
                if (!empty($_POST['nh_smtp_pass'])) {
                    update_option('nh_smtp_pass', $_POST['nh_smtp_pass']);
                }
            }

            $notice = ['status' => 'success', 'message' => 'Seluruh pengaturan konten, FAQ, Testimoni, dan SMTP berhasil disimpan!'];
        }
    }

    $defaults = nh_get_translations()['id'];
    $faqs     = get_option('nh_custom_faqs', $defaults['faq']['items']);
    $testis   = get_option('nh_custom_testimonials', $defaults['testimonials']['items']);
    $api_url  = get_option('nh_api_base_url', 'https://api.narasumberhukum.com');
    ?>
    <div class="wrap" style="max-width: 1050px;">
        <h1 style="font-weight:800; color:#0A0A0B; margin-bottom:8px;">Panel Kontrol Narasumber Hukum (NH Custom Theme)</h1>
        <p style="font-size:14px; color:#555; margin-bottom:24px;">Kelola konten halaman, impor artikel dari sistem full-stack sebelumnya, atur FAQ & Testimoni, atau buka dengan <strong>Elementor Gratis</strong>.</p>

        <?php if ($notice) : ?>
            <div class="notice notice-<?php echo $notice['status'] === 'error' ? 'error' : 'success'; ?> is-dismissible">
                <p><strong><?php echo esc_html($notice['message']); ?></strong></p>
            </div>
        <?php endif; ?>

        <!-- CARD 1: ONE-CLICK SETUP & API IMPORTER -->
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
            <div style="background:#fff; padding:24px; border-radius:12px; border:1px solid #e5e7eb; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <h2 style="margin-top:0; color:#0A0A0B;">1. Setup Otomatis Halaman, Layanan & Artikel Awal</h2>
                <p style="color:#555;">Klik tombol di bawah ini untuk otomatis membuat halaman (Beranda, Tentang Kami, Layanan, Artikel, Kontak), 3 Layanan Utama, dan 5 Artikel Edukasi Hukum awal.</p>
                <form method="post">
                    <?php wp_nonce_field('nh_admin_panel_nonce'); ?>
                    <input type="hidden" name="nh_admin_action" value="seed_defaults" />
                    <button type="submit" class="button button-primary button-hero" style="background:#0A0A0B; border-color:#C5A059; color:#C5A059; font-weight:700;">
                        Generate / Perbarui Konten Default Sekarang
                    </button>
                </form>
            </div>

            <div style="background:#fff; padding:24px; border-radius:12px; border:1px solid #e5e7eb; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <h2 style="margin-top:0; color:#0A0A0B;">2. Migrasi Artikel dari Full-Stack API Lama</h2>
                <p style="color:#555;">Tarik seluruh artikel, kategori, dan gambar pendukung (Newspaper Sidebar) dari backend API lama Anda langsung ke database WordPress:</p>
                <form method="post">
                    <?php wp_nonce_field('nh_admin_panel_nonce'); ?>
                    <input type="hidden" name="nh_admin_action" value="import_api" />
                    <input type="url" name="nh_api_base_url" value="<?php echo esc_attr($api_url); ?>" placeholder="https://api.narasumberhukum.com" style="width:100%; margin-bottom:12px; padding:8px;" />
                    <button type="submit" class="button button-secondary button-large">
                        Tarik & Impor Artikel dari API
                    </button>
                </form>
            </div>
        </div>

        <!-- CARD 2: EDIT FAQ, TESTIMONI, & SMTP -->
        <form method="post" style="background:#fff; padding:24px; border-radius:12px; border:1px solid #e5e7eb; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
            <?php wp_nonce_field('nh_admin_panel_nonce'); ?>
            <input type="hidden" name="nh_admin_action" value="save_custom_content" />

            <h2 style="margin-top:0; color:#0A0A0B; border-bottom:2px solid #C5A059; padding-bottom:8px;">3. Edit Pertanyaan Populer (FAQ Beranda)</h2>
            <?php
            $faq_count = max(4, count($faqs) + 1);
            for ($i = 0; $i < $faq_count; $i++) :
                $q = isset($faqs[$i]['q']) ? $faqs[$i]['q'] : '';
                $a = isset($faqs[$i]['a']) ? $faqs[$i]['a'] : '';
            ?>
                <div style="background:#f9fafb; padding:12px; border-radius:8px; margin-bottom:12px; border:1px solid #e5e7eb;">
                    <label style="font-weight:700; display:block; margin-bottom:4px;">Pertanyaan #<?php echo $i + 1; ?> (Kosongkan untuk menghapus):</label>
                    <input type="text" name="nh_faq_q[]" value="<?php echo esc_attr($q); ?>" style="width:100%; margin-bottom:8px;" />
                    <label style="font-weight:600; display:block; margin-bottom:4px;">Jawaban #<?php echo $i + 1; ?>:</label>
                    <textarea name="nh_faq_a[]" rows="2" style="width:100%;"><?php echo esc_textarea($a); ?></textarea>
                </div>
            <?php endfor; ?>

            <h2 style="margin-top:28px; color:#0A0A0B; border-bottom:2px solid #C5A059; padding-bottom:8px;">4. Edit Testimoni Klien</h2>
            <?php
            $testi_count = max(4, count($testis) + 1);
            for ($i = 0; $i < $testi_count; $i++) :
                $n = isset($testis[$i]['name']) ? $testis[$i]['name'] : '';
                $r = isset($testis[$i]['role']) ? $testis[$i]['role'] : 'Klien';
                $t = isset($testis[$i]['text']) ? $testis[$i]['text'] : '';
            ?>
                <div style="background:#f9fafb; padding:12px; border-radius:8px; margin-bottom:12px; border:1px solid #e5e7eb;">
                    <div style="display:flex; gap:12px; margin-bottom:8px;">
                        <div style="flex:2;">
                            <label style="font-weight:700; display:block;">Nama Klien #<?php echo $i + 1; ?>:</label>
                            <input type="text" name="nh_testi_name[]" value="<?php echo esc_attr($n); ?>" style="width:100%;" />
                        </div>
                        <div style="flex:1;">
                            <label style="font-weight:700; display:block;">Peran / Jabatan:</label>
                            <input type="text" name="nh_testi_role[]" value="<?php echo esc_attr($r); ?>" style="width:100%;" />
                        </div>
                    </div>
                    <label style="font-weight:600; display:block;">Isi Testimoni:</label>
                    <textarea name="nh_testi_text[]" rows="2" style="width:100%;"><?php echo esc_textarea($t); ?></textarea>
                </div>
            <?php endfor; ?>

            <h2 style="margin-top:28px; color:#0A0A0B; border-bottom:2px solid #C5A059; padding-bottom:8px;">5. Pengaturan SMTP Email Formulir Kontak (Opsional)</h2>
            <p style="color:#555;">Semua pesan formulir kontak otomatis tersimpan di menu <strong>Pesan Kontak</strong> di sidebar kiri. Jika Anda juga ingin mengirim notifikasi email via SMTP <code>mail.narasumberhukum.com</code>, isi di bawah ini:</p>
            <div style="display:grid; grid-template-columns: 2fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="font-weight:700; display:block;">SMTP Host:</label>
                    <input type="text" name="nh_smtp_host" value="<?php echo esc_attr(get_option('nh_smtp_host', 'mail.narasumberhukum.com')); ?>" style="width:100%;" />
                </div>
                <div>
                    <label style="font-weight:700; display:block;">SMTP Port (465 SSL / 587 TLS):</label>
                    <input type="number" name="nh_smtp_port" value="<?php echo esc_attr(get_option('nh_smtp_port', 465)); ?>" style="width:100%;" />
                </div>
            </div>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px; margin-bottom:20px;">
                <div>
                    <label style="font-weight:700; display:block;">SMTP Username / Email:</label>
                    <input type="text" name="nh_smtp_user" value="<?php echo esc_attr(get_option('nh_smtp_user', 'hello@narasumberhukum.com')); ?>" style="width:100%;" />
                </div>
                <div>
                    <label style="font-weight:700; display:block;">SMTP Password (biarkan kosong jika tidak diubah):</label>
                    <input type="password" name="nh_smtp_pass" value="" placeholder="••••••••" style="width:100%;" />
                </div>
            </div>

            <button type="submit" class="button button-primary button-hero" style="background:#C5A059; border-color:#C5A059; color:#0A0A0B; font-weight:800;">
                Simpan Seluruh Perubahan
            </button>
        </form>
    </div>
    <?php
}
