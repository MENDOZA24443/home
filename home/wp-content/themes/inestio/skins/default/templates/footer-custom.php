<?php
/**
 * The template to display default site footer
 *
 * @package INESTIO
 * @since INESTIO 1.0.10
 */

$inestio_footer_id = inestio_get_custom_footer_id();
$inestio_footer_meta = get_post_meta( $inestio_footer_id, 'trx_addons_options', true );
if ( ! empty( $inestio_footer_meta['margin'] ) ) {
	inestio_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( inestio_prepare_css_value( $inestio_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $inestio_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $inestio_footer_id ) ) ); ?>
						<?php
						$inestio_footer_scheme = inestio_get_theme_option( 'footer_scheme' );
						if ( ! empty( $inestio_footer_scheme ) && ! inestio_is_inherit( $inestio_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $inestio_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'inestio_action_show_layout', $inestio_footer_id );
	?>
</footer><!-- /.footer_wrap -->
