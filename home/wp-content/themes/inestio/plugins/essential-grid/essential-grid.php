<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'inestio_essential_grid_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'inestio_essential_grid_theme_setup9', 9 );
	function inestio_essential_grid_theme_setup9() {
		if ( inestio_exists_essential_grid() ) {
			add_action( 'wp_enqueue_scripts', 'inestio_essential_grid_frontend_scripts', 1100 );
			add_filter( 'inestio_filter_merge_styles', 'inestio_essential_grid_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'inestio_filter_tgmpa_required_plugins', 'inestio_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'inestio_essential_grid_tgmpa_required_plugins' ) ) {
	
	function inestio_essential_grid_tgmpa_required_plugins( $list = array() ) {
		if ( inestio_storage_isset( 'required_plugins', 'essential-grid' ) && inestio_storage_get_array( 'required_plugins', 'essential-grid', 'install' ) !== false && inestio_is_theme_activated() ) {
			$path = inestio_get_plugin_source_path( 'plugins/essential-grid/essential-grid.zip' );
			if ( ! empty( $path ) || inestio_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => inestio_storage_get_array( 'required_plugins', 'essential-grid', 'title' ),
					'slug'     => 'essential-grid',
					'source'   => ! empty( $path ) ? $path : 'upload://essential-grid.zip',
					'version'  => '3.0.11',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'inestio_exists_essential_grid' ) ) {
	function inestio_exists_essential_grid() {
		return defined( 'EG_PLUGIN_PATH' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'inestio_essential_grid_frontend_scripts' ) ) {
	
	function inestio_essential_grid_frontend_scripts() {
		if ( inestio_is_on( inestio_get_theme_option( 'debug_mode' ) ) ) {
			$inestio_url = inestio_get_file_url( 'plugins/essential-grid/essential-grid.css' );
			if ( '' != $inestio_url ) {
				wp_enqueue_style( 'inestio-essential-grid', $inestio_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'inestio_essential_grid_merge_styles' ) ) {
	
	function inestio_essential_grid_merge_styles( $list ) {
		$list[] = 'plugins/essential-grid/essential-grid.css';
		return $list;
	}
}

