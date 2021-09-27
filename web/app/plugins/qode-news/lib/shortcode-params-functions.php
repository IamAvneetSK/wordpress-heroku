<?php
/**
 *
 * General Group Visual Composer options for News Shortcodes
 *
 */

if (!function_exists('qode_news_get_general_shortcode_params')) {

    /**
     * Function that returns array of general predefined params formatted for Visual Composer
     *
     * @return array of params
     *
     */

    function qode_news_get_general_shortcode_params($exclude_options = array()) {

        $params_array = array();

        // General Options - start

        $params_array[] = array(
            'type' => 'textfield',
            'heading' => esc_html__('Extra Class Name','qode-news'),
            'param_name' => 'extra_class_name',
            'group' => esc_html__('General','qode-news')
        );

        $params_array[] = array(
            'type' => 'textfield',
            'heading' => esc_html__('Number of Posts','qode-news'),
            'param_name' => 'posts_per_page',
            'value' => '6',
            'save_always' => true,
            'group' => esc_html__('General','qode-news')
        );

        $params_array[] = array(
            'type' => 'dropdown',
            'heading' => esc_html__('Number of Columns','qode-news'),
            'param_name' => 'column_number',
            'value' => array(
                '' => '',
                esc_html__('One','qode-news') => 1,
                esc_html__('Two','qode-news') => 2,
                esc_html__('Three','qode-news') => 3,
                esc_html__('Four','qode-news') => 4,
                //esc_html__('Five','qode-news') => 5,
                //esc_html__('Six','qode-news') => 6
            ),
            'group' => esc_html__('General','qode-news')
        );

        $params_array[] = array(
            'type' => 'dropdown',
            'heading' => esc_html__('Block Proportion','qode-news'),
            'param_name' => 'block_proportion',
            'value' => array(
                '1/2+1/2' => 'two-half',
                '2/3+1/3' => 'two-third-one-third',
                '1/3+2/3' => 'one-third-two-third',
                '3/4+1/4' => 'three-fourths-one-fourth',
            ),
            'save_always' => true,
            'group' => esc_html__('General','qode-news')
        );

        $params_array[] = array(
            'type' => 'dropdown',
            'heading' => esc_html__('Space Between Items','qode-news'),
            'param_name' => 'space_between_items',
            'value' => array(
                esc_html__('Medium', 'qode-news') => 'normal',
                esc_html__('Small', 'qode-news') => 'small',
                esc_html__('Tiny', 'qode-news') => 'tiny',
                esc_html__('None', 'qode-news') => 'no',
            ),
            'save_always' => true,
            'group' => esc_html__('General','qode-news')
        );

        $params_array[] = array(
            'type' => 'autocomplete',
            'heading' => esc_html__('Category','qode-news'),
            'param_name' => 'category_name',
            'settings'    => array(
                'multiple'      => true,
                'sortable'      => true,
                'unique_values' => true
            ),
            'description' => esc_html__('Enter the categories of the posts you want to display (leave empty for showing all categories)','qode-news'),
            'group' => esc_html__('General','qode-news')
        );

        $params_array[] = array(
            'type' => 'autocomplete',
            'heading' => esc_html__('Author','qode-news'),
            'param_name' => 'author_id',
            'settings'    => array(
                'multiple'      => true,
                'sortable'      => true,
                'unique_values' => true
            ),
            'description' => esc_html__('Enter the authors of the posts you want to display (leave empty for showing all authors)','qode-news'),
            'group' => esc_html__('General','qode-news')
        );

        $params_array[] = array(
            'type' => 'autocomplete',
            'heading' => esc_html__('Tag','qode-news'),
            'param_name' => 'tag',
            'settings'    => array(
                'multiple'      => true,
                'sortable'      => true,
                'unique_values' => true
            ),
            'description' => esc_html__('Enter the tags of the posts you want to display (leave empty for showing all tags)','qode-news'),
            'group' => esc_html__('General','qode-news')
        );

        $params_array[] = array(
            'type' => 'autocomplete',
            'heading' => esc_html__('Include Posts','qode-news'),
            'param_name' => 'post_in',
            'settings'    => array(
                'multiple'      => true,
                'sortable'      => true,
                'unique_values' => true
            ),
            'description' => esc_html__('Enter the IDs or Titles of the posts you want to display','qode-news'),
            'group' => esc_html__('General','qode-news')
        );

        $params_array[] = array(
            'type' => 'autocomplete',
            'heading' => esc_html__('Exclude Posts','qode-news'),
            'param_name' => 'post_not_in',
            'settings'    => array(
                'multiple'      => true,
                'sortable'      => true,
                'unique_values' => true
            ),
            'description' => esc_html__('Enter the IDs or Titles of the posts you want to exclude','qode-news'),
            'group' => esc_html__('General','qode-news')
        );

        $params_array[] = array(
            'type' => 'dropdown',
            'heading' => esc_html__('Sort','qode-news'),
            'param_name' => 'sort',
            'value' => array(
                '' => '',
                esc_html__('Latest','qode-news') => 'latest',
                esc_html__('Random','qode-news') => 'random',
                esc_html__('Random Posts Today','qode-news') => 'random_today',
                esc_html__('Random in Last 7 Days','qode-news') => 'random_seven_days',
                esc_html__('Most Commented','qode-news') => 'comments',
                esc_html__('Title','qode-news') => 'title',
                esc_html__('Popular','qode-news') => 'popular',
                esc_html__('Featured Posts First','qode-news') => 'featured_first',
                esc_html__('Trending Posts First','qode-news') => 'trending_first',
                esc_html__('Hot Posts First','qode-news') => 'hot_first',
                esc_html__('By Reaction','qode-news') => 'reactions'
            ),
            'description' => '',
            'group' => esc_html__('General','qode-news')
        );

        $params_array[] = array(
            'type' => 'autocomplete',
            'heading' => esc_html__('Reaction','qode-news'),
            'param_name' => 'reaction',
            'settings'    => array(
                'multiple'      => false,
                'sortable'      => true,
                'unique_values' => true
            ),
            'dependency'    => array(
                'element' => 'sort',
                'value' => array(
                    'reactions'
                )
            ),
            'description' => esc_html__('Choose the reaction which you would like to use for sorting your posts. The posts that have the greatest number of your chosen reaction will be displayed first.','qode-news'),
            'group' => esc_html__('General','qode-news')
        );

	    $params_array[] = array(
		    'type'       => 'dropdown',
		    'param_name' => 'order',
		    'heading'    => esc_html__('Order', 'qode-news'),
		    'value'      => array_flip(bridge_qode_get_query_order_array()),
            'dependency'    => array(
                'element' => 'sort',
                'value' => array(
                    'title'
                )
            ),
            'save_always' => true,
            'group' => esc_html__('General','qode-news')
	    );

        $params_array[] = array(
            'type'       => 'textfield',
            'param_name' => 'offset',
            'heading'    => esc_html__('Offset', 'qode-news'),
            'save_always' => true,
            'group' => esc_html__('General','qode-news')
        );

        $params_array[] = array(
            'type' => 'dropdown',
            'heading' => esc_html__('Show Filter','qode-news'),
            'param_name' => 'show_filter',
			'value' => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' => esc_html__('General','qode-news')
        );


        $params_array[] = array(
            'type' => 'dropdown',
            'heading' => esc_html__('Filter By','qode-news'),
            'param_name' => 'filter_by',
            'value' => array(
                esc_html__('Category','qode-news') => 'category',
                esc_html__('Tag','qode-news') => 'tag',
            ),
            'save_always' => true,
            'dependency' => array('element' => 'show_filter', 'value' => 'yes'),
            'group' => esc_html__('General','qode-news')
        );

        $params_array[] = array(
            'type' => 'textfield',
            'heading' => esc_html__('Layout Title','qode-news'),
            'param_name' => 'layout_title',
            'group' => esc_html__('General','qode-news')
        );

        $params_array[] = array(
            'type' => 'dropdown',
            'heading' => esc_html__('Layout Title Tag','qode-news'),
            'param_name' => 'layout_title_tag',
            'value' => array_flip( bridge_qode_get_title_tag( true ) ),
            'group' => esc_html__('General','qode-news')
        );

        // General Options - end

        if (is_array($exclude_options) && count($exclude_options)) {
            foreach ($exclude_options as $exclude_key) {
                foreach ($params_array as $params_item) {
                    if ($exclude_key == $params_item['param_name']) {
                        $key = array_search($params_item, $params_array);
                        unset($params_array[$key]);
                    }
                }
            }
        }

        return $params_array;
    }
}

/**
 *
 * General Featured Post Item Visual Composer options for News Shortcodes
 *
 */
if (!function_exists('qode_news_get_featured_post_item_shortcode_params')) {
    /**
     * Function that returns array of featured post item predefined params formatted for Visual Composer
     *
     * @return array of params
     *
     */
    function qode_news_get_featured_post_item_shortcode_params($exclude_options = array()) {

        $params_array = array();

        // Post Options - Start

        $params_array[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'featured_title_tag',
			'heading'     => esc_html__( 'Title Tag', 'qode-news' ),
			'value'       => array_flip( bridge_qode_get_title_tag( true ) ),
            'group' 	  => esc_html__('Featured Post Item','qode-news'),
        );

		$params_array[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'featured_image_size',
			'heading'     => esc_html__( 'Image Size', 'qode-news' ),
			'value'		  => array(
				esc_html__('Default','qode-news') => '',
				esc_html__('Thumbnail','qode-news') => 'thumbnail',
				esc_html__('Medium','qode-news') => 'medium',
				esc_html__('Large','qode-news') => 'large',
				esc_html__('Landscape','qode-news') => 'portfolio-landscape',
				esc_html__('Portrait','qode-news') => 'portfolio-portrait',
				esc_html__('Square','qode-news') => 'portfolio-square',
				esc_html__('Full','qode-news') => 'full',
				esc_html__('Custom','qode-news') => 'custom',
			),
			'description' => esc_html__( 'Choose image size', 'qode-news' ),
			'group' 	  => esc_html__('Featured Post Item','qode-news'),
		);

		$params_array[] = array(
			'type'        => 'textfield',
			'param_name'  => 'featured_custom_image_width',
			'heading'     => esc_html__( 'Custom Image Width', 'qode-news' ),
			'description' => esc_html__( 'Enter image width in px', 'qode-news' ),
			'dependency'  => array('element' => 'featured_image_size', 'value' => 'custom'),
			'group' 	  => esc_html__('Featured Post Item','qode-news'),
		);

		$params_array[] = array(
			'type'        => 'textfield',
			'param_name'  => 'featured_custom_image_height',
			'heading'     => esc_html__( 'Custom Image Height', 'qode-news' ),
			'description' => esc_html__( 'Enter image height in px', 'qode-news' ),
			'dependency'  => array('element' => 'featured_image_size', 'value' => 'custom'),
			'group' 	  => esc_html__('Featured Post Item','qode-news'),
		);

		$params_array[] = array(
			'type'		  => 'dropdown',
			'param_name'  => 'featured_display_categories',
			'heading'	  => esc_html__('Display Categories','qode-news'),
			'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' 	  => esc_html__('Featured Post Item','qode-news'),
		);

		$params_array[] = array(
			'type'		  => 'dropdown',
			'param_name'  => 'featured_display_excerpt',
			'heading'	  => esc_html__('Display Excerpt','qode-news'),
			'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' 	  => esc_html__('Featured Post Item','qode-news'),
		);

        $params_array[] = array(
            'type'        => 'textfield',
            'param_name'  => 'featured_excerpt_length',
            'heading'	  => esc_html__('Max. Excerpt Length','qode-news'),
            'description' => esc_html__('Enter max of words that can be shown for excerpt','qode-news'),
            'dependency'  => array('element' => 'featured_display_excerpt', 'value' => array('','yes')),
            'group' 	  => esc_html__('Featured Post Item','qode-news'),
        );

		$params_array[] = array(
			'type'		  => 'dropdown',
			'param_name'  => 'featured_display_date',
			'heading'	  => esc_html__('Display Date','qode-news'),
			'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' 	  => esc_html__('Featured Post Item','qode-news'),
		);

        $params_array[] = array(
            'type'        => 'dropdown',
            'param_name'  => 'featured_date_format',
            'heading'	  => esc_html__('Publication Date Format','qode-news'),
            'value' 	  => array(
            	esc_html__('Default','qode-news') => '',
            	esc_html__('Time from Publication','qode-news') => 'difference',
            	esc_html__('Date of Publication','qode-news') => 'published'
        	),
            'dependency'  => array('element' => 'featured_display_date', 'value' => array('','yes')),
            'group' 	  => esc_html__('Featured Post Item','qode-news'),
        );

		$params_array[] = array(
			'type'		  => 'dropdown',
			'param_name'  => 'featured_display_author',
			'heading'	  => esc_html__('Display Author','qode-news'),
			'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' 	  => esc_html__('Featured Post Item','qode-news'),
		);

		$params_array[] = array(
			'type'		  => 'dropdown',
			'param_name'  => 'featured_display_views',
			'heading'	  => esc_html__('Display Views','qode-news'),
			'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' 	  => esc_html__('Featured Post Item','qode-news'),
		);

		$params_array[] = array(
			'type'		  => 'dropdown',
			'param_name'  => 'featured_display_share',
			'heading'	  => esc_html__('Display Share','qode-news'),
			'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' 	  => esc_html__('Featured Post Item','qode-news'),
		);

		$params_array[] = array(
			'type'		  => 'dropdown',
			'param_name'  => 'featured_display_hot_trending_icons',
			'heading'	  => esc_html__('Display Hot/Trending Icons','qode-news'),
			'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' 	  => esc_html__('Featured Post Item','qode-news'),
		);

        // Post Options - end

        if (is_array($exclude_options) && count($exclude_options)) {
            foreach ($exclude_options as $exclude_key) {
                foreach ($params_array as $params_item) {
                    if ($exclude_key == $params_item['param_name']) {
                        $key = array_search($params_item, $params_array);
                        unset($params_array[$key]);
                    }
                }
            }
        }

        return $params_array;
    }
}

