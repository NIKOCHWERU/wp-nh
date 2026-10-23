# Panduan Lengkap Instalasi WordPress Staging di VPS (`wp.narasumberhukum.online`)

Dokumen ini disusun **khusus dan presisi** berdasarkan hasil audit aktual server VPS Anda (`kantor@VM-4-28-ubuntu`) tanpa mengasumsikan konfigurasi generik.

---

## Ringkasan Lingkungan Server Aktual Anda

| Komponen | Kondisi Aktual di `kantor@VM-4-28-ubuntu` | Strategi Isolasi Aman |
| :--- | :--- | :--- |
| **OS** | Ubuntu 24.04.3 LTS (`noble`) | Menggunakan paket resmi repositori Ubuntu Noble |
| **Web Server** | `nginx/1.24.0` (Port `80` & `443`) | Menggunakan Virtual Host terpisah `/etc/nginx/sites-available/wp.narasumberhukum.online` |
| **PHP & PHP-FPM** | `PHP 8.4.18` (`/run/php/php8.4-fpm.sock`) | Menggunakan Unix Socket `/run/php/php8.4-fpm.sock` (**Tidak memakai port TCP**, sehingga 100% mustahil bentrok dengan PM2/Docker). Tersedia juga opsi blok server port lokal unik (`127.0.0.1:8088`) jika Anda menginginkannya. |
| **Database** | `MariaDB 10.11.13` (`127.0.0.1:3306`, aktif) | Membuat database baru `wp_nh_staging` dan user khusus `wp_nh_user` yang terpisah dari database aplikasi lain |
| **PM2 & Port Aktif** | PM2 menjalankan 7 aplikasi (`web-nh`, `absen-karyawan`, dll.) di port `3000`, `3001`, `3005`, `3008`, `3028`, `3325`, `5001`, Docker di `8000` & mail ports | **Tidak ada satu pun proses PM2 atau Docker yang disentuh, di-restart, atau diubah.** |
| **Direktori Instalasi** | `/var/www/wp.narasumberhukum.online` | Direktori baru yang terpisah sepenuhnya dari `/var/www/web-nh` dan `/var/www/wordpress` lama |

---

## Legenda Jenis Perintah

Setiap langkah di bawah ini diberi label:
- **[PEMERIKSAAN / READ-ONLY]:** Aman dijalankan kapan saja, tidak mengubah sistem.
- **[PERUBAHAN KONFIGURASI]:** Membuat file, database, atau direktori baru.
- **[ROLLBACK / PEMBATALAN]:** Cara membatalkan langkah tersebut jika diperlukan.

---

## LANGKAH 1 — Pengaturan & Pemeriksaan DNS (`wp.narasumberhukum.online`)

### Tujuan
Mengarahkan subdomain `wp.narasumberhukum.online` ke alamat IP publik VPS Anda.

### Tindakan di Panel DNS Domain (`narasumberhukum.online`)
Tambahkan 1 record baru:
- **Type:** `A`
- **Name / Host:** `wp`
- **Value / Target:** *(IP Publik VPS `VM-4-28-ubuntu` Anda)*
- **TTL:** `Auto` atau `300` (Jika menggunakan Cloudflare, matikan awan oranye / pilih **DNS Only** sementara waktu agar proses pembuatan SSL Certbot berjalan lancar).

### Perintah Pemeriksaan [PEMERIKSAAN / READ-ONLY]
```bash
# Cek IP publik VPS Anda
curl -4 ifconfig.me; echo ""

# Verifikasi apakah DNS wp.narasumberhukum.online sudah mengarah ke IP tersebut
dig +short wp.narasumberhukum.online A
```
- **Hasil yang diharapkan:** Output kedua perintah menampilkan alamat IP yang sama.

---

## LANGKAH 2 — Pemeriksaan & Instalasi Ekstensi PHP 8.4 untuk WordPress

### Tujuan
Memastikan PHP 8.4 yang sudah terinstal di VPS memiliki ekstensi wajib WordPress (`php8.4-mysql`, `php8.4-curl`, `php8.4-gd`, `php8.4-mbstring`, `php8.4-xml`, `php8.4-zip`, `php8.4-intl`).

