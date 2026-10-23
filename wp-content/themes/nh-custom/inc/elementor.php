<?php
/**
 * Elementor (Free Version) Compatibility & Custom Widgets + Shortcodes
 * Allows non-technical users to drag-and-drop Narasumber Hukum sections in Elementor Free
 */

if (!defined('ABSPATH')) {
    exit;
}

// 1. Register Shortcodes so any section can also be dropped into Elementor Shortcode Widget or Gutenberg
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

// 2. Register Native Elementor Category & Widgets when Elementor (Free) is active
add_action('elementor/elements/categories_registered', 'nh_add_elementor_widget_categories');
function nh_add_elementor_widget_categories($elements_manager) {
    $elements_manager->add_category(
        'narasumber-hukum',
        [
            'title' => 'Narasumber Hukum (NH Custom)',
            'icon'  => 'fa fa-balance-scale',
        ]
    );
}

add_action('elementor/widgets/register', 'nh_register_elementor_widgets');
function nh_register_elementor_widgets($widgets_manager) {
    if (!class_exists('\Elementor\Widget_Base')) {
        return;
    }

    // Widget 1: NH Hero Banner
    class NH_Elementor_Hero_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'nh_hero_widget'; }
        public function get_title() { return 'NH — Hero Video Banner'; }
        public function get_icon() { return 'eicon-slider-video'; }
        public function get_categories() { return ['narasumber-hukum']; }

        protected function register_controls() {
            $this->start_controls_section('content_section', [
                'label' => 'Konten Hero',
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]);
            $this->add_control('title_white', [
                'label'   => 'Judul Baris 1 (Putih)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('nh_hero_title_white', 'Sentral Edukasi'),
            ]);
            $this->add_control('title_gold', [
                'label'   => 'Judul Baris 2 (Emas)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('nh_hero_title_gold', 'Dan Solusi Hukum'),
            ]);
            $this->add_control('subtitle', [
                'label'   => 'Subjudul',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => get_theme_mod('nh_hero_subtitle', 'Kami memberikan pendampingan hukum yang profesional dengan pendekatan edukatif untuk solusi yang berkeadilan dan berkelanjutan.'),
            ]);
            $this->add_control('video_url', [
                'label'   => 'URL Video Background (MP4)',
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('nh_hero_video_url', 'https://res.cloudinary.com/dysw7tjks/video/upload/v1756377208/Desain_tanpa_judul_oeaojq.mp4'),
            ]);
            $this->end_controls_section();
        }

        protected function render() {
            $s = $this->get_settings_for_display();
            ?>
            <section class="relative h-screen flex items-center bg-gradient-to-br from-[#0a0a0b] via-[#161618] to-[#0a0a0b] text-white overflow-hidden">
                <div class="absolute inset-0 w-full h-full overflow-hidden">
                    <video class="absolute top-0 left-0 w-full h-full object-cover" autoplay loop muted playsinline>
                        <source src="<?php echo esc_url($s['video_url']); ?>" type="video/mp4" />
                    </video>
                    <div class="absolute inset-0 bg-black/70"></div>
                </div>
                <div class="container mx-auto px-4 relative z-10 pt-10">
                    <div class="max-w-3xl">
                        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-bold mb-4 md:mb-6 leading-tight tracking-tight uppercase">
                            <span><?php echo esc_html($s['title_white']); ?></span> <br />
                            <span class="text-gold"><?php echo esc_html($s['title_gold']); ?></span>
                        </h1>
                        <p class="text-base md:text-lg lg:text-xl mb-8 md:mb-10 text-gray-300 leading-relaxed border-l-4 border-gold pl-4 md:pl-6 font-light">
                            <?php echo esc_html($s['subtitle']); ?>
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="<?php echo esc_url(home_url('/services')); ?>" class="bg-gold text-navy px-8 py-4 rounded font-bold transition duration-300 hover:bg-white hover:text-navy uppercase text-sm tracking-widest flex items-center justify-center gap-2 group">
                                <span data-nh-i18n="hero.cta_services">Layanan Kami</span>
                                <?php echo nh_icon('arrow-right', 18, 'group-hover:translate-x-1 transition-transform'); ?>
                            </a>
                            <a href="<?php echo esc_url(home_url('/kontak')); ?>" class="px-8 py-4 rounded font-bold border border-white text-white hover:bg-white hover:text-navy transition duration-300 uppercase text-sm tracking-widest flex items-center justify-center">
                                <span data-nh-i18n="hero.cta_consult">Konsultasi Sekarang</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }
    }

    // Widget 2: NH Contact Form
    class NH_Elementor_Contact_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'nh_contact_widget'; }
        public function get_title() { return 'NH — Formulir Konsultasi Hukum'; }
        public function get_icon() { return 'eicon-form-horizontal'; }
        public function get_categories() { return ['narasumber-hukum']; }
        protected function render() {
            nh_render_contact_form_component();
        }
    }

    // Widget 3: NH Consultation CTA
    class NH_Elementor_CTA_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'nh_cta_widget'; }
        public function get_title() { return 'NH — Banner CTA Konsultasi WhatsApp'; }
        public function get_icon() { return 'eicon-call-to-action'; }
        public function get_categories() { return ['narasumber-hukum']; }
        protected function render() {
            nh_render_consultation_cta_component();
        }
    }

    $widgets_manager->register(new NH_Elementor_Hero_Widget());
    $widgets_manager->register(new NH_Elementor_Contact_Widget());
    $widgets_manager->register(new NH_Elementor_CTA_Widget());
}
