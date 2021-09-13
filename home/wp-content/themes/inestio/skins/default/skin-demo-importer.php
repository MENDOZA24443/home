<?php
/**
 * Skin Demo importer
 *
 * @package INESTIO
 * @since INESTIO 1.76.0
 */


// Theme storage
//-------------------------------------------------------------------------

inestio_storage_set( 'theme_demo_url', '//inestio.axiomthemes.com' );


//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'inestio_skin_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'inestio_skin_importer_set_options', 9 );
	function inestio_skin_importer_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			$options['files']['default']['title']       = esc_html__( 'Inestio Demo', 'inestio' );
			$options['files']['default']['domain_dev']  = esc_url( inestio_get_protocol() . '://inestio.axiomthemes.com' );    // Developers domain
			$options['files']['default']['domain_demo'] = inestio_storage_get( 'theme_demo_url' );                            // Demo-site domain
			if ( substr( $options['files']['default']['domain_demo'], 0, 2 ) === '//' ) {
				$options['files']['default']['domain_demo'] = inestio_get_protocol() . ':' . $options['files']['default']['domain_demo'];
			}
		}
		return $options;
	}
}


//------------------------------------------------------------------------
// OCDI support
//------------------------------------------------------------------------

// Set theme specific OCDI options
if ( ! function_exists( 'inestio_skin_ocdi_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'inestio_skin_ocdi_set_options', 9 );
	function inestio_skin_ocdi_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Demo-site domain
			$options['files']['ocdi']['title']       = esc_html__( 'Inestio OCDI Demo', 'inestio' );
			$options['files']['ocdi']['domain_demo'] = inestio_storage_get( 'theme_demo_url' );
			if ( substr( $options['files']['ocdi']['domain_demo'], 0, 2 ) === '//' ) {
				$options['files']['ocdi']['domain_demo'] = inestio_get_protocol() . ':' . $options['files']['ocdi']['domain_demo'];
			}
			// If theme need more demo - just copy 'default' and change required parameters
		}
		return $options;
	}
}