### 1. Perintah Pemeriksaan [PEMERIKSAAN / READ-ONLY]
```bash
php -m | grep -E "mysqli|curl|gd|mbstring|xml|zip|intl"
systemctl status php8.4-fpm --no-pager
```

### 2. Perintah Instalasi Ekstensi (Jika ada yang belum muncul) [PERUBAHAN KONFIGURASI]
```bash
sudo apt update
sudo apt install -y php8.4-fpm php8.4-mysql php8.4-curl php8.4-gd php8.4-mbstring php8.4-xml php8.4-zip php8.4-intl unzip
```

### 3. Verifikasi Keberhasilan
```bash
php -m | grep mysqli && ls -l /run/php/php8.4-fpm.sock
```
- **Hasil yang diharapkan:** Muncul `mysqli` dan file socket `/run/php/php8.4-fpm.sock` tersedia.

---

## LANGKAH 3 — Pembuatan Database & User Khusus WordPress di MariaDB

### Tujuan
Membuat database `wp_nh_staging` dan user `wp_nh_user` yang hanya memiliki akses ke database tersebut (hak akses minimum / *least privilege*), tanpa mengganggu database lain di MariaDB.

### 1. Perintah Pemeriksaan [PEMERIKSAAN / READ-ONLY]
```bash
# Cek daftar database yang sudah ada agar tidak bentrok nama
sudo mysql -e "SHOW DATABASES;"
```

### 2. Perintah Pembuatan Database & User [PERUBAHAN KONFIGURASI]
*(Ganti `GantiPasswordKuat2026!` dengan password pilihan Anda sendiri dan catat untuk Langkah 5)*:
```bash
sudo mysql << 'EOF'
CREATE DATABASE IF NOT EXISTS wp_nh_staging DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'wp_nh_user'@'localhost' IDENTIFIED BY 'GantiPasswordKuat2026!';
GRANT ALL PRIVILEGES ON wp_nh_staging.* TO 'wp_nh_user'@'localhost';
FLUSH PRIVILEGES;
EOF
```

### 3. Verifikasi Keberhasilan [PEMERIKSAAN / READ-ONLY]
```bash
mysql -u wp_nh_user -p'GantiPasswordKuat2026!' -e "SHOW DATABASES;"
```
- **Hasil yang diharapkan:** Menampilkan `wp_nh_staging`.

### 4. Cara Membatalkan / Rollback [ROLLBACK / PEMBATALAN]
```bash
sudo mysql -e "DROP DATABASE IF EXISTS wp_nh_staging; DROP USER IF EXISTS 'wp_nh_user'@'localhost';"
```

---

## LANGKAH 4 — Pembuatan Direktori & Unduh Paket WordPress Resmi

### Tujuan
Membuat direktori `/var/www/wp.narasumberhukum.online` dan mengunduh kode inti WordPress resmi serta memverifikasi integritasnya.

### 1. Perintah Pemeriksaan [PEMERIKSAAN / READ-ONLY]
```bash
ls -ld /var/www/wp.narasumberhukum.online 2>/dev/null || echo "Direktori belum ada (Aman untuk dibuat)"
```

### 2. Perintah Pembuatan Direktori & Unduh WordPress [PERUBAHAN KONFIGURASI]
```bash
# Buat direktori khusus
sudo mkdir -p /var/www/wp.narasumberhukum.online

# Unduh paket WordPress terbaru beserta checksum MD5 resminya di /tmp
cd /tmp
curl -LO https://wordpress.org/latest.tar.gz
curl -LO https://wordpress.org/latest.tar.gz.md5

# Verifikasi keaslian file
echo "$(cat latest.tar.gz.md5)  latest.tar.gz" | md5sum -c -

# Ekstrak ke direktori staging
sudo tar -xzf /tmp/latest.tar.gz --strip-components=1 -C /var/www/wp.narasumberhukum.online

# Atur kepemilikan ke user kantor dan grup www-data (sesuai struktur /var/www VPS Anda)
sudo chown -R kantor:www-data /var/www/wp.narasumberhukum.online
sudo find /var/www/wp.narasumberhukum.online -type d -exec chmod 775 {} \;
sudo find /var/www/wp.narasumberhukum.online -type f -exec chmod 664 {} \;
```

