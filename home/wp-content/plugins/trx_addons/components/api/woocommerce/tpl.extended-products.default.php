<?php
/**
 * Template to display theme-specific products layout
 *
 * @package ThemeREX Addons
 * @since v1.85.0
 */

$args = get_query_var('trx_addons_args_sc_extended_products');

?><div <?php if ( ! empty( $args['id'] ) ) echo ' id="' . esc_attr( $args['id'] ) . '"'; ?> 
	class="sc_extended_products sc_extended_products_<?php
		echo esc_attr( $args['type'] );
		if ( ! empty( $args['class'] ) ) echo ' ' . esc_attr( $args['class'] );
		?>"<?php
	if ( ! empty( $args['css'] ) ) echo ' style="' . esc_attr($args['css']) . '"';
	trx_addons_sc_show_attributes( 'sc_extended_products', $args, 'sc_wrapper' );
	?>><?php

	trx_addons_sc_show_titles( 'sc_extended_products', $args );

	?><div class="sc_extended_products_content sc_item_content"<?php trx_addons_sc_show_attributes( 'sc_extended_products', $args, 'sc_items_wrapper' ); ?>><?php

	trx_addons_show_layout( do_shortcode( trx_addons_sc_make_string( 'products', apply_filters( 'trx_addons_filter_sc_extended_products_args_to_woocommerce', $args ) ) ) );

	?></div><?php

	trx_addons_sc_show_links( 'sc_extended_products', $args );

?></div>
