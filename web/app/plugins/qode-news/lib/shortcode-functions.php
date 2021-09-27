<?php

if(!function_exists('qode_news_include_shortcodes_file')) {
	/**
	 * Loades all shortcodes by going through all folders that are placed directly in shortcodes folder
	 */
	function qode_news_include_shortcodes_file() {
		foreach(glob(QODE_NEWS_SHORTCODES_PATH.'/*/load.php') as $shortcode_load) {
			include_once $shortcode_load;
		}
		do_action('qode_news_action_include_shortcodes_file');
	}
	
	add_action('init', 'qode_news_include_shortcodes_file', 6); // permission 6 is set to be before vc_before_init hook that has permission 9
}

if(!function_exists('qode_news_load_shortcodes')) {
	function qode_news_load_shortcodes() {
		include_once QODE_NEWS_LIB_PATH.'/shortcode-loader.php';

		qodeNews\Lib\ShortcodeLoader::getInstance()->load();
	}
	
	add_action('init', 'qode_news_load_shortcodes', 7); // permission 7 is set to be before vc_before_init hook that has permission 9 and after qode_core_include_shortcodes_file hook
}

if (!function_exists('qode_news_get_query')) {
    /**
     * Function that returns query from params if return_query is true, or returns params if return_query is false
     *
     * @return WP_Query/params
     *
     */
    function qode_news_get_query($params, $return_query = true) {

    	$params = shortcode_atts(
            array(
                'post_type' => 'post',
                'posts_per_page' => '-1',
                'category_name' => '',
                'author_id' => '',
                'tag' => '',
                'reaction' => '',
                'post_in' => '',
                'post_not_in' => '',
                'sort' => '',
                'order' => '',
                'offset' => '0',
                'paged' => '',
                'display_pagination' => 'no',
                'pagination_type' => '',
                'pagination_range_limit' => '',
                'post_status' => 'publish',
                'only_videos' => '',
                'next_page' => '1',
				'year' => '',
				'monthnum' => '',
				'day' => ''
            ), $params);

        $query_array = array();

        $query_array['post_status'] = $params['post_status']; //to ensure that ajax call will not return 'private' posts

        if ($params['category_name'] !== '') {
            $query_array['category_name'] = $params['category_name'];
        }

        if ($params['author_id'] !== '') {
            $query_array['author_id'] = str_replace(' ', '', $params['author_id']); //because of the data and quotes spaces need to be erased
            $query_array['author'] = str_replace(' ', '', $params['author_id']); //because of the data and quotes spaces need to be erased
        }

        if (!empty($params['tag'])) {
            $query_array['tag'] = str_replace(' ', '', $params['tag']);
        }
        if (!empty($params['post_not_in'])) {

        	$query_array['post__not_in'] = explode(",", $params['post_not_in']);            
	        if (!$return_query) {
            	$query_array['post_not_in'] = str_replace(' ', '', $params['post_not_in']);
            }
        }
        if (!empty($params['post_in'])) {
            $query_array['post__in'] = explode(",", $params['post_in']);
	        if (!$return_query) {
            	$query_array['post_in'] = str_replace(' ', '', $params['post_in']);
	        }
        }

        if ($params['only_videos'] == 'yes') {
        	$query_array['tax_query'] = array(
        		array(
			        'taxonomy' => 'post_format',
			        'field'    => 'slug',
			        'terms'    => array( 'post-format-video' ),
		        )
			);

	        if (!$return_query) {
	        	$query_array['only_videos'] = 'yes';
	        }
        }

        $query_array['ignore_sticky_posts'] = '1';

        switch ($params['sort']) {
            case 'latest':
                $query_array['orderby'] = 'date';
                break;

            case 'random':
                $query_array['orderby'] = 'rand';
                break;

            case 'random_today':
                $query_array['orderby'] = 'rand';
                $query_array['year'] = date('Y');
                $query_array['monthnum'] = date('n');
                $query_array['day'] = date('j');
                break;

            case 'random_seven_days':
                $query_array['date_query'] = array(
                    'column' => 'post_date_gmt',
                    'after' => '1 week ago'
                );
                $query_array['orderby'] = 'rand';
                break;

            case 'comments':
                $query_array['orderby'] = 'comment_count';
                $query_array['order'] = 'DESC';
                break;

            case 'title':
                $query_array['orderby'] = 'title';
                break;

            case 'popular':
                $query_array['meta_key'] = 'qode_count_post_views_meta';
                $query_array['orderby'] = 'meta_value_num';
                $query_array['order'] = 'DESC';
                break;

            case 'featured_first':
            	//to get posts by featured, and afterwards when featured is not set
            	$query_array['meta_query'] = array(
					'relation' => 'OR',
					'featured' => array(
						'key' => 'qode_news_post_featured_meta',
						'value' => 'a',
						'compare' => '>'
					),
					'rest' => array(
						'key' => 'qode_news_post_featured_meta',
						'value' => 'exists',
						'compare' => 'NOT EXISTS'
					)
        		);

                $query_array['order'] = 'DESC';
                $query_array['orderby'] = 'meta_value date';

		        if (!$return_query) {
		        	$query_array['orderby'] = 'meta_value,date';
		        }
                break;

            case 'trending_first':
            	//to get posts by trending, and afterwards when trending is not set
            	$query_array['meta_query'] = array(
					'relation' => 'OR',
					'trending' => array(
						'key' => 'qode_news_post_trending_meta',
						'value' => 'a',
						'compare' => '>'
					),
					'rest' => array(
						'key' => 'qode_news_post_trending_meta',
						'value' => 'exists',
						'compare' => 'NOT EXISTS'
					)
        		);

                $query_array['order'] = 'DESC';
                $query_array['orderby'] = 'meta_value date';

		        if (!$return_query) {
		        	$query_array['orderby'] = 'meta_value,date';
		        }
                break;

            case 'hot_first':
            	//to get posts by hot, and afterwards when hot is not set
            	$query_array['meta_query'] = array(
					'relation' => 'OR',
					'hot' => array(
						'key' => 'qode_news_post_hot_meta',
						'value' => 'a',
						'compare' => '>'
					),
					'rest' => array(
						'key' => 'qode_news_post_hot_meta',
						'value' => 'exists',
						'compare' => 'NOT EXISTS'
					)
        		);

                $query_array['order'] = 'DESC';
                $query_array['orderby'] = 'meta_value date';

		        if (!$return_query) {
		        	$query_array['orderby'] = 'meta_value,date';
		        }
                break;

            case 'reactions':
            	if ($params['reaction'] !== ''){
            		
			        if (!$return_query) {
			        	$query_array['reaction'] = $params['reaction'];
			        }

	            	//to get posts by featured, and afterwards when featured is not set
	            	$query_array['meta_query'] = array(
						'relation' => 'OR',
						'featured' => array(
							'key' => 'qode_news_reaction_'.$params['reaction'],
							'value' => '-1',
							'compare' => '>',
							'type' => 'NUMERIC'
						),
						'rest' => array(
							'key' => 'qode_news_reaction_'.$params['reaction'],
							'value' => 'exists',
							'compare' => 'NOT EXISTS'
						)
	        		);

	                $query_array['order'] = 'DESC';
	                $query_array['orderby'] = 'meta_value date';
	                
			        if (!$return_query) {
			        	$query_array['orderby'] = 'meta_value,date';
			        }
            	} else {
	                $query_array['order'] = 'DESC';
	                $query_array['orderby'] = 'date';
            	}
                break;
        }

        $query_array['posts_per_page'] = $params['posts_per_page'];

        if (!empty($params['order'])) {
            $query_array['order'] = $params['order'];
        }

         if (!$return_query) {
        	$query_array['sort'] = $params['sort'];
        }
        
        if ( ! empty( $params['next_page'] ) ) {
            $query_array['paged'] = $params['next_page'];
        } else {
            $query_array['paged'] = 1;
        }

        if (!empty($params['offset'])) {
            if ($query_array['paged'] > 1) {
                $query_array['offset'] = $params['offset'] + (($query_array['paged'] - 1) * $params['posts_per_page']);
            } else {
                $query_array['offset'] = $params['offset'];
            }
        }

		$query_array['year'] = $params['year'];
		$query_array['monthnum'] = $params['monthnum'];
		$query_array['day'] = $params['day'];


        $list_query = new WP_Query($query_array);

        if (!empty($params['offset']) && $params['offset'] > '0' && $params['posts_per_page'] !== 0) {
            $list_query->max_num_pages = ceil((intval($list_query->found_posts) - intval($params['offset'])) / intval($params['posts_per_page']));
        }

        $query_array['max_num_pages'] = $list_query->max_num_pages;

        if ($return_query) {
            return $list_query;
        } else {
            return $query_array;
        }    
    }
}


