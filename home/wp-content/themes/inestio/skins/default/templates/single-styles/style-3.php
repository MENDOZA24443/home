<?php
/**
 * The "Style 3" template to display the post header of the single post or attachment:
 * featured image and title placed in the post header
 *
 * @package INESTIO
 * @since INESTIO 1.75.0
 */

if ( is_singular( 'post' ) || is_singular( 'attachment' ) ) {
	ob_start();
	?>
	<div class="post_header_wrap post_header_wrap_in_header post_header_wrap_style_<?php
		echo esc_attr( inestio_get_theme_option( 'single_style' ) );
		if ( has_post_thumbnail() || str_replace( 'post-format-', '', get_post_format() ) == 'image' ) {
			echo ' with_featured_image';
		}
	?>">
		<?php
		// Featured image
		$inestio_header_image = get_header_image();
		if ( empty( $inestio_header_image ) || !inestio_trx_addons_featured_image_override( is_singular() ) ) {
			inestio_show_post_featured_image( array(
				'thumb_bg' => true,
			) );
		}
		// Post title and meta
		inestio_show_post_title_and_meta( array(
											'content_wrap'  => true,
											'share_type'    => 'list',
											'author_avatar' => false,
											'show_labels'   => true,
											'add_spaces'    => true,
											)
										);
		?>
	</div>
	<?php
	$inestio_post_header = ob_get_contents();
	ob_end_clean();
	if ( strpos( $inestio_post_header, 'post_featured' ) !== false
		|| strpos( $inestio_post_header, 'post_title' ) !== false
		|| strpos( $inestio_post_header, 'post_meta' ) !== false
	) {
		do_action( 'inestio_action_before_post_header' );
		inestio_show_layout( $inestio_post_header );
		do_action( 'inestio_action_after_post_header' );
	}
}
