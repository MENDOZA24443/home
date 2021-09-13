<?php
/**
 * Shortcode: Countdown
 *
 * @package ThemeREX Addons
 * @since v1.4.3
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	exit;
}



// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_countdown_load_scripts_front' ) ) {
	add_action( "wp_enqueue_scripts", 'trx_addons_sc_countdown_load_scripts_front', TRX_ADDONS_ENQUEUE_SCRIPTS_PRIORITY );
	add_action( 'trx_addons_action_pagebuilder_preview_scripts', 'trx_addons_sc_countdown_load_scripts_front', 10, 1 );
	function trx_addons_sc_countdown_load_scripts_front( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
							( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) && trx_addons_is_on( trx_addons_get_option('debug_mode') ) )
							|| ( ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) )
								&& ( $force === true
									|| trx_addons_is_preview()
									|| trx_addons_sc_check_in_content( array(	// or if a shortcode is present in the current page
											'sc' => 'sc_countdown',
											'entries' => array(
												array( 'type' => 'sc',  'sc' => 'trx_sc_countdown' ),
												array( 'type' => 'gb',  'sc' => 'wp:trx-addons/countdown' ),
												array( 'type' => 'elm', 'sc' => '"widgetType":"trx_sc_countdown"' ),
												array( 'type' => 'elm', 'sc' => '"shortcode":"[trx_sc_countdown' ),
											)
										) )
									)
								)
							)
		) {
			$loaded = true;
			// Don't load styles for Gutenberg editor because they are added as editor styles
			if ( $force !== 'gutenberg' && ! trx_addons_is_preview( 'gutenberg' ) ) {
				wp_enqueue_style( 'trx_addons-sc_countdown', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.css'), array(), null );
			}
			if ( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) )
				&& trx_addons_is_on( trx_addons_get_option('debug_mode') )
				&& trx_addons_is_preview( 'gutenberg' )
 			) {
 				// Don't load scripts for Gutenberg editor in debug_mode when optimization is off
 				// because all scripts are merged to the single file
			} else {
				wp_enqueue_script( 'jquery-plugin', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/jquery.plugin.js'), array('jquery'), null, true );
				wp_enqueue_script( 'jquery-countdown', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/jquery.countdown.js'), array('jquery'), null, true );
				wp_enqueue_script( 'trx_addons-sc_countdown', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.js'), array('jquery'), null, true );
			}
			do_action( 'trx_addons_action_load_scripts_front', $force, 'sc_countdown' );
		}
	}
}

// Enqueue responsive styles for frontend
if ( ! function_exists( 'trx_addons_sc_countdown_load_scripts_front_responsive' ) ) {
	add_action( 'wp_enqueue_scripts', 'trx_addons_sc_countdown_load_scripts_front_responsive', TRX_ADDONS_ENQUEUE_RESPONSIVE_PRIORITY );
	add_action( 'trx_addons_action_load_scripts_front_sc_countdown', 'trx_addons_sc_countdown_load_scripts_front_responsive', 10, 1 );
	function trx_addons_sc_countdown_load_scripts_front_responsive( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
			current_action() == 'wp_enqueue_scripts' && trx_addons_need_frontend_scripts( 'sc_countdown' )
			||
			current_action() != 'wp_enqueue_scripts' && $force === true
			)
		) {
			$loaded = true;
			if ( ! trx_addons_is_preview( 'gutenberg' ) ) {
				wp_enqueue_style( 'trx_addons-sc_countdown-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.responsive.css'), array(), null, trx_addons_media_for_load_css_responsive( 'sc-countdown', 'sm' ) );
			}
		}
	}
}
	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_countdown_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_countdown_merge_styles');
	function trx_addons_sc_countdown_merge_styles($list) {
		if ( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.css';
		}
		return $list;
	}
}

// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_countdown_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_countdown_merge_styles_responsive');
	function trx_addons_sc_countdown_merge_styles_responsive($list) {
		if ( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.responsive.css';
		}
		return $list;
	}
}

// Merge countdown specific scripts into single file
if ( !function_exists( 'trx_addons_sc_countdown_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_countdown_merge_scripts');
	function trx_addons_sc_countdown_merge_scripts($list) {
		if ( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/jquery.plugin.js';
			$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/jquery.countdown.js';
			$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.js';
		}
		return $list;
	}
}

// Add styles to the Gutenberg editor
if ( !function_exists( 'trx_addons_sc_countdown_add_editor_style' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'trx_addons_sc_countdown_add_editor_style', TRX_ADDONS_ENQUEUE_SCRIPTS_PRIORITY );
	function trx_addons_sc_countdown_add_editor_style( $styles ) {
		if ( ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$styles[] = trx_addons_get_file_url( TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.css' );
		}
		return $styles;
	}
}

// Add responsive styles to the Gutenberg editor
if ( !function_exists( 'trx_addons_sc_countdown_add_editor_style_responsive' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'trx_addons_sc_countdown_add_editor_style_responsive', TRX_ADDONS_ENQUEUE_RESPONSIVE_PRIORITY );
	function trx_addons_sc_countdown_add_editor_style_responsive( $styles ) {
		if ( ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$styles[] = trx_addons_get_file_url( TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.responsive.css' );
		}
		return $styles;
	}
}


// Load styles and scripts if present in the cache of the menu
if ( !function_exists( 'trx_addons_sc_countdown_check_in_html_output' ) ) {
//	add_filter( 'trx_addons_filter_get_menu_cache_html', 'trx_addons_sc_countdown_check_in_html_output', 10, 1 );
	add_action( 'trx_addons_action_show_layout_from_cache', 'trx_addons_sc_countdown_check_in_html_output', 10, 1 );
	add_action( 'trx_addons_action_check_page_content', 'trx_addons_sc_countdown_check_in_html_output', 10, 1 );
	function trx_addons_sc_countdown_check_in_html_output( $content = '' ) {
		if ( ! trx_addons_need_frontend_scripts( 'sc_countdown' )
			&& ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) )
		) {
			$checklist = apply_filters( 'trx_addons_filter_check_in_html', array(
							'class=[\'"][^\'"]*sc_countdown'
							),
							'sc_countdown'
						);
			foreach ( $checklist as $item ) {
				if ( preg_match( "#{$item}#", $content, $matches ) ) {
					trx_addons_sc_countdown_load_scripts_front( true );
					break;
				}
			}
		}
		return $content;
	}
}



// trx_sc_countdown
//-------------------------------------------------------------
/*
[trx_sc_countdown id="unique_id" date="2017-12-31" time="23:59:59"]
*/
if ( !function_exists( 'trx_addons_sc_countdown' ) ) {
	function trx_addons_sc_countdown($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_countdown', $atts, trx_addons_sc_common_atts('id,title', array(
			// Individual params
			"type" => "default",
			"date" => "",
			"time" => "",
			"date_time" => "",
			"date_time_restart" => "",
			"count_to" => 1,
			"count_restart" => 0,
			"align" => "center",
			))
		);

		// Load shortcode-specific  scripts and styles
		trx_addons_sc_countdown_load_scripts_front( true );

		// Load template
		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/tpl.default.php'
										),
                                        'trx_addons_args_sc_countdown',
                                        $atts
                                    );
		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_countdown', $atts, $content);
	}
}


// Add shortcode [trx_sc_countdown]
if (!function_exists('trx_addons_sc_countdown_add_shortcode')) {
	function trx_addons_sc_countdown_add_shortcode() {
		add_shortcode("trx_sc_countdown", "trx_addons_sc_countdown");
	}
	add_action('init', 'trx_addons_sc_countdown_add_shortcode', 20);
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown-sc-vc.php';
}
