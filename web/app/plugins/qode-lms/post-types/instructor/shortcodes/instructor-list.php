<?php

namespace QodeLMS\CPT\Shortcodes\Instructor;

use QodeLMS\Lib;

class InstructorList implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'qode_instructor_list';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
		
		//Instructor category filter
		add_filter( 'vc_autocomplete_qode_instructor_list_category_callback', array( &$this, 'instructorListCategoryAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array
		
		//Instructor category render
		add_filter( 'vc_autocomplete_qode_instructor_list_category_render', array( &$this, 'instructorListCategoryAutocompleteRender', ), 10, 1 ); // Get suggestion(find). Must return an array
		
		//Instructor selected instructors filter
		add_filter( 'vc_autocomplete_qode_instructor_list_selected_instructors_callback', array( &$this, 'instructorListIdAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array
		
		//Instructor selected instructors render
		add_filter( 'vc_autocomplete_qode_instructor_list_selected_instructors_render', array( &$this, 'instructorListIdAutocompleteRender', ), 10, 1 ); // Render exact instructor. Must return an array (label,value)
	}
	
	/**
	 * Returns base for shortcode
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

    /**
     * Maps shortcode to Visual Composer
     */
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                      => esc_html__( 'Instructor List', 'qode-lms' ),
					'base'                      => $this->getBase(),
					'category'                  => esc_html__( 'by QODE LMS', 'qode-lms' ),
					'icon'                      => 'icon-wpb-instructor-list extended-custom-icon-qode',
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
							'description' => esc_html__( 'Default value is Three', 'qode-lms' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'space_between_items',
							'heading'     => esc_html__( 'Space Between Instructors', 'qode-lms' ),
							'value'       => array_flip( bridge_qode_get_space_between_items_array() ),
							'save_always' => true
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'number_of_items',
							'heading'     => esc_html__( 'Number of Instructors per page', 'qode-lms' ),
							'description' => esc_html__( 'Set number of items for your instructor list. Enter -1 to show all.', 'qode-lms' ),
							'value'       => '-1'
						),
						array(
							'type'        => 'autocomplete',
							'param_name'  => 'category',
							'heading'     => esc_html__( 'One-Category Instructor List', 'qode-lms' ),
							'description' => esc_html__( 'Enter one category slug (leave empty for showing all categories)', 'qode-lms' )
						),
						array(
							'type'        => 'autocomplete',
							'param_name'  => 'selected_instructors',
							'heading'     => esc_html__( 'Show Only Instructors with Listed IDs', 'qode-lms' ),
							'settings'    => array(
								'multiple'      => true,
								'sortable'      => true,
								'unique_values' => true
							),
							'description' => esc_html__( 'Delimit ID numbers by comma (leave empty for all)', 'qode-lms' )
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
							'type'        => 'dropdown',
							'param_name'  => 'instructor_layout',
							'heading'     => esc_html__( 'Instructor Layout', 'qode-lms' ),
							'value'       => array(
								esc_html__( 'Info Bellow', 'qode-lms' )   => 'info-bellow',
								esc_html__( 'Info on Hover', 'qode-lms' ) => 'info-hover',
								esc_html__( 'Simple', 'qode-lms' )        => 'simple',
								esc_html__( 'Minimal', 'qode-lms' )       => 'minimal'
							),
							'save_always' => true,
							'group'       => esc_html__( 'Content Layout', 'qode-lms' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'name_title_tag',
							'heading'     => esc_html__( 'Name Title Tag', 'qode-lms' ),
							'value'       => array(
								''	=> '',
								'h1'	=> 'h1',
								'h2'	=> 'h2',
								'h3'	=> 'h3',
								'h4'	=> 'h4',
								'h5'	=> 'h5',
								'h6'	=> 'h6'
							),
							'save_always' => true,
							'dependency'  => array( 'element' => 'instructor_layout', 'value' => array('info-bellow', 'info-hover', 'simple') ),
							'group'       => esc_html__( 'Content Layout', 'qode-lms' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'position_title_tag',
							'heading'     => esc_html__( 'Position Title Tag', 'qode-lms' ),
							'value'       => array(
								''	=> '',
								'h1'	=> 'h1',
								'h2'	=> 'h2',
								'h3'	=> 'h3',
								'h4'	=> 'h4',
								'h5'	=> 'h5',
								'h6'	=> 'h6'
							),
							'save_always' => true,
							'dependency'  => array( 'element' => 'instructor_layout', 'value' => array('info-bellow', 'info-hover', 'simple') ),
							'group'       => esc_html__( 'Content Layout', 'qode-lms' )
						),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'enable_excerpt',
                            'heading'     => esc_html__( 'Enable Excerpt', 'qode-lms' ),
                            'value'       => array_flip(bridge_qode_get_yes_no_select_array(false, true)),
                            'save_always' => true,
                            'dependency'  => array( 'element' => 'instructor_layout', 'value' => array('info-bellow') ),
                            'group'       => esc_html__( 'Content Layout', 'qode-lms' )
                        ),
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
	public function render( $atts, $content = null ) {
		$args   = array(
			'number_of_columns'    => '3',
			'space_between_items'  => 'normal',
			'number_of_items'      => '-1',
			'category'             => '',
			'selected_instructors' => '',
			'tag'                  => '',
			'orderby'              => 'date',
			'order'                => 'ASC',
			'instructor_layout'    => 'info-bellow',
			'instructor_slider'    => 'no',
			'slider_navigation'    => 'no',
			'slider_pagination'    => 'no',
			'name_title_tag'	   => '',
			'position_title_tag'   => '',
			'enable_excerpt'       => 'yes'
		);
		$params = shortcode_atts( $args, $atts );
		
		/***
		 * @params query_results
		 * @params holder_data
		 * @params holder_classes
		 */
		$additional_params = array();
		
		$query_array                        = $this->getQueryArray( $params );
		$query_results                      = new \WP_Query( $query_array );
		$additional_params['query_results'] = $query_results;
		
		$additional_params['holder_classes'] = $this->getHolderClasses( $params );
		$additional_params['inner_classes']  = $this->getInnerClasses( $params );
		$additional_params['data_attrs']     = $this->getDataAttribute( $params );

		if( $params['name_title_tag'] == '' ){
			$params['name_title_tag'] = 'h4';
		}

		if( $params['position_title_tag'] == '' ){
			$params['position_title_tag'] = 'h6';
		}
		
		$params['this_object'] = $this;
		
		$html = qode_lms_get_cpt_shortcode_module_template_part( 'instructor', 'instructor-holder', '', $params, $additional_params );
		
		return $html;
	}
	
	public function getQueryArray( $params ) {
		$query_array = array(
			'post_status'    => 'publish',
			'post_type'      => 'instructor',
			'posts_per_page' => $params['number_of_items'],
			'orderby'        => $params['orderby'],
			'order'          => $params['order']
		);
		
		if ( ! empty( $params['category'] ) ) {
			$query_array['instructor-category'] = $params['category'];
		}
		
		$instructor_ids = null;
		if ( ! empty( $params['selected_instructors'] ) ) {
			$instructor_ids          = explode( ',', $params['selected_instructors'] );
			$query_array['post__in'] = $instructor_ids;
		}
		
		return $query_array;
	}
	
	public function getHolderClasses( $params ) {
		$classes = array();
		
		$number_of_columns = $params['number_of_columns'];
		
		$classes[] = ! empty( $params['space_between_items'] ) ? 'qode-' . $params['space_between_items'] . '-space' : 'qode-pl-normal-space';
		
		if ( $params['instructor_slider'] !== 'yes' ) {
			switch ( $number_of_columns ):
				case '1':
					$classes[] = 'qode-tl-one-columns';
					break;
				case '2':
					$classes[] = 'qode-tl-two-columns';
					break;
				case '3':
					$classes[] = 'qode-tl-three-columns';
					break;
				case '4':
					$classes[] = 'qode-tl-four-columns';
					break;
				case '5':
					$classes[] = 'qode-tl-five-columns';
					break;
				default:
					$classes[] = 'qode-tl-three-columns';
					break;
			endswitch;
		} else {
			$classes[] = 'qode-tl-slider';
		}
		
		return implode( ' ', $classes );
	}
	
	public function getInnerClasses( $params ) {
		$classes   = array();
		$classes[] = 'qode-outer-space';
		
		if ( $params['instructor_slider'] === 'yes' ) {
			$classes[] = 'qode-owl-slider';
		}
		
		return implode( ' ', $classes );
	}
	
	private function getDataAttribute( $params ) {
		$data_attrs = array();
		
		$data_attrs['data-number-of-items']   = ! empty( $params['number_of_columns'] ) ? $params['number_of_columns'] : '3';
		$data_attrs['data-enable-navigation'] = ! empty( $params['slider_navigation'] ) ? $params['slider_navigation'] : '';
		$data_attrs['data-enable-pagination'] = ! empty( $params['slider_pagination'] ) ? $params['slider_pagination'] : '';
		
		return $data_attrs;
	}
	
	public function getInstructorSocialIcons( $id ) {
		$social_icons = array();
		
		for ( $i = 1; $i < 6; $i ++ ) {
			$instructor_icon_pack = get_post_meta( $id, 'qode_instructor_social_icon_pack_' . $i, true );
			if ( $instructor_icon_pack ) {
				$instructor_icon_coll     = bridge_qode_icon_collections()->getIconCollection( get_post_meta( $id, 'qode_instructor_social_icon_pack_' . $i, true ) );
				$instructor_social_icon   = get_post_meta( $id, 'qode_instructor_social_icon_pack_' . $i . '_' . $instructor_icon_coll->param, true );
				$instructor_social_link   = get_post_meta( $id, 'qode_instructor_social_icon_' . $i . '_link', true );
				$instructor_social_target = get_post_meta( $id, 'qode_instructor_social_icon_' . $i . '_target', true );
				
				if ( $instructor_social_icon !== '' ) {
					
					$instructor_icon_params                                 = array();
					$instructor_icon_params['icon_pack']                    = $instructor_icon_pack;
					$instructor_icon_params[ $instructor_icon_coll->param ] = $instructor_social_icon;
					$instructor_icon_params['link']                         = ( $instructor_social_link !== '' ) ? $instructor_social_link : '';
					$instructor_icon_params['target']                       = ( $instructor_social_target !== '' ) ? $instructor_social_target : '';
					
					$social_icons[] = bridge_qode_execute_shortcode( 'icons', $instructor_icon_params );
				}
			}
		}
		
		return $social_icons;
	}
	
	/**
	 * Filter instructor categories
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function instructorListCategoryAutocompleteSuggester( $query ) {
		global $wpdb;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.slug AS slug, a.name AS instructor_category_title
					FROM {$wpdb->terms} AS a
					LEFT JOIN ( SELECT term_id, taxonomy  FROM {$wpdb->term_taxonomy} ) AS b ON b.term_id = a.term_id
					WHERE b.taxonomy = 'instructor-category' AND a.name LIKE '%%%s%%'", stripslashes( $query ) ), ARRAY_A );
		
		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['slug'];
				$data['label'] = ( ( strlen( $value['instructor_category_title'] ) > 0 ) ? esc_html__( 'Category', 'qode-lms' ) . ': ' . $value['instructor_category_title'] : '' );
				$results[]     = $data;
			}
		}
		
		return $results;
	}
	
	/**
	 * Find instructor category by slug
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function instructorListCategoryAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get instructor category
			$instructor_category = get_term_by( 'slug', $query, 'instructor-category' );
			if ( is_object( $instructor_category ) ) {
				
				$instructor_category_slug  = $instructor_category->slug;
				$instructor_category_title = $instructor_category->name;
				
				$instructor_category_title_display = '';
				if ( ! empty( $instructor_category_title ) ) {
					$instructor_category_title_display = esc_html__( 'Category', 'qode-lms' ) . ': ' . $instructor_category_title;
				}
				
				$data          = array();
				$data['value'] = $instructor_category_slug;
				$data['label'] = $instructor_category_title_display;
				
				return ! empty( $data ) ? $data : false;
			}
			
			return false;
		}
		
		return false;
	}
	
	/**
	 * Filter instructors by ID or Title
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function instructorListIdAutocompleteSuggester( $query ) {
		global $wpdb;
		$instructor_id   = (int) $query;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT ID AS id, post_title AS title
					FROM {$wpdb->posts} 
					WHERE post_type = 'instructor' AND ( ID = '%d' OR post_title LIKE '%%%s%%' )", $instructor_id > 0 ? $instructor_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );
		
		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['id'];
				$data['label'] = esc_html__( 'Id', 'qode-lms' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'qode-lms' ) . ': ' . $value['title'] : '' );
				$results[]     = $data;
			}
		}
		
		return $results;
	}
	
	/**
	 * Find instructor by id
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function instructorListIdAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get instructor
			$instructor = get_post( (int) $query );
			if ( ! is_wp_error( $instructor ) ) {
				
				$instructor_id    = $instructor->ID;
				$instructor_title = $instructor->post_title;
				
				$instructor_title_display = '';
				if ( ! empty( $instructor_title ) ) {
					$instructor_title_display = ' - ' . esc_html__( 'Title', 'qode-lms' ) . ': ' . $instructor_title;
				}
				
				$instructor_id_display = esc_html__( 'Id', 'qode-lms' ) . ': ' . $instructor_id;
				
				$data          = array();
				$data['value'] = $instructor_id;
				$data['label'] = $instructor_id_display . $instructor_title_display;
				
				return ! empty( $data ) ? $data : false;
			}
			
			return false;
		}
		
		return false;
	}
}