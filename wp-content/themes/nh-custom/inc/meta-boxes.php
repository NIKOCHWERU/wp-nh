<?php
/**
 * Custom Meta Boxes for Articles (Posts) & Services (nh_service)
 * Easy-to-use fields for non-technical editors in WordPress Admin
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('add_meta_boxes', 'nh_register_custom_meta_boxes');
function nh_register_custom_meta_boxes() {
    // Meta Box for Articles (Post) - Supporting Images & External Thumbnail URL
    add_meta_box(
        'nh_article_meta_box',
        'Pengaturan Artikel Narasumber Hukum (Gambar Utama & Gambar Pendukung Koran/Sidebar)',
        'nh_render_article_meta_box',
        'post',
        'normal',
        'high'
    );

    // Meta Box for Services (nh_service)
    add_meta_box(
        'nh_service_meta_box',
        'Detail Layanan Narasumber Hukum (Ikon, Ringkasan, & Versi Bahasa Inggris)',
        'nh_render_service_meta_box',
        'nh_service',
        'normal',
        'high'
    );
}

function nh_render_article_meta_box($post) {
    wp_nonce_field('nh_save_article_meta', 'nh_article_meta_nonce');
    $external_img = get_post_meta($post->ID, '_nh_image_url', true);
    $author_name  = get_post_meta($post->ID, '_nh_author_name', true);
    $supporting   = get_post_meta($post->ID, '_nh_supporting_images', true);
    if (!is_array($supporting)) {
        $supporting = [];
    }
    ?>
    <style>
        .nh-meta-field { margin-bottom: 16px; }
        .nh-meta-field label { display: block; font-weight: 600; margin-bottom: 6px; color: #0A0A0B; }
        .nh-meta-field input[type="text"], .nh-meta-field input[type="url"] { width: 100%; padding: 8px; border: 1px solid #ccd0d4; border-radius: 6px; }
        .nh-supp-row { display: flex; gap: 10px; margin-bottom: 10px; align-items: center; background: #f9fafb; padding: 10px; border-radius: 6px; border: 1px solid #e5e7eb; }
        .nh-supp-row input { flex: 1; }
    </style>
    <div class="nh-meta-field">
        <label>URL Gambar Utama (Opsional — Gunakan Featured Image di sebelah kanan, atau tempel URL gambar di sini):</label>
        <input type="url" name="nh_image_url" value="<?php echo esc_attr($external_img); ?>" placeholder="https://images.unsplash.com/..." />
        <p class="description">Jika Anda mengupload Featured Image (Gambar Unggulan) WordPress, gambar tersebut akan diutamakan.</p>
    </div>
    <div class="nh-meta-field">
        <label>Nama Penulis Tampilan (Opsional — Default: nama akun penulis WordPress / Admin NH):</label>
        <input type="text" name="nh_author_name" value="<?php echo esc_attr($author_name); ?>" placeholder="Admin NH" />
    </div>
    <hr style="margin: 20px 0;" />
    <div class="nh-meta-field">
        <label>Gambar Pendukung Sidebar (Newspaper Layout seperti di Next.js):</label>
        <p class="description" style="margin-bottom:10px;">Jika diisi, halaman baca artikel akan menampilkan kolom gambar pendukung beserta caption di sebelah kanan artikel.</p>
        <div id="nh-supporting-wrapper">
            <?php
            $count = max(2, count($supporting));
            for ($i = 0; $i < $count; $i++) :
                $img = isset($supporting[$i]['image']) ? $supporting[$i]['image'] : '';
                $cap = isset($supporting[$i]['caption']) ? $supporting[$i]['caption'] : '';
            ?>
            <div class="nh-supp-row">
                <input type="url" name="nh_supp_image[]" value="<?php echo esc_attr($img); ?>" placeholder="URL Gambar Pendukung #<?php echo $i + 1; ?> (https://...)" />
                <input type="text" name="nh_supp_caption[]" value="<?php echo esc_attr($cap); ?>" placeholder="Caption / Keterangan Gambar #<?php echo $i + 1; ?>" />
            </div>
            <?php endfor; ?>
        </div>
        <button type="button" class="button" onclick="
            var wrap = document.getElementById('nh-supporting-wrapper');
            var div = document.createElement('div');
            div.className = 'nh-supp-row';
            div.innerHTML = '<input type=\'url\' name=\'nh_supp_image[]\' placeholder=\'URL Gambar Pendukung (https://...)\' /><input type=\'text\' name=\'nh_supp_caption[]\' placeholder=\'Caption / Keterangan Gambar\' />';
            wrap.appendChild(div);
        ">+ Tambah Baris Gambar Pendukung</button>
    </div>
    <?php
}

function nh_render_service_meta_box($post) {
    wp_nonce_field('nh_save_service_meta', 'nh_service_meta_nonce');
    $icon       = get_post_meta($post->ID, '_nh_service_icon', true) ?: 'scale';
    $image_url  = get_post_meta($post->ID, '_nh_service_image', true);
    $short_id   = get_post_meta($post->ID, '_nh_service_short_id', true);
    $title_en   = get_post_meta($post->ID, '_nh_service_title_en', true);
    $short_en   = get_post_meta($post->ID, '_nh_service_short_en', true);
    $content_en = get_post_meta($post->ID, '_nh_service_content_en', true);
    ?>
    <style>
        .nh-meta-field { margin-bottom: 16px; }
        .nh-meta-field label { display: block; font-weight: 600; margin-bottom: 6px; color: #0A0A0B; }
        .nh-meta-field input[type="text"], .nh-meta-field input[type="url"], .nh-meta-field textarea, .nh-meta-field select { width: 100%; padding: 8px; border: 1px solid #ccd0d4; border-radius: 6px; }
    </style>
    <div class="nh-meta-field">
        <label>Pilih Ikon Layanan:</label>
        <select name="nh_service_icon">
            <option value="scale" <?php selected($icon, 'scale'); ?>>Timbangan Hukum (Scale)</option>
            <option value="file-text" <?php selected($icon, 'file-text'); ?>>Dokumen / Perizinan (FileText)</option>
            <option value="shield-check" <?php selected($icon, 'shield-check'); ?>>Perisai / SDM (ShieldCheck)</option>
            <option value="lightbulb" <?php selected($icon, 'lightbulb'); ?>>Lampu / Solusi (Lightbulb)</option>
        </select>
    </div>
    <div class="nh-meta-field">
        <label>URL Gambar Kartu Layanan (Atau gunakan Featured Image di sidebar kanan):</label>
        <input type="url" name="nh_service_image" value="<?php echo esc_attr($image_url); ?>" placeholder="https://images.unsplash.com/..." />
    </div>
    <div class="nh-meta-field">
        <label>Deskripsi Singkat Kartu (Bahasa Indonesia):</label>
        <textarea name="nh_service_short_id" rows="3"><?php echo esc_textarea($short_id); ?></textarea>
    </div>
    <hr style="margin: 20px 0;" />
    <h4>Versi Bahasa Inggris (Opsional — Untuk Tombol Switch Bahasa ID/EN)</h4>
    <div class="nh-meta-field">
        <label>Judul Layanan (English):</label>
        <input type="text" name="nh_service_title_en" value="<?php echo esc_attr($title_en); ?>" />
    </div>
    <div class="nh-meta-field">
        <label>Deskripsi Singkat Kartu (English):</label>
        <textarea name="nh_service_short_en" rows="3"><?php echo esc_textarea($short_en); ?></textarea>
    </div>
    <div class="nh-meta-field">
        <label>Konten Lengkap Layanan (English HTML):</label>
        <textarea name="nh_service_content_en" rows="8"><?php echo esc_textarea($content_en); ?></textarea>
    </div>
    <?php
}

add_action('save_post', 'nh_save_custom_meta_boxes');
function nh_save_custom_meta_boxes($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save Article Meta
    if (isset($_POST['nh_article_meta_nonce']) && wp_verify_nonce($_POST['nh_article_meta_nonce'], 'nh_save_article_meta')) {
        if (isset($_POST['nh_image_url'])) {
            update_post_meta($post_id, '_nh_image_url', esc_url_raw($_POST['nh_image_url']));
        }
        if (isset($_POST['nh_author_name'])) {
            update_post_meta($post_id, '_nh_author_name', sanitize_text_field($_POST['nh_author_name']));
        }
        if (isset($_POST['nh_supp_image']) && is_array($_POST['nh_supp_image'])) {
            $supp = [];
            $imgs = $_POST['nh_supp_image'];
            $caps = isset($_POST['nh_supp_caption']) ? $_POST['nh_supp_caption'] : [];
            foreach ($imgs as $idx => $url) {
                $clean_url = esc_url_raw(trim($url));
                if (!empty($clean_url)) {
                    $supp[] = [
                        'image' => $clean_url,
                        'caption' => isset($caps[$idx]) ? sanitize_text_field($caps[$idx]) : '',
                    ];
                }
            }
            update_post_meta($post_id, '_nh_supporting_images', $supp);
        }
    }

    // Save Service Meta
    if (isset($_POST['nh_service_meta_nonce']) && wp_verify_nonce($_POST['nh_service_meta_nonce'], 'nh_save_service_meta')) {
        if (isset($_POST['nh_service_icon'])) {
            update_post_meta($post_id, '_nh_service_icon', sanitize_text_field($_POST['nh_service_icon']));
        }
        if (isset($_POST['nh_service_image'])) {
            update_post_meta($post_id, '_nh_service_image', esc_url_raw($_POST['nh_service_image']));
        }
        if (isset($_POST['nh_service_short_id'])) {
            update_post_meta($post_id, '_nh_service_short_id', sanitize_textarea_field($_POST['nh_service_short_id']));
        }
        if (isset($_POST['nh_service_title_en'])) {
            update_post_meta($post_id, '_nh_service_title_en', sanitize_text_field($_POST['nh_service_title_en']));
        }
        if (isset($_POST['nh_service_short_en'])) {
            update_post_meta($post_id, '_nh_service_short_en', sanitize_textarea_field($_POST['nh_service_short_en']));
        }
        if (isset($_POST['nh_service_content_en'])) {
            update_post_meta($post_id, '_nh_service_content_en', wp_kses_post($_POST['nh_service_content_en']));
        }
    }
}
