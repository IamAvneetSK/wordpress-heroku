<?php
namespace QodeListing\Lib\ElementorShortcodes;

use QodeListing\Lib\Core;

class QodeListingElementorListingTestimonials extends \Elementor\Widget_Base{
    private static $instance;
    private $basic_params;

    public function __construct(array $data = [], $args = null)
    {
        self::$instance = $this;
        parent::__construct($data, $args);
    }

    public static function getInstance() {
        if(self::$instance == null) {
            return new self;
        }

        return self::$instance;
    }

    public function setBasicParams($params = array()){

        if(is_array($params) && count($params)){
            foreach($params as $param_key => $param_value){
                $this->basic_params[$param_key] = $param_value;
            }
        }

    }

    public function resetBasicParams(){
        if(is_array($this->basic_params) && count($this->basic_params)){
            foreach ($this->basic_params as $param_key => $param_value) {
                unset($this->basic_params[$param_key]);
            }
        }
    }

    public function getBasicParams(){
        return $this->basic_params;
    }

    public function getBasicParamByKey($key){
        return $this->basic_params[$key];
    }

    public function get_name() {
        return 'bridge_listing_testimonials';
    }

    public function get_title() {
        return esc_html__( 'Listing Testimonials', 'qode-listing' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-listing-testimonials';
    }

    public function get_categories() {
        return [ 'qode-listing' ];
    }

    private function getTestimonialCategories(){
        $testimonials_array = array();

        $testimonials = get_terms('testimonials_category', array(
            'hide_empty' => false,
        ));

        if( is_array( $testimonials ) && count( $testimonials ) > 0 ){
            foreach ($testimonials as $testimonial){
                $testimonials_array[$testimonial->term_id] = $testimonial->name;
            }
        }

        return $testimonials_array;
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
                'description' => esc_html__('Category Slug (leave empty for all)', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => 1,
                'options' => $this->getTestimonialCategories()
            ]
        );

        $this->add_control(
            'number',
            [
                'label' => esc_html__('Number', 'qode-listing'),
                'description' => esc_html__('Number of Testimonials', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
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
                    'ASC' => esc_html__('Ascending', 'qode-listing')
                ],
                'default' => 'DESC',
                'condition' => [
                    'order_by' => array('title', 'date')
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $params = $this->get_settings_for_display();
        $params['is_elementor'] = true;

        $this->resetBasicParams();
        $this->setBasicParams($params);
        extract($params);

        $params['query_results'] = new \WP_Query($this->getQueryArray());

        echo qode_listing_get_shortcode_module_template_part('templates/holder', 'listing-testimonials', '', $params);
    }

    public function getQueryArray(){

        $query_params = array(
            'post_type' => 'testimonials',
            'posts_per_page' => $this->getBasicParamByKey('number'),
            'order_by' => $this->getBasicParamByKey('order_by'),
            'order' => $this->getBasicParamByKey('order')
        );

        $testimonials_category = $this->getBasicParamByKey('category');
        if($testimonials_category !== ''){
            $query_params['testimonials_category'] = $testimonials_category;
        }

        return $query_params;

    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeListingElementorListingTestimonials() );