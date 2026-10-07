<?php
/**
 * Optimasi Performa, Critical CSS, Minifikasi & Caching
 *
 * @package UKM_Toko_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Native Lazy Loading
 * Memastikan WordPress mengaplikasikan atribut loading="lazy" pada gambar dan iframe
 */
add_filter( 'wp_lazy_loading_enabled', '__return_true' );

/**
 * 2. Menghapus versi parameter (ver=) dari CSS dan JS
 * Membantu browser caching agar aset statis di-cache lebih efisien
 */
function ukm_toko_remove_script_version( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'ukm_toko_remove_script_version', 9999 );
add_filter( 'script_loader_src', 'ukm_toko_remove_script_version', 9999 );

/**
 * 3. Disable Emojis
 * Menghapus skrip emoji bawaan WP jika tidak digunakan (mengurangi HTTP requests)
 */
function ukm_toko_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'ukm_toko_disable_emojis_tinymce' );
}
add_action( 'init', 'ukm_toko_disable_emojis' );

function ukm_toko_disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * 4. Preload Critical CSS (Requirement 40)
 */
function ukm_toko_preload_critical_assets() {
	$css_uri = file_exists( get_stylesheet_directory() . '/style.min.css' )
		? get_stylesheet_directory_uri() . '/style.min.css'
		: get_stylesheet_uri();

	echo '<link rel="preload" href="' . esc_url( $css_uri ) . '" as="style">' . "\n";
	if ( is_front_page() || is_home() ) {
		echo '<link rel="preload" href="' . esc_url( site_url( '/wp-content/uploads/2026/10/bekgron.jpg' ) ) . '" as="image" fetchpriority="high">' . "\n";
	}
}
add_action( 'wp_head', 'ukm_toko_preload_critical_assets', 1 );

/**
 * 5. Critical CSS Inline (Requirement 41)
 * Menyuntikkan CSS kritis above-the-fold untuk mempercepat First Contentful Paint (FCP)
 */
function ukm_toko_inline_critical_css() {
	?>
	<style id="ukm-critical-css">
		:root{--ukm-primary:#0073aa;--ukm-primary-dark:#005177;--ukm-accent:#10b981;--ukm-accent-dark:#059669;--ukm-text:#1e293b;--ukm-bg:#f8fafc;--ukm-card-bg:#ffffff;--ukm-border:#e2e8f0;--ukm-radius:6px;--ukm-font:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;}
		*,*::before,*::after{box-sizing:border-box;}
		body{font-family:var(--ukm-font);color:var(--ukm-text);background-color:var(--ukm-bg);line-height:1.6;margin:0;}
		.container{width:100%;max-width:1200px;margin-left:auto;margin-right:auto;padding-left:15px;padding-right:15px;}
		.site-header{background:#ffffff;border-bottom:1px solid var(--ukm-border);position:sticky;top:0;z-index:100;}
		.site-header-inner{display:flex;align-items:center;justify-content:space-between;padding:12px 15px;}
		.site-title{margin:0;font-size:22px;font-weight:800;line-height:1.2;}
		.site-title a{color:var(--ukm-primary);text-decoration:none;}
		.nav-menu{list-style:none;margin:0;padding:0;display:flex;gap:15px;}
		.nav-menu a{color:var(--ukm-text);text-decoration:none;font-weight:600;font-size:14px;}
		.menu-toggle{display:none;}
		@media(max-width:768px){.menu-toggle{display:inline-flex;align-items:center;gap:4px;padding:6px 10px;background:#fff;border:1px solid var(--ukm-border);border-radius:4px;cursor:pointer;font-weight:700;font-size:13px;}.main-navigation:not(.toggled) .nav-menu{display:none;}}
	</style>
	<?php
}
add_action( 'wp_head', 'ukm_toko_inline_critical_css', 1 );

/**
 * 6. Browser Cache Headers (Requirement 44)
 * Menjamin header Cache-Control dan Expires dikirimkan secara konsisten
 */
function ukm_toko_cache_headers() {
	if ( ! headers_sent() ) {
		// Security Headers (Defense in depth)
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-Frame-Options: SAMEORIGIN' );

		// Cache Headers untuk halaman publik non-transaksional
		if ( ! is_user_logged_in() && ! is_admin() ) {
			if ( function_exists( 'is_cart' ) && is_cart() ) {
				header( 'Cache-Control: no-cache, no-store, must-revalidate, max-age=0' );
			} elseif ( function_exists( 'is_checkout' ) && is_checkout() ) {
				header( 'Cache-Control: no-cache, no-store, must-revalidate, max-age=0' );
			} else {
				header( 'Cache-Control: public, max-age=3600, stale-while-revalidate=86400' );
				header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + 3600 ) . ' GMT' );
			}
		}
	}
}
add_action( 'send_headers', 'ukm_toko_cache_headers' );

/**
 * 7. Konfigurasi & Filter CDN Images (Requirement 37 & 45)
 * Memungkinkan offloading URL media uploads ke CDN ketika konstanta UKM_CDN_DOMAIN didefinisikan.
 *
 * Kebijakan proteksi:
 * - Admin, AJAX Admin (Media Library Modal), dan REST API Media tidak di-rewrite agar thumbnail dashboard selalu tampil normal.
 * - Pada lingkungan lokal (localhost / 127.0.0.1), URL tetap menggunakan host lokal agar gambar di browser tampil normal tanpa dependensi DNS eksternal.
 * - Offload aktif jika UKM_CDN_DOMAIN didefinisikan dan lingkungan adalah production atau dipaksa via UKM_CDN_FORCE_LOCAL.
 */
if ( ! defined( 'UKM_CDN_DOMAIN' ) ) {
	define( 'UKM_CDN_DOMAIN', '' );
}

if ( ! function_exists( 'ukm_toko_is_local_environment' ) ) {
	function ukm_toko_is_local_environment() {
		$http_host   = isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : '';
		$server_name = isset( $_SERVER['SERVER_NAME'] ) ? $_SERVER['SERVER_NAME'] : '';
		return ( strpos( $http_host, 'localhost' ) !== false || strpos( $http_host, '127.0.0.1' ) !== false ||
		         strpos( $server_name, 'localhost' ) !== false || strpos( $server_name, '127.0.0.1' ) !== false );
	}
}

function ukm_toko_cdn_attachment_url( $url ) {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return $url;
	}
	if ( defined( 'UKM_CDN_DOMAIN' ) && ! empty( UKM_CDN_DOMAIN ) ) {
		if ( ukm_toko_is_local_environment() && ( ! defined( 'UKM_CDN_FORCE_LOCAL' ) || ! UKM_CDN_FORCE_LOCAL ) ) {
			return $url;
		}
		$site_url = site_url();
		if ( strpos( $url, $site_url ) === 0 ) {
			return str_replace( $site_url, UKM_CDN_DOMAIN, $url );
		}
	}
	return $url;
}
add_filter( 'wp_get_attachment_url', 'ukm_toko_cdn_attachment_url' );

function ukm_toko_cdn_srcset( $sources ) {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return $sources;
	}
	if ( defined( 'UKM_CDN_DOMAIN' ) && ! empty( UKM_CDN_DOMAIN ) && is_array( $sources ) ) {
		if ( ukm_toko_is_local_environment() && ( ! defined( 'UKM_CDN_FORCE_LOCAL' ) || ! UKM_CDN_FORCE_LOCAL ) ) {
			return $sources;
		}
		$site_url = site_url();
		foreach ( $sources as &$source ) {
			if ( isset( $source['url'] ) && strpos( $source['url'], $site_url ) === 0 ) {
				$source['url'] = str_replace( $site_url, UKM_CDN_DOMAIN, $source['url'] );
			}
		}
	}
	return $sources;
}
add_filter( 'wp_calculate_image_srcset', 'ukm_toko_cdn_srcset' );

