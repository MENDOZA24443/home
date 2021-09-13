<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package INESTIO
 * @since INESTIO 1.0.06
 */

$inestio_header_css   = '';
$inestio_header_image = get_header_image();
$inestio_header_video = inestio_get_header_video();
if ( ! empty( $inestio_header_image ) && inestio_trx_addons_featured_image_override( is_singular() || inestio_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$inestio_header_image = inestio_get_current_mode_image( $inestio_header_image );
}
if ( inestio_trx_addons_featured_image_override( is_singular() || inestio_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$inestio_header_image = inestio_get_current_mode_image( $inestio_header_image );
}


$inestio_header_id = inestio_get_custom_header_id();
$inestio_header_meta = get_post_meta( $inestio_header_id, 'trx_addons_options', true );
if ( ! empty( $inestio_header_meta['margin'] ) ) {
	inestio_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( inestio_prepare_css_value( $inestio_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $inestio_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $inestio_header_id ) ) ); ?>
				<?php
				echo ! empty( $inestio_header_image ) || ! empty( $inestio_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
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

	// Custom header's layout
	do_action( 'inestio_action_show_layout', $inestio_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
