<?php

namespace QodeLMS\CPT\Shortcodes\Course;

use QodeLMS\Lib;

class CourseList implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'qode_course_list';

        add_action('vc_before_init', array($this, 'vcMap'));

	    //Course category filter
	    add_filter( 'vc_autocomplete_qode_course_list_category_callback', array( &$this, 'courseListCategoryAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array

	    //Course category render
	    add_filter( 'vc_autocomplete_qode_course_list_category_render', array( &$this, 'courseListCategoryAutocompleteRender', ), 10, 1 ); // Get suggestion(find). Must return an array

	    //Course selected projects filter
	    add_filter( 'vc_autocomplete_qode_course_list_selected_courses_callback', array( &$this, 'courseListIdAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array

	    //Course selected projects render
	    add_filter( 'vc_autocomplete_qode_course_list_selected_courses_render', array( &$this, 'courseListIdAutocompleteRender', ), 10, 1 ); // Render exact course. Must return an array (label,value)

	    //Course tag filter
	    add_filter( 'vc_autocomplete_qode_course_list_tag_callback', array( &$this, 'courseListTagAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array

	    //Course tag render
	    add_filter( 'vc_autocomplete_qode_course_list_tag_render', array( &$this, 'courseListTagAutocompleteRender', ), 10, 1 ); // Get suggestion(find). Must return an array
    }
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map( array(
					'name'                      => esc_html__( 'Course List', 'qode-lms' ),
					'base'                      => $this->getBase(),
					'category'                  => esc_html__( 'by QODE LMS', 'qode-lms' ),
					'icon'                      => 'icon-wpb-course-list extended-custom-icon-qode',
					'allowed_container_element' => 'vc_row',
					'params'                    => array(
						array(
							'type'        => 'dropdown',
							'param_name'  => 'number_of_columns',
							'heading'     => esc_html__( 'Number of Columns', 'qode-lms' ),
							'value'       => array(
								esc_html__( 'Default', 'qode-lms' ) => '',
								esc_html__( 'One', 'qode-lms' )     => '1',
								esc_html__( 'Two', 'qode-lms' )     => '2',
								esc_html__( 'Three', 'qode-lms' )   => '3',
								esc_html__( 'Four', 'qode-lms' )    => '4',
								esc_html__( 'Five', 'qode-lms' )    => '5'
							),
							'description' => esc_html__( 'Default value is Three', 'qode-lms' ),
							'save_always' => true
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'space_between_items',
							'heading'     => esc_html__( 'Space Between Courses', 'qode-lms' ),
							'value'       => array_flip( bridge_qode_get_space_between_items_array() ),
							'save_always' => true
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'number_of_items',
							'heading'     => esc_html__( 'Number of Courses Per Page', 'qode-lms' ),
							'description' => esc_html__( 'Set number of items for your course list. Enter -1 to show all.', 'qode-lms' ),
							'value'       => '-1'
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'enable_image',
							'heading'    => esc_html__( 'Enable Image', 'qode-lms' ),
							'value'      => array_flip( bridge_qode_get_yes_no_select_array( false, true ) ),
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'image_proportions',
							'heading'     => esc_html__( 'Image Proportions', 'qode-lms' ),
							'value'       => array(
								esc_html__( 'Original', 'qode-lms' )  => 'full',
								esc_html__( 'Square', 'qode-lms' )    => 'square',
								esc_html__( 'Landscape', 'qode-lms' ) => 'landscape',
								esc_html__( 'Portrait', 'qode-lms' )  => 'portrait',
								esc_html__( 'Thumbnail', 'qode-lms' ) => 'thumbnail',
								esc_html__( 'Medium', 'qode-lms' )    => 'medium',
								esc_html__( 'Large', 'qode-lms' )     => 'large'
							),
							'description' => esc_html__( 'Set image proportions for your courses list.', 'qode-lms' ),
							'dependency'  => array( 'element' => 'enable_image', 'value' => 'yes' )
						),
						array(
							'type'        => 'autocomplete',
							'param_name'  => 'category',
							'heading'     => esc_html__( 'One-Category Course List', 'qode-lms' ),
							'description' => esc_html__( 'Enter one category slug (leave empty for showing all categories)', 'qode-lms' )
						),
						array(
							'type'        => 'autocomplete',
							'param_name'  => 'selected_courses',
							'heading'     => esc_html__( 'Show Only Courses with Listed IDs', 'qode-lms' ),
							'settings'    => array(
								'multiple'      => true,
								'sortable'      => true,
								'unique_values' => true
							),
							'description' => esc_html__( 'Delimit ID numbers by comma (leave empty for all)', 'qode-lms' )
						),
						array(
							'type'        => 'autocomplete',
							'param_name'  => 'tag',
							'heading'     => esc_html__( 'One-Tag Courses List', 'qode-lms' ),
							'description' => esc_html__( 'Enter one tag slug (leave empty for showing all tags)', 'qode-lms' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'orderby',
							'heading'     => esc_html__( 'Order By', 'qode-lms' ),
							'value'       => array_flip( bridge_qode_get_query_order_by_array() ),
							'save_always' => true
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'order',
							'heading'     => esc_html__( 'Order', 'qode-lms' ),
							'value'       => array_flip( bridge_qode_get_query_order_array() ),
							'save_always' => true
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'item_layout',
							'heading'    => esc_html__( 'Item Style', 'qode-lms' ),
							'value'      => array(
								esc_html__( 'Standard ', 'qode-lms' ) => 'standard',
								esc_html__( 'Minimal ', 'qode-lms' )  => 'minimal',
							),
							'group'      => esc_html__( 'Content Layout', 'qode-lms' ),
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'enable_title',
							'heading'    => esc_html__( 'Enable Title', 'qode-lms' ),
							'value'      => array_flip( bridge_qode_get_yes_no_select_array( false, true ) ),
							'group'      => esc_html__( 'Content Layout', 'qode-lms' ),
							'dependency' => array( 'element' => 'item_layout', 'value' => array( 'standard' ) )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'title_tag',
							'heading'    => esc_html__( 'Title Tag', 'qode-lms' ),
							'value'      => array_flip( bridge_qode_get_title_tag( true ) ),
							'dependency' => array( 'element' => 'enable_title', 'value' => array( 'yes' ) ),
							'group'      => esc_html__( 'Content Layout', 'qode-lms' ),
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'title_text_transform',
							'heading'    => esc_html__( 'Title Text Transform', 'qode-lms' ),
							'value'      => array_flip( bridge_qode_get_text_transform_array( true ) ),
							'dependency' => array( 'element' => 'enable_title', 'value' => array( 'yes' ) ),
							'group'      => esc_html__( 'Content Layout', 'qode-lms' )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'enable_instructor',
							'heading'    => esc_html__( 'Enable Instructor', 'qode-lms' ),
							'value'      => array_flip( bridge_qode_get_yes_no_select_array( false, true ) ),
							'group'      => esc_html__( 'Content Layout', 'qode-lms' ),
							'dependency' => array( 'element' => 'item_layout', 'value' => array( 'standard' ) )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'enable_price',
							'heading'    => esc_html__( 'Enable Price', 'qode-lms' ),
							'value'      => array_flip( bridge_qode_get_yes_no_select_array( false, true ) ),
							'group'      => esc_html__( 'Content Layout', 'qode-lms' ),
							'dependency' => array( 'element' => 'item_layout', 'value' => array( 'standard' ) )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'enable_excerpt',
							'heading'    => esc_html__( 'Enable Excerpt', 'qode-lms' ),
							'value'      => array_flip( bridge_qode_get_yes_no_select_array( false, true ) ),
							'group'      => esc_html__( 'Content Layout', 'qode-lms' ),
							'dependency' => array( 'element' => 'item_layout', 'value' => array( 'standard' ) )
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'excerpt_length',
							'heading'     => esc_html__( 'Excerpt Length', 'qode-lms' ),
							'description' => esc_html__( 'Number of characters', 'qode-lms' ),
							'dependency'  => array( 'element' => 'enable_excerpt', 'value' => array( 'yes' ) ),
							'group'       => esc_html__( 'Content Layout', 'qode-lms' )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'enable_students',
							'heading'    => esc_html__( 'Enable Students', 'qode-lms' ),
							'value'      => array_flip( bridge_qode_get_yes_no_select_array( false, true ) ),
							'group'      => esc_html__( 'Content Layout', 'qode-lms' ),
							'dependency' => array( 'element' => 'item_layout', 'value' => array( 'standard' ) )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'enable_category',
							'heading'    => esc_html__( 'Enable Category', 'qode-lms' ),
							'value'      => array_flip( bridge_qode_get_yes_no_select_array( false, true ) ),
							'group'      => esc_html__( 'Content Layout', 'qode-lms' ),
							'dependency' => array( 'element' => 'item_layout', 'value' => array( 'standard' ) )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'pagination_type',
							'heading'    => esc_html__( 'Pagination Type', 'qode-lms' ),
							'value'      => array(
								esc_html__( 'None', 'qode-lms' )            => 'no-pagination',
								esc_html__( 'Standard', 'qode-lms' )        => 'standard',
								esc_html__( 'Load More', 'qode-lms' )       => 'load-more',
								esc_html__( 'Infinite Scroll', 'qode-lms' ) => 'infinite-scroll'
							),
							'group'      => esc_html__( 'Additional Features', 'qode-lms' )
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'load_more_top_margin',
							'heading'    => esc_html__( 'Load More Top Margin (px or %)', 'qode-lms' ),
							'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'load-more' ) ),
							'group'      => esc_html__( 'Additional Features', 'qode-lms' )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'filter',
							'heading'    => esc_html__( 'Enable Filter', 'qode-lms' ),
							'value'      => array_flip( bridge_qode_get_yes_no_select_array( false ) ),
							'group'      => esc_html__( 'Additional Features', 'qode-lms' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'enable_article_animation',
							'heading'     => esc_html__( 'Enable Article Animation', 'qode-lms' ),
							'description' => esc_html__( 'Enabling this option you will enable appears animation for your course list items', 'qode-lms' ),
							'value'       => array_flip( bridge_qode_get_yes_no_select_array( false ) ),
							'dependency'  => array( 'element' => 'item_layout', 'value' => array( 'standard' ) ),
							'group'       => esc_html__( 'Additional Features', 'qode-lms' )
						)
					)
				)
			);
		}
	}

    /**
     * Renders shortcodes HTML
     *
     * @param $atts array of shortcode params
     * @param $content string shortcode content
     *
     * @return string
     */
    public function render($atts, $content = null) {
        $args = array(
	        'number_of_columns'         => '3',
            'space_between_items'       => 'normal',
	        'number_of_items'           => '-1',
            'enable_image'              => 'yes',
            'image_proportions'         => 'full',
            'category'                  => '',
            'selected_courses'          => '',
	        'tag'                       => '',
            'orderby'                   => 'date',
            'order'                     => 'DESC',
	        'item_layout'               => 'standard',
	        'enable_title'              => 'yes',
            'title_tag'                 => 'h5',
	        'title_text_transform'      => '',
            'enable_instructor'         => 'yes',
            'enable_price'              => 'yes',
            'enable_excerpt'            => 'yes',
            'excerpt_length'            => '60',
            'enable_students'           => 'yes',
            'enable_category'           => 'yes',
            'pagination_type'           => 'no-pagination',
	        'load_more_top_margin'      => '',
            'filter'                    => 'no',
            'enable_article_animation'  => 'no',
	        'course_slider_on'          => 'no',
            'enable_loop'               => 'yes',
            'enable_autoplay'		    => 'yes',
            'slider_speed'              => '5000',
            'slider_speed_animation'    => '600',
            'enable_navigation'         => 'yes',
            'navigation_skin'           => '',
            'enable_pagination'         => 'yes',
            'pagination_skin'           => '',
	        'pagination_position'       => '',
            'widget'                    => 'no',
        );
		$params = shortcode_atts($args, $atts);
	
	    /***
	     * @params query_results
	     * @params holder_data
	     * @params holder_classes
	     * @params holder_inner_classes
	     */
		$additional_params = array();
	
	    $query_array                        = $this->getQueryArray( $params );
	    $query_results                      = new \WP_Query( $query_array );
	    $additional_params['query_results'] = $query_results;

	    $additional_params['pagination_values']    = $this->getPaginationValues($params);
	    $additional_params['holder_data']          = $this->getHolderData( $params, $additional_params );
	    $additional_params['holder_classes']       = $this->getHolderClasses( $params );
	    $additional_params['holder_inner_classes'] = $this->getHolderInnerClasses( $params );
        $additional_params['slug'] = '';

        if($params['widget'] == 'yes') {
            $additional_params['slug'] = 'widget';
        }
	
	    $params['this_object'] = $this;
	
	    $html = qode_lms_get_cpt_shortcode_module_template_part( 'course', 'course-holder', '', $params, $additional_params );
	
	    return $html;
	}

	/**
    * Generates course list query attribute array
    *
    * @param $params
    *
    * @return array
    */
	public function getQueryArray($params){
		$query_array = array(
			'post_status'    => 'publish',
			'post_type'      => 'course',
			'posts_per_page' => $params['number_of_items'],
			'orderby'        => $params['orderby'],
			'order'          => $params['order']
		);

		if(!empty($params['category'])){
			$query_array['course-category'] = $params['category'];
		}

		$project_ids = null;
		if (!empty($params['selected_courses'])) {
			$project_ids = explode(',', $params['selected_courses']);
			$query_array['post__in'] = $project_ids;
		}

		if(!empty($params['tag'])){
			$query_array['course-tag'] = $params['tag'];
		}

		if(!empty($params['next_page'])){
			$query_array['paged'] = $params['next_page'];
		} else {
			$query_array['paged'] = 1;
		}

		return $query_array;
	}

    public function getPaginationValues($params){
	    $paginationValues = array();

        if(!empty($params['next_page'])){
            $paginationValues['paged'] = $params['next_page'];
        } else {
            $paginationValues['paged'] = 1;
        }

        $query_array = array(
            'post_status'    => 'publish',
            'post_type'      => 'course',
            'posts_per_page' => -1
        );

        if(!empty($params['category'])){
            $query_array['course-category'] = $params['category'];
        }

        $project_ids = null;
        if (!empty($params['selected_courses'])) {
            $project_ids = explode(',', $params['selected_courses']);
            $query_array['post__in'] = $project_ids;
        }

        if(!empty($params['tag'])){
            $query_array['course-tag'] = $params['tag'];
        }

        $query_results  = new \WP_Query( $query_array );
        $posts = $query_results->get_posts();
        $paginationValues['total_items'] = count($posts);

        if(!empty($params['number_of_items'])){
            if ($params['number_of_items'] == '-1') {
                $paginationValues['min_value'] = 1;
                $paginationValues['max_value'] = count($posts);
            } else {
                if($paginationValues['paged'] == '1') {
                    $paginationValues['min_value'] = 1;
                    $paginationValues['max_value'] = $params['number_of_items'];
                } else {
                    $paginationValues['min_value'] = ($paginationValues['paged'] - 1) * $params['number_of_items'] + 1;
                    $paginationValues['max_value'] = $paginationValues['paged'] * $params['number_of_items'];
                }
            }
        }

        return $paginationValues;
    }
	
	/**
	 * Generates data attributes array
	 *
	 * @param $params
	 * @param $additional_params
	 *
	 * @return string
	 */
	public function getHolderData($params, $additional_params){
		$dataString = '';
		
		if(get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif(get_query_var('page')) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}
		
		$query_results = $additional_params['query_results'];
		$params['max_num_pages'] = $query_results->max_num_pages;
		
		if(!empty($paged)) {
			$params['next_page'] = $paged+1;
		}
		
		foreach ($params as $key => $value) {
			if($value !== '') {
				$new_key = str_replace( '_', '-', $key );
				
				$dataString .= ' data-'.$new_key.'="'.esc_attr($value) . '"';
			}
		}
		
		return $dataString;
	}

	/**
    * Generates course holder classes
    *
    * @param $params
    *
    * @return string
    */
	public function getHolderClasses( $params ) {
		$classes = array();

		$classes[] = 'qode-cl-gallery';
		$classes[] = ! empty( $params['space_between_items'] ) ? 'qode-' . $params['space_between_items'] . '-space' : 'qode-normal-space';
		
		$number_of_columns = $params['number_of_columns'];
		switch ( $number_of_columns ):
			case '1':
				$classes[] = 'qode-cl-one-column';
				break;
			case '2':
				$classes[] = 'qode-cl-two-columns';
				break;
			case '3':
				$classes[] = 'qode-cl-three-columns';
				break;
			case '4':
				$classes[] = 'qode-cl-four-columns';
				break;
			case '5':
				$classes[] = 'qode-cl-five-columns';
				break;
			default:
				$classes[] = 'qode-cl-three-columns';
				break;
		endswitch;
		
		$classes[] = ! empty( $params['item_layout'] ) ? 'qode-cl-' . $params['item_layout'] : '';
		$classes[] = ! empty( $params['pagination_type'] ) ? 'qode-cl-pag-' . $params['pagination_type'] : '';
		$classes[] = $params['enable_article_animation'] === 'yes' ? 'qode-cl-has-animation' : '';
        $classes[] = $params['filter'] === 'yes' ? 'qode-cl-has-filter' : '';
		$classes[] = ! empty( $params['navigation_skin'] ) ? 'qode-nav-' . $params['navigation_skin'] . '-skin' : '';
		$classes[] = ! empty( $params['pagination_skin'] ) ? 'qode-pag-' . $params['pagination_skin'] . '-skin' : '';
		$classes[] = ! empty( $params['pagination_position'] ) ? 'qode-pag-' . $params['pagination_position'] : '';
		
		return implode( ' ', $classes );
	}
	
	/**
	 * Generates course holder inner classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getHolderInnerClasses($params){
		$classes = array();

		$classes[] = 'qode-outer-space';
		
		$classes[] = $params['course_slider_on'] === 'yes' ? 'qode-owl-slider qode-pl-is-slider' : '';
		
		return implode(' ', $classes);
	}

	/**
	 * Generates course article classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getArticleClasses($params){
		$classes = array();

		$classes[] = 'qode-item-space';
		
		$article_classes = get_post_class($classes);

		return implode(' ', $article_classes);
	}

    /**
     * Generates course article data for sorting
     *
     * @param $params
     *
     * @return string
     */
    public function getArticleData($params){
        $data = array();
        $dataString = '';
        $data['name'] = strtolower(str_replace(' ', '-', get_the_title()));
        $data['date'] = strtotime(get_the_date());

        foreach ($data as $key => $value) {
            if($value !== '') {
                $dataString .= ' data-'.$key.'=' . esc_attr($value);
            }
        }

		return $dataString;

    }

	/**
    * Generates course image size
    *
    * @param $params
    *
    * @return string
    */
    public function getImageSize($params){
        $thumb_size = 'full';

        if (!empty($params['image_proportions'])) {
            $image_size = $params['image_proportions'];

            switch ($image_size) {
                case 'landscape':
                    $thumb_size = 'portfolio_masonry_wide';
                    break;
                case 'portrait':
                    $thumb_size = 'portfolio_masonry_tall';
                    break;
                case 'square':
                    $thumb_size = 'portfolio_masonry_regular';
                    break;
                case 'medium':
                    $thumb_size = 'medium';
                    break;
                case 'large':
                    $thumb_size = 'large';
                    break;
                case 'full':
                    $thumb_size = 'full';
                    break;
            }
        }

        return $thumb_size;
    }

	/**
	 * Returns array of title element styles
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function getTitleStyles($params) {
		$styles = array();
		
		if(!empty($params['title_text_transform'])) {
			$styles[] = 'text-transform: '.$params['title_text_transform'];
		}
		
		return implode(';', $styles);
	}
	
	/**
	 * Returns array of load more element styles
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function getLoadMoreStyles($params) {
		$styles = array();
		
		if (!empty($params['load_more_top_margin'])) {
			$margin = $params['load_more_top_margin'];
			
			if(bridge_qode_string_ends_with($margin, '%') || bridge_qode_string_ends_with($margin, 'px')) {
				$styles[] = 'margin-top: '.$margin;
			} else {
				$styles[] = 'margin-top: '.bridge_qode_filter_px($margin).'px';
			}
		}
		
		return implode(';', $styles);
	}

	/**
	 * Filter course categories
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function courseListCategoryAutocompleteSuggester( $query ) {
		global $wpdb;
		$post_meta_infos       = $wpdb->get_results( $wpdb->prepare( "SELECT a.slug AS slug, a.name AS course_category_title
					FROM {$wpdb->terms} AS a
					LEFT JOIN ( SELECT term_id, taxonomy  FROM {$wpdb->term_taxonomy} ) AS b ON b.term_id = a.term_id
					WHERE b.taxonomy = 'course-category' AND a.name LIKE '%%%s%%'", stripslashes( $query ) ), ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['slug'];
				$data['label'] = ( ( strlen( $value['course_category_title'] ) > 0 ) ? esc_html__( 'Category', 'qode-lms' ) . ': ' . $value['course_category_title'] : '' );
				$results[]     = $data;
			}
		}

		return $results;
	}

	/**
	 * Find course category by slug
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function courseListCategoryAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get course category
			$course_category = get_term_by( 'slug', $query, 'course-category' );
			if ( is_object( $course_category ) ) {

				$course_category_slug = $course_category->slug;
				$course_category_title = $course_category->name;

				$course_category_title_display = '';
				if ( ! empty( $course_category_title ) ) {
                    $course_category_title_display = esc_html__( 'Category', 'qode-lms' ) . ': ' . $course_category_title;
				}

				$data          = array();
				$data['value'] = $course_category_slug;
				$data['label'] = $course_category_title_display;

				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}

	/**
	 * Filter courses by ID or Title
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function courseListIdAutocompleteSuggester( $query ) {
		global $wpdb;
		$course_id = (int) $query;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT ID AS id, post_title AS title
					FROM {$wpdb->posts} 
					WHERE post_type = 'course' AND ( ID = '%d' OR post_title LIKE '%%%s%%' )", $course_id > 0 ? $course_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $value['id'];
				$data['label'] = esc_html__( 'Id', 'qode-lms' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'qode-lms' ) . ': ' . $value['title'] : '' );
				$results[] = $data;
			}
		}

		return $results;
	}

	/**
	 * Find course by id
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function courseListIdAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get course
			$course = get_post( (int) $query );
			if ( ! is_wp_error( $course ) ) {

				$course_id = $course->ID;
				$course_title = $course->post_title;

				$course_title_display = '';
				if ( ! empty( $course_title ) ) {
                    $course_title_display = ' - ' . esc_html__( 'Title', 'qode-lms' ) . ': ' . $course_title;
				}

				$course_id_display = esc_html__( 'Id', 'qode-lms' ) . ': ' . $course_id;

				$data          = array();
				$data['value'] = $course_id;
				$data['label'] = $course_id_display . $course_title_display;

				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}

	/**
	 * Filter course tags
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function courseListTagAutocompleteSuggester( $query ) {
		global $wpdb;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.slug AS slug, a.name AS course_tag_title
					FROM {$wpdb->terms} AS a
					LEFT JOIN ( SELECT term_id, taxonomy  FROM {$wpdb->term_taxonomy} ) AS b ON b.term_id = a.term_id
					WHERE b.taxonomy = 'course-tag' AND a.name LIKE '%%%s%%'", stripslashes( $query ) ), ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['slug'];
				$data['label'] = ( ( strlen( $value['course_tag_title'] ) > 0 ) ? esc_html__( 'Tag', 'qode-lms' ) . ': ' . $value['course_tag_title'] : '' );
				$results[]     = $data;
			}
		}

		return $results;
	}

	/**
	 * Find course tag by slug
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function courseListTagAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get course tag
			$course_tag = get_term_by( 'slug', $query, 'course-tag' );
			if ( is_object( $course_tag ) ) {

				$course_tag_slug = $course_tag->slug;
				$course_tag_title = $course_tag->name;

				$course_tag_title_display = '';
				if ( ! empty( $course_tag_title ) ) {
                    $course_tag_title_display = esc_html__( 'Tag', 'qode-lms' ) . ': ' . $course_tag_title;
				}

				$data          = array();
				$data['value'] = $course_tag_slug;
				$data['label'] = $course_tag_title_display;

				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}
}