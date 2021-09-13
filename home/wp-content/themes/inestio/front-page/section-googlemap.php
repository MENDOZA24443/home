<div class="front_page_section front_page_section_googlemap<?php
	$inestio_scheme = inestio_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! empty( $inestio_scheme ) && ! inestio_is_inherit( $inestio_scheme ) ) {
		echo ' scheme_' . esc_attr( $inestio_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( inestio_get_theme_option( 'front_page_googlemap_paddings' ) );
	if ( inestio_get_theme_option( 'front_page_googlemap_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$inestio_css      = '';
		$inestio_bg_image = inestio_get_theme_option( 'front_page_googlemap_bg_image' );
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
	$inestio_anchor_icon = inestio_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$inestio_anchor_text = inestio_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $inestio_anchor_icon ) || ! empty( $inestio_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $inestio_anchor_icon ) ? ' icon="' . esc_attr( $inestio_anchor_icon ) . '"' : '' )
									. ( ! empty( $inestio_anchor_text ) ? ' title="' . esc_attr( $inestio_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
		<?php
		$inestio_layout = inestio_get_theme_option( 'front_page_googlemap_layout' );
		echo ' front_page_section_layout_' . esc_attr( $inestio_layout );
		if ( inestio_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
			echo ' inestio-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
		"
			<?php
			$inestio_css      = '';
			$inestio_bg_mask  = inestio_get_theme_option( 'front_page_googlemap_bg_mask' );
			$inestio_bg_color_type = inestio_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $inestio_bg_color_type ) {
				$inestio_bg_color = inestio_get_theme_option( 'front_page_googlemap_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
		if ( 'fullwidth' != $inestio_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$inestio_caption     = inestio_get_theme_option( 'front_page_googlemap_caption' );
			$inestio_description = inestio_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $inestio_caption ) || ! empty( $inestio_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $inestio_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $inestio_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $inestio_caption ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $inestio_caption, 'inestio_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $inestio_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $inestio_description ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( wpautop( $inestio_description ), 'inestio_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $inestio_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$inestio_content = inestio_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $inestio_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $inestio_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $inestio_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $inestio_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $inestio_content, 'inestio_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $inestio_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $inestio_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
				<?php
				if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! inestio_exists_trx_addons() ) {
						inestio_customizer_need_trx_addons_message();
					} else {
						inestio_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
					}
				}
				?>
			</div>
			<?php

			if ( 'columns' == $inestio_layout && ( ! empty( $inestio_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
