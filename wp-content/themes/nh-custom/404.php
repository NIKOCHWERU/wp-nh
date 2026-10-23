<?php
/**
 * 404 Not Found Template
 */
get_header();
?>

<div class="min-h-screen pt-32 pb-20 flex flex-col items-center justify-center text-center px-4 bg-white">
    <div class="w-20 h-20 bg-gold/10 rounded-2xl flex items-center justify-center text-gold mb-6">
        <?php echo nh_icon('scale', 40); ?>
    </div>
    <h1 class="text-5xl md:text-7xl font-black text-navy mb-4 font-serif">404</h1>
    <h2 class="text-2xl md:text-3xl font-bold text-navy mb-4 uppercase tracking-wider">Halaman Tidak Ditemukan</h2>
    <p class="text-gray-500 max-w-md mb-8">Halaman yang Anda cari mungkin telah dipindahkan atau tidak tersedia.</p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="bg-gold text-navy px-8 py-4 rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-navy hover:text-white transition-all shadow-lg">
        Kembali ke Beranda
    </a>
</div>

<?php get_footer(); ?>
