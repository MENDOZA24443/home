<?php
/**
 * Shortcode: Promo block
 *
 * @package ThemeREX Addons
 * @since v1.2
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	exit;
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_promo_load_scripts_front' ) ) {
	add_action( "wp_enqueue_scripts", 'trx_addons_sc_promo_load_scripts_front', TRX_ADDONS_ENQUEUE_SCRIPTS_PRIORITY );
	add_action( 'trx_addons_action_pagebuilder_preview_scripts', 'trx_addons_sc_promo_load_scripts_front', 10, 1 );
	function trx_addons_sc_promo_load_scripts_front( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
							( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) && trx_addons_is_on( trx_addons_get_option('debug_mode') ) )
							|| ( ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) )
								&& ( $force === true
									|| trx_addons_is_preview()
									|| trx_addons_sc_check_in_content( array(	// or if a shortcode is present in the current page
											'sc' => 'sc_promo',
											'entries' => array(
												array( 'type' => 'sc',  'sc' => 'trx_sc_promo' ),
												array( 'type' => 'gb',  'sc' => 'wp:trx-addons/promo' ),
												array( 'type' => 'elm', 'sc' => '"widgetType":"trx_sc_promo"' ),
												array( 'type' => 'elm', 'sc' => '"shortcode":"[trx_sc_promo' ),
											)
										) )
									)
								)
							)
		) {
			$loaded = true;
			// Don't load styles for Gutenberg editor because they are added as editor styles
			if ( $force !== 'gutenberg' && ! trx_addons_is_preview( 'gutenberg' ) ) {
				wp_enqueue_style( 'trx_addons-sc_promo', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/promo.css'), array(), null );
			}
			do_action( 'trx_addons_action_load_scripts_front', $force, 'sc_promo' );
		}
	}
}

// Enqueue responsive styles for frontend
if ( ! function_exists( 'trx_addons_sc_promo_load_scripts_front_responsive' ) ) {
	add_action( 'wp_enqueue_scripts', 'trx_addons_sc_promo_load_scripts_front_responsive', TRX_ADDONS_ENQUEUE_RESPONSIVE_PRIORITY );
	add_action( 'trx_addons_action_load_scripts_front_sc_promo', 'trx_addons_sc_promo_load_scripts_front_responsive', 10, 1 );
	function trx_addons_sc_promo_load_scripts_front_responsive( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
			current_action() == 'wp_enqueue_scripts' && trx_addons_need_frontend_scripts( 'sc_promo' )
			||
			current_action() != 'wp_enqueue_scripts' && $force === true
			)
		) {
			$loaded = true;
			if ( ! trx_addons_is_preview( 'gutenberg' ) ) {
				wp_enqueue_style( 'trx_addons-sc_promo-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/promo.responsive.css'), array(), null, trx_addons_media_for_load_css_responsive( 'sc-promo', 'xl' ) );
			}
		}
	}
}
	
// Merge shortcode's specific styles to the single stylesheet
if ( !function_exists( 'trx_addons_sc_promo_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_promo_merge_styles');
	function trx_addons_sc_promo_merge_styles($list) {
		if ( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/promo.css';
		}
		return $list;
	}
}

// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_promo_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_promo_merge_styles_responsive');
	function trx_addons_sc_promo_merge_styles_responsive($list) {
		if ( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/promo.responsive.css';
		}
		return $list;
	}
}

// Add styles to the Gutenberg editor
if ( !function_exists( 'trx_addons_sc_promo_add_editor_style' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'trx_addons_sc_promo_add_editor_style', TRX_ADDONS_ENQUEUE_SCRIPTS_PRIORITY );
	function trx_addons_sc_promo_add_editor_style( $styles ) {
		if ( ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$styles[] = trx_addons_get_file_url( TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/promo.css' );
		}
		return $styles;
	}
}

// Add responsive styles to the Gutenberg editor
if ( !function_exists( 'trx_addons_sc_promo_add_editor_style_responsive' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'trx_addons_sc_promo_add_editor_style_responsive', TRX_ADDONS_ENQUEUE_RESPONSIVE_PRIORITY );
	function trx_addons_sc_promo_add_editor_style_responsive( $styles ) {
		if ( ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$styles[] = trx_addons_get_file_url( TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/promo.responsive.css' );
		}
		return $styles;
	}
}

// Load styles and scripts if present in the cache of the menu
if ( !function_exists( 'trx_addons_sc_promo_check_in_html_output' ) ) {
//	add_filter( 'trx_addons_filter_get_menu_cache_html', 'trx_addons_sc_promo_check_in_html_output', 10, 1 );
	add_action( 'trx_addons_action_show_layout_from_cache', 'trx_addons_sc_promo_check_in_html_output', 10, 1 );
	add_action( 'trx_addons_action_check_page_content', 'trx_addons_sc_promo_check_in_html_output', 10, 1 );
	function trx_addons_sc_promo_check_in_html_output( $content = '' ) {
		if ( ! trx_addons_need_frontend_scripts( 'sc_promo' )
			&& ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) )
		) {
			$checklist = apply_filters( 'trx_addons_filter_check_in_html', array(
							'class=[\'"][^\'"]*sc_promo'
							),
							'sc_promo'
						);
			foreach ( $checklist as $item ) {
				if ( preg_match( "#{$item}#", $content, $matches ) ) {
					trx_addons_sc_promo_load_scripts_front( true );
					break;
				}
			}
		}
		return $content;
	}
}



// trx_sc_promo
//-------------------------------------------------------------
/*
[trx_sc_promo id="unique_id" title="Block title" 
subtitle="" link="#" link_text="Buy now"]Description[/trx_sc_promo]
*/
if (!function_exists('trx_addons_sc_promo')) {	
	function trx_addons_sc_promo($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_promo', $atts, trx_addons_sc_common_atts('id,title,icon', array(
			// Individual params
			"type" => "default",
			"size" => "normal",
			"icon_color" => '',
			"image" => "",
			"images" => "",				// Alter name for the 'image' ('image' reserved by Elementor)
			"image_position" => "left",
			"image_width" => "50%",
			"image_cover" => 1,
			"image_bg_color" => '',
			"video_url" => '',
			"video_embed" => '',
			"video_in_popup" => 0,
			"text_margins" => '',
			"text_align" => "none",
			"text_paddings" => 0,
			"text_float" => "none",
			"text_width" => "none",
			"text_bg_color" => '',
			"full_height" => 0,
			"gap" => 0,
			"content" => '',	// need for Elementor
			"link2" => '',
			"link2_text" => esc_html__('Learn more', 'trx_addons'),
			"link2_style" => 'default',
			))
		);

		if ( !empty( $content ) ) {
			$atts['content'] = $content;
		}

		if (empty($atts['icon'])) {
			$atts['icon'] = isset( $atts['icon_' . $atts['icon_type']] ) && $atts['icon_' . $atts['icon_type']] != 'empty' 
								? $atts['icon_' . $atts['icon_type']] 
								: '';
			trx_addons_load_icons($atts['icon_type']);
		} else if (strtolower($atts['icon']) == 'none') {
			$atts['icon'] = '';
		}
		
		if (empty($atts['image']) && !empty($atts['images']) && is_array($atts['images'])) {
			$atts['image'] = '';
			foreach ($atts['images'] as $img) {
				$atts['image'] .= (!empty($atts['image']) ? ',' : '') . $img['url'];
			}
		}
		if (strpos($atts['image'], ',')!==false) {
			$atts['image'] = explode(',', $atts['image']);
		} else {
			$atts['image'] = trx_addons_get_attachment_url($atts['image'], 'full');
		}
		
		$atts['gap'] = !empty($atts['gap']) ? trx_addons_prepare_css_value($atts['gap']) : '';
		
		if (empty($atts['image'])) {
			$atts['text_width'] = '100%';
			$atts['image_width'] = '0%';
			$atts['gap'] = '';
		} else if (empty($atts['title']) && empty($atts['subtitle']) && empty($atts['description']) && empty($atts['content']) 
				&& (empty($atts['link']) || empty($atts['link_text']))) {
			$atts['image_width'] = '100%';
			$atts['text_width'] = '0%';
			$atts['gap'] = '';
		} else {
			$atts['image_width'] = !empty($atts['image_width']) ? trx_addons_prepare_css_value($atts['image_width']) : '50%';
			$image_ed = strpos($atts['image_width'], '%')!==false ? '%' : substr($atts['image_width'], -2);
			if ($atts['gap']) {
				$gap_ed = strpos($atts['gap'], '%')!==false ? '%' : substr($atts['gap'], -2);
				if ($image_ed == $gap_ed) {
					$atts['text_width'] = $image_ed == '%'
									? (100 - ((float)str_replace('%', '', $atts['gap']))/2 - (float)str_replace('%', '', $atts['image_width'])).'%'
									: 'calc(100% - '.esc_attr($atts['gap']).'/2 - '.esc_attr($atts['image_width']).')';
					$atts['image_width'] = ((float)str_replace($image_ed, '', $atts['image_width']) - ((float)str_replace($gap_ed, '', $atts['gap'])) / 2) . $image_ed;
				} else {
					$atts['text_width'] = 'calc(100% - '.esc_attr($atts['gap']).'/2 - '.esc_attr($atts['image_width']).')';
					$atts['image_width'] = 'calc('.esc_attr($atts['image_width']).' - '.esc_attr($atts['gap']).'/2)';
				}
			} else {
				$atts['text_width'] = $image_ed=='%' 
								? (100 - (float)str_replace('%', '', $atts['image_width'])).'%'
								: 'calc(100% - '.esc_attr($atts['image_width']).')';
			}
		}

		// Load shortcode-specific scripts and styles
		trx_addons_sc_promo_load_scripts_front( true );

		// Load template
		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/tpl.default.php'
										),
                                        'trx_addons_args_sc_promo',
                                        $atts
                                    );
		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_promo', $atts, $content);
	}
}


// Add shortcode [trx_sc_promo]
if (!function_exists('trx_addons_sc_promo_add_shortcode')) {
	function trx_addons_sc_promo_add_shortcode() {
		add_shortcode("trx_sc_promo", "trx_addons_sc_promo");
	}
	add_action('init', 'trx_addons_sc_promo_add_shortcode', 20);
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/promo-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/promo-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/promo-sc-vc.php';
}
