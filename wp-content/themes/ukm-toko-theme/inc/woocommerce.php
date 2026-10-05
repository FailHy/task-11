<?php
/**
 * Konfigurasi dan Kustomisasi WooCommerce
 *
 * @package UKM_Toko_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Mendeklarasikan dukungan tema terhadap WooCommerce
 */
function ukm_toko_woocommerce_setup() {
	// Deklarasi dasar
	add_theme_support( 'woocommerce' );

	// Mengaktifkan fitur galeri produk bawaan WooCommerce
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'ukm_toko_woocommerce_setup' );

// Memastikan WooCommerce menggunakan template PHP klasik tema, bukan FSE block template parent
add_filter( 'woocommerce_has_block_template', '__return_false' );



/**
 * 2. Kustomisasi WooCommerce Wrappers
 * Menyelaraskan struktur HTML WooCommerce dengan struktur tema kita
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'ukm_toko_wrapper_start', 10 );
function ukm_toko_wrapper_start() {
	echo '<main id="primary" class="site-main container" style="padding-top: 30px; padding-bottom: 50px;">';
}

add_action( 'woocommerce_after_main_content', 'ukm_toko_wrapper_end', 10 );
function ukm_toko_wrapper_end() {
	echo '</main><!-- #primary -->';
}

/**
 * 3. Hapus sidebar default WooCommerce jika tidak dibutuhkan
 * Ini membuat layout toko kita menjadi full-width
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Render ACF Product Specs Group on Single Product Summary (Requirement 23)
 */
add_action( 'woocommerce_single_product_summary', 'ukm_toko_render_acf_product_specs', 25 );
function ukm_toko_render_acf_product_specs() {
	$berat = get_post_meta( get_the_ID(), 'detail_spesifikasi_berat', true );
	$merek = get_post_meta( get_the_ID(), 'detail_spesifikasi_merek', true );
	if ( ! empty( $berat ) || ! empty( $merek ) ) {
		echo '<div class="ukm-product-specs-summary" style="margin: 15px 0; padding: 12px 16px; background: #f8fafc; border-left: 3px solid var(--ukm-primary); border-radius: 4px; font-size: 14px;">';
		echo '<strong style="display:block; margin-bottom: 4px; color: var(--ukm-primary);">' . esc_html__( 'Spesifikasi Produk (ACF):', 'ukm-toko' ) . '</strong>';
		if ( ! empty( $merek ) ) {
			echo '<div style="margin-bottom: 2px;">' . esc_html__( 'Merek / Produsen:', 'ukm-toko' ) . ' <strong>' . esc_html( $merek ) . '</strong></div>';
		}
		if ( ! empty( $berat ) ) {
			echo '<div>' . esc_html__( 'Berat / Kemasan:', 'ukm-toko' ) . ' <strong>' . esc_html( $berat ) . '</strong></div>';
		}
		echo '</div>';
	}
}


/**
 * 4. Kustomisasi Checkout (Contoh sederhana)
 * Mengubah placeholder dan label field
 */
add_filter( 'woocommerce_checkout_fields' , 'ukm_toko_custom_checkout_fields' );
function ukm_toko_custom_checkout_fields( $fields ) {
     $fields['billing']['billing_company']['label'] = 'Nama Perusahaan/Toko';
     return $fields;
}

/**
 * 5. My Account Custom Fields
 * Menambahkan field "Nomor WhatsApp" pada halaman detail akun pengguna.
 */
add_action( 'woocommerce_edit_account_form', 'ukm_toko_add_my_account_field' );
function ukm_toko_add_my_account_field() {
	$user = wp_get_current_user();
	?>
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="account_whatsapp">Nomor WhatsApp <span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_whatsapp" id="account_whatsapp" value="<?php echo esc_attr( get_user_meta( $user->ID, 'account_whatsapp', true ) ); ?>" required />
	</p>
	<?php
}

add_action( 'woocommerce_save_account_details', 'ukm_toko_save_my_account_field' );
function ukm_toko_save_my_account_field( $user_id ) {
	if ( isset( $_POST['account_whatsapp'] ) ) {
		$whatsapp = sanitize_text_field( wp_unslash( $_POST['account_whatsapp'] ) );
		$clean = preg_replace( '/[\s\-]/', '', $whatsapp );
		if ( empty( $whatsapp ) || preg_match( '/^(\+?62|08)[0-9]{7,13}$/', $clean ) ) {
			update_user_meta( $user_id, 'account_whatsapp', $whatsapp );
		}
	}
}

/**
 * 6. AJAX Cart Fragments
 * Memperbarui angka keranjang belanja secara real-time tanpa refresh halaman
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'ukm_toko_cart_link_fragment' );
function ukm_toko_cart_link_fragment( $fragments ) {
	ob_start();
	?>
	<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'Lihat keranjang belanja Anda', 'ukm-toko' ); ?>" style="text-decoration:none; color:#333; font-weight:bold;">
		<svg class="cart-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" style="vertical-align:-2px; margin-right:4px;"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>Keranjang: <span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> 
		(<span class="count"><?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'ukm-toko' ), WC()->cart->get_cart_contents_count() ) ); ?></span>)
	</a>
	<?php
	$fragments['a.cart-contents'] = ob_get_clean();
	return $fragments;
}


/**
 * 7. Inject ACF Gallery into WooCommerce Native Gallery
 * Menggabungkan gambar dari field ACF ke slider galeri bawaan Woo.
 */
add_filter( 'woocommerce_product_get_gallery_image_ids', 'ukm_toko_merge_acf_gallery', 10, 2 );
function ukm_toko_merge_acf_gallery( $image_ids, $product ) {
	$acf_gallery = get_field( 'galeri_gambar_acf', $product->get_id() );
	if ( ! empty( $acf_gallery ) && is_array( $acf_gallery ) ) {
		foreach ( $acf_gallery as $image ) {
			// Memasukkan ID gambar ACF ke dalam array antrean WooCommerce
			$image_ids[] = $image['ID'];
		}
	}
	return $image_ids;
}

/**
 * 8. Render ACF Group (Specs) & Repeater (Variants)
 * Ditampilkan di bawah blok meta (kategori/tag) pada Single Product
 */
add_action( 'woocommerce_product_meta_end', 'ukm_toko_display_acf_specs' );
function ukm_toko_display_acf_specs() {
	global $product;
	$id = $product->get_id();

	// A. Render Group Field (Detail Spesifikasi)
	$specs = get_field( 'detail_spesifikasi', $id );
	if ( ! empty( $specs ) && ( ! empty( $specs['berat'] ) || ! empty( $specs['merek'] ) ) ) {
		echo '<div class="ukm-acf-specs product-extra-meta">';
		echo '<h4>Spesifikasi Detail</h4>';
		echo '<ul>';
		if ( ! empty( $specs['berat'] ) ) {
			echo '<li><strong>Berat:</strong> ' . esc_html( $specs['berat'] ) . '</li>';
		}
		if ( ! empty( $specs['merek'] ) ) {
			echo '<li><strong>Merek:</strong> ' . esc_html( $specs['merek'] ) . '</li>';
		}
		echo '</ul>';
		echo '</div>';
	}

	// B. Render Repeater Field (Varian Ekstra)
	if ( function_exists('have_rows') && have_rows( 'varian_produk_repeater', $id ) ) {
		echo '<div class="ukm-acf-variants product-extra-meta">';
		echo '<h4>Pilihan Varian</h4>';
		echo '<ul>';
		while ( have_rows( 'varian_produk_repeater', $id ) ) {
			the_row();
			$nama_varian  = get_sub_field( 'nama_varian' );
			$nilai_varian = get_sub_field( 'nilai_varian' );
			echo '<li><strong>' . esc_html( $nama_varian ) . ':</strong> ' . esc_html( $nilai_varian ) . '</li>';
		}
		echo '</ul>';
		echo '</div>';
	}
}

/**
 * 9. Konfigurasi Batas Input Kuantitas (Frontend HTML5)
 */
