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
<div class="inestio_admin_notice inestio_welcome_notice update-nag">
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
	<h3 class="inestio_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'inestio' ),
				$inestio_theme_obj->get( 'Name' ) . ( INESTIO_THEME_FREE ? ' ' . __( 'Free', 'inestio' ) : '' ),
				$inestio_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="inestio_notice_text">
		<p class="inestio_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $inestio_theme_obj->description ) );
			?>
		</p>
		<p class="inestio_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'inestio' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="inestio_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=inestio_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'inestio' );
			?>
		</a>
		<?php		
		// Dismiss this notice
		?>
		<a href="#" data-notice="admin" class="inestio_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="inestio_hide_notice_text"><?php esc_html_e( 'Dismiss', 'inestio' ); ?></span></a>
	</div>
</div>
