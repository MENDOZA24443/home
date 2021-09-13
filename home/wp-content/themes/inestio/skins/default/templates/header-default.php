<?php
/**
 * The template to display default site header
 *
 * @package INESTIO
 * @since INESTIO 1.0
 */

$inestio_header_css   = '';
$inestio_header_image = get_header_image();
$inestio_header_video = inestio_get_header_video();
if ( ! empty( $inestio_header_image ) && inestio_trx_addons_featured_image_override( is_singular() || inestio_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$inestio_header_image = inestio_get_current_mode_image( $inestio_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $inestio_header_image ) || ! empty( $inestio_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $inestio_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $inestio_header_image ) {
		echo ' ' . esc_attr( inestio_add_inline_css_class( 'background-image: url(' . esc_url( $inestio_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( inestio_is_on( inestio_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight inestio-full-height';
	}
	$inestio_header_scheme = inestio_get_theme_option( 'header_scheme' );
	if ( ! empty( $inestio_header_scheme ) && ! inestio_is_inherit( $inestio_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $inestio_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $inestio_header_video ) ) {
		get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( inestio_is_on( inestio_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
