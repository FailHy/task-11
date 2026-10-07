<?php
/**
 * The header for our theme
 *
 * Menampilkan semua isi dari <head> hingga <header> dan pembuka konten utama.
 *
 * @package ukm-toko
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="page" class="site">
		
		<header id="masthead" class="site-header">
			<div class="container site-header-inner">
				<div class="site-branding">
					<h1 class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<?php bloginfo( 'name' ); ?>
						</a>
					</h1>
					<?php if ( get_bloginfo( 'description' ) ) : ?>
						<p class="site-description">
							<?php bloginfo( 'description' ); ?>
						</p>
					<?php endif; ?>
				</div>
				
		<div class="header-right-actions">
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<div class="header-cart-container">
					<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'Lihat keranjang belanja Anda', 'ukm-toko' ); ?>">
						<svg class="cart-icon" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" style="vertical-align:-2px; margin-right:4px;"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>Keranjang: <span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> 
						(<span class="count"><?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'ukm-toko' ), WC()->cart->get_cart_contents_count() ) ); ?></span>)
					</a>
					
					<!-- Dropdown Widget Mini-Cart (Requirement 36) -->
					<div class="header-mini-cart-dropdown">
						<?php
						if ( is_active_sidebar( 'header-cart-widget' ) ) {
							dynamic_sidebar( 'header-cart-widget' );
						} else {
							the_widget( 'WC_Widget_Cart', array( 'title' => 'Keranjang Belanja' ) );
						}
						?>
					</div>
				</div>
			<?php endif; ?>

			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Buka Menu Navigasi', 'ukm-toko' ); ?>">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px; margin-right:4px;"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
					<span class="menu-toggle-text"><?php esc_html_e( 'Menu', 'ukm-toko' ); ?></span>
				</button>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'nav-menu',
					'fallback_cb'    => false,
				) );
				?>
			</nav>
		</div><!-- .header-right-actions -->
	</div><!-- .site-header-inner -->
</header>


		<?php
		// Breadcrumb NavXT Integration (Requirement 49)
		if ( function_exists( 'bcn_display' ) && ! is_front_page() ) :
			?>
			<nav class="breadcrumbs-bar" aria-label="<?php esc_attr_e( 'Breadcrumb', 'ukm-toko' ); ?>" style="background: var(--ukm-card-bg); border-bottom: 1px solid var(--ukm-border); padding: 0.75rem 0;">
				<div class="container breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/" style="font-size: 0.85rem; color: var(--ukm-text-muted);">
					<?php bcn_display(); ?>
				</div>
			</nav>
		<?php endif; ?>

		<!-- Pembuka bungkus konten utama -->
		<div id="content" class="site-content">