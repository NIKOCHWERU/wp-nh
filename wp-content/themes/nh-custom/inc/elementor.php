<?php
/**
 * Elementor (Free Version) Complete Integration:
 * 1. Registers ALL 10 Narasumber Hukum sections as native clickable & editable Elementor Widgets
 * 2. Auto-populates Elementor page data (`_elementor_data`) when user opens "Edit with Elementor" on Beranda/Tentang/Kontak,
 *    so EVERY section on the page is immediately clickable, editable, movable, and deletable in Elementor!
 */

if (!defined('ABSPATH')) {
    exit;
}

// Shortcodes
add_shortcode('nh_contact_form', 'nh_render_contact_form_shortcode');
function nh_render_contact_form_shortcode() {
    ob_start();
    nh_render_contact_form_component();
    return ob_get_clean();
}

add_shortcode('nh_consultation_cta', 'nh_render_consultation_cta_shortcode');
function nh_render_consultation_cta_shortcode() {
    ob_start();
    nh_render_consultation_cta_component();
    return ob_get_clean();
}

// Register NH Category at the very top of Elementor widget panel
add_action('elementor/elements/categories_registered', 'nh_add_elementor_widget_categories');
function nh_add_elementor_widget_categories($elements_manager) {
    $elements_manager->add_category(
        'narasumber-hukum',
        [
            'title' => 'Narasumber Hukum (Klik untuk Edit)',
            'icon'  => 'fa fa-balance-scale',
        ]
    );
}

/**
 * Helper to build default Elementor JSON structure for Homepage ("Beranda") so when user clicks "Edit with Elementor",
 * all 9 sections are already live Elementor widgets inside the canvas!
 */
function nh_build_default_beranda_elementor_data() {
    $widgets = [
        'nh_hero_widget',
        'nh_services_preview_widget',
        'nh_why_us_widget',
        'nh_values_widget',
        'nh_testimonials_widget',
        'nh_process_widget',
        'nh_faq_widget',
        'nh_cta_banner_widget',
        'nh_contact_section_widget',
    ];

    $sections = [];
    foreach ($widgets as $idx => $w_name) {
        $sections[] = [
            'id'       => substr(md5('nh_sec_' . $idx), 0, 7),
            'elType'   => 'section',
            'settings' => [
                'layout'  => 'full_width',
                'gap'     => 'no',
                'padding' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true],
            ],
            'elements' => [
                [
                    'id'       => substr(md5('nh_col_' . $idx), 0, 7),
                    'elType'   => 'column',
                    'settings' => [
                        '_column_size' => 100,
                        'padding'      => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true],
                    ],
                    'elements' => [
                        [
                            'id'         => substr(md5('nh_wid_' . $idx), 0, 7),
                            'elType'     => 'widget',
                            'widgetType' => $w_name,
                            'settings'   => [],
                            'elements'   => [],
                        ],
                    ],
                ],
            ],
        ];
    }

    return wp_json_encode($sections);
}

function nh_build_default_tentang_elementor_data() {
    $sections = [
        [
            'id'       => substr(md5('nh_tentang_sec'), 0, 7),
            'elType'   => 'section',
            'settings' => ['layout' => 'full_width', 'gap' => 'no'],
            'elements' => [
                [
                    'id'       => substr(md5('nh_tentang_col'), 0, 7),
                    'elType'   => 'column',
                    'settings' => ['_column_size' => 100],
                    'elements' => [
                        [
                            'id'         => substr(md5('nh_tentang_wid'), 0, 7),
                            'elType'     => 'widget',
                            'widgetType' => 'nh_about_page_widget',
                            'settings'   => [],
                            'elements'   => [],
                        ],
                    ],
                ],
            ],
        ],
    ];
    return wp_json_encode($sections);
}

/**
 * Automatically seed Elementor widgets into Beranda / Tentang Kami if _elementor_data is empty when opening Elementor
 */
