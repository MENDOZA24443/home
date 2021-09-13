<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package INESTIO
 * @since INESTIO 1.0
 */

$inestio_template_args = get_query_var( 'inestio_template_args' );
$inestio_columns = 1;
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
$inestio_expanded    = ! inestio_sidebar_present() && inestio_get_theme_option( 'expand_content' ) == 'expand';
$inestio_post_format = get_post_format();
$inestio_post_format = empty( $inestio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $inestio_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $inestio_post_format ) );
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
	?>
<div class='post_layout_excerpt_wrap'>
	<?php
	$inestio_header_image = get_header_image();
	if ( empty( $inestio_header_image ) || !inestio_trx_addons_featured_image_override( is_singular() ) ) {
		inestio_show_post_featured_image( array(
			'thumb_bg' => true,
			'class'    => 'alignwide'
		) );
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
			'thumb_size' => inestio_get_thumb_size( strpos( inestio_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $inestio_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		)
	);

	// Title and post meta
	$inestio_show_title = get_the_title() != '';
	$inestio_show_meta  = count( $inestio_components ) > 0 && ! in_array( $inestio_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $inestio_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Categories
			if ( apply_filters( 'inestio_filter_show_blog_categories', $inestio_show_meta && in_array( 'categories', $inestio_components ), array( 'categories' ), 'excerpt' ) ) {
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
			if ( apply_filters( 'inestio_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'inestio_action_before_post_title' );
				if ( empty( $inestio_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'inestio_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'inestio_filter_show_blog_excerpt', empty( $inestio_template_args['hide_excerpt'] ) && inestio_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php
			if ( inestio_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'inestio_action_before_full_post_content' );
					the_content( '' );
					do_action( 'inestio_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'inestio' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'inestio' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				inestio_show_post_content( $inestio_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// Post meta
			if ( apply_filters( 'inestio_filter_show_blog_meta', $inestio_show_meta, $inestio_components, 'excerpt' ) ) {
				if ( count( $inestio_components ) > 0 ) {
					do_action( 'inestio_action_before_post_meta' );
					inestio_show_post_meta(
						apply_filters(
							'inestio_filter_post_meta_args', array(
								'components' => join( ',', $inestio_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'inestio_action_after_post_meta' );
				}
			}

			// More button
			
			?>
		
		</div><!-- .entry-content -->
		<?php
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
