<?php
/**
 * Single Service Detail Template (/services/[slug])
 * Migrated 1:1 from app/services/[slug]/ServiceDetailClient.tsx
 */
get_header();

$dict       = nh_get_translations()['id'];
$t_srv      = $dict['services'];
$t_cta      = $dict['cta_contact'];
$wa_primary = get_theme_mod('nh_wa_primary', '6282211020022');

if (have_posts()) :
    while (have_posts()) :
        the_post();
        $pid        = get_the_ID();
        $slug       = get_post_field('post_name', $pid);
        $defaults   = nh_get_services_data();
        $def        = isset($defaults[$slug]) ? $defaults[$slug] : null;

        $icon       = get_post_meta($pid, '_nh_service_icon', true) ?: ($def ? $def['icon'] : 'scale');
        $title_id   = get_the_title($pid);
        $title_en   = get_post_meta($pid, '_nh_service_title_en', true) ?: ($def ? $def['title_en'] : $title_id);
        $content_id = get_the_content();
        $content_en = get_post_meta($pid, '_nh_service_content_en', true) ?: ($def ? $def['content_en'] : $content_id);
?>

<div class="bg-white min-h-screen">
    <!-- HERO SECTION -->
    <div class="relative pt-32 pb-24 overflow-hidden bg-navy">
        <div class="container mx-auto px-4 relative z-10">
            <a href="<?php echo esc_url(home_url('/services')); ?>" class="inline-flex items-center gap-2 text-white/70 hover:text-gold mb-8 transition-colors group">
                <?php echo nh_icon('arrow-left', 20, 'group-hover:-translate-x-1 transition-transform'); ?>
                <span data-nh-i18n="services.back_to_services"><?php echo esc_html($t_srv['back_to_services']); ?></span>
            </a>

            <div class="nh-reveal is-visible">
                <div class="w-16 h-16 bg-gold/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-gold mb-6 border border-gold/20">
                    <?php echo nh_icon($icon, 32); ?>
                </div>
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-6 font-sans max-w-4xl leading-tight">
                    <span data-nh-lang-block="id"><?php echo esc_html($title_id); ?></span>
                    <span data-nh-lang-block="en" class="hidden"><?php echo esc_html($title_en); ?></span>
                </h1>
            </div>
        </div>
    </div>

    <!-- CONTENT SECTION -->
    <div class="container mx-auto px-4 py-16 md:py-24 relative z-20">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100 -mt-32">
                <div class="nh-prose prose prose-lg max-w-none text-gray-600 leading-loose">
                    <div data-nh-lang-block="id">
                        <?php echo apply_filters('the_content', $content_id); ?>
                    </div>
                    <div data-nh-lang-block="en" class="hidden">
                        <?php echo wp_kses_post($content_en); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA SECTION -->
    <div class="container mx-auto px-4 pb-16 md:pb-24 relative z-20">
        <div class="max-w-5xl mx-auto nh-reveal">
            <div class="bg-navy text-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100 text-center">
                <div class="w-20 h-20 bg-gold/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-gold mb-6 border border-gold/20 mx-auto">
                    <?php echo nh_icon('phone', 32); ?>
                </div>
                <h3 class="text-3xl md:text-4xl font-bold mb-4 font-sans" data-nh-i18n="services.cta_title"><?php echo esc_html($t_srv['cta_title']); ?></h3>
                <p class="text-gray-300 mb-8 text-lg leading-relaxed max-w-2xl mx-auto" data-nh-i18n="services.cta_desc">
                    <?php echo esc_html($t_srv['cta_desc']); ?>
                </p>
                <a href="<?php echo esc_url('https://wa.me/' . $wa_primary . '?text=' . rawurlencode('Halo, saya ingin berkonsultasi mengenai ' . $title_id)); ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center gap-3 bg-gold text-navy px-10 py-5 rounded-full font-bold hover:bg-white transition-all duration-300 shadow-2xl hover:shadow-gold/50 hover:-translate-y-1 text-lg">
                    <?php echo nh_icon('phone', 20); ?>
                    <span data-nh-i18n="cta_contact.button"><?php echo esc_html($t_cta['button']); ?></span>
                </a>
            </div>
        </div>
    </div>
</div>

<?php
    endwhile;
endif;
get_footer();
?>
