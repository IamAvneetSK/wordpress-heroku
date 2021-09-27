<?php
namespace QodeListing\Lib\ElementorShortcodes;

use QodeListing\Lib\Core;

class QodeListingElementorListingCategories extends \Elementor\Widget_Base{
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
        return 'bridge_listing_categories';
    }

    public function get_title() {
        return esc_html__( 'Listing Categories', 'qode-listing' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-listing-categories';
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
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array_flip( $this->types )
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => esc_html__( 'Show Only Listed Categories', 'qode-core' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->getListingCategories()
            ]
        );

        $this->add_control(
            'listing_cat_number',
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
            'number'     => $listing_cat_number
        );

        if($listing_type !== ''){
            $query_params['meta_key']  = 'listing_type';
            $query_params['meta_value']  = $listing_type;
        }else{
            if (!empty($params['category'])) {
                foreach ( $params['category'] as $category_slug ){
                    $category = get_term_by('slug', $category_slug, 'job_listing_category');
                    if( $category ){
                        $query_params['include'][] = $category->term_id;
                    }
                }
                $query_params['include_params'] = implode(',', $params['category']);
            }
        }

        $terms = qode_listing_get_listing_categories($query_params);

        $this->setQueryResults($terms);

        echo qode_listing_get_shortcode_module_template_part('templates/holder', 'listing-categories', '', $params);
    }

    public function getSelectedCategories(){
        $selected_cats = explode(',',$this->getBasicParamByKey('category'));
        $selected_cats_array = array();

        if(is_array($selected_cats) && count($selected_cats)){
            foreach ($selected_cats as $cat_slug){
                $cat =  get_term_by( 'slug', $cat_slug, 'job_listing_category');
                if($cat){
                    $selected_cats_array[] = $cat->term_id;
                }

            }
        }

        return $selected_cats_array;

    }

    public function getItemClasses($gallery_size, $gallery_type){

        $classes = array();

        if($gallery_size && $gallery_size !== ''){
            $classes[] = 'qode-ls-gallery-'.$gallery_size;
        }else{
            $classes[] = 'qode-ls-gallery-square-small';
        }

        if($gallery_type && $gallery_type !== ''){
            $classes[] = 'qode-ls-gallery-'.$gallery_type.'-type';
        }
        else{
            $classes[] = 'qode-ls-gallery-standard-type';
        }

        return implode($classes , ' ');
    }


    public function getImageUrl($term_id){
        $image_url_style = '';
        $image_id = get_term_meta($term_id, 'featured_image', true);
        if($image_id && $image_id !== ''){
            $image_url = wp_get_attachment_image_url( $image_id, 'full');
            $image_url_style = 'background-image: url('.esc_url($image_url).')';
        }
        return $image_url_style;
    }

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeListingElementorListingCategories() );