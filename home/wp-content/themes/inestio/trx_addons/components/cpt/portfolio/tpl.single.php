<?php
/**
 * The template to display the portfolio single page
 *
 * @package ThemeREX Addons
 * @since v1.5
 */

get_header();

while ( have_posts() ) { the_post();

	$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);

	do_action('trx_addons_action_before_article', 'portfolio.single');
	
	?><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>" <?php post_class( 'portfolio_page itemscope portfolio_page_details_'.esc_attr($meta['details_position']) ); trx_addons_seo_snippets('', 'Article'); ?>><?php

		do_action('trx_addons_action_article_start', 'portfolio.single');

		

		// Post content
		?><section class="portfolio_page_content_wrap">
		<?php
				// Details
				trx_addons_cpt_portfolio_show_details( array(
														'meta'  => $meta,
														'class' => 'portfolio_page_details',
														'share' => true
														)
												);
			?>
			<?php
			// Project details before the content
		if ( ! empty($meta['subtitle']) || has_excerpt() || ( ! empty($meta['details']) && count($meta['details']) > 0 && ! empty($meta['details'][0]['title']) ) ) {
			if (in_array($meta['details_position'], array('right', 'bottom'))) {
				ob_start();
			}
			?><section class="portfolio_page_details_wrap"><?php
			?><div class='portfolio_page_details_wrap_column1'><?php
				// Subtitle
				if (!empty($meta['subtitle'])) {
					?><h2 class="portfolio_page_subtitle"><?php trx_addons_show_layout(trx_addons_prepare_macros($meta['subtitle'])); ?></h2><?php
				}
				// Excerpt
				if (has_excerpt()) {
					?><div class="portfolio_page_description"><?php
						the_excerpt();
					?></div><?php
				}
				?></div>
			<?php
			if (in_array($meta['details_position'], array('right', 'bottom'))) {
				$details = ob_get_contents();
				ob_end_clean();
			}
		}?>
		</section>	<?php
			// Gallery
			if (!empty($meta['gallery']) && $meta['gallery_position']!='none') {
				$images = explode('|', $meta['gallery']);
				if ( in_array( $meta['gallery_position'], array( 'inside', 'bottom' ) ) ) {
					ob_start();
				}
				?><div class="portfolio_page_gallery"><?php
					?><div class="portfolio_page_gallery_content portfolio_page_gallery_type_<?php echo esc_attr($meta['gallery_layout']); ?>"><?php
						// Layout: Slider
						if ($meta['gallery_layout'] == 'slider') {
							trx_addons_show_layout(trx_addons_get_slider_layout(array(
										'mode' => 'custom',
										), $images));
						
						// Layout: Grid or Stream
						} else if (strpos($meta['gallery_layout'], 'grid_')!==false || strpos($meta['gallery_layout'], 'masonry_')!==false || $meta['gallery_layout'] == 'stream') {
							$style   = explode('_', $meta['gallery_layout']);
							$type    = $style[0];
							$columns = empty($style[1]) ? 1 : max(2, $style[1]);
							if ($columns > 1 && $type == 'grid') {
								?><div class="portfolio_page_columns_wrap <?php
									echo esc_attr(trx_addons_get_columns_wrap_class())
										. ' columns_padding_bottom'
										. esc_attr( trx_addons_add_columns_in_single_row( $columns, $images ) );
								?>"><?php
							}
							foreach($images as $img) {
								$img_title = '';
								if (($img_id = attachment_url_to_postid($img)) > 0) {
									$img_title = wp_get_attachment_caption($img_id);
								}
								?><div class="<?php
									if ($columns > 1 && $type == 'grid')
										echo esc_attr(trx_addons_get_column_class(1, $columns));
									else
										echo 'portfolio_page_gallery_item';
								?>">
									<figure><?php
										$thumb = trx_addons_add_thumb_size($img, apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size($type=='stream'
																																	? 'full'
																																	: ($type=='masonry'
																																		? ($columns > 2 ? 'masonry' : 'masonry-big') 
																																		: ($columns > 2 ? 'medium' : 'big'))),
																																'portfolio-single'));
										$attr = trx_addons_getimagesize($thumb);
										?><a href="<?php echo esc_url($img); ?>" title="<?php echo esc_attr($img_title); ?>"><img src="<?php echo esc_url($thumb); ?>" alt="<?php esc_attr_e('Gallery item', 'inestio'); ?>"<?php if (!empty($attr[3])) echo ' '.trim($attr[3]); ?>></a><?php
										if (!empty($img_title)) {
											?><figcaption class="wp-caption-text gallery-caption"><?php echo esc_html($img_title); ?></figcaption><?php
										}
									?></figure>
								</div><?php
							}
							if ($columns > 1 && $type == 'grid') {
								?></div><?php
							}
						}
					?></div><?php
					if (!empty($meta['gallery_description'])) {
						?><div class="portfolio_page_gallery_description"><?php
							trx_addons_show_layout(trx_addons_prepare_macros($meta['gallery_description']));
						?></div><?php
					}
				?></div><?php
				// Video
				if (!empty($meta['video'])) {
					?><div class="portfolio_page_video"><?php
						?><div class="portfolio_page_video_content"><?php
							trx_addons_show_layout(trx_addons_get_video_layout(array(
																					'link' => $meta['video']
																				)));
						?></div><?php
						if (!empty($meta['video_description'])) {
							?><div class="portfolio_page_video_description"><?php
								trx_addons_show_layout(trx_addons_prepare_macros($meta['video_description']));
							?></div><?php
						}
					?></div><?php
				}
				if ( in_array( $meta['gallery_position'], array( 'inside', 'bottom' ) ) ) {
					$gallery = ob_get_contents();
					ob_end_clean();
				}
			}

			// Image
			$inestio_header_image = get_header_image();
			if ( empty( $inestio_header_image ) && !inestio_trx_addons_featured_image_override( is_singular() ) ) {
				inestio_show_post_featured_image( array(
					'thumb_bg' => true,
				) );
			}

			if ( (empty( $inestio_header_image ) || !inestio_trx_addons_featured_image_override( is_singular() )) && (! trx_addons_sc_layouts_showed('featured') && has_post_thumbnail() && (empty($meta['gallery']) || in_array($meta['gallery_position'], array('none', 'bottom'))) )) {
				?><div class="portfolio_page_featured"><?php
					the_post_thumbnail(
										apply_filters('trx_addons_filter_thumb_size', 'full', 'portfolio-single'),
										trx_addons_seo_image_params(array(
																		'alt' => the_title_attribute( array( 'echo' => false ) )
										))
										);
				?></div><?php
			}
			
			// Title
			if ( ! trx_addons_sc_layouts_showed('title') ) {
				?><h2 class="portfolio_page_title"><?php the_title(); ?></h2><?php
				// Meta
				if ( ! trx_addons_sc_layouts_showed('postmeta') ) {
					?><div class="portfolio_page_meta"><?php
						trx_addons_sc_show_post_meta('portfolio_single', apply_filters('trx_addons_filter_post_meta_args', array(
									'components' => 'views,comments,likes,share',
									'seo' => false
									), 'portfolio_single', 1)
								);
					?></div><?php
					trx_addons_sc_layouts_showed('postmeta', true);
				}
			}
		
			// Post content
    if ( trim( get_the_content() ) != '' || ( function_exists('trx_addons_elm_is_preview') && trx_addons_elm_is_preview() ) ) {
				?><div class="portfolio_page_content entry-content"<?php trx_addons_seo_snippets('articleBody'); ?>><?php
					if ( $meta['gallery_position'] == 'inside' && ! empty( $gallery ) ) {
						$place = '%%GALLERY%%';
						$content = get_the_content();
						if ( strpos( $content, $place ) !== false ) {
							trx_addons_show_layout( apply_filters( 'the_content', preg_replace( '/(\<p\>\s*)?' . $place . '(\s*\<\/p\>)?/i', $gallery, $content ) ) );
						} else {
							the_content();
						}
					} else {
						the_content();
					}
				?></div><?php
			}
			
			// Gallery after the content
			if ( $meta['gallery_position'] == 'bottom' && ! empty( $gallery ) ) {
				trx_addons_show_layout($gallery);
			}
		
		?></section><!-- .entry-content --><?php

		// Project details after the content
		if (in_array($meta['details_position'], array('right', 'bottom')) && !empty($details)) {
			trx_addons_show_layout($details);
		}

		do_action('trx_addons_action_article_end', 'portfolio.single');

	?></article><?php

	do_action('trx_addons_action_after_article', 'portfolio.single');

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}

get_footer();
