<?php
/**
 * Narasumber Hukum Custom Theme — Core Functions & Setup
 */

if (!defined('ABSPATH')) {
    exit;
}

define('NH_THEME_VERSION', '1.0.0');
define('NH_THEME_DIR', get_template_directory());
define('NH_THEME_URI', get_template_directory_uri());

require_once NH_THEME_DIR . '/inc/default-data.php';
require_once NH_THEME_DIR . '/inc/sections.php';
require_once NH_THEME_DIR . '/inc/meta-boxes.php';
require_once NH_THEME_DIR . '/inc/customizer.php';
require_once NH_THEME_DIR . '/inc/admin-settings.php';
require_once NH_THEME_DIR . '/inc/elementor.php';

/**
 * 1. Theme Setup & Elementor Free Support
 */
add_action('after_setup_theme', 'nh_theme_setup');
function nh_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo', [
        'height'      => 120,
        'width'       => 120,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    // Full support for Elementor (Free & Pro) and Gutenberg
    add_theme_support('elementor');
    add_theme_support('align-wide');

    register_nav_menus([
        'primary' => 'Menu Utama (Navbar)',
        'footer'  => 'Menu Layanan (Footer)',
    ]);
}

/**
 * Auto-seed default pages, services, and articles upon theme activation
 */
add_action('after_switch_theme', 'nh_on_theme_activation');
function nh_on_theme_activation() {
    nh_register_custom_post_types();
    nh_seed_initial_data(false);
    flush_rewrite_rules();
}

/**
 * 2. Register Custom Post Types:
 *    - nh_service (/services/{slug})
 *    - nh_contact_msg (Inbox Pesan Kontak di WP Admin)
 */
add_action('init', 'nh_register_custom_post_types');
function nh_register_custom_post_types() {
    // CPT Layanan (/services/{slug})
    register_post_type('nh_service', [
        'labels' => [
            'name'               => 'Layanan Hukum',
            'singular_name'      => 'Layanan',
            'add_new'            => 'Tambah Layanan',
            'add_new_item'       => 'Tambah Layanan Baru',
            'edit_item'          => 'Edit Layanan',
            'new_item'           => 'Layanan Baru',
            'view_item'          => 'Lihat Layanan',
            'search_items'       => 'Cari Layanan',
            'not_found'          => 'Layanan tidak ditemukan',
            'menu_name'          => 'Layanan Hukum',
        ],
        'public'             => true,
        'has_archive'        => false,
        'rewrite'            => ['slug' => 'services', 'with_front' => false],
        'menu_icon'          => 'dashicons-businessman',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'elementor'],
        'show_in_rest'       => true,
    ]);

    // CPT Pesan Kontak Masuk
    register_post_type('nh_contact_msg', [
        'labels' => [
            'name'          => 'Pesan Kontak',
            'singular_name' => 'Pesan Kontak',
            'menu_name'     => 'Pesan Kontak',
        ],
        'public'       => false,
        'show_ui'      => true,
        'menu_icon'    => 'dashicons-email-alt',
        'supports'     => ['title', 'editor', 'custom-fields'],
        'capabilities' => [
            'create_posts' => 'do_not_allow',
        ],
        'map_meta_cap' => true,
    ]);

    // Custom Rewrite Rule so /artikel/{slug} always resolves to single post even if default permalink is /%postname%/
    add_rewrite_rule('^artikel/([^/]+)/?$', 'index.php?name=$matches[1]', 'top');
}

/**
 * 3. Enqueue Fonts, Tailwind v4 CDN / Styles, and Interactive Scripts
 */
