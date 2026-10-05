<?php
/**
 * The template for displaying archive pages for CPT Produk
 *
 * @package ukm-toko
 */

get_header();
?>

<main id="primary" class="site-main container" style="padding-top: 2rem; padding-bottom: 3rem;">

	<header class="page-header" style="margin-bottom: 2rem; text-align: center;">
		<h1 class="page-title"><?php esc_html_e( 'Katalog Produk UKM Toko', 'ukm-toko' ); ?></h1>
		<p class="page-description" style="color: var(--ukm-text-muted); max-width: 600px; margin: 0.5rem auto 0;">
			<?php esc_html_e( 'Daftar komoditas sembako dan kebutuhan harian berkualitas dengan harga terjangkau.', 'ukm-toko' ); ?>
		</p>

		<?php
		$terms = get_terms( array(
			'taxonomy'   => 'kategori-produk',
			'hide_empty' => false,
		) );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
			?>
			<div class="kategori-filter-pills" style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap; margin-top: 1.5rem;">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'produk' ) ); ?>" class="btn-pill is-active" style="padding: 6px 16px; border-radius: 20px; background: var(--ukm-primary); color: #fff; text-decoration: none; font-size: 0.875rem; font-weight: 500;">
					<?php esc_html_e( 'Semua Kategori', 'ukm-toko' ); ?>
				</a>
				<?php foreach ( $terms as $term ) : ?>
					<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="btn-pill" style="padding: 6px 16px; border-radius: 20px; background: var(--ukm-card-bg); border: 1px solid var(--ukm-border); color: var(--ukm-text); text-decoration: none; font-size: 0.875rem;">
						<?php echo esc_html( $term->name ); ?> (<?php echo esc_html( $term->count ); ?>)
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</header>

	<?php if ( have_posts() ) : ?>

		<div class="cpt-produk-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem;">
			<?php
			while ( have_posts() ) :
				the_post();
				$harga = get_post_meta( get_the_ID(), '_harga_produk', true );
				$stok  = get_post_meta( get_the_ID(), '_stok_produk', true );
				$kategori_list = get_the_term_list( get_the_ID(), 'kategori-produk', '', ', ' );
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'cpt-produk-card' ); ?> style="background: var(--ukm-card-bg); border: 1px solid var(--ukm-border); border-radius: var(--ukm-radius); overflow: hidden; display: flex; flex-direction: column;">
					
					<div class="card-thumb" style="aspect-ratio: 1/1; overflow: hidden; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" style="width: 100%; height: 100%;">
								<?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
							</a>
						<?php else : ?>
							<div class="no-thumb" style="color: var(--ukm-text-muted); font-size: 0.875rem;">Tidak ada foto</div>
						<?php endif; ?>
					</div>

					<div class="card-body" style="padding: 1.25rem; display: flex; flex-direction: column; flex-grow: 1;">
						<?php if ( $kategori_list ) : ?>
							<div class="card-cat" style="font-size: 0.75rem; text-transform: uppercase; color: var(--ukm-primary); font-weight: 600; margin-bottom: 0.35rem;">
								<?php echo wp_kses_post( $kategori_list ); ?>
							</div>
						<?php endif; ?>

						<h2 class="card-title" style="font-size: 1.1rem; margin: 0 0 0.5rem; line-height: 1.3;">
							<a href="<?php the_permalink(); ?>" style="color: var(--ukm-text); text-decoration: none;">
								<?php the_title(); ?>
							</a>
						</h2>

						<div class="card-price" style="font-size: 1.125rem; font-weight: 700; color: var(--ukm-accent-dark); margin-bottom: 0.5rem;">
							<?php echo $harga ? 'Rp ' . esc_html( $harga ) : 'Hubungi Toko'; ?>
						</div>

						<div class="card-stock" style="font-size: 0.8rem; color: var(--ukm-text-muted); margin-bottom: 1rem;">
							Stok: <strong><?php echo esc_html( $stok !== '' ? $stok : 'Tersedia' ); ?> unit</strong>
						</div>

						<div class="card-action" style="margin-top: auto;">
							<a href="<?php the_permalink(); ?>" class="ukm-btn" style="display: block; text-align: center; background: var(--ukm-primary); color: #fff; text-decoration: none; padding: 8px 14px; border-radius: var(--ukm-radius); font-size: 0.875rem; font-weight: 600;">
								Detail Produk
							</a>
						</div>
					</div>

				</article>
				<?php
			endwhile;
			?>
		</div>

		<div class="posts-pagination-container" style="margin-top: 2.5rem; text-align: center;">
			<?php
			the_posts_pagination( array(
				'mid_size'  => 2,
				'prev_text' => __( '&larr; Sebelumnya', 'ukm-toko' ),
				'next_text' => __( 'Berikutnya &rarr;', 'ukm-toko' ),
			) );
			?>
		</div>

	<?php else : ?>

		<div class="no-posts-found" style="text-align: center; padding: 3rem 1rem; background: var(--ukm-card-bg); border: 1px solid var(--ukm-border); border-radius: var(--ukm-radius);">
			<h2><?php esc_html_e( 'Belum Ada Produk', 'ukm-toko' ); ?></h2>
			<p style="color: var(--ukm-text-muted);"><?php esc_html_e( 'Belum ada produk yang didaftarkan pada katalog ini.', 'ukm-toko' ); ?></p>
		</div>

	<?php endif; ?>

</main>

<?php
get_footer();