add_action('init', 'nh_auto_seed_elementor_canvas_data');
function nh_auto_seed_elementor_canvas_data() {
    // Check if Beranda page exists and has no Elementor widgets yet
    $beranda = get_page_by_path('beranda', OBJECT, 'page');
    if (!$beranda) {
        $front_id = intval(get_option('page_on_front'));
        if ($front_id) {
            $beranda = get_post($front_id);
        }
    }
    if ($beranda) {
        $existing_data = get_post_meta($beranda->ID, '_elementor_data', true);
        if (empty($existing_data) || $existing_data === '[]') {
            update_post_meta($beranda->ID, '_elementor_edit_mode', 'builder');
            update_post_meta($beranda->ID, '_elementor_template_type', 'wp-page');
            update_post_meta($beranda->ID, '_elementor_data', wp_slash(nh_build_default_beranda_elementor_data()));
        }
    }

    $tentang = get_page_by_path('tentang', OBJECT, 'page');
    if ($tentang) {
        $existing_t = get_post_meta($tentang->ID, '_elementor_data', true);
        if (empty($existing_t) || $existing_t === '[]') {
            update_post_meta($tentang->ID, '_elementor_edit_mode', 'builder');
            update_post_meta($tentang->ID, '_elementor_template_type', 'wp-page');
            update_post_meta($tentang->ID, '_elementor_data', wp_slash(nh_build_default_tentang_elementor_data()));
        }
    }
}

/**
 * Register All 10 Editable Elementor Widgets
 */
