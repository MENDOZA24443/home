<?php
/**
 * Dynamic background for Elementor's sections
 *
 * @addon bg-canvas
 * @version 1.2
 *
 * @package ThemeREX Addons
 * @since v1.84.0
 */

// Enqueue frontend scripts and styles priority
if ( ! defined( 'TRX_ADDONS_ENQUEUE_SCRIPTS_PRIORITY' ) ) define( 'TRX_ADDONS_ENQUEUE_SCRIPTS_PRIORITY', 20 );
// Enqueue responsive styles priority
if ( ! defined( 'TRX_ADDONS_ENQUEUE_RESPONSIVE_PRIORITY' ) ) define( 'TRX_ADDONS_ENQUEUE_RESPONSIVE_PRIORITY', 2000 );


// Load required styles and scripts for the frontend
if ( ! function_exists( 'trx_addons_bg_canvas_load_scripts_front' ) ) {
	add_action( 'wp_enqueue_scripts', 'trx_addons_bg_canvas_load_scripts_front', TRX_ADDONS_ENQUEUE_SCRIPTS_PRIORITY );
	add_action( 'trx_addons_action_pagebuilder_preview_scripts', 'trx_addons_bg_canvas_load_scripts_front', 10, 1 );
	function trx_addons_bg_canvas_load_scripts_front( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
					( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) && trx_addons_is_on( trx_addons_get_option('debug_mode') ) )
					|| ( ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) )
						&& ( $force === true
							|| trx_addons_is_preview()
							)
						)
					)
		) {
			$loaded = true;
			// Don't load styles for Gutenberg editor because they are added as editor styles
			if ( $force !== 'gutenberg' && ! trx_addons_is_preview( 'gutenberg' ) ) {
				wp_enqueue_style(  'trx_addons-bg-canvas', trx_addons_get_file_url( TRX_ADDONS_PLUGIN_ADDONS . 'bg-canvas/bg-canvas.css' ), array(), null );
			}
			if ( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) )
				&& trx_addons_is_on( trx_addons_get_option('debug_mode') )
				&& trx_addons_is_preview( 'gutenberg' )
 			) {
 				// Don't load scripts for Gutenberg editor in debug_mode when optimization is off
 				// because all scripts are merged to the single file
			} else {
				wp_enqueue_script( 'trx_addons-bg-canvas', trx_addons_get_file_url( TRX_ADDONS_PLUGIN_ADDONS . 'bg-canvas/bg-canvas.js' ), array('jquery'), null, true );
			}
			do_action( 'trx_addons_action_load_scripts_front', $force, 'bg_canvas' );
		}
	}
}

	
// Merge styles to the single stylesheet
if ( ! function_exists( 'trx_addons_bg_canvas_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_bg_canvas_merge_styles');
	function trx_addons_bg_canvas_merge_styles($list) {
		if ( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$list[] = TRX_ADDONS_PLUGIN_ADDONS . 'bg-canvas/bg-canvas.css';
		}
		return $list;
	}
}

	
// Merge specific scripts into single file
if ( ! function_exists( 'trx_addons_bg_canvas_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_bg_canvas_merge_scripts');
	function trx_addons_bg_canvas_merge_scripts($list) {
		if ( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$list[] = TRX_ADDONS_PLUGIN_ADDONS . 'bg-canvas/bg-canvas.js';
		}
		return $list;
	}
}

// Add styles to the Gutenberg editor
if ( ! function_exists( 'trx_addons_bg_canvas_add_editor_style' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'trx_addons_bg_canvas_add_editor_style', TRX_ADDONS_ENQUEUE_SCRIPTS_PRIORITY );
	function trx_addons_bg_canvas_add_editor_style( $styles ) {
		if ( ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$styles[] = trx_addons_get_file_url( TRX_ADDONS_PLUGIN_ADDONS . 'bg-canvas/bg-canvas.css' );
		}
		return $styles;
	}
}

// Load styles and scripts if present in the cache of the menu or layouts or finally in the whole page output
if ( ! function_exists( 'trx_addons_bg_canvas_check_in_html_output' ) ) {
//	add_filter( 'trx_addons_filter_get_menu_cache_html', 'trx_addons_audio_effects_check_in_html_output', 10, 1 );
//	add_action( 'trx_addons_action_show_layout_from_cache', 'trx_addons_audio_effects_check_in_html_output', 10, 1 );
	add_action( 'trx_addons_action_check_page_content', 'trx_addons_bg_canvas_check_in_html_output', 10, 1 );
	function trx_addons_bg_canvas_check_in_html_output( $content = '' ) {
		if ( ! trx_addons_need_frontend_scripts( 'bg_canvas' )
			&& ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) )
		) {
			$checklist = apply_filters( 'trx_addons_filter_check_in_html', array(
							'data-bg-canvas-'
							),
							'bg-canvas'
						);
			foreach ( $checklist as $item ) {
				if ( strpos( $content, $item ) !== false ) {
					trx_addons_bg_canvas_load_scripts_front( true );
					break;
				}
			}
		}
		return $content;
	}
}

