<?php

class QodeLmsInstructorSlider extends \Elementor\Widget_Base{
    public function get_name() {
        return 'bridge_instructor_slider';
    }

    public function get_title() {
        return esc_html__( 'Instructor Slider', 'qode-lms' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-course-instructor-slider';
    }

    public function get_categories() {
        return [ 'qode-lms' ];
    }

    public function getInstructorCategories(){
        $taxonomy = 'instructor-category';
        $course_categories = get_terms($taxonomy); // Get all terms of a taxonomy
        $formatted_array = array();

        if( is_array($course_categories) && count( $course_categories ) > 0 ){
            foreach ( $course_categories as $course_category ){
                $formatted_array[ $course_category->slug ] = $course_category->name;
            }
        }

        return $formatted_array;

    }

    public function getAllInstructors(){

        $formated_courses = array();

        $courses = get_posts([
            'post_type' => 'instructor',
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
                'label' => esc_html__( 'Number of Columns in Row', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '3' => esc_html__( 'Three', 'qode-lms' ),
                    '4' => esc_html__( 'Four', 'qode-lms' ),
                    '5' => esc_html__( 'Five', 'qode-lms' ),
                    '6' => esc_html__( 'Six', 'qode-lms' ),
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
            'category',
            [
                'label' => esc_html__( 'One-Category Course List', 'qode-lms' ),
                'description' => esc_html__( 'Enter one category slug (leave empty for showing all categories)', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->getInstructorCategories(),
                'multiple' => false
            ]
        );

        $this->add_control(
            'selected_instructors',
            [
                'label' => esc_html__( 'Show Only Selected Courses', 'qode-lms' ),
                'description' => esc_html__( 'Leave empty for all', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->getAllInstructors(),
                'multiple' => true
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

        $this->add_control(
            'instructor_layout',
            [
                'label' => esc_html__( 'Instructor Layout', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'info-bellow' => esc_html__( 'Info Bellow', 'qode-lms' ),
                    'info-hover' => esc_html__( 'Info on Hover', 'qode-lms' ),
                    'simple' => esc_html__( 'Simple', 'qode-lms' ),
                    'minimal' => esc_html__( 'Minimal', 'qode-lms' ),
                ],
                'default' => 'info-bellow'
            ]
        );

        $this->add_control(
            'slider_navigation',
            [
                'label' => esc_html__( 'Enable Slider Navigation Arrows', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'slider_pagination',
            [
                'label' => esc_html__( 'Enable Slider Pagination', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $atts = $this->get_settings_for_display();

        $default_atts = array(
            'number_of_columns'    => '3',
            'space_between_items'  => 'normal',
            'number_of_items'      => '-1',
            'category'             => '',
            'selected_instructors' => '',
            'tag'                  => '',
            'orderby'              => 'date',
            'order'                => 'ASC',
            'instructor_layout'    => 'info-bellow',
            'instructor_slider'    => 'yes',
            'slider_navigation'    => 'yes',
            'slider_pagination'    => 'yes'
        );
        $params = shortcode_atts( $default_atts, $atts );

        $html = '<div class="qode-instructor-slider-holder">';
        $html .= bridge_qode_execute_shortcode( 'qode_instructor_list', $params );
        $html .= '</div>';

        echo bridge_qode_get_module_part( $html );
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

        if ( ! empty( $params['selected_instructors'] ) ) {
            $query_array['post__in'] = $params['selected_instructors'];
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
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeLmsInstructorSlider() );