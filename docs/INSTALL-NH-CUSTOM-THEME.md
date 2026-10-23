# Panduan Pemasangan & Aktivasi Tema `nh-custom` (`nh-custom-theme.zip`)

Dokumen ini menjelaskan dua metode resmi untuk memasang dan mengaktifkan custom theme **Narasumber Hukum (`nh-custom`)** pada WordPress Anda, baik melalui dashboard visual **WordPress Admin** maupun melalui terminal **SSH / Git**.

---

## Metode A — Melalui WordPress Admin (Direkomendasikan untuk Orang Awam)

1. **Login ke Dashboard WordPress Admin:**
   - Buka `https://wp.narasumberhukum.online/wp-admin` dan masuk menggunakan akun Administrator Anda.
2. **Buka Menu Tema:**
   - Di sidebar kiri, klik **Appearance (Tampilan) → Themes (Tema)**.
3. **Tambah Tema Baru:**
   - Klik tombol **Add New Theme (Tambah Tema Baru)** di bagian atas halaman.
4. **Unggah Paket Tema:**
   - Klik tombol **Upload Theme (Unggah Tema)**.
5. **Pilih File ZIP:**
   - Klik **Choose File**, lalu pilih file `nh-custom-theme.zip` dari komputer Anda.
6. **Instal Tema:**
   - Klik **Install Now (Instal Sekarang)** dan tunggu hingga muncul pesan *"Theme installed successfully"*.
7. **Aktifkan Tema:**
   - Klik tautan **Activate (Aktifkan)**.
8. **Verifikasi Konfigurasi Awal Otomatis:**
   - Saat tema `nh-custom` pertama kali diaktifkan, sistem otomatis membuat:
     - Halaman **Beranda**, **Tentang Kami** (`/tentang`), **Layanan** (`/services`), **Artikel & Edukasi** (`/artikel`), dan **Hubungi Kami** (`/kontak`).
     - 3 Layanan Utama (`/services/hukum`, `/services/perizinan`, `/services/pelatihan-sdm`).
     - 5 Artikel Edukasi Hukum Awal.
   - Masuk ke **Settings → Permalinks**, pastikan opsi **Post name** terpilih, lalu klik **Save Changes**.
   - Buka menu **Narasumber Hukum** di pojok kiri atas WP Admin jika Anda ingin menarik seluruh artikel dari backend API lama atau menekan tombol **Generate / Perbarui Konten Default**.
9. **Periksa Seluruh Halaman & Fitur:**
   - Kunjungi halaman depan (`/`), `/tentang`, `/services`, `/artikel`, `/kontak`, klik tombol ganti bahasa (`ID`/`EN`) di kiri bawah, dan tombol WhatsApp di kanan bawah.

---

## Metode B — Melalui SSH / Git di VPS (`kantor@VM-4-28-ubuntu`)

Metode ini sangat praktis karena Anda dapat langsung meng-clone dari repository Git tujuan (`https://github.com/NIKOCHWERU/wp-nh.git`) atau mengekstrak file ZIP langsung di server.

### 1. Verifikasi Lokasi Direktori WordPress Terlebih Dahulu [PEMERIKSAAN / READ-ONLY]
Jangan pernah menyalin file sebelum memverifikasi document root WordPress Anda:
```bash
ls -la /var/www/wp.narasumberhukum.online/wp-content/themes/
```

### 2. Backup Tema Eksisting Jika Sudah Ada [BACKUP]
Jika folder `nh-custom` sudah ada sebelumnya, buat cadangan terlebih dahulu:
```bash
if [ -d "/var/www/wp.narasumberhukum.online/wp-content/themes/nh-custom" ]; then
    sudo cp -r /var/www/wp.narasumberhukum.online/wp-content/themes/nh-custom \
               /var/www/wp.narasumberhukum.online/wp-content/themes/nh-custom.bak.$(date +%F_%H%M)
fi
```

### 3. Pasang Tema dari Repository Git `wp-nh` atau File ZIP [INSTALASI]

**Opsi 3A — Langsung dari GitHub `https://github.com/NIKOCHWERU/wp-nh.git`:**
```bash
cd /tmp
rm -rf wp-nh-release
git clone --branch main https://github.com/NIKOCHWERU/wp-nh.git wp-nh-release

# Periksa integritas file utama tema sebelum menyalin
ls -la /tmp/wp-nh-release/wp-content/themes/nh-custom/style.css \
       /tmp/wp-nh-release/wp-content/themes/nh-custom/functions.php

# Salin ke direktori tema WordPress staging
sudo cp -r /tmp/wp-nh-release/wp-content/themes/nh-custom /var/www/wp.narasumberhukum.online/wp-content/themes/

# Atur izin kepemilikan file sesuai user web server
sudo chown -R kantor:www-data /var/www/wp.narasumberhukum.online/wp-content/themes/nh-custom
sudo find /var/www/wp.narasumberhukum.online/wp-content/themes/nh-custom -type d -exec chmod 775 {} \;
sudo find /var/www/wp.narasumberhukum.online/wp-content/themes/nh-custom -type f -exec chmod 664 {} \;
```

**Opsi 3B — Mengunggah `nh-custom-theme.zip` dari Komputer Lokal via SCP:**
Di terminal komputer lokal Anda:
```powershell
scp nh-custom-theme.zip kantor@IP_VPS_ANDA:/tmp/
```
Lalu di terminal SSH VPS Anda:
```bash
unzip -t /tmp/nh-custom-theme.zip
sudo unzip -o /tmp/nh-custom-theme.zip -d /var/www/wp.narasumberhukum.online/wp-content/themes/
sudo chown -R kantor:www-data /var/www/wp.narasumberhukum.online/wp-content/themes/nh-custom
```

### 4. Aktivasi Tema (Via WP Admin atau WP-CLI)
- **Via WP Admin:** Buka `/wp-admin` → **Appearance → Themes**, lalu klik **Activate** pada tema **Narasumber Hukum Custom (NH Custom)**.
- **Via WP-CLI (Jika WP-CLI terinstal di VPS):**
  ```bash
  # Periksa ketersediaan WP-CLI terlebih dahulu
  which wp && wp --info

  # Jika tersedia, aktifkan tema pada path yang benar:
  wp theme activate nh-custom --path=/var/www/wp.narasumberhukum.online
  wp rewrite structure '/%postname%/' --path=/var/www/wp.narasumberhukum.online
  wp rewrite flush --path=/var/www/wp.narasumberhukum.online
  ```

---

## Prosedur Rollback ke Tema Sebelumnya

Jika Anda perlu kembali ke tema standar WordPress atau versi cadangan sebelumnya:

1. **Melalui WordPress Admin:**
   - Buka **Appearance → Themes**, lalu klik **Activate** pada tema bawaan (misalnya *Twenty Twenty-Five*).
2. **Melalui SSH (Memulihkan dari Backup):**
   ```bash
   sudo rm -rf /var/www/wp.narasumberhukum.online/wp-content/themes/nh-custom
   sudo mv /var/www/wp.narasumberhukum.online/wp-content/themes/nh-custom.bak.YYYY-MM-DD_HHMM \
           /var/www/wp.narasumberhukum.online/wp-content/themes/nh-custom
   ```
