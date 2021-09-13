<?php
/**
 * The template to display single post
 *
 * @package INESTIO
 * @since INESTIO 1.0
 */

// Full post loading
$full_post_loading        = inestio_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading        = inestio_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type   = inestio_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$inestio_related_position = inestio_get_theme_option( 'related_position' );

// Type of the prev/next posts navigation
$inestio_posts_navigation = inestio_get_theme_option( 'posts_navigation' );
$inestio_prev_post        = false;

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( inestio_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	inestio_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next posts navigation
	if ( 'scroll' == $inestio_posts_navigation ) {
		$inestio_prev_post = get_previous_post( true );         // Get post from same category
		if ( ! $inestio_prev_post ) {
			$inestio_prev_post = get_previous_post( false );    // Get post from any category
			if ( ! $inestio_prev_post ) {
				$inestio_posts_navigation = 'links';
			}
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $inestio_prev_post ) ) {
		inestio_sc_layouts_showed( 'featured', false );
		inestio_sc_layouts_showed( 'title', false );
		inestio_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $inestio_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/content', 'single-' . inestio_get_theme_option( 'single_style' ) ), 'single-' . inestio_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $inestio_related_position, 'inside' ) === 0 ) {
		$inestio_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'inestio_action_related_posts' );
		$inestio_related_content = ob_get_contents();
		ob_end_clean();

		$inestio_related_position_inside = max( 0, min( 9, inestio_get_theme_option( 'related_position_inside' ) ) );
		if ( 0 == $inestio_related_position_inside ) {
			$inestio_related_position_inside = mt_rand( 1, 9 );
		}

		$inestio_p_number = 0;
		$inestio_related_inserted = false;
		for ( $i = 0; $i < strlen( $inestio_content ) - 3; $i++ ) {
			if ( '<' == $inestio_content[ $i ] && 'p' == $inestio_content[ $i + 1 ] && in_array( $inestio_content[ $i + 2 ], array( '>', ' ' ) ) ) {
				$inestio_p_number++;
				if ( $inestio_related_position_inside == $inestio_p_number ) {
					$inestio_related_inserted = true;
					$inestio_content = ( $i > 0 ? substr( $inestio_content, 0, $i ) : '' )
										. $inestio_related_content
										. substr( $inestio_content, $i );
				}
			}
		}
		if ( ! $inestio_related_inserted ) {
			$inestio_content .= $inestio_related_content;
		}

		inestio_show_layout( $inestio_content );
	}

	// Comments
	do_action( 'inestio_action_before_comments' );
	comments_template();
	do_action( 'inestio_action_after_comments' );

	// Related posts
	if ( 'below_content' == $inestio_related_position
		&& ( 'scroll' != $inestio_posts_navigation || inestio_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || inestio_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'inestio_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $inestio_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $inestio_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $inestio_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $inestio_prev_post ) ); ?>">
		</div>
		<?php
	}
}

get_footer();
