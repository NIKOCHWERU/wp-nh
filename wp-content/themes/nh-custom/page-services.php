<?php
/**
 * Template Name: Halaman Layanan (/services)
 * Migrated 1:1 from app/services/ServicesClient.tsx
 */
get_header();

$dict    = nh_get_translations()['id'];
$t_nav   = $dict['nav'];
$t_about = $dict['about_page'];
$t_srv   = $dict['services'];
$t_hero  = $dict['hero'];

// Fetch Services from CPT nh_service or fallback to default data
$srv_query = new WP_Query([
    'post_type'      => 'nh_service',
    'posts_per_page' => 20,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'ASC',
]);

$services_list = [];
if ($srv_query->have_posts()) {
    while ($srv_query->have_posts()) {
        $srv_query->the_post();
        $pid = get_the_ID();
        $img = has_post_thumbnail($pid) ? get_the_post_thumbnail_url($pid, 'full') : get_post_meta($pid, '_nh_service_image', true);
        $services_list[] = [
            'slug'     => get_post_field('post_name', $pid),
            'url'      => get_permalink($pid),
            'icon'     => get_post_meta($pid, '_nh_service_icon', true) ?: 'scale',
            'image'    => $img ?: 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
            'title_id' => get_the_title($pid),
            'title_en' => get_post_meta($pid, '_nh_service_title_en', true) ?: get_the_title($pid),
            'short_id' => get_post_meta($pid, '_nh_service_short_id', true) ?: get_the_excerpt($pid),
            'short_en' => get_post_meta($pid, '_nh_service_short_en', true) ?: get_the_excerpt($pid),
        ];
    }
    wp_reset_postdata();
} else {
    foreach (nh_get_services_data() as $s) {
        $s['url'] = home_url('/services/' . $s['slug']);
        $services_list[] = $s;
    }
}
?>

<div class="pt-20">
    <!-- HEADER SERVICES -->
    <section class="bg-navy text-white py-20 relative overflow-hidden">
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 uppercase tracking-wider">
                <span data-nh-i18n="nav.services"><?php echo esc_html($t_nav['services']); ?></span>
                <span class="text-gold" data-nh-i18n="about_page.title_gold"><?php echo esc_html($t_about['title_gold']); ?></span>
            </h1>
            <div class="w-24 h-1 bg-gold mx-auto mb-8"></div>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed" data-nh-i18n="services.subtitle">
                <?php echo esc_html($t_srv['subtitle']); ?>
            </p>
        </div>
        <div class="absolute top-0 left-0 w-64 h-64 bg-gold opacity-5 rounded-full blur-3xl transform -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-gold opacity-5 rounded-full blur-3xl transform translate-x-1/2 translate-y-1/2"></div>
    </section>

    <!-- SERVICES LIST -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($services_list as $srv) : ?>
                    <div class="bg-white rounded-xl shadow-xl overflow-hidden group hover:-translate-y-2 transition duration-300 border border-gray-100 flex flex-col h-full nh-reveal">
                        <a href="<?php echo esc_url($srv['url']); ?>" class="flex flex-col h-full">
                            <div class="h-48 relative overflow-hidden">
                                <img src="<?php echo esc_url($srv['image']); ?>" alt="<?php echo esc_attr($srv['title_id']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                                <div class="absolute inset-0 bg-navy/60 group-hover:bg-navy/40 transition-colors duration-500"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="text-gold transform group-hover:scale-110 transition duration-500">
                                        <?php echo nh_icon($srv['icon'], 64); ?>
                                    </div>
                                </div>
                                <div class="absolute inset-0 bg-navy/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                    <span class="p-3 bg-gold rounded-full text-navy transform scale-0 group-hover:scale-100 transition delay-100 duration-300">
                                        <?php echo nh_icon('arrow-right', 24); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="p-8 flex flex-col flex-grow">
                                <h3 class="text-2xl font-bold mb-4 text-navy group-hover:text-gold transition-colors font-sans">
                                    <span data-nh-lang-block="id"><?php echo esc_html($srv['title_id']); ?></span>
                                    <span data-nh-lang-block="en" class="hidden"><?php echo esc_html($srv['title_en']); ?></span>
                                </h3>
                                <p class="text-gray-600 mb-8 line-clamp-3 leading-relaxed">
                                    <span data-nh-lang-block="id"><?php echo esc_html($srv['short_id']); ?></span>
                                    <span data-nh-lang-block="en" class="hidden"><?php echo esc_html($srv['short_en']); ?></span>
                                </p>
                                <div class="text-gold font-bold text-sm uppercase tracking-wider flex items-center gap-2 group-hover:gap-4 transition-all mt-auto">
                                    <span data-nh-i18n="services.view_detail"><?php echo esc_html($t_srv['view_detail']); ?></span> <?php echo nh_icon('arrow-right', 16); ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-navy text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gold/5 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl md:text-4xl font-bold mb-8 uppercase tracking-wider" data-nh-i18n="services.cta_custom_title"><?php echo esc_html($t_srv['cta_custom_title']); ?></h2>
            <p class="text-gray-400 max-w-2xl mx-auto mb-12 text-lg" data-nh-i18n="services.cta_custom_desc">
                <?php echo esc_html($t_srv['cta_custom_desc']); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="bg-gold text-navy px-12 py-5 rounded-full font-bold hover:bg-opacity-90 transition duration-300 inline-flex items-center gap-3 uppercase tracking-widest shadow-2xl">
                <span data-nh-i18n="hero.cta_consult"><?php echo esc_html($t_hero['cta_consult']); ?></span> <?php echo nh_icon('arrow-right', 20); ?>
            </a>
        </div>
    </section>
</div>

<?php get_footer(); ?>
