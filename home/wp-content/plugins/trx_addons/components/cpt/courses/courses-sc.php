<?php
/**
 * ThemeREX Addons Custom post type: Courses (Shortcodes)
 *
 * @package ThemeREX Addons
 * @since v1.2
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	exit;
}


// trx_sc_courses
//-------------------------------------------------------------
/*
[trx_sc_courses id="unique_id" type="default" cat="category_slug or id" count="3" columns="3" slider="0|1"]
*/
if ( !function_exists( 'trx_addons_sc_courses' ) ) {
	function trx_addons_sc_courses($atts, $content=null) {	

		// Exit to prevent recursion
		if (trx_addons_sc_stack_check('trx_sc_courses')) return '';

		$atts = trx_addons_sc_prepare_atts('trx_sc_courses', $atts, trx_addons_sc_common_atts('id,title,slider,query', array(
			// Individual params
			"type" => "default",
			"past" => "0",
			"no_margin" => 0,
			"more_text" => esc_html__('More info', 'trx_addons'),
			"pagination" => "none",
			"page" => 1,
			'posts_exclude' => '',	// comma-separated list of IDs to exclude from output
			))
		);

		if (!empty($atts['ids'])) {
			if ( is_array( $atts['ids'] ) ) {
				$atts['ids'] = join(',', $atts['ids']);
			}
			$atts['ids'] = str_replace(array(';', ' '), array(',', ''), $atts['ids']);
			$atts['count'] = count(explode(',', $atts['ids']));
		}
		$atts['count'] = max(1, (int) $atts['count']);
		$atts['offset'] = max(0, (int) $atts['offset']);
		if (empty($atts['orderby'])) $atts['orderby'] = 'courses_date';
		if (empty($atts['order'])) $atts['order'] = 'desc';
		$atts['slider'] = max(0, (int) $atts['slider']);
		if ($atts['slider'] > 0 && (int) $atts['slider_pagination'] > 0) $atts['slider_pagination'] = 'bottom';
		if ($atts['slider'] > 0) $atts['pagination'] = 'none';

		// Load CPT-specific scripts and styles
		trx_addons_cpt_courses_load_scripts_front( true );

		// Load template
		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT . 'courses/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT . 'courses/tpl.default.php'
										),
									'trx_addons_args_sc_courses',
									$atts
									);
		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_courses', $atts, $content);
	}
}


// Add shortcode [trx_sc_courses]
if (!function_exists('trx_addons_sc_courses_add_shortcode')) {
	function trx_addons_sc_courses_add_shortcode() {
		add_shortcode("trx_sc_courses", "trx_addons_sc_courses");
	}
	add_action('init', 'trx_addons_sc_courses_add_shortcode', 20);
}
