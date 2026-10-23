# 00 — Project Decisions & Architecture Confirmation

Dokumen ini mencatat seluruh keputusan hasil wawancara Fase 1 & Fase 2 bersama pemilik proyek, serta hasil pemeriksaan awal kondisi VPS (read-only).

---

## 1. Repository Git

| Parameter | Nilai / Keputusan |
| :--- | :--- |
| **Repository Sumber (Next.js)** | `https://github.com/NIKOCHWERU/web-nh` |
| **Status Repo Sumber** | Public (Read-Only, **dilarang keras mengubah atau push ke repo ini**) |
| **Branch Sumber** | `main` |
| **Repository Tujuan (WordPress)** | `https://github.com/NIKOCHWERU/wp-nh` |
| **Status Repo Tujuan** | Sudah dibuat oleh pemilik proyek dan masih kosong |
| **Branch Tujuan** | `main` |

---

## 2. Domain & Keamanan Staging

| Parameter | Nilai / Keputusan |
| :--- | :--- |
| **Domain Staging** | `wp.narasumberhukum.online` |
| **Status DNS Saat Ini** | Belum dibuat (Panduan pengaturan A record disertakan di `docs/INSTALL-WORDPRESS-VPS.md`) |
| **Protokol** | HTTPS (Let's Encrypt Certbot setelah DNS mengarah ke VPS) |
| **Domain Produksi** | `narasumberhukum.com` tetap menggunakan aplikasi Next.js (`web-nh` di PM2) tanpa perubahan apa pun |
| **Isolasi Layanan** | Tidak boleh mengganggu PM2 (`absen-karyawan`, `absen-manajemen`, `absen-ptbjk`, `absensi-ptmip`, `dashboard`, `web-nh`, `web-seleco`), tidak mengganggu Docker (port `25`, `465`, `587`, `993`, `8000`), dan tidak mengganggu port Node/Next (`3000`, `3001`, `3005`, `3008`, `3028`, `3325`, `5001`). |

---

## 3. Spesifikasi Server VPS (Hasil Audit Read-Only)

Berdasarkan output terminal VPS `kantor@VM-4-28-ubuntu`:

- **Sistem Operasi:** Ubuntu 24.04.3 LTS (`noble`)
- **Web Server:** `nginx/1.24.0 (Ubuntu)` (Berjalan di port `80` dan `443`)
- **PHP & PHP-FPM:** `PHP 8.4.18` dengan socket aktif di `/run/php/php8.4-fpm.sock` (Sangat optimal, tidak memakan port TCP sehingga 100% bebas bentrok dengan PM2/Node.js, atau opsional dapat di-bind ke port lokal unik jika diinginkan)
- **Database:** `MariaDB 10.11.13` (`127.0.0.1:3306`, status `active (running)`)
- **User Sistem:** `kantor` dengan grup `www-data`
- **Direktori Web Eksisting:** `/var/www/` (Saat ini ada `/var/www/web-nh` untuk Next.js dan `/var/www/wordpress` lama; untuk staging ini kita gunakan direktori terpisah `/var/www/wp.narasumberhukum.online` agar 100% bersih dan tidak menimpa folder apa pun)
- **Virtual Host Nginx:** `/etc/nginx/sites-available/wp.narasumberhukum.online` -> `/etc/nginx/sites-enabled/wp.narasumberhukum.online`

---

## 4. Tampilan, Fitur, & Pengelolaan Konten WordPress

1. **Nama & Slug Tema:** `nh-custom` (File paket distribusi: `nh-custom-theme.zip`).
2. **Kesamaan Visual & Fungsional:**
   - Mempertahankan 100% desain, warna, tipografi, animasi, layout responsif, navigasi, tombol WhatsApp, formulir konsultasi, dan metadata SEO dari versi Next.js (`web-nh`).
3. **Kemudahan Edit bagi Orang Awam (Hybrid: WP Admin Customiser/Meta Boxes + Elementor Free Ready):**
   - **Panel Pengaturan Tema (NH Theme Settings / Customizer):** Mengubah teks Hero, Tentang Kami, Layanan, Statistik, Testimoni, FAQ, Kontak, Nomor WhatsApp, Alamat, Jam Operasional, dan Footer langsung melalui form yang rapi tanpa risiko merusak desain.
   - **Dukungan Elementor Gratis:** Tema mendaftarkan dukungan penuh Elementor (`elementor-Full-Width`, custom Elementor widgets untuk setiap seksi Narasumber Hukum, dan shortcode) sehingga tim juga bebas mengedit halaman menggunakan drag-and-drop **Elementor (Versi Gratis)**.
4. **Migrasi Full-Stack Artikel & Konten:**
   - Seluruh sistem manajemen artikel/berita/edukasi hukum dari versi full-stack Next.js dimigrasikan ke sistem **Artikel WordPress (Posts & Custom Post Types/Taxonomies)** lengkap dengan dukungan kategori, gambar thumbnail, penulis, waktu baca, dan fitur **One-Click Default Content & Article Importer/Seeder** di WP Admin.
5. **Penggunaan Plugin:**
   - Seminimal mungkin plugin. Seluruh fungsi inti (Custom Fields, CPT, SEO Meta, WhatsApp CTA, Form Handler, Elementor Widgets) sudah tertanam langsung di dalam tema `nh-custom` tanpa ketergantungan plugin berbayar.

---

## 5. Daftar Deliverables Proyek

1. `nh-custom-theme.zip` — Paket instalasi tema WordPress siap upload via WP Admin maupun SSH.
2. Source code tema di `/wp-content/themes/nh-custom/` dan seluruh repositori di-push ke `https://github.com/NIKOCHWERU/wp-nh` (branch `main`).
3. Dokumentasi Migrasi (`migration-docs/`):
   - `migration-docs/00-project-decisions.md`
   - `migration-docs/01-git-workflow.md`
   - `migration-docs/02-source-audit.md`
   - `migration-docs/03-asset-inventory.md`
4. Dokumentasi Operasional & Panduan (`docs/`):
   - `docs/INSTALL-WORDPRESS-VPS.md` (Disesuaikan khusus untuk Ubuntu 24.04 + Nginx 1.24 + PHP 8.4-FPM + MariaDB 10.11 milik `kantor@VM-4-28-ubuntu`)
   - `docs/INSTALL-NH-CUSTOM-THEME.md` (Metode WP Admin & SSH/WP-CLI)
   - `docs/CONTENT-MANAGEMENT-GUIDE.md` (Panduan edit konten, artikel, dan Elementor untuk orang awam)
   - `docs/TESTING-AND-ROLLBACK-CHECKLIST.md` (Checklist QA dan prosedur rollback)
