<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'inestio_mailchimp_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'inestio_mailchimp_theme_setup9', 9 );
	function inestio_mailchimp_theme_setup9() {
		if ( inestio_exists_mailchimp() ) {
			add_action( 'wp_enqueue_scripts', 'inestio_mailchimp_frontend_scripts', 1100 );
			add_filter( 'inestio_filter_merge_styles', 'inestio_mailchimp_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'inestio_filter_tgmpa_required_plugins', 'inestio_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'inestio_mailchimp_tgmpa_required_plugins' ) ) {
	
	function inestio_mailchimp_tgmpa_required_plugins( $list = array() ) {
		if ( inestio_storage_isset( 'required_plugins', 'mailchimp-for-wp' ) && inestio_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'install' ) !== false ) {
			$list[] = array(
				'name'     => inestio_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'title' ),
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'inestio_exists_mailchimp' ) ) {
	function inestio_exists_mailchimp() {
		return function_exists( '__mc4wp_load_plugin' ) || defined( 'MC4WP_VERSION' );
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue styles for frontend
if ( ! function_exists( 'inestio_mailchimp_frontend_scripts' ) ) {
	
	function inestio_mailchimp_frontend_scripts() {
		if ( inestio_is_on( inestio_get_theme_option( 'debug_mode' ) ) ) {
			$inestio_url = inestio_get_file_url( 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' );
			if ( '' != $inestio_url ) {
				wp_enqueue_style( 'inestio-mailchimp-for-wp', $inestio_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'inestio_mailchimp_merge_styles' ) ) {
	
	function inestio_mailchimp_merge_styles( $list ) {
		$list[] = 'plugins/mailchimp-for-wp/mailchimp-for-wp.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( inestio_exists_mailchimp() ) {
	require_once inestio_get_file_dir( 'plugins/mailchimp-for-wp/mailchimp-for-wp-style.php' );
}

