<?php
/**
 * Front Page Template (Homepage)
 * Migrated 1:1 from app/HomeClient.tsx
 * Also supports Elementor Free override if user adds Elementor content to the Beranda page
 */
get_header();

$dict       = nh_get_translations()['id'];
$t_hero     = $dict['hero'];
$t_srv      = $dict['services'];
$t_why      = $dict['why_us'];
$t_val      = $dict['values'];
$t_testi    = $dict['testimonials'];
$t_proc     = $dict['process'];
$t_faq      = $dict['faq'];
$t_cta      = $dict['cta_contact'];
$t_contact  = $dict['contact_page'];
$t_foot     = $dict['footer'];

$video_url  = get_theme_mod('nh_hero_video_url', 'https://res.cloudinary.com/dysw7tjks/video/upload/v1756377208/Desain_tanpa_judul_oeaojq.mp4');
$hero_w     = get_theme_mod('nh_hero_title_white', $t_hero['title_white']);
$hero_g     = get_theme_mod('nh_hero_title_gold', $t_hero['title_gold']);
$hero_sub   = get_theme_mod('nh_hero_subtitle', $t_hero['subtitle']);

$wa_primary = get_theme_mod('nh_wa_primary', '6282211020022');
$email_off  = get_theme_mod('nh_email_official', 'hello@narasumberhukum.com');
$maps_url   = get_theme_mod('nh_maps_url', 'https://maps.app.goo.gl/Z77ydQisZAQ6d1aQ9');

$custom_faqs   = get_option('nh_custom_faqs', $t_faq['items']);
$custom_testis = get_option('nh_custom_testimonials', $t_testi['items']);
?>

