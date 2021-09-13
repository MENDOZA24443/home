<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package INESTIO
 * @since INESTIO 1.0.10
 */

// Footer sidebar
$inestio_footer_name    = inestio_get_theme_option( 'footer_widgets' );
$inestio_footer_present = ! inestio_is_off( $inestio_footer_name ) && is_active_sidebar( $inestio_footer_name );
if ( $inestio_footer_present ) {
	inestio_storage_set( 'current_sidebar', 'footer' );
	$inestio_footer_wide = inestio_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $inestio_footer_name ) ) {
		dynamic_sidebar( $inestio_footer_name );
	}
	$inestio_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $inestio_out ) ) {
		$inestio_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $inestio_out );
		$inestio_need_columns = true;   //or check: strpos($inestio_out, 'columns_wrap')===false;
		if ( $inestio_need_columns ) {
			$inestio_columns = max( 0, (int) inestio_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $inestio_columns ) {
				$inestio_columns = min( 4, max( 1, inestio_tags_count( $inestio_out, 'aside' ) ) );
			}
			if ( $inestio_columns > 1 ) {
				$inestio_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $inestio_columns ) . ' widget', $inestio_out );
			} else {
				$inestio_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $inestio_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'inestio_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $inestio_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $inestio_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'inestio_action_before_sidebar', 'footer' );
				inestio_show_layout( $inestio_out );
				do_action( 'inestio_action_after_sidebar', 'footer' );
				if ( $inestio_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $inestio_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'inestio_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
