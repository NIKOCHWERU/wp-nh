<?php
/**
 * Main Index Fallback Template
 */
if (is_front_page() && !is_home()) {
    require get_template_directory() . '/front-page.php';
} else {
    require get_template_directory() . '/page-artikel.php';
}
