# Panduan Pengelolaan Konten Website Narasumber Hukum (Untuk Tim & Orang Awam)

Tema **Narasumber Hukum (`nh-custom`)** dirancang khusus agar tim Anda dapat mengelola seluruh artikel, layanan, teks halaman, nomor WhatsApp, alamat kantor, FAQ, testimoni, maupun menambahkan blok visual menggunakan **Elementor (Versi Gratis)** tanpa perlu menyentuh kode sedikit pun.

---

## 1. Mengelola Artikel & Edukasi Hukum (`/artikel`)

Seluruh sistem manajemen artikel dari aplikasi full-stack sebelumnya kini berada langsung di menu **Posts (Pos / Artikel)** di sidebar kiri WordPress Admin:

1. **Menulis Artikel Baru:**
   - Klik **Posts → Add New Post**.
   - **Judul Artikel:** Ketik judul artikel di bagian paling atas.
   - **Isi Artikel:** Tulis paragraf, subjudul (`Heading 2`, `Heading 3`), poin-poin (`List`), atau sisipkan gambar di dalam editor visual.
   - **Kategori Artikel:** Di panel sebelah kanan, centang atau tambah **Categories** (misalnya: *Bisnis*, *Litigasi*, *Kontrak*, *Edukasi*, *Keluarga*).
   - **Gambar Utama (Featured Image):** Di panel sebelah kanan, klik **Set featured image** untuk mengunggah foto dari komputer Anda, ATAU tempelkan link gambar di kotak **Pengaturan Artikel Narasumber Hukum → URL Gambar Utama** di bawah editor.
   - **Gambar Pendukung Koran/Sidebar (Newspaper Layout):**
     - Di bagian bawah editor, terdapat kotak **Gambar Pendukung Sidebar (Newspaper Layout)**.
     - Anda dapat memasukkan 1 atau lebih URL gambar pendukung beserta **Caption / Keterangan Gambar** (dan klik **+ Tambah Baris Gambar Pendukung** jika ingin menambah foto lagi).
     - Jika bagian ini diisi, halaman baca artikel otomatis berubah menjadi tata letak koran (2 kolom: teks utama di kiri, deretan foto pendukung + caption yang bisa di-zoom lightbox di kanan).
   - Klik tombol **Publish (Terbitkan)** di kanan atas.

2. **Menarik Artikel dari Sistem Lama (One-Click API Sync):**
   - Buka menu **Narasumber Hukum** di pojok kiri atas WP Admin.
   - Pada bagian **2. Migrasi Artikel dari Full-Stack API Lama**, pastikan URL API terisi (misalnya `https://api.narasumberhukum.com`), lalu klik **Tarik & Impor Artikel dari API**.
   - Seluruh artikel, kategori, tanggal terbit, dan gambar pendukung akan langsung masuk ke WordPress secara otomatis!

---

## 2. Mengubah Teks Hero, Video, Nomor WhatsApp, Alamat Kantor, & Sosmed (Live Preview)

Untuk mengubah tampilan utama sambil melihat perubahannya secara langsung (*Live Preview*):

1. Di WP Admin, klik **Appearance (Tampilan) → Customize (Sesuaikan)**.
2. Klik menu **Pengaturan Narasumber Hukum (Live Edit)**.
3. Anda akan menemukan 3 bagian yang sangat mudah diisi:
   - **1. Hero Beranda & Video:** Ubah judul baris 1 (putih), judul baris 2 (emas), subjudul, dan URL video background MP4.
   - **2. Nomor WhatsApp, Email & Sosmed:** Ubah nomor WhatsApp Admin (`6282211020022`), Advisor (`6282144424311`), nomor WA CTA Artikel, Email Resmi (`hello@narasumberhukum.com`), link Google Maps, Instagram, Facebook, dan LinkedIn.
   - **3. Alamat Kantor & Footer:** Ubah nama & alamat Kantor I (Jakarta), Kantor II (Bali), Kantor III (Karawang), serta jam operasional.
4. Klik tombol **Publish (Terbitkan)** di bagian atas.

---

## 3. Mengelola FAQ (Pertanyaan Populer), Testimoni Klien, & SMTP Email

1. Di sidebar kiri WP Admin, klik menu **Narasumber Hukum**.
2. Gulir ke bawah ke bagian:
   - **3. Edit Pertanyaan Populer (FAQ Beranda):** Ubah atau tambahkan pertanyaan dan jawaban baru.
   - **4. Edit Testimoni Klien:** Ubah atau tambahkan nama klien, jabatan/peran, dan isi kutipan testimoni.
   - **5. Pengaturan SMTP Email Formulir Kontak:** Masukkan host SMTP (`mail.narasumberhukum.com`), port (`465`), email, dan password jika ingin mengaktifkan pengiriman email langsung melalui server mail Anda.
3. Klik tombol emas **Simpan Seluruh Perubahan**.

---

## 4. Melihat Pesan Masuk dari Formulir Konsultasi Kontak

Setiap kali pengunjung mengisi formulir di halaman Beranda atau halaman `/kontak`:
1. Pesan tersebut **otomatis tersimpan** di menu **Pesan Kontak** di sidebar kiri WordPress Admin (lengkap dengan Nama, Email, Nomor WhatsApp, Subjek, dan Isi Pesan).
2. Notifikasi email juga dikirimkan ke alamat email resmi kantor.

---

## 5. Mengelola Layanan Hukum (`/services` & `/services/{slug}`)

1. Di sidebar kiri WP Admin, klik menu **Layanan Hukum**.
2. Anda akan melihat 3 layanan utama (*Bidang Hukum*, *Bidang Perizinan...*, dan *Pengembangan & Pelatihan SDM*) atau dapat menambah layanan baru lewat **Tambah Layanan**.
3. Di dalam halaman edit layanan:
   - Editor utama berisi rincian lengkap layanan (Bahasa Indonesia).
   - Di kotak bawah (**Detail Layanan Narasumber Hukum**), Anda dapat memilih ikon (`Scale`, `FileText`, `ShieldCheck`, `Lightbulb`), gambar kartu layanan, deskripsi singkat kartu, serta terjemahan Bahasa Inggrisnya.

---

## 6. Menggunakan Elementor (Versi Gratis)

Tema `nh-custom` 100% kompatibel dengan plugin **Elementor (Versi Gratis)**:
1. Anda dapat menginstal plugin **Elementor** gratis dari menu **Plugins → Add New Plugin → cari "Elementor" → Install & Activate**.
2. Saat mengedit halaman baru atau halaman yang ada dengan klik **Edit with Elementor**, buka kategori widget **Narasumber Hukum (NH Custom)** di panel kiri Elementor:
   - **NH — Hero Video Banner**
   - **NH — Formulir Konsultasi Hukum** (atau gunakan shortcode `[nh_contact_form]`)
   - **NH — Banner CTA Konsultasi WhatsApp** (atau gunakan shortcode `[nh_consultation_cta]`)
3. Anda bebas melakukan drag-and-drop komponen Elementor tanpa merusak Navbar, Footer, maupun tombol WhatsApp & Bahasa bawaan tema.
