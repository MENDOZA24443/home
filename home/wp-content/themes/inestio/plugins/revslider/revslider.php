<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'inestio_revslider_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'inestio_revslider_theme_setup9', 9 );
	function inestio_revslider_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'inestio_filter_tgmpa_required_plugins', 'inestio_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'inestio_revslider_tgmpa_required_plugins' ) ) {
	
	function inestio_revslider_tgmpa_required_plugins( $list = array() ) {
		if ( inestio_storage_isset( 'required_plugins', 'revslider' ) && inestio_storage_get_array( 'required_plugins', 'revslider', 'install' ) !== false && inestio_is_theme_activated() ) {
			$path = inestio_get_plugin_source_path( 'plugins/revslider/revslider.zip' );
			if ( ! empty( $path ) || inestio_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => inestio_storage_get_array( 'required_plugins', 'revslider', 'title' ),
					'slug'     => 'revslider',
					'source'   => ! empty( $path ) ? $path : 'upload://revslider.zip',
					'version'  => '6.4.11',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( ! function_exists( 'inestio_exists_revslider' ) ) {
	function inestio_exists_revslider() {
		return function_exists( 'rev_slider_shortcode' );
	}
}
