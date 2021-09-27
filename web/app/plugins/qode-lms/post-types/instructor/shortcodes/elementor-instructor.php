<?php

class QodeLmsInstructor extends \Elementor\Widget_Base{
    public function get_name() {
        return 'bridge_instructor';
    }

    public function get_title() {
        return esc_html__( 'Instructor', 'qode-lms' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-course-instructor';
    }

    public function get_categories() {
        return [ 'qode-lms' ];
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
            'instructor_id',
            [
                'label' => esc_html__( 'Select Instructor', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->getAllInstructors(),
                'multiple' => false
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $params = $this->get_settings_for_display();

        $params['instructor_id']           = ! empty( $params['instructor_id'] ) ? $params['instructor_id'] : get_the_ID();
        $params['image']                   = get_the_post_thumbnail( $params['instructor_id'] );
        $params['title']                   = get_the_title( $params['instructor_id'] );
        $params['position']                = get_post_meta( $params['instructor_id'], 'qode_instructor_title', true );
        $params['email']                   = get_post_meta( $params['instructor_id'], 'qode_instructor_email', true );
        $params['social']                  = get_post_meta( $params['instructor_id'], 'qode_instructor_social', true );
        $params['resume']                  = get_post_meta( $params['instructor_id'], 'qode_instructor_resume', true );
        $params['excerpt']                 = get_the_excerpt( $params['instructor_id'] );
        $params['instructor_social_icons'] = $this->getInstructorSocialIcons( $params['instructor_id'] );
        $params['name_title_tag'] = 'h4';
        $params['position_title_tag'] = 'h6';

        echo qode_lms_get_cpt_shortcode_module_template_part( 'instructor', 'instructor-template-' . $params['instructor_layout'], '', $params );
    }

    private function getInstructorSocialIcons( $id ) {
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

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeLmsInstructor() );