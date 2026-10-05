<?php
/**
 * The template for displaying all single posts (Blog)
 *
 * @package UKM_Toko_Theme
 */

get_header();
?>

<main id="primary" class="site-main container">

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

				<div class="entry-meta">
					<span class="posted-on">Dipublikasikan pada: <?php echo get_the_date(); ?></span>
					<span class="byline"> oleh <?php the_author(); ?></span>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="post-thumbnail mt-20">
					<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="entry-content mt-20">
				<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Halaman:', 'ukm-toko' ),
					'after'  => '</div>',
				) );
				?>
			</div>

			<footer class="entry-footer mt-20 pt-10 border-top">
				<div class="cat-links">Kategori: <?php the_category( ', ' ); ?></div>
			</footer>
		</article>

		<?php
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

		the_post_navigation( array(
			'prev_text' => '<span class="nav-subtitle">Sebelumnya:</span> <span class="nav-title">%title</span>',
			'next_text' => '<span class="nav-subtitle">Selanjutnya:</span> <span class="nav-title">%title</span>',
		) );

	endwhile;
	?>

</main>

<?php
get_footer();
