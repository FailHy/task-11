<?php
/**
 * Registrasi Gutenberg Dynamic Blocks & Block Styles (Native WordPress Core)
 *
 * @package UKM_Toko_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Registrasi Native Gutenberg Dynamic Blocks (Requirement 28, 29, 30)
 */
function ukm_toko_register_native_blocks() {

	// 1. Hero Banner Block (Requirement 28)
	register_block_type( 'ukm/hero-banner', array(
		'api_version'     => 2,
		'title'           => __( 'Hero Banner (UKM)', 'ukm-toko' ),
		'description'     => __( 'Blok banner utama dinamis untuk etalase beranda.', 'ukm-toko' ),
		'category'        => 'design',
		'icon'            => 'cover-image',
		'keywords'        => array( 'hero', 'banner', 'sembako' ),
		'attributes'      => array(
			'title'       => array(
				'type'    => 'string',
				'default' => 'Selamat Datang di UKM Toko Sembako',
			),
			'subtitle'    => array(
				'type'    => 'string',
				'default' => 'Sedia Kebutuhan Pokok & Sembako Murah, Lengkap, dan Terpercaya.',
			),
			'ctaText'     => array(
				'type'    => 'string',
				'default' => 'Mulai Belanja',
			),
			'ctaUrl'      => array(
				'type'    => 'string',
				'default' => '/shop',
			),
			'bgImage'     => array(
				'type'    => 'string',
				'default' => '',
			),
		),
		'render_callback' => 'ukm_toko_render_hero_block',
	) );

	// 2. Product Grid Block (Requirement 29)
	register_block_type( 'ukm/product-grid', array(
		'api_version'     => 2,
		'title'           => __( 'Product Grid (UKM)', 'ukm-toko' ),
		'description'     => __( 'Menampilkan daftar produk WooCommerce secara dinamis dalam grid flat modern.', 'ukm-toko' ),
		'category'        => 'design',
		'icon'            => 'cart',
		'keywords'        => array( 'produk', 'grid', 'shop' ),
		'attributes'      => array(
			'postsPerPage' => array(
				'type'     => 'number',
				'default'  => 4,
			),
			'title'        => array(
				'type'     => 'string',
				'default'  => 'Produk Unggulan',
			),
			'category'     => array(
				'type'     => 'string',
				'default'  => '',
			),
		),
		'render_callback' => 'ukm_toko_render_product_grid_block',
	) );

	// 3. Testimonial Slider / Grid Block (Requirement 30)
	register_block_type( 'ukm/testimonial-slider', array(
		'api_version'     => 2,
		'title'           => __( 'Testimonial Slider (UKM)', 'ukm-toko' ),
		'description'     => __( 'Menampilkan testimoni mitra lokal yang diambil dari CPT Klien.', 'ukm-toko' ),
		'category'        => 'design',
		'icon'            => 'businessman',
		'keywords'        => array( 'klien', 'testimonial', 'slider' ),
		'attributes'      => array(
			'title'        => array(
				'type'     => 'string',
				'default'  => 'Apa Kata Mitra & Pelanggan Kami',
			),
			'testimonials' => array(
				'type'     => 'array',
				'default'  => array(),
			),
			'postsPerPage' => array(
				'type'     => 'number',
				'default'  => 3,
			),
		),
		'render_callback' => 'ukm_toko_render_testimonial_block',
	) );

	// ==========================================
	// 2. Registrasi Block Styles Variations (Requirement 31)
	// ==========================================
	register_block_style( 'core/button', array(
		'name'         => 'ukm-flat-button',
		'label'        => __( 'UKM Flat Button', 'ukm-toko' ),
		'inline_style' => '.is-style-ukm-flat-button { border-radius: 4px !important; box-shadow: none !important; font-weight: 600 !important; }',
	) );

	register_block_style( 'core/group', array(
		'name'         => 'ukm-card',
		'label'        => __( 'UKM Card Container', 'ukm-toko' ),
		'inline_style' => '.is-style-ukm-card { background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 6px !important; padding: 20px !important; }',
	) );
}
add_action( 'init', 'ukm_toko_register_native_blocks' );

// ==========================================
// RENDER CALLBACKS
// ==========================================

/**
 * Render Callback: Hero Banner Block (Requirement 28)
 */
