# 01 — Git Workflow & Repository Architecture

Dokumen ini menjelaskan alur kerja Git yang digunakan untuk memigrasikan website **Narasumber Hukum** dari repository sumber (`web-nh`) ke repository tujuan WordPress (`wp-nh`) secara aman.

---

## 1. Pemisahan Repository Sumber & Tujuan

| Repository | URL | Peran | Aturan Keamanan |
| :--- | :--- | :--- | :--- |
| **Sumber (Source)** | `https://github.com/NIKOCHWERU/web-nh.git` | Aplikasi Next.js 16 produksi saat ini | **Read-Only.** Di-clone ke folder sementara `_source_web_nh` di luar pohon Git tujuan. Tidak ada commit atau push ke remote ini. |
| **Tujuan (Target)** | `https://github.com/NIKOCHWERU/wp-nh.git` | Proyek Migrasi WordPress (`nh-custom` theme + docs) | **Write Target.** Branch utama: `main`. Seluruh hasil migrasi dan dokumentasi di-push ke repository ini. |

---

## 2. Pemeriksaan Awal Repository Tujuan

Pada awal Fase 3, dilakukan pemeriksaan `git ls-remote https://github.com/NIKOCHWERU/wp-nh.git`:
- Ditemukan 1 commit inisial (`e40e40fb6283ff1654ea4f736c304a82b7f32a8e` pada `refs/heads/main`) yang hanya berisi file `README.md` berukuran 7 byte (`# wp-nh`).
- Untuk menjaga integritas riwayat commit tanpa menggunakan `git push --force`, workspace ini akan melakukan `git pull origin main --allow-unrelated-histories` atau mengintegrasikan commit di atas `e40e40fb6283ff1654ea4f736c304a82b7f32a8e` secara fast-forward.

---

## 3. Struktur Repository Tujuan (`wp-nh`)

```text
wp-nh/
├── .gitignore                          # Mengecualikan _source_web_nh, node_modules, .env, kredensial, log
├── README.md                           # Ringkasan arsitektur & navigasi cepat dokumentasi
├── nh-custom-theme.zip                 # Paket tema WordPress siap upload via WP Admin / SSH
├── wp-content/
│   └── themes/
│       └── nh-custom/                  # Source code lengkap Custom WordPress Theme "Narasumber Hukum"
│           ├── style.css               # Metadata tema & custom styling
│           ├── functions.php           # Setup tema, CPT, Meta Boxes, Customizer, AJAX Form, Importer, Elementor
│           ├── header.php              # Navbar responsif + Language Switcher + SEO Schema JSON-LD
│           ├── footer.php              # Footer 4 kolom + Floating WA + Floating Language + ScrollToTop
│           ├── index.php               # Fallback template
│           ├── front-page.php          # Homepage (Hero Video, Layanan, Why Us, RICCIEP Values, Testimoni, Alur, FAQ, CTA, Kontak)
│           ├── page.php                # Template halaman standar & kompatibel penuh dengan Elementor Free
│           ├── page-tentang.php        # Halaman Tentang Kami (/tentang)
│           ├── page-services.php       # Halaman Daftar Layanan (/services)
│           ├── page-artikel.php        # Halaman Direktori Artikel (/artikel)
│           ├── page-kontak.php         # Halaman Kontak (/kontak)
│           ├── single.php              # Detail Artikel (/artikel/{slug}) dengan Newspaper Layout, Supporting Images, Lightbox
│           ├── single-nh_service.php   # Detail Layanan (/services/{slug})
│           ├── archive.php             # Arsip Kategori/Tag Artikel
│           ├── 404.php                 # Halaman 404 Kustom
│           ├── assets/
│           │   ├── css/                # Stylesheet tambahan & animasi
│           │   ├── js/                 # Script interaktif (Navbar, Language Switcher ID/EN, FAQ, Lightbox, Contact Form)
│           │   └── images/             # Seluruh aset gambar & logo resmi dari repo sumber
│           └── inc/
│               ├── default-data.php    # Data terjemahan ID/EN, Layanan, Nilai RICCIEP, FAQ, Testimoni, & Artikel Awal
│               ├── customizer.php      # Pengaturan mudah bagi orang awam lewat WP Admin -> Appearance -> Customize
│               ├── admin-settings.php  # Panel Admin NH (Kelola Konten, Pesan Masuk Kontak, One-Click Importer, Sync API)
│               ├── meta-boxes.php      # Custom Fields Artikel (Supporting Images, Kategori, Penulis) & Layanan
│               └── elementor.php       # Dukungan & Custom Widgets untuk Elementor Versi Gratis
├── docs/
│   ├── INSTALL-WORDPRESS-VPS.md        # Panduan instalasi WordPress dari nol di VPS Ubuntu 24.04 (kantor@VM-4-28-ubuntu)
│   ├── INSTALL-NH-CUSTOM-THEME.md      # Panduan instalasi tema via WP Admin & SSH/WP-CLI
│   ├── CONTENT-MANAGEMENT-GUIDE.md     # Panduan edit konten, artikel, dan penggunaan Elementor untuk tim non-teknis
│   └── TESTING-AND-ROLLBACK-CHECKLIST.md # Checklist pengujian menyeluruh & prosedur rollback
└── migration-docs/
    ├── 00-project-decisions.md         # Rangkuman keputusan wawancara & spesifikasi VPS
    ├── 01-git-workflow.md              # Dokumentasi alur kerja Git ini
    ├── 02-source-audit.md              # Audit menyeluruh kode sumber Next.js
    └── 03-asset-inventory.md           # Inventaris seluruh aset gambar, video, font, dan ikon
```

---

## 4. Kebijakan Keamanan Commit & Secret Scanning

Sebelum melakukan `git commit` dan `git push`, pemeriksaan wajib dilakukan terhadap:
1. File `.gitignore` memastikan direktori referensi `_source_web_nh/` dan `_target_check/` tidak ikut ter-commit.
2. Tidak ada file `.env`, password SMTP (`SMTP_PASS`), password database, maupun SSH private key di dalam kode.
3. Konfigurasi SMTP di WordPress disediakan melalui halaman pengaturan aman di WP Admin (disimpan di tabel `wp_options` database atau `wp-config.php` di server, bukan di-hardcode di dalam Git).
