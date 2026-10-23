<?php
/**
 * Front Page Template (Homepage)
 * If Elementor data is active on this page (auto-seeded with all 9 editable NH widgets),
 * it renders `the_content()` so EVERY section can be clicked, edited, reordered, or deleted directly in Elementor!
 * If Elementor is not installed, it falls back seamlessly to the 9 default PHP sections.
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
            nh_render_section_hero();
            nh_render_section_services_preview();
            nh_render_section_why_us();
            nh_render_section_values();
            nh_render_section_testimonials();
            nh_render_section_process();
            nh_render_section_faq();
            nh_render_section_cta_banner();
            nh_render_section_contact();
            ?>
            <div class="nh-elementor-extra">
                <?php the_content(); ?>
            </div>
            <?php
        endif;
    endwhile;
endif;

get_footer();