add_action('elementor/widgets/register', 'nh_register_elementor_widgets');
function nh_register_elementor_widgets($widgets_manager) {
    if (!class_exists('\Elementor\Widget_Base')) {
        return;
    }

    // 1. HERO VIDEO BANNER
    class NH_Elementor_Hero_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'nh_hero_widget'; }
        public function get_title() { return '1. NH — Hero Video Banner'; }
        public function get_icon() { return 'eicon-slider-video'; }
        public function get_categories() { return ['narasumber-hukum']; }

        protected function register_controls() {
            $t = nh_get_translations()['id']['hero'];
            $this->start_controls_section('content_section', [
                'label' => 'Edit Konten Hero',
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]);
            $this->add_control('title_white', [
                'label'   => 'Judul Baris 1 (Putih)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('nh_hero_title_white', $t['title_white']),
            ]);
            $this->add_control('title_gold', [
                'label'   => 'Judul Baris 2 (Emas)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('nh_hero_title_gold', $t['title_gold']),
            ]);
            $this->add_control('subtitle', [
                'label'   => 'Subjudul Hero',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => get_theme_mod('nh_hero_subtitle', $t['subtitle']),
            ]);
            $this->add_control('video_url', [
                'label'   => 'URL Video Background (MP4)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('nh_hero_video_url', 'https://res.cloudinary.com/dysw7tjks/video/upload/v1756377208/Desain_tanpa_judul_oeaojq.mp4'),
            ]);
            $this->add_control('btn1_text', [
                'label'   => 'Teks Tombol 1 (Emas)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['cta_services'],
            ]);
            $this->add_control('btn1_url', [
                'label'   => 'Link Tombol 1',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => home_url('/services'),
            ]);
            $this->add_control('btn2_text', [
                'label'   => 'Teks Tombol 2 (Outline)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['cta_consult'],
            ]);
            $this->add_control('btn2_url', [
                'label'   => 'Link Tombol 2',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => home_url('/kontak'),
            ]);
            $this->end_controls_section();
        }

        protected function render() {
            nh_render_section_hero($this->get_settings_for_display());
        }
    }

    // 2. SERVICES PREVIEW
    class NH_Elementor_Services_Preview_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'nh_services_preview_widget'; }
        public function get_title() { return '2. NH — Layanan Unggulan (3 Kartu)'; }
        public function get_icon() { return 'eicon-gallery-grid'; }
        public function get_categories() { return ['narasumber-hukum']; }

        protected function register_controls() {
            $t = nh_get_translations()['id']['services'];
            $this->start_controls_section('content_section', [
                'label' => 'Edit Layanan Unggulan',
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]);
            $this->add_control('title', [
                'label'   => 'Judul Seksi',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['title'],
            ]);
            $this->add_control('subtitle', [
                'label'   => 'Subjudul Seksi',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => $t['subtitle'],
            ]);

            $rep = new \Elementor\Repeater();
            $rep->add_control('title', [
                'label'   => 'Nama Layanan',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Bidang Hukum',
            ]);
            $rep->add_control('desc', [
                'label'   => 'Deskripsi Singkat',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
            ]);
            $rep->add_control('image', [
                'label'   => 'URL Gambar Background',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
            ]);
            $rep->add_control('slug', [
                'label'   => 'Slug Link Layanan (hukum / perizinan / pelatihan-sdm)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'hukum',
            ]);
            $rep->add_control('icon', [
                'label'   => 'Ikon (scale / file-text / shield-check)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'scale',
            ]);

            $this->add_control('items', [
                'label'       => 'Daftar Kartu Layanan',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $rep->get_controls(),
                'default'     => [
                    [
                        'slug'  => 'hukum',
                        'icon'  => 'scale',
                        'title' => $t['legal_title'],
                        'desc'  => $t['legal_desc'],
                        'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'slug'  => 'perizinan',
                        'icon'  => 'file-text',
                        'title' => $t['licensing_title'],
                        'desc'  => $t['licensing_desc'],
                        'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'slug'  => 'pelatihan-sdm',
                        'icon'  => 'shield-check',
                        'title' => $t['hr_title'],
                        'desc'  => $t['hr_desc'],
                        'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80',
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]);
            $this->end_controls_section();
        }

        protected function render() {
            nh_render_section_services_preview($this->get_settings_for_display());
        }
    }

    // 3. WHY CHOOSE US
    class NH_Elementor_Why_Us_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'nh_why_us_widget'; }
        public function get_title() { return '3. NH — Mengapa Memilih Kami'; }
        public function get_icon() { return 'eicon-check-circle'; }
        public function get_categories() { return ['narasumber-hukum']; }

        protected function register_controls() {
            $t = nh_get_translations()['id']['why_us'];
            $this->start_controls_section('content_section', [
                'label' => 'Edit Mengapa Memilih Kami',
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]);
            $this->add_control('title', [
                'label'   => 'Judul Seksi',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['title'],
            ]);
            $this->add_control('subtitle', [
                'label'   => 'Subjudul Seksi',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => $t['subtitle'],
            ]);

            $rep = new \Elementor\Repeater();
            $rep->add_control('title', [
                'label'   => 'Judul Kartu',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]);
            $rep->add_control('desc', [
                'label'   => 'Deskripsi Kartu',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
            ]);

            $this->add_control('items', [
                'label'       => 'Kartu Keunggulan',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $rep->get_controls(),
                'default'     => $t['items'],
                'title_field' => '{{{ title }}}',
            ]);
            $this->end_controls_section();
        }

        protected function render() {
            nh_render_section_why_us($this->get_settings_for_display());
        }
    }

    // 4. OUR VALUES (RICCIEP)
    class NH_Elementor_Values_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'nh_values_widget'; }
        public function get_title() { return '4. NH — Nilai-Nilai Kami (RICCIEP)'; }
        public function get_icon() { return 'eicon-time-line'; }
        public function get_categories() { return ['narasumber-hukum']; }

        protected function register_controls() {
            $t = nh_get_translations()['id']['values'];
            $this->start_controls_section('content_section', [
                'label' => 'Edit Nilai-Nilai RICCIEP',
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]);
            $this->add_control('title', [
                'label'   => 'Judul Seksi',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['title'],
            ]);
            $this->add_control('subtitle', [
                'label'   => 'Subjudul Seksi',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => $t['subtitle'],
            ]);

            $rep = new \Elementor\Repeater();
            $rep->add_control('initial', [
                'label'   => 'Huruf Lingkaran Tengah (R/I/C/E/P)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'R',
            ]);
            $rep->add_control('name', [
                'label'   => 'Nama Nilai',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'RESPONSIVE (Responsif)',
            ]);
            $rep->add_control('desc', [
                'label'   => 'Deskripsi Nilai',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
            ]);
            $rep->add_control('icon', [
                'label'   => 'Ikon (zap / file-text / message-circle / lightbulb / rocket / target / heart)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'zap',
            ]);

            $this->add_control('items', [
                'label'       => 'Daftar Nilai RICCIEP',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $rep->get_controls(),
                'default'     => $t['items'],
                'title_field' => '{{{ initial }}} - {{{ name }}}',
            ]);
            $this->end_controls_section();
        }

        protected function render() {
            nh_render_section_values($this->get_settings_for_display());
        }
    }

    // 5. TESTIMONIALS
    class NH_Elementor_Testimonials_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'nh_testimonials_widget'; }
        public function get_title() { return '5. NH — Testimoni Klien'; }
        public function get_icon() { return 'eicon-testimonial-carousel'; }
        public function get_categories() { return ['narasumber-hukum']; }

        protected function register_controls() {
            $t = nh_get_translations()['id']['testimonials'];
            $this->start_controls_section('content_section', [
                'label' => 'Edit Testimoni Klien',
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]);
            $this->add_control('title', [
                'label'   => 'Judul Seksi',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['title'],
            ]);
            $this->add_control('subtitle', [
                'label'   => 'Subjudul Seksi',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => $t['subtitle'],
            ]);

            $rep = new \Elementor\Repeater();
            $rep->add_control('name', [
                'label'   => 'Nama Klien',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]);
            $rep->add_control('role', [
                'label'   => 'Peran / Jabatan',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Klien',
            ]);
            $rep->add_control('text', [
                'label'   => 'Isi Testimoni',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
            ]);

            $this->add_control('items', [
                'label'       => 'Daftar Testimoni',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $rep->get_controls(),
                'default'     => get_option('nh_custom_testimonials', $t['items']),
                'title_field' => '{{{ name }}}',
            ]);
            $this->end_controls_section();
        }

        protected function render() {
            nh_render_section_testimonials($this->get_settings_for_display());
        }
    }

    // 6. LEGAL PROCESS
    class NH_Elementor_Process_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'nh_process_widget'; }
        public function get_title() { return '6. NH — Alur Penanganan Perkara'; }
        public function get_icon() { return 'eicon-number-field'; }
        public function get_categories() { return ['narasumber-hukum']; }

        protected function register_controls() {
            $t = nh_get_translations()['id']['process'];
            $this->start_controls_section('content_section', [
                'label' => 'Edit Alur Penanganan Perkara',
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]);
            $this->add_control('title', [
                'label'   => 'Judul Seksi',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['title'],
            ]);
            $this->add_control('subtitle', [
                'label'   => 'Subjudul Seksi',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => $t['subtitle'],
            ]);

            $rep = new \Elementor\Repeater();
            $rep->add_control('step', [
                'label'   => 'Nomor Langkah',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => '01',
            ]);
            $rep->add_control('title', [
                'label'   => 'Judul Langkah',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]);
            $rep->add_control('desc', [
                'label'   => 'Deskripsi Langkah',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
            ]);

            $this->add_control('items', [
                'label'       => 'Langkah-Langkah',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $rep->get_controls(),
                'default'     => $t['items'],
                'title_field' => '{{{ step }}} - {{{ title }}}',
            ]);
            $this->end_controls_section();
        }

        protected function render() {
            nh_render_section_process($this->get_settings_for_display());
        }
    }

    // 7. FAQ ACCORDION
    class NH_Elementor_FAQ_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'nh_faq_widget'; }
        public function get_title() { return '7. NH — Pertanyaan Populer (FAQ)'; }
        public function get_icon() { return 'eicon-accordion'; }
        public function get_categories() { return ['narasumber-hukum']; }

        protected function register_controls() {
            $t = nh_get_translations()['id']['faq'];
            $this->start_controls_section('content_section', [
                'label' => 'Edit Pertanyaan Populer (FAQ)',
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]);
            $this->add_control('title', [
                'label'   => 'Judul Seksi',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['title'],
            ]);

            $rep = new \Elementor\Repeater();
            $rep->add_control('q', [
                'label'   => 'Pertanyaan',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]);
            $rep->add_control('a', [
                'label'   => 'Jawaban',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
            ]);

            $this->add_control('items', [
                'label'       => 'Daftar FAQ',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $rep->get_controls(),
                'default'     => get_option('nh_custom_faqs', $t['items']),
                'title_field' => '{{{ q }}}',
            ]);
            $this->end_controls_section();
        }

        protected function render() {
            nh_render_section_faq($this->get_settings_for_display());
        }
    }

    // 8. CTA QUOTE BANNER
    class NH_Elementor_CTA_Banner_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'nh_cta_banner_widget'; }
        public function get_title() { return '8. NH — Banner Kutipan CTA'; }
        public function get_icon() { return 'eicon-call-to-action'; }
        public function get_categories() { return ['narasumber-hukum']; }

        protected function register_controls() {
            $t = nh_get_translations()['id']['cta_contact'];
            $this->start_controls_section('content_section', [
                'label' => 'Edit Banner Kutipan CTA',
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]);
            $this->add_control('title_quote', [
                'label'   => 'Kutipan Baris 1 (Putih)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['title_quote'],
            ]);
            $this->add_control('title_gold', [
                'label'   => 'Kutipan Baris 2 (Emas)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['title_gold'],
            ]);
            $this->add_control('btn_text', [
                'label'   => 'Teks Tombol',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['free_consult'],
            ]);
            $this->add_control('wa_number', [
                'label'   => 'Nomor WhatsApp (628xxx)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('nh_wa_primary', '6282211020022'),
            ]);
            $this->end_controls_section();
        }

        protected function render() {
            nh_render_section_cta_banner($this->get_settings_for_display());
        }
    }

    // 9. CONTACT SECTION + FORM
    class NH_Elementor_Contact_Section_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'nh_contact_section_widget'; }
        public function get_title() { return '9. NH — Seksi Hubungi Kami & Form'; }
        public function get_icon() { return 'eicon-form-horizontal'; }
        public function get_categories() { return ['narasumber-hukum']; }

        protected function register_controls() {
            $t = nh_get_translations()['id']['contact_page'];
            $this->start_controls_section('content_section', [
                'label' => 'Edit Seksi Hubungi Kami',
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]);
            $this->add_control('title', [
                'label'   => 'Judul Seksi',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['title'],
            ]);
            $this->add_control('description', [
                'label'   => 'Subjudul Kutipan',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => $t['description'],
            ]);
            $this->add_control('phone_text', [
                'label'   => 'Teks Nomor Telepon',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => '+62-822-1102-0022',
            ]);
            $this->add_control('address', [
                'label'   => 'Teks Lokasi Kantor',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Jakarta Pusat, Indonesia',
            ]);
            $this->add_control('email', [
                'label'   => 'Alamat Email',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('nh_email_official', 'hello@narasumberhukum.com'),
            ]);
            $this->end_controls_section();
        }

        protected function render() {
            nh_render_section_contact($this->get_settings_for_display());
        }
    }

    // 10. ABOUT US FULL PAGE WIDGET
    class NH_Elementor_About_Page_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'nh_about_page_widget'; }
        public function get_title() { return '10. NH — Halaman Tentang Kami Lengkap'; }
        public function get_icon() { return 'eicon-info-box'; }
        public function get_categories() { return ['narasumber-hukum']; }

        protected function register_controls() {
            $t = nh_get_translations()['id']['about_page'];
            $this->start_controls_section('content_section', [
                'label' => 'Edit Halaman Tentang Kami',
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]);
            $this->add_control('title', [
                'label'   => 'Judul Putih',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['title'],
            ]);
            $this->add_control('title_gold', [
                'label'   => 'Judul Emas',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['title_gold'],
            ]);
            $this->add_control('tagline', [
                'label'   => 'Tagline',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['tagline'],
            ]);
            $this->add_control('vision_t', [
                'label'   => 'Judul Visi',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $t['vision']['title'],
            ]);
            $this->add_control('vision_d', [
                'label'   => 'Isi Visi',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => $t['vision']['desc'],
            ]);
            $this->end_controls_section();
        }

        protected function render() {
            nh_render_section_about_page($this->get_settings_for_display());
        }
    }

    $widgets_manager->register(new NH_Elementor_Hero_Widget());
    $widgets_manager->register(new NH_Elementor_Services_Preview_Widget());
    $widgets_manager->register(new NH_Elementor_Why_Us_Widget());
    $widgets_manager->register(new NH_Elementor_Values_Widget());
    $widgets_manager->register(new NH_Elementor_Testimonials_Widget());
    $widgets_manager->register(new NH_Elementor_Process_Widget());
    $widgets_manager->register(new NH_Elementor_FAQ_Widget());
    $widgets_manager->register(new NH_Elementor_CTA_Banner_Widget());
    $widgets_manager->register(new NH_Elementor_Contact_Section_Widget());
    $widgets_manager->register(new NH_Elementor_About_Page_Widget());
}
