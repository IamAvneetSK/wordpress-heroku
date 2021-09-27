<?php
namespace QodeListing\Lib\ElementorShortcodes;

use QodeListing\Lib\Core;

class QodeListingElementorAdvancedSearch extends \Elementor\Widget_Base{
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

    public function get_name() {
        return 'bridge_listing_advanced_search';
    }

    public function get_title() {
        return esc_html__( 'Listing Advanced Search', 'qode-listing' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-listing-advanced-search';
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
            'type',
            [
                'label' => esc_html__('Listing Type', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array_flip( $this->types )
            ]
        );

        $this->add_control(
            'number',
            [
                'label' => esc_html__('Number of items', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => -1
            ]
        );

        $this->add_control(
            'search_title',
            [
                'label' => esc_html__('Listing Title', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'search_subtitle',
            [
                'label' => esc_html__('Listing Subtitle', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'load_more',
            [
                'label' => esc_html__('Enable load more', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => qode_listing_get_yes_no_select_array(true)

            ]
        );

        $this->add_control(
            'content_in_grid',
            [
                'label' => esc_html__('Content in Grid', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => qode_listing_get_yes_no_select_array(true)

            ]
        );

        $this->add_control(
            'enable_map',
            [
                'label' => esc_html__('Enable Map', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => qode_listing_get_yes_no_select_array(true)

            ]
        );

        $this->add_control(
            'map_in_grid',
            [
                'label' => esc_html__('Map in Grid', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => qode_listing_get_yes_no_select_array(true),
                'condition' => [
                    'enable_map' => 'yes'
                ]

            ]
        );

        $this->add_control(
            'keyword_search',
            [
                'label' => esc_html__('Enable Keyword Search', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => qode_listing_get_yes_no_select_array(true)

            ]
        );

        $this->add_control(
            'enable_banner',
            [
                'label' => esc_html__('Sidebar Banner', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => qode_listing_get_yes_no_select_array(true)

            ]
        );

        $this->add_control(
            'banner_image',
            [
                'label' => esc_html__(  'Banner Image','qode-listing'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => [
                    'enable_banner' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'banner_title',
            [
                'label' => esc_html__('Banner title', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => [
                    'enable_banner' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'banner_text',
            [
                'label' => esc_html__('Banner text', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => [
                    'enable_banner' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'banner_link',
            [
                'label' => esc_html__('Banner link', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => [
                    'enable_banner' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'banner_link_text',
            [
                'label' => esc_html__('Banner link text', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => [
                    'enable_banner' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $params = $this->get_settings_for_display();
        $params['is_elementor'] = true;

        $this->resetBasicParams();
        $this->setBasicParams($params);
        extract($params);

        //get query results
        $query_results = null;

        $query_params = array(
            'post_number' => $number
        );

        if($type !== '') {
            $query_params['type'] = $type;
        } else{
            $query_params['post__in'] = array(0);
        }

        $query_results = qode_listing_get_listing_query_results($query_params);
        //set query results
        $this->setQueryResults($query_results);
        //init google map if is chosen in shortcode options
        $this->initGoogleMap();

        //add data param
        $this->setBasicParams(array(
            'data_params' => $this->getDattaParams(),
            'holder_classes' => $this->getHolderClasses(),
            'banner_html' => $this->getBannerHtml()
        ));

        echo qode_listing_get_shortcode_module_template_part('templates/holder', 'listing-advanced-search', '', $params);
    }

    private function getHolderClasses(){

        $classes = array();

        $map_flag = $this->getBasicParamByKey('enable_map') === 'yes' ? true : false ;

        if($map_flag){
            $classes[] = 'qode-ls-adv-with-map';
        }

        return implode(' ', $classes);

    }

    private function getDattaParams(){

        $dataString  = '';
        $params = $this->getBasicParams();

        if(get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif(get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        $params['max_num_pages'] = 0;
        $query_results = $this->getQueryResults();

        if($query_results && $query_results !== null){
            $params['max_num_pages'] = $query_results->max_num_pages;
        }

        if(isset($paged)) {
            $params['next_page'] = $paged+1;
        }

        foreach ($params as $key => $value) {
            if($value !== '') {
                $new_key = str_replace( '_', '-', $key );
                $dataString .= ' data-'.$new_key.'='.esc_attr($value);
            }
        }

        return $dataString;
    }

    public function getListingTypeHtml(){

        $html = '';
        $listing_types = qode_listing_get_listing_types_by_listing_id(get_the_ID());

        if(count($listing_types)){

            $html .= '<div class="qode-listing-type-wrapper">';
            foreach($listing_types as $type){
                $html .= '<a href="'.esc_url($type['link']).'">';
                $html .= '<span>'.esc_attr($type['name']).'</span>';
                $html .= '</a>';
            }

            $html .= '</div>';
        }

        return $html;

    }

    public function getListingCategoryHtml(){

        $html = qode_listing_get_listing_categories_by_listing_id(get_the_ID());
        return $html;

    }


    public function getListingAverageRating(){

        $html = '';
        $rating_obj = new Core\ListingRating(get_the_ID(), false, 'get_average_rating' );
        $html .= $rating_obj->getRatingHtml();

        return $html;
    }

    public function getAddressIconHtml(){

        $html = qode_listing_get_address_html(get_the_ID());
        return $html;

    }
    public function initGoogleMap(){
        $enable_map = $this->getBasicParamByKey('enable_map');
        if($enable_map === 'yes'){
            //generate multiple map global vars from current query results
            $map_array = array(
                'type' => 'multiple',
                'query' => $this->getQueryResults(),
                'init_multiple_map' => true
            );
            qode_listing_generate_listing_map_vars($map_array);
        }
    }

    public function getBannerHtml(){
        $html = '';

        $banner_flag = $this->getBasicParamByKey('enable_banner') === 'yes' ? true : false;
        $banner_image_id = $this->getBasicParamByKey('banner_image');
        $banner_image = wp_get_attachment_image_src( $banner_image_id, 'full' );
        $banner_text = $this->getBasicParamByKey('banner_text');
        $banner_title = $this->getBasicParamByKey('banner_title');
        $banner_link = $this->getBasicParamByKey('banner_link');
        $banner_link_text = $this->getBasicParamByKey('banner_link_text');

        if($banner_flag){

            if($banner_image !== ''){

                $html .= '<div class="qode-ls-adv-search-banner-holder">';

                $html .= '<div class="qode-ls-banner-image">';
                $html .= '<img src="'.esc_url($banner_image[0]).'" alt="qode-ls-adv-banner-image" title="qode-ls-adv-banner-image" />';
                $html .= '</div>';

                if($banner_title !== ''){
                    $html .= '<div class="qode-ls-banner-title">';
                    $html .= '<h5>'.esc_attr($banner_title).'</h5>';
                    $html .= '</div>';
                }
                if($banner_text !== ''){
                    $html .= '<div class="qode-ls-banner-text">';
                    $html .= '<span>'.esc_attr($banner_text).'</span>';
                    $html .= '</div>';
                }

                if($banner_link_text !== '' && $banner_link !== ''){

                    $button_params = array(
                        'text'			=> $banner_link_text,
                        'link'			=> $banner_link,
                        'custom_class'	=> 'qode-listing-button qode-button-shadow',
                        'type'			=> 'solid',
                        'html_type'		=> 'href'
                    );

                    $html .= bridge_core_get_button_html($button_params);
                }

                $html .= '</div>';

            }

        }

        return $html;

    }

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeListingElementorAdvancedSearch() );
