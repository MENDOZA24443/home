<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'inestio_addons_get_css' ) ) {
	add_filter( 'inestio_filter_get_css', 'inestio_addons_get_css', 10, 2 );
	function inestio_addons_get_css( $css, $args ) {
		return $css;
	}
}

