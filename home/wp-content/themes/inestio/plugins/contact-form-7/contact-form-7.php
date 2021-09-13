<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'inestio_cf7_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'inestio_cf7_theme_setup9', 9 );
	function inestio_cf7_theme_setup9() {
		if ( inestio_exists_cf7() ) {
			add_action( 'wp_enqueue_scripts', 'inestio_cf7_frontend_scripts', 1100 );
			add_filter( 'inestio_filter_merge_scripts', 'inestio_cf7_merge_scripts' );
		}
		if ( is_admin() ) {
			add_filter( 'inestio_filter_tgmpa_required_plugins', 'inestio_cf7_tgmpa_required_plugins' );
			add_filter( 'inestio_filter_theme_plugins', 'inestio_cf7_theme_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'inestio_cf7_tgmpa_required_plugins' ) ) {
	
	function inestio_cf7_tgmpa_required_plugins( $list = array() ) {
		if ( inestio_storage_isset( 'required_plugins', 'contact-form-7' ) && inestio_storage_get_array( 'required_plugins', 'contact-form-7', 'install' ) !== false ) {
			// CF7 plugin
			$list[] = array(
				'name'     => inestio_storage_get_array( 'required_plugins', 'contact-form-7', 'title' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			);
			// CF7 extension - datepicker
			if ( ! INESTIO_THEME_FREE && inestio_is_theme_activated() ) {
				$params = array(
					'name'     => esc_html__( 'Contact Form 7 Datepicker', 'inestio' ),
					'slug'     => 'contact-form-7-datepicker',
					'version'  => '2.6.0',
					'required' => false,
				);
				$path   = inestio_get_plugin_source_path( 'plugins/contact-form-7/contact-form-7-datepicker.zip' );
				if ( '' != $path ) {
					$params['source'] = $path;
				}
				$list[] = $params;
			}
		}
		return $list;
	}
}

// Filter theme-supported plugins list
if ( ! function_exists( 'inestio_cf7_theme_plugins' ) ) {
	
	function inestio_cf7_theme_plugins( $list = array() ) {
		if ( ! empty( $list['contact-form-7']['group'] ) ) {
			foreach ( $list as $k => $v ) {
				if ( substr( $k, 0, 15 ) == 'contact-form-7-' ) {
					if ( empty( $v['group'] ) ) {
						$list[ $k ]['group'] = $list['contact-form-7']['group'];
					}
					if ( empty( $v['logo'] ) ) {
						$logo = inestio_get_file_url( "plugins/contact-form-7/{$k}.png" );
						$list[ $k ]['logo'] = empty( $logo )
												? ( ! empty( $list['contact-form-7']['logo'] )
													? ( strpos( $list['contact-form-7']['logo'], '//' ) !== false
														? $list['contact-form-7']['logo']
														: inestio_get_file_url( "plugins/contact-form-7/{$list['contact-form-7']['logo']}" )
														)
													: ''
													)
												: $logo;
					}
				}
			}
		}
		return $list;
	}
}



// Check if cf7 installed and activated
if ( ! function_exists( 'inestio_exists_cf7' ) ) {
	function inestio_exists_cf7() {
		return class_exists( 'WPCF7' );
	}
}

// Enqueue custom scripts
if ( ! function_exists( 'inestio_cf7_frontend_scripts' ) ) {
	
	function inestio_cf7_frontend_scripts() {
		if ( inestio_is_on( inestio_get_theme_option( 'debug_mode' ) ) ) {
			$inestio_url = inestio_get_file_url( 'plugins/contact-form-7/contact-form-7.js' );
			if ( '' != $inestio_url ) {
				wp_enqueue_script( 'inestio-contact-form-7', $inestio_url, array( 'jquery' ), null, true );
			}
		}
	}
}

// Merge custom scripts
if ( ! function_exists( 'inestio_cf7_merge_scripts' ) ) {
	
	function inestio_cf7_merge_scripts( $list ) {
		$list[] = 'plugins/contact-form-7/contact-form-7.js';
		return $list;
	}
}
