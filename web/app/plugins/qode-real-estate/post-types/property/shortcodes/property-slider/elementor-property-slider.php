<?php

class QodeREPropertySlider extends \Elementor\Widget_Base{
	public function get_name() {
		return 'bridge_property_slider';
	}

	public function get_title() {
		return esc_html__( 'Property Slider', 'qode-real-estate' );
	}

	public function get_icon() {
		return 'bridge-elementor-custom-icon bridge-elementor-property-slider';
	}

	public function get_categories() {
		return [ 'qode-real-estate' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'general',
			[
				'label' => esc_html__( 'General', 'qode-real-estate' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'item_layout',
			[
				'label' => esc_html__('Item Layout', 'qode-real-estate'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'standard' => esc_html__('Standard', 'qode-real-estate'),
					'info-over' => esc_html__('Info Over', 'qode-real-estate'),
				],
				'default' => 'standard'
			]
		);

		$this->add_control(
			'number_of_columns',
			[
				'label' => esc_html__( 'Number of Columns', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'qode-real-estate' ),
					'1' => esc_html__( 'One', 'qode-real-estate' ),
					'2' => esc_html__( 'Two', 'qode-real-estate' ),
					'3' => esc_html__( 'Three', 'qode-real-estate' ),
					'4' => esc_html__( 'Four', 'qode-real-estate' ),
					'5' => esc_html__( 'Five', 'qode-real-estate' ),
				],
				'default' => '3'
			]
		);

		$this->add_control(
			'space_between_items',
			[
				'label' => esc_html__( 'Space Between Cities', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_space_between_items_array(),
			]
		);

		$this->add_control(
			'number_of_items',
			[
				'label' => esc_html__('Number of Properties Per Page', 'qode-real-estate'),
				'description' => esc_html__('Set number of items for your property list. Enter -1 to show all.', 'qode-real-estate'),
				'type' => \Elementor\Controls_Manager::TEXT
			]
		);

		$this->add_control(
			'order_by',
			[
				'label' => esc_html__('Order By', 'qode-real-estate'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_query_order_by_array()
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__('Order', 'qode-real-estate'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_query_order_array()
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__('Title Tag', 'qode-real-estate'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_title_tag(true, array('p' => 'p')),
				'condition' => [
					'enable_title' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_Settings',
			[
				'label' => esc_html__( 'Slider Settings', 'qode-real-estate' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_loop',
			[
				'label' => esc_html__( 'Enable Slider Loop', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array( false, true ),
			]
		);

		$this->add_control(
			'enable_autoplay',
			[
				'label' => esc_html__( 'Enable Slider Autoplay', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array( false, true ),
			]
		);

		$this->add_control(
			'slider_speed',
			[
				'label' => esc_html__( 'Slide Duration', 'qode-real-estate' ),
				'description' => esc_html__( 'Default value is 5000 (ms)', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'slider_speed_animation',
			[
				'label' => esc_html__( 'Slide Animation Duration', 'qode-real-estate' ),
				'description' => esc_html__( 'Speed of slide animation in milliseconds. Default value is 600.', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'enable_navigation',
			[
				'label' => esc_html__( 'Enable Slider Navigation Arrows', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array( false, false )
			]
		);

		$this->add_control(
			'navigation_skin',
			[
				'label' => esc_html__( 'Navigation Skin', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'qode-real-estate' ),
					'light' => esc_html__( 'Light', 'qode-real-estate' ),
					'dark' => esc_html__( 'Dark', 'qode-real-estate' ),
				],
				'default' => '',
				'condition' => [
					'enable_navigation' => 'yes'
				]
			]
		);

		$this->add_control(
			'enable_pagination',
			[
				'label' => esc_html__( 'Enable Slider Pagination', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array( false, false )
			]
		);

		$this->add_control(
			'pagination_skin',
			[
				'label' => esc_html__( 'Pagination Skin', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'qode-real-estate' ),
					'light' => esc_html__( 'Light', 'qode-real-estate' ),
					'dark' => esc_html__( 'Dark', 'qode-real-estate' ),
				],
				'default' => '',
				'condition' => [
					'enable_pagination' => 'yes'
				]
			]
		);

		$this->add_control(
			'pagination_position',
			[
				'label' => esc_html__( 'Pagination Position', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'below-slider' => esc_html__( 'Below Slider', 'qode-real-estate' ),
					'on-slider' => esc_html__( 'On Slider', 'qode-real-estate' ),
				],
				'default' => 'below-slider',
				'condition' => [
					'enable_pagination' => 'yes'
				]
			]
		);

		$this->end_controls_section();
	}

	protected function render(){
		$params = $this->get_settings_for_display();

		$args = array(
			'type'                      => 'slider',
			'item_layout'               => 'standard',
			'enable_fixed_proportions'  => 'no',
			'number_of_columns'         => '3',
			'space_between_items'       => 'medium',
			'number_of_items'           => '-1',
			'order_by'                  => 'date',
			'order'                     => 'DESC',
			'title_tag'                 => 'h5',
			'property_slider_on'        => 'yes',
			'enable_loop'               => 'yes',
			'enable_autoplay'		    => 'yes',
			'slider_speed'              => '5000',
			'slider_speed_animation'    => '600',
			'enable_navigation'         => 'no',
			'navigation_skin'           => '',
			'enable_pagination'         => 'no',
			'pagination_skin'           => '',
			'pagination_position'       => '',
		);
		$params = shortcode_atts($args, $params);

		if( ! isset( $params['hide_list'] ) ) {
			$params['hide_list'] = false;
		}


		echo '<div class="qodef-property-slider-holder">';
		$query_array = $this->getQueryArray($params);
		$query_results = new \WP_Query($query_array);
		$additional_params['query_results'] = $query_results;

		$additional_params['holder_data'] = qode_re_get_holder_data_for_cpt($params, $additional_params);
		$additional_params['holder_classes'] = $this->getHolderClasses($params, $additional_params);
		$additional_params['holder_inner_classes'] = $this->getHolderInnerClasses($params);
		$params['enable_compare'] = bridge_qode_options()->getOptionValue('enable_property_comparing') == 'yes' && $params['enable_compare'] == 'yes' ? 'yes' : 'no';

		$params['this_object'] = $this;

		echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'holder', $params['type'], $params, $additional_params);

		echo '</div>';
	}

	/**
	 * Generates property list query attribute array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function getQueryArray($params) {
		$query_array = array(
			'post_status'    => 'publish',
			'post_type'      => 'property',
			'posts_per_page' => $params['number_of_items'],
			'orderby'        => $params['order_by'],
			'order'          => $params['order']
		);

		$property_ids = null;
		if (!empty($params['selected_properties'])) {
			$property_ids = explode(',', $params['selected_properties']);
			$query_array['post__in'] = $property_ids;
		}

		// TAXONOMY QUERY VALUES
		if (!empty($params['property_type']) || !empty($params['property_status']) || !empty($params['property_city']) || !empty($params['property_features']) || !empty($params['property_county']) || !empty($params['property_neighborhood']) || !empty($params['property_tag'])) {
			$tax_query = array();

			if (!empty($params['property_type'])) {
				$property_tax = get_term( $params['property_type'], 'property-type' );
				if( ! is_wp_error($property_tax) && ! is_null( $property_tax ) ) {
					$tax_query[] = array(
						'taxonomy' => 'property-type',
						'terms'    => $params['property_type']
					);
				}
			}

			if (!empty($params['property_status'])) {
				$property_tax = get_term( $params['property_status'], 'property-status' );
				if( ! is_wp_error($property_tax) && ! is_null( $property_tax ) ) {
					$tax_query[] = array(
						'taxonomy' => 'property-status',
						'terms'    => $params['property_status']
					);
				}
			}

			if (!empty($params['property_city'])) {
				$property_tax = get_term( $params['property_city'], 'property-city' );
				if( ! is_wp_error($property_tax) && ! is_null( $property_tax ) ) {
					$tax_query[] = array(
						'taxonomy' => 'property-city',
						'terms'    => $params['property_city']
					);
				}
			}

			if (!empty($params['property_features'])) {
				$tax_query[] = array(
					'taxonomy' => 'property-feature',
					'terms'    => $params['property_features']
				);
			}

			if (!empty($params['property_county'])) {
				$tax_query[] = array(
					'taxonomy' => 'property-county',
					'terms'    => $params['property_county']
				);
			}

			if (!empty($params['property_neighborhood'])) {
				$tax_query[] = array(
					'taxonomy' => 'property-neighborhood',
					'terms'    => $params['property_neighborhood']
				);
			}

			if (!empty($params['property_tag'])) {
				$tax_query[] = array(
					'taxonomy' => 'property-tag',
					'terms'    => $params['property_tag']
				);
			}


			$query_array['tax_query'] = $tax_query;
		}

		// META QUERY VALUES
		if (!empty($params['property_min_size']) || !empty($params['property_max_size']) || !empty($params['property_min_price']) || !empty($params['property_max_price']) || !empty($params['property_contact']) || ! empty( $params['property_bedrooms'] ) || ! empty( $params['property_bathrooms'] )) {
			$meta_query = array();

			if (!empty($params['property_min_size']) || !empty($params['property_max_size'])) {
				$min_size = 0;
				$max_size = 999999999;
				if (!empty($params['property_min_size'])) {
					$min_size = $params['property_min_size'];

				}
				if (!empty($params['property_max_size'])) {
					$max_size = $params['property_max_size'];
				}
				$meta_query[] = array(
					'key'     => 'qodef_property_size_meta',
					'value'   => array($min_size, $max_size),
					'type'    => 'numeric',
					'compare' => 'BETWEEN'
				);
			}

			if (!empty($params['property_min_price']) || !empty($params['property_max_price'])) {
				$min_price = 0;
				$max_price = qodef_re_get_property_max_price_value();
				if (!empty($params['property_min_price'])) {
					$min_price = $params['property_min_price'];

				}
				if (!empty($params['property_max_price'])) {
					$max_price = $params['property_max_price'];
				}
				$meta_query[] = array(
					'key'     => 'qodef_property_price_meta',
					'value'   => array($min_price, $max_price),
					'type'    => 'numeric',
					'compare' => 'BETWEEN'
				);
			}

			if ( ! empty( $params['property_bedrooms'] ) ) {
				$meta_query[] = array(
					'key' => 'qodef_property_bedrooms_meta',
					'value' => $params['property_bedrooms'],
					'type' => 'numeric',
					'compare' => '='
				);
			}

			if ( ! empty( $params['property_bathrooms'] ) ) {
				$meta_query[] = array(
					'key' => 'qodef_property_bathrooms_meta',
					'value' => $params['property_bathrooms'],
					'type' => 'numeric',
					'compare' => '='
				);
			}

			if (!empty($params['property_contact'])) {
				$user_meta = get_userdata($params['property_contact']);
				$user_roles = $user_meta->roles;
				$user_role = $user_roles[0];

				$meta_query[] = array(
					'key'     => 'qodef_property_contact_' . $user_role . '_meta',
					'value'   => $params['property_contact'],
					'type'    => 'numeric',
					'compare' => '='
				);
			}

			$query_array['meta_query'] = $meta_query;
		}

		if (!empty($params['next_page'])) {
			$query_array['paged'] = $params['next_page'];
		} else {
			$query_array['paged'] = 1;
		}

		return $query_array;
	}

	/**
	 * Generates property holder classes
	 *
	 * @param $params
	 * @param $additional_params
	 *
	 * @return string
	 */
	public function getHolderClasses($params, $additional_params) {
		$classes = array();

		$classes[] = !empty($params['type']) ? 'qodef-pl-' . $params['type'] : 'qodef-pl-gallery';
		$classes[] = !empty($params['item_layout']) ? 'qodef-pl-layout-' . $params['item_layout'] : 'qodef-pl-layout-standard';
		$classes[] = !empty($params['enable_fixed_proportions']) && $params['enable_fixed_proportions'] === 'yes' ? 'qodef-pl-images-fixed' : '';
		$classes[] = !empty($params['space_between_items']) ? 'qode-' . $params['space_between_items'] . '-space' : 'qodef-medium-space';
		$classes[] = !empty($params['enable_map']) && $params['enable_map'] == 'yes' ? 'qodef-pl-with-map qodef-map-list-holder' : 'qodef-pl-no-map';
		$classes[] = !empty($params['hide_list']) && $params['hide_list'] == 'yes' ? 'qodef-pl-hide-list' : '';
		$classes[] = !empty($params['enable_filter']) && $params['enable_filter'] == 'yes' ? 'qodef-pl-with-filter' : 'qodef-pl-no-filter';
		$classes[] = !empty($params['property_type']) ? 'qodef-pl-type-set' : '';
		$classes[] = !empty($params['property_status']) ? 'qodef-pl-status-set' : '';
		$classes[] = !empty($params['property_city']) ? 'qodef-pl-city-set' : '';
		$classes[] = !empty($params['property_features']) ? 'qodef-pl-feature-set' : '';
		$classes[] = !empty($params['floating_price']) && $params['floating_price'] == 'yes' ? 'qodef-pl-with-floating-price' : '';
		$classes[] = !empty($params['content_alignment']) ? 'qodef-pl-text-align-' . $params['content_alignment'] : 'qodef-pl-text-align-left';
		$classes[] = !empty($additional_params['query_results']) && $additional_params['query_results']->have_posts() ? 'qodef-pl-properties-found' : 'qodef-pl-properties-not-found';

		$number_of_columns = $params['number_of_columns'];
		switch ($number_of_columns):
			case '1':
				$classes[] = 'qodef-pl-one-column';
				break;
			case '2':
				$classes[] = 'qodef-pl-two-columns';
				break;
			case '3':
				$classes[] = 'qodef-pl-three-columns';
				break;
			case '4':
				$classes[] = 'qodef-pl-four-columns';
				break;
			case '5':
				$classes[] = 'qodef-pl-five-columns';
				break;
			default:
				$classes[] = 'qodef-pl-three-columns';
				break;
		endswitch;

		$classes[] = !empty($params['pagination_type']) ? 'qodef-pl-pag-' . $params['pagination_type'] : '';
		$classes[] = !empty($params['navigation_skin']) ? 'qodef-nav-' . $params['navigation_skin'] . '-skin' : '';
		$classes[] = !empty($params['pagination_skin']) ? 'qodef-pag-' . $params['pagination_skin'] . '-skin' : '';
		$classes[] = !empty($params['pagination_position']) ? 'qodef-pag-' . $params['pagination_position'] : '';

		return implode(' ', $classes);
	}

	/**
	 * Generates property holder inner classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getHolderInnerClasses($params) {
		$classes = array();

		$classes[] = 'qode-outer-space';

		$classes[] = $params['property_slider_on'] === 'yes' ? 'qode-owl-slider qode-pl-is-slider' : '';
		$classes[] = !empty($params['enable_map']) && $params['enable_map'] == 'yes' ? 'qodef-ml-inner' : '';

		return implode(' ', $classes);
	}

	/**
	 * Generates property article classes
	 *
	 *
	 * @return string
	 */
	public function getArticleClasses($params) {
		$classes = array();
		$type = $params['type'];

		$classes[] = 'qode-item-space';

		$image_proportion = $params['enable_fixed_proportions'] === 'yes' ? 'fixed' : 'original';
		$masonry_size = get_post_meta(get_the_ID(), 'qodef_property_masonry_' . $image_proportion . '_dimensions_meta', true);
		$classes[] = !empty($masonry_size) && $type === 'masonry' ? 'qodef-pl-masonry-' . esc_attr($masonry_size) : '';

		$item_featured = get_post_meta(get_the_ID(), 'qodef_property_is_featured_meta', true);
		$classes[] = !empty($item_featured) && $item_featured === 'yes' ? 'qodef-item-featured' : '';

		$article_classes = get_post_class($classes);

		return implode(' ', $article_classes);
	}

	/**
	 * Generates property image size
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getImageSize($params) {
		$thumb_size = 'full';

		if (!empty($params['image_proportions']) && $params['type'] == 'gallery') {
			$image_size = $params['image_proportions'];

			switch ($image_size) {
				case 'landscape':
					$thumb_size = 'portfolio-landscape';
					break;
				case 'portrait':
					$thumb_size = 'portfolio-portrait';
					break;
				case 'square':
					$thumb_size = 'portfolio-square';
					break;
				case 'thumbnail':
					$thumb_size = 'thumbnail';
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

		if ($params['type'] == 'masonry' && $params['enable_fixed_proportions'] === 'yes') {
			$fixed_image_size = get_post_meta(get_the_ID(), 'qodef_property_masonry_fixed_dimensions_meta', true);

			switch ($fixed_image_size) {
				case 'default' :
					$thumb_size = 'portfolio_masonry_regular';
					break;
				case 'large-width':
					$thumb_size = 'portfolio_masonry_wide';
					break;
				case 'large-height':
					$thumb_size = 'portfolio_masonry_tall';
					break;
				case 'large-width-height':
					$thumb_size = 'portfolio_masonry_large';
					break;
				default :
					$thumb_size = 'full';
					break;
			}
		}

		return $thumb_size;
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

			if (bridge_qode_string_ends_with($margin, '%') || bridge_qode_string_ends_with($margin, 'px')) {
				$styles[] = 'margin-top: ' . $margin;
			} else {
				$styles[] = 'margin-top: ' . bridge_qode_filter_px($margin) . 'px';
			}
		}

		return implode(';', $styles);
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeREPropertySlider() );
