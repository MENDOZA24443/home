<?php
/**
 * Skins support: Main skin file for the skin 'Default'
 *
 * Load scripts and styles,
 * and other operations that affect the appearance and behavior of the theme
 * when the skin is activated
 *
 * @package INESTIO
 * @since INESTIO 1.0.46
 */


// SKIN SETUP
//--------------------------------------------------------------------

// Setup fonts, colors, blog and single styles, etc.
$inestio_skin_path = inestio_get_file_dir( inestio_skins_get_current_skin_dir() . 'skin-setup.php' );
if ( ! empty( $inestio_skin_path ) ) {
	require_once $inestio_skin_path;
}

// Skin options
$inestio_skin_path = inestio_get_file_dir( inestio_skins_get_current_skin_dir() . 'skin-options.php' );
if ( ! empty( $inestio_skin_path ) ) {
	require_once $inestio_skin_path;
}

// Required plugins
$inestio_skin_path = inestio_get_file_dir( inestio_skins_get_current_skin_dir() . 'skin-plugins.php' );
if ( ! empty( $inestio_skin_path ) ) {
	require_once $inestio_skin_path;
}

// Demo import
$inestio_skin_path = inestio_get_file_dir( inestio_skins_get_current_skin_dir() . 'skin-demo-importer.php' );
if ( ! empty( $inestio_skin_path ) ) {
	require_once $inestio_skin_path;
}


// TRX_ADDONS SETUP
//--------------------------------------------------------------------

// Filter to add in the required plugins list
// Priority 11 to add new plugins to the end of the list
if ( ! function_exists( 'inestio_skin_tgmpa_required_plugins' ) ) {
	add_filter( 'inestio_filter_tgmpa_required_plugins', 'inestio_skin_tgmpa_required_plugins', 11 );
	function inestio_skin_tgmpa_required_plugins( $list = array() ) {
		if ( inestio_storage_isset( 'required_plugins', 'skin-specific-plugin-slug' ) ) {
			$list[] = array(
				'name'     => inestio_storage_get_array( 'required_plugins', 'skin-specific-plugin-slug', 'title' ),
				'slug'     => 'skin-specific-plugin-slug',
				'required' => false,
			);
		}
		foreach ($list as $key => $value) {
			if ( in_array($list[$key]['slug'], array('coblocks', 'kadence-blocks', 'contact-form-7-datepicker')) ) {
				unset($list[$key]);
			}
		}
		return $list;
	}
}

// Filter to add/remove components of ThemeREX Addons when current skin is active
if ( ! function_exists( 'inestio_skin_trx_addons_default_components' ) ) {
	add_filter('trx_addons_filter_load_options', 'inestio_skin_trx_addons_default_components', 20);
	function inestio_skin_trx_addons_default_components($components) {
		return $components;
	}
}

// Filter to add/remove CPT
if ( ! function_exists( 'inestio_skin_trx_addons_cpt_list' ) ) {
	add_filter('trx_addons_cpt_list', 'inestio_skin_trx_addons_cpt_list');
	function inestio_skin_trx_addons_cpt_list( $list = array() ) {
		return $list;
	}
}

// Filter to add/remove shortcodes
if ( ! function_exists( 'inestio_skin_trx_addons_sc_list' ) ) {
	add_filter('trx_addons_sc_list', 'inestio_skin_trx_addons_sc_list');
	function inestio_skin_trx_addons_sc_list( $list = array() ) {
		$list['blogger']['templates']['default']['over_centered']['layout']['featured']=array(
			'mc' => array(
				'meta_categories', 'title', 'meta','excerpt', 'readmore'
			),
			'tr' => array(
				'price'
			),
			'br' => array(

			),
		);

		$list['button']['layouts_sc']['transparent'] = esc_html__('Transparent', 'inestio');

		return $list;
	}
}