add_action('wp_enqueue_scripts', 'nh_enqueue_assets');
function nh_enqueue_assets() {
    // Google Fonts: Inter & Playfair Display
    wp_enqueue_style(
        'nh-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&family=Playfair+Display:wght@400;700&display=swap',
        [],
        null
    );

    // Tailwind CSS Play CDN for 100% utility parity with Next.js Tailwind v4 classes
    wp_enqueue_script(
        'nh-tailwind',
        'https://cdn.tailwindcss.com?plugins=typography,line-clamp',
        [],
        null,
        false
    );

    wp_add_inline_script('nh-tailwind', '
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: "#C5A059",
                        navy: "#0A0A0B",
                        secondary: "#161618",
                        navbar: "#0A0A0B"
                    },
                    fontFamily: {
                        sans: ["Inter", "sans-serif"],
                        serif: ["Playfair Display", "serif"]
                    }
                }
            }
        };
    ');

    // Main Theme Stylesheet
    wp_enqueue_style(
        'nh-style',
        get_stylesheet_uri(),
        ['nh-google-fonts'],
        NH_THEME_VERSION
    );

    // Main Theme Interactive JS
    wp_enqueue_script(
        'nh-main-js',
        NH_THEME_URI . '/assets/js/main.js',
        [],
        NH_THEME_VERSION,
        true
    );

    // Pass Translations, AJAX URL, and Nonce to Frontend JS
    wp_localize_script('nh-main-js', 'NH_CONFIG', [
        'ajaxUrl'      => admin_url('admin-ajax.php'),
        'restUrl'      => esc_url_raw(rest_url('nh/v1/contact')),
        'nonce'        => wp_create_nonce('nh_contact_nonce'),
        'isHome'       => is_front_page(),
        'translations' => nh_get_translations(),
    ]);
}

/**
 * 4. Contact Form AJAX & REST API Handler + Optional SMTP Setup
 */
add_action('phpmailer_init', 'nh_configure_smtp');
function nh_configure_smtp($phpmailer) {
    $host = get_option('nh_smtp_host');
    $user = get_option('nh_smtp_user');
    $pass = get_option('nh_smtp_pass');
    $port = get_option('nh_smtp_port', 465);

    if (!empty($host) && !empty($user) && !empty($pass)) {
        $phpmailer->isSMTP();
        $phpmailer->Host       = $host;
        $phpmailer->SMTPAuth   = true;
        $phpmailer->Port       = intval($port);
        $phpmailer->Username   = $user;
        $phpmailer->Password   = $pass;
        $phpmailer->SMTPSecure = (intval($port) === 465) ? 'ssl' : 'tls';
        $phpmailer->From       = $user;
        $phpmailer->FromName   = 'Website Narasumber Hukum';
    }
}

add_action('wp_ajax_nh_submit_contact', 'nh_handle_contact_submission');
add_action('wp_ajax_nopriv_nh_submit_contact', 'nh_handle_contact_submission');
function nh_handle_contact_submission() {
    $name    = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email   = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $phone   = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(['message' => 'Mohon lengkapi nama, email, dan pesan Anda.'], 400);
    }

    // 1. Save to WordPress Database (Pesan Kontak CPT)
    $post_title = sprintf('[%s] %s — %s', current_time('d/m/Y H:i'), $name, $subject ?: 'Konsultasi Hukum');
    $post_body  = sprintf(
        "Nama: %s\nEmail: %s\nTelepon/WA: %s\nSubjek: %s\n\nPesan:\n%s",
        $name,
        $email,
        $phone ?: '-',
        $subject ?: '-',
        $message
    );

    wp_insert_post([
        'post_title'   => $post_title,
        'post_content' => $post_body,
        'post_status'  => 'publish',
        'post_type'    => 'nh_contact_msg',
        'meta_input'   => [
            '_nh_sender_name'  => $name,
            '_nh_sender_email' => $email,
            '_nh_sender_phone' => $phone,
        ],
    ]);

    // 2. Send Email Notification (replicate app/api/contact/route.ts)
    $to      = get_theme_mod('nh_email_official', 'hello@narasumberhukum.com');
    $mail_subject = '[Web Contact] ' . ($subject ?: 'Pesan Baru dari ' . $name);
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    ];
    $html_body = sprintf(
        '<h3>Pesan Baru dari Website Narasumber Hukum</h3>
        <p><strong>Nama:</strong> %s</p>
        <p><strong>Email:</strong> %s</p>
        <p><strong>Telepon:</strong> %s</p>
        <p><strong>Subjek:</strong> %s</p><br/>
        <p><strong>Pesan:</strong></p>
        <p>%s</p>',
        esc_html($name),
        esc_html($email),
        esc_html($phone ?: '-'),
        esc_html($subject ?: '-'),
        nl2br(esc_html($message))
    );

    @wp_mail($to, $mail_subject, $html_body, $headers);

    wp_send_json_success(['message' => 'Pesan berhasil dikirim!']);
}

