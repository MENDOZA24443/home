<?php
/**
 * Shortcode: Anchor
 *
 * @package ThemeREX Addons
 * @since v1.2
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_anchor_load_scripts_front' ) ) {
	add_action( "wp_enqueue_scripts", 'trx_addons_sc_anchor_load_scripts_front', TRX_ADDONS_ENQUEUE_SCRIPTS_PRIORITY );
	add_action( 'trx_addons_action_pagebuilder_preview_scripts', 'trx_addons_sc_anchor_load_scripts_front', 10, 1 );
	function trx_addons_sc_anchor_load_scripts_front( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
							( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) && trx_addons_is_on( trx_addons_get_option('debug_mode') ) )
							|| ( ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) )
								&& ( $force === true
									|| trx_addons_is_preview()
									|| trx_addons_sc_check_in_content( array(	// or if a shortcode is present in the current page
											'sc' => 'sc_anchor',
											'entries' => array(
												array( 'type' => 'sc',  'sc' => 'trx_sc_anchor' ),
												array( 'type' => 'gb',  'sc' => 'wp:trx-addons/anchor' ),
												array( 'type' => 'elm', 'sc' => '"widgetType":"trx_sc_anchor"' ),
												array( 'type' => 'elm', 'sc' => '"shortcode":"[trx_sc_anchor' ),
											)
										) )
									)
								)
							)
		) {
			$loaded = true;
			// Don't load styles for Gutenberg editor because they are added as editor styles
			if ( $force !== 'gutenberg' && ! trx_addons_is_preview( 'gutenberg' ) ) {
				wp_enqueue_style( 'trx_addons-sc_anchor', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/anchor.css'), array(), null );
			}
			if ( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) )
				&& trx_addons_is_on( trx_addons_get_option('debug_mode') )
				&& trx_addons_is_preview( 'gutenberg' )
 			) {
 				// Don't load scripts for Gutenberg editor in debug_mode when optimization is off
 				// because all scripts are merged to the single file
			} else {
				wp_enqueue_script( 'trx_addons-sc_anchor', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/anchor.js'), array('jquery'), null, true );
			}
			do_action( 'trx_addons_action_load_scripts_front', $force, 'sc_anchor' );
		}
	}
}

// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_anchor_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_anchor_merge_styles');
	function trx_addons_sc_anchor_merge_styles($list) {
		if ( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/anchor.css';
		}
		return $list;
	}
}

// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_sc_anchor_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_anchor_merge_scripts');
	function trx_addons_sc_anchor_merge_scripts($list) {
		if ( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/anchor.js';
		}
		return $list;
	}
}

// Add required styles to the Gutenberg editor
if ( !function_exists( 'trx_addons_sc_anchor_add_editor_style' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'trx_addons_sc_anchor_add_editor_style', TRX_ADDONS_ENQUEUE_SCRIPTS_PRIORITY );
	function trx_addons_sc_anchor_add_editor_style( $styles ) {
		if ( ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$styles[] = trx_addons_get_file_url( TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/anchor.css' );
		}
		return $styles;
	}
}

// Load styles and scripts if present in the cache of the menu
if ( !function_exists( 'trx_addons_sc_anchor_check_in_html_output' ) ) {
	add_filter( 'trx_addons_filter_get_menu_cache_html', 'trx_addons_sc_anchor_check_in_html_output', 10, 1 );
	add_action( 'trx_addons_action_show_layout_from_cache', 'trx_addons_sc_anchor_check_in_html_output', 10, 1 );
	add_action( 'trx_addons_action_check_page_content', 'trx_addons_sc_anchor_check_in_html_output', 10, 1 );
	function trx_addons_sc_anchor_check_in_html_output( $content = '' ) {
		if ( ! trx_addons_need_frontend_scripts( 'sc_anchor' )
			&& ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) )
		) {
			$checklist = apply_filters( 'trx_addons_filter_check_in_html', array(
							'class=[\'"][^\'"]*sc_anchor'
							),
							'sc_anchor'
						);
			foreach ( $checklist as $item ) {
				if ( preg_match( "#{$item}#", $content, $matches ) ) {
					trx_addons_sc_anchor_load_scripts_front( true );
					break;
				}
			}
		}
		return $content;
	}
}
	
// Add shortcode's specific vars to the JS storage
if ( !function_exists( 'trx_addons_sc_anchor_localize_script' ) ) {
	add_filter("trx_addons_filter_localize_script", 'trx_addons_sc_anchor_localize_script');
	function trx_addons_sc_anchor_localize_script($vars) {
		$is_preview = trx_addons_is_preview( 'elementor' );
		return array_merge($vars, array(
			'scroll_to_anchor' => $is_preview ? 0 : trx_addons_get_option('scroll_to_anchor'),
			'update_location_from_anchor' => $is_preview ? 0 : trx_addons_get_option('update_location_from_anchor'),
		));
	}
}



// trx_sc_anchor
//-------------------------------------------------------------
/*
[trx_sc_anchor id="unique_id" style="default"]
*/
if ( !function_exists( 'trx_addons_sc_anchor' ) ) {
	function trx_addons_sc_anchor($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_anchor', $atts, trx_addons_sc_common_atts('icon', array(
			// Individual params
			"type" => "default",
			"title" => "",
			"url" => "",
			// Common params
			"id" => "",
			"anchor_id" => ""		// Alter name for id in Elementor ('id' is reserved by Elementor)
			))
		);
		if (!empty($atts['anchor_id'])) {
			$atts['id'] = $atts['anchor_id'];
		}
		if (empty($atts['icon'])) {
			$atts['icon'] = isset( $atts['icon_' . $atts['icon_type']] ) && $atts['icon_' . $atts['icon_type']] != 'empty' 
								? $atts['icon_' . $atts['icon_type']] 
								: '';
			trx_addons_load_icons($atts['icon_type']);
		} else if (strtolower($atts['icon']) == 'none') {
			$atts['icon'] = '';
		}
		// Load shortcode-specific  scripts and styles
		trx_addons_sc_anchor_load_scripts_front( true );
		// Load template
		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/tpl.default.php'
										),
                                        'trx_addons_args_sc_anchor',
                                        $atts
                                    );
		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_anchor', $atts, $content);
	}
}


// Add shortcode [trx_sc_anchor]
if (!function_exists('trx_addons_sc_anchor_add_shortcode')) {
	function trx_addons_sc_anchor_add_shortcode() {
		add_shortcode("trx_sc_anchor", "trx_addons_sc_anchor");
	}
	add_action('init', 'trx_addons_sc_anchor_add_shortcode', 20);
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/anchor-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/anchor-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/anchor-sc-vc.php';
}
