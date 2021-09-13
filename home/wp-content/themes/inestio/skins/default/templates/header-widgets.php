<?php
/**
 * The template to display the widgets area in the header
 *
 * @package INESTIO
 * @since INESTIO 1.0
 */

// Header sidebar
$inestio_header_name    = inestio_get_theme_option( 'header_widgets' );
$inestio_header_present = ! inestio_is_off( $inestio_header_name ) && is_active_sidebar( $inestio_header_name );
if ( $inestio_header_present ) {
	inestio_storage_set( 'current_sidebar', 'header' );
	$inestio_header_wide = inestio_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $inestio_header_name ) ) {
		dynamic_sidebar( $inestio_header_name );
	}
	$inestio_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $inestio_widgets_output ) ) {
		$inestio_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $inestio_widgets_output );
		$inestio_need_columns   = strpos( $inestio_widgets_output, 'columns_wrap' ) === false;
		if ( $inestio_need_columns ) {
			$inestio_columns = max( 0, (int) inestio_get_theme_option( 'header_columns' ) );
			if ( 0 == $inestio_columns ) {
				$inestio_columns = min( 6, max( 1, inestio_tags_count( $inestio_widgets_output, 'aside' ) ) );
			}
			if ( $inestio_columns > 1 ) {
				$inestio_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $inestio_columns ) . ' widget', $inestio_widgets_output );
			} else {
				$inestio_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $inestio_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'inestio_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $inestio_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $inestio_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'inestio_action_before_sidebar', 'header' );
				inestio_show_layout( $inestio_widgets_output );
				do_action( 'inestio_action_after_sidebar', 'header' );
				if ( $inestio_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $inestio_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'inestio_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
