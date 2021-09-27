<?php

class QodeLmsCourseSearch extends \Elementor\Widget_Base{
    public function get_name() {
        return 'bridge_course_search';
    }

    public function get_title() {
        return esc_html__( 'Course Search', 'qode-lms' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-course-search';
    }

    public function get_categories() {
        return [ 'qode-lms' ];
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
            'enable_category',
            [
                'label' => esc_html__( 'Enable Category', 'qode-lms' ),
                'description' => esc_html__( 'Enable category as parameter for search', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'enable_instructor',
            [
                'label' => esc_html__( 'Enable Instructor', 'qode-lms' ),
                'description' => esc_html__( 'Enable instructor as parameter for search', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'enable_price',
            [
                'label' => esc_html__( 'Enable Price', 'qode-lms' ),
                'description' => esc_html__( 'Enable price as parameter for search', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'button_styles',
            [
                'label' => esc_html__( 'Button Style', 'qode-lms' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__( 'Button Text', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Search', 'qode-lms' ),
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label' => esc_html__( 'Button Type', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'solid' => esc_html__( 'Solid', 'qode-lms' ),
                    'outline' => esc_html__( 'Outline', 'qode-lms' ),
                ],
                'default' => 'solid'
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label' => esc_html__( 'Button Size', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'Default', 'qode-lms' ),
                    'small' => esc_html__( 'Small', 'qode-lms' ),
                    'medium' => esc_html__( 'Medium', 'qode-lms' ),
                    'large' => esc_html__( 'Large', 'qode-lms' ),
                ],
                'default' => 'medium',
                'condition' => [
                    'button_type' => ['solid', 'outline']
                ]
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Button Color', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::COLOR
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => esc_html__( 'Button Hover Color', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::COLOR
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => esc_html__( 'Button Background Color', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'button_type' => 'solid'
                ]
            ]
        );

        $this->add_control(
            'button_hover_background_color',
            [
                'label' => esc_html__( 'Button Hover Background Color', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::COLOR
            ]
        );

        $this->add_control(
            'button_border_color',
            [
                'label' => esc_html__( 'Button Border Color', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::COLOR
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => esc_html__( 'Button Hover Border Color', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::COLOR
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $params = $this->get_settings_for_display();

        $params['button_parameters'] = $this->getButtonParameters( $params );

        $html = '<form role="search" method="get" class="searchform qode-advanced-course-search" action="' . esc_url( home_url( "/" ) ) . '">';
        $html .= '<div class="input-holder clearfix">';
        $html .= '<input type="hidden" name="s" value="" />';
        $html .= '<input type="hidden" name="qode-course-search" value="yes" />';
        if ( ! empty( $params['enable_category'] ) && $params['enable_category'] == 'yes' ) {
            $html .= '<select name="qode-course-category">';
            $html .= $this->getCourseCategories( $params );
            $html .= '</select>';
        }
        if ( ! empty( $params['enable_instructor'] ) && $params['enable_instructor'] == 'yes' ) {
            $html .= '<select name="qode-course-instructor">';
            $html .= $this->getCourseInstructors( $params );
            $html .= '</select>';
        }
        if ( ! empty( $params['enable_price'] ) && $params['enable_price'] == 'yes' ) {
            $html .= '<select name="qode-course-price">';
            $html .= $this->getCoursePrice( $params );
            $html .= '</select>';
        }
        $html .= bridge_core_get_button_html( $params['button_parameters'] );
        $html .= '</div>';
        $html .= '</form>';

        echo bridge_qode_get_module_part( $html );
    }

    private function getCourseCategories( $params ) {
        $terms_args               = array();
        $terms_args['taxonomy']   = 'course-category';
        $terms_args['hide_empty'] = true;
        $terms                    = get_terms( $terms_args );

        $html = '<option value="all">' . esc_html__( "All", "qode-lms" ) . '</option>';
        foreach ( $terms as $term ) {
            if ( isset( $params['selected_category'] ) && $params['selected_category'] == $term->slug ) {
                $html .= '<option selected value="' . $term->slug . '">';
            } else {
                $html .= '<option value="' . $term->slug . '">';
            }
            $html .= $term->name;
            $html .= '</option>';
        }

        return $html;
    }

    private function getCourseInstructors( $params ) {
        $html              = '';
        $instructors_array = array();

        //Get unique instructors IDs that are set for courses
        $instructors_from_meta_array = array();
        global $wpdb;
        $instructors_from_meta = $wpdb->get_results( "SELECT DISTINCT meta_value FROM $wpdb->postmeta pm WHERE meta_key  = 'qode_course_instructor_meta'", ARRAY_A );
        foreach ( $instructors_from_meta as $instructor ) {
            $instructors_from_meta_array[] = $instructor['meta_value'];
        }

        //Get all instructors and store only the ones that are set for some course
        $instructors_query_array = array(
            'post_status'    => 'publish',
            'post_type'      => 'instructor',
            'posts_per_page' => '-1',
            'orderby'        => 'name',
            'order'          => 'ASC'
        );

        $instructors_query       = new \WP_Query( $instructors_query_array );
        $instructors             = $instructors_query->posts;
        if ( ! empty( $instructors ) ) {
            foreach ( $instructors as $instructor ) {
                if ( in_array( $instructor->ID, $instructors_from_meta_array ) ) {
                    $instructors_array[] = $instructor;
                }
            }
        }

        wp_reset_postdata();

        $html .= '<option value="all">' . esc_html__( "All", "qode-lms" ) . '</option>';
        foreach ( $instructors_array as $instructor ) {
            if ( isset( $params['selected_instructor'] ) && $params['selected_instructor'] == $instructor->ID ) {
                $html .= '<option selected value="' . $instructor->ID . '">';
            } else {
                $html .= '<option value="' . $instructor->ID . '">';
            }
            $html .= $instructor->post_title;
            $html .= '</option>';
        }

        return $html;
    }

    private function getCoursePrice( $params ) {
        $prices = array(
            'all'  => esc_html__( "All", "qode-lms" ),
            'free' => esc_html__( "Free", "qode-lms" ),
            'paid' => esc_html__( "Paid", "qode-lms" )
        );

        $html = '';
        foreach ( $prices as $key => $value ) {
            if ( isset( $params['selected_price'] ) && $params['selected_price'] == $key ) {
                $html .= '<option selected value="' . $key . '">';
            } else {
                $html .= '<option value="' . $key . '">';
            }
            $html .= $value;
            $html .= '</option>';
        }

        return $html;
    }

    private function getButtonParameters( $params ) {
        $button_params_array = array();

        $button_params_array['html_type'] = 'button';

        if ( ! empty( $params['button_text'] ) ) {
            $button_params_array['text'] = $params['button_text'];
        }

        if ( ! empty( $params['button_type'] ) ) {
            $button_params_array['type'] = $params['button_type'];
        }

        if ( ! empty( $params['button_size'] ) ) {
            $button_params_array['size'] = $params['button_size'];
        }

        if ( ! empty( $params['button_link'] ) ) {
            $button_params_array['link'] = $params['button_link'];
        }

        $button_params_array['target'] = ! empty( $params['button_target'] ) ? $params['button_target'] : '_self';

        if ( ! empty( $params['button_color'] ) ) {
            $button_params_array['color'] = $params['button_color'];
        }

        if ( ! empty( $params['button_hover_color'] ) ) {
            $button_params_array['hover_color'] = $params['button_hover_color'];
        }

        if ( ! empty( $params['button_background_color'] ) ) {
            $button_params_array['background_color'] = $params['button_background_color'];
        }

        if ( ! empty( $params['button_hover_background_color'] ) ) {
            $button_params_array['hover_background_color'] = $params['button_hover_background_color'];
        }

        if ( ! empty( $params['button_border_color'] ) ) {
            $button_params_array['border_color'] = $params['button_border_color'];
        }

        if ( ! empty( $params['button_hover_border_color'] ) ) {
            $button_params_array['hover_border_color'] = $params['button_hover_border_color'];
        }

        return $button_params_array;
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeLmsCourseSearch() );