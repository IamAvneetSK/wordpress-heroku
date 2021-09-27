<?php

class qodeNewsClassWidgetLayout2 extends qodeNewsPhpClassWidget {
    public function __construct() {
        parent::__construct(
            'qode_layout2_widget',
            esc_html__('Qode Layout 2 Widget', 'qode-news'),
            array( 'description' => esc_html__( 'Display a layout 2', 'qode-news'))
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
			$params_post_item_array
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

        if ($instance['display_excerpt'] == '') {
        	$instance['display_excerpt'] = 'no';
        }


        if ($instance['display_date'] == '') {
        	$instance['display_date'] = 'no';
        }

        // Filter out all empty params
        $instance         = array_filter($instance, function($array_value) { return trim($array_value) != ''; });
	    
	    $params = '';

        echo '<div class="widget qode-news-widget qode-news-layout2-widget">';
		    if ( ! empty( $instance['widget_title'] ) ) {
			    echo wp_kses_post( $args['before_title'] ) . esc_html( $instance['widget_title'] ) . wp_kses_post( $args['after_title'] );
		    }

            echo bridge_qode_execute_shortcode('qode_layout2', $instance); // XSS OK
        echo '</div>';
    }
}