/**
 *
 * General Post Item Visual Composer options for News Shortcodes
 *
 */
if (!function_exists('qode_news_get_post_item_shortcode_params')) {
    /**
     * Function that returns array of post item predefined params formatted for Visual Composer
     *
     * @return array of params
     *
     */
    function qode_news_get_post_item_shortcode_params($exclude_options = array()) {

        $params_array = array();

        // Post Options - Start

        $params_array[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'title_tag',
			'heading'     => esc_html__( 'Title Tag', 'qode-news' ),
			'value'       => array_flip( bridge_qode_get_title_tag( true ) ),
            'group' 	  => esc_html__('Post Item','qode-news'),
        );

		$params_array[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'image_size',
			'heading'     => esc_html__( 'Image Size', 'qode-news' ),
			'value'		  => array(
				esc_html__('Default','qode-news') => '',
				esc_html__('Thumbnail','qode-news') => 'thumbnail',
				esc_html__('Medium','qode-news') => 'medium',
				esc_html__('Large','qode-news') => 'large',
				esc_html__('Landscape','qode-news') => 'portfolio-landscape',
				esc_html__('Portrait','qode-news') => 'portfolio-portrait',
				esc_html__('Square','qode-news') => 'portfolio-square',
				esc_html__('Full','qode-news') => 'full',
				esc_html__('Custom','qode-news') => 'custom',
			),
			'description' => esc_html__( 'Choose image size', 'qode-news' ),
			'group' 	  => esc_html__('Post Item','qode-news'),
		);

		$params_array[] = array(
			'type'        => 'textfield',
			'param_name'  => 'custom_image_width',
			'heading'     => esc_html__( 'Custom Image Width', 'qode-news' ),
			'description' => esc_html__( 'Enter image width in px', 'qode-news' ),
			'dependency'  => array('element' => 'image_size', 'value' => 'custom'),
			'group' 	  => esc_html__('Post Item','qode-news'),
		);

		$params_array[] = array(
			'type'        => 'textfield',
			'param_name'  => 'custom_image_height',
			'heading'     => esc_html__( 'Custom Image Height', 'qode-news' ),
			'description' => esc_html__( 'Enter image height in px', 'qode-news' ),
			'dependency'  => array('element' => 'image_size', 'value' => 'custom'),
			'group' 	  => esc_html__('Post Item','qode-news'),
		);

		$params_array[] = array(
			'type'		  => 'dropdown',
			'param_name'  => 'display_categories',
			'heading'	  => esc_html__('Display Categories','qode-news'),
			'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' 	  => esc_html__('Post Item','qode-news'),
		);

		$params_array[] = array(
			'type'		  => 'dropdown',
			'param_name'  => 'display_excerpt',
			'heading'	  => esc_html__('Display Excerpt','qode-news'),
			'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' 	  => esc_html__('Post Item','qode-news'),
		);

        $params_array[] = array(
            'type'        => 'textfield',
            'heading'	  => esc_html__('Max. Excerpt Length','qode-news'),
            'param_name'  => 'excerpt_length',
            'description' => esc_html__('Enter max of words that can be shown for excerpt','qode-news'),
            'dependency'  => array('element' => 'display_excerpt', 'value' => array('','yes')),
            'group' 	  => esc_html__('Post Item','qode-news'),
        );

		$params_array[] = array(
			'type'		  => 'dropdown',
			'param_name'  => 'display_date',
			'heading'	  => esc_html__('Display Date','qode-news'),
			'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' 	  => esc_html__('Post Item','qode-news'),
		);

        $params_array[] = array(
            'type'        => 'dropdown',
            'heading'	  => esc_html__('Publication Date Format','qode-news'),
            'param_name'  => 'date_format',
            'value' 	  => array(
            	esc_html__('Default','qode-news') => '',
            	esc_html__('Time from Publication','qode-news') => 'difference',
            	esc_html__('Date of Publication','qode-news') => 'published'
        	),
            'dependency'  => array('element' => 'display_date', 'value' => array('','yes')),
            'group' 	  => esc_html__('Post Item','qode-news'),
        );

		$params_array[] = array(
			'type'		  => 'dropdown',
			'param_name'  => 'display_author',
			'heading'	  => esc_html__('Display Author','qode-news'),
			'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' 	  => esc_html__('Post Item','qode-news'),
		);

		$params_array[] = array(
			'type'		  => 'dropdown',
			'param_name'  => 'display_share',
			'heading'	  => esc_html__('Display Share','qode-news'),
			'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' 	  => esc_html__('Post Item','qode-news'),
		);

		$params_array[] = array(
			'type'		  => 'dropdown',
			'param_name'  => 'display_hot_trending_icons',
			'heading'	  => esc_html__('Display Hot/Trending Icons','qode-news'),
			'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' 	  => esc_html__('Post Item','qode-news'),
		);

        // Post Options - end

        if (is_array($exclude_options) && count($exclude_options)) {
            foreach ($exclude_options as $exclude_key) {
                foreach ($params_array as $params_item) {
                    if ($exclude_key == $params_item['param_name']) {
                        $key = array_search($params_item, $params_array);
                        unset($params_array[$key]);
                    }
                }
            }
        }

        return $params_array;
    }
}


/**
 *
 * Pagination Group Visual Composer Options for Shortcodes
 *
 */
if (!function_exists('qode_news_get_pagination_shortcode_params')) {
    /**
     * Function that returns array of pagination predefined params formatted for Visual Composer
     *
     * @return array of params
     *
     */
    function qode_news_get_pagination_shortcode_params($exclude_options = array()) {

        $params_array = array();

        // Pagination options - start

        $params_array[] = array(
            'type' => 'dropdown',
            'class' => '',
            'heading' => esc_html__('Display Pagination','qode-news'),
            'param_name' => 'display_pagination',
            'value' => array(
                esc_html__('No','qode-news')   => 'no',
                esc_html__('Yes','qode-news')  => 'yes'
            ),
            'save_always' => true,
            'description' => '',
            'group' => esc_html__('Pagination','qode-news')
        );
        
        $params_array[] = array(
            'type' => 'dropdown',
            'class' => '',
            'heading' => esc_html__('Pagination Type','qode-news'),
            'param_name' => 'pagination_type',
            'value' => array(
                esc_html__('Standard','qode-news') => 'standard',
                esc_html__('Load More','qode-news') => 'load-more',
                esc_html__('Infinite Scroll','qode-news') => 'infinite-scroll'
            ),
            'description' => '',
            'save_always' => true,
            'dependency' => array('element' => 'display_pagination', 'value' => array('yes')),
            'group' => esc_html__('Pagination','qode-news')
        );

        $params_array[] = array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Amount of navigation numbers','qode-news'),
            'param_name'  => 'pagination_numbers_amount',
            'description' => esc_html__('Enter a number that will limit pagination numbers amount','qode-news'),
            'dependency'  => array('element' => 'pagination_type', 'value' => array('','standard')),
            'group'       => esc_html__('Pagination','qode-news'),
        );

        // Pagination Options - End

        if (is_array($exclude_options) && count($exclude_options)) {
            foreach ($exclude_options as $exclude_key) {
                foreach ($params_array as $params_item) {
                    if ($exclude_key == $params_item['param_name']) {
                        $key = array_search($params_item, $params_array);
                        unset($params_array[$key]);
                    }
                }
            }
        }

        return $params_array;
    }
}


/**
 *
 * Navigation Group Visual Composer Options for Shortcodes (Carousels and Sliders)
 *
 */
if (!function_exists('qode_news_get_navigation_shortcode_params')) {
    /**
     * Function that returns array of navigation predefined params formatted for Visual Composer
     *
     * @return array of params
     *
     */
    function qode_news_get_navigation_shortcode_params($exclude_options = array()) {

        $params_array = array();

        // Navigation Options - start
        $params_array[] = array(
            'type' => 'dropdown',
            'heading' => esc_html__('Display Navigation','qode-news'),
            'param_name' => 'display_navigation',
            'value' => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' => esc_html__('Navigation','qode-news')
        );

        $params_array[] = array(
            'type' => 'dropdown',
            'heading' => esc_html__('Display Paging','qode-news'),
            'param_name' => 'display_paging',
            'value' => array_flip(bridge_qode_get_yes_no_select_array()),
            'group' => esc_html__('Navigation','qode-news')
        );
        // Navigation Options - end

        if (is_array($exclude_options) && count($exclude_options)) {
            foreach ($exclude_options as $exclude_key) {
                foreach ($params_array as $params_item) {
                    if ($exclude_key == $params_item['param_name']) {
                        $key = array_search($params_item, $params_array);
                        unset($params_array[$key]);
                    }
                }
            }
        }

        return $params_array;
    }
}

if (!function_exists('qode_news_get_widget_params_from_VC')) {

	function qode_news_get_widget_params_from_VC($params_array){
		$widget_params_array = array();
		$i = 0;
		foreach ($params_array as $one_parameter_array) {
			$widget_params_array[$i] = array();
			if ($one_parameter_array['type'] == 'autocomplete') {
				$widget_params_array[$i]['type'] = 'textfield';
			} else {				
				$widget_params_array[$i]['type'] = $one_parameter_array['type'];
			}

			$widget_params_array[$i]['title'] = $one_parameter_array['heading'];
			$widget_params_array[$i]['name'] = $one_parameter_array['param_name'];

			if (isset($one_parameter_array['description'])) {
				$widget_params_array[$i]['description'] = $one_parameter_array['description'];
			}

			if (isset($one_parameter_array['value']) && is_array($one_parameter_array['value']) && count($one_parameter_array['value'])) {
				$widget_params_array[$i]['options'] = array_flip($one_parameter_array['value']);
			}
			$i++;
		}

		return $widget_params_array;
	}
}