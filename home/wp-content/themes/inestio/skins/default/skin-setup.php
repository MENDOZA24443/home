<?php
/**
 * Skin Setup
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


//--------------------------------------------
// SKIN FONTS
//--------------------------------------------
if ( ! function_exists( 'inestio_skin_setup_fonts' ) ) {
	add_action( 'after_setup_theme', 'inestio_skin_setup_fonts', 1 );
	function inestio_skin_setup_fonts() {
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder css/font-face/font-name inside the skin folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		inestio_storage_set(
			'load_fonts', array(
				// Google font
				array(
					'name'   => 'Roboto',
					'family' => 'sans-serif',
					'styles' => '300,300italic,400,400italic,700,700italic',     // Parameter 'style' used only for the Google fonts
				),
				array(
					'name'   => 'Lustria',
					'family' => 'sans-serif',
					'styles' => '400',     // Parameter 'style' used only for the Google fonts
				),
				array(
					'name'   => 'Poppins',
					'family' => 'sans-serif',
					'styles' => '300,300italic,400,400italic,500,600,700,700italic',     // Parameter 'style' used only for the Google fonts
				),
				// Font-face packed with theme
				array(
					'name'   => 'Montserrat',
					'family' => 'sans-serif',
				),
				// Google font
				array(
					'name'   => 'PT Serif',
					'family' => 'sans-serif',
					'styles' => '400,400italic,700,700italic',     // Parameter 'style' used only for the Google fonts
				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		inestio_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags
		// Attention! Font name in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
		// example:
		// Correct:   'font-family' => '"Roboto",sans-serif'
		// Incorrect: 'font-family' => '"Roboto", sans-serif'
		// Incorrect: 'font-family' => 'Roboto,sans-serif'

		$font_description = esc_html__( 'Font settings of the %s of the site. To correctly display the site on mobile devices, use only the following units: "rem", "em" or "ex"', 'inestio' );

		inestio_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'inestio' ),
					'description'     => sprintf( $font_description, esc_html__( 'main text', 'inestio' ) ),
					'font-family'     => '"Lustria",sans-serif',
					'font-size'       => '1.21rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.64em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.95em',
				),
				'post'    => array(
					'title'           => esc_html__( 'Article text', 'inestio' ),
					'description'     => sprintf( $font_description, esc_html__( 'article text', 'inestio' ) ),
					'font-family'     => '',			// Example: '"PR Serif",serif',
					'font-size'       => '',			// Example: '1.286rem',
					'font-weight'     => '',			// Example: '400',
					'font-style'      => '',			// Example: 'normal',
					'line-height'     => '',			// Example: '1.75em',
					'text-decoration' => '',			// Example: 'none',
					'text-transform'  => '',			// Example: 'none',
					'letter-spacing'  => '',			// Example: '',
					'margin-top'      => '',			// Example: '0em',
					'margin-bottom'   => '',			// Example: '1.4em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'inestio' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H1', 'inestio' ) ),
					'font-family'     => '"Poppins",sans-serif',
					'font-size'       => '3.42rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '0.98em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.007em',
					'margin-top'      => '1.8117em',
					'margin-bottom'   => '0.7833em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'inestio' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H2', 'inestio' ) ),
					'font-family'     => '"Poppins",sans-serif',
					'font-size'       => '2.85rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.07em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.018em',
					'margin-top'      => '1.5852em',
					'margin-bottom'   => '0.6819em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'inestio' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H3', 'inestio' ) ),
					'font-family'     => '"Poppins",sans-serif',
					'font-size'       => '1.82em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.21em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.018em',
					'margin-top'      => '1.81em',
					'margin-bottom'   => '0.64em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'inestio' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H4', 'inestio' ) ),
					'font-family'     => '"Poppins",sans-serif',
					'font-size'       => '1.47em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.3em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.018em',
					'margin-top'      => '2.063em',
					'margin-bottom'   => '0.7em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'inestio' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H5', 'inestio' ) ),
					'font-family'     => '"Poppins",sans-serif',
					'font-size'       => '1.17em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.4em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '2.3em',
					'margin-bottom'   => '1.4em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'inestio' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H6', 'inestio' ) ),
					'font-family'     => '"Poppins",sans-serif',
					'font-size'       => '1.21rem',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.4706em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.4706em',
					'margin-bottom'   => '0.4412em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'inestio' ),
					'description'     => sprintf( $font_description, esc_html__( 'text of the logo', 'inestio' ) ),
					'font-family'     => '"Montserrat",sans-serif',
					'font-size'       => '1.8em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '1px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'inestio' ),
					'description'     => sprintf( $font_description, esc_html__( 'buttons', 'inestio' ) ),
					'font-family'     => '"Poppins",sans-serif',
					'font-size'       => '13px',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '22px',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'inestio' ),
					'description'     => sprintf( $font_description, esc_html__( 'input fields, dropdowns and textareas', 'inestio' ) ),
					'font-family'     => '"Lustria",sans-serif',
					'font-size'       => '1.07rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',     // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'inestio' ),
					'description'     => sprintf( $font_description, esc_html__( 'post meta (author, categories, publish date, counters, share, etc.)', 'inestio' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '12px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'inestio' ),
					'description'     => sprintf( $font_description, esc_html__( 'main menu items', 'inestio' ) ),
					'font-family'     => '"Montserrat",sans-serif',
					'font-size'       => '1.14rem',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'inestio' ),
					'description'     => sprintf( $font_description, esc_html__( 'dropdown menu items', 'inestio' ) ),
					'font-family'     => '"Montserrat",sans-serif',
					'font-size'       => '0.8667em',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
			)
		);
	}
}


//--------------------------------------------
// COLOR SCHEMES
//--------------------------------------------
if ( ! function_exists( 'inestio_skin_setup_schemes' ) ) {
	add_action( 'after_setup_theme', 'inestio_skin_setup_schemes', 1 );
	function inestio_skin_setup_schemes() {

		// Theme colors for customizer
		// Attention! Inner scheme must be last in the array below
		inestio_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'inestio' ),
					'description' => esc_html__( 'Colors of the main content area', 'inestio' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'inestio' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'inestio' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'inestio' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'inestio' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'inestio' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'inestio' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'inestio' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'inestio' ),
				),
			)
		);

		inestio_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'inestio' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'inestio' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'inestio' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'inestio' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'inestio' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'inestio' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'inestio' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'inestio' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'inestio' ),
					'description' => esc_html__( 'Color of the text inside this block', 'inestio' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'inestio' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'inestio' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'inestio' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'inestio' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'inestio' ),
					'description' => esc_html__( 'Color of the links inside this block', 'inestio' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'inestio' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'inestio' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Link 2', 'inestio' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'inestio' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Link 2 hover', 'inestio' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'inestio' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Link 3', 'inestio' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'inestio' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Link 3 hover', 'inestio' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'inestio' ),
				),
			)
		);

		// Default values for each color scheme
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'inestio' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff',
					'bd_color'         => '#ebebeb',

					// Text and links colors
					'text'             => '#646464',
					'text_light'       => '#888888',
					'text_dark'        => '#2b2b2d',
					'text_link'        => '#0063d9',
					'text_hover'       => '#0454b6',
					'text_link2'       => '#a98a6b',
					'text_hover2'      => '#917150',
					'text_link3'       => '#0f1012',
					'text_hover3'      => '#1b1d1f',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#f7f7f7',
					'alter_bg_hover'   => '#ededed',
					'alter_bd_color'   => '#e3e3e3',
					'alter_bd_hover'   => '#e3e3e3',
					'alter_text'       => '#646464',
					'alter_light'      => '#888888',
					'alter_dark'       => '#2b2b2d',
					'alter_link'       => '#0063d9',
					'alter_hover'      => '#0454b6',
					'alter_link2'      => '#a98a6b',
					'alter_hover2'     => '#917150',
					'alter_link3'      => '#0f1012',
					'alter_hover3'     => '#1b1d1f',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0063d9',
					'extra_bg_hover'   => '#0063d9',
					'extra_bd_color'   => '#e3e3e3',
					'extra_bd_hover'   => '#e3e3e3',
					'extra_text'       => '#b2b8c0',
					'extra_light'      => '#888888',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#ffffff',
					'extra_hover'      => '#0454b6',
					'extra_link2'      => '#a98a6b',
					'extra_hover2'     => '#917150',
					'extra_link3'      => '#0f1012',
					'extra_hover3'     => '#1b1d1f',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#ffffff',
					'input_bg_hover'   => '#ffffff',
					'input_bd_color'   => '#ebebeb',
					'input_bd_hover'   => '#d0d0d0',
					'input_text'       => '#646464',
					'input_light'      => '#a7a7a7',
					'input_dark'       => '#2b2b2d',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#1b1d1f',
					'inverse_bd_hover' => '#2B2B2D',
					
					'inverse_text'     => '#ffffff',
					'inverse_bg_color' => '#1b1d1f',
					'inverse_light'    => '#b2b8c0',
					'inverse_dark'     => '#ffffff',
					'inverse_link'     => '#ffffff',
					'inverse_hover'    => '#0454b6',
					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//--->'new_color1'         => '#rrggbb',
					//--->'alter_new_color1'   => '#rrggbb',
				    //--->	'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'inestio' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#1b1d1f',
					'bd_color'         => '#26282c',

					// Text and links colors
					'text'             => '#b2b8c0',
					'text_light'       => '#888888',
					'text_dark'        => '#ffffff',
					'text_link'        => '#ffffff',
					'text_hover'       => '#0454b6',
					'text_link2'       => '#ffffff',
					'text_hover2'      => '#917150',
					'text_link3'       => '#0f1012',
					'text_hover3'      => '#1b1d1f',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#17191b',
					'alter_bg_hover'   => '#1d1f21',
					'alter_bd_color'   => '#2d3034',
					'alter_bd_hover'   => '#2d3034',
					'alter_text'       => '#b2b8c0',
					'alter_light'      => '#d4dff5',
					'alter_dark'       => '#ffffff',
					'alter_link'       => '#ffffff',
					'alter_hover'      => '#0454b6',
					'alter_link2'      => '#a98a6b',
					'alter_hover2'     => '#917150',
					'alter_link3'      => '#0f1012',
					'alter_hover3'     => '#1b1d1f',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0063d9',
					'extra_bg_hover'   => '#0063d9',
					'extra_bd_color'   => '#e3e3e3',
					'extra_bd_hover'   => '#e3e3e3',
					'extra_text'       => '#b2b8c0',
					'extra_light'      => '#888888',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#ffffff',
					'extra_hover'      => '#0454b6',
					'extra_link2'      => '#a98a6b',
					'extra_hover2'     => '#917150',
					'extra_link3'      => '#0f1012',
					'extra_hover3'     => '#1b1d1f',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#1b1d1f',
					'input_bg_hover'   => '#1b1d1f',
					'input_bd_color'   => '#2b2d32',
					'input_bd_hover'   => '#414549',
					'input_text'       => '#b2b8c0',
					'input_light'      => '#a7a7a7',
					'input_dark'       => '#ffffff',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e3e3e3',
					'inverse_bd_hover' => '#2B2B2D',
					'inverse_text'     => '#646464',
					'inverse_bg_color'     => '#ffffff',
					'inverse_light'    => '#646464',
					'inverse_dark'     => '#2b2b2d',
					'inverse_link'     => '#0063d9',
					'inverse_hover'    => '#0454b6',
					'inverse_link2'     => '#b2b8c0',
					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//--->	'new_color1'         => '#rrggbb',
					//--->'alter_new_color1'   => '#rrggbb',
					//--->'inverse_new_color1' => '#rrggbb',
				),
			),
			// Color scheme: 'dark'
			'blue'    => array(
				'title'    => esc_html__( 'Blue', 'inestio' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#1b1d1f',
					'bd_color'         => '#ebebeb',

					// Text and links colors
					'text'             => '#b2b8c0',
					'text_light'       => '#888888',
					'text_dark'        => '#ffffff',
					'text_link'        => '#ffffff',
					'text_hover'       => '#0454b6',
					'text_link2'       => '#ffffff',
					'text_hover2'      => '#917150',
					'text_link3'       => '#0f1012',
					'text_hover3'      => '#1b1d1f',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#0063d9',
					'alter_bg_hover'   => '#1d1f21',
					'alter_bd_color'   => '#0063d9',
					'alter_bd_hover'   => '#2d3034',
					'alter_text'       => '#b2b8c0',
					'alter_light'      => '#888888',
					'alter_dark'       => '#ffffff',
					'alter_link'       => '#ffffff',
					'alter_hover'      => '#0454b6',
					'alter_link2'      => '#a98a6b',
					'alter_hover2'     => '#917150',
					'alter_link3'      => '#0f1012',
					'alter_hover3'     => '#1b1d1f',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0063d9',
					'extra_bg_hover'   => '#0063d9',
					'extra_bd_color'   => '#e3e3e3',
					'extra_bd_hover'   => '#e3e3e3',
					'extra_text'       => '#b2b8c0',
					'extra_light'      => '#888888',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#ffffff',
					'extra_hover'      => '#0454b6',
					'extra_link2'      => '#a98a6b',
					'extra_hover2'     => '#917150',
					'extra_link3'      => '#0f1012',
					'extra_hover3'     => '#1b1d1f',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#1b1d1f',
					'input_bg_hover'   => '#1b1d1f',
					'input_bd_color'   => '#2b2d32',
					'input_bd_hover'   => '#414549',
					'input_text'       => '#b2b8c0',
					'input_light'      => '#a7a7a7',
					'input_dark'       => '#ffffff',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e3e3e3',
					'inverse_bd_hover' => '#2B2B2D',
					'inverse_text'     => '#646464',
					'inverse_bg_color'     => '#ffffff',
					'inverse_light'    => '#646464',
					'inverse_dark'     => '#2b2b2d',
					'inverse_link'     => '#0063d9',
					'inverse_hover'    => '#0454b6',
					'inverse_link2'     => '#b2b8c0',
					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//--->	'new_color1'         => '#rrggbb',
					//--->'alter_new_color1'   => '#rrggbb',
					//--->'inverse_new_color1' => '#rrggbb',
				),
			),
		);
		inestio_storage_set( 'schemes', $schemes );
		inestio_storage_set( 'schemes_original', $schemes );

		// Add names of additional colors
		//---> For example:
		//---> inestio_storage_set_array( 'scheme_color_names', 'new_color1', array(
		//---> 	'title'       => __( 'New color 1', 'inestio' ),
		//---> 	'description' => __( 'Description of the new color 1', 'inestio' ),
		//---> ) );


		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		inestio_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bd_color_05'        => array(
					'color' => 'bd_color',
					'alpha' => 0.5,
				),
				
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_hover_00' => array(
					'color' => 'alter_bg_hover',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_dark_07' => array(
					'color' => 'extra_dark',
					'alpha' => 0.7,
				),
			 	'extra_dark_08' => array(
					'color' => 'extra_dark',
					'alpha' => 0.8,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'alter_dark_07' => array(
					'color' => 'alter_dark',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
				'text_dark_05'      => array(
					'color' => 'text_dark',
					'alpha' => 0.5,
				),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'inverse_bg_color_05'      => array(
					'color' => 'inverse_bg_color',
					'alpha' => 0.5,
				),
				'text_hover3_05'      => array(
					'color' => 'text_hover3',
					'alpha' => 0.6,
				),
				'inverse_bg_color_06'      => array(
					'color' => 'inverse_bg_color',
					'alpha' => 0.6,
				),
				'text_hover3_06'      => array(
					'color' => 'text_hover3',
					'alpha' => 0.6,
				),
				'inverse_bg_color_07'      => array(
					'color' => 'inverse_bg_color',
					'alpha' => 0.7,
				),
				'text_hover3_07'      => array(
					'color' => 'text_hover3',
					'alpha' => 0.7,
				),
				'inverse_bg_color_015'      => array(
					'color' => 'inverse_bg_color',
					'alpha' => 0.15,
				),
				'text_hover3_15'      => array(
					'color' => 'text_hover3',
					'alpha' => 0.15,
				),
				'inverse_bd_color_02'      => array(
					'color' => 'inverse_bd_color',
					'alpha' => 0.2,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		inestio_storage_set(
			'schemes_simple', array(
				'text_link'        => array(
					'alter_hover'      => 1,
					'extra_link'       => 1,
					'inverse_bd_color' => 0.85,
					'inverse_bd_hover' => 0.7,
				),
				'text_hover'       => array(
					'alter_link'  => 1,
					'extra_hover' => 1,
				),
				'text_link2'       => array(
					'alter_hover2' => 1,
					'extra_link2'  => 1,
				),
				'text_hover2'      => array(
					'alter_link2'  => 1,
					'extra_hover2' => 1,
				),
				'text_link3'       => array(
					'alter_hover3' => 1,
					'extra_link3'  => 1,
				),
				'text_hover3'      => array(
					'alter_link3'  => 1,
					'extra_hover3' => 1,
				),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
				'inverse_bd_color' => array(),
				'inverse_bd_hover' => array(),
			)
		);

		// Parameters to set order of schemes in the css
		inestio_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);
	}
}


//--------------------------------------------
// THUMBS
//--------------------------------------------
if ( ! function_exists( 'inestio_skin_setup_thumbs' ) ) {
	add_action( 'after_setup_theme', 'inestio_skin_setup_thumbs', 1 );
	function inestio_skin_setup_thumbs() {
		inestio_storage_set(
			'theme_thumbs', apply_filters(
				'inestio_filter_add_thumb_sizes', array(
					// Width of the image is equal to the content area width (without sidebar)
					// Height is fixed
					'inestio-thumb-huge'        => array(
						'size'  => array( 1170, 658, true ),
						'title' => esc_html__( 'Huge image', 'inestio' ),
						'subst' => 'trx_addons-thumb-huge',
					),
					// Width of the image is equal to the content area width (with sidebar)
					// Height is fixed
					'inestio-thumb-big'         => array(
						'size'  => array( 760, 428, true ),
						'title' => esc_html__( 'Large image', 'inestio' ),
						'subst' => 'trx_addons-thumb-big',
					),
					'inestio-thumb-related'         => array(
						'size'  => array( 740, 626, true ),
						'title' => esc_html__( 'Related image', 'inestio' ),
						'subst' => 'trx_addons-thumb-related',
					),
					// Width of the image is equal to the 1/3 of the content area width (without sidebar)
					// Height is fixed
					'inestio-thumb-med'         => array(
						'size'  => array( 370, 208, true ),
						'title' => esc_html__( 'Medium image', 'inestio' ),
						'subst' => 'trx_addons-thumb-medium',
					),

					// Small square image (for avatars in comments, etc.)
					'inestio-thumb-tiny'        => array(
						'size'  => array( 180, 180, true ),
						'title' => esc_html__( 'Small square avatar', 'inestio' ),
						'subst' => 'trx_addons-thumb-tiny',
					),
					// Small square image (for avatars in comments, etc.)
					'inestio-thumb-bavatar'        => array(
						'size'  => array( 390, 490, true ),
						'title' => esc_html__( 'bavatar', 'inestio' ),
						'subst' => 'trx_addons-thumb-bavatar',
					),
							// Small square image (for avatars in comments, etc.)
							'inestio-thumb-portfolio'        => array(
								'size'  => array( 960, 730, true ),
								'title' => esc_html__( 'portfolio', 'inestio' ),
								'subst' => 'trx_addons-thumb-portfolio',
							),
					// Width of the image is equal to the content area width (with sidebar)
					// Height is proportional (only downscale, not crop)
					'inestio-thumb-masonry-service' => array(
						'size'  => array( 574, 500, true ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry service', 'inestio' ),
						'subst' => 'trx_addons-thumb-masonry-service',
					),
					'inestio-thumb-masonry-big' => array(
						'size'  => array( 760, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry Large (scaled)', 'inestio' ),
						'subst' => 'trx_addons-thumb-masonry-big',
					),

					// Width of the image is equal to the 1/3 of the full content area width (without sidebar)
					// Height is proportional (only downscale, not crop)
					'inestio-thumb-masonry'     => array(
						'size'  => array( 370, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry (scaled)', 'inestio' ),
						'subst' => 'trx_addons-thumb-masonry',
					),
				)
			)
		);
	}
}


//--------------------------------------------
// BLOG STYLES
//--------------------------------------------
if ( ! function_exists( 'inestio_skin_setup_blog_styles' ) ) {
	add_action( 'after_setup_theme', 'inestio_skin_setup_blog_styles', 1 );
	function inestio_skin_setup_blog_styles() {

		$blog_styles = array(
			'excerpt' => array(
				'title'   => esc_html__( 'Standard', 'inestio' ),
				'archive' => 'index',
				'item'    => 'templates/content-excerpt',
				'styles'  => 'excerpt',
				'icon'    => "images/theme-options/blog-style/excerpt.png",
			),
			'band'    => array(
				'title'   => esc_html__( 'Band', 'inestio' ),
				'archive' => 'index',
				'item'    => 'templates/content-band',
				'styles'  => 'band',
				'icon'    => "images/theme-options/blog-style/band.png",
			),
			'classic' => array(
				'title'   => esc_html__( 'Classic', 'inestio' ),
				'archive' => 'index',
				'item'    => 'templates/content-classic',
				'columns' => array( 2, 3),
				'styles'  => 'classic',
				'icon'    => "images/theme-options/blog-style/classic-%d.png",
				'new_row' => true,
			),
		);
		if ( ! INESTIO_THEME_FREE ) {
			$blog_styles['classic-masonry']   = array(
				'title'   => esc_html__( 'Classic Masonry', 'inestio' ),
				'archive' => 'index',
				'item'    => 'templates/content-classic',
				'columns' => array( 2 ),
				'styles'  => array( 'classic', 'masonry' ),
				'scripts' => 'masonry',
				'icon'    => "images/theme-options/blog-style/classic-masonry-%d.png",
				'new_row' => true,
			);
			$blog_styles['portfolio'] = array(
				'title'   => esc_html__( 'Portfolio', 'inestio' ),
				'archive' => 'index',
				'item'    => 'templates/content-portfolio',
				'columns' => array( 2, 3),
				'styles'  => 'portfolio',
				'icon'    => "images/theme-options/blog-style/portfolio-%d.png",
				'new_row' => true,
			);
			$blog_styles['portfolio-masonry'] = array(
				'title'   => esc_html__( 'Portfolio Masonry', 'inestio' ),
				'archive' => 'index',
				'item'    => 'templates/content-portfolio',
				'columns' => array( 2, 3 ),
				'styles'  => array( 'portfolio', 'masonry' ),
				'scripts' => 'masonry',
				'icon'    => "images/theme-options/blog-style/portfolio-masonry-%d.png",
				'new_row' => true,
			);
		}
		inestio_storage_set( 'blog_styles', apply_filters( 'inestio_filter_add_blog_styles', $blog_styles ) );
	}
}


//--------------------------------------------
// SINGLE STYLES
//--------------------------------------------
if ( ! function_exists( 'inestio_skin_setup_single_styles' ) ) {
	add_action( 'after_setup_theme', 'inestio_skin_setup_single_styles', 1 );
	function inestio_skin_setup_single_styles() {

		inestio_storage_set( 'single_styles', apply_filters( 'inestio_filter_add_single_styles', array(
			'style-1'   => array(
				'title'       => esc_html__( 'Style 1', 'inestio' ),
				'description' => esc_html__( 'Fullwidth image is above the content area, the title and meta are over the image', 'inestio' ),
				'styles'      => 'style-1',
				'icon'        => "images/theme-options/single-style/style-1.png",
			),
			'style-2'   => array(
				'title'       => esc_html__( 'Style 2', 'inestio' ),
				'description' => esc_html__( 'Fullwidth image is above the content area, the title and meta are inside the content area', 'inestio' ),
				'styles'      => 'style-2',
				'icon'        => "images/theme-options/single-style/style-2.png",
			),
			'style-3'   => array(
				'title'       => esc_html__( 'Style 3', 'inestio' ),
				'description' => esc_html__( 'Fullwidth image is above the content area, the title and meta are below the image', 'inestio' ),
				'styles'      => 'style-3',
				'icon'        => "images/theme-options/single-style/style-3.png",
			),
			'style-4'   => array(
				'title'       => esc_html__( 'Style 4', 'inestio' ),
				'description' => esc_html__( 'Boxed image is above the content area, the title and meta are above the image', 'inestio' ),
				'styles'      => 'style-4',
				'icon'        => "images/theme-options/single-style/style-4.png",
			),
			'style-5'   => array(
				'title'       => esc_html__( 'Style 5', 'inestio' ),
				'description' => esc_html__( 'Boxed image is inside the content area, the title and meta are above the content area', 'inestio' ),
				'styles'      => 'style-5',
				'icon'        => "images/theme-options/single-style/style-5.png",
			),
			'style-6'   => array(
				'title'       => esc_html__( 'Style 6', 'inestio' ),
				'description' => esc_html__( 'Boxed image, the title and meta are inside the content area, the title and meta are above the image', 'inestio' ),
				'styles'      => 'style-6',
				'icon'        => "images/theme-options/single-style/style-6.png",
			),
			'style-7'   => array(
				'title'       => esc_html__( 'Style 7', 'inestio' ),
				'description' => esc_html__( 'Boxed image, the title and meta are above the content area like two big square areas', 'inestio' ),
				'styles'      => 'style-7',
				'icon'        => "images/theme-options/single-style/style-7.png",
			),
		) ) );
	}
}
