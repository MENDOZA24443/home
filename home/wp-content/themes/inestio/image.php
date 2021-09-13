<?php
/**
 * The template to display the attachment
 *
 * @package INESTIO
 * @since INESTIO 1.0
 */


get_header();

while ( have_posts() ) {
	the_post();

	// Display post's content
	get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/content', 'single-' . inestio_get_theme_option( 'single_style' ) ), 'single-' . inestio_get_theme_option( 'single_style' ) );

	// Parent post navigation.
	$inestio_posts_navigation = inestio_get_theme_option( 'posts_navigation' );
	if ( 'links' == $inestio_posts_navigation ) {
		?>
		<div class="nav-links-single<?php
			if ( ! inestio_is_off( inestio_get_theme_option( 'posts_navigation_fixed' ) ) ) {
				echo ' nav-links-fixed fixed';
			}
		?>">
			<?php
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-arrow"></span>'
						. '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Published in', 'inestio' ) . '</span> '
						. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'inestio' ) . '</span> '
						. '<h5 class="post-title">%title</h5>'
						. '<span class="post_date">%date</span>',
				)
			);
			?>
		</div>
		<?php
	}

	// Comments
	do_action( 'inestio_action_before_comments' );
	comments_template();
	do_action( 'inestio_action_after_comments' );
}

get_footer();
