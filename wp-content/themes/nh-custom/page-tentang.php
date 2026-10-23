<?php
/**
 * Template Name: Halaman Tentang Kami (/tentang)
 * Supports direct click-to-edit in Elementor and fallback when Elementor is not active.
 */
get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();
        $pid = get_the_ID();
        $is_elementor_preview = isset($_GET['elementor-preview']) || (isset($_GET['action']) && $_GET['action'] === 'elementor');
        $has_elementor_data   = get_post_meta($pid, '_elementor_edit_mode', true) === 'builder' && class_exists('\Elementor\Plugin');

        if ($is_elementor_preview || $has_elementor_data) :
            ?>
            <div class="nh-elementor-canvas">
                <?php the_content(); ?>
            </div>
            <?php
        else :
            nh_render_section_about_page();
            ?>
            <div class="nh-elementor-extra">
                <?php the_content(); ?>
            </div>
            <?php
        endif;
    endwhile;
endif;

get_footer();
