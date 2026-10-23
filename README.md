# Migrasi Website Narasumber Hukum ke WordPress (`nh-custom`)

Repositori ini berisi seluruh source code **Custom WordPress Theme (`nh-custom`)**, paket siap pasang **`nh-custom-theme.zip`**, serta dokumentasi lengkap instalasi dan pengelolaan konten hasil migrasi 1:1 dari aplikasi Next.js (`https://github.com/NIKOCHWERU/web-nh`).

---

## Fitur Utama Tema `nh-custom`

1. **Kesamaan Visual & Animasi 100% dengan Versi Next.js:**
   - Mempertahankan seluruh palet warna (`#0A0A0B` Navy, `#C5A059` Gold), tipografi (`Inter` & `Playfair Display`), Hero Video Background, animasi *scroll reveal*, pola bergerak *RICCIEP Values*, *Floating WhatsApp*, serta *Floating Language Switcher (ID/EN)*.
2. **Migrasi Full-Stack Manajemen Artikel & Konten:**
   - Dilengkapi sistem manajemen artikel native WordPress dengan fitur **Newspaper Sidebar Supporting Images** (gambar pendukung + caption), Lightbox foto, filter kategori instan, kalkulasi waktu baca, dan **One-Click API Article Importer** untuk menarik seluruh artikel dari backend API lama.
3. **Ramah Orang Awam + Kompatibel Penuh dengan Elementor (Versi Gratis):**
   - Seluruh teks Hero, Video, Nomor WhatsApp, Alamat 3 Kantor, Jam Operasional, Sosial Media, FAQ, Testimoni, Layanan, dan Artikel dapat diedit dengan mudah melalui form visual di **WordPress Admin** tanpa menyentuh kode.
   - Mendukung penuh drag-and-drop **Elementor Gratis** beserta 3 Custom Widget khusus Narasumber Hukum (`NH — Hero Video Banner`, `NH — Formulir Konsultasi Hukum`, `NH — Banner CTA Konsultasi WhatsApp`).
4. **Formulir Kontak Terintegrasi Database & SMTP:**
   - Setiap pesan dari formulir kontak otomatis tersimpan di menu **WP Admin → Pesan Kontak** dan diteruskan ke email resmi melalui SMTP (`mail.narasumberhukum.com`).

---

## Struktur Direktori & Dokumentasi

- **`nh-custom-theme.zip`** — File tema WordPress siap upload melalui **WP Admin → Appearance → Themes → Add New Theme → Upload Theme**.
- **`wp-content/themes/nh-custom/`** — Source code lengkap tema WordPress `nh-custom`.
- **Dokumentasi Operasional (`docs/`):**
  - [`docs/INSTALL-WORDPRESS-VPS.md`](./docs/INSTALL-WORDPRESS-VPS.md) — Panduan langkah demi langkah instalasi WordPress, MariaDB, PHP 8.4-FPM, Nginx (dengan port unik `8088` & domain `wp.narasumberhukum.online`), serta SSL Let's Encrypt khusus untuk VPS `kantor@VM-4-28-ubuntu`.
  - [`docs/INSTALL-NH-CUSTOM-THEME.md`](./docs/INSTALL-NH-CUSTOM-THEME.md) — Panduan pemasangan tema via WP Admin & SSH/Git.
  - [`docs/CONTENT-MANAGEMENT-GUIDE.md`](./docs/CONTENT-MANAGEMENT-GUIDE.md) — Panduan pengelolaan konten, artikel, layanan, dan Elementor untuk tim non-teknis.
  - [`docs/TESTING-AND-ROLLBACK-CHECKLIST.md`](./docs/TESTING-AND-ROLLBACK-CHECKLIST.md) — Checklist pengujian menyeluruh & prosedur rollback aman.
- **Dokumentasi Arsitektur Migrasi (`migration-docs/`):**
  - [`migration-docs/00-project-decisions.md`](./migration-docs/00-project-decisions.md)
  - [`migration-docs/01-git-workflow.md`](./migration-docs/01-git-workflow.md)
  - [`migration-docs/02-source-audit.md`](./migration-docs/02-source-audit.md)
  - [`migration-docs/03-asset-inventory.md`](./migration-docs/03-asset-inventory.md)