/**
 * 5. Inline SVG Icon Helper (Replicates Lucide-React & FaWhatsapp 1:1)
 */
function nh_icon($name, $size = 24, $class = '') {
    $s = intval($size);
    $c = esc_attr($class);
    $attrs = sprintf('xmlns="http://www.w3.org/2000/svg" width="%d" height="%d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="%s"', $s, $s, $c);

    switch ($name) {
        case 'scale':
            return "<svg $attrs><path d=\"m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z\"/><path d=\"m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z\"/><path d=\"M7 21h10\"/><path d=\"M12 3v18\"/><path d=\"M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2\"/></svg>";
        case 'file-text':
            return "<svg $attrs><path d=\"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z\"/><path d=\"M14 2v4a2 2 0 0 0 2 2h4\"/><path d=\"M10 9H8\"/><path d=\"M16 13H8\"/><path d=\"M16 17H8\"/></svg>";
        case 'shield-check':
        case 'shield':
            return "<svg $attrs><path d=\"M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z\"/><path d=\"m9 12 2 2 4-4\"/></svg>";
        case 'lightbulb':
            return "<svg $attrs><path d=\"M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5\"/><path d=\"M9 18h6\"/><path d=\"M10 22h4\"/></svg>";
        case 'check-circle':
            return "<svg $attrs><path d=\"M22 11.08V12a10 10 0 1 1-5.93-9.14\"/><path d=\"m9 11 3 3L22 4\"/></svg>";
        case 'zap':
            return "<svg $attrs><path d=\"M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z\"/></svg>";
        case 'message-circle':
            return "<svg $attrs><path d=\"M7.9 20A9 9 0 1 0 4 16.1L2 22Z\"/></svg>";
        case 'rocket':
            return "<svg $attrs><path d=\"M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z\"/><path d=\"m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z\"/><path d=\"M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0\"/><path d=\"M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5\"/></svg>";
        case 'target':
            return "<svg $attrs><circle cx=\"12\" cy=\"12\" r=\"10\"/><circle cx=\"12\" cy=\"12\" r=\"6\"/><circle cx=\"12\" cy=\"12\" r=\"2\"/></svg>";
        case 'heart':
            return "<svg $attrs><path d=\"M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z\"/></svg>";
        case 'trending-up':
            return "<svg $attrs><polyline points=\"22 7 13.5 15.5 8.5 10.5 2 17\"/><polyline points=\"16 7 22 7 22 13\"/></svg>";
        case 'phone':
            return "<svg $attrs><path d=\"M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z\"/></svg>";
        case 'mail':
            return "<svg $attrs><rect width=\"20\" height=\"16\" x=\"2\" y=\"4\" rx=\"2\"/><path d=\"m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7\"/></svg>";
        case 'map-pin':
            return "<svg $attrs><path d=\"M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z\"/><circle cx=\"12\" cy=\"10\" r=\"3\"/></svg>";
        case 'arrow-right':
            return "<svg $attrs><path d=\"M5 12h14\"/><path d=\"m12 5 7 7-7 7\"/></svg>";
        case 'arrow-left':
            return "<svg $attrs><path d=\"m12 19-7-7 7-7\"/><path d=\"M19 12H5\"/></svg>";
        case 'chevron-down':
            return "<svg $attrs><path d=\"m6 9 6 6 6-6\"/></svg>";
        case 'chevron-up':
            return "<svg $attrs><path d=\"m18 15-6-6-6 6\"/></svg>";
        case 'globe':
            return "<svg $attrs><circle cx=\"12\" cy=\"12\" r=\"10\"/><path d=\"M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20\"/><path d=\"M2 12h20\"/></svg>";
        case 'menu':
            return "<svg $attrs><line x1=\"4\" x2=\"20\" y1=\"12\" y2=\"12\"/><line x1=\"4\" x2=\"20\" y1=\"6\" y2=\"6\"/><line x1=\"4\" x2=\"20\" y1=\"18\" y2=\"18\"/></svg>";
        case 'x':
            return "<svg $attrs><path d=\"M18 6 6 18\"/><path d=\"m6 6 12 12\"/></svg>";
        case 'calendar':
            return "<svg $attrs><path d=\"M8 2v4\"/><path d=\"M16 2v4\"/><rect width=\"18\" height=\"18\" x=\"3\" y=\"4\" rx=\"2\"/><path d=\"M3 10h18\"/></svg>";
        case 'user':
            return "<svg $attrs><path d=\"M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2\"/><circle cx=\"12\" cy=\"7\" r=\"4\"/></svg>";
        case 'tag':
            return "<svg $attrs><path d=\"M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z\"/><circle cx=\"7.5\" cy=\"7.5\" r=\".5\" fill=\"currentColor\"/></svg>";
        case 'clock':
            return "<svg $attrs><circle cx=\"12\" cy=\"12\" r=\"10\"/><polyline points=\"12 6 12 12 16 14\"/></svg>";
        case 'send':
            return "<svg $attrs><path d=\"m22 2-7 20-4-9-9-4Z\"/><path d=\"M22 2 11 13\"/></svg>";
        case 'instagram':
            return "<svg $attrs><rect width=\"20\" height=\"20\" x=\"2\" y=\"2\" rx=\"5\" ry=\"5\"/><path d=\"M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z\"/><line x1=\"17.5\" x2=\"17.51\" y1=\"6.5\" y2=\"6.5\"/></svg>";
        case 'facebook':
            return "<svg $attrs><path d=\"M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z\"/></svg>";
        case 'linkedin':
            return "<svg $attrs><path d=\"M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z\"/><rect width=\"4\" height=\"12\" x=\"2\" y=\"9\"/><circle cx=\"4\" cy=\"4\" r=\"2\"/></svg>";
        case 'whatsapp':
            return sprintf('<svg xmlns="http://www.w3.org/2000/svg" width="%d" height="%d" viewBox="0 0 448 512" fill="currentColor" class="%s"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>', $s, $s, $c);
        default:
            return "<svg $attrs><circle cx=\"12\" cy=\"12\" r=\"10\"/></svg>";
    }
}