// Filter to add/remove widgets
if ( ! function_exists( 'inestio_skin_trx_addons_widgets_list' ) ) {
	add_filter('trx_addons_widgets_list', 'inestio_skin_trx_addons_widgets_list');
	function inestio_skin_trx_addons_widgets_list( $list = array() ) {
		return $list;
	}
}

// Return share links positions
if ( ! function_exists( 'inestio_skin_list_share_links_positions' ) ) {
	add_filter( 'inestio_filter_list_share_links_positions', 'inestio_skin_list_share_links_positions' );
	function inestio_skin_list_share_links_positions( $list = array() ) {
		$list = array(
				'left' => esc_html__( 'Left', 'inestio' ),
			);
		return $list;
	}
}

// Default service form "none"
if (!function_exists('inestio_skin_trx_addons_cpt_list_options')) {
	add_filter( 'trx_addons_cpt_list_options', 'inestio_skin_trx_addons_cpt_list_options', 10, 2);
		function inestio_skin_trx_addons_cpt_list_options($list = array(), $type = '') {
			if ( $type == 'services' ) {
			$list['services_form']['std'] = 'none';
			unset($list['services_form']['options']['default']);
			}
			return $list;
		}
}

// unset option - "default" from service form
if (!function_exists('inestio_skin_page_contact_form')) {
	add_filter( 'trx_addons_filter_page_contact_form', 'inestio_skin_page_contact_form', 10, 2);
		function inestio_skin_page_contact_form($list = array(), $type = '') {
			if ( $type == 'services' || $type == 'team' ) {
				unset($list['default']);
			}
			return $list;
		}
}

// Add theme-specific controls to sections and columns
if ( ! function_exists( 'inestio_skin_elm_add_controls' ) ) {
	add_action( 'elementor/element/before_section_end', 'inestio_skin_elm_add_controls', 10, 3 );
	function inestio_skin_elm_add_controls( $element, $section_id, $args ) {
		if ( is_object( $element ) ) {
			$el_name = $element->get_name();
			// Shortcode: Socials
			if ( in_array($el_name, array('image-gallery')) && !$element->get_controls('square_frame') ) { 
				$element->add_control(  
					'square_frame', array(
						'label' 		=> esc_html__("Square image frame", 'inestio'),
						'description' 	=> esc_html__("Make image's frame square form", 'inestio'),
						'type'			=> \Elementor\Controls_Manager::SWITCHER,
						'label_off'    => esc_html__( 'Off', 'inestio' ),
						'label_on'     => esc_html__( 'On', 'inestio' ),
						'return_value' => 'square',
						'prefix_class' => 'image-gallery-frame-',
					)
				);
			}
		}
	}
}

// SCRIPTS AND STYLES
//--------------------------------------------------

