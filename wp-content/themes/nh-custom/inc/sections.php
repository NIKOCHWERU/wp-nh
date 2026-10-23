<?php
/**
 * Reusable Section Renderers (Used by Page Templates & Elementor Editable Widgets)
 * Every section accepts flat, easy-to-edit settings from Elementor controls with 100% fallback to default data.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. HERO SECTION
 */
function nh_render_section_hero($args = []) {
    $dict      = nh_get_translations()['id'];
    $t_hero    = $dict['hero'];
    $title_w   = !empty($args['title_white']) ? $args['title_white'] : get_theme_mod('nh_hero_title_white', $t_hero['title_white']);
    $title_g   = !empty($args['title_gold'])  ? $args['title_gold']  : get_theme_mod('nh_hero_title_gold', $t_hero['title_gold']);
    $subtitle  = !empty($args['subtitle'])    ? $args['subtitle']    : get_theme_mod('nh_hero_subtitle', $t_hero['subtitle']);
    $video_url = !empty($args['video_url'])   ? $args['video_url']   : get_theme_mod('nh_hero_video_url', 'https://res.cloudinary.com/dysw7tjks/video/upload/v1756377208/Desain_tanpa_judul_oeaojq.mp4');
    $btn1_text = !empty($args['btn1_text'])   ? $args['btn1_text']   : $t_hero['cta_services'];
    $btn1_url  = !empty($args['btn1_url'])    ? $args['btn1_url']    : home_url('/services');
    $btn2_text = !empty($args['btn2_text'])   ? $args['btn2_text']   : $t_hero['cta_consult'];
    $btn2_url  = !empty($args['btn2_url'])    ? $args['btn2_url']    : home_url('/kontak');
    ?>
    <section id="home" class="relative h-screen flex items-center bg-gradient-to-br from-[#0a0a0b] via-[#161618] to-[#0a0a0b] text-white overflow-hidden">
        <div class="absolute inset-0 w-full h-full overflow-hidden">
            <video class="absolute top-0 left-0 w-full h-full object-cover" autoplay loop muted playsinline>
                <source src="<?php echo esc_url($video_url); ?>" type="video/mp4" />
            </video>
            <div class="absolute inset-0 bg-black/70"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 pt-10">
            <div class="max-w-3xl nh-reveal is-visible">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-bold mb-4 md:mb-6 leading-tight tracking-tight uppercase">
                    <span data-nh-i18n="hero.title_white"><?php echo esc_html($title_w); ?></span> <br />
                    <span class="text-gold" data-nh-i18n="hero.title_gold"><?php echo esc_html($title_g); ?></span>
                </h1>
                <p class="text-base md:text-lg lg:text-xl mb-8 md:mb-10 text-gray-300 leading-relaxed border-l-4 border-gold pl-4 md:pl-6 font-light" data-nh-i18n="hero.subtitle">
                    <?php echo esc_html($subtitle); ?>
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?php echo esc_url($btn1_url); ?>" class="bg-gold text-navy px-8 py-4 rounded font-bold transition duration-300 hover:bg-white hover:text-navy uppercase text-sm tracking-widest flex items-center justify-center gap-2 group">
                        <span data-nh-i18n="hero.cta_services"><?php echo esc_html($btn1_text); ?></span>
                        <?php echo nh_icon('arrow-right', 18, 'group-hover:translate-x-1 transition-transform'); ?>
                    </a>
                    <a href="<?php echo esc_url($btn2_url); ?>" class="px-8 py-4 rounded font-bold border border-white text-white hover:bg-white hover:text-navy transition duration-300 uppercase text-sm tracking-widest flex items-center justify-center">
                        <span data-nh-i18n="hero.cta_consult"><?php echo esc_html($btn2_text); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php
}

/**
 * 2. SERVICES PREVIEW SECTION
 */
