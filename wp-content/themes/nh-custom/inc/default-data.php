<?php
/**
 * Default Data, Translations (ID & EN), Services, RICCIEP Values, Testimonials, FAQs, and Seed Articles
 * Migrated 1:1 from Next.js lib/translations.ts, app/services/servicesData.tsx, and .backup/pages/Articles.jsx
 */

if (!defined('ABSPATH')) {
    exit;
}

function nh_get_translations() {
    return [
        'id' => [
            'nav' => [
                'home' => 'Beranda',
                'about' => 'Tentang Kami',
                'services' => 'Layanan',
                'articles' => 'Artikel',
                'contact' => 'Kontak',
                'cta' => 'Hubungi',
                'tagline' => 'Sentral Edukasi & Solusi',
            ],
            'about_page' => [
                'title' => 'Tentang',
                'title_gold' => 'Kami',
                'tagline' => 'Legal Certainty, Constructive Solutions, Empowering Your Legal Journey',
                'description' => [
                    'NARASUMBER HUKUM saat ini terdiri dari Narasumber Hukum yang bekerjasama dengan PT Sedana Legal Consultant (SELECO), SLECO Project dan PT Teira Dwan Indonesia (MTI-Talenstory). Dengan ini menjadikan kami sebuah kesatuan pelayanan dalam sektor Hukum, Izin, dan Legalitas disertai dengan Pengembangan dan Pelatihan Sumber Daya Manusia.',
                    'Kami mengaplikasikan pengetahuan, kemampuan, dan kreativitas yang maksimal untuk mencapai tujuan bersama dengan klien kami. Kami tersedia untuk memberikan layanan hukum, izin, legalitas, pengembangan dan pelatihan SDM yang efektif dan efisien secara tepat.',
                    'Pendirian NARASUMBER HUKUM dilatarbelakangi oleh pemahaman akan pentingnya kualitas pelayanan, dan komitmen terhadap kepuasan klien. Kami percaya bahwa dengan menyediakan layanan yang lengkap serta berkualitas tinggi adalah solusi yang tepat untuk memberikan berbagai kemudahan dan kelegaan bagi klien kami.',
                    'Kami yakin bahwa kolaborasi dalam tim kami menghasilkan kinerja maksimal dalam menangani dan menyelesaikan kebutuhan klien kami, karena tim kami berpengalaman dan terlatih serta terbiasa menghadapi berbagai perkara atau proyek dengan tingkat keahliannya yang tinggi.',
                ],
                'vision' => [
                    'title' => 'Visi Kami',
                    'desc' => 'Menjadi mitra terpercaya dalam menyediakan solusi hukum yang berintegritas, inovatif, dan berorientasi pada hasil guna mendukung pertumbuhan dan kepastian hukum bagi setiap klien.',
                ],
                'mission' => [
                    'title' => 'Misi Kami',
                    'items' => [
                        ['icon' => 'heart', 'title' => 'Pelayanan Terbaik', 'desc' => 'Menyediakan layanan hukum berkualitas tinggi yang mendahulukan kepentingan klien dengan memberikan solusi tepat, responsif, dan inovatif.'],
                        ['icon' => 'scale', 'title' => 'Keadilan dan Kepastian Hukum', 'desc' => 'Mengadvokasi keadilan dan kepastian hukum sebagai landasan utama dalam setiap tindakan hukum yang kami ambil, dengan memastikan bahwa hak dan kepentingan klien dijaga dengan cermat.'],
                        ['icon' => 'trending-up', 'title' => 'Kemitraan yang Berkelanjutan', 'desc' => 'Mengembangkan hubungan jangka panjang yang saling menguntungkan dengan klien kami, dengan fokus pada dukungan berkelanjutan dalam mencapai tujuan hukum dan bisnis mereka.'],
                        ['icon' => 'lightbulb', 'title' => 'Inovasi dan Pengetahuan', 'desc' => 'Terus mengembangkan pengetahuan dan teknologi dalam hukum untuk memberikan solusi yang paling muktahir dan efektif kepada klien kami.'],
                        ['icon' => 'shield', 'title' => 'Integritas dan Etika', 'desc' => 'Menegakkan standar tertinggi dalam integritas dan etika hukum, menjadikan kejujuran dan keadilan sebagai prinsip utama dalam setiap tindakan kami.'],
                        ['icon' => 'target', 'title' => 'Dukungan pada Pertumbuhan Bisnis', 'desc' => 'Membantu klien dalam menghadapi tantangan hukum yang kompleks dan memastikan pertumbuhan berkelanjutan bisnis mereka.'],
                    ],
                ],
                'legal_scope' => [
                    'title' => 'Ruang Lingkup Penanganan Perkara',
                    'subtitle' => 'Firma Narasumber Hukum memberikan layanan hukum yang komprehensif untuk berbagai jenis perkara dan upaya hukum. Kami siap membantu klien dalam penyelesaian perkara perdata dan pidana di seluruh Indonesia, baik melalui proses litigasi (penyelesaian di pengadilan) maupun non-litigasi (penyelesaian di luar pengadilan).',
                    'items' => [
                        'Perkara Kewarganegaraan', 'Perkara Perkawinan', 'Perkara Adopsi atau Hak Asuh Anak', 'Perkara Kepemilikan Barang atau Aset',
                        'Perkara Hak Usaha', 'Perkara Perikatan-perikatan', 'Perkara Perkumpulan dan Persekutuan', 'Perkara Jual-Beli, Tukar-Menukar, Sewa-Menyewa', 'Perkara Pinjam-Meminjam',
                        'Perkara Hutang Piutang', 'Perkara Waris atau Hibah', 'Perkara Hak Paten atau Hak Kekayaan Intelektual', 'Perkara Pencemaran Nama Baik',
                        'Perkara Perubahan Nama atau Identitas', 'Perkara Wanprestasi', 'Perkara Perbuatan Melawan Hukum (PMH)', 'Perkara Pemisahan Harta',
                        'Perkara Perjanjian Bisnis atau Pekerjaan', 'Perkara Pencurian atau Perampokan', 'Perkara Pembunuhan', 'Perkara Penipuan',
                        'Perkara Pemerasan', 'Perkara Penganiayaan', 'Perkara Pemerkosaan', 'Perkara Korupsi',
                        'Perkara Pengemplangan Pajak', 'Perkara Pemalsuan Dokumen', 'Perkara Perzinahan', 'Perkara Kekerasan Dalam Rumah Tangga',
                        'Perkara Narkotika', 'Perkara Pelanggaran Ketertiban Umum', 'Perkara Pemalsuan (Counterfeiting)', 'Perkara Perbuatan Curang',
                        'Perkara Pelanggaran Jabatan dan Perkara Pidana Lainnya',
                    ],
                ],
            ],
            'hero' => [
                'title_white' => 'Sentral Edukasi',
                'title_gold' => 'Dan Solusi Hukum',
                'subtitle' => 'Kami memberikan pendampingan hukum yang profesional dengan pendekatan edukatif untuk solusi yang berkeadilan dan berkelanjutan.',
                'cta_services' => 'Layanan Kami',
                'cta_consult' => 'Konsultasi Sekarang',
            ],
            'services' => [
                'title' => 'Layanan Unggulan',
                'subtitle' => 'Solusi hukum komprehensif yang disesuaikan dengan kebutuhan Anda.',
                'view_all' => 'Lihat Layanan Hukum Kami',
                'view_detail' => 'Lihat Detail',
                'cta_custom_title' => 'Butuh Layanan Khusus?',
                'cta_custom_desc' => 'Jika Anda memiliki kebutuhan hukum yang spesifik dan tidak tercantum di atas, hubungi kami untuk mendiskusikan solusi yang tepat.',
                'legal_title' => 'Bidang Hukum',
                'legal_desc' => 'Kami siap mendampingi, memberikan pertimbangan, serta melakukan segala bentuk upaya hukum di Indonesia, baik pembelaan di dalam maupun di luar Pengadilan (Litigasi & Non-Litigasi).',
                'licensing_title' => 'Bidang Perizinan, Legalitas, Perpajakan, Keimigrasian & Pertanahan',
                'licensing_desc' => 'Solusi praktis perlindungan aset dan legalitas bisnis. Kami mendampingi dari investasi awal hingga operasional, mencakup pengurusan izin di 18 Kementerian sesuai regulasi terbaru.',
                'hr_title' => 'Pengembangan & Pelatihan Sumber Daya Manusia',
                'hr_desc' => 'Kami berdedikasi merancang langkah perubahan berdampak bagi individu dan perusahaan melalui metode pelatihan SDM terbaru yang relevan dan inovatif.',
                'back_to_services' => 'Kembali ke Layanan',
                'cta_title' => 'Butuh Bantuan Hukum?',
                'cta_desc' => 'Jangan ragu untuk mendiskusikan masalah Anda dengan tim ahli kami. Kami siap memberikan solusi terbaik.',
            ],
            'why_us' => [
                'title' => 'Mengapa Memilih Kami?',
                'subtitle' => 'Kami peduli, berpengalaman, dan ahli. Bersama kami, Anda tidak lagi berjalan sendiri menghadapi masalah hukum.',
                'items' => [
                    ['title' => 'Komitmen Layanan Terbaik', 'desc' => 'Kepercayaan dan kualitas adalah kunci utama. Kami berkomitmen penuh memberikan pelayanan terbaik bagi Anda.'],
                    ['title' => 'Individu & Perusahaan', 'desc' => 'Solusi hukum tanpa batasan. Siap melayani kebutuhan baik untuk perseorangan maupun korporasi.'],
                    ['title' => 'Tim Berpengalaman', 'desc' => 'Tim terampil, tangguh, dan terbiasa menghadapi berbagai tantangan hukum secara maksimal.'],
                    ['title' => 'Strategi Cekatan', 'desc' => 'Strategi terukur, efisien, dan bertanggung jawab demi efektivitas penyelesaian masalah Anda.'],
                ],
            ],
            'partners' => [
                'title' => 'Partner Kami',
                'sleco' => 'Sleco Project',
                'narasumber' => 'Narasumber Hukum Law Firm',
                'mti' => 'PT Teira Dwan Indonesia',
                'mti_sub' => '(MTI-Talenstory)',
            ],
            'values' => [
                'title' => 'Nilai-nilai Kami',
                'subtitle' => 'Prinsip utama yang menjadi landasan setiap langkah kami dalam melayani Anda.',
                'items' => [
                    ['initial' => 'R', 'icon' => 'zap', 'name' => 'RESPONSIVE (Responsif)', 'desc' => '"Action Today, Not Tomorrow." Menanggapi setiap komunikasi atau rekan kerja maksimal dalam hitungan jam, bukan hari.'],
                    ['initial' => 'I', 'icon' => 'file-text', 'name' => 'INFORMATIVE (Informatif)', 'desc' => '"Clarity is Power." Menyajikan data yang akurat, transparan, dan mudah dipahami dalam setiap laporan atau dokumen.'],
                    ['initial' => 'C', 'icon' => 'message-circle', 'name' => 'COMMUNICATIVE (Komunikatif)', 'desc' => '"Listen First, Solve Better." Membangun dialog dua arah yang jujur dan menjaga alur informasi tetap mengalir tanpa hambatan.'],
                    ['initial' => 'C', 'icon' => 'lightbulb', 'name' => 'CREATIVE (Kreatif)', 'desc' => '"Think Beyond Boundaries." Berani menawarkan sudut pandang baru dan solusi inovatif untuk setiap tantangan yang dihadapi.'],
                    ['initial' => 'I', 'icon' => 'rocket', 'name' => 'INITIATIVE (Inisiatif)', 'desc' => '"Lead the Way." Bertindak proaktif untuk mencegah kendala sebelum terjadi dan memberikan nilai tambah tanpa harus diminta.'],
                    ['initial' => 'E', 'icon' => 'target', 'name' => 'EFFECTIVE (Efektif)', 'desc' => '"Result-Oriented Action." Bekerja dengan fokus pada tujuan akhir dan memastikan setiap langkah memberikan dampak nyata bagi keberhasilan.'],
                    ['initial' => 'P', 'icon' => 'heart', 'name' => 'POSITIVE (Positif)', 'desc' => '"Optimism in Every Challenge." Menjaga energi positif dalam tim dan memberikan rasa aman serta optimisme kepada setiap pihak yang kita layani.'],
                ],
            ],
            'testimonials' => [
                'title' => 'Testimoni Klien',
                'subtitle' => 'Dedikasi kami tercermin dalam setiap kesuksesan yang diraih oleh klien kami.',
                'items' => [
                    ['name' => 'Anwar Muksin', 'role' => 'Klien', 'text' => 'Tim Narasumber Hukum memiliki pemahaman yang mendalam tentang hukum, perizinan dan legalitas yang ada di Indonesia. Kami bersyukur semua permasalahan dalam usaha saya dapat ditangani dengan baik dan efisien oleh tim Narasumber Hukum'],
                    ['name' => 'Ani Handayani', 'role' => 'Klien', 'text' => 'Ibu Debora dan tim melakukan pekerjaan yang sangat baik dan praktis. Mereka memberikan penjelasan yang jelas untuk membantu kami mengambil keputusan. Terimakasih kepada seluruh tim Narasumber Hukum'],
                    ['name' => 'Ridwan Hanafi', 'role' => 'Klien', 'text' => 'Tim ini dapat diandalkan dan responsif. Saya sangat puas dengan kinerja tim, berintegritas dan bersedia mempertimbangkan biaya alternatif untuk menjaga kepuasan klien.'],
                    ['name' => 'Meliana Iskandar', 'role' => 'Klien', 'text' => 'Tim Narasumber Hukum telah mengatur segalanya dengan cermat, dan semuanya terjadi sesuai antisipasi dan penjelasan kepada kami. Sangat sangat membantu dan berguna, terimakasih banyak tim Narasumber Hukum'],
                ],
            ],
            'process' => [
                'title' => 'Alur Penanganan Perkara',
                'subtitle' => 'Langkah-langkah strategis kami dalam memastikan setiap perkara ditangani secara profesional.',
                'items' => [
                    ['step' => '01', 'title' => 'Konsultasi & Analisis', 'desc' => 'Pendalaman materi perkara dan identifikasi posisi hukum klien secara menyeluruh.'],
                    ['step' => '02', 'title' => 'Strategi Hukum', 'desc' => 'Penyusunan langkah-langkah hukum praktis dan efektif sesuai dengan target yang ingin dicapai.'],
                    ['step' => '03', 'title' => 'Eksekusi Tindakan', 'desc' => 'Pelaksanaan langkah hukum baik melalui jalur meja hijau maupun negosiasi di luar pengadilan.'],
                    ['step' => '04', 'title' => 'Evaluasi & Solusi', 'desc' => 'Penyelesaian perkara dengan hasil yang optimal dan berkeadilan bagi masa depan klien.'],
                ],
            ],
            'faq' => [
                'title' => 'Pertanyaan Populer',
                'items' => [
                    ['q' => 'Bagaimana cara memulai konsultasi hukum?', 'a' => 'Anda dapat menghubungi kami melalui tombol WhatsApp yang tersedia di website ini atau mengisi formulir kontak di halaman Hubungi Kami. Tim kami akan segera merespons permintaan Anda.'],
                    ['q' => 'Berapa biaya jasa hukum di Narasumber Hukum?', 'a' => 'Biaya jasa hukum kami bervariasi tergantung pada kompleksitas dan jenis perkara. Kami selalu mengedepankan transparansi dan akan memberikan estimasi biaya setelah sesi konsultasi awal.'],
                    ['q' => 'Apakah Narasumber Hukum hanya melayani di Jakarta?', 'a' => 'Meskipun kantor pusat kami berada di lokasi tertentu, kami melayani klien dan menangani perkara di seluruh wilayah Indonesia (Seluruh Indonesia).'],
                    ['q' => 'Layanan apa saja yang tersedia?', 'a' => 'Kami menyediakan layanan komprehensif mulai dari Litigasi & Non-Litigasi, Perizinan Bisnis, Legalitas Perusahaan, hingga Pengembangan SDM.'],
                ],
            ],
            'cta_contact' => [
                'title_quote' => 'Jangan Ditunda Dan Dipendam,',
                'title_gold' => 'Segera Selesaikan.',
                'button' => 'Hubungi Kami Sekarang',
                'free_consult' => 'Konsultasi Gratis',
            ],
            'contact_page' => [
                'title' => 'Hubungi Kami',
                'description' => '"Kami siap mendengarkan dan mendampingi setiap perkara Anda dengan profesionalisme tinggi."',
                'profile_link' => 'Pelajari Profil Narasumber Hukum',
                'email_label' => 'Email Resmi',
            ],
            'contact_form' => [
                'name_label' => 'Nama Lengkap',
                'name_placeholder' => 'Masukkan nama Anda',
                'email_label' => 'Email Aktif',
                'email_placeholder' => 'name@example.com',
                'phone_label' => 'Nomor WhatsApp',
                'phone_placeholder' => '0812xxxx',
                'subject_label' => 'Subjek',
                'subject_placeholder' => 'Apa yang ingin Anda bicarakan?',
                'message_label' => 'Pesan',
                'message_placeholder' => 'Tuliskan detail pertanyaan atau masalah Anda...',
                'submit_button' => 'Kirim Pesan Sekarang',
                'sending' => 'Mengirim...',
                'success_title' => 'Pesan Terkirim!',
                'success_message' => 'Terima kasih telah menghubungi kami. Tim kami akan segera merespon pesan Anda.',
                'error_message' => 'Terjadi kesalahan. Silakan coba beberapa saat lagi atau hubungi kami via WhatsApp.',
            ],
            'articles_page' => [
                'badge' => 'Sentral Edukasi Hukum',
                'title' => 'Artikel & Edukasi',
                'subtitle' => 'Wawasan hukum kontemporer untuk mendampingi setiap keputusan strategis Anda.',
                'read_more' => 'Baca Selengkapnya',
                'more_articles' => 'Artikel Lainnya',
                'categories' => 'Kategori',
                'back_to_articles' => 'Kembali ke Artikel',
            ],
            'consultation_cta' => [
                'title' => 'Butuh Konsultasi Hukum?',
                'desc' => 'Jangan biarkan permasalahan hukum Anda menjadi beban. Tim ahli kami siap membantu memberikan solusi edukatif dan strategis untuk Anda.',
                'button' => 'Konsultasi Sekarang',
                'available' => 'Tersedia untuk Konsultasi Online',
            ],
            'footer' => [
                'desc' => 'Merupakan tempat berkumpulnya para Aktivis Handal dibidang Hukum, Perizinan, Legalitas, Pengembangan dan Pelatihan SDM yang telah terkoneksi dalam satu pintu untuk dapat melayani kebutuhan Klien kami di Seluruh Indonesia.',
                'services_title' => 'Layanan Kami',
                'office_title' => 'Kantor Kami',
                'contact_title' => 'Hubungi Kami',
                'rights' => 'All Rights Reserved.',
                'office_1_name' => 'Kantor I',
                'office_1_addr' => 'Jl.M.H Thamrin No. 9 Lt 12, Kebon Sirih Menteng, DKI Jakarta, 10340',
                'office_2_name' => 'Kantor II',
                'office_2_addr' => 'Jl. Sunset Road No. 77, Lt.3, Kuta, Kec. Kuta, Badung, Bali, 80361',
                'office_3_name' => 'Kantor III',
                'office_3_addr' => 'Jl. Kertabumi No 1 Ruko Kertabumi Blok A No.9 Lantai 2 Kelurahan Karawang Kulon, Kecamatan Karawang Barat, Kabupaten Karawang, Provinsi Jawa Barat',
                'monday_friday' => 'Melayani konsultasi Senin - Jumat (09.00 - 17.00 WIB)',
            ],
        ],
        'en' => [
            'nav' => [
                'home' => 'Home',
                'about' => 'About Us',
                'services' => 'Services',
                'articles' => 'Articles',
                'contact' => 'Contact',
                'cta' => 'Contact',
                'tagline' => 'Education & Solutions Center',
            ],
            'about_page' => [
                'title' => 'About',
                'title_gold' => 'Us',
                'tagline' => 'Legal Certainty, Constructive Solutions, Empowering Your Legal Journey',
                'description' => [
                    'NARASUMBER HUKUM currently consists of Legal Sources working with PT Sedana Legal Consultant (SELECO), SLECO Project and PT Teira Dwan Indonesia (MTI-Talenstory). This makes us a service unit in the Legal, Permit, and Legality sectors accompanied by Human Resource Development and Training.',
                    'We apply maximum knowledge, ability, and creativity to achieve common goals with our clients. We are available to provide appropriate legal services, permits, legality, HR development and training that are effective and efficient.',
                    'The establishment of NARASUMBER HUKUM was motivated by an understanding of the importance of service quality and commitment to client satisfaction. We believe that providing complete and high-quality services is the right solution to provide various conveniences and relief for our clients.',
                    'We are confident that collaboration in our team produces maximum performance in handling and completing our clients\' needs, because our team is experienced and trained and used to facing various cases or projects with high levels of expertise.',
                ],
                'vision' => [
                    'title' => 'Our Vision',
                    'desc' => 'To be a trusted partner in providing legal solutions with integrity, innovation and result-oriented to support growth and legal certainty for every client.',
                ],
                'mission' => [
                    'title' => 'Our Mission',
                    'items' => [
                        ['icon' => 'heart', 'title' => 'Best Service', 'desc' => 'Providing high-quality legal services that prioritize client interests by providing appropriate, responsive and innovative solutions.'],
                        ['icon' => 'scale', 'title' => 'Justice and Legal Certainty', 'desc' => 'Advocating for justice and legal certainty as the main foundation in every legal action we take, by ensuring client rights and interests are maintained carefully.'],
                        ['icon' => 'trending-up', 'title' => 'Sustainable Partnership', 'desc' => 'Developing mutually beneficial long-term relationships with our clients, with a focus on continuous support in achieving their legal and business goals.'],
                        ['icon' => 'lightbulb', 'title' => 'Innovation and Knowledge', 'desc' => 'Continuing to develop knowledge and technology in law to provide the most updated and effective solutions to our clients.'],
                        ['icon' => 'shield', 'title' => 'Integrity and Ethics', 'desc' => 'Upholding the highest standards in integrity and legal ethics, making honesty and justice the main principles in every of our actions.'],
                        ['icon' => 'target', 'title' => 'Support for Business Growth', 'desc' => 'Helping clients face complex legal challenges and ensuring the continuous growth of their business.'],
                    ],
                ],
                'legal_scope' => [
                    'title' => 'Scope of Case Handling',
                    'subtitle' => 'Narasumber Hukum Law Firm provides comprehensive legal services for various types of cases and legal efforts. We are ready to help clients in resolving civil and criminal cases throughout Indonesia, both through litigation (settlement in court) and non-litigation (settlement out of court).',
                    'items' => [
                        'Citizenship Cases', 'Marriage Cases', 'Adoption or Child Custody Cases', 'Goods or Asset Ownership Cases',
                        'Business Right Cases', 'Commitment Cases', 'Association and Partnership Cases', 'Buy and Sell, Exchange, Rent and Lease Cases', 'Lending and Borrowing Cases',
                        'Debt and Credit Cases', 'Inheritance or Grant Cases', 'Patent or Intellectual Property Right Cases', 'Defamation Cases',
                        'Name or Identity Change Cases', 'Default (Wanprestasi) Cases', 'Unlawful Act (PMH) Cases', 'Property Separation Cases',
                        'Business or Work Agreement Cases', 'Theft or Robbery Cases', 'Murder Cases', 'Fraud Cases',
                        'Extortion Cases', 'Assault Cases', 'Rape Cases', 'Corruption Cases',
                        'Tax Evasion Cases', 'Document Forgery Cases', 'Adultery Cases', 'Domestic Violence Cases',
                        'Narcotics Cases', 'Public Order Violation Cases', 'Counterfeiting Cases', 'Fraudulent Act Cases',
                        'Position Violation Cases and Other Criminal Cases',
                    ],
                ],
            ],
            'hero' => [
                'title_white' => 'Legal Education',
                'title_gold' => 'and Solution Center',
                'subtitle' => 'We provide professional legal assistance with an educational approach for solutions that are fair and sustainable.',
                'cta_services' => 'Our Services',
                'cta_consult' => 'Consult Now',
            ],
            'services' => [
                'title' => 'Selected Services',
                'subtitle' => 'Comprehensive legal solutions tailored to your needs.',
                'view_all' => 'See Our Legal Services',
                'view_detail' => 'See Detail',
                'cta_custom_title' => 'Need Special Services?',
                'cta_custom_desc' => 'If you have specific legal needs not listed above, contact us to discuss the right solution.',
                'legal_title' => 'Legal Field',
                'legal_desc' => 'We are ready to assist, provide considerations, and carry out all forms of legal efforts in Indonesia, both defense inside and outside the Court (Litigation & Non-Litigation).',
                'licensing_title' => 'Permit, Legality, Taxation, Immigration & Land Field',
                'licensing_desc' => 'Practical solutions for asset protection and business legality. We assist from initial investment to operational, including processing permits at 18 Ministries according to the latest regulations.',
                'hr_title' => 'Human Resource Development & Training',
                'hr_desc' => 'We are dedicated to designing impactful change steps for individuals and companies through the latest HR training methods that are relevant and innovative.',
                'back_to_services' => 'Back to Services',
                'cta_title' => 'Need Legal Help?',
                'cta_desc' => 'Do not hesitate to discuss your problems with our expert team. We are ready to provide the best solutions.',
            ],
            'why_us' => [
                'title' => 'Why Choose Us?',
                'subtitle' => 'We care, are experienced, and expert. With us, you are no longer walking alone facing legal problems.',
                'items' => [
                    ['title' => 'Best Service Commitment', 'desc' => 'Trust and quality are the main keys. We are fully committed to providing the best service for you.'],
                    ['title' => 'Individuals & Companies', 'desc' => 'Legal solutions without boundaries. Ready to serve needs for both individuals and corporations.'],
                    ['title' => 'Experienced Team', 'desc' => 'Skilled, tough team, and used to facing various legal challenges maximally.'],
                    ['title' => 'Agile Strategy', 'desc' => 'Measured, efficient, and responsible strategies for the effectiveness of solving your problems.'],
                ],
            ],
            'partners' => [
                'title' => 'Our Partners',
                'sleco' => 'Sleco Project',
                'narasumber' => 'Narasumber Hukum Law Firm',
                'mti' => 'PT Teira Dwan Indonesia',
                'mti_sub' => '(MTI-Talenstory)',
            ],
            'values' => [
                'title' => 'Our Values',
                'subtitle' => 'Main principles that become the foundation of every of our steps in serving you.',
                'items' => [
                    ['initial' => 'R', 'icon' => 'zap', 'name' => 'RESPONSIVE', 'desc' => '"Action Today, Not Tomorrow." Responding to every communication or coworker maximally within hours, not days.'],
                    ['initial' => 'I', 'icon' => 'file-text', 'name' => 'INFORMATIVE', 'desc' => '"Clarity is Power." Presenting accurate, transparent, and easily understood data in every report or document.'],
                    ['initial' => 'C', 'icon' => 'message-circle', 'name' => 'COMMUNICATIVE', 'desc' => '"Listen First, Solve Better." Building honest two-way dialogue and keeping the information flow uninterrupted.'],
                    ['initial' => 'C', 'icon' => 'lightbulb', 'name' => 'CREATIVE', 'desc' => '"Think Beyond Boundaries." Daring to offer new perspectives and innovative solutions for every challenge faced.'],
                    ['initial' => 'I', 'icon' => 'rocket', 'name' => 'INITIATIVE', 'desc' => '"Lead the Way." Acting proactively to prevent obstacles before they occur and providing added value without being asked.'],
                    ['initial' => 'E', 'icon' => 'target', 'name' => 'EFFECTIVE', 'desc' => '"Result-Oriented Action." Working with a focus on the end goal and ensuring every step makes a real impact on success.'],
                    ['initial' => 'P', 'icon' => 'heart', 'name' => 'POSITIVE', 'desc' => '"Optimism in Every Challenge." Maintaining positive energy in the team and providing a sense of security and optimism to every party we serve.'],
                ],
            ],
            'testimonials' => [
                'title' => 'Client Testimonials',
                'subtitle' => 'Our dedication is reflected in every success achieved by our clients.',
                'items' => [
                    ['name' => 'Anwar Muksin', 'role' => 'Client', 'text' => 'Narasumber Hukum team has a deep understanding of law, permits and legality in Indonesia. We are grateful that all problems in my business could be handled well and efficiently by the Narasumber Hukum team.'],
                    ['name' => 'Ani Handayani', 'role' => 'Client', 'text' => 'Ms. Debora and team did an excellent and practical job. They provided clear explanations to help us make decisions. Thank you to the entire Narasumber Hukum team.'],
                    ['name' => 'Ridwan Hanafi', 'role' => 'Client', 'text' => 'This team is reliable and responsive. I am very satisfied with the team\'s performance, integrity and willingness to consider alternative costs to maintain client satisfaction.'],
                    ['name' => 'Meliana Iskandar', 'role' => 'Client', 'text' => 'Narasumber Hukum team has organized everything carefully, and everything happened according to anticipation and explanation to us. Very very helpful and useful, thank you very much Narasumber Hukum team.'],
                ],
            ],
            'process' => [
                'title' => 'Case Handling Flow',
                'subtitle' => 'Our strategic steps in ensuring every case is handled professionally.',
                'items' => [
                    ['step' => '01', 'title' => 'Consultation & Analysis', 'desc' => 'Deepening of case materials and thorough identification of client legal position.'],
                    ['step' => '02', 'title' => 'Legal Strategy', 'desc' => 'Preparation of practical and effective legal steps according to the targets to be achieved.'],
                    ['step' => '03', 'title' => 'Action Execution', 'desc' => 'Implementation of legal steps either through court or mediation outside court.'],
                    ['step' => '04', 'title' => 'Evaluation & Solution', 'desc' => 'Resolution of cases with optimal and fair results for client\'s future.'],
                ],
            ],
            'faq' => [
                'title' => 'Popular Questions',
                'items' => [
                    ['q' => 'How to start a legal consultation?', 'a' => 'You can contact us via the WhatsApp button available on this website or fill out the contact form on the Contact Us page. Our team will immediately respond to your request.'],
                    ['q' => 'How much is the legal service fee at Narasumber Hukum?', 'a' => 'Our legal service fees vary depending on the complexity and type of case. We always prioritize transparency and will provide cost estimates after the initial consultation session.'],
                    ['q' => 'Does Narasumber Hukum only serve in Jakarta?', 'a' => 'Even though our head office is in a certain location, we serve clients and handle cases throughout the territory of Indonesia (Seluruh Indonesia).'],
                    ['q' => 'What services are available?', 'a' => 'We provide comprehensive services starting from Litigation & Non-Litigation, Business Permits, Company Legality, to HR Development.'],
                ],
            ],
            'cta_contact' => [
                'title_quote' => 'Do Not Delay And Keep Inside,',
                'title_gold' => 'Finish Immediately.',
                'button' => 'Contact Us Now',
                'free_consult' => 'Free Consultation',
            ],
            'contact_page' => [
                'title' => 'Contact Us',
                'description' => '"We are ready to listen and accompany your every case with high professionalism."',
                'profile_link' => 'Learn Narasumber Hukum Profile',
                'email_label' => 'Official Email',
            ],
            'contact_form' => [
                'name_label' => 'Full Name',
                'name_placeholder' => 'Enter your name',
                'email_label' => 'Active Email',
                'email_placeholder' => 'name@example.com',
                'phone_label' => 'WhatsApp Number',
                'phone_placeholder' => '0812xxxx',
                'subject_label' => 'Subject',
                'subject_placeholder' => 'What do you want to talk about?',
                'message_label' => 'Message',
                'message_placeholder' => 'Write details of your question or problem...',
                'submit_button' => 'Send Message Now',
                'sending' => 'Sending...',
                'success_title' => 'Message Sent!',
                'success_message' => 'Thank you for contacting us. Our team will immediately respond to your message.',
                'error_message' => 'An error occurred. Please try again in a few moments or contact us via WhatsApp.',
            ],
            'articles_page' => [
                'badge' => 'Legal Education Center',
                'title' => 'Articles & Education',
                'subtitle' => 'Contemporary legal insights to accompany your strategic decisions.',
                'read_more' => 'Read More',
                'more_articles' => 'More Articles',
                'categories' => 'Categories',
                'back_to_articles' => 'Back to Articles',
            ],
            'consultation_cta' => [
                'title' => 'Need Legal Consultation?',
                'desc' => 'Don\'t let legal problems become a burden. Our expert team is ready to provide educational and strategic solutions for you.',
                'button' => 'Consult Now',
                'available' => 'Available for Online Consultation',
            ],
            'footer' => [
                'desc' => 'Is a gathering place for reliable activists in the field of Law, Permits, Legality, HR Development and Training who have been connected in one door to be able to serve the needs of our clients throughout Indonesia.',
                'services_title' => 'Our Services',
                'office_title' => 'Our Office',
                'contact_title' => 'Contact Us',
                'rights' => 'All Rights Reserved.',
                'office_1_name' => 'Office I',
                'office_1_addr' => 'Jl.M.H Thamrin No. 9 Lt 12, Kebon Sirih Menteng, DKI Jakarta, 10340',
                'office_2_name' => 'Office II',
                'office_2_addr' => 'Jl. Sunset Road No. 77, Lt.3, Kuta, Kec. Kuta, Badung, Bali, 80361',
                'office_3_name' => 'Office III',
                'office_3_addr' => 'Jl. Kertabumi No 1 Ruko Kertabumi Blok A No.9 Lantai 2 Karawang Kulon, West Karawang, Karawang Regency, West Java',
                'monday_friday' => 'Serving consultation Monday - Friday (09.00 - 17.00 WIB)',
            ],
        ],
    ];
}

