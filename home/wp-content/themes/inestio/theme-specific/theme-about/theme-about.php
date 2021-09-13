<?php
/**
 * Information about this theme
 *
 * @package INESTIO
 * @since INESTIO 1.0.30
 */


// Redirect to the 'About Theme' page after switch theme
if ( ! function_exists( 'inestio_about_after_switch_theme' ) ) {
	add_action( 'after_switch_theme', 'inestio_about_after_switch_theme', 1000 );
	function inestio_about_after_switch_theme() {
		update_option( 'inestio_about_page', 1 );
	}
}
if ( ! function_exists( 'inestio_about_after_setup_theme' ) ) {
	add_action( 'init', 'inestio_about_after_setup_theme', 1000 );
	function inestio_about_after_setup_theme() {
		if ( ! defined( 'WP_CLI' ) && get_option( 'inestio_about_page' ) == 1 ) {
			update_option( 'inestio_about_page', 0 );
			wp_safe_redirect( admin_url() . 'themes.php?page=inestio_about' );
			exit();
		} else {
			if ( inestio_get_value_gp( 'page' ) == 'inestio_about' && inestio_exists_trx_addons() ) {
				wp_safe_redirect( admin_url() . 'admin.php?page=trx_addons_theme_panel' );
				exit();
			}
		}
	}
}


// Add 'About Theme' item in the Appearance menu
if ( ! function_exists( 'inestio_about_add_menu_items' ) ) {
	add_action( 'admin_menu', 'inestio_about_add_menu_items' );
	function inestio_about_add_menu_items() {
		if ( ! inestio_exists_trx_addons() ) {
			$theme_slug  = get_option( 'template' );
			$theme_name  = wp_get_theme( $theme_slug )->get( 'Name' ) . ( INESTIO_THEME_FREE ? ' ' . esc_html__( 'Free', 'inestio' ) : '' );
			add_theme_page(
				// Translators: Add theme name to the page title
				sprintf( esc_html__( 'About %s', 'inestio' ), $theme_name ),
				// Translators: Add theme name to the menu title
				sprintf( esc_html__( 'About %s', 'inestio' ), $theme_name ),
				'manage_options',
				'inestio_about',
				'inestio_about_page_builder'
			);
		}
	}
}


// Load page-specific scripts and styles
if ( ! function_exists( 'inestio_about_enqueue_scripts' ) ) {
	add_action( 'admin_enqueue_scripts', 'inestio_about_enqueue_scripts' );
	function inestio_about_enqueue_scripts() {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;
		if ( ! empty( $screen->id ) && false !== strpos( $screen->id, '_page_inestio_about' ) ) {
			// Scripts
			if ( ! inestio_exists_trx_addons() && function_exists( 'inestio_plugins_installer_enqueue_scripts' ) ) {
				inestio_plugins_installer_enqueue_scripts();
			}
			// Styles
			$fdir = inestio_get_file_url( 'theme-specific/theme-about/theme-about.css' );
			if ( '' != $fdir ) {
				wp_enqueue_style( 'inestio-about', $fdir, array(), null );
			}
		}
	}
}


// Build 'About Theme' page
if ( ! function_exists( 'inestio_about_page_builder' ) ) {
	function inestio_about_page_builder() {
		$theme_slug = get_option( 'template' );
		$theme      = wp_get_theme( $theme_slug );
		?>
		<div class="inestio_about">

			<?php do_action( 'inestio_action_theme_about_start', $theme ); ?>

			<?php do_action( 'inestio_action_theme_about_before_logo', $theme ); ?>

			<div class="inestio_about_logo">
				<?php
				$logo = inestio_get_file_url( 'theme-specific/theme-about/icon.jpg' );
				if ( empty( $logo ) ) {
					$logo = inestio_get_file_url( 'screenshot.jpg' );
				}
				if ( ! empty( $logo ) ) {
					?>
					<img src="<?php echo esc_url( $logo ); ?>">
					<?php
				}
				?>
			</div>

			<?php do_action( 'inestio_action_theme_about_before_title', $theme ); ?>

			<h1 class="inestio_about_title">
			<?php
				echo esc_html(
					sprintf(
						// Translators: Add theme name and version to the 'Welcome' message
						__( 'Welcome to %1$s %2$s v.%3$s', 'inestio' ),
						$theme->get( 'Name' ),
						INESTIO_THEME_FREE ? __( 'Free', 'inestio' ) : '',
						$theme->get( 'Version' )
					)
				);
			?>
			</h1>

			<?php do_action( 'inestio_action_theme_about_before_description', $theme ); ?>

			<div class="inestio_about_description">
				<p>
					<?php
					echo wp_kses_data( __( 'In order to continue, please install and activate <b>ThemeREX Addons plugin</b>.', 'inestio' ) );
					?>
					<sup>*</sup>
				</p>
			</div>

			<?php do_action( 'inestio_action_theme_about_before_buttons', $theme ); ?>

			<div class="inestio_about_buttons">
				<?php inestio_plugins_installer_get_button_html( 'trx_addons' ); ?>
			</div>

			<?php do_action( 'inestio_action_theme_about_before_buttons', $theme ); ?>

			<div class="inestio_about_notes">
				<p>
					<sup>*</sup>
					<?php
					echo wp_kses_data( __( "<i>ThemeREX Addons plugin</i> will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options.", 'inestio' ) );
					?>
				</p>
			</div>

			<?php do_action( 'inestio_action_theme_about_end', $theme ); ?>

		</div>
		<?php
	}
}


// Hide TGMPA notice on the page 'About Theme'
if ( ! function_exists( 'inestio_about_page_disable_tgmpa_notice' ) ) {
	add_filter( 'tgmpa_show_admin_notice_capability', 'inestio_about_page_disable_tgmpa_notice' );
	function inestio_about_page_disable_tgmpa_notice($cap) {
		if ( inestio_get_value_gp( 'page' ) == 'inestio_about' ) {
			$cap = 'unfiltered_upload';
		}
		return $cap;
	}
}

require_once INESTIO_THEME_DIR . 'includes/plugins-installer/plugins-installer.php';
