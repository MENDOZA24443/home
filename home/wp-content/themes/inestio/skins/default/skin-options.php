<?php
/**
 * Skin Options
 *
 * @package INESTIO
 * @since INESTIO 1.76.0
 */


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( ! function_exists( 'inestio_create_theme_options' ) ) {

	function inestio_create_theme_options() {

		// Message about options override.
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = esc_html__( 'Attention! Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages. If you changed such parameter and nothing happened on the page, this option may be overridden in the corresponding section or in the Page Options of this page. These options are marked with an asterisk (*) in the title.', 'inestio' );

		// Color schemes number: if < 2 - hide fields with selectors
		$hide_schemes = count( inestio_storage_get( 'schemes' ) ) < 2;

		inestio_storage_set(

			'options', array(

				// 'Logo & Site Identity'
				//---------------------------------------------
				'title_tagline'                 => array(
					'title'    => esc_html__( 'Logo & Site Identity', 'inestio' ),
					'desc'     => '',
					'priority' => 10,
					'icon'     => 'icon-home-2',
					'type'     => 'section',
				),
				'logo_info'                     => array(
					'title'    => esc_html__( 'Logo Settings', 'inestio' ),
					'desc'     => '',
					'priority' => 20,
					'qsetup'   => esc_html__( 'General', 'inestio' ),
					'type'     => 'info',
				),
				'logo_text'                     => array(
					'title'    => esc_html__( 'Use Site Name as Logo', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Use the site title and tagline as a text logo if no image is selected', 'inestio' ) ),
					'priority' => 30,
					'std'      => 1,
					'qsetup'   => esc_html__( 'General', 'inestio' ),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'logo_zoom'                     => array(
					'title'      => esc_html__( 'Logo zoom', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Zoom the logo (set 1 to leave original size). For this parameter to affect images, their max-height should be specified in "em" instead of "px" when creating a header. In this case maximum size of logo depends on the actual size of the picture.', 'inestio' ) ),
					'std'        => 1,
					'min'        => 0.2,
					'max'        => 2,
					'step'       => 0.1,
					'refresh'    => false,
					'show_value' => true,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'slider',
				),
				'logo_retina_enabled'           => array(
					'title'    => esc_html__( 'Allow retina display logo', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Show fields to select logo images for Retina display', 'inestio' ) ),
					'priority' => 40,
					'refresh'  => false,
					'std'      => 1,
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
				'logo_retina'                   => array(
					'title'      => esc_html__( 'Logo for Retina', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'inestio' ) ),
					'priority'   => 70,
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile_header'            => array(
					'title' => esc_html__( 'Logo for the mobile header', 'inestio' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'inestio' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_header_retina'     => array(
					'title'      => esc_html__( 'Logo for the mobile header on Retina', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'inestio' ) ),
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile'                   => array(
					'title' => esc_html__( 'Logo for the mobile menu', 'inestio' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile menu', 'inestio' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_retina'            => array(
					'title'      => esc_html__( 'Logo mobile on Retina', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'inestio' ) ),
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_side'                     => array(
					'title' => esc_html__( 'Logo for the side menu', 'inestio' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo (with vertical orientation) to display it in the side menu', 'inestio' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'logo_side_retina'              => array(
					'title'      => esc_html__( 'Logo for the side menu on Retina', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'inestio' ) ),
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'image',
				),



				// 'General settings'
				//---------------------------------------------
				'general'                       => array(
					'title'    => esc_html__( 'General', 'inestio' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 20,
					'icon'     => 'icon-settings',
					'type'     => 'section',
				),

				'general_layout_info'           => array(
					'title'  => esc_html__( 'Layout', 'inestio' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'inestio' ),
					'type'   => 'info',
				),
				'body_style'                    => array(
					'title'    => esc_html__( 'Body style', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select width of the body content', 'inestio' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'qsetup'   => esc_html__( 'General', 'inestio' ),
					'refresh'  => false,
					'std'      => 'wide',
					'options'  => inestio_get_list_body_styles( false ),
					'type'     => 'choice',
				),
				'page_width'                    => array(
					'title'      => esc_html__( 'Page width', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Total width of the site content and sidebar (in pixels). If empty - use default width', 'inestio' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed', 'wide' ),
					),
					'std'        => 1170,
					'min'        => 1000,
					'max'        => 1600,
					'step'       => 10,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'page',               // SASS variable's name to preview changes 'on fly'
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'slider',
				),
				'page_boxed_extra'             => array(
					'title'      => esc_html__( 'Boxed page extra spaces', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Width of the extra side space on boxed pages', 'inestio' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'std'        => 60,
					'min'        => 0,
					'max'        => 150,
					'step'       => 10,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'page_boxed_extra',   // SASS variable's name to preview changes 'on fly'
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'slider',
				),
				'boxed_bg_image'                => array(
					'title'      => esc_html__( 'Boxed bg image', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'inestio' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'std'        => '',
					'qsetup'     => esc_html__( 'General', 'inestio' ),
					'type'       => 'image',
				),
				'remove_margins'                => array(
					'title'    => esc_html__( 'Page margins', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Add margins above and below the content area', 'inestio' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'refresh'  => false,
					'std'      => 0,
					'options'  => inestio_get_list_remove_margins(),
					'type'     => 'choice',
				),

				'general_menu_info'             => array(
					'title' => esc_html__( 'Navigation', 'inestio' ),
					'desc'  => '',
					'type'  => INESTIO_THEME_FREE ? 'hidden' : 'info',
				),
				'menu_side'                     => array(
					'title'    => esc_html__( 'Sidemenu position', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select position of the side menu - panel with icons (ancors) for inner-page navigation. Use this menu if shortcodes "Ancor" are present on the page.', 'inestio' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'std'      => 'none',
					'options'  => array(
						'hide'  => array(
										'title' => esc_html__( 'No menu', 'inestio' ),
										'icon'  => 'images/theme-options/menu-side/hide.png',
									),
						'left'  => array(
										'title' => esc_html__( 'Left menu', 'inestio' ),
										'icon'  => 'images/theme-options/menu-side/left.png',
									),
						'right' => array(
										'title' => esc_html__( 'Right menu', 'inestio' ),
										'icon'  => 'images/theme-options/menu-side/right.png',
									),
					),
					'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'choice',
				),
				'menu_side_icons'               => array(
					'title'      => esc_html__( 'Iconed sidemenu', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'menu_side' => array( 'left', 'right' ),
					),
					'std'        => 1,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'menu_side_stretch'             => array(
					'title'      => esc_html__( 'Stretch sidemenu', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Stretch sidemenu to window height (if menu items number >= 5)', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'menu_side' => array( 'left', 'right' ),
						'menu_side_icons' => array( 1 )
					),
					'std'        => 0,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'menu_mobile_fullscreen'        => array(
					'title' => esc_html__( 'Mobile menu fullscreen', 'inestio' ),
					'desc'  => wp_kses_data( __( 'Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'inestio' ) ),
					'std'   => 1,
					'type'  => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),

				'general_sidebar_info'          => array(
					'title' => esc_html__( 'Sidebar', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position'              => array(
					'title'    => esc_html__( 'Sidebar position', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar', 'inestio' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'std'      => 'right',
					'qsetup'   => esc_html__( 'General', 'inestio' ),
					'options'  => array(),
					'type'     => 'choice',
				),
				'sidebar_position_ss'       => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'inestio' ),
					'desc'     => wp_kses_data( __( "Select position to move sidebar (if it's not hidden) on the small screen - above or below the content", 'inestio' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_ss_single'
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
					),
					'std'      => 'below',
					'qsetup'   => esc_html__( 'General', 'inestio' ),
					'options'  => array(),
					'type'     => 'radio',
				),
				'sidebar_type'              => array(
					'title'    => esc_html__( 'Sidebar style', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
					),
					'std'      => 'default',
					'options'  => inestio_get_list_header_footer_types(),
					'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'sidebar_style'                 => array(
					'title'      => esc_html__( 'Select custom layout', 'inestio' ),
					'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'inestio' ), 'inestio_kses_content' ),
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
						'sidebar_type' => array( 'custom' ),
					),
					'std'        => 'sidebar-custom-sidebar',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets'               => array(
					'title'      => esc_html__( 'Sidebar widgets', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_widgets_single'
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
						'sidebar_type'     => array( 'default')
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'inestio' ),
					'type'       => 'select',
				),
				'sidebar_width'                 => array(
					'title'      => esc_html__( 'Sidebar width', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Width of the sidebar (in pixels). If empty - use default width', 'inestio' ) ),
					'std'        => 370,
					'min'        => 150,
					'max'        => 500,
					'step'       => 10,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'sidebar',      // SASS variable's name to preview changes 'on fly'
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'slider',
				),
				'sidebar_gap'                   => array(
					'title'      => esc_html__( 'Sidebar gap', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Gap between content and sidebar (in pixels). If empty - use default gap', 'inestio' ) ),
					'std'        => 40,
					'min'        => 0,
					'max'        => 100,
					'step'       => 1,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'gap',          // SASS variable's name to preview changes 'on fly'
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'slider',
				),
				'expand_content'                => array(
					'title'   => esc_html__( 'Content width', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Content width if the sidebar is hidden', 'inestio' ) ),
					'refresh' => false,
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'expand_content_single'
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'options' => inestio_get_list_expand_content(),
					'std'     => 'expand',
					'type'    => 'choice',
				),

				'general_widgets_info'          => array(
					'title' => esc_html__( 'Additional widgets', 'inestio' ),
					'desc'  => '',
					'type'  => INESTIO_THEME_FREE ? 'hidden' : 'info',
					'type'    => 'hidden',
				),
				'widgets_above_page'            => array(
					'title'    => esc_html__( 'Widgets at the top of the page', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'inestio' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'inestio' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'select',
					'type'    => 'hidden',
				),
				'widgets_above_content'         => array(
					'title'    => esc_html__( 'Widgets above the content', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'inestio' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'inestio' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'select',
					'type'    => 'hidden',
				),
				'widgets_below_content'         => array(
					'title'    => esc_html__( 'Widgets below the content', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'inestio' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'inestio' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'select',
					'type'    => 'hidden',
				),
				'widgets_below_page'            => array(
					'title'    => esc_html__( 'Widgets at the bottom of the page', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'inestio' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'inestio' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'select',
					'type'    => 'hidden',
				),

				'general_effects_info'          => array(
					'title' => esc_html__( 'Design & Effects', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'border_radius'                 => array(
					'title'      => esc_html__( 'Border radius', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Specify the border radius of the form fields and buttons in pixels', 'inestio' ) ),
					'std'        => 0,
					'min'        => 0,
					'max'        => 20,
					'step'       => 1,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'rad',      // SASS name to preview changes 'on fly'
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'slider',
				),

				'general_misc_info'             => array(
					'title' => esc_html__( 'Miscellaneous', 'inestio' ),
					'desc'  => '',
					'type'  => INESTIO_THEME_FREE ? 'hidden' : 'info',
				),
				'seo_snippets'                  => array(
					'title' => esc_html__( 'SEO snippets', 'inestio' ),
					'desc'  => wp_kses_data( __( 'Add structured data markup to the single posts and pages', 'inestio' ) ),
					'std'   => 0,
					'type'  => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'privacy_text' => array(
					"title" => esc_html__("Text with Privacy Policy link", 'inestio'),
					"desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'inestio') ),
					"std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'inestio'), 'inestio_kses_content' ),
					"type"  => "textarea"
				),



				// 'Header'
				//---------------------------------------------
				'header'                        => array(
					'title'    => esc_html__( 'Header', 'inestio' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 30,
					'icon'     => 'icon-header',
					'type'     => 'section',
				),

				'header_style_info'             => array(
					'title' => esc_html__( 'Header style', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type'                   => array(
					'title'    => esc_html__( 'Header style', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'inestio' ),
					),
					'std'      => 'default',
					'options'  => inestio_get_list_header_footer_types(),
					'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'header_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'inestio' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'inestio' ), 'inestio_kses_content' ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'inestio' ),
					),
					'dependency' => array(
						'header_type' => array( 'custom' ),
					),
					'std'        => 'header-custom-elementor-header-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position'               => array(
					'title'    => esc_html__( 'Header position', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'inestio' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'inestio' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'radio',
				),
				'header_fullheight'             => array(
					'title'    => esc_html__( 'Header fullheight', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill the whole screen. Used only if the header has a background image', 'inestio' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'inestio' ),
					),
					'std'      => 0,
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_wide'                   => array(
					'title'      => esc_html__( 'Header fullwidth', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'inestio' ),
					),
					'std'        => 1,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'hidden',
				),
				'header_zoom'                   => array(
					'title'   => esc_html__( 'Header zoom', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Zoom the header title. 1 - original size', 'inestio' ) ),
					'std'     => 1,
					'min'     => 0.2,
					'max'     => 2,
					'step'    => 0.1,
					'show_value' => true,
					'refresh' => false,
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'slider',
				),

				'header_widgets_info'           => array(
					'title' => esc_html__( 'Header widgets', 'inestio' ),
					'desc'  => wp_kses_data( __( 'Here you can place a widget slider, advertising banners, etc.', 'inestio' ) ),
					'type'  => 'hidden',
				),
				'header_widgets'                => array(
					'title'    => esc_html__( 'Header widgets', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select set of widgets to show in the header on each page', 'inestio' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'inestio' ),
						'desc'    => wp_kses_data( __( 'Select set of widgets to show in the header on this page', 'inestio' ) ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => 'hidden',
				),
				'header_columns'                => array(
					'title'      => esc_html__( 'Header columns', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'inestio' ),
					),
					'dependency' => array(
						'header_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => inestio_get_list_range( 0, 6 ),
					'type'       => 'select',
				),

				'header_image_info'             => array(
					'title' => esc_html__( 'Header image', 'inestio' ),
					'desc'  => '',
					'type'  => INESTIO_THEME_FREE ? 'hidden' : 'info',
				),
				'header_image_override'         => array(
					'title'    => esc_html__( 'Header image override', 'inestio' ),
					'desc'     => wp_kses_data( __( "Allow override the header image with the page's/post's/product's/etc. featured image", 'inestio' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'inestio' ),
					),
					'std'      => 1,
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),

				'header_mobile_info'            => array(
					'title'      => esc_html__( 'Mobile header', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Configure the mobile version of the header', 'inestio' ) ),
					'priority'   => 500,
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'info',
				),
				'header_mobile_enabled'         => array(
					'title'      => esc_html__( 'Enable the mobile header', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Use the mobile version of the header (if checked) or relayout the current header on mobile devices', 'inestio' ) ),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_mobile_additional_info' => array(
					'title'      => esc_html__( 'Additional info', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Additional info to show at the top of the mobile header', 'inestio' ) ),
					'std'        => '',
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'refresh'    => false,
					'teeny'      => false,
					'rows'       => 20,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'text_editor',
				),
				'header_mobile_hide_info'       => array(
					'title'      => esc_html__( 'Hide additional info', 'inestio' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_mobile_hide_logo'       => array(
					'title'      => esc_html__( 'Hide logo', 'inestio' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_mobile_hide_login'      => array(
					'title'      => esc_html__( 'Hide login/logout', 'inestio' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_mobile_hide_search'     => array(
					'title'      => esc_html__( 'Hide search', 'inestio' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_mobile_hide_cart'       => array(
					'title'      => esc_html__( 'Hide cart', 'inestio' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),



				// 'Footer'
				//---------------------------------------------
				'footer'                        => array(
					'title'    => esc_html__( 'Footer', 'inestio' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 50,
					'icon'     => 'icon-footer',
					'type'     => 'section',
				),
				'footer_type'                   => array(
					'title'    => esc_html__( 'Footer style', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'inestio' ),
					),
					'std'      => 'default',
					'options'  => inestio_get_list_header_footer_types(),
					'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'footer_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'inestio' ),
					'desc'       => wp_kses( __( 'Select custom footer from Layouts Builder', 'inestio' ), 'inestio_kses_content' ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'inestio' ),
					),
					'dependency' => array(
						'footer_type' => array( 'custom' ),
					),
					'std'        => 'footer-custom-elementor-footer-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets'                => array(
					'title'      => esc_html__( 'Footer widgets', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'inestio' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns'                => array(
					'title'      => esc_html__( 'Footer columns', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'inestio' ),
					),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'footer_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => inestio_get_list_range( 0, 6 ),
					'type'       => 'select',
				),
				'footer_wide'                   => array(
					'title'      => esc_html__( 'Footer fullwidth', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'inestio' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'switch',
				),
				'logo_in_footer'                => array(
					'title'      => esc_html__( 'Show logo', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Show logo in the footer', 'inestio' ) ),
					'refresh'    => false,
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'switch',
				),
				'logo_footer'                   => array(
					'title'      => esc_html__( 'Logo for footer', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo to display it in the footer', 'inestio' ) ),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'logo_in_footer' => array( 1 ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'logo_footer_retina'            => array(
					'title'      => esc_html__( 'Logo for footer (Retina)', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'inestio' ) ),
					'dependency' => array(
						'footer_type'         => array( 'default' ),
						'logo_in_footer'      => array( 1 ),
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'image',
				),
				'socials_in_footer'             => array(
					'title'      => esc_html__( 'Show social icons', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Show social icons in the footer (under logo or footer widgets)', 'inestio' ) ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => ! inestio_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'copyright'                     => array(
					'title'      => esc_html__( 'Copyright', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'inestio' ) ),
					'translate'  => true,
					'std'        => esc_html__( 'Copyright &copy; {Y} by AxiomThemes. All rights reserved.', 'inestio' ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'refresh'    => false,
					'type'       => 'textarea',
				),



				// 'Mobile version'
				//---------------------------------------------
				'mobile'                        => array(
					'title'    => esc_html__( 'Mobile', 'inestio' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 55,
					'icon'     => 'icon-smartphone',
					'type'     => 'section',
				),

				'mobile_header_info'            => array(
					'title' => esc_html__( 'Header on the mobile device', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_mobile'            => array(
					'title'    => esc_html__( 'Header style', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use on mobile devices: the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
					'std'      => 'inherit',
					'options'  => inestio_get_list_header_footer_types( true ),
					'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'header_style_mobile'           => array(
					'title'      => esc_html__( 'Select custom layout', 'inestio' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'inestio' ), 'inestio_kses_content' ),
					'dependency' => array(
						'header_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_mobile'        => array(
					'title'    => esc_html__( 'Header position', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'inestio' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'radio',
				),

				'mobile_sidebar_info'           => array(
					'title' => esc_html__( 'Sidebar on the mobile device', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_mobile'       => array(
					'title'    => esc_html__( 'Sidebar position on mobile', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar on mobile devices', 'inestio' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => 'choice',
				),
				'sidebar_type_mobile'           => array(
					'title'    => esc_html__( 'Sidebar style', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
					),
					'std'      => 'inherit',
					'options'  => inestio_get_list_header_footer_types( true ),
					'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'sidebar_style_mobile'          => array(
					'title'      => esc_html__( 'Select custom layout', 'inestio' ),
					'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'inestio' ), 'inestio_kses_content' ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
						'sidebar_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets_mobile'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on mobile devices', 'inestio' ) ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
						'sidebar_type_mobile' => array( 'default' )
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_mobile'         => array(
					'title'   => esc_html__( 'Content width', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Content width if the sidebar is hidden on mobile devices', 'inestio' ) ),
					'refresh' => false,
					'dependency' => array(
						'sidebar_position_mobile' => array( 'hide', 'inherit' ),
					),
					'std'     => 'inherit',
					'options' => inestio_get_list_expand_content( true ),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'choice',
				),

				'mobile_footer_info'           => array(
					'title' => esc_html__( 'Footer on the mobile device', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'footer_type_mobile'           => array(
					'title'    => esc_html__( 'Footer style', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use on mobile devices: the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
					'std'      => 'inherit',
					'options'  => inestio_get_list_header_footer_types( true ),
					'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'footer_style_mobile'          => array(
					'title'      => esc_html__( 'Select custom layout', 'inestio' ),
					'desc'       => wp_kses( __( 'Select custom footer from Layouts Builder', 'inestio' ), 'inestio_kses_content' ),
					'dependency' => array(
						'footer_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets_mobile'        => array(
					'title'      => esc_html__( 'Footer widgets', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'inestio' ) ),
					'dependency' => array(
						'footer_type_mobile' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns_mobile'        => array(
					'title'      => esc_html__( 'Footer columns', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'inestio' ) ),
					'dependency' => array(
						'footer_type_mobile'    => array( 'default' ),
						'footer_widgets_mobile' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => inestio_get_list_range( 0, 6 ),
					'type'       => 'select',
				),



				// 'Blog'
				//---------------------------------------------
				'blog'                          => array(
					'title'    => esc_html__( 'Blog', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Options of the the blog archive', 'inestio' ) ),
					'priority' => 70,
					'icon'     => 'icon-page',
					'type'     => 'panel',
				),


				// Blog - Posts page
				//---------------------------------------------
				'blog_general'                  => array(
					'title' => esc_html__( 'Posts page', 'inestio' ),
					'desc'  => wp_kses_data( __( 'Style and components of the blog archive', 'inestio' ) ),
					'type'  => 'section',
				),
				'blog_general_info'             => array(
					'title'  => esc_html__( 'Posts page settings', 'inestio' ),
					'desc'   => wp_kses_data( __( 'Customize the blog archive: post layout, header and footer style, sidebar position, etc.', 'inestio' ) ),
					'qsetup' => esc_html__( 'General', 'inestio' ),
					'type'   => 'info',
				),
				'blog_style'                    => array(
					'title'      => esc_html__( 'Blog style', 'inestio' ),
					'desc'       => '',
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'std'        => 'excerpt',
					'qsetup'     => esc_html__( 'General', 'inestio' ),
					'options'    => array(),
					'type'       => 'choice',
				),
				'first_post_large'              => array(
					'title'      => esc_html__( 'First post large', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Make your first post stand out by making it bigger', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array( 'classic', 'masonry' ),
					),
					'std'        => 0,
					'type'       => 'switch',
				),
				'blog_content'                  => array(
					'title'      => esc_html__( 'Posts content', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Display either post excerpts or the full post content', 'inestio' ) ),
					'std'        => 'excerpt',
					'dependency' => array(
						'blog_style' => array( 'excerpt' ),
					),
					'options'    => inestio_get_list_blog_contents(),
					'type'       => 'radio',
				),
				'excerpt_length'                => array(
					'title'      => esc_html__( 'Excerpt length', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged', 'inestio' ) ),
					'dependency' => array(
						'blog_style'   => array( 'excerpt' ),
						'blog_content' => array( 'excerpt' ),
					),
					'std'        => 55,
					'type'       => 'text',
				),
				'blog_columns'                  => array(
					'title'   => esc_html__( 'Blog columns', 'inestio' ),
					'desc'    => wp_kses_data( __( 'How many columns should be used in the blog archive (from 2 to 4)?', 'inestio' ) ),
					'std'     => 2,
					'options' => inestio_get_list_range( 2, 4 ),
					'type'    => 'hidden',      // This options is available and must be overriden only for some modes (for example, 'shop')
				),
				'post_type'                     => array(
					'title'      => esc_html__( 'Post type', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select post type to show in the blog archive', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'linked'     => 'parent_cat',
					'refresh'    => false,
					'hidden'     => true,
					'std'        => 'post',
					'options'    => array(),
					'type'       => 'select',
				),
				'parent_cat'                    => array(
					'title'      => esc_html__( 'Category to show', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select category to show in the blog archive', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'refresh'    => false,
					'hidden'     => true,
					'std'        => '0',
					'options'    => array(),
					'type'       => 'select',
				),
				'posts_per_page'                => array(
					'title'      => esc_html__( 'Posts per page', 'inestio' ),
					'desc'       => wp_kses_data( __( 'How many posts will be displayed on this page', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'hidden'     => true,
					'std'        => '',
					'type'       => 'text',
				),
				'blog_pagination'               => array(
					'title'      => esc_html__( 'Pagination style', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Show Older/Newest posts or Page numbers below the posts list', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'std'        => 'pages',
					'qsetup'     => esc_html__( 'General', 'inestio' ),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'options'    => inestio_get_list_blog_paginations(),
					'type'       => 'choice',
				),
				'blog_animation'                => array(
					'title'      => esc_html__( 'Post animation', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour!', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'compare'                                  => 'or',
						'#page_template'                           => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'std'        => 'fadeInUp',
					'options'    => array(),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'select',
				),
				'disable_animation_on_mobile'   => array(
					'title'      => esc_html__( 'Disable animation on mobile', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Disable any posts animation on mobile devices', 'inestio' ) ),
					'std'        => 1,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'show_filters'                  => array(
					'title'      => esc_html__( 'Show filters', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Show categories as tabs to filter posts', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'compare'                                  => 'or',
						'#page_template'                           => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'hidden'     => true,
					'std'        => 0,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'video_in_popup'                => array(
					'title'      => esc_html__( 'Open video in the popup on a blog archive', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Open the video from posts in the popup (if plugin "ThemeREX Addons" is installed) or play the video instead the cover image', 'inestio' ) ),
					'std'        => 1,
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'compare'                                  => 'or',
						'#page_template'                           => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'type'       => 'switch',
				),
				'open_full_post_in_blog'        => array(
					'title'      => esc_html__( 'Open full post in blog', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Allow to open the full version of the post directly in the blog feed. Attention! Applies only to 1 column layouts!', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'std'        => 0,
					'type'       => 'switch',
				),
				'open_full_post_hide_author'    => array(
					'title'      => esc_html__( 'Hide author bio', 'inestio' ),
					'desc'       => wp_kses_data( __( "Hide author bio after post content when open the full version of the post directly in the blog feed.", 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'open_full_post_in_blog' => array( 1 ),
					),
					'std'        => 1,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'open_full_post_hide_related'   => array(
					'title'      => esc_html__( 'Hide related posts', 'inestio' ),
					'desc'       => wp_kses_data( __( "Hide related posts after post content when open the full version of the post directly in the blog feed.", 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'open_full_post_in_blog' => array( 1 ),
					),
					'std'        => 1,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_header_info'              => array(
					'title' => esc_html__( 'Header', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_blog'              => array(
					'title'    => esc_html__( 'Header style', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
					'std'      => 'inherit',
					'options'  => inestio_get_list_header_footer_types( true ),
					'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'header_style_blog'             => array(
					'title'      => esc_html__( 'Select custom layout', 'inestio' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'inestio' ), 'inestio_kses_content' ),
					'dependency' => array(
						'header_type_blog' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_blog'          => array(
					'title'    => esc_html__( 'Header position', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'inestio' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'radio',
				),
				'header_fullheight_blog'        => array(
					'title'    => esc_html__( 'Header fullheight', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'inestio' ) ),
					'std'      => 'inherit',
					'options'  => inestio_get_list_checkbox_values( true ),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'radio',
				),
				'header_wide_blog'              => array(
					'title'      => esc_html__( 'Header fullwidth', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'inestio' ) ),
					'dependency' => array(
						'header_type_blog' => array( 'default' ),
					),
					'std'      => 'inherit',
					'options'  => inestio_get_list_checkbox_values( true ),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'hidden',
				),

				'blog_sidebar_info'             => array(
					'title' => esc_html__( 'Sidebar', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_blog'         => array(
					'title'   => esc_html__( 'Sidebar position', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar', 'inestio' ) ),
					'std'     => 'inherit',
					'options' => array(),
					'qsetup'     => esc_html__( 'General', 'inestio' ),
					'type'    => 'choice',
				),
				'sidebar_position_ss_blog'  => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'inestio' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'      => 'inherit',
					'qsetup'   => esc_html__( 'General', 'inestio' ),
					'options'  => array(),
					'type'     => 'radio',
				),
				'sidebar_type_blog'           => array(
					'title'    => esc_html__( 'Sidebar style', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'      => 'default',
					'options'  => inestio_get_list_header_footer_types(),
					'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'sidebar_style_blog'            => array(
					'title'      => esc_html__( 'Select custom layout', 'inestio' ),
					'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'inestio' ), 'inestio_kses_content' ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
						'sidebar_type_blog'     => array( 'custom' ),
					),
					'std'        => 'sidebar-custom-sidebar',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets_blog'          => array(
					'title'      => esc_html__( 'Sidebar widgets', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'inestio' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
						'sidebar_type_blog'     => array( 'default' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'inestio' ),
					'type'       => 'select',
				),
				'expand_content_blog'           => array(
					'title'   => esc_html__( 'Content width', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Content width if the sidebar is hidden', 'inestio' ) ),
					'refresh' => false,
					'std'     => 'inherit',
					'options' => inestio_get_list_expand_content( true ),
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'choice',
				),

				'blog_widgets_info'             => array(
					'title' => esc_html__( 'Additional widgets', 'inestio' ),
					'desc'  => '',
					'type'  => INESTIO_THEME_FREE ? 'hidden' : 'info',
					'type'    => 'hidden',
				),
				'widgets_above_page_blog'       => array(
					'title'   => esc_html__( 'Widgets at the top of the page', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'inestio' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'select',
					'type'    => 'hidden',
				),
				'widgets_above_content_blog'    => array(
					'title'   => esc_html__( 'Widgets above the content', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'inestio' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'select',
					'type'    => 'hidden',
				),
				'widgets_below_content_blog'    => array(
					'title'   => esc_html__( 'Widgets below the content', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'inestio' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'select',
					'type'    => 'hidden',
				),
				'widgets_below_page_blog'       => array(
					'title'   => esc_html__( 'Widgets at the bottom of the page', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'inestio' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'select',
					'type'    => 'hidden',
				),

				'blog_advanced_info'            => array(
					'title' => esc_html__( 'Advanced settings', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'no_image'                      => array(
					'title' => esc_html__( 'Image placeholder', 'inestio' ),
					'desc'  => wp_kses_data( __( "Select or upload an image used as placeholder for posts without a featured image. Placeholder is used on the blog stream page only (no placeholder in single post), and only in those styles of it where non-using featured image doesn't seem appropriate.", 'inestio' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'time_diff_before'              => array(
					'title' => esc_html__( 'Easy Readable Date Format', 'inestio' ),
					'desc'  => wp_kses_data( __( "For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'inestio' ) ),
					'std'   => 5,
					'type'  => 'text',
				),
				'sticky_style'                  => array(
					'title'   => esc_html__( 'Sticky posts style', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Select style of the sticky posts output', 'inestio' ) ),
					'std'     => 'inherit',
					'options' => array(
						'inherit' => esc_html__( 'Decorated posts', 'inestio' ),
						'columns' => esc_html__( 'Mini-cards', 'inestio' ),
					),
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'select',
				),
				'meta_parts'                    => array(
					'title'      => esc_html__( 'Post meta', 'inestio' ),
					'desc'       => wp_kses_data( __( "If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'inestio' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'author=1|date=1|comments=1|categories=1',
					'options'    => inestio_get_list_meta_parts(),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'checklist',
				),
				'use_blog_archive_pages'        => array(
					'title'      => esc_html__( 'Use "Blog Archive" page settings on the post list', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Apply options and content of pages created with the template "Blog Archive" for some type of posts and / or taxonomy when viewing feeds of posts of this type and taxonomy.', 'inestio' ) ),
					'std'        => 0,
					'type'       => 'switch',
				),


				// Blog - Single posts
				//---------------------------------------------
				'blog_single'                   => array(
					'title' => esc_html__( 'Single posts', 'inestio' ),
					'desc'  => wp_kses_data( __( 'Settings of the single post', 'inestio' ) ),
					'type'  => 'section',
				),

				'blog_single_header_info'       => array(
					'title' => esc_html__( 'Header', 'inestio' ),
					'desc'   => wp_kses_data( __( 'Customize the single post: post layout, header and footer style,sidebar position, meta parts, etc.', 'inestio' ) ),
					'type'  => 'info',
				),
				'header_type_single'            => array(
					'title'    => esc_html__( 'Header style', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
					'std'      => 'inherit',
					'options'  => inestio_get_list_header_footer_types( true ),
					'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'header_style_single'           => array(
					'title'      => esc_html__( 'Select custom layout', 'inestio' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'inestio' ), 'inestio_kses_content' ),
					'dependency' => array(
						'header_type_single' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_single'        => array(
					'title'    => esc_html__( 'Header position', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'inestio' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'radio',
				),
				'header_fullheight_single'      => array(
					'title'    => esc_html__( 'Header fullheight', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'inestio' ) ),
					'std'      => 'inherit',
					'options'  => inestio_get_list_checkbox_values( true ),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'radio',
				),
				'header_wide_single'            => array(
					'title'      => esc_html__( 'Header fullwidth', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'inestio' ) ),
					'dependency' => array(
						'header_type_single' => array( 'default' ),
					),
					'std'      => 'inherit',
					'options'  => inestio_get_list_checkbox_values( true ),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'hidden',
				),

				'blog_single_sidebar_info'      => array(
					'title' => esc_html__( 'Sidebar', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_single'       => array(
					'title'   => esc_html__( 'Sidebar position', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar on the single posts', 'inestio' ) ),
					'std'     => 'hide',
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'options' => array(),
					'type'    => 'choice',
				),
				'sidebar_position_ss_single'    => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select position to move sidebar on the single posts on the small screen - above or below the content', 'inestio' ) ),
					'override' => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'      => 'below',
					'options'  => array(),
					'type'     => 'radio',
				),
				'sidebar_type_single'           => array(
					'title'    => esc_html__( 'Sidebar style', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'      => 'default',
					'options'  => inestio_get_list_header_footer_types(),
					'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'sidebar_style_single'            => array(
					'title'      => esc_html__( 'Select custom layout', 'inestio' ),
					'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'inestio' ), 'inestio_kses_content' ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
						'sidebar_type_single'     => array( 'custom' ),
					),
					'std'        => 'sidebar-custom-sidebar',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets_single'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on the single posts', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
						'sidebar_type_single'     => array( 'default' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_single'         => array(
					'title'   => esc_html__( 'Content width', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Content width on the single posts if the sidebar is hidden', 'inestio' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'refresh' => false,
					'std'     => 'normal',
					'options' => inestio_get_list_expand_content( true ),
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'choice',
				),

				'blog_single_title_info'        => array(
					'title' => esc_html__( 'Featured image and title', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'single_style'                  => array(
					'title'      => esc_html__( 'Single style', 'inestio' ),
					'desc'       => '',
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'std'        => 'style-1',
					'qsetup'     => esc_html__( 'General', 'inestio' ),
					'options'    => array(),
					'type'       => 'choice',
				),
				'post_subtitle'                 => array(
					'title' => esc_html__( 'Post subtitle', 'inestio' ),
					'desc'  => wp_kses_data( __( "Specify post subtitle to display it under the post title.", 'inestio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'std'   => '',
					'hidden' => true,
					'type'  => 'text',
				),
				'show_post_meta'                => array(
					'title' => esc_html__( 'Show post meta', 'inestio' ),
					'desc'  => wp_kses_data( __( "Display block with post's meta: date, categories, counters, etc.", 'inestio' ) ),
					'std'   => 1,
					'type'  => 'switch',
				),
				'meta_parts_single'             => array(
					'title'      => esc_html__( 'Post meta', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Meta parts for single posts. Post counters and Share Links are available only if plugin ThemeREX Addons is active', 'inestio' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'inestio' ) ),
					'dependency' => array(
						'show_post_meta' => array( 1 ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'author=1|categories=1|date=1|views=0|likes=0|share=1|comments=1|edit=1|rating=0',
					'options'    => inestio_get_list_meta_parts(),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'checklist',
				),
				'share_position'                 => array(
					'title'      => esc_html__( 'Share links position', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select one or more positions to show Share links on single posts. Post counters and Share Links are available only if plugin ThemeREX Addons is active', 'inestio' ) ),
					'dependency' => array(
						'show_post_meta' => array( 1 ),
					),
					'dir'        => 'vertical',
					'std'        => 'left=0',
					'options'    => inestio_get_list_share_links_positions(),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'checklist',
				),
				'show_author_info'              => array(
					'title' => esc_html__( 'Show author info', 'inestio' ),
					'desc'  => wp_kses_data( __( "Display block with information about post's author", 'inestio' ) ),
					'std'   => 1,
					'type'  => 'switch',
				),

				'blog_single_related_info'      => array(
					'title' => esc_html__( 'Related posts', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'show_related_posts'            => array(
					'title'    => esc_html__( 'Show related posts', 'inestio' ),
					'desc'     => wp_kses_data( __( "Show section 'Related posts' on the single post's pages", 'inestio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'std'      => 1,
					'type'     => 'switch',
				),
				'related_style'                 => array(
					'title'      => esc_html__( 'Related posts style', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select style of the related posts output', 'inestio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'classic',
					'options'    => array(
						'classic' => esc_html__( 'Classic', 'inestio' ),
						'short'   => esc_html__( 'Short', 'inestio' ),
					),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'radio',
				),
				'related_position'              => array(
					'title'      => esc_html__( 'Related posts position', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select position to display the related posts', 'inestio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'below_content',
					'options'    => array (
						'inside'        => esc_html__( 'Inside the content (fullwidth)', 'inestio' ),
						'inside_left'   => esc_html__( 'At left side of the content', 'inestio' ),
						'inside_right'  => esc_html__( 'At right side of the content', 'inestio' ),
						'below_content' => esc_html__( 'After the content', 'inestio' ),
						'below_page'    => esc_html__( 'After the content & sidebar', 'inestio' ),
					),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'select',
				),
				'related_position_inside'       => array(
					'title'      => esc_html__( 'Before # paragraph', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Before what paragraph should related posts appear? If 0 - randomly.', 'inestio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_position' => array( 'inside', 'inside_left', 'inside_right' ),
					),
					'std'        => 2,
					'options'    => inestio_get_list_range( 0, 9 ),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'select',
				),
				'related_posts'                 => array(
					'title'      => esc_html__( 'Related posts', 'inestio' ),
					'desc'       => wp_kses_data( __( 'How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'inestio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 2,
					'min'        => 1,
					'max'        => 9,
					'show_value' => true,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'slider',
				),
				'related_columns'               => array(
					'title'      => esc_html__( 'Related columns', 'inestio' ),
					'desc'       => wp_kses_data( __( 'How many columns should be used to output related posts in the single page?', 'inestio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_position' => array( 'inside', 'below_content', 'below_page' ),
					),
					'std'        => 2,
					'options'    => inestio_get_list_range( 1, 6 ),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'radio',
				),
				'related_slider'                => array(
					'title'      => esc_html__( 'Use slider layout', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Use slider layout in case related posts count is more than columns count', 'inestio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 0,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_slider_controls'       => array(
					'title'      => esc_html__( 'Slider controls', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Show arrows in the slider', 'inestio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'none',
					'options'    => array(
						'none'    => esc_html__('None', 'inestio'),
						'side'    => esc_html__('Side', 'inestio'),
						'outside' => esc_html__('Outside', 'inestio'),
						'top'     => esc_html__('Top', 'inestio'),
						'bottom'  => esc_html__('Bottom', 'inestio')
					),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'select',
				),
				'related_slider_pagination'       => array(
					'title'      => esc_html__( 'Slider pagination', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Show bullets after the slider', 'inestio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'bottom',
					'options'    => array(
						'none'    => esc_html__('None', 'inestio'),
						'bottom'  => esc_html__('Bottom', 'inestio')
					),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'radio',
				),
				'related_slider_space'          => array(
					'title'      => esc_html__( 'Space between slides', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Space between slides in the related posts slider', 'inestio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'inestio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 30,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'text',
				),
				'posts_navigation_info'      => array(
					'title' => esc_html__( 'Posts navigation', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'posts_navigation'           => array(
					'title'   => esc_html__( 'Show posts navigation', 'inestio' ),
					'desc'    => wp_kses_data( __( "Show posts navigation on the single post's pages", 'inestio' ) ),
					'std'     => 'none',
					'options' => array(
						'none'   => esc_html__('None', 'inestio'),
						'links'  => esc_html__('Prev/Next links', 'inestio'),
						'scroll' => esc_html__('Autoload next post', 'inestio')
					),
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'radio',
				),
				'posts_navigation_fixed'     => array(
					'title'      => esc_html__( 'Fixed posts navigation', 'inestio' ),
					'desc'       => wp_kses_data( __( "Make posts navigation fixed position. Display it when the content of the article is inside the window.", 'inestio' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'links' ),
					),
					'std'        => 0,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'posts_navigation_scroll_which_block'  => array(
					'title'   => esc_html__( 'Which block to load?', 'inestio' ),
					'desc'    => wp_kses_data( __( "Load only the content of the next article or the article and sidebar together?", 'inestio' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'     => 'article',
					'options' => array(
						'article' => array(
										'title' => esc_html__( 'Only content', 'inestio' ),
										'icon'  => 'images/theme-options/posts-navigation-scroll-which-block/article.png',
									),
						'wrapper' => array(
										'title' => esc_html__( 'Full post', 'inestio' ),
										'icon'  => 'images/theme-options/posts-navigation-scroll-which-block/wrapper.png',
									),
					),
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'choice',
				),
				'posts_navigation_scroll_hide_author'  => array(
					'title'      => esc_html__( 'Hide author bio', 'inestio' ),
					'desc'       => wp_kses_data( __( "Hide author bio after post content when infinite scroll is used.", 'inestio' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 0,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'posts_navigation_scroll_hide_related'  => array(
					'title'      => esc_html__( 'Hide related posts', 'inestio' ),
					'desc'       => wp_kses_data( __( "Hide related posts after post content when infinite scroll is used.", 'inestio' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 0,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'posts_navigation_scroll_hide_comments' => array(
					'title'      => esc_html__( 'Hide comments', 'inestio' ),
					'desc'       => wp_kses_data( __( "Hide comments after post content when infinite scroll is used.", 'inestio' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 1,
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'blog_end'                      => array(
					'type' => 'panel_end',
				),



				// 'Colors'
				//---------------------------------------------
				'panel_colors'                  => array(
					'title'    => esc_html__( 'Colors', 'inestio' ),
					'desc'     => '',
					'priority' => 300,
					'icon'     => 'icon-customizer',
					'type'     => 'section',
				),

				'color_schemes_info'            => array(
					'title'  => esc_html__( 'Color schemes', 'inestio' ),
					'desc'   => wp_kses_data( __( 'Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'inestio' ) ),
					'hidden' => $hide_schemes,
					'type'   => 'info',
				),
				'color_scheme'                  => array(
					'title'    => esc_html__( 'Site Color Scheme', 'inestio' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'inestio' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'radio',
				),
				'header_scheme'                 => array(
					'title'    => esc_html__( 'Header Color Scheme', 'inestio' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'inestio' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'radio',
				),
				'menu_scheme'                   => array(
					'title'    => esc_html__( 'Sidemenu Color Scheme', 'inestio' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'inestio' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes || INESTIO_THEME_FREE ? 'hidden' : 'radio',
				),
				'sidebar_scheme'                => array(
					'title'    => esc_html__( 'Sidebar Color Scheme', 'inestio' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'inestio' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'radio',
				),
				'footer_scheme'                 => array(
					'title'    => esc_html__( 'Footer Color Scheme', 'inestio' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'inestio' ),
					),
					'std'      => 'dark',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'radio',
				),

				'color_scheme_editor_info'      => array(
					'title' => esc_html__( 'Color scheme editor', 'inestio' ),
					'desc'  => wp_kses_data( __( 'Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'inestio' ) ),
					'type'  => 'info',
				),
				'scheme_storage'                => array(
					'title'       => esc_html__( 'Color scheme editor', 'inestio' ),
					'desc'        => '',
					'std'         => '$inestio_get_scheme_storage',
					'refresh'     => false,
					'colorpicker' => 'spectrum', //'tiny',
					'type'        => 'scheme_editor',
				),

				// Internal options.
				// Attention! Don't change any options in the section below!
				// Huge priority is used to call render this elements after all options!
				'reset_options'                 => array(
					'title'    => '',
					'desc'     => '',
					'std'      => '0',
					'priority' => 10000,
					'type'     => 'hidden',
				),

				'last_option'                   => array(     // Need to manually call action to include Tiny MCE scripts
					'title' => '',
					'desc'  => '',
					'std'   => 1,
					'type'  => 'hidden',
				),

			)
		);


		// Add parameters for "Caregory", "Tag", "Author", "Search" to Theme Options
		inestio_storage_set_array_before( 'options', 'blog_single', inestio_options_get_list_blog_options( 'category', esc_html__( 'Category', 'inestio' ) ) );
		inestio_storage_set_array_before( 'options', 'blog_single', inestio_options_get_list_blog_options( 'tag', esc_html__( 'Tag', 'inestio' ) ) );
		inestio_storage_set_array_before( 'options', 'blog_single', inestio_options_get_list_blog_options( 'author', esc_html__( 'Author', 'inestio' ) ) );
		inestio_storage_set_array_before( 'options', 'blog_single', inestio_options_get_list_blog_options( 'search', esc_html__( 'Search', 'inestio' ) ) );


		// Prepare panel 'Fonts'
		// -------------------------------------------------------------
		$fonts = array(

			// 'Fonts'
			//---------------------------------------------
			'fonts'             => array(
				'title'    => esc_html__( 'Typography', 'inestio' ),
				'desc'     => '',
				'priority' => 200,
				'icon'     => 'icon-text',
				'type'     => 'panel',
			),

			// Fonts - Load_fonts
			'load_fonts'        => array(
				'title' => esc_html__( 'Load fonts', 'inestio' ),
				'desc'  => wp_kses_data( __( 'Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'inestio' ) )
						. wp_kses_data( __( 'Press "Refresh" button to reload preview area after the all fonts are changed', 'inestio' ) ),
				'type'  => 'section',
			),
			'load_fonts_info'   => array(
				'title' => esc_html__( 'Load fonts', 'inestio' ),
				'desc'  => '',
				'type'  => 'info',
			),
			'load_fonts_subset' => array(
				'title'   => esc_html__( 'Google fonts subsets', 'inestio' ),
				'desc'    => wp_kses_data( __( 'Specify comma separated list of the subsets which will be load from Google fonts', 'inestio' ) )
						. wp_kses_data( __( 'Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'inestio' ) ),
				'class'   => 'inestio_column-1_3 inestio_new_row',
				'refresh' => false,
				'std'     => '$inestio_get_load_fonts_subset',
				'type'    => 'text',
			),
		);

		for ( $i = 1; $i <= inestio_get_theme_setting( 'max_load_fonts' ); $i++ ) {
			if ( inestio_get_value_gp( 'page' ) != 'theme_options' ) {
				$fonts[ "load_fonts-{$i}-info" ] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					'title' => esc_html( sprintf( __( 'Font %s', 'inestio' ), $i ) ),
					'desc'  => '',
					'type'  => 'info',
				);
			}
			$fonts[ "load_fonts-{$i}-name" ]   = array(
				'title'   => esc_html__( 'Font name', 'inestio' ),
				'desc'    => '',
				'class'   => 'inestio_column-1_3 inestio_new_row',
				'refresh' => false,
				'std'     => '$inestio_get_load_fonts_option',
				'type'    => 'text',
			);
			$fonts[ "load_fonts-{$i}-family" ] = array(
				'title'   => esc_html__( 'Font family', 'inestio' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Select font family to use it if font above is not available', 'inestio' ) )
							: '',
				'class'   => 'inestio_column-1_3',
				'refresh' => false,
				'std'     => '$inestio_get_load_fonts_option',
				'options' => array(
					'inherit'    => esc_html__( 'Inherit', 'inestio' ),
					'serif'      => esc_html__( 'serif', 'inestio' ),
					'sans-serif' => esc_html__( 'sans-serif', 'inestio' ),
					'monospace'  => esc_html__( 'monospace', 'inestio' ),
					'cursive'    => esc_html__( 'cursive', 'inestio' ),
					'fantasy'    => esc_html__( 'fantasy', 'inestio' ),
				),
				'type'    => 'select',
			);
			$fonts[ "load_fonts-{$i}-styles" ] = array(
				'title'   => esc_html__( 'Font styles', 'inestio' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'inestio' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Each weight and style increase download size! Specify only used weights and styles.', 'inestio' ) )
							: '',
				'class'   => 'inestio_column-1_3',
				'refresh' => false,
				'std'     => '$inestio_get_load_fonts_option',
				'type'    => 'text',
			);
		}
		$fonts['load_fonts_end'] = array(
			'type' => 'section_end',
		);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = inestio_get_theme_fonts();
		foreach ( $theme_fonts as $tag => $v ) {
			$fonts[ "{$tag}_font_section" ] = array(
				'title' => ! empty( $v['title'] )
								? $v['title']
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html( sprintf( __( '%s settings', 'inestio' ), $tag ) ),
				'desc'  => ! empty( $v['description'] )
								? $v['description']
								// Translators: Add tag's name to make description
								: wp_kses_data( sprintf( __( 'Font settings of the "%s" tag.', 'inestio' ), $tag ) ),
				'type'  => 'section',
			);
			$fonts[ "{$tag}_font_info" ] = array(
				'title' => ! empty( $v['title'] )
								? $v['title']
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html( sprintf( __( '%s settings', 'inestio' ), $tag ) ),
				'desc'  => ! empty( $v['description'] )
								? $v['description']
								: '',
				'type'  => 'info',
			);
			foreach ( $v as $css_prop => $css_value ) {
				if ( in_array( $css_prop, array( 'title', 'description' ) ) ) {
					continue;
				}
				// Skip property 'text-decoration' for the main text
				if ( 'text-decoration' == $css_prop && 'p' == $tag ) {
					continue;
				}

				$options    = '';
				$type       = 'text';
				$load_order = 1;
				$title      = ucfirst( str_replace( '-', ' ', $css_prop ) );
				if ( 'font-family' == $css_prop ) {
					$type       = 'select';
					$options    = array();
					$load_order = 2;        // Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} elseif ( 'font-weight' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'inestio' ),
						'100'     => esc_html__( '100 (Light)', 'inestio' ),
						'200'     => esc_html__( '200 (Light)', 'inestio' ),
						'300'     => esc_html__( '300 (Thin)', 'inestio' ),
						'400'     => esc_html__( '400 (Normal)', 'inestio' ),
						'500'     => esc_html__( '500 (Semibold)', 'inestio' ),
						'600'     => esc_html__( '600 (Semibold)', 'inestio' ),
						'700'     => esc_html__( '700 (Bold)', 'inestio' ),
						'800'     => esc_html__( '800 (Black)', 'inestio' ),
						'900'     => esc_html__( '900 (Black)', 'inestio' ),
					);
				} elseif ( 'font-style' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'inestio' ),
						'normal'  => esc_html__( 'Normal', 'inestio' ),
						'italic'  => esc_html__( 'Italic', 'inestio' ),
					);
				} elseif ( 'text-decoration' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'      => esc_html__( 'Inherit', 'inestio' ),
						'none'         => esc_html__( 'None', 'inestio' ),
						'underline'    => esc_html__( 'Underline', 'inestio' ),
						'overline'     => esc_html__( 'Overline', 'inestio' ),
						'line-through' => esc_html__( 'Line-through', 'inestio' ),
					);
				} elseif ( 'text-transform' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'    => esc_html__( 'Inherit', 'inestio' ),
						'none'       => esc_html__( 'None', 'inestio' ),
						'uppercase'  => esc_html__( 'Uppercase', 'inestio' ),
						'lowercase'  => esc_html__( 'Lowercase', 'inestio' ),
						'capitalize' => esc_html__( 'Capitalize', 'inestio' ),
					);
				}
				$fonts[ "{$tag}_{$css_prop}" ] = array(
					'title'      => $title,
					'desc'       => '',
					'refresh'    => false,
					'load_order' => $load_order,
					'std'        => '$inestio_get_theme_fonts_option',
					'options'    => $options,
					'type'       => $type,
				);
			}

			$fonts[ "{$tag}_section_end" ] = array(
				'type' => 'section_end',
			);
		}

		$fonts['fonts_end'] = array(
			'type' => 'panel_end',
		);

		// Add fonts parameters to Theme Options
		inestio_storage_set_array_before( 'options', 'panel_colors', $fonts );

		// Add Header Video if WP version < 4.7
		// -----------------------------------------------------
		if ( ! function_exists( 'get_header_video_url' ) ) {
			inestio_storage_set_array_after(
				'options', 'header_image_override', 'header_video', array(
					'title'    => esc_html__( 'Header video', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select video to use it as background for the header', 'inestio' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'inestio' ),
					),
					'std'      => '',
					'type'     => 'video',
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is not 'Customize'
		// ------------------------------------------------------
		if ( ! function_exists( 'the_custom_logo' ) || ! inestio_check_url( 'customize.php' ) ) {
			inestio_storage_set_array_before(
				'options', 'logo_retina', function_exists( 'the_custom_logo' ) ? 'custom_logo' : 'logo', array(
					'title'    => esc_html__( 'Logo', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select or upload the site logo', 'inestio' ) ),
					'priority' => 60,
					'std'      => '',
					'qsetup'   => esc_html__( 'General', 'inestio' ),
					'type'     => 'image',
				)
			);
		}

	}
}


// Returns a list of options that can be overridden for categories, tags, archives, author posts, search, etc.
if ( ! function_exists( 'inestio_options_get_list_blog_options' ) ) {
	function inestio_options_get_list_blog_options( $mode, $title = '' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $mode );
		}
		return array(
				"blog_general_{$mode}"           => array(
					'title' => $title,
					// Translators: Add mode name to the description
					'desc'  => wp_kses_data( sprintf( __( "Style and components of the %s posts page", 'inestio' ), $title ) ),
					'type'  => 'section',
				),
				"blog_general_info_{$mode}"      => array(
					// Translators: Add mode name to the title
					'title'  => wp_kses_data( sprintf( __( "%s posts page", 'inestio' ), $title ) ),
					// Translators: Add mode name to the description
					'desc'   => wp_kses_data( sprintf( __( 'Customize the %s posts page: the posts layout, the style of the header and footer, the sidebar position and the set of widgets, etc.', 'inestio' ), $title ) ),
					'type'   => 'info',
				),
				"blog_style_{$mode}"             => array(
					'title'      => esc_html__( 'Blog style', 'inestio' ),
					'desc'       => '',
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'choice',
				),
				"first_post_large_{$mode}"       => array(
					'title'      => esc_html__( 'First post large', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Make your first post stand out by making it bigger', 'inestio' ) ),
					'std'        => 0,
					'options'    => inestio_get_list_yesno( true ),
					'type'       => 'radio',
				),
				"blog_content_{$mode}"           => array(
					'title'      => esc_html__( 'Posts content', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Display either post excerpts or the full post content', 'inestio' ) ),
					'std'        => 'excerpt',
					'dependency' => array(
						"blog_style_{$mode}" => array( 'excerpt' ),
					),
					'options'    => inestio_get_list_blog_contents( true ),
					'type'       => 'radio',
				),
				"excerpt_length_{$mode}"         => array(
					'title'      => esc_html__( 'Excerpt length', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged', 'inestio' ) ),
					'dependency' => array(
						"blog_style_{$mode}"   => array( 'excerpt' ),
						"blog_content_{$mode}" => array( 'excerpt' ),
					),
					'std'        => 55,
					'type'       => 'text',
				),
				"meta_parts_{$mode}"             => array(
					'title'      => esc_html__( 'Post meta', 'inestio' ),
					'desc'       => wp_kses_data( __( "Set up post meta parts to show in the blog archive. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'inestio' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'inestio' ) ),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=1|date=1|views=1|likes=1|comments=1|author=0|share=0|edit=1',
					'options'    => inestio_get_list_meta_parts(),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'checklist',
				),
				"blog_pagination_{$mode}"        => array(
					'title'      => esc_html__( 'Pagination style', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Show Older/Newest posts or Page numbers below the posts list', 'inestio' ) ),
					'std'        => 'pages',
					'options'    => inestio_get_list_blog_paginations( true ),
					'type'       => 'choice',
				),
				"blog_animation_{$mode}"         => array(
					'title'      => esc_html__( 'Post animation', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select animation to show posts on the {$title} posts page. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour!', 'inestio' ) ),
					'std'        => 'none',
					'options'    => array(),
					'type'       => INESTIO_THEME_FREE ? 'hidden' : 'select',
				),
				"open_full_post_in_blog_{$mode}" => array(
					'title'      => esc_html__( 'Open full post in blog', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Allow to open the full version of the post directly in the posts feed. Attention! Applies only to 1 column layouts!', 'inestio' ) ),
					'std'        => 0,
					'options'    => inestio_get_list_blog_contents( true ),
					'type'       => 'radio',
				),

				"blog_header_info_{$mode}"       => array(
					'title' => esc_html__( 'Header', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				"header_type_{$mode}"            => array(
					'title'    => esc_html__( 'Header style', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
					'std'      => 'inherit',
					'options'  => inestio_get_list_header_footer_types( true ),
					'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'radio',
				),
				"header_style_{$mode}"           => array(
					'title'      => esc_html__( 'Select custom layout', 'inestio' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'inestio' ), 'inestio_kses_content' ),
					'dependency' => array(
						"header_type_{$mode}" => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				"header_position_{$mode}"        => array(
					'title'    => esc_html__( 'Header position', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'inestio' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'radio',
				),
				"header_fullheight_{$mode}"      => array(
					'title'    => esc_html__( 'Header fullheight', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'inestio' ) ),
					'std'      => 'inherit',
					'options'  => inestio_get_list_checkbox_values( true ),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'radio',
				),
				"header_wide_{$mode}"            => array(
					'title'      => esc_html__( 'Header fullwidth', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'inestio' ) ),
					'dependency' => array(
						"header_type_{$mode}" => array( 'default' ),
					),
					'std'      => 'inherit',
					'options'  => inestio_get_list_checkbox_values( true ),
					'type'     => INESTIO_THEME_FREE ? 'hidden' : 'hidden',
				),

				"blog_sidebar_info_{$mode}"      => array(
					'title' => esc_html__( 'Sidebar', 'inestio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				"sidebar_position_{$mode}"       => array(
					'title'   => esc_html__( 'Sidebar position', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar', 'inestio' ) ),
					'std'     => 'inherit',
					'options' => array(),
					'type'    => 'choice',
				),
				"sidebar_type_{$mode}"           => array(
					'title'    => esc_html__( 'Sidebar style', 'inestio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
					'dependency' => array(
						"sidebar_position_{$mode}" => array( '^hide' ),
					),
					'std'      => 'default',
					'options'  => inestio_get_list_header_footer_types(),
					'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'radio',
				),
				"sidebar_style_{$mode}"          => array(
					'title'      => esc_html__( 'Select custom layout', 'inestio' ),
					'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'inestio' ), 'inestio_kses_content' ),
					'dependency' => array(
						"sidebar_position_{$mode}" => array( '^hide' ),
						"sidebar_type_{$mode}"     => array( 'custom' ),
					),
					'std'        => 'sidebar-custom-sidebar',
					'options'    => array(),
					'type'       => 'select',
				),
				"sidebar_widgets_{$mode}"        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'inestio' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'inestio' ) ),
					'dependency' => array(
						"sidebar_position_{$mode}" => array( '^hide' ),
						"sidebar_type_{$mode}"     => array( 'default' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				"expand_content_{$mode}"         => array(
					'title'   => esc_html__( 'Content width', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Content width if the sidebar is hidden', 'inestio' ) ),
					'refresh' => false,
					'std'     => 'inherit',
					'options' => inestio_get_list_expand_content( true ),
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'choice',
				),

				"blog_widgets_info_{$mode}"      => array(
					'title' => esc_html__( 'Additional widgets', 'inestio' ),
					'desc'  => '',
					'type'  => INESTIO_THEME_FREE ? 'hidden' : 'info',
					'type'    => 'hidden',
				),
				"widgets_above_page_{$mode}"     => array(
					'title'   => esc_html__( 'Widgets at the top of the page', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'inestio' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'select',
					'type'    => 'hidden',
				),
				"widgets_above_content_{$mode}"  => array(
					'title'   => esc_html__( 'Widgets above the content', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'inestio' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'select',
					'type'    => 'hidden',
				),
				"widgets_below_content_{$mode}"  => array(
					'title'   => esc_html__( 'Widgets below the content', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'inestio' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'select',
					'type'    => 'hidden',
				),
				"widgets_below_page_{$mode}"     => array(
					'title'   => esc_html__( 'Widgets at the bottom of the page', 'inestio' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'inestio' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => INESTIO_THEME_FREE ? 'hidden' : 'select',
					'type'    => 'hidden',
				),
		);
	}
}


// Returns a list of options that can be overridden for CPT
if ( ! function_exists( 'inestio_options_get_list_cpt_options' ) ) {
	function inestio_options_get_list_cpt_options( $cpt, $title = '' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $cpt );
		}
		return array(
			"content_info_{$cpt}"           => array(
				'title' => esc_html__( 'Content', 'inestio' ),
				// Translators: Add CPT name to the description
				'desc'  => wp_kses_data( sprintf( __( 'Customize the %s: post layout, header and footer style, sidebar position, etc.', 'inestio' ), $title ) ),
				'type'  => 'info',
			),
			"body_style_{$cpt}"             => array(
				'title'    => esc_html__( 'Body style', 'inestio' ),
				'desc'     => wp_kses_data( __( 'Select width of the body content', 'inestio' ) ),
				'std'      => 'inherit',
				'options'  => inestio_get_list_body_styles( true ),
				'type'     => 'choice',
			),
			"boxed_bg_image_{$cpt}"         => array(
				'title'      => esc_html__( 'Boxed bg image', 'inestio' ),
				'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'inestio' ) ),
				'dependency' => array(
					"body_style_{$cpt}" => array( 'boxed' ),
				),
				'std'        => 'inherit',
				'type'       => 'image',
			),
			"header_info_{$cpt}"            => array(
				'title' => esc_html__( 'Header', 'inestio' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"header_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Header style', 'inestio' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
				'std'     => 'inherit',
				'options' => inestio_get_list_header_footer_types( true ),
				'type'    => INESTIO_THEME_FREE ? 'hidden' : 'radio',
			),
			"header_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'inestio' ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select custom layout to display the site header on the %s pages', 'inestio' ), $title ) ),
				'dependency' => array(
					"header_type_{$cpt}" => array( 'custom' ),
				),
				'std'        => 'inherit',
				'options'    => array(),
				'type'       => INESTIO_THEME_FREE ? 'hidden' : 'select',
			),
			"header_position_{$cpt}"        => array(
				'title'   => esc_html__( 'Header position', 'inestio' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to display the site header on the %s pages', 'inestio' ), $title ) ),
				'std'     => 'inherit',
				'options' => array(),
				'type'    => INESTIO_THEME_FREE ? 'hidden' : 'radio',
			),
			"header_image_override_{$cpt}"  => array(
				'title'   => esc_html__( 'Header image override', 'inestio' ),
				'desc'    => wp_kses_data( __( "Allow override the header image with the post's featured image", 'inestio' ) ),
				'std'     => 'inherit',
				'options' => inestio_get_list_yesno( true ),
				'type'    => INESTIO_THEME_FREE ? 'hidden' : 'radio',
			), 
			"header_widgets_{$cpt}"         => array(
				'title'   => esc_html__( 'Header widgets', 'inestio' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select set of widgets to show in the header on the %s pages', 'inestio' ), $title ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => 'hidden',
			),

			"sidebar_info_{$cpt}"           => array(
				'title' => esc_html__( 'Sidebar', 'inestio' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"sidebar_position_{$cpt}"       => array(
				// Translators: Add CPT name to the title
				'title'   => sprintf( __( 'Sidebar position on the %s list', 'inestio' ), $title ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to show sidebar on the %s list', 'inestio' ), $title ) ),
				'std'     => 'right',
				'options' => array(),
				'type'    => 'choice',
			),
			"sidebar_position_ss_{$cpt}"    => array(
				// Translators: Add CPT name to the title
				'title'    => sprintf( __( 'Sidebar position on the %s list on the small screen', 'inestio' ), $title ),
				'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'inestio' ) ),
				'std'      => 'below',
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
				),
				'options'  => array(),
				'type'     => 'radio',
			),
			"sidebar_type_{$cpt}"           => array(
				// Translators: Add CPT name to the title
				'title'    => sprintf( __( 'Sidebar style on the %s list', 'inestio' ), $title ),
				'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
				),
				'std'      => 'default',
				'options'  => inestio_get_list_header_footer_types(),
				'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'radio',
			),
			"sidebar_style_{$cpt}"          => array(
				'title'      => esc_html__( 'Select custom layout', 'inestio' ),
				'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'inestio' ), 'inestio_kses_content' ),
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
					"sidebar_type_{$cpt}"     => array( 'custom' ),
				),
				'std'        => 'sidebar-custom-sidebar',
				'options'    => array(),
				'type'       => 'select',
			),
			"sidebar_widgets_{$cpt}"        => array(
				// Translators: Add CPT name to the title
				'title'      => sprintf( __( 'Sidebar widgets on the %s list', 'inestio' ), $title ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select sidebar to show on the %s list', 'inestio' ), $title ) ),
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
					"sidebar_type_{$cpt}"     => array( 'default' ),
				),
				'std'        => 'custom_widgets_2',
				'options'    => array(),
				'type'       => 'select',
			),
			"sidebar_position_single_{$cpt}"       => array(
				'title'   => esc_html__( 'Sidebar position on the single post', 'inestio' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to show sidebar on the single posts of the %s', 'inestio' ), $title ) ),
				'std'     => 'left',
				'options' => array(),
				'type'    => 'choice',
			),
			"sidebar_position_ss_single_{$cpt}"    => array(
				'title'    => esc_html__( 'Sidebar position on the single post on the small screen', 'inestio' ),
				'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'inestio' ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
				),
				'std'      => 'below',
				'options'  => array(),
				'type'     => 'radio',
			),
			"sidebar_type_single_{$cpt}"           => array(
				// Translators: Add CPT name to the title
				'title'    => esc_html__( 'Sidebar style on the single post', 'inestio' ),
				'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
				),
				'std'      => 'default',
				'options'  => inestio_get_list_header_footer_types(),
				'type'     => INESTIO_THEME_FREE || ! inestio_exists_trx_addons() ? 'hidden' : 'radio',
			),
			"sidebar_style_single_{$cpt}"          => array(
				'title'      => esc_html__( 'Select custom layout', 'inestio' ),
				'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'inestio' ), 'inestio_kses_content' ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
					"sidebar_type_single_{$cpt}"     => array( 'custom' ),
				),
				'std'        => 'sidebar-custom-sidebar',
				'options'    => array(),
				'type'       => 'select',
			),
			"sidebar_widgets_single_{$cpt}"        => array(
				'title'      => esc_html__( 'Sidebar widgets on the single post', 'inestio' ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select widgets to show in the sidebar on the single posts of the %s', 'inestio' ), $title ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
					"sidebar_type_single_{$cpt}"     => array( 'default' ),
				),
				'std'        => 'hide',
				'options'    => array(),
				'type'       => 'select',
			),
			"expand_content_{$cpt}"         => array(
				'title'   => esc_html__( 'Content width', 'inestio' ),
				'desc'    => wp_kses_data( __( 'Content width if the sidebar is hidden or leave it narrow', 'inestio' ) ),
				'refresh' => false,
				'std'     => 'inherit',
				'options' => inestio_get_list_expand_content( true ),
				'type'    => INESTIO_THEME_FREE ? 'hidden' : 'choice',
			),
			"expand_content_single_{$cpt}"         => array(
				'title'   => esc_html__( 'Content width on the single post', 'inestio' ),
				'desc'    => wp_kses_data( __( 'Content width on the single post if the sidebar is hidden', 'inestio' ) ),
				'refresh' => false,
				'std'     => 'expand',
				'options' => inestio_get_list_expand_content( true ),
				'type'    => INESTIO_THEME_FREE ? 'hidden' : 'choice',
			),

			"footer_info_{$cpt}"            => array(
				'title' => esc_html__( 'Footer', 'inestio' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"footer_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Footer style', 'inestio' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'inestio' ) ),
				'std'     => 'inherit',
				'options' => inestio_get_list_header_footer_types( true ),
				'type'    => INESTIO_THEME_FREE ? 'hidden' : 'radio',
			),
			"footer_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'inestio' ),
				'desc'       => wp_kses_data( __( 'Select custom layout to display the site footer', 'inestio' ) ),
				'std'        => 'inherit',
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'custom' ),
				),
				'options'    => array(),
				'type'       => INESTIO_THEME_FREE ? 'hidden' : 'select',
			),
			"footer_widgets_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer widgets', 'inestio' ),
				'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'inestio' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 'footer_widgets',
				'options'    => array(),
				'type'       => 'select',
			),
			"footer_columns_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer columns', 'inestio' ),
				'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'inestio' ) ),
				'dependency' => array(
					"footer_type_{$cpt}"    => array( 'default' ),
					"footer_widgets_{$cpt}" => array( '^hide' ),
				),
				'std'        => 0,
				'options'    => inestio_get_list_range( 0, 6 ),
				'type'       => 'select',
			),
			"footer_wide_{$cpt}"            => array(
				'title'      => esc_html__( 'Footer fullwidth', 'inestio' ),
				'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'inestio' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 0,
				'type'       => 'switch',
			),

			"widgets_info_{$cpt}"           => array(
				'title' => esc_html__( 'Additional panels', 'inestio' ),
				'desc'  => '',
				'type'  => INESTIO_THEME_FREE ? 'hidden' : 'hidden',
			),
			"widgets_above_page_{$cpt}"     => array(
				'title'   => esc_html__( 'Widgets at the top of the page', 'inestio' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'inestio' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => INESTIO_THEME_FREE ? 'hidden' : 'select',
				'type'    => 'hidden',
			),
			"widgets_above_content_{$cpt}"  => array(
				'title'   => esc_html__( 'Widgets above the content', 'inestio' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'inestio' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => INESTIO_THEME_FREE ? 'hidden' : 'select',
			),
			"widgets_below_content_{$cpt}"  => array(
				'title'   => esc_html__( 'Widgets below the content', 'inestio' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'inestio' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => INESTIO_THEME_FREE ? 'hidden' : 'select',
			),
			"widgets_below_page_{$cpt}"     => array(
				'title'   => esc_html__( 'Widgets at the bottom of the page', 'inestio' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'inestio' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => INESTIO_THEME_FREE ? 'hidden' : 'select',
			),
		);
	}
}


// Return lists with choises when its need in the admin mode
if ( ! function_exists( 'inestio_options_get_list_choises' ) ) {
	add_filter( 'inestio_filter_options_get_list_choises', 'inestio_options_get_list_choises', 10, 2 );
	function inestio_options_get_list_choises( $list, $id ) {
		if ( is_array( $list ) && count( $list ) == 0 ) {
			if ( strpos( $id, 'header_style' ) === 0 ) {
				$list = inestio_get_list_header_styles( strpos( $id, 'header_style_' ) === 0 );
			} elseif ( strpos( $id, 'header_position' ) === 0 ) {
				$list = inestio_get_list_header_positions( strpos( $id, 'header_position_' ) === 0 );
			} elseif ( strpos( $id, 'header_widgets' ) === 0 ) {
				$list = inestio_get_list_sidebars( strpos( $id, 'header_widgets_' ) === 0, true );
			} elseif ( strpos( $id, '_scheme' ) > 0 ) {
				$list = inestio_get_list_schemes( 'color_scheme' != $id );
			} else if ( strpos( $id, 'sidebar_style' ) === 0 ) {
				$list = inestio_get_list_sidebar_styles( strpos( $id, 'sidebar_style_' ) === 0 );
			} elseif ( strpos( $id, 'sidebar_widgets' ) === 0 ) {
				$list = inestio_get_list_sidebars( 'sidebar_widgets_single' != $id && ( strpos( $id, 'sidebar_widgets_' ) === 0 || strpos( $id, 'sidebar_widgets_single_' ) === 0 ), true );
			} elseif ( strpos( $id, 'sidebar_position_ss' ) === 0 ) {
				$list = inestio_get_list_sidebars_positions_ss( strpos( $id, 'sidebar_position_ss_' ) === 0 );
			} elseif ( strpos( $id, 'sidebar_position' ) === 0 ) {
				$list = inestio_get_list_sidebars_positions( strpos( $id, 'sidebar_position_' ) === 0 );
			} elseif ( strpos( $id, 'widgets_above_page' ) === 0 ) {
				$list = inestio_get_list_sidebars( strpos( $id, 'widgets_above_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_above_content' ) === 0 ) {
				$list = inestio_get_list_sidebars( strpos( $id, 'widgets_above_content_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_page' ) === 0 ) {
				$list = inestio_get_list_sidebars( strpos( $id, 'widgets_below_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_content' ) === 0 ) {
				$list = inestio_get_list_sidebars( strpos( $id, 'widgets_below_content_' ) === 0, true );
			} elseif ( strpos( $id, 'footer_style' ) === 0 ) {
				$list = inestio_get_list_footer_styles( strpos( $id, 'footer_style_' ) === 0 );
			} elseif ( strpos( $id, 'footer_widgets' ) === 0 ) {
				$list = inestio_get_list_sidebars( strpos( $id, 'footer_widgets_' ) === 0, true );
			} elseif ( strpos( $id, 'blog_style' ) === 0 ) {
				$list = inestio_get_list_blog_styles( strpos( $id, 'blog_style_' ) === 0 );
			} elseif ( strpos( $id, 'single_style' ) === 0 ) {
				$list = inestio_get_list_single_styles( strpos( $id, 'single_style_' ) === 0 );
			} elseif ( strpos( $id, 'post_type' ) === 0 ) {
				$list = inestio_get_list_posts_types();
			} elseif ( strpos( $id, 'parent_cat' ) === 0 ) {
				$list = inestio_array_merge( array( 0 => esc_html__( '- Select category -', 'inestio' ) ), inestio_get_list_categories() );
			} elseif ( strpos( $id, 'blog_animation' ) === 0 ) {
				$list = inestio_get_list_animations_in( strpos( $id, 'blog_animation_' ) === 0 );
			} elseif ( 'color_scheme_editor' == $id ) {
				$list = inestio_get_list_schemes();
			} elseif ( strpos( $id, '_font-family' ) > 0 ) {
				$list = inestio_get_list_load_fonts( true );
			}
		}
		return $list;
	}
}