add_filter( 'woocommerce_quantity_input_args', 'ukm_toko_quantity_input_args', 10, 2 );
function ukm_toko_quantity_input_args( $args, $product ) {
	if ( is_null( $product ) ) {
		return $args;
	}

	$max_purchase_limit = 20;

	$stock = $product->get_stock_quantity();
	if ( $product->managing_stock() && ! is_null( $stock ) ) {
		$args['max_value'] = min( $stock, $max_purchase_limit );
	} else {
		$args['max_value'] = $max_purchase_limit;
	}

	$args['min_value'] = 1;
	$args['step']      = 1;

	return $args;
}

/**
 * Batasi Kuantitas yang Masuk ke Keranjang (Defense in Depth)
 */
add_filter( 'woocommerce_add_to_cart_quantity', 'ukm_toko_filter_add_to_cart_quantity', 10, 2 );
function ukm_toko_filter_add_to_cart_quantity( $quantity, $product_id ) {
	$max_purchase_limit = 20;
	if ( $quantity > $max_purchase_limit ) {
		return $max_purchase_limit;
	}
	return intval( $quantity );
}

/**
 * 10. Validasi Server-Side Kuantitas Saat Tambah ke Keranjang (Anti-Abuse)
 */
add_filter( 'woocommerce_add_to_cart_validation', 'ukm_toko_validate_add_to_cart_quantity', 10, 5 );
function ukm_toko_validate_add_to_cart_quantity( $passed, $product_id, $quantity, $variation_id = 0, $variations = array() ) {
	$max_purchase_limit = 20;

	// Periksa jika ada input eksplisit quantity dari request (mencegah bypass quantity=0)
	if ( isset( $_REQUEST['quantity'] ) ) {
		$raw_qty = wp_unslash( $_REQUEST['quantity'] );
		if ( $raw_qty !== '' && ( ! is_numeric( $raw_qty ) || intval( $raw_qty ) != $raw_qty || floatval( $raw_qty ) <= 0 ) ) {
			wc_add_notice( __( 'Jumlah pesanan tidak valid. Harap masukkan bilangan bulat positif minimal 1.', 'ukm-toko' ), 'error' );
			return false;
		}
	}

	// A. Validasi bilangan bulat positif
	if ( ! is_numeric( $quantity ) || intval( $quantity ) != $quantity || $quantity <= 0 ) {
		wc_add_notice( __( 'Jumlah pesanan tidak valid. Harap masukkan bilangan bulat positif minimal 1.', 'ukm-toko' ), 'error' );
		return false;
	}

	$quantity = intval( $quantity );

	// B. Validasi batas maksimal per pembelian
	if ( $quantity > $max_purchase_limit ) {
		wc_add_notice( sprintf(
			/* translators: %d: maximum allowed quantity */
			__( 'Maaf, batas maksimum pembelian per transaksi untuk produk ini adalah %d unit.', 'ukm-toko' ),
			$max_purchase_limit
		), 'error' );
		return false;
	}

	// C. Validasi ketersediaan stok riil dan akumulasi di keranjang
	$product = wc_get_product( $product_id );
	if ( $product && $product->managing_stock() ) {
		$stock = $product->get_stock_quantity();

		$current_cart_qty = 0;
		if ( ! is_null( WC()->cart ) ) {
			foreach ( WC()->cart->get_cart() as $cart_item ) {
				if ( $cart_item['product_id'] == $product_id ) {
					$current_cart_qty += $cart_item['quantity'];
				}
			}
		}

		$total_requested = $current_cart_qty + $quantity;

		if ( $total_requested > $stock ) {
			wc_add_notice( sprintf(
				/* translators: 1: stock available, 2: current quantity in cart */
				__( 'Jumlah pesanan melebihi stok yang tersedia. Stok tersisa: %1$d unit (sudah ada %2$d unit di keranjang Anda).', 'ukm-toko' ),
				$stock,
				$current_cart_qty
			), 'error' );
			return false;
		}

		if ( $total_requested > $max_purchase_limit ) {
			wc_add_notice( sprintf(
				/* translators: %d: maximum limit */
				__( 'Total produk ini di keranjang Anda akan melebihi batas maksimum pembelian (%d unit).', 'ukm-toko' ),
				$max_purchase_limit
			), 'error' );
			return false;
		}
	}

	return $passed;
}

