# Checklist Pengujian Staging & Prosedur Rollback (`wp.narasumberhukum.online`)

Gunakan checklist di bawah ini setelah Anda memasang WordPress dan mengaktifkan tema `nh-custom` di server staging `wp.narasumberhukum.online` sebelum mempertimbangkan cutover di masa mendatang.

---

## A. Checklist Isolasi & Keamanan Produksi (Wajib Lulus 100%)

- [ ] **1. Aplikasi PM2 Tetap Online:** Jalankan `pm2 list` di VPS dan pastikan ke-7 aplikasi (`web-nh`, `absen-karyawan`, `absen-manajemen`, `absen-ptbjk`, `absensi-ptmip`, `dashboard`, `web-seleco`) berstatus `online`.
- [ ] **2. Website Produksi Utama Tidak Terganggu:** Buka `https://narasumberhukum.com` dan pastikan tetap berjalan normal dari aplikasi Next.js.
- [ ] **3. Tidak Ada Port Bentrok:** Port `8088` (dan socket `/run/php/php8.4-fpm.sock`) tidak menyentuh port `3000`, `3001`, `3005`, `3008`, `3028`, `3325`, `5001`, maupun `8000`.
- [ ] **4. Pencegahan Indeks Google di Staging:** Header HTTP mengembalikan `X-Robots-Tag: noindex, nofollow` pada domain staging `wp.narasumberhukum.online`.

---

## B. Checklist Visual & Halaman (Kesamaan 1:1 dengan Next.js)

- [ ] **1. Beranda (`/`):**
  - [ ] Video background Hero berputar otomatis (autoplay, loop, muted) dengan overlay gelap dan teks Putih-Emas.
  - [ ] Navbar transparan di posisi paling atas, lalu berubah menjadi warna gelap (`#0A0A0B`) saat halaman digulir ke bawah.
  - [ ] Seksi **Layanan Unggulan** menampilkan 3 kartu dengan efek zoom gambar dan deskripsi saat kursor diarahkan (hover).
  - [ ] Seksi **Mengapa Memilih Kami?** menampilkan 4 kartu keunggulan.
  - [ ] Seksi **Nilai-nilai Kami (RICCIEP)** menampilkan animasi pola latar belakang, watermark `RICCIEP`, dan garis timeline vertikal 7 nilai (`R-I-C-C-I-E-P`).
  - [ ] Seksi **Testimoni Klien** menampilkan 4 kartu testimoni.
  - [ ] Seksi **Alur Penanganan Perkara** menampilkan langkah `01` s/d `04`.
  - [ ] Seksi **Pertanyaan Populer (FAQ)** dapat dibuka-tutup (accordion) saat diklik.
  - [ ] Seksi **CTA Quote** & **Hubungi Kami** tampil rapi beserta formulir kontak.
- [ ] **2. Halaman Tentang Kami (`/tentang`):**
  - [ ] Menampilkan Hero Tentang Kami, 4 paragraf profil Narasumber Hukum, Visi Kami, 6 kartu Misi Kami, 33 daftar Ruang Lingkup Penanganan Perkara, dan 3 kartu Logo Partner (`logo-narasumber-hukum.png`, `logo-seleco.png`, `logo-mti-talenstory.jpg`).
- [ ] **3. Halaman Layanan (`/services` & `/services/{slug}`):**
  - [ ] `/services` menampilkan 3 kartu layanan.
  - [ ] `/services/hukum` menampilkan rincian 33 perkara litigasi & non-litigasi.
  - [ ] `/services/perizinan` menampilkan 4 accordion `<details>` perizinan 18 kementerian.
  - [ ] `/services/pelatihan-sdm` menampilkan 3 program pengembangan Human Capital.
- [ ] **4. Halaman Artikel & Detail Artikel (`/artikel` & `/artikel/{slug}`):**
  - [ ] `/artikel` menampilkan Featured Article di atas, 3-column grid di tengah, daftar Artikel Lainnya di kiri bawah, dan filter Kategori di kanan bawah.
  - [ ] Klik tombol filter kategori menyaring artikel secara instan tanpa reload.
  - [ ] Halaman baca artikel (`/artikel/{slug}`) menampilkan gambar utama, isi artikel, gambar pendukung di sidebar kanan (Newspaper Layout), fitur klik perbesar gambar (Lightbox), Artikel Terkait, dan kotak CTA Konsultasi.
- [ ] **5. Halaman Kontak (`/kontak`):**
  - [ ] Menampilkan informasi alamat kantor, nomor telepon/WA, email, dan formulir kontak.

---

## C. Checklist Fungsional & Admin

- [ ] **1. Tombol Ganti Bahasa (`ID` / `EN`) di Kiri Bawah:**
  - [ ] Saat diklik, seluruh teks navigasi, tombol, seksi halaman, dan isi artikel berganti antara Bahasa Indonesia dan Bahasa Inggris secara instan, serta tersimpan di `localStorage`.
- [ ] **2. Tombol Floating WhatsApp di Kanan Bawah:**
  - [ ] Mengarah ke `https://wa.me/6282211020022` dengan teks pesan pembuka otomatis.
- [ ] **3. Pengiriman Formulir Kontak:**
  - [ ] Mengisi dan mengirim formulir menampilkan pesan sukses hijau (`Pesan Terkirim!`).
  - [ ] Data pesan masuk tercatat di menu **WP Admin → Pesan Kontak**.
- [ ] **4. Kemudahan Edit di WP Admin:**
  - [ ] Perubahan di **Appearance → Customize → Pengaturan Narasumber Hukum** langsung tampil di website.
  - [ ] Perubahan FAQ & Testimoni di menu **Narasumber Hukum** langsung tampil di Beranda.
  - [ ] Penambahan artikel baru di menu **Posts → Add New** langsung tampil di `/artikel`.

---

## D. Prosedur Rollback Darurat

1. **Rollback Konfigurasi Nginx (Kurang dari 10 detik):**
   ```bash
   sudo rm -f /etc/nginx/sites-enabled/wp.narasumberhukum.online
   sudo nginx -t && sudo systemctl reload nginx
   ```
2. **Rollback Tema WordPress:**
   - Masuk ke **WP Admin → Appearance → Themes** dan aktifkan tema standar, atau pulihkan folder backup `nh-custom.bak` di `/var/www/wp.narasumberhukum.online/wp-content/themes/`.
3. **Rollback Database Staging:**
   ```bash
   mysql -u wp_nh_user -p'GantiPasswordKuat2026!' wp_nh_staging < ~/backups-wp-nh/wp_nh_staging_YYYY-MM-DD.sql
   ```
