<?php

class qodeNewsClassWidgetLayout1 extends qodeNewsPhpClassWidget {
    public function __construct() {
        parent::__construct(
            'qode_layout1_widget',
            esc_html__('Qode Layout 1 Widget', 'qode-news'),
            array( 'description' => esc_html__( 'Display a layout 1', 'qode-news'))
        );

        $this->setParams();
    }

    /**
     * Sets widget options
     */
	protected function setParams() {
    	// General Options - start
        $params_general_array = qode_news_get_widget_params_from_VC(qode_news_get_general_shortcode_params(array('block_proportion','layout_title','layout_title_tag')));
        // General Options - end

        // Post Item Options - start
        $params_post_item_array = qode_news_get_widget_params_from_VC(qode_news_get_post_item_shortcode_params());
        // Post Item Options - end

		$this->params = array_merge(
			array(
				array(
					'type'  => 'textfield',
					'name'  => 'widget_title',
					'title' => esc_html__( 'Widget Title', 'qode-news' )
				)
			),
			$params_general_array,
			$params_post_item_array,
			array(
				array(
					'type'  => 'dropdown',
					'name'  => 'display_image',
					'title' => esc_html__( 'Display Image', 'qode-news' ),
					'options' => array(
						'' => esc_html__('Default','qode-news'),
						'yes' => esc_html__('Yes','qode-news'),
						'no' => esc_html__('No','qode-news')
					)
				),
				array(
					'type'  => 'dropdown',
					'name'  => 'content_alignment',
					'title' => esc_html__( 'Content Alignment', 'qode-news' ),
					'options' => array(
						'left' => esc_html__('Left','qode-news'),
						'center' => esc_html__('Center','qode-news'),
						'right' => esc_html__('Right','qode-news')
					)
				),
				array(
					'type'  => 'dropdown',
					'name'  => 'show_numbers',
					'title' => esc_html__( 'Show Numbers', 'qode-news' ),
					'options' => array(
						'no' => esc_html__('No','qode-news'),
						'yes' => esc_html__('Yes','qode-news')
					)
				)
			)
		);
	}

    /**
     * Generates widget's HTML
     *
     * @param array $args args from widget area
     * @param array $instance widget's options
     */
    public function widget($args, $instance) {
        if (!is_array($instance)) { $instance = array(); }

        if ($instance['column_number'] == '') {
        	$instance['column_number'] = '1';
        }

		if ($instance['display_categories'] == '') {
			$instance['display_categories'] = 'no';
		}

        // Filter out all empty params
        $instance         = array_filter($instance, function($array_value) { return trim($array_value) != ''; });

        echo '<div class="widget qode-news-widget qode-news-layout1-widget">';
		    if ( ! empty( $instance['widget_title'] ) ) {
			    echo wp_kses_post( $args['before_title'] ) . esc_html( $instance['widget_title'] ) . wp_kses_post( $args['after_title'] );
		    }

            echo bridge_qode_execute_shortcode('qode_layout1', $instance); // XSS OK
        echo '</div>';
    }
}