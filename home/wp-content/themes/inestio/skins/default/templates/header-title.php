<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package INESTIO
 * @since INESTIO 1.0
 */

// Page (category, tag, archive, author) title

if ( inestio_need_page_title() ) {
	inestio_sc_layouts_showed( 'title', true );
	inestio_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								inestio_show_post_meta(
									apply_filters(
										'inestio_filter_post_meta_args', array(
											'components' => join( ',', inestio_array_get_keys_by_value( inestio_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', inestio_array_get_keys_by_value( inestio_get_theme_option( 'counters' ) ) ),
											'seo'        => inestio_is_on( inestio_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$inestio_blog_title           = inestio_get_blog_title();
							$inestio_blog_title_text      = '';
							$inestio_blog_title_class     = '';
							$inestio_blog_title_link      = '';
							$inestio_blog_title_link_text = '';
							if ( is_array( $inestio_blog_title ) ) {
								$inestio_blog_title_text      = $inestio_blog_title['text'];
								$inestio_blog_title_class     = ! empty( $inestio_blog_title['class'] ) ? ' ' . $inestio_blog_title['class'] : '';
								$inestio_blog_title_link      = ! empty( $inestio_blog_title['link'] ) ? $inestio_blog_title['link'] : '';
								$inestio_blog_title_link_text = ! empty( $inestio_blog_title['link_text'] ) ? $inestio_blog_title['link_text'] : '';
							} else {
								$inestio_blog_title_text = $inestio_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $inestio_blog_title_class ); ?>">
								<?php
								$inestio_top_icon = inestio_get_term_image_small();
								if ( ! empty( $inestio_top_icon ) ) {
									$inestio_attr = inestio_getimagesize( $inestio_top_icon );
									?>
									<img src="<?php echo esc_url( $inestio_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'inestio' ); ?>"
										<?php
										if ( ! empty( $inestio_attr[3] ) ) {
											inestio_show_layout( $inestio_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $inestio_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $inestio_blog_title_link ) && ! empty( $inestio_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $inestio_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $inestio_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'inestio_action_breadcrumbs' );
						$inestio_breadcrumbs = ob_get_contents();
						ob_end_clean();
						inestio_show_layout( $inestio_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