function nh_render_section_services_preview($args = []) {
    $t_srv    = nh_get_translations()['id']['services'];
    $title    = !empty($args['title'])    ? $args['title']    : $t_srv['title'];
    $subtitle = !empty($args['subtitle']) ? $args['subtitle'] : $t_srv['subtitle'];

    $defaults = [
        1 => [
            'slug'  => 'hukum',
            'icon'  => 'scale',
            'title' => $t_srv['legal_title'],
            'desc'  => $t_srv['legal_desc'],
            'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
        ],
        2 => [
            'slug'  => 'perizinan',
            'icon'  => 'file-text',
            'title' => $t_srv['licensing_title'],
            'desc'  => $t_srv['licensing_desc'],
            'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=800&q=80',
        ],
        3 => [
            'slug'  => 'pelatihan-sdm',
            'icon'  => 'shield-check',
            'title' => $t_srv['hr_title'],
            'desc'  => $t_srv['hr_desc'],
            'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80',
        ],
    ];

    $items = [];
    for ($i = 1; $i <= 3; $i++) {
        $items[] = [
            'slug'  => !empty($args["srv_{$i}_slug"])  ? $args["srv_{$i}_slug"]  : $defaults[$i]['slug'],
            'icon'  => $defaults[$i]['icon'],
            'title' => !empty($args["srv_{$i}_title"]) ? $args["srv_{$i}_title"] : $defaults[$i]['title'],
            'desc'  => !empty($args["srv_{$i}_desc"])  ? $args["srv_{$i}_desc"]  : $defaults[$i]['desc'],
            'image' => !empty($args["srv_{$i}_image"]) ? $args["srv_{$i}_image"] : $defaults[$i]['image'],
        ];
    }
    ?>
    <section id="services-preview" class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-4 text-center">
            <div class="mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-6 uppercase tracking-wider text-navy" data-nh-i18n="services.title"><?php echo esc_html($title); ?></h2>
                <div class="w-24 h-1.5 bg-gold mx-auto mb-8"></div>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg md:text-xl leading-relaxed" data-nh-i18n="services.subtitle">
                    <?php echo esc_html($subtitle); ?>
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <?php foreach ($items as $srv) : ?>
                    <a href="<?php echo esc_url(home_url('/services/' . $srv['slug'])); ?>" class="relative group overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 h-[350px] md:h-[450px] block">
                        <div class="absolute inset-0">
                            <img src="<?php echo esc_url($srv['image']); ?>" alt="<?php echo esc_attr($srv['title']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                            <div class="absolute inset-0 bg-gradient-to-t from-navy via-navy/60 to-transparent opacity-90"></div>
                        </div>

                        <div class="absolute inset-0 p-8 flex flex-col justify-end text-left">
                            <div class="mb-4 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 text-gold">
                                <?php echo nh_icon($srv['icon'], 40); ?>
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold mb-3 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-75">
                                <?php echo esc_html($srv['title']); ?>
                            </h3>
                            <p class="text-gray-300 text-sm leading-relaxed opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 delay-150">
                                <?php echo esc_html($srv['desc']); ?>
                            </p>
                            <div class="w-12 h-1 bg-gold mt-6 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <a href="<?php echo esc_url(home_url('/services')); ?>" class="inline-flex items-center gap-2 text-gold font-bold uppercase tracking-widest hover:underline text-sm">
                <span data-nh-i18n="services.view_all"><?php echo esc_html($t_srv['view_all']); ?></span> <?php echo nh_icon('arrow-right', 16); ?>
            </a>
        </div>
    </section>
    <?php
}

/**
 * 3. WHY CHOOSE US SECTION
 */
