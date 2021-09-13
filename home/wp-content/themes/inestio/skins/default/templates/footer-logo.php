<?php
/**
 * The template to display the site logo in the footer
 *
 * @package INESTIO
 * @since INESTIO 1.0.10
 */

// Logo
if ( inestio_is_on( inestio_get_theme_option( 'logo_in_footer' ) ) ) {
	$inestio_logo_image = inestio_get_logo_image( 'footer' );
	$inestio_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $inestio_logo_image['logo'] ) || ! empty( $inestio_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $inestio_logo_image['logo'] ) ) {
					$inestio_attr = inestio_getimagesize( $inestio_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $inestio_logo_image['logo'] ) . '"'
								. ( ! empty( $inestio_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $inestio_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'inestio' ) . '"'
								. ( ! empty( $inestio_attr[3] ) ? ' ' . wp_kses_data( $inestio_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $inestio_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $inestio_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
