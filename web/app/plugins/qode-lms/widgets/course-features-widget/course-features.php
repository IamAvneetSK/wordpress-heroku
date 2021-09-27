<?php

class QodeCourseFeaturesWidget extends BridgeQodeWidget {
	public function __construct() {
		parent::__construct(
			'qode_course_features_widget',
			esc_html__( 'Qode Course Features Widget', 'qode-lms' ),
			array( 'description' => esc_html__( 'Display your course features', 'qode-lms' ) )
		);
		
		$this->setParams();
	}
	
	/**
	 * Sets widget options
	 */
	protected function setParams() {
		$this->params = array(
			array(
				'type'  => 'textfield',
				'name'  => 'widget_title',
				'title' => esc_html__( 'Widget Title', 'qode-lms' )
			),
			array(
				'type'  => 'textfield',
				'name'  => 'course_id',
				'title' => esc_html__( 'Course ID. If empty, current page ID will be used', 'qode-lms' )
			),
			array(
				'type'    => 'dropdown',
				'name'    => 'course_duration',
				'title'   => esc_html__( 'Show Course Duration', 'qode-lms' ),
				'options' => bridge_qode_get_yes_no_select_array( false, true )
			),
			array(
				'type'    => 'dropdown',
				'name'    => 'course_units',
				'title'   => esc_html__( 'Show Course Units', 'qode-lms' ),
				'options' => bridge_qode_get_yes_no_select_array( false, true )
			),
			array(
				'type'    => 'dropdown',
				'name'    => 'course_students',
				'title'   => esc_html__( 'Show Course Students', 'qode-lms' ),
				'options' => bridge_qode_get_yes_no_select_array( false, true )
			),
			array(
				'type'    => 'dropdown',
				'name'    => 'course_pass_percent',
				'title'   => esc_html__( 'Show Course Passing Percentage', 'qode-lms' ),
				'options' => bridge_qode_get_yes_no_select_array( false, true )
			),
			array(
				'type'    => 'dropdown',
				'name'    => 'course_retakes',
				'title'   => esc_html__( 'Show Course Maximum Retakes', 'qode-lms' ),
				'options' => bridge_qode_get_yes_no_select_array( false, true )
			)
		);
	}
	
	/**
	 * Generates widget's HTML
	 *
	 * @param array $args args from widget area
	 * @param array $instance widget's options
	 */
	public function widget( $args, $instance ) {
		if ( ! is_array( $instance ) ) {
			$instance = array();
		}
		
		// Filter out all empty params
		$instance = array_filter( $instance, function ( $array_value ) {
			return trim( $array_value ) != '';
		} );
		
		$params = '';
		//generate shortcode params
		foreach ( $instance as $key => $value ) {
			$params .= " $key='$value' ";
		}
		
		echo '<div class="widget qode-course-features-widget">';
			if ( ! empty( $instance['widget_title'] ) ) {
				echo wp_kses_post( $args['before_title'] ) . esc_html( $instance['widget_title'] ) . wp_kses_post( $args['after_title'] );
			}
			
			echo do_shortcode( "[qode_course_features $params]" ); // XSS OK
		echo '</div>';
	}
}