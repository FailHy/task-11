<?php
/**
 * Konfigurasi WordPress Customizer
 *
 * @package UKM_Toko_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ukm_toko_customize_register( $wp_customize ) {
	// ==========================================
	// 1. COLORS
	// ==========================================
	$wp_customize->add_section( 'ukm_colors', array(
		'title'       => __( 'Warna Tema', 'ukm-toko' ),
		'priority'    => 30,
	) );

	$wp_customize->add_setting( 'primary_color', array(
		'default'           => '#0073aa',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
		'label'   => __( 'Warna Utama', 'ukm-toko' ),
		'section' => 'ukm_colors',
	) ) );

	// ==========================================
	// 2. TYPOGRAPHY
	// ==========================================
	$wp_customize->add_section( 'ukm_typography', array(
		'title'       => __( 'Tipografi', 'ukm-toko' ),
		'priority'    => 35,
	) );

	$wp_customize->add_setting( 'base_font', array(
		'default'           => 'sans-serif',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'base_font', array(
		'label'   => __( 'Font Dasar', 'ukm-toko' ),
		'section' => 'ukm_typography',
		'type'    => 'select',
		'choices' => array(
			'sans-serif' => 'Sans-Serif (Modern)',
			'serif'      => 'Serif (Klasik)',
			'monospace'  => 'Monospace',
		),
	) );

	// ==========================================
	// 3. HEADER OPTIONS
	// ==========================================
	$wp_customize->add_section( 'ukm_header_options', array(
		'title'       => __( 'Opsi Header', 'ukm-toko' ),
		'priority'    => 40,
	) );

	$wp_customize->add_setting( 'header_bg_color', array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bg_color', array(
		'label'   => __( 'Warna Background Header', 'ukm-toko' ),
		'section' => 'ukm_header_options',
	) ) );

	// ==========================================
	// 4. FOOTER OPTIONS
	// ==========================================
	$wp_customize->add_section( 'ukm_footer_options', array(
		'title'       => __( 'Opsi Footer', 'ukm-toko' ),
		'priority'    => 45,
	) );

	$wp_customize->add_setting( 'footer_copyright', array(
		'default'           => '&copy; ' . date('Y') . ' UKM Toko. All rights reserved.',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'footer_copyright', array(
		'label'   => __( 'Teks Copyright', 'ukm-toko' ),
		'section' => 'ukm_footer_options',
		'type'    => 'textarea',
	) );
}
add_action( 'customize_register', 'ukm_toko_customize_register' );

/**
 * Injeksi Variabel CSS ke Frontend
 */
function ukm_toko_customizer_css() {
	$primary_color = get_theme_mod( 'primary_color', '#0073aa' );
	$header_bg     = get_theme_mod( 'header_bg_color', '#ffffff' );
	$base_font     = get_theme_mod( 'base_font', 'sans-serif' );
	?>
	<style type="text/css" id="ukm-customizer-css">
		:root {
			--ukm-primary: <?php echo esc_attr( $primary_color ); ?>;
			--ukm-header-bg: <?php echo esc_attr( $header_bg ); ?>;
			--ukm-font: <?php echo esc_attr( $base_font ); ?>;
		}
		
		body {
			font-family: var(--ukm-font);
		}
		
		.site-header {
			background-color: var(--ukm-header-bg) !important;
		}
		
		.ukm-btn, .wp-block-button__link, .button.alt, button.button.alt {
			background-color: var(--ukm-primary) !important;
			color: #ffffff !important;
			border: none;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'ukm_toko_customizer_css' );
