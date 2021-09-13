<?php
/**
 * The style "chess" of the Services item
 *
 * @package ThemeREX Addons
 * @since v1.6.13
 */

$args = get_query_var('trx_addons_args_sc_services');
if (empty($args['id'])) $args['id'] = 'sc_services_'.str_replace('.', '', mt_rand());

$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
if (!is_array($meta)) $meta = array();
$meta['price'] = apply_filters( 'trx_addons_filter_custom_meta_value', !empty($meta['price']) ? $meta['price'] : '', 'price' );

$link = empty($args['no_links'])
			? (!empty($meta['link']) ? $meta['link'] : get_permalink())
			: '';

if (!empty($args['slider'])) {
	?><div class="slider-slide swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'], !empty($args['columns_tablet']) ? $args['columns_tablet'] : '', !empty($args['columns_mobile']) ? $args['columns_mobile'] : '')); ?> "><?php
}
?>
<div data-post-id="<?php the_ID(); ?>" <?php post_class( apply_filters( 'trx_addons_filter_services_item_class',
			'sc_services_item sc_item_container post_container'
			. (empty($post_link) ? ' no_links' : '')
			. (isset($args['hide_excerpt']) && (int)$args['hide_excerpt'] > 0 ? ' without_content' : ' with_content'),
			$args )
			);
	trx_addons_add_blog_animation('services', $args);
	if (!empty($args['popup'])) {
		?> data-post_id="<?php echo esc_attr(get_the_ID()); ?>"<?php
		?> data-post_type="<?php echo esc_attr(TRX_ADDONS_CPT_SERVICES_PT); ?>"<?php
	}
?>><?php
	do_action( 'trx_addons_action_services_item_start', $args );
	trx_addons_get_template_part('templates/tpl.featured.php',
									'trx_addons_args_featured',
									apply_filters('trx_addons_filter_args_featured', array(
												'class' => 'sc_services_item_header',
												'show_no_image' => true,
												'no_links' => empty($link),
												'link' => $link,
												'thumb_bg' => true,
												'thumb_size' => apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size('full'), 'services-chess')
												),
												'services-chess'
												)
								);
	do_action( 'trx_addons_action_services_item_after_featured', $args );
	?>
	<div class="sc_services_item_content">
		<?php
		do_action( 'trx_addons_action_services_item_content_start', $args );

		/* icon */
		if (!empty($meta['icon'])) {
			$number = get_query_var('trx_addons_args_item_number');
			$svg_present = false;
			$svg = $img = '';
			if (trx_addons_is_url($meta['icon'])) {
				if (strpos($meta['icon'], '.svg') !== false) {
					$svg = $meta['icon'];
					$svg_present = !empty($args['icons_animation']);
				} else {
					$img = $meta['icon'];
				}
				$meta['icon'] = basename($meta['icon']);
			} else if (!empty($args['icons_animation']) && ($svg = trx_addons_get_file_dir('css/icons.svg/'.trx_addons_clear_icon_name($meta['icon']).'.svg')) != '') {
				$svg_present = true;
			}
			if (!empty($link)) {
				?><a href="<?php echo esc_url($link); ?>"<?php if (!empty($meta['link'])) echo ' target="_blank"'; ?>class="sc_services_item_icon"><?php
			}
				?><span id="<?php echo esc_attr($args['id'].'_'.trim($meta['icon']).'_'.trim($number)); ?>"
					class="sc_services_item_icon<?php 
							if ($svg_present) echo ' sc_icon_animation';
							echo !empty($svg) 
									? ' sc_icon_type_svg'
									: (!empty($img) 
										? ' sc_icon_type_images'
										: ' sc_icon_type_icons ' . esc_attr($meta['icon'])
										);
							?>"
					><?php
					if (!empty($svg)) {
						trx_addons_show_layout(trx_addons_get_svg_from_file($svg));
					} else if (!empty($img)) {
						$attr = trx_addons_getimagesize($img);
						?><img class="sc_icon_as_image" src="<?php echo esc_url($img); ?>" alt="<?php esc_attr_e('Icon', 'inestio'); ?>"<?php echo (!empty($attr[3]) ? ' '.trim($attr[3]) : ''); ?>><?php
					}
				?></span><?php
			if (!empty($link)) {
				?></a><?php
			}
		}

		/* title */
		$title_tag = 'h6';
		if ($args['columns'] == 1) $title_tag = 'h4';
		?>
		<<?php echo esc_attr($title_tag); ?> class="sc_services_item_title<?php if (!empty($meta['price'])) echo ' with_price'; ?>"><?php
			if (!empty($link)) {
				?><a href="<?php echo esc_url($link); ?>"<?php if (!empty($meta['link'])) echo ' target="_blank"'; ?>><?php
			}
			the_title();
			// Price
			if (!empty($meta['price'])) {
				?><div class="sc_services_item_price"><?php trx_addons_show_layout($meta['price']); ?></div><?php
			}
			if (!empty($link)) {
				?></a><?php
			}
		?></<?php echo esc_attr($title_tag); ?>>
		<?php do_action( 'trx_addons_action_services_item_after_title', $args ); ?>
	
		<?php do_action( 'trx_addons_action_services_item_after_subtitle', $args ); ?>
		<?php if (!isset($args['hide_excerpt']) || (int) $args['hide_excerpt']==0) { ?>
			<div class="sc_services_item_text"><?php the_excerpt(); ?></div>
		<?php } 
		if (!empty($link) && !empty($args['more_text'])) {
			?><div class="sc_services_item_button sc_item_button"><a href="<?php echo esc_url($link); ?>"<?php if (!empty($meta['link'])) echo ' target="_blank"'; ?> class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_link_classes', 'sc_button color_style_dark', 'sc_services', $args)); ?>"><?php echo esc_html($args['more_text']); ?></a></div><?php
		}
		?>
		<?php do_action( 'trx_addons_action_services_item_content_end', $args ); ?>
	</div>
</div>
<?php
if (!empty($args['slider']) || $args['columns'] > 1) {
	?></div><?php
}
