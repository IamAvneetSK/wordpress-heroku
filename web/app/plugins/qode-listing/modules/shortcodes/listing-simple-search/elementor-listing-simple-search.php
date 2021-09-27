<?php
namespace QodeListing\Lib\ElementorShortcodes;

use QodeListing\Lib\Core;

class QodeListingElementorListingSimpleSearch extends \Elementor\Widget_Base{
    private static $instance;
    private $basic_params;
    private $types;
    private $regions;

    public function __construct(array $data = [], $args = null)
    {
        self::$instance = $this;
        $this->generateListingTypeArray();
        $this->generateListingRegionArray();
        parent::__construct($data, $args);
    }

    public static function getInstance() {
        if(self::$instance == null) {
            return new self;
        }

        return self::$instance;
    }

    public function generateListingTypeArray(){
        $types_array = qode_listing_get_listing_types(true);
        $this->types = $types_array['key_value'];
    }

    public function getListingTypes(){
        return $this->types;
    }

    public function generateListingRegionArray(){
        $region_array = qode_listing_get_listing_region(true);
        $this->regions = $region_array['key_value'];
    }

    public function getListingRegions(){
        return $this->regions;
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
        return 'bridge_listing_simple_search';
    }

    public function get_title() {
        return esc_html__( 'Listing Simple Search', 'qode-listing' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-listing-simple-search';
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
            'listing_search_keyword_text',
            [
                'label' => esc_html__('Enter keyword text', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Type in your keyword', 'qode-listing')
            ]
        );

        $this->add_control(
            'listing_search_button_text',
            [
                'label' => esc_html__('Enter button text', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Find Listings', 'qode-listing'),
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

        echo qode_listing_get_shortcode_module_template_part('templates/holder', 'listing-simple-search', '', $params);
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeListingElementorListingSimpleSearch() );