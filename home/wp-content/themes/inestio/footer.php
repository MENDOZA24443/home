<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package INESTIO
 * @since INESTIO 1.0
 */

							// Widgets area inside page content
							inestio_create_widgets_area( 'widgets_below_content' );
						
							?>
						</div><!-- /.content -->
						<?php

						// Show main sidebar
						get_sidebar();
						?>
					</div><!-- /.content_wrap -->
					<?php

					// Widgets area below page content and related posts below page content
					$inestio_body_style = inestio_get_theme_option( 'body_style' );
					$inestio_widgets_name = inestio_get_theme_option( 'widgets_below_page' );
					$inestio_show_widgets = ! inestio_is_off( $inestio_widgets_name ) && is_active_sidebar( $inestio_widgets_name );
					$inestio_show_related = is_single() && inestio_get_theme_option( 'related_position' ) == 'below_page';
					if ( $inestio_show_widgets || $inestio_show_related ) {
						if ( 'fullscreen' != $inestio_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $inestio_show_related ) {
							do_action( 'inestio_action_related_posts' );
						}

						// Widgets area below page content
						if ( $inestio_show_widgets ) {
							inestio_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $inestio_body_style ) {
							?>
							</div><!-- /.content_wrap -->
							<?php
						}
					}
					?>
			</div><!-- /.page_content_wrap -->
			<?php

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! is_singular( 'post' ) && ! is_singular( 'attachment' ) ) || ! in_array ( inestio_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="inestio_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'inestio_action_before_footer' );

				// Footer
				$inestio_footer_type = inestio_get_theme_option( 'footer_type' );
				if ( 'custom' == $inestio_footer_type && ! inestio_is_layouts_available() ) {
					$inestio_footer_type = 'default';
				}
				get_template_part( apply_filters( 'inestio_filter_get_template_part', "templates/footer-{$inestio_footer_type}" ) );

				do_action( 'inestio_action_after_footer' );

			}
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php wp_footer(); ?>

</body>
</html>