<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package UKM_Toko_Theme
 */

get_header();
?>

<main id="primary" class="site-main container">

	<section class="error-404 not-found" style="text-align: center; padding: 50px 0;">
		<header class="page-header">
			<h1 class="page-title" style="font-size: 4em; margin-bottom: 20px;">404</h1>
			<h2 class="page-subtitle">Halaman Tidak Ditemukan</h2>
		</header><!-- .page-header -->

		<div class="page-content" style="max-width: 600px; margin: 0 auto;">
			<p>Sepertinya tidak ada yang ditemukan di lokasi ini. Cobalah kembali ke <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a> atau gunakan fitur pencarian di bawah ini.</p>

			<div style="margin-top: 30px;">
				<?php get_search_form(); ?>
			</div>
		</div><!-- .page-content -->
	</section><!-- .error-404 -->

</main><!-- #primary -->

<?php
get_footer();
