<?php

class QodeListingBlogList extends \Elementor\Widget_Base{
    public function get_name() {
        return 'bridge_listing_blog_list';
    }

    public function get_title() {
        return esc_html__( 'Listing Blog List', 'qode-listing' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-listing-blog-list';
    }

    public function get_categories() {
        return [ 'qode-listing' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__( 'General', 'qode-listing' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => esc_html__('Category', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->getPostCategories(),
                'description' => esc_html__('Category Slug (leave empty for all)', 'qode-listing')
            ]
        );

        $this->add_control(
            'number',
            [
                'label' => esc_html__('Number', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__('Number of posts', 'qode-listing'),
                'default' => -1
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label' => esc_html__('Order By', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'date' => esc_html__('Date', 'qode-listing'),
                    'title' => esc_html__('Title', 'qode-listing'),
                    'rand' => esc_html__('Random', 'qode-listing'),
                ],
                'default' => 'date'
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order Type', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'DESC' => esc_html__('Descending', 'qode-listing'),
                    'ASC' => esc_html__('Ascending', 'qode-listing'),
                ],
                'default' => 'DESC',
                'condition' => [
                    'order_by' => array('title', 'date')
                ]
            ]
        );

        $this->add_control(
            'text_length',
            [
                'label' => esc_html__('Text Legth', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 150
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__( 'Title Tag', 'qode-listing' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => qode_listing_get_title_tag( true ),
                'default' => 'h5'
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $params = $this->get_settings_for_display();

        $this->getQueryArray( $params );
        extract( $params );

        $query_results = new \WP_Query($this->getQueryArray( $params ));

        echo qode_listing_get_shortcode_module_template_part('templates/holder', 'listing-blog-list', '', array('query_results' => $query_results, 'params' => $params));
    }

    private function getPostCategories(){
        $categories_array = array();
        $categories = get_categories();

        if( is_array( $categories ) && count( $categories ) > 0 ){
            foreach ( $categories as $category ){
                $categories_array[$category->slug] = $category->name;
            }
        }

        return $categories_array;
    }

    public function getQueryArray( $params ){

        $query_params = array(
            'posts_per_page' => $params['number'],
            'order_by' => $params['order_by'],
            'order' => $params['order']
        );

        $category = $params['category'];
        if($category !== ''){
            $query_params['category_name'] = $category;
        }

        return $query_params;

    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeListingBlogList() );