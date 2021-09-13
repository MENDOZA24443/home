<?php
/**
 * The Front Page template file.
 *
 * @package INESTIO
 * @since INESTIO 1.0.31
 */

get_header();

// If front-page is a static page
if ( get_option( 'show_on_front' ) == 'page' ) {

	// If Front Page Builder is enabled - display sections
	if ( inestio_is_on( inestio_get_theme_option( 'front_page_enabled' ) ) ) {

		if ( have_posts() ) {
			the_post();
		}

		$inestio_sections = inestio_array_get_keys_by_value( inestio_get_theme_option( 'front_page_sections' ) );
		if ( is_array( $inestio_sections ) ) {
			foreach ( $inestio_sections as $inestio_section ) {
				get_template_part( apply_filters( 'inestio_filter_get_template_part', 'front-page/section', $inestio_section ), $inestio_section );
			}
		}

		// Else if this page is blog archive
	} elseif ( is_page_template( 'blog.php' ) ) {
		get_template_part( apply_filters( 'inestio_filter_get_template_part', 'blog' ) );

		// Else - display native page content
	} else {
		get_template_part( apply_filters( 'inestio_filter_get_template_part', 'page' ) );
	}

	// Else get index template to show posts
} else {
	get_template_part( apply_filters( 'inestio_filter_get_template_part', 'index' ) );
}

get_footer();
