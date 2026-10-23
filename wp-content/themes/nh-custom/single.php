<?php
/**
 * Single Article Detail Template (/artikel/[slug])
 * Migrated 1:1 from app/artikel/[slug]/ArticleDetailClient.tsx
 * Supports Newspaper Sidebar Supporting Images + Lightbox + Related Articles + Consultation CTA
 */
get_header();

$dict  = nh_get_translations()['id'];
$t_art = $dict['articles_page'];

if (have_posts()) :
    while (have_posts()) :
        the_post();
        $pid         = get_the_ID();
        $cats        = get_the_category($pid);
        $cat_name    = (!empty($cats) && $cats[0]->name !== 'Uncategorized') ? $cats[0]->name : 'Hukum';
        $author_name = get_post_meta($pid, '_nh_author_name', true) ?: (get_the_author() ?: 'Admin NH');
        $main_img    = nh_get_post_image($pid);
        $supporting  = get_post_meta($pid, '_nh_supporting_images', true);
        $has_supp    = is_array($supporting) && !empty($supporting);

        // Related Articles
        $rel_query = new WP_Query([
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 3,
            'post__not_in'   => [$pid],
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);
?>

<div class="pt-24 pb-20 bg-white min-h-screen font-sans">
    <div class="container mx-auto px-4 max-w-[90%] md:max-w-6xl">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="<?php echo esc_url(home_url('/artikel')); ?>" class="inline-flex items-center text-navy hover:text-gold transition-colors font-bold uppercase tracking-widest text-xs gap-2">
                <?php echo nh_icon('arrow-left', 16); ?>
                <span data-nh-i18n="articles_page.back_to_articles"><?php echo esc_html($t_art['back_to_articles']); ?></span>
            </a>
        </div>

        <!-- Header Section -->
        <header class="mb-12 nh-reveal is-visible">
            <div class="flex items-center gap-2 mb-4">
                <span class="bg-gold text-navy text-[10px] font-bold px-3 py-1 uppercase tracking-[0.2em] rounded-full" data-nh-dynamic-translate="1">
                    <?php echo esc_html($cat_name); ?>
                </span>
            </div>
            <h1 class="text-3xl md:text-5xl font-bold text-navy mb-8 font-sans leading-tight" data-nh-dynamic-translate="1">
                <?php the_title(); ?>
            </h1>

            <div class="flex flex-wrap items-center gap-6 text-gray-400 text-sm border-b border-gray-100 pb-8">
                <div class="flex items-center gap-2">
                    <span class="text-gold"><?php echo nh_icon('calendar', 16); ?></span>
                    <span><?php echo esc_html(get_the_date('d F Y', $pid)); ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-gold"><?php echo nh_icon('user', 16); ?></span>
                    <span><?php echo esc_html($author_name); ?></span>
                </div>
            </div>
        </header>

        <!-- Featured Image with Lightbox -->
        <div class="mb-12 rounded-2xl overflow-hidden shadow-xl aspect-video cursor-pointer" data-nh-lightbox="<?php echo esc_url($main_img); ?>">
            <img src="<?php echo esc_url($main_img); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
        </div>

        <!-- Newspaper Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Main Article Content -->
            <div class="<?php echo $has_supp ? 'lg:col-span-8' : 'lg:col-span-12'; ?>">
                <article class="nh-prose prose prose-lg md:prose-xl max-w-none text-gray-800 leading-relaxed font-normal mb-16">
                    <div class="article-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            </div>

            <!-- Newspaper Sidebar for Supporting Images -->
            <?php if ($has_supp) : ?>
                <div class="lg:col-span-4 border-t lg:border-t-0 lg:border-l border-gray-100 pt-8 lg:pt-0 lg:pl-8 flex flex-col gap-8">
                    <?php foreach ($supporting as $idx => $s_item) :
                        $s_img = is_string($s_item) ? $s_item : (isset($s_item['image']) ? $s_item['image'] : '');
                        $s_cap = is_array($s_item) && isset($s_item['caption']) ? $s_item['caption'] : '';
                        if (empty($s_img)) continue;
                    ?>
                        <div class="flex flex-col gap-3 group">
                            <div class="cursor-pointer overflow-hidden rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition-all duration-300 relative aspect-video" data-nh-lightbox="<?php echo esc_url($s_img); ?>">
                                <img src="<?php echo esc_url($s_img); ?>" alt="<?php echo esc_attr($s_cap ?: 'Supporting image'); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            </div>
                            <?php if (!empty($s_cap)) : ?>
                                <p class="text-xs text-gray-500 italic font-sans text-center px-2" data-nh-dynamic-translate="1">
                                    <?php echo esc_html($s_cap); ?>
                                </p>
                            <?php endif; ?>
                            <div class="w-full border-b border-gray-100 mt-2"></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Related Articles Section -->
        <?php if ($rel_query->have_posts()) : ?>
            <div class="mt-8 mb-16 pt-16 border-t border-gray-100">
                <div class="text-center md:text-left mb-10">
                    <h4 class="text-gold font-black tracking-[0.2em] uppercase text-xs mb-3" data-nh-i18n="articles_page.badge">
                        <?php echo esc_html($t_art['badge']); ?>
                    </h4>
                    <h2 class="text-3xl font-black text-navy uppercase font-sans mb-4 tracking-wide" data-nh-i18n="articles_page.title">
                        <?php echo esc_html($t_art['title']); ?>
                    </h2>
                    <p class="text-gray-500 max-w-2xl text-sm leading-relaxed" data-nh-i18n="articles_page.subtitle">
                        <?php echo esc_html($t_art['subtitle']); ?>
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php while ($rel_query->have_posts()) : $rel_query->the_post();
                        $r_id   = get_the_ID();
                        $r_slug = get_post_field('post_name', $r_id);
                        $r_cats = get_the_category($r_id);
                        $r_cat  = (!empty($r_cats) && $r_cats[0]->name !== 'Uncategorized') ? $r_cats[0]->name : 'Hukum';
                    ?>
                        <a href="<?php echo esc_url(home_url('/artikel/' . $r_slug)); ?>" class="flex flex-col group h-full bg-white border border-gray-100 shadow-sm hover:shadow-md hover:border-gold/30 rounded-xl p-4 transition-all duration-300">
                            <div class="w-full h-40 bg-gray-50 mb-4 overflow-hidden rounded-lg relative">
                                <img src="<?php echo esc_url(nh_get_post_image($r_id)); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            </div>
                            <div class="text-gold text-[10px] font-black tracking-widest uppercase mb-2" data-nh-dynamic-translate="1">
                                <?php echo esc_html($r_cat); ?>
                            </div>
                            <h4 class="text-sm font-bold text-navy mb-3 line-clamp-2 uppercase font-sans group-hover:text-gold transition-colors leading-snug" data-nh-dynamic-translate="1">
                                <?php the_title(); ?>
                            </h4>
                            <div class="mt-auto pt-3 flex justify-between items-center border-t border-gray-50">
                                <div class="flex items-center gap-2 text-gray-400">
                                    <?php echo nh_icon('calendar', 12); ?>
                                    <span class="text-[10px] font-semibold uppercase"><?php echo esc_html(get_the_date('d M Y', $r_id)); ?></span>
                                </div>
                            </div>
                        </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Consultation CTA -->
        <?php nh_render_consultation_cta_component(); ?>

        <!-- Footer Tag Info -->
        <footer class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-gold"><?php echo nh_icon('tag', 16); ?></span>
                <span class="text-xs text-gray-500"><?php echo esc_html($cat_name); ?></span>
            </div>
        </footer>

        <!-- Lightbox Modal -->
        <div id="nh-lightbox-modal" class="hidden fixed inset-0 z-50 bg-black/95 items-center justify-center p-4">
            <button type="button" class="absolute top-6 right-6 text-white/50 hover:text-white transition-colors">
                <?php echo nh_icon('x', 32); ?>
            </button>
            <img id="nh-lightbox-img" src="" alt="Lightbox view" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl" />
        </div>
    </div>
</div>

<?php
    endwhile;
endif;
get_footer();
?>