/**
 * 6. Reusable UI Components: ContactForm & ConsultationCTA
 */
function nh_render_contact_form_component() {
    $t = nh_get_translations()['id']['contact_form'];
    ?>
    <div class="bg-white p-6 md:p-10 rounded-[2rem] shadow-2xl border border-gray-100 relative overflow-hidden">
        <!-- Success View -->
        <div id="nh-contact-success" class="hidden text-center py-12">
            <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <?php echo nh_icon('check-circle', 40); ?>
            </div>
            <h3 class="text-2xl font-bold text-navy mb-4" data-nh-i18n="contact_form.success_title"><?php echo esc_html($t['success_title']); ?></h3>
            <p class="text-gray-500" data-nh-i18n="contact_form.success_message"><?php echo esc_html($t['success_message']); ?></p>
        </div>

        <!-- Form View -->
        <form id="nh-contact-form" class="space-y-5">
            <div class="grid grid-cols-1 gap-5">
                <div class="space-y-2 text-left">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1 block" data-nh-i18n="contact_form.name_label"><?php echo esc_html($t['name_label']); ?></label>
                    <input required type="text" name="name" data-nh-placeholder="contact_form.name_placeholder" placeholder="<?php echo esc_attr($t['name_placeholder']); ?>" class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:border-gold focus:ring-0 transition-all outline-none text-navy font-medium placeholder:text-gray-300" />
                </div>
                <div class="space-y-2 text-left">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1 block" data-nh-i18n="contact_form.email_label"><?php echo esc_html($t['email_label']); ?></label>
                    <input required type="email" name="email" data-nh-placeholder="contact_form.email_placeholder" placeholder="<?php echo esc_attr($t['email_placeholder']); ?>" class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:border-gold focus:ring-0 transition-all outline-none text-navy font-medium placeholder:text-gray-300" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5">
                <div class="space-y-2 text-left">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1 block" data-nh-i18n="contact_form.phone_label"><?php echo esc_html($t['phone_label']); ?></label>
                    <input required type="tel" name="phone" data-nh-placeholder="contact_form.phone_placeholder" placeholder="<?php echo esc_attr($t['phone_placeholder']); ?>" class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:border-gold focus:ring-0 transition-all outline-none text-navy font-medium placeholder:text-gray-300" />
                </div>
                <div class="space-y-2 text-left">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1 block" data-nh-i18n="contact_form.subject_label"><?php echo esc_html($t['subject_label']); ?></label>
                    <input required type="text" name="subject" data-nh-placeholder="contact_form.subject_placeholder" placeholder="<?php echo esc_attr($t['subject_placeholder']); ?>" class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:border-gold focus:ring-0 transition-all outline-none text-navy font-medium placeholder:text-gray-300" />
                </div>
            </div>

            <div class="space-y-2 text-left">
                <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1 block" data-nh-i18n="contact_form.message_label"><?php echo esc_html($t['message_label']); ?></label>
                <textarea required rows="3" name="message" data-nh-placeholder="contact_form.message_placeholder" placeholder="<?php echo esc_attr($t['message_placeholder']); ?>" class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:border-gold focus:ring-0 transition-all outline-none text-navy font-medium placeholder:text-gray-300 resize-none"></textarea>
            </div>

            <button type="submit" id="nh-contact-submit" class="w-full bg-navy text-white py-4 rounded-xl font-bold uppercase tracking-[0.2em] text-xs flex items-center justify-center gap-3 hover:bg-gold hover:text-navy transition-all duration-300 shadow-xl shadow-navy/10 active:scale-95 disabled:opacity-70 mt-2 cursor-pointer">
                <span id="nh-contact-submit-text" data-nh-i18n="contact_form.submit_button"><?php echo esc_html($t['submit_button']); ?></span>
                <?php echo nh_icon('send', 16); ?>
            </button>

            <div id="nh-contact-error" class="hidden flex-col items-center gap-2 text-red-500 text-xs font-medium justify-center mt-4 bg-red-50 p-3 rounded-xl border border-red-100">
                <span id="nh-contact-error-text" data-nh-i18n="contact_form.error_message"><?php echo esc_html($t['error_message']); ?></span>
            </div>
        </form>
    </div>
    <?php
}

