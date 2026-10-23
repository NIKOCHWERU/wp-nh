<?php
/**
 * Footer Template (Footer 4 Columns + FloatingWA + FloatingLanguage)
 * Migrated 1:1 from components/Footer.jsx, FloatingWA.jsx, FloatingLanguage.jsx
 */
if (!defined('ABSPATH')) {
    exit;
}

$dict   = nh_get_translations()['id'];
$t_nav  = $dict['nav'];
$t_srv  = $dict['services'];
$t_foot = $dict['footer'];

$logo_url   = NH_THEME_URI . '/assets/images/logo.png';
$wa_primary = get_theme_mod('nh_wa_primary', '6282211020022');
$wa_disp_1  = get_theme_mod('nh_wa_display_1', '0822 1102 0022');
$wa_advisor = get_theme_mod('nh_wa_advisor', '6282144424311');
$wa_disp_2  = get_theme_mod('nh_wa_display_2', '0821 4442 4311');

$socials = [
    ['name' => 'Instagram', 'icon' => 'instagram', 'url' => get_theme_mod('nh_ig_url', 'https://www.instagram.com/narasumberhukum')],
    ['name' => 'Facebook', 'icon' => 'facebook', 'url' => get_theme_mod('nh_fb_url', 'https://facebook.com/kantor.narasumber.hukum')],
    ['name' => 'LinkedIn', 'icon' => 'linkedin', 'url' => get_theme_mod('nh_li_url', 'https://www.linkedin.com/company/kantor-narasumber-hukum')],
    ['name' => 'Whatsapp', 'icon' => 'whatsapp', 'url' => 'https://wa.me/' . $wa_primary . '?text=' . rawurlencode('Halo Kantor Narasumber Hukum, saya ingin berkonsultasi mengenai layanan Anda.')],
];
?>
    </main>

    <!-- FOOTER -->
    <footer class="bg-navy text-white pt-16 border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-[1.5fr_1fr_1fr_1fr] gap-8 mb-12">
                <!-- Col 1: Brand -->
                <div class="flex flex-col">
                    <div class="flex items-center gap-4 mb-8">
                        <img src="<?php echo esc_url($logo_url); ?>" alt="Logo" class="w-14 h-14 object-contain filter drop-shadow-lg" />
                        <div>
                            <h3 class="text-xl md:text-2xl font-bold tracking-wider font-serif text-gold">NARASUMBER HUKUM</h3>
                            <p class="text-white text-[10px] tracking-[0.2em] uppercase mt-1" data-nh-i18n="nav.tagline"><?php echo esc_html($t_nav['tagline']); ?></p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm mb-6 leading-relaxed max-w-sm" data-nh-i18n="footer.desc">
                        <?php echo esc_html($t_foot['desc']); ?>
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <?php foreach ($socials as $soc) : ?>
                            <a href="<?php echo esc_url($soc['url']); ?>"
                               title="<?php echo esc_attr($soc['name']); ?>"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-11 h-11 flex items-center justify-center bg-white/5 border border-white/10 rounded-xl hover:bg-gold hover:text-navy transition-all duration-300 group">
                                <span class="text-gold group-hover:text-navy transition-colors">
                                    <?php echo nh_icon($soc['icon'], 20); ?>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Col 2: Our Services -->
                <div>
                    <h4 class="text-xl font-bold mb-6 text-gold" data-nh-i18n="footer.services_title"><?php echo esc_html($t_foot['services_title']); ?></h4>
                    <ul class="space-y-4 text-sm text-gray-300">
                        <li>
                            <a href="<?php echo esc_url(home_url('/services/hukum')); ?>" class="hover:text-gold transition-colors block leading-relaxed" data-nh-i18n="services.legal_title"><?php echo esc_html($t_srv['legal_title']); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/services/perizinan')); ?>" class="hover:text-gold transition-colors block leading-relaxed" data-nh-i18n="services.licensing_title"><?php echo esc_html($t_srv['licensing_title']); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/services/pelatihan-sdm')); ?>" class="hover:text-gold transition-colors block leading-relaxed" data-nh-i18n="services.hr_title"><?php echo esc_html($t_srv['hr_title']); ?></a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Offices -->
                <div>
                    <h4 class="text-xl font-bold mb-6 text-gold" data-nh-i18n="footer.office_title"><?php echo esc_html($t_foot['office_title']); ?></h4>
                    <div class="space-y-4 text-sm text-gray-300">
                        <div>
                            <p class="font-bold text-white mb-1" data-nh-i18n="footer.office_1_name"><?php echo esc_html(get_theme_mod('nh_office_1_name', $t_foot['office_1_name'])); ?></p>
                            <p><?php echo esc_html(get_theme_mod('nh_office_1_addr', $t_foot['office_1_addr'])); ?></p>
                        </div>
                        <div>
                            <p class="font-bold text-white mb-1" data-nh-i18n="footer.office_2_name"><?php echo esc_html(get_theme_mod('nh_office_2_name', $t_foot['office_2_name'])); ?></p>
                            <p><?php echo esc_html(get_theme_mod('nh_office_2_addr', $t_foot['office_2_addr'])); ?></p>
                        </div>
                        <div>
                            <p class="font-bold text-white mb-1" data-nh-i18n="footer.office_3_name"><?php echo esc_html(get_theme_mod('nh_office_3_name', $t_foot['office_3_name'])); ?></p>
                            <p><?php echo esc_html(get_theme_mod('nh_office_3_addr', $t_foot['office_3_addr'])); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Col 4: Contacts -->
                <div>
                    <h4 class="text-xl font-bold mb-6 text-gold" data-nh-i18n="footer.contact_title"><?php echo esc_html($t_foot['contact_title']); ?></h4>
                    <div class="space-y-4 text-sm text-gray-300">
                        <div class="group">
                            <p class="font-bold text-white mb-1">Admin</p>
                            <a href="<?php echo esc_url('https://wa.me/' . $wa_primary . '?text=' . rawurlencode('Halo Admin Narasumber Hukum, saya ingin berkonsultasi.')); ?>"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="flex items-center gap-2 hover:text-gold transition">
                                <?php echo nh_icon('phone', 16); ?> <?php echo esc_html($wa_disp_1); ?>
                            </a>
                        </div>
                        <div class="group">
                            <p class="font-bold text-white mb-1">Advisor</p>
                            <a href="<?php echo esc_url('https://wa.me/' . $wa_advisor . '?text=' . rawurlencode('Halo Admin Narasumber Hukum, saya ingin berkonsultasi.')); ?>"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="flex items-center gap-2 hover:text-gold transition">
                                <?php echo nh_icon('phone', 16); ?> <?php echo esc_html($wa_disp_2); ?>
                            </a>
                        </div>
                        <div class="mt-6">
                            <p class="text-xs text-gray-500 italic" data-nh-i18n="footer.monday_friday"><?php echo esc_html(get_theme_mod('nh_work_hours', $t_foot['monday_friday'])); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 py-8 text-center">
                <p class="text-[10px] text-gray-500 uppercase tracking-widest">
                    &copy; <?php echo esc_html(date('Y')); ?> Narasumber Hukum. <span data-nh-i18n="footer.rights"><?php echo esc_html($t_foot['rights']); ?></span>
                </p>
            </div>
        </div>
    </footer>

    <!-- FLOATING WHATSAPP BUTTON (Bottom Right) -->
    <a href="<?php echo esc_url('https://wa.me/' . $wa_primary . '?text=' . rawurlencode('Halo Kantor Narasumber Hukum, saya ingin berkonsultasi. Mohon info jadwalnya.')); ?>"
       target="_blank"
       rel="noopener noreferrer"
       class="fixed bottom-6 right-6 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition duration-300 transform hover:scale-110 z-50 flex items-center gap-2 group"
       aria-label="Chat on WhatsApp">
        <?php echo nh_icon('whatsapp', 32); ?>
        <span class="hidden group-hover:block whitespace-nowrap font-bold text-sm">
            Hubungi Kami
        </span>
    </a>

    <!-- FLOATING LANGUAGE SWITCHER BUTTON (Bottom Left) -->
    <button id="nh-floating-lang-btn"
            type="button"
            class="fixed bottom-6 left-6 bg-navy text-white p-4 rounded-full shadow-lg hover:bg-gold hover:text-navy transition duration-300 transform hover:scale-110 z-50 flex items-center justify-center gap-2 group border border-white/10 cursor-pointer"
            aria-label="Switch Language">
        <?php echo nh_icon('globe', 24, 'group-hover:rotate-12 transition-transform duration-300'); ?>
        <span id="nh-lang-code" class="font-bold text-sm tracking-widest uppercase">ID</span>
        <span id="nh-lang-label" class="hidden group-hover:block whitespace-nowrap font-bold text-xs ml-1">Ganti Bahasa</span>
    </button>
</div><!-- /.min-h-screen -->

<?php wp_footer(); ?>
</body>
</html>
