<?php

class QodeLmsCourseSlider extends \Elementor\Widget_Base{
    public function get_name() {
        return 'bridge_course_slider';
    }

    public function get_title() {
        return esc_html__( 'Course Slider', 'qode-lms' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-course-slider';
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
            'number_of_items',
            [
                'label' => esc_html__( 'Number of Course Items', 'qode-lms' ),
                'description' => esc_html__( 'Set number of items for your course slider. Enter -1 to show all', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '9'
            ]
        );

        $this->add_control(
            'number_of_columns',
            [
                'label' => esc_html__( 'Number of Columns', 'qode-lms' ),
                'description' => esc_html__( 'Number of courses that are showing at the same time in slider (on smaller screens is responsive so there will be less items shown). Default value is Four', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'Default', 'qode-lms' ),
                    '1' => esc_html__( 'One', 'qode-lms' ),
                    '2' => esc_html__( 'Two', 'qode-lms' ),
                    '3' => esc_html__( 'Three', 'qode-lms' ),
                    '4' => esc_html__( 'Four', 'qode-lms' ),
                    '5' => esc_html__( 'Five', 'qode-lms' ),
                ],
                'default' => '4'
            ]
        );

        $this->add_control(
            'space_between_items',
            [
                'label' => esc_html__( 'Space Between Course Items', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_space_between_items_array(),
                'default' => 'normal'
            ]
        );

        $this->add_control(
            'image_proportions',
            [
                'label' => esc_html__( 'Image Proportions', 'qode-lms' ),
                'description' => esc_html__( 'Set image proportions for your course slider.', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'full' => esc_html__( 'Original', 'qode-lms' ),
                    'square' => esc_html__( 'Square', 'qode-lms' ),
                    'landscape' => esc_html__( 'Landscape', 'qode-lms' ),
                    'portrait' => esc_html__( 'Portrait', 'qode-lms' ),
                    'medium' => esc_html__( 'Medium', 'qode-lms' ),
                    'large' => esc_html__( 'Large', 'qode-lms' ),
                ],
                'default' => 'full'
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
            'slider_settings',
            [
                'label' => esc_html__( 'Slider Settings', 'qode-lms' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'enable_loop',
            [
                'label' => esc_html__( 'Enable Slider Loop', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, false ),
                'default' => 'no'
            ]
        );

        $this->add_control(
            'enable_autoplay',
            [
                'label' => esc_html__( 'Enable Slider Autoplay', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'slider_speed',
            [
                'label' => esc_html__( 'Slide Duration', 'qode-lms' ),
                'description' => esc_html__( 'Default value is 5000 (ms)', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '5000'
            ]
        );

        $this->add_control(
            'slider_speed_animation',
            [
                'label' => esc_html__( 'Slide Animation Duration', 'qode-lms' ),
                'description' => esc_html__( 'Speed of slide animation in milliseconds. Default value is 600.', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '600'
            ]
        );

        $this->add_control(
            'enable_navigation',
            [
                'label' => esc_html__( 'Enable Slider Navigation Arrows', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'navigation_skin',
            [
                'label' => esc_html__( 'Navigation Skin', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'Default', 'qode-lms' ),
                    'light' => esc_html__( 'Light', 'qode-lms' ),
                    'dark' => esc_html__( 'Dark', 'qode-lms' ),
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
                'label' => esc_html__( 'Enable Slider Pagination', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'pagination_skin',
            [
                'label' => esc_html__( 'Pagination Skin', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'Default', 'qode-lms' ),
                    'light' => esc_html__( 'Light', 'qode-lms' ),
                    'dark' => esc_html__( 'Dark', 'qode-lms' ),
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
                'label' => esc_html__( 'Pagination Position', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'below-slider' => esc_html__( 'Below Slider', 'qode-lms' ),
                    'on-slider' => esc_html__( 'On Slider', 'qode-lms' )
                ],
                'default' => '',
                'condition' => [
                    'enable_pagination' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $atts = $this->get_settings_for_display();

        $args   = array(
            'number_of_items'        => '9',
            'number_of_columns'      => '4',
            'space_between_items'    => 'normal',
            'image_proportions'      => 'full',
            'category'               => '',
            'selected_projects'      => '',
            'tag'                    => '',
            'orderby'                => 'date',
            'order'                  => 'ASC',
            'item_layout'            => 'standard',
            'enable_title'           => 'yes',
            'title_tag'              => 'h5',
            'title_text_transform'   => '',
            'enable_instructor'      => 'yes',
            'enable_price'           => 'yes',
            'enable_excerpt'         => 'no',
            'excerpt_length'         => '20',
            'enable_students'        => 'yes',
            'enable_category'        => 'yes',
            'enable_loop'            => 'no',
            'enable_autoplay'        => 'yes',
            'slider_speed'           => '5000',
            'slider_speed_animation' => '600',
            'enable_navigation'      => 'yes',
            'navigation_skin'        => '',
            'enable_pagination'      => 'yes',
            'pagination_skin'        => '',
            'pagination_position'    => 'below-slider'
        );
        $params = shortcode_atts( $args, $atts );

        $params['course_slider_on'] = 'yes';

        $html = '<div class="qode-course-slider-holder">';
        $html .= bridge_qode_execute_shortcode( 'qode_course_list', $params );
        $html .= '</div>';

        echo bridge_qode_get_module_part( $html );

    }

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeLmsCourseSlider() );