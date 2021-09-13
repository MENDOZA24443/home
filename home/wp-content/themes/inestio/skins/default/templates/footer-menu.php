<?php
/**
 * The template to display menu in the footer
 *
 * @package INESTIO
 * @since INESTIO 1.0.10
 */

// Footer menu
$inestio_menu_footer = inestio_get_nav_menu( 'menu_footer' );
if ( ! empty( $inestio_menu_footer ) ) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php
			inestio_show_layout(
				$inestio_menu_footer,
				'<nav class="menu_footer_nav_area sc_layouts_menu sc_layouts_menu_default"'
					. ' itemscope="itemscope" itemtype="' . esc_attr( inestio_get_protocol( true ) ) . '//schema.org/SiteNavigationElement"'
					. '>',
				'</nav>'
			);
			?>
		</div>
	</div>
	<?php
}
