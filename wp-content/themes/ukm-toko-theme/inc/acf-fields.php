<?php
/**
 * Registrasi Field Advanced Custom Fields (ACF) & Settings Fallback
 *
 * @package UKM_Toko_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 1. Tambahkan Options Page jika ACF Pro tersedia (Requirement 27)
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page( array(
		'page_title' => 'Pengaturan Toko (Global)',
		'menu_title' => 'Pengaturan Toko',
		'menu_slug'  => 'ukm-toko-settings',
		'capability' => 'edit_posts',
		'redirect'   => false,
		'icon_url'   => 'dashicons-store',
	) );
}

// 2. Native WordPress Settings API Fallback untuk Pengaturan Toko Global
// Solusi graceful degradation untuk ACF Free agar opsi toko tetap ada di admin
function ukm_toko_register_settings_fallback() {
	add_options_page(
		__( 'Pengaturan UKM Toko', 'ukm-toko' ),
		__( 'Pengaturan UKM Toko', 'ukm-toko' ),
		'manage_options',
		'ukm-toko-settings',
		'ukm_toko_render_settings_page'
	);

	register_setting( 'ukm_toko_settings_group', 'ukm_toko_whatsapp' );
	register_setting( 'ukm_toko_settings_group', 'ukm_toko_alamat' );
	register_setting( 'ukm_toko_settings_group', 'ukm_toko_jam_operasional' );
}
add_action( 'admin_menu', 'ukm_toko_register_settings_fallback' );

function ukm_toko_render_settings_page() {
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'ukm_toko_settings_group' );
			do_settings_sections( 'ukm_toko_settings_group' );
			?>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="ukm_toko_whatsapp">Nomor WhatsApp Layanan</label></th>
					<td><input type="text" name="ukm_toko_whatsapp" id="ukm_toko_whatsapp" value="<?php echo esc_attr( get_option( 'ukm_toko_whatsapp', '6281234567890' ) ); ?>" class="regular-text" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="ukm_toko_alamat">Alamat Toko Fisik</label></th>
					<td><textarea name="ukm_toko_alamat" id="ukm_toko_alamat" class="large-text" rows="3"><?php echo esc_textarea( get_option( 'ukm_toko_alamat', 'Jl. Merdeka No. 123, Jakarta' ) ); ?></textarea></td>
				</tr>
				<tr>
					<th scope="row"><label for="ukm_toko_jam_operasional">Jam Operasional Toko</label></th>
					<td><input type="text" name="ukm_toko_jam_operasional" id="ukm_toko_jam_operasional" value="<?php echo esc_attr( get_option( 'ukm_toko_jam_operasional', 'Senin - Sabtu: 08:00 - 20:00' ) ); ?>" class="regular-text" /></td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

// 3. Registrasi Field Group ACF untuk Spesifikasi Produk (Requirement 23)
add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// ==========================================
	// FIELD GROUP: Spesifikasi Data Produk (ACF Group Field)
	// ==========================================
	acf_add_local_field_group( array(
		'key'      => 'group_produk_specs',
		'title'    => 'Ekstra Spesifikasi Produk (ACF)',
		'fields'   => array(
			// Field Harga (Requirement 11)
			array(
				'key'          => 'field_produk_harga',
				'label'        => 'Harga Produk (Rp)',
				'name'         => 'harga',
				'type'         => 'text',
				'instructions' => 'Harga jual komoditas produk dalam Rupiah (misal: 75.000)',
			),
			// Field Stok (Requirement 11)
			array(
				'key'           => 'field_produk_stok',
				'label'         => 'Jumlah Stok Fisik',
				'name'          => 'stok',
				'type'          => 'number',
				'instructions'  => 'Jumlah ketersediaan barang di gudang/toko',
				'default_value' => 50,
			),
			// GROUP FIELD: Spesifikasi Detail (Requirement 23)
			array(
				'key'        => 'field_produk_detail_specs',
				'label'      => 'Detail Spesifikasi',
				'name'       => 'detail_spesifikasi',
				'type'       => 'group',
				'layout'     => 'block',
				'sub_fields' => array(
					array(
						'key'    => 'field_produk_berat',
						'label'  => 'Berat / Kemasan',
						'name'   => 'berat',
						'type'   => 'text',
						'append' => 'kg / liter / pack',
					),
					array(
						'key'   => 'field_produk_merek',
						'label' => 'Merek / Pabrik',
						'name'  => 'merek',
						'type'  => 'text',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'product',
				),
			),
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'produk',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => 'Spesifikasi produk sembako dan retail UKM.',
	) );
} );
