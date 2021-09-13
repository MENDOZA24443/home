<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package INESTIO
 * @since INESTIO 1.0
 */

$inestio_template = apply_filters( 'inestio_filter_get_template_part', inestio_blog_archive_get_template() );

if ( ! empty( $inestio_template ) && 'index' != $inestio_template ) {

	get_template_part( $inestio_template );

} else {

	inestio_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$inestio_stickies  = is_home() ? get_option( 'sticky_posts' ) : false;
		$inestio_post_type = inestio_get_theme_option( 'post_type' );
		$inestio_args      = array(
								'blog_style'     => inestio_get_theme_option( 'blog_style' ),
								'post_type'      => $inestio_post_type,
								'taxonomy'       => inestio_get_post_type_taxonomy( $inestio_post_type ),
								'parent_cat'     => inestio_get_theme_option( 'parent_cat' ),
								'posts_per_page' => inestio_get_theme_option( 'posts_per_page' ),
								'sticky'         => inestio_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $inestio_stickies )
															&& count( $inestio_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		inestio_blog_archive_start();

		do_action( 'inestio_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'inestio_action_before_page_author' );
			get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'inestio_action_after_page_author' );
		}

		if ( inestio_get_theme_option( 'show_filters' ) ) {
			do_action( 'inestio_action_before_page_filters' );
			inestio_show_filters( $inestio_args );
			do_action( 'inestio_action_after_page_filters' );
		} else {
			do_action( 'inestio_action_before_page_posts' );
			inestio_show_posts( array_merge( $inestio_args, array( 'cat' => $inestio_args['parent_cat'] ) ) );
			do_action( 'inestio_action_after_page_posts' );
		}

		do_action( 'inestio_action_blog_archive_end' );

		inestio_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'inestio_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
