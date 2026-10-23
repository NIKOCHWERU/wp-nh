<?php
/**
 * Template Name: Halaman Kontak (/kontak)
 * Migrated 1:1 from app/kontak/page.tsx
 */
get_header();

$dict       = nh_get_translations()['id'];
$t_contact  = $dict['contact_page'];
$t_foot     = $dict['footer'];
$email_off  = get_theme_mod('nh_email_official', 'halo@narasumberhukum.com');
?>

<div class="pt-24 pb-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-sans font-bold text-navy mb-4" data-nh-i18n="contact_page.title">
                    <?php echo esc_html($t_contact['title']); ?>
                </h1>
                <p class="text-lg text-gray-600" data-nh-i18n="contact_page.description">
                    <?php echo esc_html($t_contact['description']); ?>
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-8 md:p-12 bg-navy text-white">
                        <h2 class="text-2xl font-bold mb-6 text-gold" data-nh-i18n="footer.contact_title"><?php echo esc_html($t_foot['contact_title']); ?></h2>

                        <div class="space-y-8">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center flex-shrink-0 text-gold">
                                    <?php echo nh_icon('map-pin', 24); ?>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg mb-1" data-nh-i18n="footer.office_title"><?php echo esc_html($t_foot['office_title']); ?></h3>
                                    <p class="text-white/80"><?php echo esc_html(get_theme_mod('nh_office_1_addr', $t_foot['office_1_addr'])); ?></p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center flex-shrink-0 text-gold">
                                    <?php echo nh_icon('phone', 24); ?>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg mb-1">Telepon / WA</h3>
                                    <p class="text-white/80">+62 822-1102-0022</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center flex-shrink-0 text-gold">
                                    <?php echo nh_icon('mail', 24); ?>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg mb-1" data-nh-i18n="contact_page.email_label"><?php echo esc_html($t_contact['email_label']); ?></h3>
                                    <p class="text-white/80"><?php echo esc_html($email_off); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 md:p-12">
                        <?php nh_render_contact_form_component(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
