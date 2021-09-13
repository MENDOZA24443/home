<?php
// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'inestio_skin_css_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'inestio_skin_css_theme_setup9', 9 );
	function inestio_skin_css_theme_setup9() {
		add_filter( 'inestio_filter_get_css', 'inestio_skin_get_css', 10, 2 );
	}
}

// Add skin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'inestio_skin_get_css' ) ) {
	
	function inestio_skin_get_css( $css, $args ) {

		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS

CSS;
		}

		if ( isset( $css['vars'] ) && isset( $args['vars'] ) ) {
			$vars         = $args['vars'];
			extract($vars);
			$css['vars'] .= <<<CSS

CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS

CSS;
		}

		return $css;
	}
}