// Add "Bg Canvas" params to all elements
if ( ! function_exists( 'trx_addons_elm_add_params_bg_canvas' ) ) {
	add_action( 'elementor/element/before_section_start', 'trx_addons_elm_add_params_bg_canvas', 10, 3 );
	add_action( 'elementor/widget/before_section_start', 'trx_addons_elm_add_params_bg_canvas', 10, 3 );
	function trx_addons_elm_add_params_bg_canvas($element, $section_id, $args) {

		if ( !is_object($element) ) return;

		if ( $element->get_name() == 'common' && $section_id == '_section_responsive' ) {
			
			$element->start_controls_section( 'section_trx_bg_canvas', array(
																		'tab' => !empty($args['tab']) ? $args['tab'] : \Elementor\Controls_Manager::TAB_ADVANCED,
																		'label' => __( 'Dynamic Background', 'trx_addons' )
																	) );
			$element->add_control( 'bg_canvas_type', array(
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => __( 'Breakpoint type', 'trx_addons' ),
				'label_block' => false,
				'options' => apply_filters( 'trx_addons_filter_bg_canvas_effects', array(
					'none' => esc_html__( 'None', 'trx_addons' ),
					'start' => esc_html__( 'Start', 'trx_addons' ),
					'end'  => esc_html__( 'End', 'trx_addons' ),
				) ),
				'default' => 'none',
			) );
			$element->add_control( 'bg_canvas_id', array(
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => __( 'Breakpoint ID', 'trx_addons' ),
				'label_block' => false,
				'condition' => array(
					'bg_canvas_type!' => 'none'
				),
			) );
			$element->add_control( 'bg_canvas_effect', array(
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => __( 'Background effect', 'trx_addons' ),
				'label_block' => false,
				'options' => apply_filters( 'trx_addons_filter_bg_canvas_effects', array(
					'round' => esc_html__( 'Round', 'trx_addons' ),
					'fade'  => esc_html__( 'Fade', 'trx_addons' ),
				) ),
				'default' => 'round',
				'condition' => array(
					'bg_canvas_type!' => 'none'
				),
			) );
			$element->add_control( 'bg_canvas_color', array(
				'label' => __( 'Background color', 'trx_addons' ),
				'label_block' => false,
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				// Not used, because global colors are not compatible with fade
				'global' => array(
					'active' => false,
				),
				'condition' => array(
					'bg_canvas_type!' => 'none',
				),
			) );
			$element->add_control( 'bg_canvas_size', array(
				'label' => __( 'Min.size', 'trx_addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => array(
					'size' => '',
					'unit' => 'px'
				),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 300
					),
				),
				'size_units' => array( 'px' ),
				'condition' => array(
					'bg_canvas_type!' => 'none',
					'bg_canvas_effect' => 'round',
				),
			) );
			$element->add_control( 'bg_canvas_shift', array(
				'label' => __( 'Shift', 'trx_addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => array(
					'size' => '',
					'unit' => 'px'
				),
				'range' => array(
					'px' => array(
						'min' => -100,
						'max' => 100
					),
				),
				'size_units' => array( 'px' ),
				'condition' => array(
					'bg_canvas_type!' => 'none'
				),
			) );

			$element->end_controls_section();
		}
	}
}

// Add "data-bg-canvas" to the wrapper of the row
if ( !function_exists( 'trx_addons_elm_add_bg_canvas_data' ) ) {
	// Before Elementor 2.1.0
	add_action( 'elementor/frontend/element/before_render',  'trx_addons_elm_add_bg_canvas_data', 10, 1 );
	// After Elementor 2.1.0
	add_action( 'elementor/frontend/widget/before_render', 'trx_addons_elm_add_bg_canvas_data', 10, 1 );
	function trx_addons_elm_add_bg_canvas_data($element) {
		if ( is_object($element) ) {
			$settings = trx_addons_elm_prepare_global_params( $element->get_settings() );
			if ( ! empty($settings['bg_canvas_type']) && ! trx_addons_is_off($settings['bg_canvas_type']) ) {
				// Load scripts and styles
				trx_addons_bg_canvas_load_scripts_front( true );
				// Add data-parameters to the element wrapper
				$element->add_render_attribute( '_wrapper', array(
					'data-bg-canvas-id'     => $settings['bg_canvas_id'],
					'data-bg-canvas-type'   => $settings['bg_canvas_type'],
					'data-bg-canvas-effect' => $settings['bg_canvas_effect'],
					'data-bg-canvas-size'   => $settings['bg_canvas_size']['size'],
					'data-bg-canvas-shift'  => $settings['bg_canvas_shift']['size'],
					'data-bg-canvas-color'  => $settings['bg_canvas_color']
				) );
			}
		}
	}
}
