<?php
/**
 * Header Template (Navbar + SEO Metadata + Schema JSON-LD)
 * Migrated 1:1 from app/layout.tsx & components/Navbar.jsx
 */
if (!defined('ABSPATH')) {
    exit;
}

$t_nav    = nh_get_translations()['id']['nav'];
$is_home  = is_front_page();
$logo_url = NH_THEME_URI . '/assets/images/logo.png';
if (has_custom_logo()) {
    $custom_logo_id = get_theme_mod('custom_logo');
    $custom_logo_src = wp_get_attachment_image_src($custom_logo_id, 'full');
    if (!empty($custom_logo_src[0])) {
        $logo_url = $custom_logo_src[0];
    }
}

$req_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
$nav_links = [
    ['key' => 'nav.home', 'label' => $t_nav['home'], 'url' => home_url('/'), 'active' => $is_home],
    ['key' => 'nav.about', 'label' => $t_nav['about'], 'url' => home_url('/tentang'), 'active' => strpos($req_uri, '/tentang') !== false],
    ['key' => 'nav.services', 'label' => $t_nav['services'], 'url' => home_url('/services'), 'active' => strpos($req_uri, '/services') !== false],
    ['key' => 'nav.articles', 'label' => $t_nav['articles'], 'url' => home_url('/artikel'), 'active' => strpos($req_uri, '/artikel') !== false || is_single()],
    ['key' => 'nav.contact', 'label' => $t_nav['contact'], 'url' => home_url('/kontak'), 'active' => strpos($req_uri, '/kontak') !== false],
];
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kantor Narasumber Hukum memberikan pendampingan hukum profesional dengan pendekatan edukatif untuk solusi yang berkeadilan, resmi, dan terpercaya.">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url(NH_THEME_URI . '/assets/images/icon-32.png'); ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo esc_url(NH_THEME_URI . '/assets/images/icon-192.png'); ?>">
    <link rel="apple-touch-icon" sizes="1024x1024" href="<?php echo esc_url(NH_THEME_URI . '/assets/images/icon.png'); ?>">

    <!-- OpenGraph & Twitter Cards -->
    <meta property="og:site_name" content="Narasumber Hukum">
    <meta property="og:title" content="<?php echo esc_attr(wp_get_document_title()); ?>">
    <meta property="og:description" content="Kantor Narasumber Hukum: Pendampingan hukum profesional dengan pendekatan edukatif untuk solusi yang berkeadilan.">
    <meta property="og:image" content="<?php echo esc_url($logo_url); ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    [
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "Narasumber Hukum",
            "url": "<?php echo esc_url(home_url('/')); ?>",
            "logo": "<?php echo esc_url($logo_url); ?>",
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+62 822-1102-0022",
                "contactType": "customer service",
                "areaServed": "ID",
                "availableLanguage": "Indonesian"
            },
            "sameAs": [
                "<?php echo esc_url(get_theme_mod('nh_ig_url', 'https://www.instagram.com/narasumberhukum/')); ?>",
                "<?php echo esc_url(get_theme_mod('nh_li_url', 'https://www.linkedin.com/company/kantor-narasumber-hukum/')); ?>"
            ]
        },
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "Narasumber Hukum",
            "url": "<?php echo esc_url(home_url('/')); ?>"
        }
    ]
    </script>

    <?php wp_head(); ?>
</head>
<body <?php body_class('antialiased font-sans'); ?>>
<?php wp_body_open(); ?>

<div class="flex flex-col min-h-screen bg-gray-50 text-navy">
    <!-- NAVBAR -->
    <nav id="nh-navbar" data-is-home="<?php echo $is_home ? '1' : '0'; ?>" class="fixed top-0 w-full z-50 transition-all duration-300 <?php echo $is_home ? 'bg-transparent py-5' : 'bg-navbar shadow-2xl py-3'; ?>">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <!-- Brand Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2 lg:gap-4 group">
                <div class="relative">
                    <img src="<?php echo esc_url($logo_url); ?>" alt="Narasumber Hukum Logo" class="w-10 h-10 md:w-14 lg:w-16 md:h-14 lg:h-16 object-contain filter drop-shadow-xl transition-transform duration-500 group-hover:scale-105" />
                </div>
                <div class="flex flex-col">
                    <span class="text-lg md:text-2xl font-bold tracking-[0.15em] uppercase font-serif text-gold border-b border-gold/40 pb-0.5 leading-tight">
                        Narasumber Hukum
                    </span>
                    <span class="text-[8px] md:text-[9px] lg:text-[10px] text-white tracking-[0.3em] uppercase mt-0.5 font-sans whitespace-nowrap" data-nh-i18n="nav.tagline">
                        <?php echo esc_html($t_nav['tagline']); ?>
                    </span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex md:space-x-6 lg:space-x-8 items-center text-xs lg:text-sm font-medium uppercase tracking-wide">
                <?php foreach ($nav_links as $link) : ?>
                    <a href="<?php echo esc_url($link['url']); ?>"
                       data-nh-i18n="<?php echo esc_attr($link['key']); ?>"
                       class="transition duration-300 hover:text-gold <?php echo $link['active'] ? 'text-gold' : 'text-white'; ?>">
                        <?php echo esc_html($link['label']); ?>
                    </a>
                <?php endforeach; ?>

                <a href="<?php echo esc_url(home_url('/kontak')); ?>"
                   data-nh-i18n="nav.cta"
                   class="bg-gold text-navy px-4 lg:px-5 py-2 rounded font-bold hover:bg-opacity-90 transition duration-300 uppercase text-[10px] lg:text-xs tracking-widest cursor-pointer">
                    <?php echo esc_html($t_nav['cta']); ?>
                </a>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center gap-4 md:hidden">
                <button id="nh-mobile-menu-btn" type="button" class="text-gold focus:outline-none" aria-label="Toggle Menu">
                    <span id="nh-icon-menu"><?php echo nh_icon('menu', 28); ?></span>
                    <span id="nh-icon-close" class="hidden"><?php echo nh_icon('x', 28); ?></span>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="nh-mobile-menu" class="hidden md:hidden bg-navbar border-t border-white/5">
            <div class="flex flex-col p-3 space-y-3 text-sm font-medium uppercase text-center text-white">
                <?php foreach ($nav_links as $link) : ?>
                    <a href="<?php echo esc_url($link['url']); ?>"
                       data-nh-i18n="<?php echo esc_attr($link['key']); ?>"
                       class="block hover:text-gold transition py-1.5 <?php echo $link['active'] ? 'text-gold' : ''; ?>">
                        <?php echo esc_html($link['label']); ?>
                    </a>
                <?php endforeach; ?>
                <a href="<?php echo esc_url(home_url('/kontak')); ?>"
                   data-nh-i18n="nav.cta"
                   class="block bg-gold text-navy px-5 py-2.5 rounded font-bold hover:bg-opacity-90 transition uppercase mt-1">
                    <?php echo esc_html($t_nav['cta']); ?>
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
