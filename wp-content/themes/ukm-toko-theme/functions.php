<?php
/**
 * UKM Toko Theme functions and definitions
 *
 * @package ukm-toko
 */

// Mencegah akses langsung ke file ini
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'ukm_toko_setup' ) ) {
	/**
	 * Konfigurasi default tema dan registrasi dukungan fitur WordPress.
	 */
	function ukm_toko_setup() {
		// 1. Membiarkan WordPress mengelola tag <title> di dokumen HTML.
		add_theme_support( 'title-tag' );

		// 2. Mengaktifkan fitur Gambar Andalan (Featured Image/Post Thumbnail).
		add_theme_support( 'post-thumbnails' );

		// 3. Meregistrasi lokasi menu navigasi.
		register_nav_menus( array(
			'primary' => esc_html__( 'Menu Utama', 'ukm-toko' ),
			'footer'  => esc_html__( 'Menu Footer', 'ukm-toko' ),
		) );

		// 4. Menggunakan standar HTML5 untuk elemen inti WordPress.
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		) );
	}
}
// Kaitkan fungsi setup ke hook 'after_setup_theme'
add_action( 'after_setup_theme', 'ukm_toko_setup' );

/**
 * Menonaktifkan block-templates FSE dari parent theme Twenty Twenty-Three
 * agar seluruh halaman (Shop, Cart, Checkout, Pages) selalu menggunakan
 * template PHP klasik child theme dengan header, navbar, dan footer utuh.
 */
add_action( 'after_setup_theme', function() {
	remove_theme_support( 'block-templates' );
}, 99 );

if ( ! function_exists( 'ukm_toko_widgets_init' ) ) {
	/**
	 * Registrasi area widget / sidebar tema.
	 */
	function ukm_toko_widgets_init() {
		register_sidebar( array(
			'name'          => esc_html__( 'Header Cart Widget Area', 'ukm-toko' ),
			'id'            => 'header-cart-widget',
			'description'   => esc_html__( 'Area widget untuk mini cart keranjang belanja di header.', 'ukm-toko' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
}
add_action( 'widgets_init', 'ukm_toko_widgets_init' );

if ( ! function_exists( 'ukm_toko_scripts' ) ) {
	/**
	 * Enqueue scripts and styles (Memuat CSS dan JS).
	 */
	function ukm_toko_scripts() {
		// Memuat file style CSS utama (gunakan style.min.css jika tersedia)
		$css_uri = file_exists( get_stylesheet_directory() . '/style.min.css' )
			? get_stylesheet_directory_uri() . '/style.min.css'
			: get_stylesheet_uri();

		wp_enqueue_style( 
			'ukm-toko-style',
			$css_uri,
			array(),
			filemtime( get_theme_file_path( '/style.css' ) )
		);

		// Memuat file main JS untuk navigasi responsif dan interaktivitas
		$js_uri = file_exists( get_stylesheet_directory() . '/js/main.min.js' )
			? get_stylesheet_directory_uri() . '/js/main.min.js'
			: get_stylesheet_directory_uri() . '/js/main.js';

		wp_enqueue_script(
			'ukm-toko-main',
			$js_uri,
			array(),
			file_exists( get_stylesheet_directory() . '/js/main.js' ) ? filemtime( get_stylesheet_directory() . '/js/main.js' ) : '1.0.0',
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}
}
// Kaitkan fungsi ke hook 'wp_enqueue_scripts'
add_action( 'wp_enqueue_scripts', 'ukm_toko_scripts' );

/**
 * Custom template tags for this theme (Underscores _s Standard).
 */
require_once get_stylesheet_directory() . '/inc/template-tags.php';

/**
 * Load Custom Post Types and Taxonomies
 */
require_once get_stylesheet_directory() . '/inc/cpt-taxonomy.php';

/**
 * Load Advanced Custom Fields Registrations
 */
if ( class_exists( 'ACF' ) ) {
	require_once get_stylesheet_directory() . '/inc/acf-fields.php';
}

/**
 * Load Gutenberg Blocks & Styles
 */
require_once get_stylesheet_directory() . '/inc/blocks.php';

/**
 * Load WooCommerce Support & Customizations
 */
if ( class_exists( 'WooCommerce' ) ) {
	require_once get_stylesheet_directory() . '/inc/woocommerce.php';
}

/**
 * Load Performance Optimizations
 */
require_once get_stylesheet_directory() . '/inc/performance.php';

/**
 * Load SEO Optimizations (Schema JSON-LD & Meta Tags)
 */
require_once get_stylesheet_directory() . '/inc/seo.php';

/**
 * Load Customizer Controls
 */
require_once get_stylesheet_directory() . '/inc/customizer.php';