function nh_render_section_why_us($args = []) {
    $t_why    = nh_get_translations()['id']['why_us'];
    $title    = !empty($args['title'])    ? $args['title']    : $t_why['title'];
    $subtitle = !empty($args['subtitle']) ? $args['subtitle'] : $t_why['subtitle'];

    $items = [];
    foreach ($t_why['items'] as $idx => $def) {
        $n = $idx + 1;
        $items[] = [
            'title' => !empty($args["item_{$n}_title"]) ? $args["item_{$n}_title"] : $def['title'],
            'desc'  => !empty($args["item_{$n}_desc"])  ? $args["item_{$n}_desc"]  : $def['desc'],
        ];
    }
    ?>
    <section class="py-16 md:py-24 bg-navy text-white relative overflow-hidden">
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-gold/5 rounded-full blur-[150px] transform -translate-x-1/2 translate-y-1/2"></div>
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 relative z-10">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 uppercase tracking-wide" data-nh-i18n="why_us.title"><?php echo esc_html($title); ?></h2>
                <div class="w-24 h-1.5 bg-gold mx-auto"></div>
                <p class="mt-4 text-gray-400 max-w-2xl mx-auto text-lg leading-relaxed" data-nh-i18n="why_us.subtitle">
                    <?php echo esc_html($subtitle); ?>
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 relative z-10">
                <?php foreach ($items as $idx => $item) : ?>
                    <div class="bg-gray-50 p-6 md:p-8 rounded-2xl border border-gray-100 hover:border-gold/30 transition-all duration-300 hover:-translate-y-2 group nh-reveal is-visible">
                        <div class="mb-6 text-gold group-hover:scale-110 transition-transform">
                            <?php echo nh_icon('check-circle', 40); ?>
                        </div>
                        <h3 class="text-xl font-bold mb-4 uppercase tracking-wide font-sans text-navy" data-nh-i18n="why_us.items.<?php echo intval($idx); ?>.title"><?php echo esc_html($item['title']); ?></h3>
                        <p class="text-gray-600 text-sm leading-relaxed font-light" data-nh-i18n="why_us.items.<?php echo intval($idx); ?>.desc"><?php echo esc_html($item['desc']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

/**
 * 4. OUR VALUES (RICCIEP) SECTION
 */
function nh_render_section_values($args = []) {
    $t_val    = nh_get_translations()['id']['values'];
    $title    = !empty($args['title'])    ? $args['title']    : $t_val['title'];
    $subtitle = !empty($args['subtitle']) ? $args['subtitle'] : $t_val['subtitle'];

    $items = [];
    foreach ($t_val['items'] as $idx => $def) {
        $n = $idx + 1;
        $items[] = [
            'initial' => !empty($args["val_{$n}_initial"]) ? $args["val_{$n}_initial"] : $def['initial'],
            'icon'    => $def['icon'],
            'name'    => !empty($args["val_{$n}_name"])    ? $args["val_{$n}_name"]    : $def['name'],
            'desc'    => !empty($args["val_{$n}_desc"])    ? $args["val_{$n}_desc"]    : $def['desc'],
        ];
    }
    ?>
    <section class="py-16 md:py-32 relative overflow-hidden bg-navy text-white">
        <div class="absolute inset-0 bg-navy"></div>
        <div class="absolute inset-0 opacity-20 nh-animated-pattern"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-navy/50 via-transparent to-navy/80 pointer-events-none"></div>

        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-gold/10 rounded-full blur-[120px] pointer-events-none transform translate-x-1/4 -translate-y-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[800px] h-[800px] bg-gold/5 rounded-full blur-[120px] pointer-events-none transform -translate-x-1/4 translate-y-1/4"></div>

        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-[20rem] font-black text-white/[0.02] pointer-events-none font-sans tracking-tighter whitespace-nowrap z-0 select-none">
            RICCIEP
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-3xl md:text-5xl font-bold mb-6 uppercase tracking-wider text-white" data-nh-i18n="values.title"><?php echo esc_html($title); ?></h2>
                <div class="w-24 h-1.5 bg-gold mx-auto mb-8"></div>
                <p class="text-gray-300 max-w-2xl mx-auto text-lg md:text-xl leading-relaxed font-light" data-nh-i18n="values.subtitle">
                    <?php echo esc_html($subtitle); ?>
                </p>
            </div>

            <div class="max-w-7xl mx-auto py-10 relative">
                <!-- Central Trunk -->
                <div class="nh-ricciep-trunk"></div>

                <div class="flex flex-col gap-12 md:gap-20">
                    <?php foreach ($items as $idx => $val) :
                        $is_left = ($idx % 2 === 0);
                        $icon    = !empty($val['icon']) ? $val['icon'] : 'zap';
                    ?>
                        <div class="nh-ricciep-row nh-reveal is-visible <?php echo $is_left ? 'is-left' : 'is-right'; ?>">
                            <!-- Center Node Letter -->
                            <div class="nh-ricciep-node group">
                                <div class="absolute inset-0 bg-gold/20 rounded-full animate-ping opacity-30"></div>
                                <span class="text-2xl md:text-5xl font-black font-sans text-gold group-hover:text-white transition-colors"><?php echo esc_html($val['initial']); ?></span>
                            </div>

                            <!-- Content Card -->
                            <div class="nh-ricciep-card-col">
                                <div class="bg-white p-8 md:p-12 rounded-[2rem] shadow-xl border border-gray-100 hover:shadow-2xl hover:border-gold/40 transition-all duration-500 group relative overflow-hidden nh-ricciep-card-inner">
                                    <div class="flex-shrink-0 w-16 h-16 md:w-20 md:h-20 bg-navy/5 text-gold rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-inner nh-ricciep-icon">
                                        <?php echo nh_icon($icon, 36); ?>
                                    </div>

                                    <div class="flex-1 relative z-10 nh-ricciep-text">
                                        <h3 class="text-xl md:text-3xl font-bold mb-3 md:mb-4 text-navy font-sans group-hover:text-gold transition-colors" data-nh-i18n="values.items.<?php echo intval($idx); ?>.name"><?php echo esc_html($val['name']); ?></h3>
                                        <p class="text-gray-600 text-sm md:text-lg leading-relaxed font-light" data-nh-i18n="values.items.<?php echo intval($idx); ?>.desc"><?php echo esc_html($val['desc']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}

/**
 * 5. TESTIMONIALS SECTION
 */
function nh_render_section_testimonials($args = []) {
    $t_testi  = nh_get_translations()['id']['testimonials'];
    $title    = !empty($args['title'])    ? $args['title']    : $t_testi['title'];
    $subtitle = !empty($args['subtitle']) ? $args['subtitle'] : $t_testi['subtitle'];
    $saved    = get_option('nh_custom_testimonials', $t_testi['items']);
    if (!is_array($saved) || empty($saved)) {
        $saved = $t_testi['items'];
    }

    $items = [];
    foreach ($saved as $idx => $def) {
        $n = $idx + 1;
        $items[] = [
            'name' => !empty($args["testi_{$n}_name"]) ? $args["testi_{$n}_name"] : $def['name'],
            'role' => !empty($args["testi_{$n}_role"]) ? $args["testi_{$n}_role"] : $def['role'],
            'text' => !empty($args["testi_{$n}_text"]) ? $args["testi_{$n}_text"] : $def['text'],
        ];
    }
    ?>
    <section id="reviews" class="py-16 md:py-24 bg-white relative overflow-hidden">
        <div class="absolute top-1/3 left-0 w-96 h-96 bg-gold/5 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-gold/10 rounded-full blur-[120px] translate-x-1/2 translate-y-1/2"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-left mb-20 text-navy">
                <h2 class="text-2xl md:text-5xl font-bold mb-4 md:mb-6 uppercase tracking-wider" data-nh-i18n="testimonials.title"><?php echo esc_html($title); ?></h2>
                <div class="w-16 md:w-24 h-1 md:h-1.5 bg-gold mb-6 md:mb-8"></div>
                <p class="text-gray-500 max-w-2xl text-sm md:text-xl leading-relaxed" data-nh-i18n="testimonials.subtitle">
                    <?php echo esc_html($subtitle); ?>
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 lg:gap-10">
                <?php foreach ($items as $idx => $review) : ?>
                    <div class="bg-gray-50 p-6 md:p-10 rounded-[1.5rem] md:rounded-[2rem] shadow-xl border border-gray-100 flex flex-col justify-between hover:shadow-2xl hover:border-gold/30 transition-all duration-500 transform hover:-translate-y-3 group nh-reveal is-visible">
                        <div>
                            <p class="text-gray-600 italic text-base md:text-xl leading-relaxed mb-6 md:mb-10 font-sans">
                                "<span data-nh-i18n="testimonials.items.<?php echo intval($idx); ?>.text"><?php echo esc_html($review['text']); ?></span>"
                            </p>
                        </div>
                        <div class="flex items-center gap-4 md:gap-6 border-t border-gray-200 pt-6 md:pt-8">
                            <div>
                                <h4 class="font-bold text-navy text-base md:text-xl"><?php echo esc_html($review['name']); ?></h4>
                                <p class="text-[10px] md:text-sm text-gray-400 uppercase tracking-widest font-medium mt-0.5 md:mt-1" data-nh-i18n="testimonials.items.<?php echo intval($idx); ?>.role"><?php echo esc_html($review['role']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

/**
 * 6. LEGAL PROCESS SECTION
 */
function nh_render_section_process($args = []) {
    $t_proc   = nh_get_translations()['id']['process'];
    $title    = !empty($args['title'])    ? $args['title']    : $t_proc['title'];
    $subtitle = !empty($args['subtitle']) ? $args['subtitle'] : $t_proc['subtitle'];

    $items = [];
    foreach ($t_proc['items'] as $idx => $def) {
        $n = $idx + 1;
        $items[] = [
            'step'  => !empty($args["step_{$n}_num"])   ? $args["step_{$n}_num"]   : $def['step'],
            'title' => !empty($args["step_{$n}_title"]) ? $args["step_{$n}_title"] : $def['title'],
            'desc'  => !empty($args["step_{$n}_desc"])  ? $args["step_{$n}_desc"]  : $def['desc'],
        ];
    }
    ?>
    <section class="py-16 md:py-24 bg-gray-50 relative overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 relative z-10">
                <h2 class="text-3xl md:text-5xl font-bold mb-6 uppercase tracking-wider text-navy" data-nh-i18n="process.title"><?php echo esc_html($title); ?></h2>
                <div class="w-24 h-1.5 bg-gold mx-auto mb-8"></div>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg md:text-xl leading-relaxed" data-nh-i18n="process.subtitle">
                    <?php echo esc_html($subtitle); ?>
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 relative z-10">
                <?php foreach ($items as $idx => $step) : ?>
                    <div class="relative p-8 bg-white rounded-3xl shadow-lg border border-gray-100 hover:border-gold/30 transition-all duration-300 group nh-reveal is-visible">
                        <div class="text-6xl font-black text-gray-50 absolute top-4 right-8 group-hover:text-gold/10 transition-colors">
                            <?php echo esc_html($step['step']); ?>
                        </div>
                        <div class="relative z-10">
                            <h3 class="text-xl font-bold mb-4 text-navy font-sans" data-nh-i18n="process.items.<?php echo intval($idx); ?>.title"><?php echo esc_html($step['title']); ?></h3>
                            <p class="text-gray-500 text-sm leading-relaxed" data-nh-i18n="process.items.<?php echo intval($idx); ?>.desc"><?php echo esc_html($step['desc']); ?></p>
                        </div>
                        <?php if ($idx < 3) : ?>
                            <div class="hidden lg:block absolute top-1/2 -right-4 translate-x-1/2 -translate-y-1/2 z-20 text-gold/30">
                                <?php echo nh_icon('arrow-right', 32); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

/**
 * 7. FAQ SECTION
 */
function nh_render_section_faq($args = []) {
    $t_faq = nh_get_translations()['id']['faq'];
    $title = !empty($args['title']) ? $args['title'] : $t_faq['title'];
    $saved = get_option('nh_custom_faqs', $t_faq['items']);
    if (!is_array($saved) || empty($saved)) {
        $saved = $t_faq['items'];
    }

    $items = [];
    foreach ($saved as $idx => $def) {
        $n = $idx + 1;
        $items[] = [
            'q' => !empty($args["faq_{$n}_q"]) ? $args["faq_{$n}_q"] : $def['q'],
            'a' => !empty($args["faq_{$n}_a"]) ? $args["faq_{$n}_a"] : $def['a'],
        ];
    }
    ?>
    <section class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-4 text-center">
            <div class="mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 uppercase tracking-wide text-navy" data-nh-i18n="faq.title"><?php echo esc_html($title); ?></h2>
                <div class="w-24 h-1.5 bg-gold mx-auto"></div>
            </div>

            <div class="max-w-3xl mx-auto text-left">
                <?php foreach ($items as $idx => $faq) : ?>
                    <div class="nh-faq-item border-b border-gray-200 mb-4">
                        <button type="button" class="nh-faq-btn flex justify-between items-center w-full py-4 text-left focus:outline-none group cursor-pointer">
                            <span class="nh-faq-title font-bold text-lg text-navy group-hover:text-gold transition" data-nh-i18n="faq.items.<?php echo intval($idx); ?>.q"><?php echo esc_html($faq['q']); ?></span>
                            <span class="nh-faq-down text-gray-400 group-hover:text-gold"><?php echo nh_icon('chevron-down', 22); ?></span>
                            <span class="nh-faq-up hidden text-gold"><?php echo nh_icon('chevron-up', 22); ?></span>
                        </button>
                        <div class="nh-faq-body hidden overflow-hidden">
                            <p class="pb-6 text-gray-600 leading-relaxed" data-nh-i18n="faq.items.<?php echo intval($idx); ?>.a">
                                <?php echo esc_html($faq['a']); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

/**
 * 8. CTA QUOTE BANNER SECTION
 */
function nh_render_section_cta_banner($args = []) {
    $t_cta      = nh_get_translations()['id']['cta_contact'];
    $quote      = !empty($args['title_quote']) ? $args['title_quote'] : $t_cta['title_quote'];
    $gold       = !empty($args['title_gold'])  ? $args['title_gold']  : $t_cta['title_gold'];
    $btn_text   = !empty($args['btn_text'])    ? $args['btn_text']    : $t_cta['free_consult'];
    $wa_primary = !empty($args['wa_number'])   ? $args['wa_number']   : get_theme_mod('nh_wa_primary', '6282211020022');
    ?>
    <section class="py-20 bg-navy text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-gold/10"></div>
        <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="container mx-auto px-4 relative z-10 text-center nh-reveal is-visible">
            <h2 class="text-2xl md:text-5xl font-bold mb-8 uppercase tracking-widest leading-tight font-sans">
                "<span data-nh-i18n="cta_contact.title_quote"><?php echo esc_html($quote); ?></span> <br />
                <span class="text-gold" data-nh-i18n="cta_contact.title_gold"><?php echo esc_html($gold); ?></span>"
            </h2>
            <a href="<?php echo esc_url('https://wa.me/' . $wa_primary); ?>"
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center gap-3 bg-gold text-navy px-10 py-5 rounded-full font-bold uppercase tracking-widest text-sm hover:bg-white hover:text-navy transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                <span class="flex items-center justify-center w-6 h-6 bg-navy text-gold rounded-full">
                    <?php echo nh_icon('phone', 14); ?>
                </span>
                <span data-nh-i18n="cta_contact.free_consult"><?php echo esc_html($btn_text); ?></span>
            </a>
        </div>
    </section>
    <?php
}

/**
 * 9. CONTACT SECTION
 */
function nh_render_section_contact($args = []) {
    $dict       = nh_get_translations()['id'];
    $t_contact  = $dict['contact_page'];
    $t_foot     = $dict['footer'];
    $title      = !empty($args['title'])       ? $args['title']       : $t_contact['title'];
    $desc       = !empty($args['description']) ? $args['description'] : $t_contact['description'];
    $wa_primary = !empty($args['wa_number'])   ? $args['wa_number']   : get_theme_mod('nh_wa_primary', '6282211020022');
    $phone_disp = !empty($args['phone_text'])  ? $args['phone_text']  : '+62-822-1102-0022';
    $addr_disp  = !empty($args['address'])     ? $args['address']     : 'Jakarta Pusat, Indonesia';
    $email_off  = !empty($args['email'])       ? $args['email']       : get_theme_mod('nh_email_official', 'hello@narasumberhukum.com');
    $maps_url   = !empty($args['maps_url'])    ? $args['maps_url']    : get_theme_mod('nh_maps_url', 'https://maps.app.goo.gl/Z77ydQisZAQ6d1aQ9');
    ?>
    <section id="contact" class="py-16 md:py-24 bg-gray-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gold/5 rounded-full blur-[150px] translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-gold/5 rounded-full blur-[150px] -translate-x-1/2 translate-y-1/2"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 uppercase tracking-wide text-navy" data-nh-i18n="contact_page.title"><?php echo esc_html($title); ?></h2>
                <div class="w-24 h-1.5 bg-gold mx-auto mb-8"></div>
                <p class="mt-4 text-gray-500 max-w-2xl mx-auto text-lg leading-relaxed font-light italic" data-nh-i18n="contact_page.description">
                    <?php echo esc_html($desc); ?>
                </p>
                <div class="mt-8">
                    <a href="<?php echo esc_url(home_url('/tentang')); ?>" class="text-navy font-bold hover:text-gold transition-colors underline decoration-gold underline-offset-4" data-nh-i18n="contact_page.profile_link">
                        <?php echo esc_html($t_contact['profile_link']); ?>
                    </a>
                </div>
            </div>

            <div class="max-w-5xl mx-auto">
                <div class="grid md:grid-cols-3 gap-8 mb-16">
                    <a href="<?php echo esc_url('https://wa.me/' . $wa_primary . '?text=' . rawurlencode('Halo Kantor Narasumber Hukum, saya ingin berkonsultasi mengenai layanan Anda.')); ?>"
                       target="_blank" rel="noopener noreferrer"
                       class="bg-white p-6 md:p-8 rounded-3xl shadow-xl border border-gray-100 flex flex-col items-center justify-center text-center group hover:border-gold/30 transition-all duration-500 cursor-pointer nh-reveal is-visible">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-navy text-gold rounded-2xl flex items-center justify-center mb-5 md:mb-6 group-hover:bg-gold group-hover:text-navy transition-all duration-500 shadow-lg">
                            <?php echo nh_icon('phone', 24); ?>
                        </div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-2" data-nh-i18n="footer.contact_title"><?php echo esc_html($t_foot['contact_title']); ?></p>
                        <p class="font-bold text-navy text-[11px] sm:text-xs md:text-sm"><?php echo esc_html($phone_disp); ?></p>
                    </a>

                    <a href="<?php echo esc_url($maps_url); ?>"
                       target="_blank" rel="noopener noreferrer"
                       class="bg-white p-6 md:p-8 rounded-3xl shadow-xl border border-gray-100 flex flex-col items-center justify-center text-center group hover:border-gold/30 transition-all duration-500 cursor-pointer nh-reveal is-visible">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-navy text-gold rounded-2xl flex items-center justify-center mb-5 md:mb-6 group-hover:bg-gold group-hover:text-navy transition-all duration-500 shadow-lg">
                            <?php echo nh_icon('map-pin', 24); ?>
                        </div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-2" data-nh-i18n="footer.office_title"><?php echo esc_html($t_foot['office_title']); ?></p>
                        <p class="font-bold text-navy text-[11px] sm:text-xs md:text-sm"><?php echo esc_html($addr_disp); ?></p>
                    </a>

                    <a href="<?php echo esc_url('mailto:' . $email_off); ?>"
                       class="bg-white p-6 md:p-8 rounded-3xl shadow-xl border border-gray-100 flex flex-col items-center justify-center text-center group hover:border-gold/30 transition-all duration-500 cursor-pointer nh-reveal is-visible">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-navy text-gold rounded-2xl flex items-center justify-center mb-5 md:mb-6 group-hover:bg-gold group-hover:text-navy transition-all duration-500 shadow-lg">
                            <?php echo nh_icon('mail', 24); ?>
                        </div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-2" data-nh-i18n="contact_page.email_label"><?php echo esc_html($t_contact['email_label']); ?></p>
                        <p class="font-bold text-navy text-[11px] sm:text-xs md:text-sm"><?php echo esc_html($email_off); ?></p>
                    </a>
                </div>

                <div class="max-w-3xl mx-auto nh-reveal is-visible">
                    <?php nh_render_contact_form_component(); ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}

/**
 * 10. ABOUT US FULL PAGE SECTION
 */
function nh_render_section_about_page($args = []) {
    $dict    = nh_get_translations()['id'];
    $t_about = $dict['about_page'];
    $t_part  = $dict['partners'];

    $title      = !empty($args['title'])      ? $args['title']      : $t_about['title'];
    $title_gold = !empty($args['title_gold']) ? $args['title_gold'] : $t_about['title_gold'];
    $tagline    = !empty($args['tagline'])    ? $args['tagline']    : $t_about['tagline'];
    $vision_t   = !empty($args['vision_t'])   ? $args['vision_t']   : $t_about['vision']['title'];
    $vision_d   = !empty($args['vision_d'])   ? $args['vision_d']   : $t_about['vision']['desc'];

    $paragraphs = [];
    foreach ($t_about['description'] as $idx => $def_p) {
        $n = $idx + 1;
        $paragraphs[] = !empty($args["p{$n}"]) ? $args["p{$n}"] : $def_p;
    }
    $missions = $t_about['mission']['items'];
    ?>
    <div class="pt-20">
        <!-- HERO -->
        <section class="relative py-20 md:py-32 overflow-hidden bg-navy">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=1920&q=80" alt="Legal Background" class="w-full h-full object-cover opacity-20" />
                <div class="absolute inset-0 bg-gradient-to-br from-navy via-navy/95 to-navy/90"></div>
            </div>
            <div class="container mx-auto px-4 relative z-10 text-center">
                <h1 class="text-3xl md:text-4xl font-bold mb-6 uppercase tracking-wide text-white">
                    <span data-nh-i18n="about_page.title"><?php echo esc_html($title); ?></span>
                    <span class="text-gold" data-nh-i18n="about_page.title_gold"><?php echo esc_html($title_gold); ?></span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto leading-relaxed italic font-sans">
                    "<span data-nh-i18n="about_page.tagline"><?php echo esc_html($tagline); ?></span>"
                </p>
                <div class="mt-12">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gold/10 backdrop-blur-md rounded-2xl border border-gold/20 text-gold">
                        <?php echo nh_icon('scale', 40); ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- PROFILE -->
        <section class="relative py-16 md:py-24 overflow-hidden bg-white">
            <div class="container mx-auto px-4 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-6xl lg:text-7xl font-black mb-6 uppercase tracking-wider text-navy">NARASUMBER HUKUM</h2>
                    <div class="w-32 h-1.5 bg-gold mx-auto"></div>
                </div>
                <div class="max-w-4xl mx-auto prose prose-lg">
                    <?php foreach ($paragraphs as $idx => $txt) : ?>
                        <p class="text-gray-600 leading-relaxed mb-6" data-nh-i18n="about_page.description.<?php echo intval($idx); ?>"><?php echo esc_html($txt); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- VISION -->
        <section class="relative py-16 md:py-24 overflow-hidden bg-navy text-white">
            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6 uppercase tracking-wide" data-nh-i18n="about_page.vision.title"><?php echo esc_html($vision_t); ?></h2>
                    <div class="w-24 h-1 bg-gold mx-auto mb-8"></div>
                    <p class="text-xl md:text-2xl leading-relaxed text-gray-200 font-sans italic" data-nh-i18n="about_page.vision.desc">"<?php echo esc_html($vision_d); ?>"</p>
                </div>
            </div>
        </section>

        <!-- MISSION -->
        <section class="py-16 md:py-24 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4 uppercase tracking-wide text-navy" data-nh-i18n="about_page.mission.title"><?php echo esc_html($t_about['mission']['title']); ?></h2>
                    <div class="w-24 h-1 bg-gold mx-auto"></div>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    <?php foreach ($missions as $idx => $m) :
                        $ic = !empty($m['icon']) ? $m['icon'] : 'scale';
                    ?>
                        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:border-gold/30 transition-all duration-300 hover:-translate-y-2 group">
                            <div class="w-16 h-16 bg-navy/5 rounded-xl flex items-center justify-center text-gold mb-6 group-hover:bg-navy group-hover:text-gold transition-all duration-500">
                                <?php echo nh_icon($ic, 32); ?>
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-navy font-sans" data-nh-i18n="about_page.mission.items.<?php echo intval($idx); ?>.title"><?php echo esc_html($m['title']); ?></h3>
                            <p class="text-gray-600 text-sm leading-relaxed" data-nh-i18n="about_page.mission.items.<?php echo intval($idx); ?>.desc"><?php echo esc_html($m['desc']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- LEGAL SCOPE -->
        <section class="relative py-16 md:py-24 overflow-hidden bg-gradient-to-br from-white to-gray-50">
            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-5xl mx-auto">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4 uppercase tracking-wide text-navy" data-nh-i18n="about_page.legal_scope.title"><?php echo esc_html($t_about['legal_scope']['title']); ?></h2>
                        <div class="w-24 h-1 bg-gold mx-auto mb-6"></div>
                        <p class="text-gray-600 leading-relaxed max-w-3xl mx-auto" data-nh-i18n="about_page.legal_scope.subtitle"><?php echo esc_html($t_about['legal_scope']['subtitle']); ?></p>
                    </div>
                    <div class="bg-gradient-to-br from-navy/5 to-gold/5 p-8 md:p-12 rounded-3xl border border-gray-200">
                        <div class="grid md:grid-cols-2 gap-x-8 gap-y-3">
                            <?php foreach ($t_about['legal_scope']['items'] as $idx => $scope) : ?>
                                <div class="flex items-start gap-3">
                                    <span class="text-gold flex-shrink-0 mt-1"><?php echo nh_icon('check-circle', 18); ?></span>
                                    <span class="text-gray-700 text-sm leading-relaxed" data-nh-i18n="about_page.legal_scope.items.<?php echo intval($idx); ?>"><?php echo esc_html($scope); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- PARTNERS -->
        <section class="relative py-16 md:py-24 overflow-hidden bg-navy">
            <div class="container mx-auto px-4 relative z-10">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4 uppercase tracking-wide text-white" data-nh-i18n="partners.title"><?php echo esc_html($t_part['title']); ?></h2>
                    <div class="w-24 h-1 bg-gold mx-auto"></div>
                </div>
                <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    <div class="bg-white/10 backdrop-blur-md p-6 md:p-8 rounded-2xl border border-white/20 hover:border-gold/50 transition-all duration-300">
                        <div class="bg-white rounded-xl p-4 mb-6 flex items-center justify-center min-h-[100px] w-full">
                            <img src="<?php echo esc_url(NH_THEME_URI . '/assets/images/logo-narasumber-hukum.png'); ?>" alt="Narasumber Hukum" class="w-full h-auto object-contain" />
                        </div>
                        <h3 class="text-lg font-bold text-center text-white font-sans"><?php echo esc_html($t_part['narasumber']); ?></h3>
                        <p class="text-gray-300 text-[10px] text-center mt-2 uppercase tracking-widest font-medium">Advocate, Intercessor & Legal Consultant</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md p-6 md:p-8 rounded-2xl border border-white/20 hover:border-gold/50 transition-all duration-300 flex flex-col items-center">
                        <div class="bg-white rounded-xl p-4 mb-6 flex items-center justify-center min-h-[100px] w-full">
                            <img src="<?php echo esc_url(NH_THEME_URI . '/assets/images/logo-seleco.png'); ?>" alt="Sleco" class="w-full h-auto max-h-[80px] object-contain" />
                        </div>
                        <h3 class="text-lg font-bold text-center text-white font-sans"><?php echo esc_html($t_part['sleco']); ?></h3>
                        <p class="text-gray-300 text-[10px] text-center mt-2 uppercase tracking-widest font-medium">Sustainable Solutions & Project Management</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md p-6 md:p-8 rounded-2xl border border-white/20 hover:border-gold/50 transition-all duration-300 flex flex-col items-center">
                        <div class="bg-white rounded-xl p-4 mb-6 flex items-center justify-center min-h-[100px] w-full">
                            <img src="<?php echo esc_url(NH_THEME_URI . '/assets/images/logo-mti-talenstory.jpg'); ?>" alt="MTI" class="w-full h-auto max-h-16 object-contain" />
                        </div>
                        <h3 class="text-lg font-bold text-center text-white font-sans"><?php echo esc_html($t_part['mti']); ?></h3>
                        <p class="text-gray-300 text-[10px] text-center mt-2 uppercase tracking-widest font-medium"><?php echo esc_html($t_part['mti_sub']); ?></p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php
}
