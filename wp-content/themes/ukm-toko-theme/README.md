# UKM Toko Theme - WordPress Custom Child Theme

**UKM Toko Theme** adalah tema child kustom WordPress yang dibangun berbasis Underscores (`_s`) dengan dukungan penuh WooCommerce, Gutenberg Custom Blocks, Advanced Custom Fields (ACF), Custom Post Types (CPT), serta optimasi performa dan SEO teknikal.

Tema ini dirancang khusus untuk operasional toko retail sembako dan UMKM dengan katalog produk cepat, navigasi responsif, dan alur checkout terintegrasi.

---

## Fitur Utama

### 1. Template Hierarchy & Layout
- **Custom Homepage (`front-page.php`)**: Memuat hero banner, kategori pilihan sembako, grid produk unggulan, artikel terkini, dan slider testimoni.
- **Classic Loop Blog (`index.php`)**: Arsip pos blog dengan pagination dinamis (`the_posts_pagination`).
- **Single Post (`single.php`)**: Layout artikel bersih dengan navigasi postingan sebelumnya/berikutnya.
- **Custom Post Type Produk (`archive-produk.php`, `single-produk.php`)**: Katalog produk CPT dengan filter taksonomi, spesifikasi ACF, status stok, dan related items.
- **WooCommerce Integration (`woocommerce/archive-product.php`, `woocommerce/single-product.php`, `taxonomy-product_cat.php`)**: Kompatibilitas penuh katalog belanja WooCommerce, galeri lightbox/zoom/slider, dan mini-cart header.

### 2. Custom Post Types & Taxonomies
- **CPT Produk (`produk`)**: Mendukung nama, deskripsi, thumbnail, harga, stok, dan spesifikasi.
- **CPT Klien (`klien`)**: Direktori mitra/klien dengan metadata email, nomor telepon, dan lokasi operasional.
- **Taksonomi Kategori Produk (`kategori-produk`)**: Taksonomi kustom untuk pengelompokan komoditas sembako.

### 3. Gutenberg Custom Blocks
- `ukm/hero-banner`: Banner promosi utama dengan headline, sub-headline, CTA button, dan gambar latar.
- `ukm/product-grid`: Grid etalase produk interaktif dengan pilihan jumlah produk dan kolom responsif.
- `ukm/testimonial-slider`: Slider carousel testimoni pelanggan interaktif berbasis JavaScript murni (vanilla JS).

### 4. Advanced Custom Fields (ACF) Integration
- Group field spesifikasi detail produk (berat, merek, produsen).
- Field harga dan stok fisik.
- Settings page fallback untuk informasi kontak toko (WhatsApp, alamat fisik, jam operasional).

### 5. Optimasi Performa & Kecepatan (PageSpeed 95+)
- Output HTML Minification melalui output buffering filter.
- Aset terkompresi: `style.min.css` dan `main.min.js`.
- Inline Critical CSS & Resource Preloading (`style.min.css`).
- Native Image Lazy Loading (`loading="lazy"`).
- Browser caching headers & GZIP compression (`.htaccess`).
- Dukungan CDN image offloading hook (`UKM_CDN_DOMAIN`).

### 6. SEO & Keamanan
- Schema Markup JSON-LD terintegrasi: `LocalBusiness`, `Organization`, dan `Product`.
- Breadcrumbs NavXT terpasang di seluruh halaman produk dan arsip.
- Open Graph & Twitter Card meta tags.
- XML Sitemap dinamis didukung Rank Math SEO.
- Server & Form Hardening: Pembatasan panjang input anti-DoS, validasi ketat kuantitas keranjang (anti-negatif, max 20 unit, cek stok riil), regex nomor WhatsApp, dan proteksi akses `xmlrpc.php`.

---

## Struktur Berkas Tema

```text
ukm-toko-theme/
├── 404.php
├── archive-produk.php
├── archive.php
├── footer-shop.php
├── footer.php
├── front-page.php
├── functions.php
├── header-shop.php
├── header.php
├── index.php
├── page.php
├── single-produk.php
├── single.php
├── style.css
├── style.min.css
├── taxonomy-kategori-produk.php
├── taxonomy-product-cat.php
├── taxonomy-product_cat.php
├── taxonomy-product_tag.php
├── inc/
│   ├── acf-fields.php
│   ├── blocks.php
│   ├── cpt-taxonomy.php
│   ├── customizer.php
│   ├── performance.php
│   ├── seo.php
│   ├── template-tags.php
│   └── woocommerce.php
├── js/
│   ├── main.js
│   └── main.min.js
└── woocommerce/
    ├── archive-product.php
    └── single-product.php
```

---

## Cara Instalasi

1. Unduh atau clone repository ini ke folder tema WordPress:
   ```bash
   git clone https://github.com/username/wordpress-ukm-theme.git wp-content/themes/ukm-toko-theme
   ```
2. Aktifkan tema melalui dashboard WordPress:
   - Masuk ke **Appearance** -> **Themes**.
   - Pilih **UKM Toko Theme** lalu klik **Activate**.
3. Pastikan plugin pendukung berikut telah aktif:
   - WooCommerce
   - Advanced Custom Fields (ACF)
   - Breadcrumb NavXT
   - Rank Math SEO / Yoast SEO