/**
 * 11. Validasi Server-Side Saat Memperbarui Kuantitas di Halaman Keranjang
 */
add_filter( 'woocommerce_update_cart_validation', 'ukm_toko_validate_update_cart_quantity', 10, 4 );
function ukm_toko_validate_update_cart_quantity( $passed, $cart_item_key, $values, $quantity ) {
	$max_purchase_limit = 20;

	// A. Validasi bilangan bulat non-negatif
	if ( $quantity < 0 || ! is_numeric( $quantity ) || intval( $quantity ) != $quantity ) {
		wc_add_notice( __( 'Jumlah produk di keranjang tidak valid. Nilai tidak boleh negatif atau pecahan.', 'ukm-toko' ), 'error' );
		return false;
	}

	$quantity = intval( $quantity );

	if ( $quantity === 0 ) {
		return $passed; // Biarkan WooCommerce menghapus item secara normal jika nilai 0
	}

	// B. Validasi batas maksimal per pembelian
	if ( $quantity > $max_purchase_limit ) {
		wc_add_notice( sprintf(
			/* translators: %d: maximum allowed quantity */
			__( 'Maaf, batas maksimum pembelian untuk produk ini adalah %d unit.', 'ukm-toko' ),
			$max_purchase_limit
		), 'error' );
		return false;
	}

	// C. Validasi stok produk
	$product = isset( $values['data'] ) ? $values['data'] : null;
	if ( $product && $product->managing_stock() ) {
		$stock = $product->get_stock_quantity();
		if ( $quantity > $stock ) {
			wc_add_notice( sprintf(
				/* translators: %d: stock available */
				__( 'Jumlah pesanan melebihi stok yang tersedia. Stok saat ini hanya %d unit.', 'ukm-toko' ),
				$stock
			), 'error' );
			return false;
		}
	}

	return $passed;
}

/**
 * 12. Validasi Nomor WhatsApp & Batas Panjang Input di Checkout
 */
add_action( 'woocommerce_after_checkout_validation', 'ukm_toko_validate_checkout_fields', 10, 2 );
function ukm_toko_validate_checkout_fields( $data, $errors ) {
	// A. Validasi nomor telepon/WhatsApp
	if ( ! empty( $data['billing_phone'] ) ) {
		$clean_phone = preg_replace( '/[\s\-]/', '', $data['billing_phone'] );
		if ( ! preg_match( '/^(\+?62|08)[0-9]{7,13}$/', $clean_phone ) ) {
			$errors->add( 'validation', __( 'Nomor telepon tidak valid. Harap gunakan format nomor Indonesia yang benar (contoh: 08123456789 atau +628123456789).', 'ukm-toko' ) );
		}
	}

	// B. Batasi panjang karakter untuk mencegah DoS / buffer overflow
	if ( ! empty( $data['billing_first_name'] ) && mb_strlen( $data['billing_first_name'] ) > 50 ) {
		$errors->add( 'validation', __( 'Nama depan maksimal 50 karakter.', 'ukm-toko' ) );
	}
	if ( ! empty( $data['billing_last_name'] ) && mb_strlen( $data['billing_last_name'] ) > 50 ) {
		$errors->add( 'validation', __( 'Nama belakang maksimal 50 karakter.', 'ukm-toko' ) );
	}
	if ( ! empty( $data['billing_address_1'] ) && mb_strlen( $data['billing_address_1'] ) > 200 ) {
		$errors->add( 'validation', __( 'Alamat maksimal 200 karakter.', 'ukm-toko' ) );
	}
	if ( ! empty( $data['order_comments'] ) && mb_strlen( $data['order_comments'] ) > 500 ) {
		$errors->add( 'validation', __( 'Catatan pesanan maksimal 500 karakter.', 'ukm-toko' ) );
	}
}

