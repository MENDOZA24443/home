<?php
$inestio_slider_sc = inestio_get_theme_option( 'front_page_title_shortcode' );
if ( ! empty( $inestio_slider_sc ) && strpos( $inestio_slider_sc, '[' ) !== false && strpos( $inestio_slider_sc, ']' ) !== false ) {

	?><div class="front_page_section front_page_section_title front_page_section_slider front_page_section_title_slider
		<?php
		if ( inestio_get_theme_option( 'front_page_title_stack' ) ) {
			echo ' sc_stack_section_on';
		}
		?>
	">
	<?php
		// Add anchor
		$inestio_anchor_icon = inestio_get_theme_option( 'front_page_title_anchor_icon' );
		$inestio_anchor_text = inestio_get_theme_option( 'front_page_title_anchor_text' );
	if ( ( ! empty( $inestio_anchor_icon ) || ! empty( $inestio_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
		echo do_shortcode(
			'[trx_sc_anchor id="front_page_section_title"'
									. ( ! empty( $inestio_anchor_icon ) ? ' icon="' . esc_attr( $inestio_anchor_icon ) . '"' : '' )
									. ( ! empty( $inestio_anchor_text ) ? ' title="' . esc_attr( $inestio_anchor_text ) . '"' : '' )
									. ']'
		);
	}
		// Show slider (or any other content, generated by shortcode)
		echo do_shortcode( $inestio_slider_sc );
	?>
	</div>
	<?php

} else {

	?>
	<div class="front_page_section front_page_section_title
		<?php
		$inestio_scheme = inestio_get_theme_option( 'front_page_title_scheme' );
		if ( ! empty( $inestio_scheme ) && ! inestio_is_inherit( $inestio_scheme ) ) {
			echo ' scheme_' . esc_attr( $inestio_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( inestio_get_theme_option( 'front_page_title_paddings' ) );
		if ( inestio_get_theme_option( 'front_page_title_stack' ) ) {
			echo ' sc_stack_section_on';
		}
		?>
		"
		<?php
		$inestio_css      = '';
		$inestio_bg_image = inestio_get_theme_option( 'front_page_title_bg_image' );
		if ( ! empty( $inestio_bg_image ) ) {
			$inestio_css .= 'background-image: url(' . esc_url( inestio_get_attachment_url( $inestio_bg_image ) ) . ');';
		}
		if ( ! empty( $inestio_css ) ) {
			echo ' style="' . esc_attr( $inestio_css ) . '"';
		}
		?>
	>
	<?php
		// Add anchor
		$inestio_anchor_icon = inestio_get_theme_option( 'front_page_title_anchor_icon' );
		$inestio_anchor_text = inestio_get_theme_option( 'front_page_title_anchor_text' );
	if ( ( ! empty( $inestio_anchor_icon ) || ! empty( $inestio_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
		echo do_shortcode(
			'[trx_sc_anchor id="front_page_section_title"'
									. ( ! empty( $inestio_anchor_icon ) ? ' icon="' . esc_attr( $inestio_anchor_icon ) . '"' : '' )
									. ( ! empty( $inestio_anchor_text ) ? ' title="' . esc_attr( $inestio_anchor_text ) . '"' : '' )
									. ']'
		);
	}
	?>
		<div class="front_page_section_inner front_page_section_title_inner
		<?php
		if ( inestio_get_theme_option( 'front_page_title_fullheight' ) ) {
			echo ' inestio-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
			"
			<?php
			$inestio_css      = '';
			$inestio_bg_mask  = inestio_get_theme_option( 'front_page_title_bg_mask' );
			$inestio_bg_color_type = inestio_get_theme_option( 'front_page_title_bg_color_type' );
			if ( 'custom' == $inestio_bg_color_type ) {
				$inestio_bg_color = inestio_get_theme_option( 'front_page_title_bg_color' );
			} elseif ( 'scheme_bg_color' == $inestio_bg_color_type ) {
				$inestio_bg_color = inestio_get_scheme_color( 'bg_color', $inestio_scheme );
			} else {
				$inestio_bg_color = '';
			}
			if ( ! empty( $inestio_bg_color ) && $inestio_bg_mask > 0 ) {
				$inestio_css .= 'background-color: ' . esc_attr(
					1 == $inestio_bg_mask ? $inestio_bg_color : inestio_hex2rgba( $inestio_bg_color, $inestio_bg_mask )
				) . ';';
			}
			if ( ! empty( $inestio_css ) ) {
				echo ' style="' . esc_attr( $inestio_css ) . '"';
			}
			?>
		>
			<div class="front_page_section_content_wrap front_page_section_title_content_wrap content_wrap">
				<?php
				// Caption
				$inestio_caption = inestio_get_theme_option( 'front_page_title_caption' );
				if ( ! empty( $inestio_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h1 class="front_page_section_caption front_page_section_title_caption front_page_block_<?php echo ! empty( $inestio_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $inestio_caption, 'inestio_kses_content' ); ?></h1>
					<?php
				}

				// Description (text)
				$inestio_description = inestio_get_theme_option( 'front_page_title_description' );
				if ( ! empty( $inestio_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_title_description front_page_block_<?php echo ! empty( $inestio_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $inestio_description ), 'inestio_kses_content' ); ?></div>
					<?php
				}

				// Buttons
				if ( inestio_get_theme_option( 'front_page_title_button1_link' ) != '' || inestio_get_theme_option( 'front_page_title_button2_link' ) != '' ) {
					?>
					<div class="front_page_section_buttons front_page_section_title_buttons">
					<?php
						inestio_show_layout( inestio_customizer_partial_refresh_front_page_title_button1_link() );
						inestio_show_layout( inestio_customizer_partial_refresh_front_page_title_button2_link() );
					?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php
}
