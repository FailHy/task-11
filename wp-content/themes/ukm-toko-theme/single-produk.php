<?php
/**
 * The template for displaying single CPT Produk posts
 *
 * @package ukm-toko
 */

get_header();
?>

<main id="primary" class="site-main container" style="padding-top: 2rem; padding-bottom: 3rem;">

	<?php
	while ( have_posts() ) :
		the_post();
		$post_id  = get_the_ID();
		$harga    = get_post_meta( $post_id, '_harga_produk', true );
		$stok     = get_post_meta( $post_id, '_stok_produk', true );
		$specs    = get_post_meta( $post_id, '_spesifikasi_produk', true );
		$kategori = get_the_terms( $post_id, 'kategori-produk' );

		// ACF Group Field: detail_spesifikasi (jika diisi)
		$acf_specs = function_exists( 'get_field' ) ? get_field( 'detail_spesifikasi', $post_id ) : null;
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'cpt-single-produk' ); ?>>
			
			<div class="cpt-produk-detail-wrapper" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem; background: var(--ukm-card-bg); padding: 2rem; border-radius: var(--ukm-radius); border: 1px solid var(--ukm-border); margin-bottom: 3rem;">
				
				<!-- Kolom Gambar -->
				<div class="cpt-produk-gallery" style="background: #f8fafc; border-radius: var(--ukm-radius); overflow: hidden; border: 1px solid var(--ukm-border);">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'style' => 'width: 100%; height: auto; display: block; object-fit: cover;' ) ); ?>
					<?php else : ?>
						<div style="padding: 4rem 1rem; text-align: center; color: var(--ukm-text-muted);">
							<?php esc_html_e( 'Tidak ada foto produk', 'ukm-toko' ); ?>
						</div>
					<?php endif; ?>
				</div>

				<!-- Kolom Informasi & Spesifikasi -->
				<div class="cpt-produk-info">
					<?php if ( ! empty( $kategori ) && ! is_wp_error( $kategori ) ) : ?>
						<div class="cpt-cat-badge" style="display: inline-block; background: var(--ukm-primary-light); color: var(--ukm-primary); font-size: 0.8rem; font-weight: 600; padding: 3px 10px; border-radius: 4px; margin-bottom: 0.75rem;">
							<?php echo esc_html( $kategori[0]->name ); ?>
						</div>
					<?php endif; ?>

					<h1 class="entry-title" style="font-size: 1.85rem; margin: 0 0 1rem; line-height: 1.25;">
						<?php the_title(); ?>
					</h1>

					<div class="cpt-price-row" style="font-size: 1.75rem; font-weight: 700; color: var(--ukm-accent-dark); margin-bottom: 1rem;">
						<?php echo $harga ? 'Rp ' . esc_html( $harga ) : 'Hubungi Toko'; ?>
					</div>

					<div class="cpt-stock-status" style="margin-bottom: 1.5rem; font-size: 0.9rem; color: var(--ukm-text-muted);">
						Status Stok: <strong style="color: var(--ukm-accent);"><?php echo esc_html( $stok !== '' ? $stok : '50' ); ?> unit tersedia</strong>
					</div>

					<!-- Spesifikasi Teknis / Meta -->
					<div class="cpt-specs-table-wrapper" style="border-top: 1px solid var(--ukm-border); padding-top: 1rem; margin-bottom: 1.5rem;">
						<h3 style="font-size: 1rem; margin-bottom: 0.75rem;">Spesifikasi Produk</h3>
						<table class="cpt-specs-table" style="width: 100%; font-size: 0.875rem; border-collapse: collapse;">
							<?php if ( ! empty( $acf_specs['berat'] ) ) : ?>
								<tr>
									<th style="text-align: left; padding: 6px 0; color: var(--ukm-text-muted); width: 35%;">Berat / Kemasan</th>
									<td style="padding: 6px 0; font-weight: 600;"><?php echo esc_html( $acf_specs['berat'] ); ?></td>
								</tr>
							<?php endif; ?>
							<?php if ( ! empty( $acf_specs['merek'] ) ) : ?>
								<tr>
									<th style="text-align: left; padding: 6px 0; color: var(--ukm-text-muted); width: 35%;">Merek / Produsen</th>
									<td style="padding: 6px 0; font-weight: 600;"><?php echo esc_html( $acf_specs['merek'] ); ?></td>
								</tr>
							<?php endif; ?>
							<?php if ( ! empty( $specs ) ) : ?>
								<tr>
									<th style="text-align: left; padding: 6px 0; color: var(--ukm-text-muted); width: 35%;">Keterangan</th>
									<td style="padding: 6px 0;"><?php echo esc_html( $specs ); ?></td>
								</tr>
							<?php endif; ?>
						</table>
					</div>

					<div class="entry-content" style="font-size: 0.95rem; line-height: 1.7; color: var(--ukm-text); margin-bottom: 2rem;">
						<?php the_content(); ?>
					</div>

					<div class="cpt-order-actions">
						<a href="https://wa.me/6281234567890?text=Halo%20UKM%20Toko,%20saya%20tertarik%20dengan%20produk%20<?php echo rawurlencode( get_the_title() ); ?>" target="_blank" rel="noopener" class="ukm-btn" style="display: inline-block; background: var(--ukm-accent); color: #fff; padding: 10px 22px; border-radius: var(--ukm-radius); text-decoration: none; font-weight: 600;">
							Pesan via WhatsApp
						</a>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'produk' ) ); ?>" style="margin-left: 1rem; color: var(--ukm-text-muted); text-decoration: none; font-size: 0.875rem;">
							&larr; Kembali ke Katalog
						</a>
					</div>
				</div>

			</div>

			<!-- Produk Terkait (Related Products Query) -->
			<?php
			$related_args = array(
				'post_type'      => 'produk',
				'posts_per_page' => 3,
				'post__not_in'   => array( $post_id ),
			);
			if ( ! empty( $kategori ) && ! is_wp_error( $kategori ) ) {
				$related_args['tax_query'] = array(
					array(
						'taxonomy' => 'kategori-produk',
						'field'    => 'term_id',
						'terms'    => $kategori[0]->term_id,
					),
				);
			}
			$related_query = new WP_Query( $related_args );

			if ( $related_query->have_posts() ) :
				?>
				<div class="cpt-related-products" style="margin-top: 3rem;">
					<h2 style="font-size: 1.35rem; margin-bottom: 1.5rem; text-align: center;">Produk Terkait Lainnya</h2>
					<div class="cpt-produk-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.5rem;">
						<?php
						while ( $related_query->have_posts() ) :
							$related_query->the_post();
							$rel_harga = get_post_meta( get_the_ID(), '_harga_produk', true );
							?>
							<div class="cpt-related-card" style="background: var(--ukm-card-bg); border: 1px solid var(--ukm-border); border-radius: var(--ukm-radius); padding: 1rem;">
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 4px;' ) ); ?>
									</a>
								<?php endif; ?>
								<h3 style="font-size: 1rem; margin: 0.75rem 0 0.25rem;">
									<a href="<?php the_permalink(); ?>" style="color: var(--ukm-text); text-decoration: none;">
										<?php the_title(); ?>
									</a>
								</h3>
								<div style="font-weight: 700; color: var(--ukm-accent-dark); font-size: 0.95rem;">
									<?php echo $rel_harga ? 'Rp ' . esc_html( $rel_harga ) : 'Hubungi Toko'; ?>
								</div>
							</div>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>
			<?php endif; ?>

		</article>

	<?php endwhile; ?>

</main>

<?php
get_footer();
