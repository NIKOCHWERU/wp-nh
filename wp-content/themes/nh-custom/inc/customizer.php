<?php
/**
 * WordPress Theme Customizer — Visual Live Editor for Non-Technical Users
 * Appears under Appearance -> Customize in WP Admin
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('customize_register', 'nh_customize_register');
function nh_customize_register($wp_customize) {

    // 1. PANEL: Narasumber Hukum Theme Options
    $wp_customize->add_panel('nh_theme_panel', [
        'title'       => 'Pengaturan Narasumber Hukum (Live Edit)',
        'description' => 'Ubah teks Hero, Video, Nomor WhatsApp, Kontak, Alamat Kantor, Visi, dan Sosial Media secara langsung.',
        'priority'    => 10,
    ]);

    // SECTION A: Hero Homepage
    $wp_customize->add_section('nh_hero_section', [
        'title' => '1. Hero Beranda & Video',
        'panel' => 'nh_theme_panel',
    ]);

    $hero_fields = [
        'nh_hero_title_white' => ['Judul Hero Baris 1 (Putih)', 'Sentral Edukasi'],
        'nh_hero_title_gold'  => ['Judul Hero Baris 2 (Emas)', 'Dan Solusi Hukum'],
        'nh_hero_subtitle'    => ['Subjudul Hero', 'Kami memberikan pendampingan hukum yang profesional dengan pendekatan edukatif untuk solusi yang berkeadilan dan berkelanjutan.'],
        'nh_hero_video_url'   => ['URL Video Background Hero (MP4)', 'https://res.cloudinary.com/dysw7tjks/video/upload/v1756377208/Desain_tanpa_judul_oeaojq.mp4'],
    ];

    foreach ($hero_fields as $id => $info) {
        $wp_customize->add_setting($id, [
            'default'           => $info[1],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control($id, [
            'label'   => $info[0],
            'section' => 'nh_hero_section',
            'type'    => 'text',
        ]);
    }

    // SECTION B: Kontak, WhatsApp & Sosial Media
    $wp_customize->add_section('nh_contact_section', [
        'title' => '2. Nomor WhatsApp, Email & Sosmed',
        'panel' => 'nh_theme_panel',
    ]);

    $contact_fields = [
        'nh_wa_primary'     => ['Nomor WhatsApp Utama (Format 628xxx)', '6282211020022'],
        'nh_wa_display_1'   => ['Tampilan Nomor Admin', '0822 1102 0022'],
        'nh_wa_advisor'     => ['Nomor WhatsApp Advisor (Format 628xxx)', '6282144424311'],
        'nh_wa_display_2'   => ['Tampilan Nomor Advisor', '0821 4442 4311'],
        'nh_wa_article_cta' => ['Nomor WA Tombol CTA Artikel (Format 628xxx)', '6281252992361'],
        'nh_email_official' => ['Email Resmi', 'hello@narasumberhukum.com'],
        'nh_maps_url'       => ['Link Google Maps Kantor', 'https://maps.app.goo.gl/Z77ydQisZAQ6d1aQ9'],
        'nh_ig_url'         => ['Link Instagram', 'https://www.instagram.com/narasumberhukum'],
        'nh_fb_url'         => ['Link Facebook', 'https://facebook.com/kantor.narasumber.hukum'],
        'nh_li_url'         => ['Link LinkedIn', 'https://www.linkedin.com/company/kantor-narasumber-hukum'],
    ];

    foreach ($contact_fields as $id => $info) {
        $wp_customize->add_setting($id, [
            'default'           => $info[1],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control($id, [
            'label'   => $info[0],
            'section' => 'nh_contact_section',
            'type'    => 'text',
        ]);
    }

    // SECTION C: Alamat 3 Kantor & Footer
    $wp_customize->add_section('nh_offices_section', [
        'title' => '3. Alamat Kantor & Footer',
        'panel' => 'nh_theme_panel',
    ]);

    $office_fields = [
        'nh_office_1_name' => ['Nama Kantor I', 'Kantor I'],
        'nh_office_1_addr' => ['Alamat Kantor I', 'Jl.M.H Thamrin No. 9 Lt 12, Kebon Sirih Menteng, DKI Jakarta, 10340'],
        'nh_office_2_name' => ['Nama Kantor II', 'Kantor II'],
        'nh_office_2_addr' => ['Alamat Kantor II', 'Jl. Sunset Road No. 77, Lt.3, Kuta, Kec. Kuta, Badung, Bali, 80361'],
        'nh_office_3_name' => ['Nama Kantor III', 'Kantor III'],
        'nh_office_3_addr' => ['Alamat Kantor III', 'Jl. Kertabumi No 1 Ruko Kertabumi Blok A No.9 Lantai 2 Kelurahan Karawang Kulon, Kecamatan Karawang Barat, Kabupaten Karawang, Provinsi Jawa Barat'],
        'nh_work_hours'    => ['Jam Operasional', 'Melayani konsultasi Senin - Jumat (09.00 - 17.00 WIB)'],
    ];

    foreach ($office_fields as $id => $info) {
        $wp_customize->add_setting($id, [
            'default'           => $info[1],
            'sanitize_callback' => 'sanitize_textarea_field',
        ]);
        $wp_customize->add_control($id, [
            'label'   => $info[0],
            'section' => 'nh_offices_section',
            'type'    => 'textarea',
        ]);
    }
}
