<?php
/* ThemeREX Updater support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'inestio_trx_updater_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'inestio_trx_updater_theme_setup9', 9 );
	function inestio_trx_updater_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'inestio_filter_tgmpa_required_plugins', 'inestio_trx_updater_tgmpa_required_plugins', 8 );
		}
	}
}

// Filter to add in the required plugins list
// Priority 8 is used to add this plugin before all other plugins
if ( ! function_exists( 'inestio_trx_updater_tgmpa_required_plugins' ) ) {
	
	function inestio_trx_updater_tgmpa_required_plugins( $list = array() ) {
		if ( inestio_storage_isset( 'required_plugins', 'trx_updater' ) && inestio_storage_get_array( 'required_plugins', 'trx_updater', 'install' ) !== false && inestio_is_theme_activated() ) {
			$path = inestio_get_plugin_source_path( 'plugins/trx_updater/trx_updater.zip' );
			if ( ! empty( $path ) || inestio_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => inestio_storage_get_array( 'required_plugins', 'trx_updater', 'title' ),
					'slug'     => 'trx_updater',
					'source'   => ! empty( $path ) ? $path : 'upload://trx_updater.zip',
					'version'  => '1.8.0',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'inestio_exists_trx_updater' ) ) {
	function inestio_exists_trx_updater() {
		return defined( 'TRX_UPDATER_VERSION' );
	}
}
