<?php
/* ThemeREX Popup support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'inestio_trx_popup_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'inestio_trx_popup_theme_setup9', 9 );
	function inestio_trx_popup_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'inestio_filter_tgmpa_required_plugins', 'inestio_trx_popup_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'inestio_trx_popup_tgmpa_required_plugins' ) ) {
	
	function inestio_trx_popup_tgmpa_required_plugins( $list = array() ) {
		if ( inestio_storage_isset( 'required_plugins', 'trx_popup' ) && inestio_storage_get_array( 'required_plugins', 'trx_popup', 'install' ) !== false && inestio_is_theme_activated() ) {
			$path = inestio_get_plugin_source_path( 'plugins/trx_popup/trx_popup.zip' );
			if ( ! empty( $path ) || inestio_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => inestio_storage_get_array( 'required_plugins', 'trx_popup', 'title' ),
					'slug'     => 'trx_popup',
					'source'   => ! empty( $path ) ? $path : 'upload://trx_popup.zip',
					'version'  => '1.1.3',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'inestio_exists_trx_popup' ) ) {
	function inestio_exists_trx_popup() {
		return defined( 'TRX_POPUP_URL' );
	}
}
