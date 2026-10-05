<?php
/**
 * The template for displaying archive pages
 *
 * @package UKM_Toko_Theme
 */

if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_product_taxonomy() || is_post_type_archive( 'product' ) ) ) {
	wc_get_template( 'archive-product.php' );
	return;
}

if ( is_post_type_archive( 'produk' ) || is_tax( 'kategori-produk' ) ) {
	get_template_part( 'archive', 'produk' );
	return;
}

get_header();
?>

<main id="primary" class="site-main container">

	<?php if ( have_posts() ) : ?>

		<header class="page-header" style="margin-bottom: 30px;">
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header><!-- .page-header -->

		<div class="archive-loop">
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="margin-bottom: 40px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
					<header class="entry-header">
						<?php
						the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark" style="text-decoration:none; color:#333;">', esc_url( get_permalink() ) ), '</a></h2>' );
						?>

						<?php if ( 'post' === get_post_type() ) : ?>
						<div class="entry-meta">
							<span class="posted-on">Dipublikasikan pada: <?php echo get_the_date(); ?></span>
							<span class="byline"> oleh <?php the_author(); ?></span>
						</div><!-- .entry-meta -->
						<?php endif; ?>
					</header><!-- .entry-header -->

					<div class="entry-summary" style="margin-top: 15px;">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
				</article><!-- #post-<?php the_ID(); ?> -->

				<?php
			endwhile;

			the_posts_navigation( array(
				'prev_text' => 'Postingan Lama',
				'next_text' => 'Postingan Baru'
			) );

		else :
			?>
			
			<section class="no-results not-found">
				<header class="page-header">
					<h1 class="page-title">Tidak ada yang ditemukan</h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p>Sepertinya kami tidak dapat menemukan apa yang Anda cari. Mungkin pencarian bisa membantu.</p>
					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .no-results -->

			<?php
		endif;
		?>
		</div>

</main><!-- #primary -->

<?php
get_footer();
