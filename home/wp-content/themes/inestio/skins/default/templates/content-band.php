<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package INESTIO
 * @since INESTIO 1.71.0
 */

$inestio_template_args = get_query_var( 'inestio_template_args' );

$inestio_columns       = 1;

$inestio_expanded      = ! inestio_sidebar_present() && inestio_get_theme_option( 'expand_content' ) == 'expand';

$inestio_post_format   = get_post_format();
$inestio_post_format   = empty( $inestio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $inestio_post_format );

if ( is_array( $inestio_template_args ) ) {
	$inestio_columns    = empty( $inestio_template_args['columns'] ) ? 1 : max( 1, $inestio_template_args['columns'] );
	$inestio_blog_style = array( $inestio_template_args['type'], $inestio_columns );
	if ( ! empty( $inestio_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $inestio_columns > 1 ) {
		?>
		<div class="column-1_<?php echo esc_attr( $inestio_columns ); ?>">
		<?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $inestio_post_format ) );
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
								: array_map( 'trim', explode( ',', $inestio_template_args['meta_parts'] ) )
								)
							: inestio_array_get_keys_by_value( inestio_get_theme_option( 'meta_parts' ) );
	inestio_show_post_featured(
		array(
			'no_links'   => ! empty( $inestio_template_args['no_links'] ),
			'hover'      => $inestio_hover,
			'meta_parts' => $inestio_components,
			'thumb_bg'   => true,
			'thumb_size' => inestio_get_thumb_size( 
								in_array( $inestio_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( inestio_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $inestio_expanded 
											? 'big' 
											: 'med'
											)
										)
									: 'masonry-big'
								)
		)
	);

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$inestio_show_title = get_the_title() != '';
		$inestio_show_meta  = count( $inestio_components ) > 0 && ! in_array( $inestio_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $inestio_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'inestio_filter_show_blog_categories', $inestio_show_meta && in_array( 'categories', $inestio_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'inestio_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						inestio_show_post_meta( apply_filters(
															'inestio_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																),
															'hover_' . $inestio_hover, 1
															)
											);
						?>
					</div>
					<?php
					$inestio_components = inestio_array_delete_by_value( $inestio_components, 'categories' );
					do_action( 'inestio_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'inestio_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'inestio_action_before_post_title' );
					if ( empty( $inestio_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'inestio_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $inestio_template_args['excerpt_length'] ) && ! in_array( $inestio_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$inestio_template_args['excerpt_length'] = 30;
		}
		if ( apply_filters( 'inestio_filter_show_blog_excerpt', empty( $inestio_template_args['hide_excerpt'] ) && inestio_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				inestio_show_post_content( $inestio_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'inestio_filter_show_blog_meta', $inestio_show_meta, $inestio_components, 'band' ) ) {
			if ( count( $inestio_components ) > 0 ) {
				do_action( 'inestio_action_before_post_meta' );
				inestio_show_post_meta(
					apply_filters(
						'inestio_filter_post_meta_args', array(
							'components' => join( ',', $inestio_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'inestio_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'inestio_filter_show_blog_readmore', ! $inestio_show_title, 'band' ) ) {
			if ( empty( $inestio_template_args['no_links'] ) ) {
				do_action( 'inestio_action_before_post_readmore' );
				inestio_show_post_more_link( $inestio_template_args, '<p>', '</p>' );
				do_action( 'inestio_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $inestio_template_args ) ) {
	if ( ! empty( $inestio_template_args['slider'] ) || $inestio_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
