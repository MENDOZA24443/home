<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package INESTIO
 * @since INESTIO 1.0.50
 */

$inestio_template_args = get_query_var( 'inestio_template_args' );
if ( is_array( $inestio_template_args ) ) {
	$inestio_columns    = empty( $inestio_template_args['columns'] ) ? 2 : max( 1, $inestio_template_args['columns'] );
	$inestio_blog_style = array( $inestio_template_args['type'], $inestio_columns );
} else {
	$inestio_blog_style = explode( '_', inestio_get_theme_option( 'blog_style' ) );
	$inestio_columns    = empty( $inestio_blog_style[1] ) ? 2 : max( 1, $inestio_blog_style[1] );
}
$inestio_blog_id       = inestio_get_custom_blog_id( join( '_', $inestio_blog_style ) );
$inestio_blog_style[0] = str_replace( 'blog-custom-', '', $inestio_blog_style[0] );
$inestio_expanded      = ! inestio_sidebar_present() && inestio_get_theme_option( 'expand_content' ) == 'expand';
$inestio_components    = ! empty( $inestio_template_args['meta_parts'] )
							? ( is_array( $inestio_template_args['meta_parts'] )
								? join( ',', $inestio_template_args['meta_parts'] )
								: $inestio_template_args['meta_parts']
								)
							: inestio_array_get_keys_by_value( inestio_get_theme_option( 'meta_parts' ) );
$inestio_post_format   = get_post_format();
$inestio_post_format   = empty( $inestio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $inestio_post_format );

$inestio_blog_meta     = inestio_get_custom_layout_meta( $inestio_blog_id );
$inestio_custom_style  = ! empty( $inestio_blog_meta['scripts_required'] ) ? $inestio_blog_meta['scripts_required'] : 'none';

if ( ! empty( $inestio_template_args['slider'] ) || $inestio_columns > 1 || ! inestio_is_off( $inestio_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $inestio_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( inestio_is_off( $inestio_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $inestio_custom_style ) ) . "-1_{$inestio_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $inestio_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $inestio_columns )
					. ' post_layout_' . esc_attr( $inestio_blog_style[0] )
					. ' post_layout_' . esc_attr( $inestio_blog_style[0] ) . '_' . esc_attr( $inestio_columns )
					. ( ! inestio_is_off( $inestio_custom_style )
						? ' post_layout_' . esc_attr( $inestio_custom_style )
							. ' post_layout_' . esc_attr( $inestio_custom_style ) . '_' . esc_attr( $inestio_columns )
						: ''
						)
		);
	inestio_add_blog_animation( $inestio_template_args );
	?>
>
	<?php
	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}
	// Custom layout
	do_action( 'inestio_action_show_layout', $inestio_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $inestio_template_args['slider'] ) || $inestio_columns > 1 || ! inestio_is_off( $inestio_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