// Enqueue skin-specific scripts
// Priority 1050 -  before main theme plugins-specific (1100)
if ( ! function_exists( 'inestio_skin_frontend_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'inestio_skin_frontend_scripts', 1050 );
	function inestio_skin_frontend_scripts() {
		$inestio_url = inestio_get_file_url( inestio_skins_get_current_skin_dir() . 'css/style.css' );
		if ( '' != $inestio_url ) {
			wp_enqueue_style( 'inestio-skin-' . esc_attr( inestio_skins_get_current_skin_name() ), $inestio_url, array(), null );
		}
		$inestio_url = inestio_get_file_url( inestio_skins_get_current_skin_dir() . 'skin.js' );
		if ( '' != $inestio_url ) {
			wp_enqueue_script( 'inestio-skin-' . esc_attr( inestio_skins_get_current_skin_name() ), $inestio_url, array( 'jquery' ), null, true );
		}
	}
}


// Custom styles
$inestio_style_path = inestio_get_file_dir( inestio_skins_get_current_skin_dir() . 'css/style.php' );
if ( ! empty( $inestio_style_path ) ) {
	require_once $inestio_style_path;
}

// New Functions
//--------------------------------------------------

if ( ! function_exists( 'inestio_skin_post_meta_args' ) ) {
	add_filter( 'inestio_filter_post_meta_args', 'inestio_skin_post_meta_args', 100, 3);
	function inestio_skin_post_meta_args($array, $x, $z) {
		if ( array_key_exists('sc', $array) && $array['sc'] == 'sc_layouts_title_cat' ) {
			if ( strpos($array['components'], 'categories') !== false ) {
				$array['components'] = 'categories';
			}
		}
		if ( array_key_exists('sc', $array) && $array['sc'] == 'sc_layouts_title_other' ) {
			if ( strpos($array['components'], 'categories') !== false ) {
				$array['components'] = str_replace('categories,', '', $array['components']); 
			}
		}
		return $array;		
	}
}

// Add new image position to the list
if ( ! function_exists( 'inestio_trx_addons_get_list_sc_blogger_image_positions' ) ) {
	add_filter( 'trx_addons_filter_get_list_sc_blogger_image_positions','inestio_trx_addons_get_list_sc_blogger_image_positions');
	function inestio_trx_addons_get_list_sc_blogger_image_positions( $list = array() ) {
		if ( $list ) {
			$list['none'] = esc_html__('None', 'inestio');
		}		
		return $list;
	}
}

// Add new layout to icons shortcode
if ( ! function_exists( 'inestio_skin_trx_addons_sc_type' ) ) {
	add_filter( 'trx_addons_sc_type', 'inestio_skin_trx_addons_sc_type', 10, 2);
	function inestio_skin_trx_addons_sc_type($array, $sc) {
		if ( $sc == 'trx_sc_icons' ) {
			$array['classic'] = esc_html__('Classic', 'inestio');
			$array['onplate'] = esc_html__('Onplate', 'inestio');
			$array['withborder'] = esc_html__('Withborder', 'inestio');
		}
		return $array;		
	}
}

// Change suggest php version 
if ( ! function_exists( 'inestio_skin_trx_trx_addons_get_sys_info' ) ) {
	add_filter( 'trx_addons_filter_get_sys_info', 'inestio_skin_trx_trx_addons_get_sys_info', 10, 1);
	function inestio_skin_trx_trx_addons_get_sys_info($php) {
		$php['php_version']['recommended'] = '7.0.0+';
		return $php;		
	}
}

// Add color scheme to widget_contact
if ( ! function_exists( 'inestio_skin_trx_addons_widget_args' ) ) {
	add_filter( 'trx_addons_filter_widget_args', 'inestio_skin_trx_addons_widget_args', 10, 3);
	function inestio_skin_trx_addons_widget_args($array, $instance, $sc) {
		if ( $sc == 'trx_addons_widget_contacts' ) {
			$array['color'] = isset($instance['color']) ? $instance['color'] : '';
		}
		return $array;		
	}
}

// Add color scheme to widget_contact
if ( ! function_exists( 'inestio_skin_trx_addons_widget_args_update' ) ) {
	add_filter( 'trx_addons_filter_widget_args_update', 'inestio_skin_trx_addons_widget_args_update', 10, 3);
	function inestio_skin_trx_addons_widget_args_update($instance, $new_instance, $sc) {
		if ( $sc == 'trx_addons_widget_contacts' ) {
			$instance['color'] = strip_tags($new_instance['color']);
		}
		return $instance;		
	}
}

// Add color scheme to widget_contact
if ( ! function_exists( 'inestio_skin_trx_addons_widget_args_default' ) ) {
	add_filter( 'trx_addons_filter_widget_args_default', 'inestio_skin_trx_addons_widget_args_default', 10, 2);
	function inestio_skin_trx_addons_widget_args_default($array, $sc) {
		if ( $sc == 'trx_addons_widget_contacts' ) {
			$array['color'] = 'default';
		}
		return $array;		
	}
}

// Theme init priorities:
//10 - standard Theme init procedures (not ordered)
if ( ! function_exists( 'inestio_skin_theme_setup10' ) ) {
	add_action( 'after_setup_theme', 'inestio_skin_theme_setup10', 10 );
	function inestio_skin_theme_setup10() {
		// Related posts
		$related_position = inestio_get_theme_option( 'related_position' );
		$posts_navigation = inestio_get_theme_option( 'posts_navigation' );
		$full_post_loading = inestio_get_value_gp( 'action' ) == 'full_post_loading';
		if ( 'below_content' == $related_position
			&& ( 'scroll' != $posts_navigation || inestio_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
			&& ( ! $full_post_loading || inestio_get_theme_option( 'open_full_post_hide_related' ) == 0 )
		) {
			remove_action( 'inestio_action_related_posts', 'inestio_show_related_posts_callback' );
		}
	}
}

// Show related posts before comments
if ( ! function_exists( 'inestio_skin_show_related_posts' ) ) {
	add_action( 'inestio_action_after_post_footer', 'inestio_skin_show_related_posts' );
	function inestio_skin_show_related_posts() {
		// Related posts
		$related_position = inestio_get_theme_option( 'related_position' );
		$posts_navigation = inestio_get_theme_option( 'posts_navigation' );
		$full_post_loading = inestio_get_value_gp( 'action' ) == 'full_post_loading';
		if ( 'below_content' == $related_position
			&& ( 'scroll' != $posts_navigation || inestio_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
			&& ( ! $full_post_loading || inestio_get_theme_option( 'open_full_post_hide_related' ) == 0 )
		) {
			inestio_show_related_posts_callback();
		}
	}
}

// Add color scheme to widget_contact
if ( ! function_exists( 'inestio_skin_trx_addons_after_widget_fields' ) ) {
	add_action( 'trx_addons_action_after_widget_fields', 'inestio_skin_trx_addons_after_widget_fields', 10, 3);
	function inestio_skin_trx_addons_after_widget_fields( $instance, $sc, $widget) {
		if ( $sc == 'trx_addons_widget_contacts' ) {
			$widget->show_field(array('name' => 'color',
								'title' => esc_html__('Color scheme:', 'inestio'),
								'value' => $instance['color'],
								'options' => inestio_get_list_schemes(),
								'type' => 'select'));
		}	
	}
}

// Add color scheme to widget_contact
if ( ! function_exists( 'inestio_skin_trx_addons_sc_atts' ) ) {
	add_filter( 'trx_addons_sc_atts', 'inestio_skin_trx_addons_sc_atts', 10, 2);
	function inestio_skin_trx_addons_sc_atts($defa, $sc) {
		if ( $sc == 'trx_widget_contacts' ) {
			$defa['color'] = 'default';
		}
		return $defa;		
	}
}

// Add color scheme to widget_contact
if ( ! function_exists( 'inestio_video_cover_thumb_size' ) ) {
	add_filter('trx_addons_filter_video_cover_thumb_size', 'inestio_video_cover_thumb_size', 10, 1);
	function inestio_video_cover_thumb_size($imgsize) {
		$imgsize = "full";
		return $imgsize;		
	}
}

// Add theme-specific controls to sections and columns
if ( ! function_exists( 'inestio_skin_elm_add_color_scheme_control' ) ) {
	add_action( 'elementor/element/before_section_end', 'inestio_skin_elm_add_color_scheme_control', 10, 3 );
	function inestio_skin_elm_add_color_scheme_control( $element, $section_id, $args ) {
		if ( is_object( $element ) ) {
			$el_name = $element->get_name();
			if ( 'trx_widget_contacts' == $el_name && 'section_sc_contacts' === $section_id ) {
				$element->add_control(
					'color', array(
						'type'         => \Elementor\Controls_Manager::SELECT,
						'label'        => esc_html__( 'Color scheme', 'inestio' ),
						'label_block'  => false,
						'options'      => inestio_array_merge( array( '' => esc_html__( 'Inherit', 'inestio' ) ), inestio_get_list_schemes() ),
						'render_type'  => 'none',	// ( none | ui | template ) - reload template after parameter is changed
						'default'      => '',
					)
				);
			
			}
		}
	}
}

// Add theme-specific controls to sections and columns
if ( ! function_exists( 'inestio_skin_elm_add_control' ) ) {
	add_action( 'elementor/element/before_section_end', 'inestio_skin_elm_add_control', 10, 3 );
	function inestio_skin_elm_add_control( $element, $section_id, $args ) {
		if ( is_object( $element ) ) {
			$el_name = $element->get_name();
			if ( 'trx_sc_team' == $el_name ) {
				$element->update_control(
					'type', array(
						'default' => 'featured',
					)
				);
			}
		}
	}
}

// Show single post footer: tags, likes and share
if ( ! function_exists( 'inestio_show_post_footer' ) ) {
	function inestio_show_post_footer( $components = 'pages,tags,categories,likes,share,prev_next,author' ) {

		$components               = array_map( 'trim', explode( ',', $components ) );
		$meta_components          = inestio_array_get_keys_by_value( inestio_get_theme_option( 'meta_parts' ) );
		$share_position           = inestio_array_get_keys_by_value( inestio_get_theme_option( 'share_position' ) );

		$full_post_loading        = inestio_get_value_gp( 'action' ) == 'full_post_loading';
		$inestio_posts_navigation = inestio_get_theme_option( 'posts_navigation' );
		foreach( $components as $comp ) {

			if ( 'categories' == $comp ) { 

				// Post categories
				?> 
				<div class="post_categories_single">
					<div class='post_categories_single_wrap'>
					<span class="post_meta_label"><?php echo esc_html__('Categories:', 'inestio'); ?></span><?php
					inestio_show_post_meta(
						apply_filters(
							'inestio_filter_post_meta_args',
								array(
									'components' => 'categories',
									'class'      => 'post_meta_categories',
								),
								'single_footer',
								1
						)
					); ?>
			</div>	</div><?php

			} else if ( 'tags' == $comp ) {

				// Post tags
				the_tags( '<div class="post_tags_single"><div class="post_tags_single_wrap"><span class="post_meta_label">' . esc_html__( 'Tags:', 'inestio' ) . '</span> ', '', '</div></div>' );
				
			} else if ( 'likes' == $comp ) {

				// Emotions
				if ( inestio_exists_trx_addons() && function_exists( 'trx_addons_get_post_reactions' ) && trx_addons_is_on( trx_addons_get_option( 'emotions_allowed' ) ) ) {
					trx_addons_get_post_reactions( true );
				}

			} else if ( 'share' == $comp ) {

				// Likes and Share
				$meta_footer = array();
				if ( in_array( 'likes', $components ) && in_array( 'likes', $meta_components )
						&&
						( ! function_exists( 'trx_addons_get_option' ) || trx_addons_is_off( trx_addons_get_option( 'emotions_allowed' ) ) || ! apply_filters( 'trx_addons_filter_show_post_reactions', is_single() && ! is_attachment() ) )
				) {
					$meta_footer[] = 'likes';
				}
				if ( in_array( 'bottom', $share_position ) ) {
					$meta_footer[] = 'share';
				}
				if ( count( $meta_footer) > 0 ) {
					ob_start();
					inestio_show_post_meta(
						apply_filters(
							'inestio_filter_post_meta_args',
							array(
								'components' => join( ',', $meta_footer ),
								'class'      => 'post_meta_single',
								'share_type' => 'block'
							),
							'single',
							1
						)
					);
					$inestio_meta_output = ob_get_contents();
					ob_end_clean();
					if ( ! empty( $inestio_meta_output ) ) {
						do_action( 'inestio_action_before_post_meta' );
						inestio_show_layout( $inestio_meta_output );
						do_action( 'inestio_action_after_post_meta' );
					}
				}

			} else if ( 'author' == $comp ) {

				// Author bio
				if ( inestio_get_theme_option( 'show_author_info' ) == 1
					&& ! is_attachment()
					&& get_the_author_meta( 'description' )
					&& ( 'scroll' != $inestio_posts_navigation || inestio_get_theme_option( 'posts_navigation_scroll_hide_author' ) == 0 )
					&& ( ! $full_post_loading || inestio_get_theme_option( 'open_full_post_hide_author' ) == 0 )
				) {
					do_action( 'inestio_action_before_post_author' );
					get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/author-bio' ) );
					do_action( 'inestio_action_after_post_author' );
				}

			} else if ( 'prev_next' == $comp ) {

				// Previous/next post navigation.
				if ( 'links' == $inestio_posts_navigation && ! $full_post_loading ) {
					do_action( 'inestio_action_before_post_navigation' );
					?>
					<div class="nav-links-single<?php
						if ( inestio_get_theme_setting( 'thumbs_in_navigation' ) ) {
							echo ' nav-links-with-thumbs';
						}
						if ( ! inestio_is_off( inestio_get_theme_option( 'posts_navigation_fixed' ) ) ) {
							echo ' nav-links-fixed fixed';
						}
					?>">
						<?php
						the_post_navigation(
							array(
								'next_text' => ( inestio_get_theme_setting( 'thumbs_in_navigation' ) ? '<span class="nav-arrow"></span>' : '' )
									. '<span class="nav-arrow-label">' . esc_html__( 'Next', 'inestio' ) . '</span> '
									. '<h6 class="post-title">%title</h6>'
									. '<span class="post_date">%date</span>',
								'prev_text' => ( inestio_get_theme_setting( 'thumbs_in_navigation' ) ? '<span class="nav-arrow"></span>' : '' )
									. '<span class="nav-arrow-label">' . esc_html__( 'Previous', 'inestio' ) . '</span> '
									. '<h6 class="post-title">%title</h6>'
									. '<span class="post_date">%date</span>',
							)
						);
						?>
					</div>
					<?php
					do_action( 'inestio_action_after_post_navigation' );
				}

			}
		}
	}
}

// Unset narrow content width on single posts
if ( ! function_exists( 'inestio_skin_comment_form_args' ) ) {
	add_filter('inestio_filter_comment_form_args', 'inestio_skin_comment_form_args');
	function inestio_skin_comment_form_args( $list = array() ) {
		$list['label_submit'] = esc_html__('Send Comment', 'inestio');
		return $list;
	}
}


// Return theme specific widgetized areas
if ( ! function_exists( 'inestio_skin_list_sidebars' ) ) {
	add_filter('inestio_filter_list_sidebars', 'inestio_skin_list_sidebars');
	function inestio_skin_list_sidebars( $list = array() ) {
		unset($list['header_widgets']);
		unset($list['above_page_widgets']);
		unset($list['above_content_widgets']);
		unset($list['below_content_widgets']);
		unset($list['below_page_widgets']);
		return $list;
	}
}

// Unset narrow content width on single posts
if ( ! function_exists( 'inestio_skin_get_list_expand_content' ) ) {
	add_filter('inestio_filter_list_expand_content', 'inestio_skin_get_list_expand_content');
	function inestio_skin_get_list_expand_content( $list = array() ) {
		unset($list['narrow']);
		return $list;
	}
}


// Enqueue skin-specific scripts
// Priority 1050 -  before main theme plugins-specific (1100)
if ( ! function_exists( 'inestio_skin_frontend_scripts2' ) ) {
	add_action( 'wp_enqueue_scripts', 'inestio_skin_frontend_scripts2', 2210 );
	function inestio_skin_frontend_scripts2() {
		$inestio_url = inestio_get_file_url( inestio_skins_get_current_skin_dir() . 'css/skin-responsive.css' );
		if ( '' != $inestio_url ) {
			wp_enqueue_style( 'inestio-skin-responsive-' . esc_attr( inestio_skins_get_current_skin_name() ), $inestio_url, array(), null );
		}
	}
}