if (!function_exists('qode_news_get_shortcode_params_names')) {
    /**
     * Function that returns array of predefined names which will be used for shortcode
     * This is used just to set default values
     *
     * @param $params_array array with all params for shortcode with empty value
     *
     * @return array of names with empty values
     *
     */
    function qode_news_get_shortcode_params_names($params_array) {
        $params_names = array();

        foreach ($params_array as $param) {
            $params_names[$param['param_name']] = '';
        }

        $params_names['offset'] = '';

        return $params_names;
    }
}


if (!function_exists('qode_news_get_holder_data_params')) {
    /**
     * Function which set data params on news shortcodes holder div
     *
     * @param $params array with all params for shortcode with empty value
     *
     * @return $dataString - string with formatted parameters
     *
     */
    function qode_news_get_holder_data_params($params, $base) {
        $data_string = '';
        
        $query_result = qode_news_get_query($params, false);

        if ( ! empty( $query_result['paged'] ) ) {
            $query_result['next-page'] = $query_result['paged'] + 1;
        }
        
        if ( ! empty( $params['title_tag'] ) ) {
            $query_result['title_tag'] = $params['title_tag'];
        }

        if ( ! empty( $params['image_size'] ) ) {
            $query_result['image_size'] = $params['image_size'];
        }

		if ( ! empty( $params['custom_image_width'] ) ) {
			$query_result['custom_image_width'] = $params['custom_image_width'];
		}

		if ( ! empty( $params['custom_image_height'] ) ) {
			$query_result['custom_image_height'] = $params['custom_image_height'];
		}

        if ( ! empty( $params['display_categories'] ) ) {
            $query_result['display_categories'] = $params['display_categories'];
        }

        if ( ! empty( $params['display_excerpt'] ) ) {
            $query_result['display_excerpt'] = $params['display_excerpt'];
        }

        if ( ! empty( $params['excerpt_length'] ) ) {
            $query_result['excerpt_length'] = $params['excerpt_length'];
        }

        if ( ! empty( $params['display_date'] ) ) {
            $query_result['display_date'] = $params['display_date'];
        }

        if ( ! empty( $params['date_format'] ) ) {
            $query_result['date_format'] = $params['date_format'];
        }

        if ( ! empty( $params['display_author'] ) ) {
            $query_result['display_author'] = $params['display_author'];
        }

        if ( ! empty( $params['display_views'] ) ) {
            $query_result['display_views'] = $params['display_views'];
        }

        if ( ! empty( $params['display_share'] ) ) {
            $query_result['display_share'] = $params['display_share'];
        }

        if ( ! empty( $params['display_hot_trending_icons'] ) ) {
            $query_result['display_hot_trending_icons'] = $params['display_hot_trending_icons'];        	
        }

        if ( ! empty( $params['display_review'] ) ) {
            $query_result['display_review'] = $params['display_review'];        	
        }

        if ( ! empty( $params['featured_title_tag'] ) ) {
            $query_result['featured_title_tag'] = $params['featured_title_tag'];
        }

        if ( ! empty( $params['featured_image_size'] ) ) {
            $query_result['featured_image_size'] = $params['featured_image_size'];
        }

        if ( ! empty( $params['featured_display_categories'] ) ) {
            $query_result['featured_display_categories'] = $params['featured_display_categories'];
        }

        if ( ! empty( $params['featured_display_excerpt'] ) ) {
            $query_result['featured_display_excerpt'] = $params['featured_display_excerpt'];
        }

        if ( ! empty( $params['featured_excerpt_length'] ) ) {
            $query_result['featured_excerpt_length'] = $params['featured_excerpt_length'];
        }

        if ( ! empty( $params['featured_display_date'] ) ) {
            $query_result['featured_display_date'] = $params['featured_display_date'];
        }

        if ( ! empty( $params['featured_date_format'] ) ) {
            $query_result['featured_date_format'] = $params['featured_date_format'];
        }

        if ( ! empty( $params['featured_display_author'] ) ) {
            $query_result['featured_display_author'] = $params['featured_display_author'];
        }

        if ( ! empty( $params['featured_display_views'] ) ) {
            $query_result['featured_display_views'] = $params['featured_display_views'];
        }

        if ( ! empty( $params['featured_display_share'] ) ) {
            $query_result['featured_display_share'] = $params['featured_display_share'];
        }

        if ( ! empty( $params['featured_display_hot_trending_icons'] ) ) {
            $query_result['featured_display_hot_trending_icons'] = $params['featured_display_hot_trending_icons'];        	
        }

        if ( ! empty( $params['pagination_type'] ) && ( $params['pagination_type'] == 'standard') ) {
            if ( ! empty( $params['pagination_numbers_amount'] ) ) {
                $query_result['pagination_numbers_amount'] = $params['pagination_numbers_amount'];
            } else {
                $query_result['pagination_numbers_amount'] = 3;
            }
        }

        $query_result['layout'] = $base;

        foreach ( $query_result  as $key => $value ) {
            if ( $key !== 'query_result' && $value !== '' && !is_array($value)) {
                $new_key = str_replace( '_', '-', $key );
                
                $data_string .= ' data-' . $new_key . '=' . esc_attr( $value );
            }
        }
        
        return $data_string;
    }
}

