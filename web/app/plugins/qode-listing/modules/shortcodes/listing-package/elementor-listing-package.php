<?php
namespace QodeListing\Lib\ElementorShortcodes;

use QodeListing\Lib\Core;

class QodeListingElementorListingPackage extends \Elementor\Widget_Base{
    private static $instance;
    private $basic_params;
    private $packages;

    public function __construct(array $data = [], $args = null)
    {
        self::$instance = $this;
        $this->setPackages();
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

    public function setPackages(){

        $this->packages = qode_listing_get_listing_packages();

    }

    public function getPackages(){

        return $this->packages;

    }

    public function get_name() {
        return 'bridge_listing_package';
    }

    public function get_title() {
        return esc_html__( 'Listing Packages', 'qode-listing' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-listing-packages';
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
            'listing_package_title',
            [
                'label' => esc_html__('Package Button Text', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'listing_package_link',
            [
                'label' => esc_html__('Package Button Link', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $params = $this->get_settings_for_display();
        $params['is_elementor_listing_package'] = true;

        $this->resetBasicParams();
        $this->setBasicParams($params);

        echo qode_listing_get_shortcode_module_template_part('templates/holder', 'listing-package', '', $params);
    }


}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeListingElementorListingPackage() );