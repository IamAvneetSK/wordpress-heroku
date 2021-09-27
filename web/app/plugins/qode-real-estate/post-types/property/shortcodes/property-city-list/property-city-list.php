<?php

namespace QodefRE\CPT\Shortcodes\Property;

use QodefRE\Lib;

class PropertyCityList implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'qodef_property_city_list';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
		
		//Property city list filter
		add_filter( 'vc_autocomplete_qodef_property_city_list_city_callback', array(
			&$this,
			'portfolioCityAutocompleteSuggester',
		), 10, 1 ); // Get suggestion(find). Must return an array
		
		//Property city list render
		add_filter( 'vc_autocomplete_qodef_property_city_list_city_render', array(
			&$this,
			'portfolioCityAutocompleteRender',
		), 10, 1 ); // Get suggestion(find). Must return an array
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map( array(
					'name'                      => esc_html__( 'Qode Property City List', 'qode-real-estate' ),
					'base'                      => $this->getBase(),
					'category'                  => esc_html__( 'by QODE REAL ESTATE', 'qode-real-estate' ),
					'icon'                      => 'icon-wpb-property-city-list extended-custom-re-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array(
						array(
							'type'        => 'dropdown',
							'param_name'  => 'number_of_columns',
							'heading'     => esc_html__( 'Number of Columns', 'qode-real-estate' ),
							'value'       => array(
								esc_html__( 'Default', 'qode-real-estate' ) => '',
								esc_html__( 'One', 'qode-real-estate' )     => '1',
								esc_html__( 'Two', 'qode-real-estate' )     => '2',
								esc_html__( 'Three', 'qode-real-estate' )   => '3',
								esc_html__( 'Four', 'qode-real-estate' )    => '4',
								esc_html__( 'Five', 'qode-real-estate' )    => '5',
								esc_html__( 'Six', 'qode-real-estate' )     => '6'
							),
							'description' => esc_html__( 'Default value is Four', 'qode-real-estate' ),
							'save_always' => true
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'space_between_items',
							'heading'     => esc_html__( 'Space Between Cities', 'qode-real-estate' ),
							'value'       => array_flip( bridge_qode_get_space_between_items_array() ),
							'save_always' => true
						),
                        array(
							'type'        => 'dropdown',
							'param_name'  => 'title_tag',
							'heading'     => esc_html__( 'Title tag', 'qode-real-estate' ),
							'value'       => array_flip( bridge_qode_get_title_tag( false ) ),
							'save_always' => true
						),
						array(
							'type'        => 'autocomplete',
							'param_name'  => 'city',
							'heading'     => esc_html__( 'Show Only Cities with Listed Slugs', 'qode-real-estate' ),
							'settings'    => array(
								'multiple'      => true,
								'sortable'      => true,
								'unique_values' => true
							),
							'description' => esc_html__( 'Delimit slugs by comma (leave empty for all)', 'qode-real-estate' )
						)
					)
				) );
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
		$args = array(
			'number_of_columns'      => '4',
			'space_between_items'    => 'normal',
			'title_tag'              => 'h5',
			'city'                   => '',
			'slider'                 => 'no',
			'enable_loop'            => 'yes',
			'enable_autoplay'        => 'yes',
			'slider_speed'           => '5000',
			'slider_speed_animation' => '600',
			'enable_navigation'      => 'no',
			'navigation_skin'        => '',
			'enable_pagination'      => 'no',
			'pagination_skin'        => '',
			'pagination_position'    => '',
		);
		
		$params = shortcode_atts( $args, $atts );
		
		/***
		 * @params query_results
		 * @params holder_data
		 * @params holder_classes
		 * @params holder_inner_classes
		 */
		$additional_params = array();
		
		$property_cities           = $this->getTaxonomyList( $params );
		$params['property_cities'] = $property_cities;
		
		$params['holder_classes']       = $this->getHolderClasses( $params );
		$params['holder_inner_classes'] = $this->getHolderInnerClasses( $params );
		$params['slider_data']          = $this->getSliderData( $params );
		
		$params['item_layout'] = 'standard';
		$params['this_object'] = $this;
		
		$html = qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-city-list', 'holder', '', $params, $additional_params );
		
		return $html;
	}
	
	public function getSliderData( $params ) {
		$slider_data = array();
		
		$slider_data['data-number-of-items']        = ! empty( $params['number_of_columns'] ) ? $params['number_of_columns'] : '5';
		$slider_data['data-enable-loop']            = ! empty( $params['enable_loop'] ) ? $params['enable_loop'] : '';
		$slider_data['data-enable-autoplay']        = ! empty( $params['slider_autoplay'] ) ? $params['slider_autoplay'] : '';
		$slider_data['data-slider-speed']           = ! empty( $params['slider_speed'] ) ? $params['slider_speed'] : '5000';
		$slider_data['data-slider-speed-animation'] = ! empty( $params['slider_speed_animation'] ) ? $params['slider_speed_animation'] : '600';
		$slider_data['data-enable-navigation']      = ! empty( $params['enable_navigation'] ) ? $params['enable_navigation'] : '';
		$slider_data['data-pagination-skin']        = ! empty( $params['pagination-skin'] ) ? $params['pagination-skin'] : '';
		$slider_data['data-enable-pagination']      = ! empty( $params['enable_pagination'] ) ? $params['enable_pagination'] : '';
		
		return $slider_data;
	}
	
	/**
	 * Generates property cities list
	 *
	 *
	 * @return array
	 */
	public function getTaxonomyList( $params ) {
		
		if ( ! empty ( $params['city'] ) ) {
			$property_list = array();
			
			$list_of_cities = explode( ',', $params['city'] );
			
			foreach ( $list_of_cities as $city ) {
				$property_list[] = get_term_by( 'slug', $city, 'property-city' );
			}
		} else {
			$property_list = qodef_re_get_taxonomy_list( 'property-city', false, 'obj' );
		}
		
		return $property_list;
	}
	
	/**
	 * Generates property holder classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getHolderClasses( $params ) {
		$classes = array();
		
		$classes[] = ! empty( $params['space_between_items'] ) ? 'qode-' . $params['space_between_items'] . '-space' : 'qodef-normal-space';
		$classes[] = ! empty( $params['slider'] ) && $params['slider'] == 'yes' ? 'qodef-property-city-list-slider' : '';
		
		$number_of_columns = $params['number_of_columns'];
		switch ( $number_of_columns ):
			case '1':
				$classes[] = 'qodef-pcl-one-column';
				break;
			case '2':
				$classes[] = 'qodef-pcl-two-columns';
				break;
			case '3':
				$classes[] = 'qodef-pcl-three-columns';
				break;
			case '4':
				$classes[] = 'qodef-pcl-four-columns';
				break;
			case '5':
				$classes[] = 'qodef-pcl-five-columns';
				break;
			case '6':
				$classes[] = 'qodef-pcl-six-columns';
				break;
			default:
				$classes[] = 'qodef-pcl-three-columns';
				break;
		endswitch;
		
		return implode( ' ', $classes );
	}
	
	/**
	 * Generates property holder inner classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getHolderInnerClasses( $params ) {
		$classes = array();
		
		$classes[] = 'qode-outer-space';
		
		if ( isset( $params['slider'] ) && $params['slider'] == 'yes' ) {
			$classes[] = 'qode-owl-slider';
		}
		
		return implode( ' ', $classes );
	}
	
	/**
	 * Filter property cities
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function portfolioCityAutocompleteSuggester( $query ) {
		global $wpdb;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.slug AS slug, a.name AS property_city_title
					FROM {$wpdb->terms} AS a
					LEFT JOIN ( SELECT term_id, taxonomy  FROM {$wpdb->term_taxonomy} ) AS b ON b.term_id = a.term_id
					WHERE b.taxonomy = 'property-city' AND a.name LIKE '%%%s%%'", stripslashes( $query ) ), ARRAY_A );
		
		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['slug'];
				$data['label'] = ( ( strlen( $value['property_city_title'] ) > 0 ) ? esc_html__( 'Property City', 'qode-real-estate' ) . ': ' . $value['property_city_title'] : '' );
				$results[]     = $data;
			}
		}
		
		return $results;
	}
	
	/**
	 * Find property cities by slug
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function portfolioCityAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get portfolio category
			$property_city = get_term_by( 'slug', $query, 'property-city' );
			if ( is_object( $property_city ) ) {
				
				$portfolio_city_slug  = $property_city->slug;
				$portfolio_city_title = $property_city->name;
				
				$portfolio_city_title_display = '';
				if ( ! empty( $portfolio_city_title ) ) {
					$portfolio_city_title_display = esc_html__( 'Property City', 'qode-real-estate' ) . ': ' . $portfolio_city_title;
				}
				
				$data          = array();
				$data['value'] = $portfolio_city_slug;
				$data['label'] = $portfolio_city_title_display;
				
				return ! empty( $data ) ? $data : false;
			}
			
			return false;
		}
		
		return false;
	}
}