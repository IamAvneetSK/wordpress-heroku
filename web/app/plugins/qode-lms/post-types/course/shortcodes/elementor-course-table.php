<?php

class QodeLmsCourseTable extends \Elementor\Widget_Base{
    public function get_name() {
        return 'bridge_course_table';
    }

    public function get_title() {
        return esc_html__( 'Course Table', 'qode-lms' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-course-table';
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
            'enable_instructor',
            [
                'label' => esc_html__( 'Enable Instructor', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'enable_price',
            [
                'label' => esc_html__( 'Enable Price', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'enable_students',
            [
                'label' => esc_html__( 'Enable Students', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'enable_category',
            [
                'label' => esc_html__( 'Enable Category', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $atts = $this->get_settings_for_display();

        $args   = array(
            'category'          => '',
            'selected_courses'  => '',
            'tag'               => '',
            'orderby'           => 'date',
            'order'             => 'ASC',
            'enable_instructor' => 'yes',
            'enable_price'      => 'no',
            'enable_students'   => 'yes',
            'enable_category'   => 'yes'
        );
        $params = shortcode_atts( $args, $atts );

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

        $params['col_number']  = $this->getColumnNumber( $params );
        $params['this_object'] = $this;

        echo qode_lms_get_cpt_shortcode_module_template_part( 'course', 'course-table', '', $params, $additional_params );
    }

    public function getColumnNumber( $params ) {
        $column_number = 2;

        if ( ! empty( $params['enable_instructor'] ) && $params['enable_instructor'] == 'yes' ) {
            $column_number ++;
        }
        if ( ! empty( $params['enable_price'] ) && $params['enable_price'] == 'yes' ) {
            $column_number ++;
        }
        if ( ! empty( $params['enable_students'] ) && $params['enable_students'] == 'yes' ) {
            $column_number ++;
        }
        if ( ! empty( $params['enable_category'] ) && $params['enable_category'] == 'yes' ) {
            $column_number ++;
        }

        return $column_number;
    }

    public function getQueryArray( $params ) {
        $query_array = array(
            'post_status' => 'publish',
            'post_type'   => 'course',
            'orderby'     => $params['orderby'],
            'order'       => $params['order']
        );

        if ( ! empty( $params['category'] ) ) {
            $query_array['course-category'] = $params['category'];
        }

        if ( ! empty( $params['selected_courses'] ) ) {
            $query_array['post__in'] = $params['selected_courses'];
        }

        if ( ! empty( $params['tag'] ) ) {
            $query_array['course-tag'] = $params['tag'];
        }

        if ( ! empty( $params['next_page'] ) ) {
            $query_array['paged'] = $params['next_page'];
        } else {
            $query_array['paged'] = 1;
        }

        return $query_array;
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeLmsCourseTable() );