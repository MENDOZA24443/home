<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package INESTIO
 * @since INESTIO 1.0
 */

if ( inestio_sidebar_present() ) {
	
	$inestio_sidebar_type = inestio_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $inestio_sidebar_type && ! inestio_is_layouts_available() ) {
		$inestio_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $inestio_sidebar_type ) {
		// Default sidebar with widgets
		$inestio_sidebar_name = inestio_get_theme_option( 'sidebar_widgets' );
		inestio_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $inestio_sidebar_name ) ) {
			dynamic_sidebar( $inestio_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$inestio_sidebar_id = inestio_get_custom_sidebar_id();
		do_action( 'inestio_action_show_layout', $inestio_sidebar_id );
	}
	$inestio_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $inestio_out ) ) {
		$inestio_sidebar_position    = inestio_get_theme_option( 'sidebar_position' );
		$inestio_sidebar_position_ss = inestio_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $inestio_sidebar_position );
			echo ' sidebar_' . esc_attr( $inestio_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $inestio_sidebar_type );

			if ( 'float' == $inestio_sidebar_position_ss ) {
				echo ' sidebar_float';
			}
			$inestio_sidebar_scheme = inestio_get_theme_option( 'sidebar_scheme' );
			if ( ! empty( $inestio_sidebar_scheme ) && ! inestio_is_inherit( $inestio_sidebar_scheme ) ) {
				echo ' scheme_' . esc_attr( $inestio_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="inestio_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'inestio_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $inestio_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$inestio_title = apply_filters( 'inestio_filter_sidebar_control_title', 'float' == $inestio_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'inestio' ) : '' );
				$inestio_text  = apply_filters( 'inestio_filter_sidebar_control_text', 'above' == $inestio_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'inestio' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $inestio_title ); ?>"><?php echo esc_html( $inestio_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'inestio_action_before_sidebar', 'sidebar' );
				inestio_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $inestio_out ) );
				do_action( 'inestio_action_after_sidebar', 'sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
			<?php

			do_action( 'inestio_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div><!-- /.sidebar -->
		<div class="clearfix"></div>
		<?php
	}
}
