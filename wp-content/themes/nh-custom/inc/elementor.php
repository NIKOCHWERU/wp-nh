<?php
/**
 * Elementor (Free Version) Complete Integration:
 * 1. Registers ALL 10 Narasumber Hukum sections as native clickable & editable Elementor Widgets
 *    using 100% flat TEXT/TEXTAREA controls for maximum Elementor 4.x stability and ease of use.
 * 2. Auto-populates Elementor page data (`_elementor_data`) using native Flexbox Containers (`container`)
 *    and non-empty associative settings objects so every section on Beranda & Tentang Kami can be
 *    clicked, edited, reordered, or deleted directly on the Elementor canvas.
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

// Register NH Category in Elementor widget panel
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
 * Helper to build default Elementor JSON structure for Homepage ("Beranda")
 * Uses native Elementor 4.x Flexbox Container + non-empty associative settings
 * so json_decode(..., true) -> wp_json_encode() always outputs JSON Objects {} and never []
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

    $containers = [];
    foreach ($widgets as $idx => $w_name) {
        $containers[] = [
            'id'       => substr(md5('nh_con4_' . $idx), 0, 7),
            'elType'   => 'container',
            'isInner'  => false,
            'settings' => [
                'content_width' => 'full',
                'padding'       => [
                    'unit'     => 'px',
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'isLinked' => true,
                ],
            ],
            'elements' => [
                [
                    'id'         => substr(md5('nh_wid4_' . $idx), 0, 7),
                    'elType'     => 'widget',
                    'widgetType' => $w_name,
                    'settings'   => [
                        '_nh_seeded' => 'v4',
                    ],
                    'elements'   => [],
                ],
            ],
        ];
    }

    return wp_json_encode($containers);
}

function nh_build_default_tentang_elementor_data() {
    $containers = [
        [
            'id'       => substr(md5('nh_tentang_con4'), 0, 7),
            'elType'   => 'container',
            'isInner'  => false,
            'settings' => [
                'content_width' => 'full',
                'padding'       => [
                    'unit'     => 'px',
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'isLinked' => true,
                ],
            ],
            'elements' => [
                [
                    'id'         => substr(md5('nh_tentang_wid4'), 0, 7),
                    'elType'     => 'widget',
                    'widgetType' => 'nh_about_page_widget',
                    'settings'   => [
                        '_nh_seeded' => 'v4',
                    ],
                    'elements'   => [],
                ],
            ],
        ],
    ];
    return wp_json_encode($containers);
}

/**
 * Automatically seed/upgrade Elementor widgets into Beranda & Tentang Kami (once per seed version 'v4')
 */
add_action('init', 'nh_auto_seed_elementor_canvas_data');
function nh_auto_seed_elementor_canvas_data() {
    $beranda = get_page_by_path('beranda', OBJECT, 'page');
    if (!$beranda) {
        $front_id = intval(get_option('page_on_front'));
        if ($front_id) {
            $beranda = get_post($front_id);
        }
    }
    if ($beranda) {
        $seed_ver = get_post_meta($beranda->ID, '_nh_elementor_seed_v', true);
        $existing = get_post_meta($beranda->ID, '_elementor_data', true);
        if ($seed_ver !== 'v4' || empty($existing) || $existing === '[]') {
            update_post_meta($beranda->ID, '_elementor_edit_mode', 'builder');
            update_post_meta($beranda->ID, '_elementor_template_type', 'wp-page');
            if (defined('ELEMENTOR_VERSION')) {
                update_post_meta($beranda->ID, '_elementor_version', ELEMENTOR_VERSION);
            }
            update_post_meta($beranda->ID, '_elementor_data', wp_slash(nh_build_default_beranda_elementor_data()));
            delete_post_meta($beranda->ID, '_elementor_css');
            update_post_meta($beranda->ID, '_nh_elementor_seed_v', 'v4');
        }
    }

    $tentang = get_page_by_path('tentang', OBJECT, 'page');
    if ($tentang) {
        $seed_ver_t = get_post_meta($tentang->ID, '_nh_elementor_seed_v', true);
        $existing_t = get_post_meta($tentang->ID, '_elementor_data', true);
        if ($seed_ver_t !== 'v4' || empty($existing_t) || $existing_t === '[]') {
            update_post_meta($tentang->ID, '_elementor_edit_mode', 'builder');
            update_post_meta($tentang->ID, '_elementor_template_type', 'wp-page');
            if (defined('ELEMENTOR_VERSION')) {
                update_post_meta($tentang->ID, '_elementor_version', ELEMENTOR_VERSION);
            }
            update_post_meta($tentang->ID, '_elementor_data', wp_slash(nh_build_default_tentang_elementor_data()));
            delete_post_meta($tentang->ID, '_elementor_css');
            update_post_meta($tentang->ID, '_nh_elementor_seed_v', 'v4');
        }
    }
}

