<?php
/**
 * The template to display default site footer
 *
 * @package INESTIO
 * @since INESTIO 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$inestio_footer_scheme = inestio_get_theme_option( 'footer_scheme' );
if ( ! empty( $inestio_footer_scheme ) && ! inestio_is_inherit( $inestio_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $inestio_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/footer-socials' ) );

	// Menu
	get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/footer-menu' ) );

	// Copyright area
	get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