if ( ! function_exists( 'qode_news_shortcodes_load_more' ) ) {
    function qode_news_shortcodes_load_more() {
        $params = array();
        
        if ( ! empty( $_POST ) ) {
            foreach ( $_POST as $key => $value ) {
                if ( $key !== '' ) {
                    $addUnderscoreBeforeCapitalLetter = preg_replace( '/([A-Z])/', '_$1', $key );
                    $setAllLettersToLowercase         = strtolower( $addUnderscoreBeforeCapitalLetter );
                    
                    $params[ $setAllLettersToLowercase ] = $value;
                }
            }
        }

        $layout = str_replace('qode_', '', $params['layout']);
        $layout = str_replace('_', ' ', $layout);
        $layout = str_replace(' ','',ucwords($layout));
        $layout_class = ucfirst($layout);

        $a = '\qodeNews\CPT\Shortcodes\\'.$layout_class.'\\'.$layout_class;
        
        $this_object = new $a;
        
        $query_results = $this_object->generatePostsQuery( $params );

        $params['this_object'] = $this_object;
        $params['query_result'] = $query_results;

        $html = '';

        $html .= $this_object->renderQuery($params, null, true);

        $return_obj = array(
            'html' => $html,
        );
        
        echo json_encode( $return_obj );
        exit;
    }
    
    add_action( 'wp_ajax_nopriv_qode_news_shortcodes_load_more', 'qode_news_shortcodes_load_more' );
    add_action( 'wp_ajax_qode_news_shortcodes_load_more', 'qode_news_shortcodes_load_more' );
}