function nh_get_services_data() {
    return [
        'hukum' => [
            'slug' => 'hukum',
            'icon' => 'scale',
            'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
            'title_id' => 'Bidang Hukum',
            'title_en' => 'Legal Field',
            'short_id' => 'Kami siap mendampingi, memberikan pertimbangan, serta melakukan segala bentuk upaya hukum di Indonesia, baik pembelaan di dalam maupun di luar Pengadilan (Litigasi & Non-Litigasi).',
            'short_en' => 'We are ready to assist, provide considerations, and carry out all forms of legal efforts in Indonesia, both defense inside and outside the Court (Litigation & Non-Litigation).',
            'content_id' => '
                <h2>Layanan Hukum Komprehensif</h2>
                <p>Pada intinya meliputi seluruh Perkara/Upaya Hukum di Indonesia, baik secara Litigasi (Penyelesaian dilakukan di Pengadilan) maupun Non Litigasi (Penyelesaian dilakukan di Luar Pengadilan).</p>
                <h3 class="font-bold text-navy text-lg mt-6 mb-4">Cakupan Penanganan Perkara:</h3>
                <div class="grid md:grid-cols-2 gap-x-8 gap-y-2">
                    <ul class="space-y-2 list-disc list-inside text-gray-600">
                        <li>Perkara Kewarganegaraan</li>
                        <li>Perkara Perkawinan</li>
                        <li>Perkara Adopsi atau Hak Asuh Anak</li>
                        <li>Perkara Kepemilikan Barang atau Aset</li>
                        <li>Perkara Hak Usaha</li>
                        <li>Perkara Perikatan-perikatan</li>
                        <li>Perkara Perkumpulan atau Persekutuan</li>
                        <li>Perkara Jual-Beli, Tukar-Menukar, Sewa-Menyewa</li>
                        <li>Perkara Pinjam-Meminjam & Hutang Piutang</li>
                        <li>Perkara Waris atau Hibah</li>
                        <li>Perkara Hak Paten atau HAKI</li>
                        <li>Perkara Pencemaran Nama Baik</li>
                        <li>Perkara Perubahan Nama atau Identitas</li>
                        <li>Perkara Wanprestasi</li>
                        <li>Perkara Perbuatan Melawan Hukum (PMH)</li>
                        <li>Perkara Pemisahan Harta</li>
                        <li>Perkara Perjanjian Bisnis</li>
                        <li>Perkara Pelanggaran Jabatan</li>
                    </ul>
                    <ul class="space-y-2 list-disc list-inside text-gray-600">
                        <li>Perkara Pencurian atau Perampokan</li>
                        <li>Perkara Pembunuhan</li>
                        <li>Perkara Penipuan & Penggelapan</li>
                        <li>Perkara Pemerasan & Pengancaman</li>
                        <li>Perkara Penganiayaan</li>
                        <li>Perkara Pemerkosaan & Asusila</li>
                        <li>Perkara Korupsi (Tipikor)</li>
                        <li>Perkara Pengemplangan Pajak</li>
                        <li>Perkara Pemalsuan Dokumen</li>
                        <li>Perkara Perzinahan</li>
                        <li>Perkara KDRT</li>
                        <li>Perkara Narkotika</li>
                        <li>Perkara Pelanggaran Ketertiban Umum</li>
                        <li>Perkara Perbuatan Curang</li>
                        <li>Dan Perkara Pidana Lainnya</li>
                    </ul>
                </div>
            ',
            'content_en' => '
                <h2>Comprehensive Legal Services</h2>
                <p>Essentially covering all Cases/Legal Efforts in Indonesia, both Litigation (Settlement in Court) and Non-Litigation (Settlement Outside Court).</p>
                <h3 class="font-bold text-navy text-lg mt-6 mb-4">Scope of Case Handling:</h3>
                <div class="grid md:grid-cols-2 gap-x-8 gap-y-2">
                    <ul class="space-y-2 list-disc list-inside text-gray-600">
                        <li>Citizenship Cases</li>
                        <li>Marriage Cases</li>
                        <li>Adoption or Child Custody Cases</li>
                        <li>Goods/Asset Ownership Cases</li>
                        <li>Business Rights Cases</li>
                        <li>Commitment Cases</li>
                        <li>Association or Partnership Cases</li>
                        <li>Buy & Sell, Exchange, Rent & Lease Cases</li>
                        <li>Borrowing and Debt Cases</li>
                        <li>Inheritance or Grant Cases</li>
                        <li>Patent or Intellectual Property Cases</li>
                        <li>Defamation Cases</li>
                        <li>Name or Identity Change Cases</li>
                        <li>Default (Wanprestasi) Cases</li>
                        <li>Unlawful Act (PMH) Cases</li>
                        <li>Property Separation Cases</li>
                        <li>Business Agreement Cases</li>
                        <li>Position Violation Cases</li>
                    </ul>
                    <ul class="space-y-2 list-disc list-inside text-gray-600">
                        <li>Theft or Robbery Cases</li>
                        <li>Murder Cases</li>
                        <li>Fraud & Embezzlement Cases</li>
                        <li>Extortion & Threat Cases</li>
                        <li>Assault Cases</li>
                        <li>Rape & Indecency Cases</li>
                        <li>Corruption (Tipikor) Cases</li>
                        <li>Tax Evasion Cases</li>
                        <li>Document Forgery Cases</li>
                        <li>Adultery Cases</li>
                        <li>Domestic Violence (KDRT) Cases</li>
                        <li>Narcotics Cases</li>
                        <li>Public Order Violation Cases</li>
                        <li>Fraudulent Act Cases</li>
                        <li>And Other Criminal Cases</li>
                    </ul>
                </div>
            ',
        ],
        'perizinan' => [
            'slug' => 'perizinan',
            'icon' => 'file-text',
            'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=800&q=80',
            'title_id' => 'Bidang Perizinan, Legalitas, Perpajakan, Keimigrasian & Pertanahan',
            'title_en' => 'Permit, Legality, Taxation, Immigration & Land Field',
            'short_id' => 'Solusi praktis perlindungan aset dan legalitas bisnis. Kami mendampingi dari investasi awal hingga operasional, mencakup pengurusan izin di 18 Kementerian sesuai regulasi terbaru.',
            'short_en' => 'Practical solutions for asset protection and business legality. We assist from initial investment to operational, including processing permits at 18 Ministries according to the latest regulations.',
            'content_id' => '
                <h2>Solusi Legalitas & Perizinan Terpadu</h2>
                <p>Kami menawarkan solusi dan saran praktis mengenai semua aspek dalam menjalankan bisnis dan segala upaya kaitan dengan perlindungan asset berharga yang ada di Indonesia beserta nasihat untuk keberlangsungan berbagai perizinan dan legalitas.</p>
                <p>Kami berpengalaman melakukan pengurusan serta pendampingan mulai dari investasi awal hingga keberhasilan pendirian dan pengoperasian. Layanan kami mencakup seluruh pekerjaan yang berkaitan dengan 18 Kementrian di Indonesia.</p>
                <div class="space-y-6 mt-8 text-sm">
                    <details class="bg-gray-50 p-4 rounded-lg border border-gray-200" open>
                        <summary class="font-bold text-navy text-base cursor-pointer hover:text-gold transition">1. Legalitas & Izin Usaha Umum</summary>
                        <ul class="mt-3 space-y-1 list-disc list-inside text-gray-600 ml-2">
                            <li>Pendirian, Pembaharuan, Pembubaran Badan Usaha</li>
                            <li>Izin-Izin Usaha OSS dan Hak Kekayaan Intelektual</li>
                            <li>Sertifikat Halal, PIRT, SNI, BPOM</li>
                            <li>Izin Lingkungan dan Mendirikan Bangunan (IMB/PBG)</li>
                        </ul>
                    </details>
                    <details class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <summary class="font-bold text-navy text-base cursor-pointer hover:text-gold transition">2. Perpajakan Lengkap</summary>
                        <ul class="mt-3 space-y-1 list-disc list-inside text-gray-600 ml-2">
                            <li>SPT Tahunan & Masa (Pribadi/Badan)</li>
                            <li>Pengurusan NPWP, EFIN, PKP</li>
                            <li>Restitusi, Keberatan, dan Surat Keterangan Fiskal</li>
                        </ul>
                    </details>
                    <details class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <summary class="font-bold text-navy text-base cursor-pointer hover:text-gold transition">3. Kesehatan & Medis, Keimigrasian & Pertanahan</summary>
                        <ul class="mt-3 space-y-1 list-disc list-inside text-gray-600 ml-2">
                            <li>Izin Operasional RS, Klinik, Apotek & Tenaga Medis</li>
                            <li>Paspor, KITAS, KITAP, & Alih Status Izin Tinggal</li>
                            <li>Konversi, Peralihan, Hak Tanggungan & Perpanjangan Hak Tanah</li>
                        </ul>
                    </details>
                    <details class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <summary class="font-bold text-navy text-base cursor-pointer hover:text-gold transition">4. Sektor Strategis Lainnya</summary>
                        <ul class="mt-3 space-y-1 list-disc list-inside text-gray-600 ml-2">
                            <li>Energi, Migas & Pertambangan</li>
                            <li>Transportasi, Reklame & Lingkungan (AMDAL)</li>
                            <li>Industri, Perdagangan & Rekomendasi Ekspor/Impor</li>
                        </ul>
                    </details>
                </div>
            ',
            'content_en' => '
                <h2>Integrated Legality & Permitting Solutions</h2>
                <p>We offer practical solutions and advice on all aspects of running a business and maintaining the protection of valuable assets in Indonesia, along with counsel for the continuity of various permits and legality.</p>
                <p>We have experience in managing and accompanying from initial investment to successful establishment and operation. Our services cover all work related to 18 Ministries in Indonesia.</p>
                <div class="space-y-6 mt-8 text-sm">
                    <details class="bg-gray-50 p-4 rounded-lg border border-gray-200" open>
                        <summary class="font-bold text-navy text-base cursor-pointer hover:text-gold transition">1. Legality & General Business Permits</summary>
                        <ul class="mt-3 space-y-1 list-disc list-inside text-gray-600 ml-2">
                            <li>Establishment, Renewal, and Dissolution of Business Entities</li>
                            <li>OSS Business Permits and Intellectual Property Rights</li>
                            <li>Halal Certification, PIRT, SNI, BPOM</li>
                            <li>Environmental Permits and Building Permits (IMB/PBG)</li>
                        </ul>
                    </details>
                    <details class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <summary class="font-bold text-navy text-base cursor-pointer hover:text-gold transition">2. Comprehensive Taxation</summary>
                        <ul class="mt-3 space-y-1 list-disc list-inside text-gray-600 ml-2">
                            <li>Annual & Periodic Tax Returns (Individual/Corporate)</li>
                            <li>Processing of NPWP, EFIN, PKP</li>
                            <li>Restitution, Objections, and Fiscal Certificates</li>
                        </ul>
                    </details>
                    <details class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <summary class="font-bold text-navy text-base cursor-pointer hover:text-gold transition">3. Health & Medical, Immigration & Land Affairs</summary>
                        <ul class="mt-3 space-y-1 list-disc list-inside text-gray-600 ml-2">
                            <li>Operational Permits for Hospitals, Clinics, Pharmacies & Medical Personnel</li>
                            <li>Passports, KITAS, KITAP, & Stay Permit Status Switching</li>
                            <li>Conversion, Transfer, Mortgage Rights & Extension of Land Rights</li>
                        </ul>
                    </details>
                    <details class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <summary class="font-bold text-navy text-base cursor-pointer hover:text-gold transition">4. Other Strategic Sectors</summary>
                        <ul class="mt-3 space-y-1 list-disc list-inside text-gray-600 ml-2">
                            <li>Energy, Oil/Gas & Mining Processing</li>
                            <li>Transportation, Advertising & Environment (AMDAL)</li>
                            <li>Industry, Trade & Export/Import Recommendations</li>
                        </ul>
                    </details>
                </div>
            ',
        ],
        'pelatihan-sdm' => [
            'slug' => 'pelatihan-sdm',
            'icon' => 'shield-check',
            'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80',
            'title_id' => 'Pengembangan & Pelatihan Sumber Daya Manusia',
            'title_en' => 'Human Resource Development & Training',
            'short_id' => 'Kami berdedikasi merancang langkah perubahan berdampak bagi individu dan perusahaan melalui metode pelatihan SDM terbaru yang relevan dan inovatif.',
            'short_en' => 'We are dedicated to designing impactful change steps for individuals and companies through the latest HR training methods that are relevant and innovative.',
            'content_id' => '
                <h2>Pengembangan Potensi Human Capital</h2>
                <p>Kami berdedikasi untuk menciptakan, merencanakan, mendesain dan membawakan sebuah langkah perubahan yang berdampak bagi setiap individu maupun Perusahaan dengan disertai metode-metode terbaru yang lebih relevan.</p>
                <div class="space-y-6 mt-8">
                    <div class="bg-gradient-to-r from-navy/5 to-gold/5 p-6 rounded-xl border-l-4 border-gold">
                        <h3 class="font-bold text-navy text-lg mb-3 flex items-center gap-2">IN HOUSE & PUBLIC TRAINING</h3>
                        <p class="text-gray-600 leading-relaxed">Menggunakan model pembelajaran terintegrasi (pra-pelatihan, kelas, dan pasca-pelatihan) dan dikemas dalam bentuk <em>learning journey with high business value</em>.</p>
                    </div>
                    <div class="bg-gradient-to-r from-navy/5 to-gold/5 p-6 rounded-xl border-l-4 border-gold">
                        <h3 class="font-bold text-navy text-lg mb-3 flex items-center gap-2">OUTBOUND PROGRAM FOR TEAMBUILDING</h3>
                        <p class="text-gray-600 leading-relaxed">Melibatkan komponen permainan <em>goal-setting</em>, <em>interpersonal relations</em>, <em>problem-solving</em>, dan <em>role clarification</em>.</p>
                    </div>
                    <div class="bg-gradient-to-r from-navy/5 to-gold/5 p-6 rounded-xl border-l-4 border-gold">
                        <h3 class="font-bold text-navy text-lg mb-3 flex items-center gap-2">PEOPLE ENABLER CONSULTANCY & CAREER COACHING</h3>
                        <p class="text-gray-600 leading-relaxed">Mulai dari rekrutmen, perencanaan karir, pembaharuan kebijakan, hingga coaching lintas generasi (Milennial & Gen Z) agar lebih empowered di tempat kerjanya.</p>
                    </div>
                </div>
            ',
            'content_en' => '
                <h2>Human Capital Potential Development</h2>
                <p>We are dedicated to creating, planning, designing, and delivering impactful steps for change for every individual and Company, accompanied by the latest, more relevant methods.</p>
                <div class="space-y-6 mt-8">
                    <div class="bg-gradient-to-r from-navy/5 to-gold/5 p-6 rounded-xl border-l-4 border-gold">
                        <h3 class="font-bold text-navy text-lg mb-3 flex items-center gap-2">IN HOUSE & PUBLIC TRAINING</h3>
                        <p class="text-gray-600 leading-relaxed">Using an integrated learning model (pre-training, class, and post-training) and packaged as a <em>learning journey with high business value</em>.</p>
                    </div>
                    <div class="bg-gradient-to-r from-navy/5 to-gold/5 p-6 rounded-xl border-l-4 border-gold">
                        <h3 class="font-bold text-navy text-lg mb-3 flex items-center gap-2">OUTBOUND PROGRAM FOR TEAMBUILDING</h3>
                        <p class="text-gray-600 leading-relaxed">Involving game components such as <em>goal-setting</em>, <em>interpersonal relations</em>, <em>problem-solving</em>, and <em>role clarification</em>.</p>
                    </div>
                    <div class="bg-gradient-to-r from-navy/5 to-gold/5 p-6 rounded-xl border-l-4 border-gold">
                        <h3 class="font-bold text-navy text-lg mb-3 flex items-center gap-2">PEOPLE ENABLER CONSULTANCY & CAREER COACHING</h3>
                        <p class="text-gray-600 leading-relaxed">From recruitment, career planning, policy updates, to cross-generational coaching (Millennials & Gen Z) to make them more empowered at their workplace.</p>
                    </div>
                </div>
            ',
        ],
    ];
}

function nh_get_default_seed_articles() {
    return [
        [
            'title' => 'Pentingnya Legalitas Bisnis untuk UMKM',
            'slug' => 'pentingnya-legalitas-bisnis-untuk-umkm',
            'category' => 'Bisnis',
            'excerpt' => 'Mengapa mendaftarkan usaha Anda bukan hanya sekadar kepatuhan, tetapi investasi untuk pertumbuhan jangka panjang?',
            'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=1200&q=80',
            'supporting_images' => [
                ['image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=800&q=80', 'caption' => 'Pendampingan pengurusan izin usaha melalui sistem OSS terpadu.'],
            ],
            'content' => '<p>Legalitas usaha adalah fondasi utama bagi setiap pelaku bisnis, termasuk Usaha Mikro, Kecil, dan Menengah (UMKM). Banyak pelaku UMKM yang masih menganggap bahwa mengurus izin usaha adalah proses yang rumit dan mahal. Padahal, di era digital saat ini, pemerintah telah mempermudah proses perizinan melalui sistem Online Single Submission (OSS).</p><p>Beberapa alasan mengapa legalitas sangat penting antara lain:</p><ul><li><strong>Perlindungan Hukum:</strong> Usaha Anda memiliki payung hukum yang kuat jika terjadi sengketa di kemudian hari.</li><li><strong>Akses Permodalan:</strong> Lembaga keuangan seperti bank mewajibkan adanya dokumen legalitas bagi pelaku usaha yang ingin mengajukan kredit.</li><li><strong>Meningkatkan Kepercayaan Konsumen:</strong> Konsumen dan mitra bisnis lebih percaya untuk bekerja sama dengan usaha yang memiliki identitas resmi.</li><li><strong>Fasilitas Pemerintah:</strong> Banyak program bantuan dan pembinaan dari pemerintah yang dikhususkan bagi UMKM yang sudah berizin.</li></ul><p>Segera urus Nomor Induk Berusaha (NIB) Anda untuk memastikan bisnis Anda tumbuh secara berkelanjutan dan profesional.</p>',
        ],
        [
            'title' => 'Memahami Proses Litigasi di Pengadilan',
            'slug' => 'memahami-proses-litigasi-di-pengadilan',
            'category' => 'Litigasi',
            'excerpt' => 'Panduan praktis bagi Anda yang sedang menghadapi sengketa hukum di pengadilan. Ketahui tahapan dan persiapannya.',
            'image' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1200&q=80',
            'supporting_images' => [
                ['image' => 'https://images.unsplash.com/photo-1589216532372-1c2a367900d9?auto=format&fit=crop&w=800&q=80', 'caption' => 'Tahapan pembuktian dan mediasi dalam persidangan perdata.'],
            ],
            'content' => '<p>Menghadapi sengketa hukum di pengadilan bisa menjadi pengalaman yang menegangkan jika Anda tidak memahami prosedurnya. Litigasi adalah proses penyelesaian sengketa melalui jalur pengadilan, di mana hakim akan memutuskan perkara berdasarkan bukti-bukti yang diajukan.</p><p>Tahapan umum dalam litigasi perdata meliputi:</p><ol><li><strong>Pendaftaran Gugatan:</strong> Penggugat mengajukan berkas ke pengadilan yang berwenang.</li><li><strong>Mediasi:</strong> Tahapan wajib di mana kedua belah pihak mencoba berdamai dengan bantuan mediator hakim.</li><li><strong>Pembacaan Gugatan & Jawaban:</strong> Jika mediasi gagal, persidangan masuk ke pokok perkara.</li><li><strong>Pembuktian:</strong> Tahap krusial untuk mengajukan bukti surat, saksi, maupun saksi ahli.</li><li><strong>Kesimpulan & Putusan:</strong> Hakim memberikan penilaian akhir atas perkara tersebut.</li></ol><p>Persiapan yang matang dan dokumentasi yang lengkap adalah kunci utama dalam menghadapi proses litigasi. Konsultasikan dengan tenaga profesional untuk memastikan hak-hak hukum Anda terlindungi dengan maksimal.</p>',
        ],
        [
            'title' => 'Cara Membuat Kontrak Bisnis yang Aman',
            'slug' => 'cara-membuat-kontrak-bisnis-yang-aman',
            'category' => 'Kontrak',
            'excerpt' => 'Tips menyusun perjanjian kerjasama yang melindungi hak Anda dan mencegah sengketa di kemudian hari.',
            'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1200&q=80',
            'supporting_images' => [
                ['image' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=800&q=80', 'caption' => 'Review klausul kontrak bisnis oleh tim konsultan hukum.'],
            ],
            'content' => '<p>Kontrak atau perjanjian adalah undang-undang bagi pihak-pihak yang membuatnya. Dalam dunia bisnis, kontrak tertulis sangat vital untuk menghindari interpretasi yang berbeda di masa mendatang.</p><p>Kriteria kontrak bisnis yang kuat:</p><ol><li><strong>Identitas Lengkap:</strong> Pastikan subjek hukum (pihak yang bertanda tangan) memiliki kewenangan yang sah.</li><li><strong>Objek Perjanjian:</strong> Jelaskan secara mendetail apa yang menjadi hak dan kewajiban masing-masing pihak.</li><li><strong>Klausul Wanprestasi:</strong> Tentukan apa yang terjadi jika salah satu pihak gagal memenuhi janji, termasuk denda atau sanksi.</li><li><strong>Penyelesaian Sengketa:</strong> Tentukan tempat penyelesaian masalah, apakah melalui negosiasi, arbitrase, atau pengadilan tertentu.</li><li><strong>Force Majeure:</strong> Atur kondisi luar biasa (seperti bencana alam) yang dapat menunda pelaksanaan kontrak.</li></ol><p>Jangan pernah menandatangani kontrak yang tidak Anda pahami sepenuhnya. Review hukum oleh profesional dapat menyelamatkan bisnis Anda dari kerugian besar di masa depan.</p>',
        ],
        [
            'title' => 'Perlindungan Konsumen di Era Digital',
            'slug' => 'perlindungan-konsumen-di-era-digital',
            'category' => 'Edukasi',
            'excerpt' => 'Hak-hak konsumen yang wajib diketahui dalam transaksi online dan langkah hukum jika dirugikan.',
            'image' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1200&q=80',
            'supporting_images' => [
                ['image' => 'https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?auto=format&fit=crop&w=800&q=80', 'caption' => 'Perlindungan hukum bagi transaksi elektronik sesuai UUPK & UU ITE.'],
            ],
            'content' => '<p>Belanja online memberikan kemudahan, namun juga menyimpan risiko. Sebagai konsumen, Anda dilindungi oleh Undang-Undang Perlindungan Konsumen (UUPK).</p><p>Hak-hak utama konsumen digital:</p><ul><li>Hak atas informasi yang benar, jelas, dan jujur mengenai kondisi barang/jasa.</li><li>Hak untuk mendapatkan keamanan dan keselamatan dalam mengonsumsi barang/jasa.</li><li>Hak untuk didengar pendapat dan keluhannya.</li><li>Hak untuk mendapatkan kompensasi atau ganti rugi jika barang yang diterima tidak sesuai.</li></ul><p>Jika Anda merasa dirugikan dalam transaksi digital, simpan semua bukti percakapan dan bukti pembayaran. Anda dapat melapor ke Badan Penyelesaian Sengketa Konsumen (BPSK) atau berkonsultasi dengan pendamping hukum resmi.</p>',
        ],
        [
            'title' => 'Panduan Lengkap Hak Waris di Indonesia',
            'slug' => 'panduan-lengkap-hak-waris-di-indonesia',
            'category' => 'Keluarga',
            'excerpt' => 'Membedah hukum waris di Indonesia: Siapa yang berhak dan bagaimana pembagiannya secara adil.',
            'image' => 'https://images.unsplash.com/photo-1544027993-37dbfe43562a?auto=format&fit=crop&w=1200&q=80',
            'supporting_images' => [
                ['image' => 'https://images.unsplash.com/photo-1505664194779-8beaceb93744?auto=format&fit=crop&w=800&q=80', 'caption' => 'Konsultasi penetapan ahli waris dan balik nama aset warisan.'],
            ],
            'content' => '<p>Hukum waris di Indonesia memiliki sistem hukum yang majemuk, meliputi Hukum Waris Islam, Hukum Waris Perdata (KUHPerdata), dan Hukum Waris Adat. Pemilihan hukum yang berlaku bergantung pada latar belakang hukum dan kesepakatan keluarga.</p><p>Poin penting dalam pembagian warisan:</p><ol><li><strong>Ahli Waris:</strong> Siapa saja yang masuk dalam golongan utama penerima warisan.</li><li><strong>Harta Waris:</strong> Seluruh harta kekayaan pewaris setelah dikurangi kewajiban atau utang yang ada.</li><li><strong>Legitieme Portie:</strong> Bagian mutlak yang dilindungi oleh undang-undang bagi ahli waris garis lurus.</li><li><strong>Proses Balik Nama:</strong> Melegalkan perpindahan hak atas tanah atau aset lainnya kepada ahli waris secara sah.</li></ol><p>Penyusunan wasiat sejak dini atau konsultasi dengan ahli hukum dapat meminimalisir potensi konflik keluarga di kemudian hari terkait pembagian harta.</p>',
        ],
    ];
}