<div>
    <!-- 1. HERO SECTION -->
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
                    <span data-nh-i18n="hero.title_white"><?php echo esc_html($hero_w); ?></span> <br />
                    <span class="text-gold" data-nh-i18n="hero.title_gold"><?php echo esc_html($hero_g); ?></span>
                </h1>
                <p class="text-base md:text-lg lg:text-xl mb-8 md:mb-10 text-gray-300 leading-relaxed border-l-4 border-gold pl-4 md:pl-6 font-light" data-nh-i18n="hero.subtitle">
                    <?php echo esc_html($hero_sub); ?>
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?php echo esc_url(home_url('/services')); ?>" class="bg-gold text-navy px-8 py-4 rounded font-bold transition duration-300 hover:bg-white hover:text-navy uppercase text-sm tracking-widest flex items-center justify-center gap-2 group">
                        <span data-nh-i18n="hero.cta_services"><?php echo esc_html($t_hero['cta_services']); ?></span>
                        <?php echo nh_icon('arrow-right', 18, 'group-hover:translate-x-1 transition-transform'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/kontak')); ?>" class="px-8 py-4 rounded font-bold border border-white text-white hover:bg-white hover:text-navy transition duration-300 uppercase text-sm tracking-widest flex items-center justify-center">
                        <span data-nh-i18n="hero.cta_consult"><?php echo esc_html($t_hero['cta_consult']); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. SERVICES PREVIEW SECTION -->
    <section id="services-preview" class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-4 text-center">
            <div class="mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-6 uppercase tracking-wider text-navy" data-nh-i18n="services.title"><?php echo esc_html($t_srv['title']); ?></h2>
                <div class="w-24 h-1.5 bg-gold mx-auto mb-8"></div>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg md:text-xl leading-relaxed" data-nh-i18n="services.subtitle">
                    <?php echo esc_html($t_srv['subtitle']); ?>
                </p>
            </div>

            <?php
            $preview_services = [
                [
                    'slug'  => 'hukum',
                    'icon'  => 'scale',
                    't_key' => 'services.legal_title',
                    'd_key' => 'services.legal_desc',
                    'title' => $t_srv['legal_title'],
                    'desc'  => $t_srv['legal_desc'],
                    'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
                ],
                [
                    'slug'  => 'perizinan',
                    'icon'  => 'file-text',
                    't_key' => 'services.licensing_title',
                    'd_key' => 'services.licensing_desc',
                    'title' => $t_srv['licensing_title'],
                    'desc'  => $t_srv['licensing_desc'],
                    'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=800&q=80',
                ],
                [
                    'slug'  => 'pelatihan-sdm',
                    'icon'  => 'shield-check',
                    't_key' => 'services.hr_title',
                    'd_key' => 'services.hr_desc',
                    'title' => $t_srv['hr_title'],
                    'desc'  => $t_srv['hr_desc'],
                    'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80',
                ],
            ];
            ?>
            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <?php foreach ($preview_services as $srv) : ?>
                    <a href="<?php echo esc_url(home_url('/services/' . $srv['slug'])); ?>" class="relative group overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 h-[350px] md:h-[450px] block">
                        <div class="absolute inset-0">
                            <img src="<?php echo esc_url($srv['image']); ?>" alt="<?php echo esc_attr($srv['title']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                            <div class="absolute inset-0 bg-gradient-to-t from-navy via-navy/60 to-transparent opacity-90"></div>
                        </div>

                        <div class="absolute inset-0 p-8 flex flex-col justify-end text-left">
                            <div class="mb-4 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 text-gold">
                                <?php echo nh_icon($srv['icon'], 40); ?>
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold mb-3 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-75" data-nh-i18n="<?php echo esc_attr($srv['t_key']); ?>">
                                <?php echo esc_html($srv['title']); ?>
                            </h3>
                            <p class="text-gray-300 text-sm leading-relaxed opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 delay-150" data-nh-i18n="<?php echo esc_attr($srv['d_key']); ?>">
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

    <!-- 3. WHY CHOOSE US SECTION -->
    <section class="py-16 md:py-24 bg-navy text-white relative overflow-hidden">
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-gold/5 rounded-full blur-[150px] transform -translate-x-1/2 translate-y-1/2"></div>
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 relative z-10">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 uppercase tracking-wide" data-nh-i18n="why_us.title"><?php echo esc_html($t_why['title']); ?></h2>
                <div class="w-24 h-1.5 bg-gold mx-auto"></div>
                <p class="mt-4 text-gray-400 max-w-2xl mx-auto text-lg leading-relaxed" data-nh-i18n="why_us.subtitle">
                    <?php echo esc_html($t_why['subtitle']); ?>
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 relative z-10">
                <?php foreach ($t_why['items'] as $idx => $item) : ?>
                    <div class="bg-gray-50 p-6 md:p-8 rounded-2xl border border-gray-100 hover:border-gold/30 transition-all duration-300 hover:-translate-y-2 group nh-reveal">
                        <div class="mb-6 text-gold group-hover:scale-110 transition-transform">
                            <?php echo nh_icon('check-circle', 40); ?>
                        </div>
                        <h3 class="text-xl font-bold mb-4 uppercase tracking-wide font-sans text-navy" data-nh-i18n="why_us.items.<?php echo $idx; ?>.title"><?php echo esc_html($item['title']); ?></h3>
                        <p class="text-gray-600 text-sm leading-relaxed font-light" data-nh-i18n="why_us.items.<?php echo $idx; ?>.desc"><?php echo esc_html($item['desc']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- 4. OUR VALUES SECTION (RICCIEP) -->
    <section class="py-16 md:py-32 relative overflow-hidden bg-navy text-white">
        <div class="absolute inset-0 bg-navy"></div>
        <div class="absolute inset-0 opacity-20 nh-animated-pattern"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-navy/50 via-transparent to-navy/80 pointer-events-none"></div>

        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-gold/10 rounded-full blur-[120px] pointer-events-none transform translate-x-1/4 -translate-y-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[800px] h-[800px] bg-gold/5 rounded-full blur-[120px] pointer-events-none transform -translate-x-1/4 translate-y-1/4"></div>

        <!-- Watermark RICCIEP -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-[20rem] font-black text-white/[0.02] pointer-events-none font-sans tracking-tighter whitespace-nowrap z-0 select-none">
            RICCIEP
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-3xl md:text-5xl font-bold mb-6 uppercase tracking-wider text-white" data-nh-i18n="values.title"><?php echo esc_html($t_val['title']); ?></h2>
                <div class="w-24 h-1.5 bg-gold mx-auto mb-8"></div>
                <p class="text-gray-300 max-w-2xl mx-auto text-lg md:text-xl leading-relaxed font-light" data-nh-i18n="values.subtitle">
                    <?php echo esc_html($t_val['subtitle']); ?>
                </p>
            </div>

            <div class="max-w-7xl mx-auto py-10 relative">
                <!-- Central Trunk -->
                <div class="absolute left-12 md:left-1/2 top-0 bottom-0 w-1.5 bg-gradient-to-b from-gold/10 via-gold/50 to-gold/10 transform md:-translate-x-1/2 rounded-full"></div>

                <div class="flex flex-col gap-12 md:gap-20">
                    <?php foreach ($t_val['items'] as $idx => $val) :
                        $is_left = ($idx % 2 === 0);
                    ?>
                        <div class="relative flex items-center w-full nh-reveal <?php echo $is_left ? 'md:flex-row-reverse' : 'md:flex-row'; ?>">
                            <div class="hidden md:block w-1/2"></div>

                            <!-- Center Node Letter -->
                            <div class="absolute left-12 md:left-1/2 transform -translate-x-1/2 flex items-center justify-center w-16 h-16 md:w-28 md:h-28 bg-navy border-[6px] border-white ring-4 ring-gold/30 text-white rounded-full z-10 shadow-2xl group hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gold/20 rounded-full animate-ping opacity-30"></div>
                                <span class="text-2xl md:text-5xl font-black font-sans text-gold group-hover:text-white transition-colors"><?php echo esc_html($val['initial']); ?></span>
                            </div>

                            <!-- Content Card -->
                            <div class="w-full pl-28 md:pl-0 md:w-1/2 <?php echo $is_left ? 'md:pr-24 text-left md:text-right' : 'md:pl-24 text-left'; ?>">
                                <div class="bg-white p-8 md:p-12 rounded-[2rem] shadow-xl border border-gray-100 hover:shadow-2xl hover:border-gold/40 transition-all duration-500 group relative overflow-hidden flex flex-col md:flex-row items-center gap-6 md:gap-8">
                                    <div class="absolute top-0 w-32 h-32 bg-gold/5 rounded-full blur-2xl <?php echo $is_left ? 'right-0' : 'left-0'; ?>"></div>

                                    <div class="flex-shrink-0 w-16 h-16 md:w-20 md:h-20 bg-navy/5 text-gold rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-inner <?php echo $is_left ? 'md:order-2' : ''; ?>">
                                        <?php echo nh_icon($val['icon'], 36); ?>
                                    </div>

                                    <div class="flex-1 relative z-10 <?php echo $is_left ? 'md:order-1' : ''; ?>">
                                        <h3 class="text-xl md:text-3xl font-bold mb-3 md:mb-4 text-navy font-sans group-hover:text-gold transition-colors" data-nh-i18n="values.items.<?php echo $idx; ?>.name"><?php echo esc_html($val['name']); ?></h3>
                                        <p class="text-gray-600 text-sm md:text-lg leading-relaxed font-light" data-nh-i18n="values.items.<?php echo $idx; ?>.desc"><?php echo esc_html($val['desc']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. TESTIMONIALS SECTION -->
    <section id="reviews" class="py-16 md:py-24 bg-white relative overflow-hidden">
        <div class="absolute top-1/3 left-0 w-96 h-96 bg-gold/5 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-gold/10 rounded-full blur-[120px] translate-x-1/2 translate-y-1/2"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-left mb-20 text-navy">
                <h2 class="text-2xl md:text-5xl font-bold mb-4 md:mb-6 uppercase tracking-wider" data-nh-i18n="testimonials.title"><?php echo esc_html($t_testi['title']); ?></h2>
                <div class="w-16 md:w-24 h-1 md:h-1.5 bg-gold mb-6 md:mb-8"></div>
                <p class="text-gray-500 max-w-2xl text-sm md:text-xl leading-relaxed" data-nh-i18n="testimonials.subtitle">
                    <?php echo esc_html($t_testi['subtitle']); ?>
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 lg:gap-10">
                <?php foreach ($custom_testis as $idx => $review) : ?>
                    <div class="bg-gray-50 p-6 md:p-10 rounded-[1.5rem] md:rounded-[2rem] shadow-xl border border-gray-100 flex flex-col justify-between hover:shadow-2xl hover:border-gold/30 transition-all duration-500 transform hover:-translate-y-3 group nh-reveal">
                        <div>
                            <p class="text-gray-600 italic text-base md:text-xl leading-relaxed mb-6 md:mb-10 font-sans">
                                "<span data-nh-i18n="testimonials.items.<?php echo $idx; ?>.text"><?php echo esc_html($review['text']); ?></span>"
                            </p>
                        </div>
                        <div class="flex items-center gap-4 md:gap-6 border-t border-gray-200 pt-6 md:pt-8">
                            <div>
                                <h4 class="font-bold text-navy text-base md:text-xl"><?php echo esc_html($review['name']); ?></h4>
                                <p class="text-[10px] md:text-sm text-gray-400 uppercase tracking-widest font-medium mt-0.5 md:mt-1" data-nh-i18n="testimonials.items.<?php echo $idx; ?>.role"><?php echo esc_html($review['role']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- 6. LEGAL PROCESS SECTION -->
    <section class="py-16 md:py-24 bg-gray-50 relative overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 relative z-10">
                <h2 class="text-3xl md:text-5xl font-bold mb-6 uppercase tracking-wider text-navy" data-nh-i18n="process.title"><?php echo esc_html($t_proc['title']); ?></h2>
                <div class="w-24 h-1.5 bg-gold mx-auto mb-8"></div>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg md:text-xl leading-relaxed" data-nh-i18n="process.subtitle">
                    <?php echo esc_html($t_proc['subtitle']); ?>
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 relative z-10">
                <?php foreach ($t_proc['items'] as $idx => $step) : ?>
                    <div class="relative p-8 bg-white rounded-3xl shadow-lg border border-gray-100 hover:border-gold/30 transition-all duration-300 group nh-reveal">
                        <div class="text-6xl font-black text-gray-50 absolute top-4 right-8 group-hover:text-gold/10 transition-colors">
                            <?php echo esc_html($step['step']); ?>
                        </div>
                        <div class="relative z-10">
                            <h3 class="text-xl font-bold mb-4 text-navy font-sans" data-nh-i18n="process.items.<?php echo $idx; ?>.title"><?php echo esc_html($step['title']); ?></h3>
                            <p class="text-gray-500 text-sm leading-relaxed" data-nh-i18n="process.items.<?php echo $idx; ?>.desc"><?php echo esc_html($step['desc']); ?></p>
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

    <!-- 7. FAQ SECTION -->
    <section class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-4 text-center">
            <div class="mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 uppercase tracking-wide text-navy" data-nh-i18n="faq.title"><?php echo esc_html($t_faq['title']); ?></h2>
                <div class="w-24 h-1.5 bg-gold mx-auto"></div>
            </div>

            <div class="max-w-3xl mx-auto text-left">
                <?php foreach ($custom_faqs as $idx => $faq) : ?>
                    <div class="nh-faq-item border-b border-gray-200 mb-4">
                        <button type="button" class="nh-faq-btn flex justify-between items-center w-full py-4 text-left focus:outline-none group cursor-pointer">
                            <span class="nh-faq-title font-bold text-lg text-navy group-hover:text-gold transition" data-nh-i18n="faq.items.<?php echo $idx; ?>.q"><?php echo esc_html($faq['q']); ?></span>
                            <span class="nh-faq-down text-gray-400 group-hover:text-gold"><?php echo nh_icon('chevron-down', 22); ?></span>
                            <span class="nh-faq-up hidden text-gold"><?php echo nh_icon('chevron-up', 22); ?></span>
                        </button>
                        <div class="nh-faq-body hidden overflow-hidden">
                            <p class="pb-6 text-gray-600 leading-relaxed" data-nh-i18n="faq.items.<?php echo $idx; ?>.a">
                                <?php echo esc_html($faq['a']); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- 8. CALL TO ACTION BANNER -->
    <section class="py-20 bg-navy text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-gold/10"></div>
        <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="container mx-auto px-4 relative z-10 text-center nh-reveal">
            <h2 class="text-2xl md:text-5xl font-bold mb-8 uppercase tracking-widest leading-tight font-sans">
                "<span data-nh-i18n="cta_contact.title_quote"><?php echo esc_html($t_cta['title_quote']); ?></span> <br />
                <span class="text-gold" data-nh-i18n="cta_contact.title_gold"><?php echo esc_html($t_cta['title_gold']); ?></span>"
            </h2>
            <a href="<?php echo esc_url('https://wa.me/' . $wa_primary); ?>"
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center gap-3 bg-gold text-navy px-10 py-5 rounded-full font-bold uppercase tracking-widest text-sm hover:bg-white hover:text-navy transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                <span class="flex items-center justify-center w-6 h-6 bg-navy text-gold rounded-full">
                    <?php echo nh_icon('phone', 14); ?>
                </span>
                <span data-nh-i18n="cta_contact.free_consult"><?php echo esc_html($t_cta['free_consult']); ?></span>
            </a>
        </div>
    </section>

    <!-- 9. CONTACT SECTION -->
    <section id="contact" class="py-16 md:py-24 bg-gray-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gold/5 rounded-full blur-[150px] translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-gold/5 rounded-full blur-[150px] -translate-x-1/2 translate-y-1/2"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 uppercase tracking-wide text-navy" data-nh-i18n="contact_page.title"><?php echo esc_html($t_contact['title']); ?></h2>
                <div class="w-24 h-1.5 bg-gold mx-auto mb-8"></div>
                <p class="mt-4 text-gray-500 max-w-2xl mx-auto text-lg leading-relaxed font-light italic" data-nh-i18n="contact_page.description">
                    <?php echo esc_html($t_contact['description']); ?>
                </p>
                <div class="mt-8">
                    <a href="<?php echo esc_url(home_url('/tentang')); ?>" class="text-navy font-bold hover:text-gold transition-colors underline decoration-gold underline-offset-4" data-nh-i18n="contact_page.profile_link">
                        <?php echo esc_html($t_contact['profile_link']); ?>
                    </a>
                </div>
            </div>

            <div class="max-w-5xl mx-auto">
                <div class="grid md:grid-cols-3 gap-8 mb-16">
                    <!-- Card 1: Phone -->
                    <a href="<?php echo esc_url('https://wa.me/' . $wa_primary . '?text=' . rawurlencode('Halo Kantor Narasumber Hukum, saya ingin berkonsultasi mengenai layanan Anda.')); ?>"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="bg-white p-6 md:p-8 rounded-3xl shadow-xl border border-gray-100 flex flex-col items-center justify-center text-center group hover:border-gold/30 transition-all duration-500 cursor-pointer nh-reveal">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-navy text-gold rounded-2xl flex items-center justify-center mb-5 md:mb-6 group-hover:bg-gold group-hover:text-navy transition-all duration-500 shadow-lg">
                            <?php echo nh_icon('phone', 24); ?>
                        </div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-2" data-nh-i18n="footer.contact_title"><?php echo esc_html($t_foot['contact_title']); ?></p>
                        <p class="font-bold text-navy text-[11px] sm:text-xs md:text-sm">+62-822-1102-0022</p>
                    </a>

                    <!-- Card 2: Office Map -->
                    <a href="<?php echo esc_url($maps_url); ?>"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="bg-white p-6 md:p-8 rounded-3xl shadow-xl border border-gray-100 flex flex-col items-center justify-center text-center group hover:border-gold/30 transition-all duration-500 cursor-pointer nh-reveal">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-navy text-gold rounded-2xl flex items-center justify-center mb-5 md:mb-6 group-hover:bg-gold group-hover:text-navy transition-all duration-500 shadow-lg">
                            <?php echo nh_icon('map-pin', 24); ?>
                        </div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-2" data-nh-i18n="footer.office_title"><?php echo esc_html($t_foot['office_title']); ?></p>
                        <p class="font-bold text-navy text-[11px] sm:text-xs md:text-sm">Jakarta Pusat, Indonesia</p>
                    </a>

                    <!-- Card 3: Email -->
                    <a href="<?php echo esc_url('mailto:' . $email_off); ?>"
                       class="bg-white p-6 md:p-8 rounded-3xl shadow-xl border border-gray-100 flex flex-col items-center justify-center text-center group hover:border-gold/30 transition-all duration-500 cursor-pointer nh-reveal">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-navy text-gold rounded-2xl flex items-center justify-center mb-5 md:mb-6 group-hover:bg-gold group-hover:text-navy transition-all duration-500 shadow-lg">
                            <?php echo nh_icon('mail', 24); ?>
                        </div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-2" data-nh-i18n="contact_page.email_label"><?php echo esc_html($t_contact['email_label']); ?></p>
                        <p class="font-bold text-navy text-[11px] sm:text-xs md:text-sm"><?php echo esc_html($email_off); ?></p>
                    </a>
                </div>

                <div class="max-w-3xl mx-auto nh-reveal">
                    <?php nh_render_contact_form_component(); ?>
                </div>
            </div>
        </div>
    </section>

    <?php
    // Always call the_content() inside the loop so Elementor editor always detects the content area
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            ?>
            <div class="nh-elementor-content">
                <?php the_content(); ?>
            </div>
            <?php
        endwhile;
    endif;
    ?>
</div>

<?php get_footer(); ?>
