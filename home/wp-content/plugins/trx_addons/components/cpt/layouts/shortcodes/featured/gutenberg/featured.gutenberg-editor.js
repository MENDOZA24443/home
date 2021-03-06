(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	// Register Block - Featured image
	blocks.registerBlockType(
		'trx-addons/layouts-featured',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Featured image' ),
			description: i18n.__( 'Insert featured with items number and totals to the custom layout' ),
			icon: 'format-image',
			category: 'trx-addons-layouts',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_param', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					height: {
						type: 'title',
						default: ''
					},
					align: {
						type: 'string',
						default: ''
					},
					content: {
						type: 'string',
						default: ''
					}
				},
				trx_addons_gutenberg_get_param_hide(true),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/layouts-featured' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'parent': true,
						'allowedblocks': TRX_ADDONS_STORAGE['gutenberg_allowed_blocks'],
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Layout
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select layout's type" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_featured'] ),
								},
								// Height of the block
								{
									'name': 'height',
									'title': i18n.__( 'Height of the block' ),
									'descr': i18n.__( "Specify height of this block. If empty - use default height" ),
									'type': 'text',
								},
								// Content alignment
								{
									'name': 'align',
									'title': i18n.__( 'Content alignment' ),
									'descr': i18n.__( "Select alignment of the inner content in this block" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] ),
								}
							], 'trx-addons/layouts-featured', props ), props )
						),
						'additional_params': el(
							'div', {},
							// Hide on devices params
							trx_addons_gutenberg_add_param_hide( props, true ),
							// ID, Class, CSS params
							trx_addons_gutenberg_add_param_id( props )
						)
					}, props
				);
			},
			save: function(props) {
				return el( wp.editor.InnerBlocks.Content, {} );
			}
		},
		'trx-addons/layouts-featured'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );