<?php
/**
 * The template to display Admin notices
 *
 * @package INESTIO
 * @since INESTIO 1.0.1
 */

$inestio_theme_slug = get_option( 'template' );
$inestio_theme_obj  = wp_get_theme( $inestio_theme_slug );

?>
<div class="inestio_admin_notice inestio_rate_notice update-nag">
	<?php
	// Theme image
	$inestio_theme_img = inestio_get_file_url( 'screenshot.jpg' );
	if ( '' != $inestio_theme_img ) {
		?>
		<div class="inestio_notice_image"><img src="<?php echo esc_url( $inestio_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'inestio' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="inestio_notice_title"><a href="<?php echo esc_url( inestio_storage_get( 'theme_rate_url' ) ); ?>" target="_blank">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Rate our theme "%s", please', 'inestio' ),
				$inestio_theme_obj->get( 'Name' ) . ( INESTIO_THEME_FREE ? ' ' . __( 'Free', 'inestio' ) : '' )
			)
		);
		?>
	</a></h3>
	<?php

	// Description
	?>
	<div class="inestio_notice_text">
		<p><?php echo wp_kses_data( __( "We are glad you chose our WP theme for your website. You've done well customizing your website and we hope that you've enjoyed working with our theme.", 'inestio' ) ); ?></p>
		<p><?php echo wp_kses_data( __( "It would be just awesome if you spend just a minute of your time to rate our theme or the customer service you've received from us.", 'inestio' ) ); ?></p>
		<p class="inestio_notice_text_info"><?php echo wp_kses_data( __( '* We love receiving your reviews! Every time you leave a review, our CEO Henry Rise gives $5 to homeless dog shelter! Save the planet with us!', 'inestio' ) ); ?></p>
	</div>
	<?php

	// Buttons
	?>
	<div class="inestio_notice_buttons">
		<?php
		// Link to the theme download page
		?>
		<a href="<?php echo esc_url( inestio_storage_get( 'theme_rate_url' ) ); ?>" class="button button-primary" target="_blank"><i class="dashicons dashicons-star-filled"></i> 
			<?php
			// Translators: Add theme name
			echo esc_html( sprintf( __( 'Rate theme %s', 'inestio' ), $inestio_theme_obj->name ) );
			?>
		</a>
		<?php
		// Link to the theme support
		?>
		<a href="<?php echo esc_url( inestio_storage_get( 'theme_support_url' ) ); ?>" class="button" target="_blank"><i class="dashicons dashicons-sos"></i> 
			<?php
			esc_html_e( 'Support', 'inestio' );
			?>
		</a>
		<?php
		// Link to the theme documentation
		?>
		<a href="<?php echo esc_url( inestio_storage_get( 'theme_doc_url' ) ); ?>" class="button" target="_blank"><i class="dashicons dashicons-book"></i> 
			<?php
			esc_html_e( 'Documentation', 'inestio' );
			?>
		</a>
		<?php
		// Dismiss
		?>
		<a href="#" data-notice="rate" class="inestio_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="inestio_hide_notice_text"><?php esc_html_e( 'Dismiss', 'inestio' ); ?></span></a>
	</div>
</div>