/**
 * Register All 10 Editable Elementor Widgets (100% Flat Controls — Zero Repeater Crashes)
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

            $defaults = [
                1 => ['slug' => 'hukum',         'title' => $t['legal_title'],     'desc' => $t['legal_desc'],     'img' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80'],
                2 => ['slug' => 'perizinan',     'title' => $t['licensing_title'], 'desc' => $t['licensing_desc'], 'img' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=800&q=80'],
                3 => ['slug' => 'pelatihan-sdm', 'title' => $t['hr_title'],        'desc' => $t['hr_desc'],        'img' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80'],
            ];

            foreach ($defaults as $i => $d) {
                $this->add_control("srv_{$i}_title", [
                    'label'   => "Kartu {$i} — Judul Layanan",
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => $d['title'],
                ]);
                $this->add_control("srv_{$i}_desc", [
                    'label'   => "Kartu {$i} — Deskripsi",
                    'type'    => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => $d['desc'],
                ]);
                $this->add_control("srv_{$i}_image", [
                    'label'   => "Kartu {$i} — URL Gambar",
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => $d['img'],
                ]);
                $this->add_control("srv_{$i}_slug", [
                    'label'   => "Kartu {$i} — Slug Link",
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => $d['slug'],
                ]);
            }
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

            foreach ($t['items'] as $idx => $item) {
                $n = $idx + 1;
                $this->add_control("item_{$n}_title", [
                    'label'   => "Keunggulan {$n} — Judul",
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => $item['title'],
                ]);
                $this->add_control("item_{$n}_desc", [
                    'label'   => "Keunggulan {$n} — Deskripsi",
                    'type'    => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => $item['desc'],
                ]);
            }
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

            foreach ($t['items'] as $idx => $val) {
                $n = $idx + 1;
                $this->add_control("val_{$n}_initial", [
                    'label'   => "Nilai {$n} — Huruf Lingkaran Tengah",
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => $val['initial'],
                ]);
                $this->add_control("val_{$n}_name", [
                    'label'   => "Nilai {$n} — Nama Nilai",
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => $val['name'],
                ]);
                $this->add_control("val_{$n}_desc", [
                    'label'   => "Nilai {$n} — Deskripsi",
                    'type'    => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => $val['desc'],
                ]);
            }
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

            foreach ($t['items'] as $idx => $item) {
                $n = $idx + 1;
                $this->add_control("testi_{$n}_name", [
                    'label'   => "Testimoni {$n} — Nama Klien",
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => $item['name'],
                ]);
                $this->add_control("testi_{$n}_role", [
                    'label'   => "Testimoni {$n} — Peran/Jabatan",
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => $item['role'],
                ]);
                $this->add_control("testi_{$n}_text", [
                    'label'   => "Testimoni {$n} — Isi Testimoni",
                    'type'    => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => $item['text'],
                ]);
            }
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

            foreach ($t['items'] as $idx => $step) {
                $n = $idx + 1;
                $this->add_control("step_{$n}_num", [
                    'label'   => "Langkah {$n} — Nomor",
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => $step['step'],
                ]);
                $this->add_control("step_{$n}_title", [
                    'label'   => "Langkah {$n} — Judul",
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => $step['title'],
                ]);
                $this->add_control("step_{$n}_desc", [
                    'label'   => "Langkah {$n} — Deskripsi",
                    'type'    => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => $step['desc'],
                ]);
            }
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

            foreach ($t['items'] as $idx => $faq) {
                $n = $idx + 1;
                $this->add_control("faq_{$n}_q", [
                    'label'   => "FAQ {$n} — Pertanyaan",
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => $faq['q'],
                ]);
                $this->add_control("faq_{$n}_a", [
                    'label'   => "FAQ {$n} — Jawaban",
                    'type'    => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => $faq['a'],
                ]);
            }
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
            foreach ($t['description'] as $idx => $p_text) {
                $n = $idx + 1;
                $this->add_control("p{$n}", [
                    'label'   => "Paragraf Profil {$n}",
                    'type'    => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => $p_text,
                ]);
            }
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
