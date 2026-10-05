<?php
/**
 * Custom Post Types dan Taxonomies
 *
 * @package UKM_Toko_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registrasi Custom Post Types (Produk & Klien) dan Taksonomi (kategori-produk)
 */
function ukm_toko_register_cpt_tax() {

	// ==========================================
	// 1. CPT: Produk (Requirement 17 & 18)
	// ==========================================
	$labels_produk = array(
		'name'                  => _x( 'Produk CPT', 'Post type general name', 'ukm-toko' ),
		'singular_name'         => _x( 'Produk CPT', 'Post type singular name', 'ukm-toko' ),
		'menu_name'             => _x( 'Produk CPT', 'Admin Menu text', 'ukm-toko' ),
		'name_admin_bar'        => _x( 'Produk CPT', 'Add New on Toolbar', 'ukm-toko' ),
		'add_new'               => __( 'Tambah Produk Baru', 'ukm-toko' ),
		'add_new_item'          => __( 'Tambah Produk Baru', 'ukm-toko' ),
		'new_item'              => __( 'Produk Baru', 'ukm-toko' ),
		'edit_item'             => __( 'Edit Produk', 'ukm-toko' ),
		'view_item'             => __( 'Lihat Produk', 'ukm-toko' ),
		'all_items'             => __( 'Semua Produk CPT', 'ukm-toko' ),
		'search_items'          => __( 'Cari Produk', 'ukm-toko' ),
		'not_found'             => __( 'Tidak ada produk ditemukan.', 'ukm-toko' ),
		'not_found_in_trash'    => __( 'Tidak ada produk di kotak sampah.', 'ukm-toko' ),
	);

	$args_produk = array(
		'labels'             => $labels_produk,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'produk', 'with_front' => false ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-products',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'show_in_rest'       => true,
	);

	register_post_type( 'produk', $args_produk );

	// ==========================================
	// 2. Taksonomi: kategori-produk (Requirement 21)
	// ==========================================
	$labels_kategori = array(
		'name'              => _x( 'Kategori Produk', 'taxonomy general name', 'ukm-toko' ),
		'singular_name'     => _x( 'Kategori Produk', 'taxonomy singular name', 'ukm-toko' ),
		'search_items'      => __( 'Cari Kategori', 'ukm-toko' ),
		'all_items'         => __( 'Semua Kategori', 'ukm-toko' ),
		'parent_item'       => __( 'Kategori Induk', 'ukm-toko' ),
		'parent_item_colon' => __( 'Kategori Induk:', 'ukm-toko' ),
		'edit_item'         => __( 'Edit Kategori', 'ukm-toko' ),
		'update_item'       => __( 'Perbarui Kategori', 'ukm-toko' ),
		'add_new_item'      => __( 'Tambah Kategori Baru', 'ukm-toko' ),
		'new_item_name'     => __( 'Nama Kategori Baru', 'ukm-toko' ),
		'menu_name'         => __( 'Kategori Produk', 'ukm-toko' ),
	);

	$args_kategori = array(
		'hierarchical'      => true,
		'labels'            => $labels_kategori,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'kategori-produk', 'with_front' => false ),
		'show_in_rest'      => true,
	);

	// Tautkan taksonomi ke CPT produk dan native WooCommerce product
	register_taxonomy( 'kategori-produk', array( 'produk', 'product' ), $args_kategori );

	// ==========================================
	// 3. CPT: Klien (Requirement 19 & 20)
	// ==========================================
	$labels_klien = array(
		'name'                  => _x( 'Klien', 'Post type general name', 'ukm-toko' ),
		'singular_name'         => _x( 'Klien', 'Post type singular name', 'ukm-toko' ),
		'menu_name'             => _x( 'Klien', 'Admin Menu text', 'ukm-toko' ),
		'add_new'               => __( 'Tambah Baru', 'ukm-toko' ),
		'add_new_item'          => __( 'Tambah Klien Baru', 'ukm-toko' ),
		'edit_item'             => __( 'Edit Klien', 'ukm-toko' ),
		'all_items'             => __( 'Semua Klien', 'ukm-toko' ),
	);

	$args_klien = array(
		'labels'             => $labels_klien,
		'public'             => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'menu_icon'          => 'dashicons-businessman',
		'supports'           => array( 'title', 'thumbnail' ),
		'show_in_rest'       => false,
	);

	register_post_type( 'klien', $args_klien );

	// Registrasi Post Meta untuk CPT Produk (Requirement 18)
	register_post_meta( 'produk', '_harga_produk', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback'     => function() {
			return current_user_can( 'edit_posts' );
		},
	) );

	register_post_meta( 'produk', '_stok_produk', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'integer',
		'sanitize_callback' => 'absint',
		'auth_callback'     => function() {
			return current_user_can( 'edit_posts' );
		},
	) );

	register_post_meta( 'produk', '_spesifikasi_produk', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_textarea_field',
		'auth_callback'     => function() {
			return current_user_can( 'edit_posts' );
		},
	) );

	// Registrasi Post Meta untuk Klien (Requirement 20)
	register_post_meta( 'klien', 'klien_email', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_email',
		'auth_callback'     => function() {
			return current_user_can( 'edit_posts' );
		},
	) );

	register_post_meta( 'klien', 'klien_telepon', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback'     => function() {
			return current_user_can( 'edit_posts' );
		},
	) );

	register_post_meta( 'klien', 'klien_lokasi', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback'     => function() {
			return current_user_can( 'edit_posts' );
		},
	) );
}
add_action( 'init', 'ukm_toko_register_cpt_tax' );

/**
 * Meta Box Admin untuk Informasi Kontak Klien (Requirement 20)
 */
