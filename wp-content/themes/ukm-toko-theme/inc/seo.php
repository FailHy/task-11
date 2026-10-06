<?php
/**
 * Optimasi SEO, Schema JSON-LD, Social Meta & Sitemap Routes
 *
 * @package UKM_Toko_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Menginjeksi Schema JSON-LD LocalBusiness ke wp_head (Requirement 48)
 */
function ukm_toko_inject_local_business_schema() {
	if ( ! is_front_page() && ! is_home() ) {
		return;
	}

	$schema = array(
		'@context'     => 'https://schema.org',
		'@type'        => 'LocalBusiness',
		'name'         => get_bloginfo( 'name' ),
		'image'        => esc_url( get_stylesheet_directory_uri() . '/screenshot.png' ),
		'@id'          => esc_url( home_url( '/' ) ),
		'url'          => esc_url( home_url( '/' ) ),
		'telephone'    => '+6281234567890',
		'priceRange'   => '$$',
		'address'      => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Jl. Merdeka No. 123',
			'addressLocality' => 'Jakarta',
			'postalCode'      => '10110',
			'addressCountry'  => 'ID',
		),
		'openingHoursSpecification' => array(
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ),
				'opens'     => '08:00',
				'closes'    => '20:00',
			),
		),
	);

	echo "<!-- JSON-LD LocalBusiness (UKM Toko) -->\n";
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
}
add_action( 'wp_head', 'ukm_toko_inject_local_business_schema' );

/**
 * 2. Injeksi Open Graph dan Twitter Cards Social Meta (Requirement 49 / Social Meta)
 */
function ukm_toko_inject_social_meta() {
	$title       = wp_get_document_title();
	$site_name   = get_bloginfo( 'name' );
	$description = get_bloginfo( 'description' );
	$url         = home_url( '/' );
	$image       = get_stylesheet_directory_uri() . '/screenshot.png';
	$type        = 'website';

	if ( is_singular() ) {
		$post_id = get_the_ID();
		$title   = get_the_title( $post_id ) . ' - ' . $site_name;
		$url     = get_permalink( $post_id );
		$type    = ( 'product' === get_post_type() || 'produk' === get_post_type() ) ? 'og:product' : 'article';

		if ( has_excerpt( $post_id ) ) {
			$description = get_the_excerpt( $post_id );
		} else {
			$content = wp_strip_all_tags( get_post_field( 'post_content', $post_id ) );
			if ( ! empty( $content ) ) {
				$description = wp_trim_words( $content, 25, '...' );
			}
		}

		if ( has_post_thumbnail( $post_id ) ) {
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large' );
			if ( $thumb ) {
				$image = $thumb[0];
			}
		}
	}

	echo "<!-- Standard SEO Meta -->\n";
	echo '<meta name="description" content="' . esc_attr( $description ) . '" />' . "\n";

	echo "<!-- Open Graph Meta Tags -->\n";
	echo '<meta property="og:locale" content="id_ID" />' . "\n";
	echo '<meta property="og:type" content="' . esc_attr( $type ) . '" />' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $description ) . '" />' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '" />' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '" />' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $image ) . '" />' . "\n";

	echo "<!-- Twitter Card Meta Tags -->\n";
	echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '" />' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '" />' . "\n";
	echo '<meta name="twitter:image" content="' . esc_url( $image ) . '" />' . "\n";
}
add_action( 'wp_head', 'ukm_toko_inject_social_meta', 2 );

/**
 * 3. Injeksi Tag Hreflang (Multilingual Ready)
 */
function ukm_toko_inject_hreflang() {
	if ( ! is_singular() && ! is_front_page() && ! is_home() ) {
		return;
	}
	$url = is_front_page() ? home_url( '/' ) : get_permalink();
	if ( ! $url ) {
		return;
	}
	$lang = str_replace( '_', '-', strtolower( get_locale() ) );
	if ( 'id-id' === $lang ) {
		$lang = 'id';
	}
	
	echo '<link rel="alternate" href="' . esc_url( $url ) . '" hreflang="' . esc_attr( $lang ) . '" />' . "\n";
	echo '<link rel="alternate" href="' . esc_url( $url ) . '" hreflang="x-default" />' . "\n";
}
add_action( 'wp_head', 'ukm_toko_inject_hreflang', 3 );

/**
 * 4. Route Handler untuk XML Sitemaps (Requirement 49)
 */
function ukm_toko_sitemap_routes() {
	if ( ! isset( $_SERVER['REQUEST_URI'] ) ) {
		return;
	}

	$uri = $_SERVER['REQUEST_URI'];

	// Kategori Produk Sitemap
	if ( strpos( $uri, 'product_cat-sitemap.xml' ) !== false || strpos( $uri, 'kategori-produk-sitemap.xml' ) !== false ) {
		if ( class_exists( 'RankMath\Sitemap\Sitemap_XML' ) ) {
			new \RankMath\Sitemap\Sitemap_XML( 'product_cat' );
			exit;
		}
	}

	// Produk Post Type Sitemap
	if ( strpos( $uri, 'product-sitemap.xml' ) !== false ) {
		if ( class_exists( 'RankMath\Sitemap\Sitemap_XML' ) ) {
			new \RankMath\Sitemap\Sitemap_XML( 'product' );
			exit;
		}
	}
}
add_action( 'template_redirect', 'ukm_toko_sitemap_routes', 0 );
