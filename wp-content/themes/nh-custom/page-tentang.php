<?php
/**
 * Template Name: Halaman Tentang Kami (/tentang)
 * Migrated 1:1 from app/tentang/AboutClient.tsx
 */
get_header();

$dict     = nh_get_translations()['id'];
$t_about  = $dict['about_page'];
$t_part   = $dict['partners'];
?>

<div class="pt-20">
    <!-- 1. HERO SECTION -->
    <section class="relative py-20 md:py-32 overflow-hidden bg-navy">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=1920&q=80" alt="Legal Background" class="w-full h-full object-cover opacity-20" />
            <div class="absolute inset-0 bg-gradient-to-br from-navy via-navy/95 to-navy/90"></div>
        </div>

        <div class="absolute top-0 left-0 w-96 h-96 bg-gold/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-gold/10 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-6 uppercase tracking-wide text-white">
                <span data-nh-i18n="about_page.title"><?php echo esc_html($t_about['title']); ?></span>
                <span class="text-gold" data-nh-i18n="about_page.title_gold"><?php echo esc_html($t_about['title_gold']); ?></span>
            </h1>

            <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto leading-relaxed italic font-sans">
                "<span data-nh-i18n="about_page.tagline"><?php echo esc_html($t_about['tagline']); ?></span>"
            </p>

            <div class="mt-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gold/10 backdrop-blur-md rounded-2xl border border-gold/20 text-gold">
                    <?php echo nh_icon('scale', 40); ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. ABOUT PROFILE SECTION -->
    <section class="relative py-16 md:py-24 overflow-hidden bg-white">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')]"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-6xl lg:text-7xl font-black mb-6 uppercase tracking-wider text-navy">
                    NARASUMBER HUKUM
                </h2>
                <div class="w-32 h-1.5 bg-gold mx-auto"></div>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="prose prose-lg max-w-none nh-reveal">
                    <?php foreach ($t_about['description'] as $idx => $p) : ?>
                        <p class="text-gray-600 leading-relaxed mb-6" data-nh-i18n="about_page.description.<?php echo $idx; ?>">
                            <?php echo esc_html($p); ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. VISION SECTION -->
    <section class="relative py-16 md:py-24 overflow-hidden bg-navy text-white">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1920&q=80" alt="Business Vision" class="w-full h-full object-cover opacity-15" />
            <div class="absolute inset-0 bg-gradient-to-br from-navy via-navy/95 to-navy/90"></div>
        </div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-gold/10 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center nh-reveal">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 uppercase tracking-wide" data-nh-i18n="about_page.vision.title"><?php echo esc_html($t_about['vision']['title']); ?></h2>
                <div class="w-24 h-1 bg-gold mx-auto mb-8"></div>
                <p class="text-xl md:text-2xl leading-relaxed text-gray-200 font-sans italic">
                    "<span data-nh-i18n="about_page.vision.desc"><?php echo esc_html($t_about['vision']['desc']); ?></span>"
                </p>
            </div>
        </div>
    </section>

    <!-- 4. MISSION SECTION -->
    <section class="py-16 md:py-24 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 uppercase tracking-wide text-navy" data-nh-i18n="about_page.mission.title"><?php echo esc_html($t_about['mission']['title']); ?></h2>
                <div class="w-24 h-1 bg-gold mx-auto"></div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <?php foreach ($t_about['mission']['items'] as $idx => $m) : ?>
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:border-gold/30 transition-all duration-300 hover:-translate-y-2 group nh-reveal">
                        <div class="w-16 h-16 bg-navy/5 rounded-xl flex items-center justify-center text-gold mb-6 group-hover:bg-navy group-hover:text-gold transition-all duration-500 group-hover:scale-110 group-hover:rotate-3 shadow-sm">
                            <?php echo nh_icon($m['icon'], 32); ?>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-navy font-sans" data-nh-i18n="about_page.mission.items.<?php echo $idx; ?>.title"><?php echo esc_html($m['title']); ?></h3>
                        <p class="text-gray-600 text-sm leading-relaxed" data-nh-i18n="about_page.mission.items.<?php echo $idx; ?>.desc"><?php echo esc_html($m['desc']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- 5. LEGAL SCOPE SECTION -->
    <section class="relative py-16 md:py-24 overflow-hidden bg-gradient-to-br from-white to-gray-50">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')]"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4 uppercase tracking-wide text-navy" data-nh-i18n="about_page.legal_scope.title"><?php echo esc_html($t_about['legal_scope']['title']); ?></h2>
                    <div class="w-24 h-1 bg-gold mx-auto mb-6"></div>
                    <p class="text-gray-600 leading-relaxed max-w-3xl mx-auto" data-nh-i18n="about_page.legal_scope.subtitle">
                        <?php echo esc_html($t_about['legal_scope']['subtitle']); ?>
                    </p>
                </div>

                <div class="bg-gradient-to-br from-navy/5 to-gold/5 p-8 md:p-12 rounded-3xl border border-gray-200 nh-reveal">
                    <div class="grid md:grid-cols-2 gap-x-8 gap-y-3">
                        <?php foreach ($t_about['legal_scope']['items'] as $idx => $scope) : ?>
                            <div class="flex items-start gap-3">
                                <span class="text-gold flex-shrink-0 mt-1"><?php echo nh_icon('check-circle', 18); ?></span>
                                <span class="text-gray-700 text-sm leading-relaxed" data-nh-i18n="about_page.legal_scope.items.<?php echo $idx; ?>"><?php echo esc_html($scope); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. PARTNERS SECTION -->
    <section class="relative py-16 md:py-24 overflow-hidden bg-navy">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80" alt="Office Building" class="w-full h-full object-cover opacity-10" />
            <div class="absolute inset-0 bg-gradient-to-br from-navy via-navy/95 to-navy/90"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 uppercase tracking-wide text-white" data-nh-i18n="partners.title"><?php echo esc_html($t_part['title']); ?></h2>
                <div class="w-24 h-1 bg-gold mx-auto"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Partner 1: Narasumber Hukum Law Firm -->
                <div class="bg-white/10 backdrop-blur-md p-6 md:p-8 rounded-2xl border border-white/20 hover:border-gold/50 transition-all duration-300 hover:-translate-y-2 group nh-reveal">
                    <div class="bg-white rounded-xl p-4 mb-6 flex items-center justify-center min-h-[100px] w-full border border-gray-100 group-hover:border-gold/30 transition-all duration-300">
                        <img src="<?php echo esc_url(NH_THEME_URI . '/assets/images/logo-narasumber-hukum.png'); ?>" alt="<?php echo esc_attr($t_part['narasumber']); ?>" class="w-full h-auto object-contain transition-all duration-500" />
                    </div>
                    <h3 class="text-lg font-bold text-center text-white font-sans"><?php echo esc_html($t_part['narasumber']); ?></h3>
                    <p class="text-gray-300 text-[10px] text-center mt-2 uppercase tracking-widest font-medium">Advocate, Intercessor & Legal Consultant</p>
                </div>

                <!-- Partner 2: Sleco Project -->
                <div class="bg-white/10 backdrop-blur-md p-6 md:p-8 rounded-2xl border border-white/20 hover:border-gold/50 transition-all duration-300 hover:-translate-y-2 group flex flex-col items-center nh-reveal">
                    <div class="bg-white rounded-xl p-4 mb-6 flex items-center justify-center min-h-[100px] w-full border border-gray-100 group-hover:border-gold/30 transition-all duration-300">
                        <img src="<?php echo esc_url(NH_THEME_URI . '/assets/images/logo-seleco.png'); ?>" alt="<?php echo esc_attr($t_part['sleco']); ?>" class="w-full h-auto max-h-[80px] object-contain transition-all duration-500" />
                    </div>
                    <h3 class="text-lg font-bold text-center text-white font-sans"><?php echo esc_html($t_part['sleco']); ?></h3>
                    <p class="text-gray-300 text-[10px] text-center mt-2 uppercase tracking-widest font-medium">Sustainable Solutions & Project Management</p>
                </div>

                <!-- Partner 3: MTI Talenstory -->
                <div class="bg-white/10 backdrop-blur-md p-6 md:p-8 rounded-2xl border border-white/20 hover:border-gold/50 transition-all duration-300 hover:-translate-y-2 group flex flex-col items-center nh-reveal">
                    <div class="bg-white rounded-xl p-4 mb-6 flex items-center justify-center min-h-[100px] w-full border border-gray-100 group-hover:border-gold/30 transition-all duration-300">
                        <img src="<?php echo esc_url(NH_THEME_URI . '/assets/images/logo-mti-talenstory.jpg'); ?>" alt="<?php echo esc_attr($t_part['mti']); ?>" class="w-full h-auto max-h-16 object-contain transition-all duration-500" />
                    </div>
                    <h3 class="text-lg font-bold text-center text-white font-sans"><?php echo esc_html($t_part['mti']); ?></h3>
                    <p class="text-gray-300 text-[10px] text-center mt-2 uppercase tracking-widest font-medium"><?php echo esc_html($t_part['mti_sub']); ?></p>
                </div>
            </div>
        </div>
    </section>

    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            if (!empty(trim(get_the_content()))) :
                ?>
                <section class="nh-elementor-extra">
                    <?php the_content(); ?>
                </section>
                <?php
            endif;
        endwhile;
    endif;
    ?>
</div>

<?php get_footer(); ?>
