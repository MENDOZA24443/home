<?php
/**
 * The Classic template to display the content
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
$inestio_expanded   = ! inestio_sidebar_present() && inestio_get_theme_option( 'expand_content' ) == 'expand';

$inestio_post_format = get_post_format();
$inestio_post_format = empty( $inestio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $inestio_post_format );

?><div class="<?php
	if ( ! empty( $inestio_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( inestio_is_blog_style_use_masonry( $inestio_blog_style[0] ) ? 'masonry_item masonry_item' : 'column' ) . '-1_' . esc_attr( $inestio_columns );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $inestio_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $inestio_columns )
				. ' post_layout_' . esc_attr( $inestio_blog_style[0] )
				. ' post_layout_' . esc_attr( $inestio_blog_style[0] ) . '_' . esc_attr( $inestio_columns )
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

	// Featured image
	$inestio_hover      = ! empty( $inestio_template_args['hover'] ) && ! inestio_is_inherit( $inestio_template_args['hover'] )
							? $inestio_template_args['hover']
							: inestio_get_theme_option( 'image_hover' );

	$inestio_components = ! empty( $inestio_template_args['meta_parts'] )
							? ( is_array( $inestio_template_args['meta_parts'] )
								? $inestio_template_args['meta_parts']
								: explode( ',', $inestio_template_args['meta_parts'] )
								)
							: inestio_array_get_keys_by_value( inestio_get_theme_option( 'meta_parts' ) );

	inestio_show_post_featured(
		array(
			'thumb_size' => inestio_get_thumb_size(
				'classic' == $inestio_blog_style[0]
						? ( strpos( inestio_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $inestio_columns > 2 ? 'big' : 'huge' )
								: ( $inestio_columns > 2
									? ( $inestio_expanded ? 'med' : 'small' )
									: ( $inestio_expanded ? 'big' : 'med' )
									)
							)
						: ( strpos( inestio_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $inestio_columns > 2 ? 'masonry-big' : 'full' )
								: ( $inestio_columns <= 2 && $inestio_expanded ? 'masonry-big' : 'masonry' )
							)
			),
			'hover'      => $inestio_hover,
			'meta_parts' => $inestio_components,
			'no_links'   => ! empty( $inestio_template_args['no_links'] ),
		)
	);
	?><div class="post_masonry_wrap"><?php
	// Title and post meta
	$inestio_show_title = get_the_title() != '';
	$inestio_show_meta  = count( $inestio_components ) > 0 && ! in_array( $inestio_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $inestio_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'inestio_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'inestio_action_before_post_title' );
				if ( empty( $inestio_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'inestio_action_after_post_title' );
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	ob_start();
	if ( apply_filters( 'inestio_filter_show_blog_excerpt', empty( $inestio_template_args['hide_excerpt'] ) && inestio_get_theme_option( 'excerpt_length' ) > 0, 'classic' ) ) {
		inestio_show_post_content( $inestio_template_args, '<div class="post_content_inner">', '</div>' );
	}
	$inestio_content = ob_get_contents();
	ob_end_clean();
	
	inestio_show_layout( $inestio_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->' );

	// Post meta
	if ( apply_filters( 'inestio_filter_show_blog_meta', $inestio_show_meta, $inestio_components, 'classic' ) ) { 
		if ( count( $inestio_components ) > 0 ) {
			do_action( 'inestio_action_before_post_meta' );
			inestio_show_post_meta(
				apply_filters(
					'inestio_filter_post_meta_args', array(
						'components' => join( ',', $inestio_components ),
						'seo'        => false,
						'echo'       => true,
					), $inestio_blog_style[0], $inestio_columns
				)
			);
		do_action( 'inestio_action_after_post_meta' );
		}
	}	

	// More button
	if ( apply_filters( 'inestio_filter_show_blog_readmore', ! $inestio_show_title, 'classic' ) ) {
		if ( empty( $inestio_template_args['no_links'] ) ) {
			do_action( 'inestio_action_before_post_readmore' );
			inestio_show_post_more_link( $inestio_template_args, '<p>', '</p>' );
			do_action( 'inestio_action_after_post_readmore' );
		}
	}
	?>
</div>
</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
