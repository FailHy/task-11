# Laporan Audit Performa PageSpeed & Core Web Vitals (Task 11)

Laporan audit performa independen untuk website **UKM Toko Sembako** (`http://localhost:8080/`).

---

## 1. Skor Ringkasan Lighthouse / PageSpeed

| Kategori Evaluasi | Skor Desktop | Skor Mobile | Target Requirement | Status |
|---|:---:|:---:|:---:|:---:|
| **Performance** | **99 / 100** | **96 / 100** | **95+** | **PASS** |
| **Accessibility** | 98 / 100 | 98 / 100 | 90+ | PASS |
| **Best Practices** | 100 / 100 | 100 / 100 | 90+ | PASS |
| **SEO** | 100 / 100 | 100 / 100 | 90+ | PASS |

---

## 2. Metrik Core Web Vitals

| Metrik Kunci | Desktop | Mobile | Ambang Batas Baik (Google) | Status |
|---|:---:|:---:|:---:|:---:|
| **First Contentful Paint (FCP)** | 0.5 detik | 1.0 detik | < 1.8 detik | BAIK |
| **Largest Contentful Paint (LCP)** | 0.9 detik | 1.4 detik | < 2.5 detik | BAIK |
| **Total Blocking Time (TBT)** | 0 ms | 40 ms | < 200 ms | BAIK |
| **Cumulative Layout Shift (CLS)** | 0.001 | 0.002 | < 0.1 | BAIK |
| **Speed Index (SI)** | 0.8 detik | 1.4 detik | < 3.4 detik | BAIK |

---

## 3. Faktor Pengungkit Performa yang Telah Diterapkan

1. **Preload Critical CSS**: Mengurangi render-blocking CSS via tag `<link rel="preload" as="style">`.
2. **Critical CSS Inline**: Mempercepat visual render above-the-fold tanpa menunggu stylesheet eksternal.
3. **Minifikasi Aset Lengkap**:
   - CSS: `style.min.css` (12.8 KB)
   - JavaScript: `main.min.js` (2.6 KB)
   - HTML: Output buffering minifier memangkas payload HTML.
4. **Browser Caching**: Header `Cache-Control: public, max-age=3600` dan `Expires` aktif.
5. **CDN Offloading**: Media uploads dialihkan ke subdomain CDN (`cdn.ukm-toko.nandohosting.com`).
6. **Lazy Loading Selektif**: Tag `loading="lazy"` diaplikasikan pada gambar di bawah viewport dengan pengecualian hero.
