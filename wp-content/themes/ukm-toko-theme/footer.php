<?php
/**
 * The template for displaying the footer
 *
 * Berisi penutup dari div #content dan #page, serta pemanggilan wp_footer().
 *
 * @package ukm-toko
 */
?>
		</div><!-- #content -->

		<footer id="colophon" class="site-footer">
			<div class="container">
				<div class="footer-grid">
					<div class="footer-col">
						<h4><?php bloginfo( 'name' ); ?></h4>
						<p style="font-size: 13px; line-height: 1.6; margin-top: 8px;">Pusat pasokan sembako dan kebutuhan pokok terpercaya dengan harga grosir bersahabat untuk keluarga dan pelaku usaha.</p>
					</div>
					<div class="footer-col">
						<h4>Katalog</h4>
						<ul>
							<li><a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>">Semua Produk</a></li>
							<li><a href="<?php echo esc_url( home_url( '/product-category/sembako/' ) ); ?>">Sembako</a></li>
							<li><a href="<?php echo esc_url( home_url( '/product-category/kebersihan/' ) ); ?>">Kebersihan</a></li>
							<li><a href="<?php echo esc_url( home_url( '/product-category/minuman/' ) ); ?>">Minuman</a></li>
							<li><a href="<?php echo esc_url( home_url( '/product-category/snack/' ) ); ?>">Snack</a></li>
						</ul>
					</div>
					<div class="footer-col">
						<h4>Belanja</h4>
						<ul>
							<li><a href="<?php echo esc_url( home_url( '/cart/' ) ); ?>">Keranjang Belanja</a></li>
							<li><a href="<?php echo esc_url( home_url( '/my-account/' ) ); ?>">Akun Pengguna</a></li>
							<li><a href="<?php echo esc_url( home_url( '/checkout/' ) ); ?>">Checkout</a></li>
						</ul>
					</div>
					<div class="footer-col">
						<h4>Layanan</h4>
						<p style="font-size: 13px; margin-bottom: 6px;">Jakarta Selatan, DKI Jakarta</p>
						<p style="font-size: 13px; margin-bottom: 6px;">WhatsApp: 0812-3456-7890</p>
						<p style="font-size: 13px; margin: 0;">Senin - Sabtu (08:00 - 20:00)</p>
					</div>
				</div><!-- .footer-grid -->

				<div class="site-info">
					<p>
						<?php 
						$default_copy = '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. All rights reserved.';
						echo wp_kses_post( get_theme_mod( 'footer_copyright', $default_copy ) ); 
						?>
					</p>
				</div>
			</div><!-- .container -->
		</footer>
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>