function ukm_toko_add_klien_meta_boxes() {
	add_meta_box(
		'ukm_klien_contact_info',
		__( 'Informasi Kontak Klien', 'ukm-toko' ),
		'ukm_toko_render_klien_meta_box',
		'klien',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'ukm_toko_add_klien_meta_boxes' );

function ukm_toko_render_klien_meta_box( $post ) {
	wp_nonce_field( 'ukm_klien_meta_action', 'ukm_klien_meta_nonce' );

	$email   = get_post_meta( $post->ID, 'klien_email', true );
	$telepon = get_post_meta( $post->ID, 'klien_telepon', true );
	$lokasi  = get_post_meta( $post->ID, 'klien_lokasi', true );
	?>
	<table class="form-table">
		<tr>
			<th><label for="klien_email"><?php esc_html_e( 'Email Klien', 'ukm-toko' ); ?></label></th>
			<td>
				<input type="email" name="klien_email" id="klien_email" class="regular-text" value="<?php echo esc_attr( $email ); ?>" />
			</td>
		</tr>
		<tr>
			<th><label for="klien_telepon"><?php esc_html_e( 'Nomor Telepon', 'ukm-toko' ); ?></label></th>
			<td>
				<input type="text" name="klien_telepon" id="klien_telepon" class="regular-text" value="<?php echo esc_attr( $telepon ); ?>" />
			</td>
		</tr>
		<tr>
			<th><label for="klien_lokasi"><?php esc_html_e( 'Lokasi (Kota / Kecamatan)', 'ukm-toko' ); ?></label></th>
			<td>
				<input type="text" name="klien_lokasi" id="klien_lokasi" class="regular-text" value="<?php echo esc_attr( $lokasi ); ?>" />
			</td>
		</tr>
	</table>
	<?php
}

function ukm_toko_save_klien_meta_box( $post_id ) {
	if ( ! isset( $_POST['ukm_klien_meta_nonce'] ) || ! wp_verify_nonce( $_POST['ukm_klien_meta_nonce'], 'ukm_klien_meta_action' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['klien_email'] ) ) {
		update_post_meta( $post_id, 'klien_email', sanitize_email( $_POST['klien_email'] ) );
	}
	if ( isset( $_POST['klien_telepon'] ) ) {
		update_post_meta( $post_id, 'klien_telepon', sanitize_text_field( $_POST['klien_telepon'] ) );
	}
	if ( isset( $_POST['klien_lokasi'] ) ) {
		update_post_meta( $post_id, 'klien_lokasi', sanitize_text_field( $_POST['klien_lokasi'] ) );
	}
}
add_action( 'save_post_klien', 'ukm_toko_save_klien_meta_box' );

/**
 * Meta Box Admin untuk Spesifikasi Produk CPT (Requirement 18)
 */
function ukm_toko_add_produk_meta_boxes() {
	add_meta_box(
		'ukm_produk_specs_box',
		__( 'Spesifikasi Produk (Harga, Stok & Keterangan)', 'ukm-toko' ),
		'ukm_toko_render_produk_meta_box',
		'produk',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'ukm_toko_add_produk_meta_boxes' );

function ukm_toko_render_produk_meta_box( $post ) {
	wp_nonce_field( 'ukm_produk_meta_action', 'ukm_produk_meta_nonce' );

	$harga = get_post_meta( $post->ID, '_harga_produk', true );
	$stok  = get_post_meta( $post->ID, '_stok_produk', true );
	$specs = get_post_meta( $post->ID, '_spesifikasi_produk', true );
	?>
	<table class="form-table">
		<tr>
			<th><label for="_harga_produk"><?php esc_html_e( 'Harga Produk (Rp)', 'ukm-toko' ); ?></label></th>
			<td>
				<input type="text" name="_harga_produk" id="_harga_produk" class="regular-text" value="<?php echo esc_attr( $harga ); ?>" placeholder="Contoh: 75.000" />
			</td>
		</tr>
		<tr>
			<th><label for="_stok_produk"><?php esc_html_e( 'Jumlah Stok Tersedia', 'ukm-toko' ); ?></label></th>
			<td>
				<input type="number" name="_stok_produk" id="_stok_produk" class="small-text" min="0" value="<?php echo esc_attr( $stok !== '' ? $stok : '50' ); ?>" />
			</td>
		</tr>
		<tr>
			<th><label for="_spesifikasi_produk"><?php esc_html_e( 'Spesifikasi Teknis / Komposisi', 'ukm-toko' ); ?></label></th>
			<td>
				<textarea name="_spesifikasi_produk" id="_spesifikasi_produk" rows="4" class="large-text"><?php echo esc_textarea( $specs ); ?></textarea>
			</td>
		</tr>
	</table>
	<?php
}

function ukm_toko_save_produk_meta_box( $post_id ) {
	if ( ! isset( $_POST['ukm_produk_meta_nonce'] ) || ! wp_verify_nonce( $_POST['ukm_produk_meta_nonce'], 'ukm_produk_meta_action' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['_harga_produk'] ) ) {
		update_post_meta( $post_id, '_harga_produk', sanitize_text_field( $_POST['_harga_produk'] ) );
	}
	if ( isset( $_POST['_stok_produk'] ) ) {
		update_post_meta( $post_id, '_stok_produk', absint( $_POST['_stok_produk'] ) );
	}
	if ( isset( $_POST['_spesifikasi_produk'] ) ) {
		update_post_meta( $post_id, '_spesifikasi_produk', sanitize_textarea_field( $_POST['_spesifikasi_produk'] ) );
	}
}
add_action( 'save_post_produk', 'ukm_toko_save_produk_meta_box' );
