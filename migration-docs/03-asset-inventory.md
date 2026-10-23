# 03 — Asset Inventory & Media Mapping

Dokumen ini mendata seluruh aset statis (gambar, ikon, favicon, logo partner) dan aset eksternal (video, font, tekstur, ilustrasi) dari repository sumber `web-nh` beserta lokasi migrasinya di tema WordPress `nh-custom`.

---

## 1. Aset Lokal di `public/` (Dimigrasikan ke `wp-content/themes/nh-custom/assets/images/`)

| File Sumber (`web-nh/public/`) | Ukuran | Kegunaan | Lokasi di Tema WordPress (`nh-custom`) |
| :--- | :--- | :--- | :--- |
| `logo.png` | 826.3 KB | Logo utama Navbar, Footer, OpenGraph | `assets/images/logo.png` |
| `logo-narasumber-hukum.png` | 55.5 KB | Logo kartu Partner 1 (Halaman Tentang Kami) | `assets/images/logo-narasumber-hukum.png` |
| `logo-seleco.png` | 367.9 KB | Logo kartu Partner 2 — Sleco Project | `assets/images/logo-seleco.png` |
| `logo-mti-talenstory.jpg` | 9.5 KB | Logo kartu Partner 3 — PT Teira Dwan Indonesia | `assets/images/logo-mti-talenstory.jpg` |
| `favicon.ico` | 4.3 KB | Favicon browser standar | `assets/images/favicon.ico` |
| `favicon.png` | 826.3 KB | Favicon PNG resolusi tinggi | `assets/images/favicon.png` |
| `icon.png` | 826.3 KB | Apple Touch Icon (1024x1024) | `assets/images/icon.png` |
| `icon-192.png` | 35.9 KB | Web App Manifest / Icon (192x192) | `assets/images/icon-192.png` |
| `icon-32.png` | 2.4 KB | Favicon kecil (32x32) | `assets/images/icon-32.png` |
| `globe.svg` | 1.0 KB | Ikon SVG | `assets/images/globe.svg` |
| `file.svg` | 0.4 KB | Ikon SVG | `assets/images/file.svg` |
| `window.svg` | 0.4 KB | Ikon SVG | `assets/images/window.svg` |

---

## 2. Aset Media & CDN Eksternal yang Digunakan di Source Code

Seluruh URL media di bawah ini dipertahankan secara default di dalam tema dan **dapat diganti kapan saja melalui WordPress Admin Customizer / Media Library** tanpa menyentuh kode:

| Jenis Aset | Lokasi / Komponen | URL Sumber | Dapat Diedit di WP Admin? |
| :--- | :--- | :--- | :--- |
| **Hero Background Video** | Homepage Hero (`#home`) | `https://res.cloudinary.com/dysw7tjks/video/upload/v1756377208/Desain_tanpa_judul_oeaojq.mp4` | **Ya** (Bisa upload file MP4 ke Media Library atau ganti URL video) |
| **Gambar Layanan 1 (Hukum)** | Homepage & `/services` | `https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80` | **Ya** (Featured Image di CPT Layanan / Pengaturan Tema) |
| **Gambar Layanan 2 (Perizinan)** | Homepage & `/services` | `https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=800&q=80` | **Ya** |
| **Gambar Layanan 3 (SDM)** | Homepage & `/services` | `https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80` | **Ya** |
| **Hero Background Tentang Kami** | `/tentang` Hero | `https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=1920&q=80` | **Ya** |
| **Background Seksi Visi** | `/tentang` Visi | `https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1920&q=80` | **Ya** |
| **Background Seksi Partner** | `/tentang` Partner | `https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80` | **Ya** |
| **Pattern Cubes** | Nilai-nilai RICCIEP, CTA, Kategori Artikel | `https://www.transparenttextures.com/patterns/cubes.png` | **Ya** |
| **Pattern Diagmonds** | Tentang Kami & Ruang Lingkup | `https://www.transparenttextures.com/patterns/diagmonds-light.png` | **Ya** |

---

## 3. Tipografi & Ikon

1. **Google Fonts:**
   - `Inter` (Weights: 300, 400, 500, 600, 700, 900) — digunakan sebagai `--font-sans`
   - `Playfair Display` (Weights: 400, 700) — digunakan sebagai `--font-serif` (Judul brand `NARASUMBER HUKUM`)
2. **Sistem Ikon SVG:**
   - Seluruh ikon `lucide-react` (`Scale`, `FileText`, `ShieldCheck`, `Lightbulb`, `Phone`, `Mail`, `MapPin`, `CheckCircle`, `ChevronDown`, `ChevronUp`, `Heart`, `Zap`, `MessageCircle`, `Rocket`, `Target`, `Globe`, `Menu`, `X`, `ArrowRight`, `ArrowLeft`, `Calendar`, `User`, `Tag`, `Clock`, `Send`, `Instagram`, `Facebook`, `Linkedin`) dan `FaWhatsapp` dirender sebagai **inline SVG ringan** di dalam fungsi helper PHP tema `nh_icon($name, $size, $class)` sehingga tidak membebani waktu muat halaman dan tampil 100% identik dengan versi React.
