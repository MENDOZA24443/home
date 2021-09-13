<?php
//Allowed components
$components = array(
		'components_present' => 1,
		'components_api_elementor' => 1,
		'components_api_gutenberg' => 1,
		'components_api_js_composer' => 0,
		'components_api_vc-extensions-bundle' => 1,
		'components_api_bbpress' => 0,
		'components_api_booked' => 0,
		'components_api_calculated-fields-form' => 0,
		'components_api_contact-form-7' => 1,
		'components_api_content_timeline' => 0,
		'components_api_easy-digital-downloads' => 0,
		'components_api_elegro-payment' => 1,
		'components_api_essential-grid' => 1,
		'components_api_give' => 0,
		'components_api_instagram-feed' => 0,
		'components_api_learnpress' => 0,
		'components_api_mailchimp-for-wp' => 1,
		'components_api_mp-timetable' => 0,
		'components_api_powerkit' => 0,
		'components_api_revslider' => 1,
		'components_api_the-events-calendar' => 0,
		'components_api_the-events-calendar_layouts_sc' => array(
				'default' => 1,
				'detailed' => 1,
				'classic' => 1
				),
		'components_api_tourmaster' => 0,
		'components_api_trx_donations' => 0,
		'components_api_twitter' => 0,
		'components_api_ubermenu' => 1,
		'components_api_woocommerce' => 1,
		'components_api_sitepress-multilingual-cms' => 1,
		'components_api_wp-gdpr-compliance' => 1,
		'components_api_trx_popup' => 1,
		'components_cpt_cars' => 0,
		'components_cpt_cars_layouts_arh' => array(
				'default_1' => 1,
				'default_2' => 1,
				'default_3' => 1
				),
		'components_cpt_cars_layouts_sc' => array(
				'default' => 1,
				'slider' => 1
				),
		'components_cpt_certificates' => 0,
		'components_cpt_courses' => 0,
		'components_cpt_courses_layouts_arh' => array(
				'default_2' => 1,
				'default_3' => 1
				),
		'components_cpt_dishes' => 0,
		'components_cpt_dishes_layouts_arh' => array(
				'default_2' => 1,
				'default_3' => 1
				),
		'components_cpt_dishes_layouts_sc' => array(
				'default' => 1,
				'float' => 1,
				'compact' => 1
				),
		'components_cpt_layouts' => 1,
		'components_cpt_layouts_layouts_sc' => array(
				'blog_item' => 1,
				'cart' => 0,
				'container' => 1,
				'currency' => 0,
				'featured' => 1,
				'iconed_text' => 1,
				'layouts' => 1,
				'language' => 0,
				'login' => 1,
				'logo' => 1,
				'menu' => 1,
				'meta' => 1,
				'search' => 1,
				'title' => 1,
				'widgets' => 1
				),
		'components_cpt_portfolio' => 1,
		'components_cpt_portfolio_layouts_arh' => array(
				'default_2' => 1,
				'default_3' => 1
				),
		'components_cpt_properties' => 0,
		'components_cpt_properties_layouts_arh' => array(
				'default_1' => 1,
				'default_2' => 1,
				'default_3' => 1
				),
		'components_cpt_properties_layouts_sc' => array(
				'default' => 1,
				'slider' => 1,
				'map' => 1
				),
		'components_cpt_resume' => 0,
		'components_cpt_services' => 1,
		'components_cpt_services_layouts_arh' => array(
				'default_2' => 1,
				'default_3' => 1,
				'light_2' => 0,
				'light_3' => 0,
				'callouts_2' => 0,
				'callouts_3' => 0,
				'chess_1' => 1,
				'chess_2' => 1,
				'hover_2' => 0,
				'hover_3' => 1,
				'iconed_2' => 1,
				'iconed_3' => 1
				),
		'components_cpt_services_layouts_sc' => array(
				'default' => 1,
				'light' => 1,
				'iconed' => 0,
				'callouts' => 0,
				'list' => 0,
				'hover' => 0,
				'chess' => 1,
				'timeline' => 0,
				'tabs' => 0,
				'tabs_simple' => 0
				),
		'components_cpt_sport' => 0,
		'components_cpt_sport_layouts_arh' => array(
				'default_2' => 1,
				'default_3' => 1
				),
		'components_cpt_team' => 1,
		'components_cpt_team_layouts_arh' => array(
				'default_2' => 1,
				'default_3' => 1
				),
		'components_cpt_team_layouts_sc' => array(
				'default' => 0,
				'short' => 0,
				'featured' => 1
				),
		'components_cpt_testimonials' => 1,
		'components_cpt_testimonials_layouts_sc' => array(
				'default' => 1,
				'simple' => 1
				),
		'components_sc_action' => 1,
		'components_sc_action_layouts_sc' => array(
				'default' => 1,
				'simple' => 0,
				'event' => 0
				),
		'components_sc_anchor' => 0,
		'components_sc_accordionposts' => 0,
		'components_sc_blogger' => 1,
		'components_sc_blogger_layouts_sc' => array(
				'default' => 1,
				'wide' => 1,
				'list' => 1,
				'news' => 0
				),
		'components_sc_button' => 1,
		'components_sc_button_layouts_sc' => array(
				'default' => 1,
				'bordered' => 1,
				'simple' => 1,
				'transparent' => 1
				),
		'components_sc_countdown' => 0,
		'components_sc_countdown_layouts_sc' => array(
				'default' => 1,
				'circle' => 1
				),
		'components_sc_form' => 0,
		'components_sc_form_layouts_sc' => array(
				'default' => 1,
				'modern' => 1,
				'detailed' => 1
				),
		'components_sc_googlemap' => 1,
		'components_sc_googlemap_layouts_sc' => array(
				'default' => 1,
				'detailed' => 0
				),
		'components_sc_icons' => 1,
		'components_sc_icons_layouts_sc' => array(
				'default' => 1,
				'modern' => 1
				),
		'components_sc_osmap' => 0,
		'components_sc_osmap_layouts_sc' => array(
				'default' => 1,
				'detailed' => 1
				),
		'components_sc_price' => 1,
		'components_sc_promo' => 0,
		'components_sc_promo_layouts_sc' => array(
				'default' => 1,
				'modern' => 1,
				'blockquote' => 1
				),
		'components_sc_skills' => 1,
		'components_sc_skills_layouts_sc' => array(
				'pie' => 1,
				'counter' => 1
				),
		'components_sc_supertitle' => 1,
		'components_sc_socials' => 1,
		'components_sc_socials_layouts_sc' => array(
				'default' => 1,
				'names' => 0,
				'icons_names' => 0
				),
		'components_sc_table' => 1,
		'components_sc_title' => 1,
		'components_sc_title_layouts_sc' => array(
				'default' => 1,
				'shadow' => 0,
				'accent' => 0,
				'gradient' => 0
				),
		'components_sc_yandexmap' => 0,
		'components_sc_yandexmap_layouts_sc' => array(
				'default' => 1,
				'detailed' => 1
				),
		'components_widgets_aboutme' => 0,
		'components_widgets_audio' => 1,
		'components_widgets_banner' => 1,
		'components_widgets_calendar' => 1,
		'components_widgets_categories_list' => 0,
		'components_widgets_categories_list_layouts_sc' => array(
				'1' => 1,
				'2' => 1,
				'3' => 1
				),
		'components_widgets_contacts' => 1,
		'components_widgets_custom_links' => 0,
		'components_widgets_flickr' => 0,
		'components_widgets_instagram' => 0,
		'components_widgets_popular_posts' => 1,
		'components_widgets_recent_news' => 0,
		'components_widgets_recent_news_layouts_sc' => array(
				'news-announce' => 1,
				'news-excerpt' => 1,
				'news-magazine' => 1,
				'news-portfolio' => 1
				),
		'components_widgets_recent_posts' => 0,
		'components_widgets_slider' => 1,
		'components_widgets_slider_layouts_sc' => array(
				'default' => 1,
				'modern' => 0
				),
		'components_widgets_socials' => 1,
		'components_widgets_twitter' => 0,
		'components_widgets_twitter_layouts_sc' => array(
				'list' => 1,
				'default' => 1
				),
		'components_widgets_video' => 1,
		'components_widgets_video_list' => 0,
		'components_widgets_rating_posts' => 0,
		'components_components_dashboard_widget' => 1,
		'components_components_editor' => 1,
		'components_components_extended-taxonomy' => 1,
		'components_components_reviews' => 1,
		'components_components_web_push' => 0,
		'components_api_trx_addons' => 1,
		'components_api_trx_updater' => 1,
		'components_api_envato-market' => 1
		);
?>