function ukm_toko_render_hero_block( $attributes, $content = '' ) {
	$title    = ! empty( $attributes['title'] ) ? $attributes['title'] : 'Selamat Datang di UKM Toko Sembako';
	$subtitle = ! empty( $attributes['subtitle'] ) ? $attributes['subtitle'] : 'Sedia Kebutuhan Pokok & Sembako Murah, Lengkap, dan Terpercaya.';
	$cta_text = ! empty( $attributes['ctaText'] ) ? $attributes['ctaText'] : 'Mulai Belanja';
	$cta_url  = ! empty( $attributes['ctaUrl'] ) ? $attributes['ctaUrl'] : site_url( '/shop' );
	$bg_image = ! empty( $attributes['bgImage'] ) ? $attributes['bgImage'] : site_url( '/wp-content/uploads/2026/10/bekgron.jpg' );

	ob_start();
	?>
	<section class="ukm-hero-block" style="background-image: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('<?php echo esc_url( $bg_image ); ?>'); background-size: cover; background-position: center; border-radius: var(--ukm-radius); padding: 4rem 2rem; color: #ffffff; text-align: center; margin: 2rem 0;">
		<div class="ukm-hero-inner" style="max-width: 750px; margin: 0 auto;">
			<h2 style="font-size: 2.25rem; font-weight: 800; margin: 0 0 1rem; color: #ffffff; line-height: 1.2;">
				<?php echo esc_html( $title ); ?>
			</h2>
			<p style="font-size: 1.125rem; margin: 0 0 1.75rem; color: #e2e8f0; line-height: 1.6;">
				<?php echo esc_html( $subtitle ); ?>
			</p>
			<a href="<?php echo esc_url( $cta_url ); ?>" class="ukm-btn is-style-ukm-flat-button" style="display: inline-block; background: var(--ukm-accent); color: #ffffff; padding: 12px 28px; text-decoration: none; border-radius: 4px; font-weight: 700; font-size: 1rem;">
				<?php echo esc_html( $cta_text ); ?>
			</a>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * Render Callback: Product Grid Block (Requirement 29)
 */
function ukm_toko_render_product_grid_block( $attributes, $content = '' ) {
	$posts_per_page = ! empty( $attributes['postsPerPage'] ) ? absint( $attributes['postsPerPage'] ) : 4;
	$block_title    = ! empty( $attributes['title'] ) ? $attributes['title'] : 'Produk Unggulan';
	$category       = ! empty( $attributes['category'] ) ? sanitize_text_field( $attributes['category'] ) : '';

	$query_args = array(
		'post_type'      => 'product',
		'posts_per_page' => $posts_per_page,
		'post_status'    => 'publish',
	);

	if ( ! empty( $category ) ) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $category,
			),
		);
	}

	$products = new WP_Query( $query_args );

	ob_start();
	?>
	<section class="ukm-product-grid-block" style="margin: 2.5rem 0;">
		<?php if ( ! empty( $block_title ) ) : ?>
			<h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; text-align: center;">
				<?php echo esc_html( $block_title ); ?>
			</h3>
		<?php endif; ?>

		<?php if ( $products->have_posts() ) : ?>
			<div class="ukm-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem;">
				<?php
				while ( $products->have_posts() ) :
					$products->the_post();
					global $product;
					?>
					<div class="ukm-grid-item" style="background: var(--ukm-card-bg); border: 1px solid var(--ukm-border); border-radius: var(--ukm-radius); padding: 1rem; display: flex; flex-direction: column;">
						<div style="aspect-ratio: 1/1; overflow: hidden; border-radius: 4px; background: #f8fafc; margin-bottom: 0.75rem;">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
								</a>
							<?php endif; ?>
						</div>
						<h4 style="font-size: 0.95rem; margin: 0 0 0.5rem; line-height: 1.3;">
							<a href="<?php the_permalink(); ?>" style="color: var(--ukm-text); text-decoration: none;">
								<?php the_title(); ?>
							</a>
						</h4>
						<div style="font-weight: 700; color: var(--ukm-accent-dark); margin-top: auto;">
							<?php echo $product ? wp_kses_post( $product->get_price_html() ) : ''; ?>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<p style="text-align: center; color: var(--ukm-text-muted);"><?php esc_html_e( 'Belum ada produk yang ditampilkan.', 'ukm-toko' ); ?></p>
		<?php endif; ?>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * Render Callback: Testimonial Slider / Carousel Block (Requirement 23)
 */
