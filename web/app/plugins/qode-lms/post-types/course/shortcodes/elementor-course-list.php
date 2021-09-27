<?php

class QodeLmsCourseList extends \Elementor\Widget_Base{
    public function get_name() {
        return 'bridge_course_list';
    }

    public function get_title() {
        return esc_html__( 'Course List', 'qode-lms' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-course-list';
    }

    public function get_categories() {
        return [ 'qode-lms' ];
    }

    public function getCourseCategories(){
        $taxonomy = 'course-category';
        $course_categories = get_terms($taxonomy); // Get all terms of a taxonomy
        $formatted_array = array();

        if( is_array($course_categories) && count( $course_categories ) > 0 ){
            foreach ( $course_categories as $course_category ){
                $formatted_array[ $course_category->slug ] = $course_category->name;
            }
        }

        return $formatted_array;

    }

    public function getCourseTags(){
        global $wpdb;
        $formatted_array = array();

        $course_tags = $wpdb->get_results( $wpdb->prepare( "SELECT a.slug AS slug, a.name AS course_tag_title
					FROM {$wpdb->terms} AS a
					LEFT JOIN ( SELECT term_id, taxonomy  FROM {$wpdb->term_taxonomy} ) AS b ON b.term_id = a.term_id
					WHERE b.taxonomy = %s", 'course-tag' ), ARRAY_A );

        if( is_array( $course_tags ) && count( $course_tags ) > 1 ){
            foreach ( $course_tags as $course_tag ){
                $formatted_array[$course_tag['slug']] = $course_tag['course_tag_title'];
            }
        }

        return $formatted_array;
    }

    public function getAllCourses(){

        $formated_courses = array();

        $courses = get_posts([
            'post_type' => 'course',
            'post_status' => 'publish',
            'numberposts' => -1
        ]);

        foreach ($courses as $course) {
            $formated_courses[$course->ID] = $course->post_title;
        }

        return $formated_courses;
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__( 'General', 'qode-lms' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'number_of_columns',
            [
                'label' => esc_html__( 'Number of Columns', 'qode-lms' ),
                'description' => esc_html__( 'Default value is Three', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'Default', 'qode-lms' ),
                    '1' => esc_html__( 'One', 'qode-lms' ),
                    '2' => esc_html__( 'Two', 'qode-lms' ),
                    '3' => esc_html__( 'Three', 'qode-lms' ),
                    '4' => esc_html__( 'Four', 'qode-lms' ),
                    '5' => esc_html__( 'Five', 'qode-lms' ),
                ],
                'default' => '3'
            ]
        );

        $this->add_control(
            'space_between_items',
            [
                'label' => esc_html__( 'Space Between Courses', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_space_between_items_array(),
                'default' => 'normal'
            ]
        );

        $this->add_control(
            'number_of_items',
            [
                'label' => esc_html__( 'Number of Courses Per Page', 'qode-lms' ),
                'description' => esc_html__( 'Set number of items for your course list. Enter -1 to show all.', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '-1'
            ]
        );

        $this->add_control(
            'enable_image',
            [
                'label' => esc_html__( 'Enable Image', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'image_proportions',
            [
                'label' => esc_html__( 'Image Proportions', 'qode-lms' ),
                'description' => esc_html__( 'Set image proportions for your courses list.', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'full' => esc_html__( 'Original', 'qode-lms' ),
                    'square' => esc_html__( 'Square', 'qode-lms' ),
                    'landscape' => esc_html__( 'Landscape', 'qode-lms' ),
                    'portrait' => esc_html__( 'Portrait', 'qode-lms' ),
                    'thumbnail' => esc_html__( 'Thumbnail', 'qode-lms' ),
                    'medium' => esc_html__( 'Medium', 'qode-lms' ),
                    'large' => esc_html__( 'Large', 'qode-lms' ),
                ],
                'default' => 'full',
                'condition' => [
                    'enable_image' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => esc_html__( 'One-Category Course List', 'qode-lms' ),
                'description' => esc_html__( 'Enter one category slug (leave empty for showing all categories)', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->getCourseCategories(),
                'multiple' => false
            ]
        );

        $this->add_control(
            'selected_courses',
            [
                'label' => esc_html__( 'Show Only Selected Courses', 'qode-lms' ),
                'description' => esc_html__( 'Leave empty for all', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->getAllCourses(),
                'multiple' => true
            ]
        );

        $this->add_control(
            'tag',
            [
                'label' => esc_html__( 'One-Tag Courses List', 'qode-lms' ),
                'description' => esc_html__( 'Enter one tag slug (leave empty for showing all tags)', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->getCourseTags(),
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__( 'Order By', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_query_order_by_array(),
                'default' => 'date'
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__( 'Order', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_query_order_array(),
                'default' => 'DESC'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_layout',
            [
                'label' => esc_html__( 'Content Layout', 'qode-lms' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'item_layout',
            [
                'label' => esc_html__( 'Item Style', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'standard' =>  esc_html__( 'Standard ', 'qode-lms' ),
                    'minimal' =>  esc_html__( 'Minimal ', 'qode-lms' ),
                ],
                'default' => 'standard'
            ]
        );

        $this->add_control(
            'enable_title',
            [
                'label' => esc_html__( 'Enable Title', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes',
                'condition' => [
                    'item_layout' => 'standard'
                ]
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__( 'Title Tag', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_title_tag( false ),
                'default' => 'h5',
                'condition' => [
                    'enable_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'title_text_transform',
            [
                'label' => esc_html__( 'Title Text Transform', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_text_transform_array( true ),
                'default' => '',
                'condition' => [
                    'enable_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'enable_instructor',
            [
                'label' => esc_html__( 'Enable Instructor', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes',
                'condition' => [
                    'item_layout' => 'standard'
                ]
            ]
        );

        $this->add_control(
            'enable_price',
            [
                'label' => esc_html__( 'Enable Price', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes',
                'condition' => [
                    'item_layout' => 'standard'
                ]
            ]
        );

        $this->add_control(
            'enable_excerpt',
            [
                'label' => esc_html__( 'Enable Excerpt', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes',
                'condition' => [
                    'item_layout' => 'standard'
                ]
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__( 'Excerpt Length', 'qode-lms' ),
                'description' => esc_html__( 'Number of characters', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 60,
                'condition' => [
                    'enable_excerpt' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'enable_students',
            [
                'label' => esc_html__( 'Enable Students', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes',
                'condition' => [
                    'item_layout' => 'standard'
                ]
            ]
        );

        $this->add_control(
            'enable_category',
            [
                'label' => esc_html__( 'Enable Category', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes',
                'condition' => [
                    'item_layout' => 'standard'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'additional_features',
            [
                'label' => esc_html__( 'Additional Features', 'qode-lms' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pagination_type',
            [
                'label' => esc_html__( 'Pagination Type', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'no-pagination' => esc_html__( 'None', 'qode-lms' ),
                    'standard' => esc_html__( 'Standard', 'qode-lms' ),
                    'load-more' => esc_html__( 'Load More', 'qode-lms' ),
                    'infinite-scroll' => esc_html__( 'Infinite Scroll', 'qode-lms' ),
                ],
                'default' => 'no-pagination'
            ]
        );

        $this->add_control(
            'load_more_top_margin',
            [
                'label' => esc_html__( 'Load More Top Margin (px or %)', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => [
                    'pagination_type' => 'load-more'
                ]
            ]
        );

        $this->add_control(
            'filter',
            [
                'label' => esc_html__( 'Enable Filter', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false ),
                'default' => 'no'
            ]
        );

        $this->add_control(
            'enable_article_animation',
            [
                'label' => esc_html__( 'Enable Article Animation', 'qode-lms' ),
                'description' => esc_html__( 'Enabling this option you will enable appears animation for your course list items', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false ),
                'default' => 'no',
                'condition' => [
                    'item_layout' => 'standard'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $atts = $this->get_settings_for_display();

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


        $additional_params = array();

        $query_array                        = $this->getQueryArray( $params );
        $query_results                      = new \WP_Query( $query_array );
        $additional_params['query_results'] = $query_results;

        $additional_params['pagination_values']    = $this->getPaginationValues($params);
        $additional_params['holder_data']          = $this->getHolderData( $params, $additional_params );
        $additional_params['holder_classes']       = $this->getHolderClasses( $params );
        $additional_params['holder_inner_classes'] = $this->getHolderInnerClasses( $params );
        $additional_params['slug'] = '';

        $params['this_object'] = $this;

        echo qode_lms_get_cpt_shortcode_module_template_part( 'course', 'course-holder', '', $params, $additional_params );
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

        if (!empty($params['selected_courses'])) {
            $query_array['post__in'] = $params['selected_courses'];
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

        if (!empty($params['selected_courses'])) {
            $query_array['post__in'] = $params['selected_courses'];
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
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeLmsCourseList() );