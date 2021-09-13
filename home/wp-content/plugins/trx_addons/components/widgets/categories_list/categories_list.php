<?php
/**
 * Widget: Categories list
 *
 * @package ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	exit;
}

// Load widget
if (!function_exists('trx_addons_widget_categories_list_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_categories_list_load' );
	function trx_addons_widget_categories_list_load() {
		register_widget('trx_addons_widget_categories_list');
	}
}

// Widget Class
class trx_addons_widget_categories_list extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_categories_list', 'description' => esc_html__('Display categories list with icons or images', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_categories_list', esc_html__('ThemeREX Categories list', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {

		$instance['title'] = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		$instance['style'] = isset($instance['style']) ? max(1, (int) $instance['style']) : 1;
		$instance['number'] = isset($instance['number']) ? (int) $instance['number'] : '';
		$instance['columns'] = isset($instance['columns']) ? (int) $instance['columns'] : '';
		$instance['columns_tablet'] = isset($instance['columns_tablet']) ? (int) $instance['columns_tablet'] : '';
		$instance['columns_mobile'] = isset($instance['columns_mobile']) ? (int) $instance['columns_mobile'] : '';
		$instance['show_thumbs'] = isset($instance['show_thumbs']) ? (int) $instance['show_thumbs'] : 0;
		$instance['show_posts'] = isset($instance['show_posts']) ? (int) $instance['show_posts'] : 0;
		$instance['show_children'] = isset($instance['show_children']) ? (int) $instance['show_children'] : 0;
		$instance['post_type'] = isset($instance['post_type']) ? $instance['post_type'] : '';
		$instance['taxonomy'] = isset($instance['taxonomy']) ? $instance['taxonomy'] : '';
		$instance['cat_list'] = isset($instance['cat_list']) ? $instance['cat_list'] : '';

		if ( ! $instance['show_thumbs'] && $instance['style'] == 2 ) {
			$instance['style'] = 1;
		}
		$q_obj = get_queried_object();

		$query_args = array(
			'type'         => $instance['post_type'],
			'taxonomy'     => $instance['taxonomy'],
			'include'      => $instance['cat_list'],
			'number'       => $instance['number'] > 0 && empty($instance['cat_list']) ? $instance['number'] : '',
			'parent'       => $instance['show_children']
								? ( is_category() 
									? (int) get_query_var( 'cat' )
									: ( is_tax() && !empty( $q_obj->term_id )
										? $q_obj->term_id
										: ( empty( $instance['cat_list'] ) ? 0 : '' )
										)
									)
								: ( empty($instance['cat_list'] ) ? 0 : '' ),
			'orderby'      => 'name',
			'order'        => 'ASC',
			'hide_empty'   => true,
			'hierarchical' => true,
			'pad_counts'   => $instance['show_posts'] > 0
		);

		$categories = get_terms($query_args);

		// If result is empty - exit without output
		if ( count($categories) == 0 ) return;

		// Load widget-specific scripts and styles
		trx_addons_widget_categories_list_load_scripts_front( true );

		// Load template
		trx_addons_get_template_part( array(
										TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/tpl.categories-list-'.trim($instance['style']).'.php',
										TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/tpl.categories-list-1.php'
										),
                                        'trx_addons_args_widget_categories_list',
										apply_filters('trx_addons_filter_widget_args',
												array_merge( $args, $instance, compact('categories') ),
												$instance,
												'trx_addons_widget_categories_list'
										)
                                    );
	}

	// Update the widget settings
	function update($new_instance, $instance) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['style'] = (int) $new_instance['style'];
		$instance['number'] = (int) $new_instance['number'];
		$instance['columns'] = (int) $new_instance['columns'];
		$instance['show_thumbs'] = !empty($new_instance['show_thumbs']) ? 1 : 0;
		$instance['show_posts'] = !empty($new_instance['show_posts']) ? 1 : 0;
		$instance['show_children'] = !empty($new_instance['show_children']) ? 1 : 0;
		$instance['post_type'] = strip_tags($new_instance['post_type']);
		$instance['taxonomy'] = strip_tags($new_instance['taxonomy']);
		$instance['cat_list'] = join(',', $new_instance['cat_list']);
		$instance['slider'] = isset( $new_instance['slider'] ) ? 1 : 0;
		$instance['slides_space'] = (int) $new_instance['slides_space'];
		$instance['slides_centered'] = isset( $new_instance['slides_centered'] ) ? 1 : 0;
		$instance['slides_overflow'] = isset( $new_instance['slides_overflow'] ) ? 1 : 0;
		$instance['slider_mouse_wheel'] = isset( $new_instance['slider_mouse_wheel'] ) ? 1 : 0;
		$instance['slider_autoplay'] = isset( $new_instance['slider_autoplay'] ) ? 1 : 0;
		$instance['slider_free_mode'] = isset( $new_instance['slider_free_mode'] ) ? 1 : 0;
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_categories_list');
	}

	// Displays the widget settings controls on the widget panel
	function form($instance) {
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'style' => '1',
			'number' => '5',
			'columns' => '5',
			'show_thumbs' => '1',
			'show_posts' => '1',
			'show_children' => '0',
			'post_type' => 'post',
			'taxonomy' => 'category',
			'cat_list' => '',
			// Slider params
			"slider" => 0,
			"slider_pagination" => "none",
			"slider_controls" => "none",
			"slides_space" => 0,
			"slides_centered" => 0,
			"slides_overflow" => 0,
			"slider_mouse_wheel" => 0,
			"slider_autoplay" => 1,
			"slider_free_mode" => 0,
			), 'trx_addons_widget_categories_list')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_categories_list', $this);
		
		$this->show_field(array('name' => 'title',
								'title' => __('Widget title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_categories_list', $this);
		
		$this->show_field(array('name' => 'style',
								'title' => __('Output style:', 'trx_addons'),
								'value' => (int) $instance['style'],
								'options' => trx_addons_components_get_allowed_layouts('widgets', 'categories_list'),
								'type' => 'radio'));
		
		$this->show_field(array('name' => 'post_type',
								'title' => __('Post type:', 'trx_addons'),
								'value' => $instance['post_type'],
								'options' => trx_addons_get_list_posts_types(),
								'class' => 'trx_addons_post_type_selector',
								'type' => 'select'));
		
		$this->show_field(array('name' => 'taxonomy',
								'title' => __('Taxonomy:', 'trx_addons'),
								'value' => $instance['taxonomy'],
								'options' => trx_addons_get_list_taxonomies(false, $instance['post_type']),
								'class' => 'trx_addons_taxonomy_selector',
								'type' => 'select'));
		
		$this->show_field(array('name' => 'cat_list',
								'title' => __('Categories to show:', 'trx_addons'),
								'value' => $instance['cat_list'],
								'options' => trx_addons_get_list_terms(false, $instance['taxonomy']),
								'class' => 'trx_addons_terms_selector',
								'type' => 'checklist'));
		
		$this->show_field(array('name' => 'number',
								'title' => __('Number categories to show (if field above is empty):', 'trx_addons'),
								'value' => (int) $instance['number'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'columns',
								'title' => __('Columns number:', 'trx_addons'),
								'value' => (int) $instance['columns'],
								'type' => 'text'));

		$this->show_field(array('name' => 'show_thumbs',
								'title' => __('Show images:', 'trx_addons'),
								'value' => (int) $instance['show_thumbs'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'radio'));

		$this->show_field(array('name' => 'show_posts',
								'title' => __('Show posts count:', 'trx_addons'),
								'value' => (int) $instance['show_posts'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'radio'));

		$this->show_field(array('name' => 'show_children',
								'title' => __('Only children of the current category:', 'trx_addons'),
								'value' => (int) $instance['show_children'],
								'options' => array(
													1 => __('Children', 'trx_addons'),
													0 => __('From root', 'trx_addons')
													),
								'type' => 'radio'));

		$this->show_fields_slider_param($instance);
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_categories_list', $this);
	}
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_categories_list_load_scripts_front' ) ) {
	add_action( "wp_enqueue_scripts", 'trx_addons_widget_categories_list_load_scripts_front', TRX_ADDONS_ENQUEUE_SCRIPTS_PRIORITY );
	add_action( 'trx_addons_action_pagebuilder_preview_scripts', 'trx_addons_widget_categories_list_load_scripts_front', 10, 1 );
	function trx_addons_widget_categories_list_load_scripts_front( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
							( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) && trx_addons_is_on( trx_addons_get_option('debug_mode') ) )
							|| ( ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) )
								&& ( $force === true
									|| trx_addons_is_preview()
									|| trx_addons_sc_check_in_content( array(	// or if a shortcode is present in the current page
											'sc' => 'widget_categories_list',
											'entries' => array(
												array( 'type' => 'sc',  'sc' => 'trx_widget_categories_list' ),
												array( 'type' => 'gb',  'sc' => 'wp:trx-addons/categories-list' ),
												array( 'type' => 'elm', 'sc' => '"widgetType":"trx_widget_categories_list"' ),
												array( 'type' => 'elm', 'sc' => '"shortcode":"[trx_widget_categories_list' ),
											)
										) )
									)
								)
							)
		) {
			$loaded = true;
			// Don't load styles for Gutenberg editor because they are added as editor styles
			if ( $force !== 'gutenberg' && ! trx_addons_is_preview( 'gutenberg' ) ) {
				wp_enqueue_style( 'trx_addons-widget_categories_list', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list.css'), array(), null );
			}
			do_action( 'trx_addons_action_load_scripts_front', $force, 'widget_categories_list' );
		}
	}
}

// Enqueue responsive styles for frontend
if ( ! function_exists( 'trx_addons_widget_categories_list_load_scripts_front_responsive' ) ) {
	add_action( 'wp_enqueue_scripts', 'trx_addons_widget_categories_list_load_scripts_front_responsive', TRX_ADDONS_ENQUEUE_RESPONSIVE_PRIORITY );
	add_action( 'trx_addons_action_load_scripts_front_widget_categories_list', 'trx_addons_widget_categories_list_load_scripts_front_responsive', 10, 1 );
	function trx_addons_widget_categories_list_load_scripts_front_responsive( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
			current_action() == 'wp_enqueue_scripts' && trx_addons_need_frontend_scripts( 'widget_categories_list' )
			||
			current_action() != 'wp_enqueue_scripts' && $force === true
			)
		) {
			$loaded = true;
			if ( ! trx_addons_is_preview( 'gutenberg' ) ) {
				wp_enqueue_style( 'trx_addons-widget_categories_list-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list.responsive.css'), array(), null, trx_addons_media_for_load_css_responsive( 'widget-categories-list', 'md' ) );
			}
		}
	}
}

// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_categories_list_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_categories_list_merge_styles');
	function trx_addons_widget_categories_list_merge_styles($list) {
		if ( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list.css';
		}
		return $list;
	}
}

// Merge widget's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_widget_categories_list_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_widget_categories_list_merge_styles_responsive');
	function trx_addons_widget_categories_list_merge_styles_responsive($list) {
		if ( trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list.responsive.css';
		}
		return $list;
	}
}

// Add styles to the Gutenberg editor
if ( !function_exists( 'trx_addons_widget_categories_list_add_editor_style' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'trx_addons_widget_categories_list_add_editor_style', TRX_ADDONS_ENQUEUE_SCRIPTS_PRIORITY );
	function trx_addons_widget_categories_list_add_editor_style( $styles ) {
		if ( ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$styles[] = trx_addons_get_file_url( TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list.css' );
		}
		return $styles;
	}
}

// Add responsive styles to the Gutenberg editor
if ( !function_exists( 'trx_addons_widget_categories_list_add_editor_style_responsive' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'trx_addons_widget_categories_list_add_editor_style_responsive', TRX_ADDONS_ENQUEUE_RESPONSIVE_PRIORITY );
	function trx_addons_widget_categories_list_add_editor_style_responsive( $styles ) {
		if ( ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) ) ) {
			$styles[] = trx_addons_get_file_url( TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list.responsive.css' );
		}
		return $styles;
	}
}

// Load styles and scripts if present in the cache of the menu
if ( !function_exists( 'trx_addons_widget_categories_list_check_in_html_output' ) ) {
	add_filter( 'trx_addons_filter_get_menu_cache_html', 'trx_addons_widget_categories_list_check_in_html_output', 10, 1 );
	add_action( 'trx_addons_action_show_layout_from_cache', 'trx_addons_widget_categories_list_check_in_html_output', 10, 1 );
	add_action( 'trx_addons_action_check_page_content', 'trx_addons_widget_categories_list_check_in_html_output', 10, 1 );
	function trx_addons_widget_categories_list_check_in_html_output( $content = '' ) {
		if ( ! trx_addons_need_frontend_scripts( 'widget_categories_list' )
			&& ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) )
		) {
			$checklist = apply_filters( 'trx_addons_filter_check_in_html', array(
							'class=[\'"][^\'"]*widget_categories_list'
							),
							'widget_categories_list'
						);
			foreach ( $checklist as $item ) {
				if ( preg_match( "#{$item}#", $content, $matches ) ) {
					trx_addons_widget_categories_list_load_scripts_front( true );
					break;
				}
			}
		}
		return $content;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list-sc-vc.php';
}
