<?php
// Add plugin-specific vars to the custom CSS
if ( ! function_exists( 'inestio_elm_add_theme_vars' ) ) {
	add_filter( 'inestio_filter_add_theme_vars', 'inestio_elm_add_theme_vars', 10, 2 );
	function inestio_elm_add_theme_vars( $rez, $vars ) {
		foreach ( array( 10, 20, 30, 40, 60 ) as $m ) {
			if ( substr( $vars['page'], 0, 2 ) != '{{' ) {
				$rez[ "page{$m}" ]    = ( $vars['page'] + $m ) . 'px';
				$rez[ "content{$m}" ] = ( $vars['page'] - $vars['gap'] - $vars['sidebar'] + $m ) . 'px';
			} else {
				$rez[ "page{$m}" ]    = "{{ data.page{$m} }}";
				$rez[ "content{$m}" ] = "{{ data.content{$m} }}";
			}
		}
		return $rez;
	}
}


// Add custom animations
if ( ! function_exists( 'inestio_elm_add_theme_animations' ) ) {
	add_filter( 'elementor/controls/animations/additional_animations', 'inestio_elm_add_theme_animations' );
	function inestio_elm_add_theme_animations( $animations ) {
		return array_merge( $animations, array(
			esc_html__( 'Theme Specific', 'inestio' ) => array(
				'inestio-fadeinup' => esc_html__( 'Inestio - Fade In Up', 'inestio' ),
				'inestio-fadeinright' => esc_html__( 'Inestio - Fade In Right', 'inestio' ),
				'inestio-fadeinleft' => esc_html__( 'Inestio - Fade In Left', 'inestio' ),
				'inestio-fadeindown' => esc_html__( 'Inestio - Fade In Down', 'inestio' ),
				'inestio-fadein' => esc_html__( 'Inestio - Fade In', 'inestio' )
			)
		) );
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'inestio_elm_get_css' ) ) {
	add_filter( 'inestio_filter_get_css', 'inestio_elm_get_css', 10, 2 );
	function inestio_elm_get_css( $css, $args ) {

		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS

/* elementor-widget-progress */
.elementor-widget-progress .elementor-title {
	{$fonts['h5_font-family']};
}
.elementor-widget-progress .elementor-progress-percentage{ 
	{$fonts['h5_font-family']};
}

/* elementor-widget-toggle */
.elementor-widget-toggle .elementor-tab-title {
	{$fonts['h5_font-family']};
}

CSS;
		}


		if ( isset( $css['vars'] ) && isset( $args['vars'] ) ) {
			$vars = $args['vars'];
			$css['vars'] .= <<<CSS
/* No gap */
.elementor-section.elementor-section-boxed > .elementor-column-gap-no {
	max-width: {$vars['page']};
}
/* Narrow: 5px */
.elementor-section.elementor-section-boxed > .elementor-column-gap-narrow {
	max-width: {$vars['page10']};
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow {
	width: {$vars['page10']};
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow {
	width: {$vars['content10']};
}

/* Default: 10px */
.elementor-section.elementor-section-boxed > .elementor-column-gap-default {
	max-width: {$vars['page20']};
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default {
	width: {$vars['page20']};
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default {
	width: {$vars['content20']};
}

/* Extended: 15px */
.elementor-section.elementor-section-boxed > .elementor-column-gap-extended {
	max-width: {$vars['page30']};
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended {
	width: {$vars['page30']};
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended {
	width: {$vars['content30']};
}

/* Wide: 20px */
.elementor-section.elementor-section-boxed > .elementor-column-gap-wide {
	max-width: {$vars['page40']};
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide {
	width: {$vars['page40']};
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide {
	width: {$vars['content40']};
}

/* Wider: 30px */
.elementor-section.elementor-section-boxed > .elementor-column-gap-wider {
	max-width: {$vars['page60']};
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider {
	width: {$vars['page60']};
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider {
	width: {$vars['content60']};
}

CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS

/* Shape above and below rows */
.elementor-shape .elementor-shape-fill {
	fill: {$colors['bg_color']};
}

/* elementor-widget-progress */
.elementor-widget-progress .elementor-title {
    color: {$colors['text_dark']};
}
.elementor-widget-progress .elementor-progress-text {
    color: {$colors['text_dark']};
}
.elementor-widget-progress .elementor-progress-percentage{ 
	color: {$colors['text_dark']};
}

/* elementor-widget-social-icons */
.scheme_self.footer_wrap .elementor-social-icon {
	border-color: {$colors['alter_bd_hover']};
}

/* social icons */
.elementor-social-icon i {
	color: {$colors['alter_text']};
}

/* toggle */
.elementor-toggle .elementor-tab-title {
	color: {$colors['text_dark']};
}

CSS;
		}

		return $css;
	}
}

