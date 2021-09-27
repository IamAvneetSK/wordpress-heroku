<?php
namespace QodeListing\Lib\ElementorShortcodes;

use QodeListing\Lib\Core;

class QodeListingElementorListingSlider extends \Elementor\Widget_Base{
    private static $instance;
    private $basic_params;
    private $types;
    private $cats;

    public function __construct(array $data = [], $args = null)
    {
        self::$instance = $this;
        $this->generateListingCatsArray();
        $this->generateListingTypeArray();
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

    public function setQueryResults($query){
        $this->query = $query;
    }
    public function getQueryResults(){
        return $this->query;
    }

    public function generateListingTypeArray(){
        $this->types = array_flip( qode_listing_get_listing_types_VC_Array() );
    }

    public function getListingTypes(){
        return $this->types;
    }

    public function generateListingCatsArray(){
        $this->cats = array_flip( qode_listing_categories_VC_ARRAY(true) );
    }

    public function get_name() {
        return 'bridge_listing_slider';
    }

    public function get_title() {
        return esc_html__( 'Listing Slider', 'qode-listing' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-listing-slider';
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
            'listing_type',
            [
                'label' => esc_html__('Listing Type', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => 1,
                'options' => $this->types
            ]
        );

        $this->add_control(
            'listing_category',
            [
                'label' => esc_html__('Listing Category', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => 1,
                'options' => $this->cats
            ]
        );

        $this->add_control(
            'listing_list_number',
            [
                'label' => esc_html__('Number of items', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => -1
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $params = $this->get_settings_for_display();
        $params['is_elementor'] = true;

        extract($params);

        $this->resetBasicParams();
        $this->setBasicParams($params);

        $this->setBasicParams(array(
            'holder_classes' => $this->getHolderClasses(),
            'data_params'    => $this->getDataParams()
        ));

        $query_results = qode_listing_get_listing_query_results($this->getQueryArray());


        $this->setQueryResults($query_results);

        echo qode_listing_get_shortcode_module_template_part('templates/holder', 'listing-slider','', $params);
    }

    public function getHolderClasses(){

        $classes = array(
            'qode-ls-slider-normal-space'
        );

        return implode(' ', $classes);
    }


    public function getQueryArray(){

        $query_params = array(
            'post_number' => $this->getBasicParamByKey('listing_list_number')
        );

        $type = $this->getBasicParamByKey('listing_type');
        $listing_category = $this->getBasicParamByKey('listing_category');

        if($type !== ''){
            $query_params['type'] = $type;
        }
        if($listing_category !== ''){
            $query_params['category_array'] = array($listing_category);
        }

        return $query_params;

    }

    public function getDataParams(){
        $slider_data = array();

        $slider_data['data-number-of-items']        = 4;
        $slider_data['data-enable-loop']            = 'yes';
        $slider_data['data-enable-autoplay']        = 'yes';
        $slider_data['data-enable-navigation']      = 'no';
        $slider_data['data-enable-pagination']      = 'yes';

        return $slider_data;
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeListingElementorListingSlider() );