### 3. Verifikasi Keberhasilan [PEMERIKSAAN / READ-ONLY]
```bash
ls -la /var/www/wp.narasumberhukum.online/wp-settings.php
```
- **Hasil yang diharapkan:** File `wp-settings.php` terlihat dengan kepemilikan `kantor www-data`.

### 4. Cara Membatalkan / Rollback [ROLLBACK / PEMBATALAN]
```bash
sudo rm -rf /var/www/wp.narasumberhukum.online
```

---

## LANGKAH 5 — Konfigurasi `wp-config.php` dengan Aman

### Tujuan
Menghubungkan WordPress ke database `wp_nh_staging` dengan Salt Keys acak dan mengunci keamanan file konfigurasi.

### 1. Perintah Pembuatan `wp-config.php` [PERUBAHAN KONFIGURASI]
*(Sesuaikan `GantiPasswordKuat2026!` dengan password database yang Anda buat di Langkah 3)*:
```bash
cd /var/www/wp.narasumberhukum.online
cp wp-config-sample.php wp-config.php

# Set nama database, user, dan password
sed -i "s/database_name_here/wp_nh_staging/" wp-config.php
sed -i "s/username_here/wp_nh_user/" wp-config.php
sed -i "s/password_here/GantiPasswordKuat2026!/" wp-config.php

# Tambahkan pengaturan keamanan & izinkan instalasi tema/plugin langsung tanpa FTP prompt
cat << 'EOF' >> wp-config.php

/* Pengaturan Tambahan Narasumber Hukum Staging */
define( 'FS_METHOD', 'direct' );
define( 'DISALLOW_FILE_EDIT', true );
define( 'WP_MEMORY_LIMIT', '256M' );
EOF

# Amankan izin baca wp-config.php
chmod 640 /var/www/wp.narasumberhukum.online/wp-config.php
chown kantor:www-data /var/www/wp.narasumberhukum.online/wp-config.php
```

### 2. Verifikasi Keberhasilan [PEMERIKSAAN / READ-ONLY]
```bash
php -l /var/www/wp.narasumberhukum.online/wp-config.php
```
- **Hasil yang diharapkan:** `No syntax errors detected in /var/www/wp.narasumberhukum.online/wp-config.php`

---

## LANGKAH 6 — Konfigurasi Virtual Host Nginx (Dengan Port Unik Opsional `8088` + Domain `wp.narasumberhukum.online`)

### Tujuan
Membuat konfigurasi Nginx di `/etc/nginx/sites-available/wp.narasumberhukum.online` yang:
1. Melayani domain `wp.narasumberhukum.online` di port standar `80`/`443`.
2. Sekaligus menyediakan **port internal unik `8088`** (bebas dari seluruh port yang sedang dipakai di VPS Anda: `3000`, `3001`, `3005`, `3008`, `3028`, `3325`, `5001`, `8000`) sehingga Anda juga bisa mengetesnya secara terisolasi penuh tanpa mengganggu proyek mana pun.

### 1. Backup Konfigurasi Nginx Sebelum Perubahan [PEMERIKSAAN / READ-ONLY]
```bash
sudo cp -r /etc/nginx/sites-available /etc/nginx/sites-available.bak.$(date +%F)
sudo ss -tulpn | grep :8088 || echo "Port 8088 kosong dan aman digunakan"
```

### 2. Buat File Virtual Host Nginx [PERUBAHAN KONFIGURASI]
Lokasi file: `/etc/nginx/sites-available/wp.narasumberhukum.online`

```bash
sudo tee /etc/nginx/sites-available/wp.narasumberhukum.online > /dev/null << 'EOF'
server {
    listen 80;
    listen [::]:80;
    # Port unik tambahan (8088) yang tidak bentrok dengan PM2/Docker lain
    listen 8088;

    server_name wp.narasumberhukum.online;
    root /var/www/wp.narasumberhukum.online;
    index index.php index.html index.htm;

    access_log /var/log/nginx/wp.narasumberhukum.online.access.log;
    error_log  /var/log/nginx/wp.narasumberhukum.online.error.log;

    client_max_body_size 64M;

    # Cegah mesin pencari mengindeks domain staging
    add_header X-Robots-Tag "noindex, nofollow" always;

    # Aturan Permalink WordPress (/tentang, /services, /artikel/slug, /kontak)
    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    # Eksekusi PHP melalui PHP 8.4-FPM Unix Socket yang sudah berjalan di VPS Anda
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Keamanan: Blokir akses ke file sensitif (.htaccess, wp-config.php, xmlrpc.php)
    location ~ /\.(?!well-known).* {
        deny all;
    }

    location = /wp-config.php {
        deny all;
    }

    location = /xmlrpc.php {
        deny all;
    }

    # Cache aset statis
    location ~* \.(css|gif|ico|jpeg|jpg|js|png|svg|webp|woff|woff2|mp4)$ {
        expires 30d;
        log_not_found off;
    }
}
EOF
```

### 3. Aktifkan Site & Uji Konfigurasi Nginx Sebelum Reload [PERUBAHAN KONFIGURASI]
```bash
sudo ln -sf /etc/nginx/sites-available/wp.narasumberhukum.online /etc/nginx/sites-enabled/wp.narasumberhukum.online

# WAJIB: Uji sintaks Nginx terlebih dahulu!
sudo nginx -t

# Jika muncul "syntax is ok" dan "test is successful", reload Nginx dengan aman:
sudo systemctl reload nginx
```

### 4. Verifikasi Keberhasilan & Pastikan PM2 Produksi Tetap Jalan [PEMERIKSAAN / READ-ONLY]
```bash
# Cek respons HTTP lokal ke WordPress baru
curl -I -H "Host: wp.narasumberhukum.online" http://127.0.0.1:8088/

# Pastikan seluruh aplikasi PM2 (termasuk web-nh) tetap online
pm2 list
```
- **Hasil yang diharapkan:** `curl` mengembalikan `HTTP/1.1 200 OK` atau `302 Found` (ke `/wp-admin/setup-config.php` / `install.php`), dan `pm2 list` menampilkan semua aplikasi berstatus `online`.

### 5. Cara Membatalkan / Rollback [ROLLBACK / PEMBATALAN]
```bash
sudo rm -f /etc/nginx/sites-enabled/wp.narasumberhukum.online
sudo nginx -t && sudo systemctl reload nginx
```

---

## LANGKAH 7 — Aktivasi HTTPS (SSL Let's Encrypt)

### Tujuan
Mengaktifkan sertifikat SSL resmi gratis untuk `wp.narasumberhukum.online` setelah DNS (Langkah 1) sudah aktif mengarah ke IP VPS.

### 1. Perintah Pemeriksaan [PEMERIKSAAN / READ-ONLY]
```bash
dig +short wp.narasumberhukum.online A
sudo certbot --version
```

### 2. Perintah Aktivasi SSL [PERUBAHAN KONFIGURASI]
```bash
sudo certbot --nginx -d wp.narasumberhukum.online
```

### 3. Verifikasi Keberhasilan [PEMERIKSAAN / READ-ONLY]
```bash
curl -I https://wp.narasumberhukum.online
```
- **Hasil yang diharapkan:** Mengembalikan respons lewat `HTTPS` (`HTTP/2 200` atau `302`) dengan sertifikat Let's Encrypt yang valid.

---

## LANGKAH 8 — Penyelesaian Wizard Awal WordPress & Pencegahan Indeks Mesin Pencari

1. Buka browser dan kunjungi `https://wp.narasumberhukum.online`
2. Isi formulir instalasi awal WordPress:
   - **Site Title:** `Kantor Narasumber Hukum | Sentral Edukasi & Solusi`
   - **Username:** *(Buat username admin Anda, hindari kata `admin`)*
   - **Password:** *(Gunakan password kuat yang digenerate otomatis)*
   - **Your Email:** `hello@narasumberhukum.com`
   - **Search engine visibility:** **Centang** *"Discourage search engines from indexing this site"* (selama masa testing staging).
3. Klik **Install WordPress**, lalu login ke `/wp-admin`.
4. Masuk ke **Settings → Permalinks**, pilih **Post name** (`/%postname%/`), lalu klik **Save Changes**.

---

## LANGKAH 9 — Instalasi & Aktivasi Tema `nh-custom`

Ikuti panduan lengkap di dokumen `docs/INSTALL-NH-CUSTOM-THEME.md`:
1. Masuk ke **Appearance → Themes → Add New Theme → Upload Theme**.
2. Pilih file `nh-custom-theme.zip` lalu klik **Install Now** dan **Activate**.
3. Begitu diaktifkan, tema akan **secara otomatis membuat**:
   - Halaman **Beranda**, **Tentang Kami** (`/tentang`), **Layanan** (`/services`), **Artikel & Edukasi** (`/artikel`), dan **Hubungi Kami** (`/kontak`).
   - 3 Layanan Utama (`/services/hukum`, `/services/perizinan`, `/services/pelatihan-sdm`).
   - 5 Artikel Edukasi Hukum Awal.
4. Anda juga dapat membuka menu **Narasumber Hukum** di pojok kiri atas WP Admin untuk menarik seluruh artikel dari backend API lama Anda hanya dengan 1 klik!

---

## LANGKAH 10 — Troubleshooting Error Umum

1. **Error `413 Request Entity Too Large` saat upload ZIP tema:**
   - Pastikan baris `client_max_body_size 64M;` sudah ada di `/etc/nginx/sites-available/wp.narasumberhukum.online` dan jalankan:
     ```bash
     sudo sed -i 's/^upload_max_filesize.*/upload_max_filesize = 64M/' /etc/php/8.4/fpm/php.ini
     sudo sed -i 's/^post_max_size.*/post_max_size = 64M/' /etc/php/8.4/fpm/php.ini
     sudo systemctl reload php8.4-fpm nginx
     ```
2. **Halaman `/tentang`, `/services`, atau `/artikel` menampilkan 404 Not Found:**
   - Masuk ke **WP Admin → Settings → Permalinks**, klik tombol **Save Changes** untuk me-refresh aturan rewrite, dan pastikan blok `location / { try_files $uri $uri/ /index.php?$args; }` sudah terpasang di konfigurasi Nginx.
3. **WordPress meminta kredensial FTP saat menginstal tema/plugin:**
   - Pastikan `define( 'FS_METHOD', 'direct' );` sudah ada di `wp-config.php` dan kepemilikan direktori adalah `sudo chown -R www-data:www-data /var/www/wp.narasumberhukum.online/wp-content`.

---

## LANGKAH 11 — Prosedur Backup & Rollback Penuh

### A. Backup Database & File Staging WordPress
```bash
mkdir -p ~/backups-wp-nh
mysqldump -u wp_nh_user -p'GantiPasswordKuat2026!' wp_nh_staging > ~/backups-wp-nh/wp_nh_staging_$(date +%F).sql
tar -czf ~/backups-wp-nh/wp_nh_files_$(date +%F).tar.gz -C /var/www wp.narasumberhukum.online
```

### B. Rollback Penuh (Menghapus Staging WordPress Tanpa Menyentuh Produksi Next.js)
Jika suatu saat Anda ingin menghapus instalasi staging WordPress ini secara menyeluruh:
```bash
# 1. Lepas konfigurasi Nginx staging & reload
sudo rm -f /etc/nginx/sites-enabled/wp.narasumberhukum.online
sudo nginx -t && sudo systemctl reload nginx

# 2. Hapus direktori staging
sudo rm -rf /var/www/wp.narasumberhukum.online

# 3. Hapus database staging
sudo mysql -e "DROP DATABASE IF EXISTS wp_nh_staging; DROP USER IF EXISTS 'wp_nh_user'@'localhost';"
```
Website utama `narasumberhukum.com` (di `/var/www/web-nh` dan PM2 `web-nh`) tidak akan terpengaruh sedikit pun.
