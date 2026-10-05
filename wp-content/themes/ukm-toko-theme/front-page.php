<?php
/**
 * The template for displaying the front page (Home Loop Variant)
 *
 * Provides a dedicated custom multi-loop front-page layout distinct from index.php and single.php.
 *
 * @package ukm-toko
 */

get_header();
?>

<main id="primary" class="site-main site-front-page">

	<!-- Section 1: Hero Banner Utama -->
	<section class="ukm-hero-section" style="background-image: linear-gradient(rgba(15, 23, 42, 0.72), rgba(15, 23, 42, 0.72)), url('<?php echo esc_url( site_url( '/wp-content/uploads/2026/10/bekgron.jpg' ) ); ?>'); background-size: cover; background-position: center; color: #ffffff; padding: 5rem 1.5rem; text-align: center;">
		<div class="container" style="max-width: 800px; margin: 0 auto;">
			<span style="display: inline-block; background: var(--ukm-primary); color: #ffffff; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; padding: 4px 14px; border-radius: 20px; margin-bottom: 1rem; letter-spacing: 0.5px;">
				Pusat Sembako &amp; Retail UKM Terpercaya
			</span>
			<h1 style="font-size: 2.75rem; font-weight: 800; line-height: 1.2; margin: 0 0 1rem; color: #ffffff;">
				Belanja Sembako Murah, Lengkap, dan Berkualitas
			</h1>
			<p style="font-size: 1.15rem; line-height: 1.6; margin: 0 0 2rem; color: #e2e8f0;">
				Penyedia kebutuhan pokok rumah tangga, warung makan, dan mitra kelontong dengan jaminan harga grosir bersahabat dan pasokan terjamin.
			</p>
			<div class="ukm-hero-cta" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
				<a href="<?php echo esc_url( site_url( '/shop' ) ); ?>" class="ukm-btn is-style-ukm-flat-button" style="background: var(--ukm-accent); color: #ffffff; padding: 12px 28px; border-radius: var(--ukm-radius); text-decoration: none; font-weight: 700; font-size: 1rem;">
					Mulai Belanja Katalog
				</a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'produk' ) ); ?>" class="ukm-btn is-style-ukm-flat-button" style="background: rgba(255, 255, 255, 0.15); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.4); padding: 12px 24px; border-radius: var(--ukm-radius); text-decoration: none; font-weight: 600; font-size: 1rem;">
					Katalog CPT Produk
				</a>
			</div>
		</div>
	</section>

	<!-- Section 2: Kategori Pilihan -->
	<section class="ukm-categories-section container" style="padding: 3.5rem 15px 2rem;">
		<div style="text-align: center; margin-bottom: 2rem;">
			<h2 style="font-size: 1.85rem; font-weight: 800; margin: 0 0 0.5rem;">Kategori Produk Pilihan</h2>
			<p style="color: var(--ukm-text-muted); margin: 0;">Pilih kelompok sembako dan kebutuhan harian sesuai kebutuhan Anda</p>
		</div>
		<div class="ukm-cat-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem;">
			<?php
			$categories = array(
				array( 'name' => 'Sembako', 'slug' => 'sembako', 'desc' => 'Beras, Minyak, Gula, Tepung, Telur & Garam' ),
				array( 'name' => 'Kebersihan', 'slug' => 'kebersihan', 'desc' => 'Sabun, Deterjen, Pembersih Lantai & Pasta Gigi' ),
				array( 'name' => 'Minuman', 'slug' => 'minuman', 'desc' => 'Teh, Kopi Bubuk, Susu & Air Mineral' ),
				array( 'name' => 'Snack', 'slug' => 'snack', 'desc' => 'Biskuit, Keripik, Wafer & Mie Instan' ),
			);
			foreach ( $categories as $cat ) :
				?>
				<a href="<?php echo esc_url( site_url( '/product-category/' . $cat['slug'] . '/' ) ); ?>" class="ukm-cat-card is-style-ukm-card" style="text-decoration: none; display: block; text-align: center; transition: all 0.2s ease;">
					<h3 style="color: var(--ukm-primary); font-size: 1.25rem; margin: 0 0 0.5rem; font-weight: 700;"><?php echo esc_html( $cat['name'] ); ?></h3>
					<p style="color: var(--ukm-text-muted); font-size: 0.875rem; margin: 0; line-height: 1.5;"><?php echo esc_html( $cat['desc'] ); ?></p>
				</a>
			<?php endforeach; ?>
		</div>
	</section>

	<!-- Section 3: Produk Terlaris (WooCommerce Dynamic Grid) -->
	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
		<section class="ukm-featured-products-section container" style="padding: 2rem 15px 3.5rem;">
			<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.75rem; border-bottom: 2px solid var(--ukm-border); padding-bottom: 0.75rem;">
				<div>
					<h2 style="font-size: 1.75rem; font-weight: 800; margin: 0 0 0.25rem;">Produk Terlaris Minggu Ini</h2>
					<p style="color: var(--ukm-text-muted); margin: 0; font-size: 0.95rem;">Produk kebutuhan pokok dengan harga grosir terbaik</p>
				</div>
				<a href="<?php echo esc_url( site_url( '/shop' ) ); ?>" style="color: var(--ukm-primary); text-decoration: none; font-weight: 600; font-size: 0.9rem;">
					Lihat Semua Produk &rarr;
				</a>
			</div>
			<?php echo do_shortcode( '[products limit="8" columns="4" orderby="popularity"]' ); ?>
		</section>
	<?php endif; ?>

	<!-- Section 4: Home Loop Varian (Artikel & Tips Terbaru) -->
	<section class="ukm-home-posts-section container" style="padding: 1rem 15px 3.5rem;">
		<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.75rem; border-bottom: 2px solid var(--ukm-border); padding-bottom: 0.75rem;">
			<div>
				<h2 style="font-size: 1.75rem; font-weight: 800; margin: 0 0 0.25rem;">Tips &amp; Promo Sembako</h2>
				<p style="color: var(--ukm-text-muted); margin: 0; font-size: 0.95rem;">Wawasan seputar penyimpanan bahan pangan dan kabar promo toko</p>
			</div>
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: site_url( '/blog' ) ); ?>" style="color: var(--ukm-primary); text-decoration: none; font-weight: 600; font-size: 0.9rem;">
				Semua Artikel &rarr;
			</a>
		</div>

		<?php
		$home_posts = new WP_Query( array(
			'post_type'      => 'post',
			'posts_per_page' => 3,
			'post_status'    => 'publish',
		) );

		if ( $home_posts->have_posts() ) :
			?>
			<div class="ukm-home-posts-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
				<?php
				while ( $home_posts->have_posts() ) :
					$home_posts->the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'ukm-post-card is-style-ukm-card' ); ?> style="display: flex; flex-direction: column;">
						<?php if ( has_post_thumbnail() ) : ?>
							<div style="aspect-ratio: 16/9; background: #f1f5f9; border-radius: 4px; overflow: hidden; margin-bottom: 1rem;">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
								</a>
							</div>
						<?php endif; ?>
						<div style="font-size: 0.8rem; color: var(--ukm-text-muted); margin-bottom: 0.4rem;">
							<?php echo esc_html( get_the_date() ); ?>
						</div>
						<h3 style="font-size: 1.15rem; margin: 0 0 0.5rem; line-height: 1.35;">
							<a href="<?php the_permalink(); ?>" style="color: var(--ukm-text); text-decoration: none;">
								<?php the_title(); ?>
							</a>
						</h3>
						<div style="font-size: 0.875rem; color: var(--ukm-text-muted); margin-bottom: 1rem; line-height: 1.5;">
							<?php echo wp_trim_words( get_the_excerpt(), 18, '...' ); ?>
						</div>
						<div style="margin-top: auto;">
							<a href="<?php the_permalink(); ?>" style="color: var(--ukm-primary); font-weight: 600; text-decoration: none; font-size: 0.875rem;">
								Baca Selengkapnya &rarr;
							</a>
						</div>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		<?php else : ?>
			<p style="color: var(--ukm-text-muted);">Belum ada artikel yang diterbitkan.</p>
		<?php endif; ?>
	</section>

	<!-- Section 5: Testimoni Pelanggan / Slider -->
	<section class="ukm-testimonials-home container" style="padding-bottom: 4rem;">
		<?php
		echo ukm_toko_render_testimonial_block( array(
			'postsPerPage' => 3,
			'title'        => 'Testimoni Pelanggan & Mitra Warung',
		) );
		?>
	</section>

</main>

<?php
get_footer();
