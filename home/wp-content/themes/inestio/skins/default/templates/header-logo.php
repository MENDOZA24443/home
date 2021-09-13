<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package INESTIO
 * @since INESTIO 1.0
 */

$inestio_args = get_query_var( 'inestio_logo_args' );

// Site logo
$inestio_logo_type   = isset( $inestio_args['type'] ) ? $inestio_args['type'] : '';
$inestio_logo_image  = inestio_get_logo_image( $inestio_logo_type );
$inestio_logo_text   = inestio_is_on( inestio_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$inestio_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $inestio_logo_image['logo'] ) || ! empty( $inestio_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $inestio_logo_image['logo'] ) ) {
			if ( empty( $inestio_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric( $inestio_logo_image['logo'] ) && $inestio_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$inestio_attr = inestio_getimagesize( $inestio_logo_image['logo'] );
				echo '<img src="' . esc_url( $inestio_logo_image['logo'] ) . '"'
						. ( ! empty( $inestio_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $inestio_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $inestio_logo_text ) . '"'
						. ( ! empty( $inestio_attr[3] ) ? ' ' . wp_kses_data( $inestio_attr[3] ) : '' )
						. '>';
			}
		} else {
			inestio_show_layout( inestio_prepare_macros( $inestio_logo_text ), '<span class="logo_text">', '</span>' );
			inestio_show_layout( inestio_prepare_macros( $inestio_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
