<?php
namespace QodeListing\Lib\ElementorShortcodes;

use QodeListing\Lib\Core;

class QodeListingElementorListingRegions extends \Elementor\Widget_Base{
    private static $instance;
    private $basic_params;
    private $types;
    private $query;

    public function __construct(array $data = [], $args = null)
    {
        self::$instance = $this;
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
        $this->types = qode_listing_get_listing_types_VC_Array();
    }

    private function getListingRegions(){
        $listing_regions_array = array();

        $listing_regions = get_terms('job_listing_region', array(
            'hide_empty' => false,
        ));

        if( is_array( $listing_regions ) && count( $listing_regions ) > 0 ){
            foreach ($listing_regions as $listing_region){
                $listing_regions_array[$listing_region->term_id] = $listing_region->name;
            }
        }

        return $listing_regions_array;

    }

    public function get_name() {
        return 'bridge_listing_regions';
    }

    public function get_title() {
        return esc_html__( 'Listing Regions', 'qode-listing' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-listing-regions';
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
            'region',
            [
                'label' => esc_html__( 'Show Only Listed Regions', 'qode-listing' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'label_block' => 1,
                'options' => $this->getListingRegions()

            ]
        );

        $this->add_control(
            'listing_region_number',
            [
                'label' => esc_html__('Number of items', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT

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

        $query_params = array(
            'number'     => $listing_region_number
        );

        if (!empty($params['region'])) {

            $query_params['include'] = $this->getSelectedRegions();
            $query_params['include_params'] = $params['region'];
        }

        $terms = qode_listing_get_listing_regions($query_params);
        $this->setQueryResults($terms);

        echo qode_listing_get_shortcode_module_template_part('templates/holder', 'listing-regions', '', $params);
    }

    public function getSelectedRegions(){

        $selected_cats = explode(',',$this->getBasicParamByKey('region'));
        $selected_cats_array = array();

        if(is_array($selected_cats) && count($selected_cats)){
            foreach ($selected_cats as $cat_slug){
                $cat =  get_term_by( 'slug', $cat_slug, 'job_listing_region');
                if($cat){
                    $selected_cats_array[] = $cat->term_id;
                }

            }
        }

        return $selected_cats_array;

    }

    public function getItemClasses($gallery_size, $gallery_type){

        $classes = array();


        return implode($classes , ' ');
    }

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeListingElementorListingRegions() );