if ( ! function_exists( 'qode_news_shortcodes_filter' ) ) {
    function qode_news_shortcodes_filter() {
        $params = array();
        
        if ( ! empty( $_POST ) ) {
            foreach ( $_POST as $key => $value ) {
                if ( $key !== '' ) {
                    $addUnderscoreBeforeCapitalLetter = preg_replace( '/([A-Z])/', '_$1', $key );
                    $setAllLettersToLowercase         = strtolower( $addUnderscoreBeforeCapitalLetter );
                    
                    $params[ $setAllLettersToLowercase ] = $value;
                }
            }
        }
        
        $layout = str_replace('qode_', '', $params['layout']);
        $layout = str_replace('_', ' ', $layout);
        $layout = str_replace(' ','',ucwords($layout));
        $layout_class = ucwords($layout);

        $a = '\qodeNews\CPT\Shortcodes\\'.$layout_class.'\\'.$layout_class;
        
        $this_object = new $a;

        if (isset($params['next_page'])){
        	unset($params['next_page']); //to stay on the current page, whatever it is
        }

        $query_results = $this_object->generatePostsQuery( $params );

        $params['this_object'] = $this_object;
        $params['query_result'] = $query_results;

        $html = '';

        $html .= $this_object->renderQuery($params, null, true);

        $query_params = qode_news_get_query($params, false);

        $return_obj = array(
            'html' => $html,
            'newQueryParams' => $query_params
        );
        
        echo json_encode( $return_obj );
        exit;
    }
    
    add_action( 'wp_ajax_nopriv_qode_news_shortcodes_filter', 'qode_news_shortcodes_filter' );
    add_action( 'wp_ajax_qode_news_shortcodes_filter', 'qode_news_shortcodes_filter' );
}
?>