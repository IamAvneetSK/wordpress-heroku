<?php

class QodeLmsCourseFeatures extends \Elementor\Widget_Base{
    public function get_name() {
        return 'bridge_course_features';
    }

    public function get_title() {
        return esc_html__( 'Course Features', 'qode-lms' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-course-features';
    }

    public function get_categories() {
        return [ 'qode-lms' ];
    }

    public function getCourses(){
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
            'course_id',
            [
                'label' => esc_html__('Selected Course', 'qode-lms'),
                'description' => esc_html__( 'If you left this field empty then course ID will be of the current page', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->getCourses(),
                'multiple' => false,
                'default' => ''
            ]
        );

        $this->add_control(
            'course_duration',
            [
                'label' => esc_html__( 'Show Course Duration', 'qode-lms' ),
                'description' => esc_html__( 'If you left this field empty then course ID will be of the current page', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'course_units',
            [
                'label' => esc_html__( 'Show Course Units', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'course_students',
            [
                'label' => esc_html__( 'Show Course Students', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'course_pass_percent',
            [
                'label' => esc_html__( 'Show Course Passing Percentage', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'course_retakes',
            [
                'label' => esc_html__( 'Show Course Maximum Retakes', 'qode-lms' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array( false, true ),
                'default' => 'yes'
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $params = $this->get_settings_for_display();

        $params['course_id']           = ! empty( $params['course_id'] ) ? $params['course_id'] : get_the_ID();
        $params['course_duration']     = ! empty( $params['course_duration'] ) ? $params['course_duration'] : 'yes';
        $params['course_units']        = ! empty( $params['course_units'] ) ? $params['course_units'] : 'yes';
        $params['course_students']     = ! empty( $params['course_students'] ) ? $params['course_students'] : 'yes';
        $params['course_pass_percent'] = ! empty( $params['course_pass_percent'] ) ? $params['course_pass_percent'] : 'yes';
        $params['course_retakes']      = ! empty( $params['course_retakes'] ) ? $params['course_retakes'] : 'yes';

        $html = '<div class="qode-course-features-holder">';
            $html .= '<ul class="qode-course-features">';
                $html .= $this->getCourseDurationHtml( $params );
                $html .= $this->getCourseUnitsHtml( $params );
                $html .= $this->getCourseStudentsHtml( $params );
                $html .= $this->getCoursePassPercentageHtml( $params );
                $html .= $this->getCourseMaxRetakesHtml( $params );
            $html .= '</ul>';
        $html .= '</div>';

        echo bridge_qode_get_module_part( $html );
    }

    public function getCourseDurationHtml( $params ) {
        $html      = '';
        $course_id = $params['course_id'];

        $duration_value = get_post_meta( $course_id, 'qode_course_duration_meta', true );
        $duration_unit  = get_post_meta( $course_id, 'qode_course_duration_parameter_meta', true );
        if ( $params['course_duration'] == 'yes' && $duration_value != '' ) {
            $html = '<li class="qode-feature-item">';
            $html .= '<span class="qode-item-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>';
            $html .= '<span class="qode-item-label">' . esc_html__( 'Duration', 'qode-lms' ) . '</span>';
            $html .= '<span class="qode-item-value">' . $duration_value . ' ' . $duration_unit . '</span>';
            $html .= '</li>';
        }

        return $html;
    }

    public function getCourseUnitsHtml( $params ) {
        $html         = '';
        $lesson_count = 0;
        $quzz_count   = 0;
        $course_id    = $params['course_id'];

        $course_lectures = qode_lms_get_items_in_course( $course_id );
        foreach ( $course_lectures as $lecture ) {
            if ( get_post_type( $lecture ) == 'lesson' ) {
                $lesson_count ++;
            } else if ( get_post_type( $lecture ) == 'quiz' ) {
                $quzz_count ++;
            }
        }
        if ( $params['course_units'] == 'yes' ) {
            $html = '<li class="qode-feature-item">';
            $html .= '<span class="qode-item-icon"><i class="fa fa-folder-open" aria-hidden="true"></i></span>';
            $html .= '<span class="qode-item-label">' . esc_html__( 'Lectures', 'qode-lms' ) . '</span>';
            $html .= '<span class="qode-item-value">' . $lesson_count . '</span>';
            $html .= '</li>';

            $html .= '<li class="qode-feature-item">';
            $html .= '<span class="qode-item-icon"><i class="fa fa-list-alt" aria-hidden="true"></i></span>';
            $html .= '<span class="qode-item-label">' . esc_html__( 'Quizzes', 'qode-lms' ) . '</span>';
            $html .= '<span class="qode-item-value">' . $quzz_count . '</span>';
            $html .= '</li>';
        }

        return $html;
    }

    public function getCourseStudentsHtml( $params ) {
        $html      = '';
        $course_id = $params['course_id'];

        $students = get_post_meta( $course_id, 'qode_course_users_attended', true );

        if ( $params['course_students'] == 'yes' && $students != '' ) {
            $html = '<li class="qode-feature-item">';
            $html .= '<span class="qode-item-icon"><i class="lnr lnr-users" aria-hidden="true"></i></span>';
            $html .= '<span class="qode-item-label">' . esc_html__( 'Students', 'qode-lms' ) . '</span>';
            $html .= '<span class="qode-item-value">' . $students . '</span>';
            $html .= '</li>';
        }

        return $html;
    }

    public function getCoursePassPercentageHtml( $params ) {
        $html            = '';
        $course_id       = $params['course_id'];
        $pass_percentage = get_post_meta( $course_id, 'qode_course_passing_percentage_meta', true );

        if ( $params['course_pass_percent'] == 'yes' && $pass_percentage != '' ) {
            $html = '<li class="qode-feature-item">';
            $html .= '<span class="qode-item-icon"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span>';
            $html .= '<span class="qode-item-label">' . esc_html__( 'Pass Percentage', 'qode-lms' ) . '</span>';
            $html .= '<span class="qode-item-value">' . $pass_percentage . '</span>';
            $html .= '</li>';
        }

        return $html;
    }

    public function getCourseMaxRetakesHtml( $params ) {
        $html        = '';
        $course_id   = $params['course_id'];
        $max_retakes = get_post_meta( $course_id, 'qode_course_retake_number_meta', true );

        if ( $params['course_retakes'] == 'yes' && $max_retakes != '' ) {
            $html = '<li class="qode-feature-item">';
            $html .= '<span class="qode-item-icon"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span>';
            $html .= '<span class="qode-item-label">' . esc_html__( 'Max Retakes', 'qode-lms' ) . '</span>';
            $html .= '<span class="qode-item-value">' . $max_retakes . '</span>';
            $html .= '</li>';
        }

        return $html;
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeLmsCourseFeatures() );