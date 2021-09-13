<?php
/**
 * Plugin support: WooCommerce (Elementor support)
 *
 * @package ThemeREX Addons
 * @since v1.6.52.2
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	exit;
}


// Add class 'woocommerce' to the Elementor's output
//---------------------------------------------------------------------------------------
if (!function_exists('trx_addons_woocommerce_elm_widgets_class')) {
	add_filter( 'elementor/widget/render_content', 'trx_addons_woocommerce_elm_widgets_class', 10, 2 );
	function trx_addons_woocommerce_elm_widgets_class($content, $widget=null) {
		if (is_object($widget) && strpos($widget->get_name(), 'wp-widget-woocommerce') !== false) {
			$content = str_replace('class="widget wp-widget-woocommerce', 'class="widget woocommerce wp-widget-woocommerce', $content);
		}
		return $content;
	}
}

// Add featured image output in the Elementor's edit mode
// ( by default, WooCommerce is not include file wc-template-hooks.php while Elementor loading a preview area )
//---------------------------------------------------------------------------------------
if ( ! function_exists( 'trx_addons_woocommerce_elm_add_product_thumbnails_in_edit_mode')) {
	add_action( 'woocommerce_before_shop_loop_item_title', 'trx_addons_woocommerce_elm_add_product_thumbnails_in_edit_mode', 1 );
	function trx_addons_woocommerce_elm_add_product_thumbnails_in_edit_mode() {
		if ( trx_addons_elm_is_preview()
			&& ! has_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' )
			&& function_exists( 'woocommerce_template_loop_product_thumbnail' )
		) {
			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		}
	}
}
