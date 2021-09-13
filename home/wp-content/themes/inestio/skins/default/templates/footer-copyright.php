<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package INESTIO
 * @since INESTIO 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$inestio_copyright_scheme = inestio_get_theme_option( 'copyright_scheme' );
if ( ! empty( $inestio_copyright_scheme ) && ! inestio_is_inherit( $inestio_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $inestio_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$inestio_copyright = inestio_get_theme_option( 'copyright' );
			if ( ! empty( $inestio_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$inestio_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $inestio_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$inestio_copyright = inestio_prepare_macros( $inestio_copyright );
				// Display copyright
				echo wp_kses( nl2br( $inestio_copyright ), 'inestio_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
