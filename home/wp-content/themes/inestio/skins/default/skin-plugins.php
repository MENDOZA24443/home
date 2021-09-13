<?php
/**
 * Required plugins
 *
 * @package INESTIO
 * @since INESTIO 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$inestio_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'inestio' ),
	'page_builders' => esc_html__( 'Page Builders', 'inestio' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'inestio' ),
	'socials'       => esc_html__( 'Socials and Communities', 'inestio' ),
	'events'        => esc_html__( 'Events and Appointments', 'inestio' ),
	'content'       => esc_html__( 'Content', 'inestio' ),
	'other'         => esc_html__( 'Other', 'inestio' ),
);
$inestio_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'inestio' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'inestio' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $inestio_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'inestio' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'inestio' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $inestio_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'inestio' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'inestio' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $inestio_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'inestio' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'inestio' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $inestio_theme_required_plugins_groups['page_builders'],
	),
	'vc-extensions-bundle'       => array(
		'title'       => esc_html__( 'WPBakery PageBuilder extensions bundle', 'inestio' ),
		'description' => esc_html__( "Many shortcodes for the WPBakery PageBuilder", 'inestio' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'vc-extensions-bundle.png',
		'group'       => $inestio_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'inestio' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'inestio' ),
		'required'    => false,
		'install'     => false,    
		'logo'        => 'woocommerce.png',
		'group'       => $inestio_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'inestio' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'inestio' ),
		'required'    => false,
		'install'     => false,    
		'logo'        => 'elegro-payment.png',
		'group'       => $inestio_theme_required_plugins_groups['ecommerce'],
	),
	'easy-digital-downloads'     => array(
		'title'       => esc_html__( 'Easy Digital Downloads', 'inestio' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'easy-digital-downloads.png',
		'group'       => $inestio_theme_required_plugins_groups['ecommerce'],
	),
	'give'                       => array(
		'title'       => esc_html__( 'Give', 'inestio' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'give.png',
		'group'       => $inestio_theme_required_plugins_groups['ecommerce'],
	),
	'bbpress'                    => array(
		'title'       => esc_html__( 'BBPress and BuddyPress', 'inestio' ),
		'description' => '',
		'required'    => false,
		'install'     => false,    
		'logo'        => 'bbpress.png',
		'group'       => $inestio_theme_required_plugins_groups['socials'],
	),
	'instagram-feed'             => array(
		'title'       => esc_html__( 'Instagram Feed', 'inestio' ),
		'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'inestio' ),
		'required'    => false,
		'install'     => false,    
		'logo'        => 'instagram-feed.png',
		'group'       => $inestio_theme_required_plugins_groups['socials'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'inestio' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'inestio' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $inestio_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'inestio' ),
		'description' => '',
		'required'    => false,
		'install'     => false,    
		'logo'        => 'booked.png',
		'group'       => $inestio_theme_required_plugins_groups['events'],
	),
	'content_timeline'           => array(
		'title'       => esc_html__( 'Content Timeline', 'inestio' ),
		'description' => '',
		'required'    => false,
		'install'     => false,    
		'logo'        => 'content_timeline.png',
		'group'       => $inestio_theme_required_plugins_groups['events'],
	),
	'mp-timetable'               => array(
		'title'       => esc_html__( 'MP Time Table', 'inestio' ),
		'description' => '',
		'required'    => false,
		'install'     => false,    
		'logo'        => 'mp-timetable.png',
		'group'       => $inestio_theme_required_plugins_groups['events'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'inestio' ),
		'description' => '',
		'required'    => false,
		'install'     => false,    
		'logo'        => 'the-events-calendar.png',
		'group'       => $inestio_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'inestio' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'inestio' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $inestio_theme_required_plugins_groups['content'],
	),
	'calculated-fields-form'     => array(
		'title'       => esc_html__( 'Calculated Fields Form', 'inestio' ),
		'description' => '',
		'required'    => false,
		'install'     => false,    
		'logo'        => 'calculated-fields-form.png',
		'group'       => $inestio_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'inestio' ),
		'description' => '',
		'required'    => true,
		'install'     => true,  
		'logo'        => 'essential-grid.png',
		'group'       => $inestio_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'inestio' ),
		'description' => '',
		'required'    => true,
		'install'     => true, 
		'logo'        => 'revslider.png',
		'group'       => $inestio_theme_required_plugins_groups['content'],
	),
	'ubermenu'                   => array(
		'title'       => esc_html__( 'UberMenu', 'inestio' ),
		'description' => esc_html__( "Popular MenuBuilder which allows you to create excellent menus", 'inestio' ),
		'required'    => false,
		'install'     => false,    
		'logo'        => 'ubermenu.png',
		'group'       => $inestio_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'inestio' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'inestio' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $inestio_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'WP GDPR Compliance', 'inestio' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'inestio' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $inestio_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'inestio' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'inestio' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $inestio_theme_required_plugins_groups['other'],
	),
	'trx_popup'                  => array(
		'title'       => esc_html__( 'ThemeREX Popup', 'inestio' ),
		'description' => esc_html__( "Add popup to your site.", 'inestio' ),
		'required'    => false,
		'logo'        => 'trx_popup.png',
		'group'       => $inestio_theme_required_plugins_groups['other'],
	),
	'envato-market'              => array(
		'title'       => esc_html__( 'Envato Market', 'inestio' ),
		'description' => '',
		'required'    => false,
		'install'     => false,    
		'logo'        => 'envato-market.png',
		'group'       => $inestio_theme_required_plugins_groups['other'],
	)
);

if ( INESTIO_THEME_FREE ) {
	unset( $inestio_theme_required_plugins['js_composer'] );
	unset( $inestio_theme_required_plugins['vc-extensions-bundle'] );
	unset( $inestio_theme_required_plugins['easy-digital-downloads'] );
	unset( $inestio_theme_required_plugins['give'] );
	unset( $inestio_theme_required_plugins['bbpress'] );
	unset( $inestio_theme_required_plugins['booked'] );
	unset( $inestio_theme_required_plugins['content_timeline'] );
	unset( $inestio_theme_required_plugins['mp-timetable'] );
	unset( $inestio_theme_required_plugins['learnpress'] );
	unset( $inestio_theme_required_plugins['the-events-calendar'] );
	unset( $inestio_theme_required_plugins['calculated-fields-form'] );
	unset( $inestio_theme_required_plugins['essential-grid'] );
	unset( $inestio_theme_required_plugins['revslider'] );
	unset( $inestio_theme_required_plugins['ubermenu'] );
	unset( $inestio_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $inestio_theme_required_plugins['envato-market'] );
	unset( $inestio_theme_required_plugins['trx_updater'] );
	unset( $inestio_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
inestio_storage_set( 'required_plugins', $inestio_theme_required_plugins );
