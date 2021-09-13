<?php
/**
 * The Header: Logo and main menu
 *
 * @package INESTIO
 * @since INESTIO 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js
									<?php
										// Class scheme_xxx need in the <html> as context for the <body>!
										echo ' scheme_' . esc_attr( inestio_get_theme_option( 'color_scheme' ) );
									?>
										">
<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'inestio_action_before_body' );
	?>

	<div class="body_wrap">

		<div class="page_wrap">
			
			<?php
			$inestio_full_post_loading = ( is_singular( 'post' ) || is_singular( 'attachment' ) ) && inestio_get_value_gp( 'action' ) == 'full_post_loading';
			$inestio_prev_post_loading = ( is_singular( 'post' ) || is_singular( 'attachment' ) ) && inestio_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $inestio_full_post_loading && ! $inestio_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="inestio_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to content", 'inestio' ); ?></a>
				<?php if ( inestio_sidebar_present() ) { ?>
				<a class="inestio_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to sidebar", 'inestio' ); ?></a>
				<?php } ?>
				<a class="inestio_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to footer", 'inestio' ); ?></a>
				
				<?php
				do_action( 'inestio_action_before_header' );

				// Header
				$inestio_header_type = inestio_get_theme_option( 'header_type' );
				if ( 'custom' == $inestio_header_type && ! inestio_is_layouts_available() ) {
					$inestio_header_type = 'default';
				}
				get_template_part( apply_filters( 'inestio_filter_get_template_part', "templates/header-{$inestio_header_type}" ) );

				// Side menu
				if ( in_array( inestio_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/header-navi-mobile' ) );

				do_action( 'inestio_action_after_header' );

			}
			?>

			<div class="page_content_wrap">
				<?php
				do_action( 'inestio_action_page_content_wrap', $inestio_full_post_loading || $inestio_prev_post_loading );

				// Single posts banner
				if ( is_singular( 'post' ) || is_singular( 'attachment' ) ) {
					if ( $inestio_prev_post_loading ) {
						if ( inestio_get_theme_option( 'posts_navigation_scroll_which_block' ) != 'article' ) {
							do_action( 'inestio_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$inestio_path = apply_filters( 'inestio_filter_get_template_part', 'templates/single-styles/' . inestio_get_theme_option( 'single_style' ) );
					if ( inestio_get_file_dir( $inestio_path . '.php' ) != '' ) {
						get_template_part( $inestio_path );
					}
				}

				// Widgets area above page content
				$inestio_body_style   = inestio_get_theme_option( 'body_style' );
				$inestio_widgets_name = inestio_get_theme_option( 'widgets_above_page' );
				$inestio_show_widgets = ! inestio_is_off( $inestio_widgets_name ) && is_active_sidebar( $inestio_widgets_name );
				if ( $inestio_show_widgets ) {
					if ( 'fullscreen' != $inestio_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					inestio_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $inestio_body_style ) {
						?>
						</div><!-- </.content_wrap> -->
						<?php
					}
				}

				// Content area
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $inestio_body_style ? '_fullscreen' : ''; ?>">

					<div class="content">
						<?php
						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="inestio_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( is_singular( 'post' ) || is_singular( 'attachment' ) )
							&& $inestio_prev_post_loading 
							&& inestio_get_theme_option( 'posts_navigation_scroll_which_block' ) == 'article'
						) {
							do_action( 'inestio_action_between_posts' );
						}

						// Widgets area inside page content
						inestio_create_widgets_area( 'widgets_above_content' );
