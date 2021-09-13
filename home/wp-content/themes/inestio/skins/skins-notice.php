<?php
/**
 * The template to display Admin notices
 *
 * @package INESTIO
 * @since INESTIO 1.0.64
 */

$inestio_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$inestio_skins_args = get_query_var( 'inestio_skins_notice_args' );

?>
<div class="inestio_admin_notice inestio_skins_notice update-nag">
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
		<?php esc_html_e( 'New skins available', 'inestio' ); ?>
	</h3>
	<?php

	// Description
	$inestio_total      = $inestio_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$inestio_skins_msg  = $inestio_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $inestio_total, 'inestio' ), $inestio_total ) . '</strong>'
							: '';
	$inestio_total      = $inestio_skins_args['free'];
	$inestio_skins_msg .= $inestio_total > 0
							? ( ! empty( $inestio_skins_msg ) ? ' ' . esc_html__( 'and', 'inestio' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $inestio_total, 'inestio' ), $inestio_total ) . '</strong>'
							: '';
	$inestio_total      = $inestio_skins_args['pay'];
	$inestio_skins_msg .= $inestio_skins_args['pay'] > 0
							? ( ! empty( $inestio_skins_msg ) ? ' ' . esc_html__( 'and', 'inestio' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $inestio_total, 'inestio' ), $inestio_total ) . '</strong>'
							: '';
	?>
	<div class="inestio_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'inestio' ), $inestio_skins_msg ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="inestio_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $inestio_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'inestio' );
			?>
		</a>
		<?php
		// Dismiss
		?>
		<a href="#" data-notice="skins" class="inestio_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="inestio_hide_notice_text"><?php esc_html_e( 'Dismiss', 'inestio' ); ?></span></a>
	</div>
</div>
