<?php
/**
 * The template to display the background video in the header
 *
 * @package INESTIO
 * @since INESTIO 1.0.14
 */
$inestio_header_video = inestio_get_header_video();
$inestio_embed_video  = '';
if ( ! empty( $inestio_header_video ) && ! inestio_is_from_uploads( $inestio_header_video ) ) {
	if ( inestio_is_youtube_url( $inestio_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $inestio_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php inestio_show_layout( inestio_get_embed_video( $inestio_header_video ) ); ?></div>
		<?php
	}
}
