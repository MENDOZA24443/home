<?php
/**
 * The template 'Style 4' to displaying related posts
 *
 * @package INESTIO
 * @since INESTIO 1.0.54
 */

$inestio_link        = get_permalink();
$inestio_post_format = get_post_format();
$inestio_post_format = empty( $inestio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $inestio_post_format );

?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $inestio_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<div class="post_header entry-header">
		<h6 class="post_title entry-title"><a href="<?php echo esc_url( $inestio_link ); ?>"><?php
			if ( '' == get_the_title() ) {
				esc_html_e( '- No title -', 'inestio' );
			} else {
				the_title();
			}
		?></a></h6>
		<?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			?>
			<div class="post_meta">
				<a href="<?php echo esc_url( $inestio_link ); ?>" class="post_meta_item post_date"><span class="icon-clock"></span><?php echo wp_kses_data( inestio_get_date() ); ?></a>
			</div>
			<?php
		}
		?>
	</div>
</div>
