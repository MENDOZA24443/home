/* global jQuery:false */
/* global INESTIO_STORAGE:false */

(function() {
	"use strict";

		jQuery( window ).load( function() {
		"use strict";

				// Elementor Images
				jQuery('.elementor a img[class*="align"]').each(function(){
					if (jQuery(this).hasClass('alignright')) {
						jQuery(this).removeClass('alignright')
						jQuery(this).parent().addClass('alignright');
					}
					if (jQuery(this).hasClass('alignleft')) {
						jQuery(this).removeClass('alignleft')
						jQuery(this).parent().addClass('alignleft');
					}
				});
	});

	// Move data-scheme from contacts_wrap to widget_contacts
	jQuery( document ).ready( function() {
		"use strict";
		jQuery('.widget_contacts').each(function(){
			var attr = jQuery(this).find(".contacts_wrap").attr('data-scheme');
			if ( attr != '') {
				jQuery(this).addClass("scheme_"+attr );
			}

		});
	});

})();
