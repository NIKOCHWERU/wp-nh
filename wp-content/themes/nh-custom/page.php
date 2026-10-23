<?php
/**
 * Default Page Template (Full Elementor Free & Gutenberg Compatibility)
 */
get_header();
?>

<div class="pt-20 min-h-screen bg-white nh-page-container">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            // Check if built with Elementor
            $is_elementor = get_post_meta(get_the_ID(), '_elementor_edit_mode', true);
            if ($is_elementor) :
                the_content();
            else :
                ?>
                <div class="container mx-auto px-4 py-16 max-w-5xl">
                    <h1 class="text-3xl md:text-5xl font-bold text-navy mb-8 uppercase"><?php the_title(); ?></h1>
                    <div class="nh-prose prose prose-lg max-w-none">
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php
            endif;
        endwhile;
    endif;
    ?>
</div>

<?php get_footer(); ?>
