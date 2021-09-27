<?php
namespace QodeListing\Lib\ElementorShortcodes;

use QodeListing\Lib\Core;

class QodeListingElementorListingList extends \Elementor\Widget_Base{
    private static $instance;
    private $basic_params;
    private $types;
    private $query;

    public function __construct(array $data = [], $args = null)
    {
        self::$instance = $this;
        $this->types = qode_listing_get_listing_types_VC_Array();
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

    public function getListingCategories(){
        $taxonomy = 'job_listing_category';
        $course_categories = get_terms($taxonomy); // Get all terms of a taxonomy
        $formatted_array = array();

        if( is_array($course_categories) && count( $course_categories ) > 0 ){
            foreach ( $course_categories as $course_category ){
                $formatted_array[ $course_category->slug ] = $course_category->name;
            }
        }

        return $formatted_array;

    }

    public function get_name() {
        return 'bridge_listing_list';
    }

    public function get_title() {
        return esc_html__( 'Listing List', 'qode-listing' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-listing-list';
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
            'listing_list_skin',
            [
                'label' => esc_html__('Skin', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'qode-listing'),
                    'light' => esc_html__('Light', 'qode-listing'),
                    'dark' => esc_html__('Dark', 'qode-listing'),
                ],
                'default' => ''
            ]
        );

        $this->add_control(
            'listing_type',
            [
                'label' => esc_html__('Listing Type', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array_flip( $this->types )
            ]
        );

        $this->add_control(
            'listing_category',
            [
                'label' => esc_html__('Listing Category', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->getListingCategories()
            ]
        );

        $this->add_control(
            'listing_list_number',
            [
                'label' => esc_html__('Number of items', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'listing_list_columns',
            [
                'label' => esc_html__('Number of columns', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'qode-listing'),
                    'one' => esc_html__('One Column', 'qode-listing'),
                    'two' => esc_html__('Two Column', 'qode-listing'),
                    'three' => esc_html__('Three Column', 'qode-listing'),
                    'four' => esc_html__('Four Column', 'qode-listing'),
                    'five' => esc_html__('Five Column', 'qode-listing'),
                    'six' => esc_html__('Six Column', 'qode-listing'),
                ]
            ]
        );

        $this->add_control(
            'show_content',
            [
                'label' => esc_html__('Show Excerpt', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'no' => esc_html__('No', 'qode-listing'),
                    'yes' => esc_html__('Yes', 'qode-listing'),
                ],
                'default' => 'no'
            ]
        );

        $this->add_control(
            'text_length',
            [
                'label' => esc_html__('Text Length', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => [
                    'show_content' => 'yes'
                ]
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
            'holder_classes' => $this->getHolderClasses()
        ));

        $query_results = qode_listing_get_listing_query_results($this->getQueryArray());

        $this->setQueryResults($query_results);

        echo qode_listing_get_shortcode_module_template_part('templates/holder', 'listing-list', '', $params);
    }

    public function getHolderClasses(){

        $classes = array(
            'qode-ls-list-normal-space'
        );

        $skin = $this->getBasicParamByKey('listing_list_skin');
        if($skin && $skin !== ''){
            $classes[] = 'qode-'.$skin.'-skin';
        }

        $column_number = $this->getBasicParamByKey('listing_list_columns');
        if($column_number && $column_number !== ''){
            $classes[] = 'qode-ls-list-'.$column_number.'-columns';
        }

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

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeListingElementorListingList() );
