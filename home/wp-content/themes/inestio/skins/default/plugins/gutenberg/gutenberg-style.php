<?php
// Add plugin-specific vars to the custom CSS
if ( ! function_exists( 'inestio_gutenberg_add_theme_vars' ) ) {
	add_filter( 'inestio_filter_add_theme_vars', 'inestio_gutenberg_add_theme_vars', 10, 2 );
	function inestio_gutenberg_add_theme_vars( $rez, $vars ) {
		return $rez;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'inestio_gutenberg_get_css' ) ) {
	add_filter( 'inestio_filter_get_css', 'inestio_gutenberg_get_css', 10, 2 );
	function inestio_gutenberg_get_css( $css, $args ) {

		if ( isset( $css['vars'] ) && isset( $args['vars'] ) ) {
			$vars         = $args['vars'];
			$css['vars'] .= <<<CSS
/* Editor area width for all post types */
.editor-block-list__block,
.editor-post-title__block,
.editor-default-block-appender {
	max-width: {$vars['content']} !important;
}
/* Editor area width for pages without sidebar */
body.sidebar_position_hide.expand_content .editor-block-list__block,
body.sidebar_position_hide.expand_content .editor-post-title__block,
body.sidebar_position_hide.expand_content .editor-default-block-appender {
	max-width: {$vars['page']} !important;
}
body.sidebar_position_hide.narrow_content .editor-block-list__block,
body.sidebar_position_hide.narrow_content .editor-post-title__block,
body.sidebar_position_hide.narrow_content .editor-default-block-appender {
	max-width: {$vars['content_narrow']} !important;
}
body.single-cpt_layouts .trx-addons-layout--single-preview {
	max-width: {$vars['page']} !important;
}
CSS;
		}

		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts                   = $args['fonts'];
			$fonts['p_font-family!'] = str_replace(';', ' !important;', $fonts['p_font-family']);
			$fonts['p_font-size!'] = str_replace(';', ' !important;', $fonts['p_font-size']);
			$css['fonts']           .= <<<CSS
body.edit-post-visual-editor {
	{$fonts['p_font-family!']}
	{$fonts['p_font-size']}
	{$fonts['p_font-weight']}
	{$fonts['p_font-style']}
	{$fonts['p_line-height']}
	{$fonts['p_text-decoration']}
	{$fonts['p_text-transform']}
	{$fonts['p_letter-spacing']}
}
.editor-post-title__block .editor-post-title__input {
	{$fonts['h1_font-family']}
	{$fonts['h1_font-size']}
	{$fonts['h1_font-weight']}
	{$fonts['h1_font-style']}
}
CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS
.editor-post-title__block .editor-post-title__input,
.editor-post-title__block .editor-post-title__input:focus {
	color: {$colors['text_dark']};	
}
.editor-post-sidebar-holder {
	background-color: {$colors['alter_bg_color']};	
}
.editor-post-sidebar-holder:before {
	color: {$colors['alter_text']};
}
.wp-block-nextpage > span {
	background-color: {$colors['bg_color']};
	color: {$colors['text_dark']};
}

.wp-block-cover .wp-block-cover-text a {
	color: {$colors['extra_dark']};
}

.wp-block-cover .wp-block-cover-text a:hover {
	color: {$colors['text_hover']};
}

CSS;
		}

		return $css;
	}
}