function nh_render_consultation_cta_component() {
    $c = nh_get_translations()['id']['consultation_cta'];
    $wa_num = get_theme_mod('nh_wa_article_cta', '6281252992361');
    $wa_msg = rawurlencode('Halo Office Narasumber Hukum, saya ingin berkonsultasi mengenai permasalahan hukum saya setelah membaca artikel di website.');
    $wa_url = "https://wa.me/{$wa_num}?text={$wa_msg}";
    ?>
    <div class="mt-12 mb-12 relative overflow-hidden rounded-2xl max-w-4xl mx-auto shadow-xl nh-reveal">
        <div class="absolute inset-0 bg-navy"></div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-gold/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-gold/5 rounded-full blur-3xl -ml-32 -mb-32"></div>

        <div class="relative z-10 p-6 md:p-8 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-gold/20 rounded-xl mb-4 text-gold">
                <?php echo nh_icon('message-circle', 24); ?>
            </div>
            <h2 class="text-lg md:text-xl font-bold text-white mb-3 uppercase tracking-widest font-sans" data-nh-i18n="consultation_cta.title">
                <?php echo esc_html($c['title']); ?>
            </h2>
            <p class="text-gray-300 text-xs md:text-sm max-w-2xl mx-auto mb-6 leading-relaxed" data-nh-i18n="consultation_cta.desc">
                <?php echo esc_html($c['desc']); ?>
            </p>
            <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-gold hover:bg-white text-navy font-bold py-3 px-6 text-sm rounded-lg transition-all duration-300 transform hover:scale-105 shadow-md group">
                <span data-nh-i18n="consultation_cta.button"><?php echo esc_html($c['button']); ?></span>
                <?php echo nh_icon('arrow-right', 16, 'group-hover:translate-x-1 transition-transform'); ?>
            </a>
            <div class="mt-8 flex items-center justify-center gap-2 text-gray-500 text-sm">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span data-nh-i18n="consultation_cta.available"><?php echo esc_html($c['available']); ?></span>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Helper to get article featured image (supports both WP Featured Image and external URL meta)
 */
function nh_get_post_image($post_id) {
    if (has_post_thumbnail($post_id)) {
        return get_the_post_thumbnail_url($post_id, 'full');
    }
    $meta_img = get_post_meta($post_id, '_nh_image_url', true);
    if (!empty($meta_img)) {
        return $meta_img;
    }
    return 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=1200&q=80';
}

/**
 * Helper to compute reading time in minutes
 */
function nh_get_reading_time($content) {
    $words = str_word_count(wp_strip_all_tags($content));
    return max(1, round($words / 200));
}
