<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package INESTIO
 * @since INESTIO 1.0
 */

$inestio_template_args = get_query_var( 'inestio_template_args' );
if ( is_array( $inestio_template_args ) ) {
	$inestio_columns    = empty( $inestio_template_args['columns'] ) ? 2 : max( 1, $inestio_template_args['columns'] );
	$inestio_blog_style = array( $inestio_template_args['type'], $inestio_columns );
} else {
	$inestio_blog_style = explode( '_', inestio_get_theme_option( 'blog_style' ) );
	$inestio_columns    = empty( $inestio_blog_style[1] ) ? 2 : max( 1, $inestio_blog_style[1] );
}

$inestio_post_format = get_post_format();
$inestio_post_format = empty( $inestio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $inestio_post_format );

?><div class="
<?php
if ( ! empty( $inestio_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( inestio_is_blog_style_use_masonry( $inestio_blog_style[0] ) ? 'masonry_item masonry_item' : 'column' ) . '-1_' . esc_attr( $inestio_columns );
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $inestio_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $inestio_columns )
		. ( 'portfolio' != $inestio_blog_style[0] ? ' ' . esc_attr( $inestio_blog_style[0] )  . '_' . esc_attr( $inestio_columns ) : '' )
		. ( is_sticky() && ! is_paged() ? ' sticky' : '' )
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

	$inestio_hover   = ! empty( $inestio_template_args['hover'] ) && ! inestio_is_inherit( $inestio_template_args['hover'] )
								? $inestio_template_args['hover']
								: inestio_get_theme_option( 'image_hover' );

	if ( 'dots' == $inestio_hover ) {
		$inestio_post_link = empty( $inestio_template_args['no_links'] )
								? ( ! empty( $inestio_template_args['link'] )
									? $inestio_template_args['link']
									: get_permalink()
									)
								: '';
		$inestio_target    = ! empty( $inestio_post_link ) && false === strpos( $inestio_post_link, home_url() )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$inestio_components = ! empty( $inestio_template_args['meta_parts'] )
							? ( is_array( $inestio_template_args['meta_parts'] )
								? $inestio_template_args['meta_parts']
								: explode( ',', $inestio_template_args['meta_parts'] )
								)
							: inestio_array_get_keys_by_value( inestio_get_theme_option( 'meta_parts' ) );

	// Featured image
	inestio_show_post_featured(
		array(
			'hover'         => $inestio_hover,
			'no_links'      => ! empty( $inestio_template_args['no_links'] ),
			'thumb_size'    => inestio_get_thumb_size(
									inestio_is_blog_style_use_masonry( $inestio_blog_style[0] )
										? (	strpos( inestio_get_theme_option( 'body_style' ), 'full' ) !== false || $inestio_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( inestio_get_theme_option( 'body_style' ), 'full' ) !== false || $inestio_columns < 3
											? 'big'
											: 'portfolio'
											)
								),
			'show_no_image' => true,
			'meta_parts'    => $inestio_components,
			'class'         => 'dots' == $inestio_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $inestio_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $inestio_post_link )
												? '<a href="' . esc_url( $inestio_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $inestio_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
		)
	);
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!