function ukm_toko_render_testimonial_block( $attributes, $content = '' ) {
	$posts_per_page   = ! empty( $attributes['postsPerPage'] ) ? absint( $attributes['postsPerPage'] ) : 3;
	$block_title      = ! empty( $attributes['title'] ) ? $attributes['title'] : 'Apa Kata Mitra & Pelanggan Kami';
	$raw_testimonials = ! empty( $attributes['testimonials'] ) && is_array( $attributes['testimonials'] ) ? $attributes['testimonials'] : array();

	// Kumpulkan data testimoni (dari repeater attribute atau fallback ke CPT Klien)
	$slides = array();

	if ( ! empty( $raw_testimonials ) ) {
		foreach ( $raw_testimonials as $item ) {
			$slides[] = array(
				'name'     => ! empty( $item['name'] ) ? $item['name'] : 'Mitra UKM',
				'subtitle' => ! empty( $item['role'] ) ? $item['role'] : 'Pelanggan Setia',
				'quote'    => ! empty( $item['quote'] ) ? $item['quote'] : 'Pelayanan cepat dan pasokan sembako selalu terjamin.',
			);
		}
	} else {
		$clients = new WP_Query( array(
			'post_type'      => 'klien',
			'posts_per_page' => $posts_per_page,
			'post_status'    => 'publish',
		) );

		if ( $clients->have_posts() ) {
			while ( $clients->have_posts() ) {
				$clients->the_post();
				$lokasi   = get_post_meta( get_the_ID(), 'klien_lokasi', true );
				$slides[] = array(
					'name'     => get_the_title(),
					'subtitle' => $lokasi ?: 'Mitra Toko Kelontong',
					'quote'    => 'Pelayanan toko sembako ini sangat cepat dan harga grosir yang ditawarkan bersahabat untuk kelangsungan usaha kami.',
				);
			}
			wp_reset_postdata();
		}
	}

	ob_start();
	?>
	<section class="ukm-testimonial-block" style="margin: 2.5rem 0; padding: 2.5rem 1.5rem; background: var(--ukm-card-bg); border: 1px solid var(--ukm-border); border-radius: var(--ukm-radius);">
		<?php if ( ! empty( $block_title ) ) : ?>
			<h3 style="font-size: 1.65rem; font-weight: 800; margin-bottom: 2rem; text-align: center; color: var(--ukm-text);">
				<?php echo esc_html( $block_title ); ?>
			</h3>
		<?php endif; ?>

		<?php if ( ! empty( $slides ) ) : ?>
			<div class="ukm-slider-container" style="position: relative; overflow: hidden; max-width: 850px; margin: 0 auto;">
				<div class="ukm-slider-track" style="display: flex; transition: transform 0.4s ease-in-out;">
					<?php foreach ( $slides as $index => $slide ) : ?>
						<div class="ukm-slide" style="min-width: 100%; box-sizing: border-box; padding: 1.5rem 2rem; text-align: center;">
							<div class="is-style-ukm-card" style="background: #f8fafc; border: 1px solid var(--ukm-border); border-radius: var(--ukm-radius); padding: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
								<p style="font-style: italic; font-size: 1.1rem; color: var(--ukm-text); margin: 0 0 1.25rem; line-height: 1.6;">
									&ldquo;<?php echo esc_html( $slide['quote'] ); ?>&rdquo;
								</p>
								<div style="font-weight: 700; font-size: 1rem; color: var(--ukm-primary);">
									<?php echo esc_html( $slide['name'] ); ?>
								</div>
								<div style="font-size: 0.85rem; color: var(--ukm-text-muted); margin-top: 2px;">
									<?php echo esc_html( $slide['subtitle'] ); ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Navigasi Slider (Arrows & Dots) -->
				<div class="ukm-slider-controls" style="display: flex; justify-content: center; align-items: center; gap: 15px; margin-top: 1.5rem;">
					<button type="button" class="ukm-slider-btn ukm-prev" aria-label="Previous Slide" style="background: var(--ukm-card-bg); border: 1px solid var(--ukm-border); width: 36px; height: 36px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 700; color: var(--ukm-text);">
						&larr;
					</button>
					<div class="ukm-slider-dots" style="display: flex; gap: 8px;">
						<?php foreach ( $slides as $i => $s ) : ?>
							<span class="ukm-dot <?php echo 0 === $i ? 'is-active' : ''; ?>" data-slide="<?php echo esc_attr( $i ); ?>" style="width: 10px; height: 10px; border-radius: 50%; background: <?php echo 0 === $i ? 'var(--ukm-primary)' : 'var(--ukm-border-dark)'; ?>; cursor: pointer; display: inline-block;"></span>
						<?php endforeach; ?>
					</div>
					<button type="button" class="ukm-slider-btn ukm-next" aria-label="Next Slide" style="background: var(--ukm-card-bg); border: 1px solid var(--ukm-border); width: 36px; height: 36px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 700; color: var(--ukm-text);">
						&rarr;
					</button>
				</div>
			</div>
		<?php else : ?>
			<p style="text-align: center; color: var(--ukm-text-muted);"><?php esc_html_e( 'Belum ada testimoni klien.', 'ukm-toko' ); ?></p>
		<?php endif; ?>
	</section>
	<?php
	return ob_get_clean();
}