/**
 * 8. Blokir Akses XML-RPC
 */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_action( 'init', function() {
	if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
		status_header( 403 );
		wp_die( 'Akses XML-RPC telah dinonaktifkan.', 'Forbidden', array( 'response' => 403 ) );
	}
	if ( isset( $_SERVER['SCRIPT_NAME'] ) && strpos( $_SERVER['SCRIPT_NAME'], 'xmlrpc.php' ) !== false ) {
		status_header( 403 );
		wp_die( 'Akses XML-RPC telah dinonaktifkan.', 'Forbidden', array( 'response' => 403 ) );
	}
} );

/**
 * 9. Sanitasi & Pembatasan Panjang Query Pencarian Publik (Anti-DoS)
 */
function ukm_toko_limit_search_query_length( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
		$search_query = $query->get( 's' );
		if ( ! empty( $search_query ) && mb_strlen( $search_query ) > 100 ) {
			$sanitized = mb_substr( sanitize_text_field( $search_query ), 0, 100 );
			$query->set( 's', $sanitized );
		}
	}
}
add_action( 'pre_get_posts', 'ukm_toko_limit_search_query_length' );

/**
 * 10. Sanitasi & Pembatasan Panjang Ulasan / Komentar Produk
 */
function ukm_toko_sanitize_comment_content( $commentdata ) {
	if ( ! empty( $commentdata['comment_content'] ) ) {
		$clean_content = wp_strip_all_tags( $commentdata['comment_content'] );
		if ( mb_strlen( $clean_content ) > 1000 ) {
			$clean_content = mb_substr( $clean_content, 0, 1000 );
		}
		$commentdata['comment_content'] = $clean_content;
	}
	return $commentdata;
}
add_filter( 'preprocess_comment', 'ukm_toko_sanitize_comment_content' );


/**
 * 12. Minifikasi Output HTML Publik (Requirement 34)
 */
function ukm_toko_minify_html_output( $buffer ) {
	if ( is_admin() || is_feed() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return $buffer;
	}
	if ( strpos( $buffer, '<html' ) === false ) {
		return $buffer;
	}

	$search = array(
		'/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', // Remove non-IE HTML comments
		'/\>[^\S ]+/s',                                         // Strip whitespace after tags
		'/[^\S ]+\</s',                                         // Strip whitespace before tags
		'/(\s)+/s',                                             // Collapse multi-whitespace
	);
	$replace = array( '', '>', '<', '\\1' );
	return preg_replace( $search, $replace, $buffer );
}

function ukm_toko_start_html_minify() {
	if ( ! is_admin() ) {
		ob_start( 'ukm_toko_minify_html_output' );
	}
}
add_action( 'template_redirect', 'ukm_toko_start_html_minify', 0 );

/**
 * 13. Dequeue Unneeded Assets on Frontend & Defer Non-Critical Scripts
 */
function ukm_toko_optimize_scripts() {
	if ( ! is_admin() ) {
		wp_dequeue_style( 'woocommerce-blocktheme' );
		wp_dequeue_script( 'jquery-migrate' );
	}
}
add_action( 'wp_enqueue_scripts', 'ukm_toko_optimize_scripts', 100 );

function ukm_toko_defer_frontend_scripts( $tag, $handle, $src ) {
	if ( is_admin() ) {
		return $tag;
	}
	if ( strpos( $tag, 'defer' ) !== false || strpos( $tag, 'async' ) !== false ) {
		return $tag;
	}
	return str_replace( ' src', ' defer src', $tag );
}
add_filter( 'script_loader_tag', 'ukm_toko_defer_frontend_scripts', 10, 3 );

