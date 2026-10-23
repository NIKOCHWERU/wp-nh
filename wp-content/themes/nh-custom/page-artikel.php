<?php
/**
 * Template Name: Halaman Artikel & Edukasi (/artikel)
 * Migrated 1:1 from app/artikel/ArticlesClient.tsx
 */
get_header();

$dict  = nh_get_translations()['id'];
$t_art = $dict['articles_page'];

// Ensure seed articles exist if no posts found yet
$post_count = wp_count_posts('post')->publish;
if ($post_count == 0) {
    nh_seed_initial_data(true);
}

$art_query = new WP_Query([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 50,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

$all_articles = [];
$categories_set = [];

if ($art_query->have_posts()) {
    while ($art_query->have_posts()) {
        $art_query->the_post();
        $pid  = get_the_ID();
        $cats = get_the_category($pid);
        $cat_name = (!empty($cats) && $cats[0]->name !== 'Uncategorized') ? $cats[0]->name : 'Hukum';
        $categories_set[$cat_name] = true;

        $author_name = get_post_meta($pid, '_nh_author_name', true) ?: (get_the_author() ?: 'Admin NH');
        $slug = get_post_field('post_name', $pid);

        $all_articles[] = [
            'id'        => $pid,
            'title'     => get_the_title($pid),
            'slug'      => $slug,
            'url'       => home_url('/artikel/' . $slug),
            'image'     => nh_get_post_image($pid),
            'category'  => $cat_name,
            'author'    => $author_name,
            'date'      => get_the_date('d M Y', $pid),
            'excerpt'   => wp_trim_words(wp_strip_all_tags(get_the_content()), 24),
            'read_time' => nh_get_reading_time(get_the_content()),
        ];
    }
    wp_reset_postdata();
}

$featured_article = !empty($all_articles) ? $all_articles[0] : null;
$grid_articles    = array_slice($all_articles, 1, 3);
$list_articles    = array_slice($all_articles, 4);
$unique_cats      = array_keys($categories_set);
?>

<div class="pt-24 bg-white min-h-screen pb-24 font-sans text-gray-800">

    <!-- 1. TOP SECTION (Hero & Featured Article) -->
    <section class="container mx-auto px-4 max-w-7xl mb-16">
        <div class="flex flex-col lg:flex-row gap-10 items-stretch">

            <!-- Left: Titles & Info -->
            <div class="lg:w-1/3 flex flex-col justify-center py-8">
                <div class="nh-reveal is-visible">
                    <h4 class="text-gold font-black tracking-[0.2em] uppercase text-xs mb-4" data-nh-i18n="articles_page.badge">
                        <?php echo esc_html($t_art['badge']); ?>
                    </h4>
                    <h1 class="text-5xl lg:text-6xl font-black mb-6 text-navy leading-tight uppercase font-sans" data-nh-i18n="articles_page.title">
                        <?php echo esc_html($t_art['title']); ?>
                    </h1>
                    <p class="text-gray-500 mb-8 leading-relaxed max-w-md text-lg" data-nh-i18n="articles_page.subtitle">
                        <?php echo esc_html($t_art['subtitle']); ?>
                    </p>
                    <?php if ($featured_article) : ?>
                        <a href="<?php echo esc_url($featured_article['url']); ?>"
                           class="inline-flex items-center gap-3 bg-navy hover:bg-gold text-white hover:text-navy px-8 py-4 text-sm font-bold tracking-widest uppercase transition-colors rounded-sm w-fit shadow-lg shadow-navy/20"
                           data-nh-i18n="articles_page.read_more">
                            <?php echo esc_html($t_art['read_more']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right: Featured Article Image Card -->
            <div class="lg:w-2/3">
                <?php if ($featured_article) : ?>
                    <div class="w-full h-full min-h-[300px] lg:min-h-[450px] bg-gray-100 rounded-sm overflow-hidden relative group cursor-pointer shadow-xl border border-gray-100" data-nh-article-cat="<?php echo esc_attr($featured_article['category']); ?>">
                        <a href="<?php echo esc_url($featured_article['url']); ?>" class="block w-full h-full">
                            <img src="<?php echo esc_url($featured_article['image']); ?>" alt="<?php echo esc_attr($featured_article['title']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 absolute inset-0" />
                            <div class="absolute inset-0 bg-navy/30 group-hover:bg-navy/10 transition-colors"></div>

                            <!-- Floating Badge for Featured -->
                            <div class="absolute bottom-6 left-6 right-6">
                                <div class="bg-white/95 border border-gold/30 backdrop-blur-sm p-6 rounded-sm shadow-xl transform group-hover:-translate-y-2 transition-transform duration-300">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="text-gold text-xs font-black tracking-widest uppercase" data-nh-dynamic-translate="1">
                                            <?php echo esc_html($featured_article['category']); ?>
                                        </div>
                                    </div>
                                    <h3 class="text-xl md:text-3xl font-bold text-navy line-clamp-2 leading-tight font-sans mb-4" data-nh-dynamic-translate="1">
                                        <?php echo esc_html($featured_article['title']); ?>
                                    </h3>
                                    <div class="flex items-center gap-3 border-t border-gray-100 pt-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                            <?php echo nh_icon('user', 14); ?>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-navy"><?php echo esc_html($featured_article['author']); ?></span>
                                            <span class="text-[10px] text-gray-500 font-medium uppercase tracking-wider"><?php echo esc_html($featured_article['date']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- 2. MIDDLE SECTION (3-Column Grid) -->
    <?php if (!empty($grid_articles)) : ?>
    <section class="container mx-auto px-4 max-w-7xl mb-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <?php foreach ($grid_articles as $art) : ?>
                <div class="flex flex-col group h-full nh-reveal" data-nh-article-cat="<?php echo esc_attr($art['category']); ?>">
                    <a href="<?php echo esc_url($art['url']); ?>" class="flex flex-col h-full bg-white border border-gray-100 shadow-sm hover:shadow-xl hover:border-gold/30 rounded-sm p-5 transition-all duration-300">
                        <div class="w-full h-56 bg-gray-50 mb-6 overflow-hidden rounded-sm relative shadow-sm">
                            <img src="<?php echo esc_url($art['image']); ?>" alt="<?php echo esc_attr($art['title']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />
                        </div>

                        <div class="text-gold text-xs font-black tracking-widest uppercase mb-3 line-clamp-1" data-nh-dynamic-translate="1">
                            <?php echo esc_html($art['category']); ?>
                        </div>

                        <h3 class="text-xl font-bold text-navy mb-3 line-clamp-2 uppercase font-sans group-hover:text-gold transition-colors leading-snug" data-nh-dynamic-translate="1">
                            <?php echo esc_html($art['title']); ?>
                        </h3>

                        <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-6" data-nh-dynamic-translate="1">
                            <?php echo esc_html($art['excerpt']); ?>
                        </p>

                        <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                                    <?php echo nh_icon('user', 14); ?>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-navy"><?php echo esc_html($art['author']); ?></span>
                                    <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider"><?php echo esc_html($art['date']); ?></span>
                                </div>
                            </div>
                            <span class="flex items-center gap-1.5 text-gray-400 text-xs font-semibold">
                                <?php echo nh_icon('clock', 12); ?> <?php echo esc_html($art['read_time']); ?> min
                            </span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Divider -->
    <div class="container mx-auto px-4 max-w-7xl mb-16">
        <div class="w-full border-t border-gray-100"></div>
    </div>

    <!-- 3. BOTTOM SECTION (More Articles + Category Filter Sidebar) -->
    <section class="bg-gray-50 py-16 md:py-24 border-t border-gray-100">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col lg:flex-row gap-16">

                <!-- Left: Article List -->
                <div class="lg:w-2/3">
                    <h2 class="text-3xl font-black text-navy uppercase font-sans mb-10 tracking-wide flex items-center gap-4">
                        <span data-nh-i18n="articles_page.more_articles"><?php echo esc_html($t_art['more_articles']); ?></span>
                        <span class="h-0.5 bg-gray-200 flex-1"></span>
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-12">
                        <?php foreach ($all_articles as $art) : ?>
                            <a href="<?php echo esc_url($art['url']); ?>"
                               data-nh-article-cat="<?php echo esc_attr($art['category']); ?>"
                               class="flex gap-5 group items-start bg-white p-4 rounded-sm border border-gray-100 shadow-sm hover:shadow-md hover:border-gold/30 transition-all duration-300">
                                <div class="w-24 h-24 shrink-0 bg-gray-50 border border-gray-100 rounded-sm overflow-hidden shadow-sm relative">
                                    <img src="<?php echo esc_url($art['image']); ?>" alt="<?php echo esc_attr($art['title']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />
                                </div>
                                <div class="flex flex-col justify-start flex-1">
                                    <div class="text-gold text-[10px] font-black tracking-widest uppercase mb-1" data-nh-dynamic-translate="1">
                                        <?php echo esc_html($art['category']); ?>
                                    </div>
                                    <h4 class="text-sm font-bold text-navy uppercase mb-2 group-hover:text-gold transition-colors line-clamp-2 leading-relaxed" data-nh-dynamic-translate="1">
                                        <?php echo esc_html($art['title']); ?>
                                    </h4>
                                    <div class="mt-auto flex items-center gap-2 pt-2 border-t border-gray-50">
                                        <span class="text-gray-400"><?php echo nh_icon('user', 14); ?></span>
                                        <span class="text-[10px] font-bold text-navy truncate"><?php echo esc_html($art['author']); ?></span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Right: Categories Block -->
                <div class="lg:w-1/3">
                    <div class="bg-navy border border-navy p-10 rounded-sm h-full relative overflow-hidden min-h-[300px] flex flex-col shadow-xl">
                        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-screen"></div>

                        <h3 class="text-gold font-black uppercase tracking-widest text-lg mb-8 relative z-10 border-b border-white/10 pb-4" data-nh-i18n="articles_page.categories">
                            <?php echo esc_html($t_art['categories']); ?>
                        </h3>

                        <div class="relative z-10 flex flex-wrap gap-3">
                            <button type="button" data-cat="all" class="nh-cat-filter-btn px-5 py-2.5 text-xs font-black uppercase tracking-widest rounded-sm transition-all shadow-md border bg-gold border-gold text-navy scale-105 cursor-pointer">
                                ALL
                            </button>
                            <?php foreach ($unique_cats as $cat) : ?>
                                <button type="button" data-cat="<?php echo esc_attr($cat); ?>" class="nh-cat-filter-btn px-5 py-2.5 text-xs font-black uppercase tracking-widest rounded-sm transition-all shadow-md border bg-white/5 border-white/10 text-gray-300 hover:border-gold hover:text-gold hover:scale-105 cursor-pointer">
                                    <?php echo esc_html($cat); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. CTA FOOTER -->
    <div class="container mx-auto px-4 max-w-7xl mt-20">
        <?php nh_render_consultation_cta_component(); ?>
    </div>

    <?php
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
