<?php

class QodeCourseCategoriesWidget extends BridgeQodeWidget {
	public function __construct() {
		parent::__construct(
			'qode_course_categories_widget',
			esc_html__( 'Qode Course Categories Widget', 'qode-lms' ),
			array( 'description' => esc_html__( 'Display list of your course categories', 'qode-lms' ) )
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
				'name'  => 'number_of_items',
				'title' => esc_html__( 'Number of Categories', 'qode-lms' )
			),
			array(
				'type'        => 'textfield',
				'name'        => 'category',
				'title'       => esc_html__( 'Parent Category', 'qode-lms' ),
				'description' => esc_html__( 'Leave empty for all or fill in parent category slug', 'qode-lms' )
			),
			array(
				'type'    => 'dropdown',
				'name'    => 'order_by',
				'title'   => esc_html__( 'Order By', 'qode-lms' ),
				'options' => array(
					'name' => esc_html__( 'Name', 'qode-lms' ),
					'slug' => esc_html__( 'Slug', 'qode-lms' ),
					'id'   => esc_html__( 'ID', 'qode-lms' )
				)
			),
			array(
				'type'    => 'dropdown',
				'name'    => 'order',
				'title'   => esc_html__( 'Order', 'qode-lms' ),
				'options' => bridge_qode_get_query_order_array()
			),
			array(
				'type'    => 'dropdown',
				'name'    => 'title_tag',
				'title'   => esc_html__( 'Title Tag', 'qode-lms' ),
				'options' => bridge_qode_get_title_tag( true )
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
	    if ( ! is_array( $instance ) ) {
		    $instance = array();
	    }
	
	    $terms_args               = array();
	    $terms_args['taxonomy']   = 'course-category';
	    $terms_args['order_by']   = $instance['order_by'];
	    $terms_args['order']      = $instance['order'];
	    $terms_args['hide_empty'] = true;
	    // Filter out all empty params
	    if ( $instance['number_of_items'] != '' ) {
		    $terms_args['number'] = $instance['number_of_items'];
	    }
	    if ( $instance['category'] != '' ) {
		    $category               = get_term_by( 'slug', $instance['category'], 'course-category' );
		    $category_id            = $category->term_id;
		    $terms_args['child_of'] = $category_id;
	    }
	    $title_tag = $instance['title_tag'] != '' ? $instance['title_tag'] : 'h5';
	
	    $terms = get_terms( $terms_args );

        echo '<div class="widget qode-course-categories-widget">';
		    if ( ! empty( $instance['widget_title'] ) ) {
			    echo wp_kses_post( $args['before_title'] ) . esc_html( $instance['widget_title'] ) . wp_kses_post( $args['after_title'] );
		    }
		
		    if ( ! empty( $terms ) ) {
			    echo '<ul class="qode-course-categories-list">';
			    foreach ( $terms as $term ) {
				    echo '<li>';
				    echo '<' . $title_tag . ' class="qode-course-categories-list-title">';
				    if ( qode_lms_theme_installed() ) {
					    $icon_pack = get_term_meta( $term->term_id, 'course_category_icon_pack', true );
					    if ( $icon_pack != '' ) {
						    $iconPackName = bridge_qode_icon_collections()->getIconCollectionParamNameByKey( $icon_pack );
						    $icon         = get_term_meta( $term->term_id, 'course_category_icon_pack_' . $iconPackName, true );
						    if ( $icon != '' ) {
							    echo bridge_qode_icon_collections()->renderIcon( $icon, $icon_pack );
						    }
					    }
				    }
				    echo '<a href="' . get_term_link( $term->term_id ) . '" target="_self" itemprop="url">';
				    echo esc_html( $term->name );
				    echo '</a>';
				    echo '</' . $title_tag . '>';
				    echo '</li>';
			    }
			    echo '</ul>';
		    }
        echo '</div>';
    }
}