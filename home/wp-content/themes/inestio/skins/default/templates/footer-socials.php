<?php
/**
 * The template to display the socials in the footer
 *
 * @package INESTIO
 * @since INESTIO 1.0.10
 */


// Socials
if ( inestio_is_on( inestio_get_theme_option( 'socials_in_footer' ) ) ) {
	$inestio_output = inestio_get_socials_links();
	if ( '' != $inestio_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php inestio_show_layout( $inestio_output ); ?>
			</div>
		</div>
		<?php
	}
}
