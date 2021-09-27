<?php

require_once 'const.php';

//load lib
require_once 'lib/helpers-functions.php';

//load blog
require_once 'modules/blog/load.php';

//load shortcodes
require_once 'lib/news-abstract.php';
require_once 'lib/shortcode-functions.php';
require_once 'lib/shortcode-params-functions.php';
require_once 'lib/taxonomy-custom-fields.php';

//load reactions
require_once 'modules/reactions/load.php';

//load likes
require_once 'modules/like/load.php';

//Widgets
require_once 'modules/widgets/lib/widget-class.php';
require_once 'modules/widgets/lib/widget-loader.php';

//load custom styles
if(!function_exists('qode_news_load_custom_styles')) {
	function qode_news_load_custom_styles() {
		require_once 'assets/custom-styles/news.php';
	}
	add_action('after_setup_theme','qode_news_load_custom_styles');
}