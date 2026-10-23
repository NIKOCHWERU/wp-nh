# 02 — Source Code Audit (`web-nh`)

Dokumen ini mencatat hasil audit lengkap terhadap repository sumber `https://github.com/NIKOCHWERU/web-nh` (branch `main`).

---

## 1. Ringkasan Teknologi Sumber

- **Framework:** Next.js `16.1.1` (App Router) + React `19.2.3`
- **Styling:** Tailwind CSS v4 (`@tailwindcss/postcss`), Google Fonts (`Inter` & `Playfair Display`)
- **Palet Warna Utama:**
  - `--color-gold`: `#C5A059`
  - `--color-navy`: `#0A0A0B`
  - `--color-secondary`: `#161618`
  - `--color-navbar`: `#0A0A0B`
- **Animasi & Ikon:** `framer-motion` (fadeInUp, staggerContainer, pattern background), `lucide-react`, `react-icons/fa` (`FaWhatsapp`)
- **Multi-Bahasa (ID / EN):**
  - Menggunakan `LanguageContext.tsx` (`localStorage.getItem('nh-locale')`, default `'id'`).
  - Kamus statis lengkap di `lib/translations.ts` untuk Bahasa Indonesia (`id`) dan Bahasa Inggris (`en`).
  - Penerjemah dinamis di `lib/translationService.ts` menggunakan endpoint publik `translate.googleapis.com/translate_a/single?client=gtx` untuk menerjemahkan isi artikel secara otomatis saat pengunjung mengganti bahasa ke `EN`.

---

## 2. Daftar Halaman & Rute (Routes)

| Route di Next.js | File Sumber | Pemetaan di WordPress (`nh-custom`) |
| :--- | :--- | :--- |
| `/` | `app/page.tsx` -> `app/HomeClient.tsx` | `front-page.php` (Halaman Beranda) |
| `/tentang` | `app/tentang/page.tsx` -> `app/tentang/AboutClient.tsx` | `page-tentang.php` (Slug halaman: `tentang`) |
| `/services` | `app/services/page.tsx` -> `app/services/ServicesClient.tsx` | `page-services.php` / Archive CPT `nh_service` (Slug: `services`) |
| `/services/[slug]` | `app/services/[slug]/page.tsx` -> `ServiceDetailClient.tsx` | `single-nh_service.php` (`/services/hukum`, `/services/perizinan`, `/services/pelatihan-sdm`) |
| `/artikel` | `app/artikel/page.tsx` -> `app/artikel/ArticlesClient.tsx` | `page-artikel.php` & `home.php` (Slug: `artikel`) |
| `/artikel/[slug]` | `app/artikel/[slug]/page.tsx` -> `ArticleDetailClient.tsx` | `single.php` (Permalink: `/artikel/%postname%/`) |
| `/kontak` | `app/kontak/page.tsx` | `page-kontak.php` (Slug: `kontak`) |
| `/api/contact` | `app/api/contact/route.ts` | WordPress AJAX & REST API (`admin-ajax.php?action=nh_submit_contact` & `/wp-json/nh/v1/contact`) |

---

## 3. Audit Seksi & Komponen per Halaman

### A. Komponen Global (`app/layout.tsx`)
1. **SEO & Schema.org JSON-LD:**
   - Title Template: `%s | Narasumber Hukum` (Default: `Kantor Narasumber Hukum | Sentral Edukasi & Solusi`).
   - OpenGraph & Twitter Card dengan gambar `/logo.png`.
   - JSON-LD `Organization` (telepon `+62 822-1102-0022`, Instagram, LinkedIn) & `WebSite`.
2. **Navbar (`components/Navbar.jsx`):**
   - Fixed top, transparan di atas Hero Homepage lalu berubah menjadi `bg-navbar shadow-2xl py-3` saat di-scroll (`scrollY > 50`) atau saat berada di halaman selain Homepage.
   - Logo `/logo.png` + teks `Narasumber Hukum` (font serif emas) + tagline `Sentral Edukasi & Solusi`.
   - Menu: Beranda (`/`), Tentang Kami (`/tentang`), Layanan (`/services`), Artikel (`/artikel`), Kontak (`/kontak`), dan tombol CTA `Hubungi` (`/kontak`).
   - Menu hamburger responsif untuk layar mobile.
3. **Footer (`components/Footer.jsx`):**
   - 4 Kolom:
     - **Brand:** Logo, nama, tagline, deskripsi singkat, dan tombol sosial media (Instagram, Facebook, LinkedIn, WhatsApp `6282211020022`).
     - **Layanan Kami:** Link ke 3 layanan utama.
     - **Kantor Kami:** Kantor I (Jakarta Pusat - Jl. M.H Thamrin No. 9 Lt 12), Kantor II (Bali - Jl. Sunset Road No. 77 Lt. 3 Kuta), Kantor III (Karawang - Jl. Kertabumi No 1 Ruko Kertabumi Blok A No. 9 Lt 2).
     - **Hubungi Kami:** Admin (`0822 1102 0022`), Advisor (`0821 4442 4311`), jam operasional (`Senin - Jumat 09.00 - 17.00 WIB`).
4. **Floating Buttons:**
   - **Floating WhatsApp (`components/FloatingWA.jsx`):** Kanan bawah (`fixed bottom-6 right-6`), hijau `bg-green-500`, mengarah ke `https://wa.me/6282211020022`.
   - **Floating Language (`components/FloatingLanguage.jsx`):** Kiri bawah (`fixed bottom-6 left-6`), tombol switch bahasa `ID` / `EN` instan tanpa reload halaman, tersimpan di `localStorage` (`nh-locale`).

### B. Halaman Utama (`app/HomeClient.tsx`)
1. **Hero Section:**
   - Video background looping (`https://res.cloudinary.com/dysw7tjks/video/upload/v1756377208/Desain_tanpa_judul_oeaojq.mp4`) + dark overlay `bg-black/70`.
   - Judul besar 2 warna (Putih & Gold), subjudul dengan garis kiri emas (`border-l-4 border-gold`), dan 2 tombol CTA (`Layanan Kami` -> `/services`, `Konsultasi Sekarang` -> `/kontak`).
2. **Services Preview Section:**
   - 3 Kartu Layanan dengan gambar background, efek zoom saat hover, ikon emas, judul, dan deskripsi yang muncul saat hover.
3. **Why Choose Us Section (`Mengapa Memilih Kami?`):**
   - 4 Kartu keunggulan berlatar belakang putih di atas seksi Navy.
4. **Our Values Section (`Nilai-nilai Kami` - RICCIEP):**
   - Watermark raksasa `RICCIEP` di latar belakang + animasi pola kubus.
   - Timeline vertikal (Central Trunk) bergantian kiri-kanan untuk 7 nilai:
     - **R** - Responsive (`Zap`)
     - **I** - Informative (`FileText`)
     - **C** - Communicative (`MessageCircle`)
     - **C** - Creative (`Lightbulb`)
     - **I** - Initiative (`Rocket`)
     - **E** - Effective (`Target`)
     - **P** - Positive (`Heart`)
5. **Testimonials Section (`Testimoni Klien`):**
   - 4 Kartu kutipan testimoni klien (Anwar Muksin, Ani Handayani, Ridwan Hanafi, Meliana Iskandar).
6. **Legal Process Section (`Alur Penanganan Perkara`):**
   - 4 Langkah berurutan (`01` Konsultasi & Analisis, `02` Strategi Hukum, `03` Eksekusi Tindakan, `04` Evaluasi & Solusi) dengan panah penghubung.
7. **FAQ Section (`Pertanyaan Populer`):**
   - Accordion interaktif (buka/tutup jawaban).
8. **Call To Action Quote Banner:**
   - Kutipan `"Jangan Ditunda Dan Dipendam, Segera Selesaikan."` + tombol WhatsApp `Konsultasi Gratis`.
9. **Contact Section:**
   - 3 Kartu info kontak (Telepon/WA, Lokasi Maps Jakarta Pusat, Email `hello@narasumberhukum.com`) + komponen `ContactForm`.

### C. Halaman Tentang Kami (`app/tentang/AboutClient.tsx`)
1. **Hero Tentang Kami:** Judul, tagline `"Legal Certainty, Constructive Solutions, Empowering Your Legal Journey"`, ikon timbangan (`Scale`).
2. **Profil Narasumber Hukum:** 4 paragraf penjelasan kolaborasi Narasumber Hukum, PT Sedana Legal Consultant (SELECO), SLECO Project, dan PT Teira Dwan Indonesia (MTI-Talenstory).
3. **Visi Kami:** Banner Navy dengan kutipan visi.
4. **Misi Kami:** Grid 6 kartu misi beserta ikon masing-masing.
5. **Ruang Lingkup Penanganan Perkara:** Daftar 33 jenis perkara perdata dan pidana dalam kotak 2 kolom dengan ikon centang emas.
6. **Partner Kami:** 3 Kartu logo partner (`/logo-narasumber-hukum.png`, `/logo-seleco.png`, `/logo-mti-talenstory.jpg`).

### D. Halaman Layanan & Detail Layanan (`app/services/`)
1. **Daftar Layanan (`/services`):** Menampilkan 3 kartu layanan utama + seksi CTA bawah.
2. **Detail Layanan (`/services/[slug]`):**
   - `/services/hukum`: Layanan Hukum Komprehensif (daftar 33 perkara litigasi & non-litigasi).
   - `/services/perizinan`: Solusi Legalitas & Perizinan Terpadu (4 accordion `<details>` mencakup izin usaha OSS, perpajakan, kesehatan/imigrasi/pertanahan, dan sektor strategis 18 kementerian).
   - `/services/pelatihan-sdm`: Pengembangan Potensi Human Capital (3 blok program: In House & Public Training, Outbound Program, People Enabler Consultancy & Career Coaching).

### E. Sistem Full-Stack Artikel & Edukasi (`app/artikel/`)
1. **Arsitektur Asli:**
   - Mengambil artikel dari backend API (`NEXT_PUBLIC_API_URL/api/articles`) dengan struktur data: `title`, `slug`, `content` (HTML), `image` / `image_url`, `category.name`, `author.name`, `author.profile_photo_url`, `published_at`, dan `supporting_images` (array gambar pendukung + caption untuk layout koran/newspaper sidebar).
   - Di `.backup/pages/Articles.jsx` juga terdapat 5 artikel hukum awal lengkap beserta isi, kategori, dan gambar Unsplash.
2. **Migrasi ke WordPress Full-Stack:**
   - Di WordPress, seluruh manajemen artikel menjadi **100% Native Full-Stack di dalam WordPress Admin** (menu **Posts / Artikel**):
     - Mendukung **Featured Image (Gambar Utama)**, **Kategori Artikel**, **Penulis & Foto Profil**, **Waktu Baca Otomatis**, dan **Custom Meta Box "Supporting Images (Newspaper Sidebar)"** (lengkap dengan gambar pendukung & caption seperti di `ArticleDetailClient.tsx`).
     - Dilengkapi fitur **One-Click Seed / Import Artikel**: Mengimpor ke-5 artikel awal + menarik otomatis seluruh artikel dari API lama (`https://api.narasumberhukum.com/api/articles` atau URL API yang dimasukkan admin) langsung menjadi Post WordPress asli!
     - Tetap mendukung fitur **Auto-Translate (ID <-> EN)** untuk artikel dan halaman saat tombol bahasa di kiri bawah diklik.

### F. Formulir Kontak (`components/ContactForm.jsx` & `app/api/contact/route.ts`)
- Formulir memiliki 5 field: `name`, `email`, `phone`, `subject`, `message`.
- Di WordPress (`nh-custom`), saat formulir dikirim:
  1. **Disimpan otomatis ke Database WordPress** (Custom Post Type `nh_contact_msg` di menu **Pesan Kontak** WP Admin) sehingga tidak ada pesan klien yang hilang meskipun SMTP belum disetting.
  2. **Mengirim Email Notifikasi** ke `hello@narasumberhukum.com` melalui `wp_mail()` (dengan dukungan konfigurasi SMTP langsung di panel pengaturan tema `mail.narasumberhukum.com:465`).
