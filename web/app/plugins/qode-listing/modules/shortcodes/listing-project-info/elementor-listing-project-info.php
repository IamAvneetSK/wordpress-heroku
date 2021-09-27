<?php
namespace QodeListing\Lib\ElementorShortcodes;

use QodeListing\Lib\Core;

class QodeListingElementorListingProjectInfo extends \Elementor\Widget_Base{
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

    public function getAllListing(){
        $listings_array = array();

        $listings = get_posts([
            'post_type' => 'job_listing',
            'post_status' => 'publish',
            'numberposts' => -1
        ]);

        if( is_array( $listings ) && count( $listings ) > 0 ){
            foreach ($listings as $listing){
                $listings_array[$listing->ID] = $listing->post_title;
            }
        }

        return $listings_array;
    }

    public function get_name() {
        return 'bridge_listing_project_info';
    }

    public function get_title() {
        return esc_html__( 'Listing Project Info', 'qode-listing' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-listing-project-info';
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
            'project_id',
            [
                'label' => esc_html__( 'Selected Project', 'qode-listing' ),
                'description' => esc_html__( 'If you left this field empty then project ID will be of the current page', 'qode-listing' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'label_block' => 1,
                'options' => $this->getAllListing()

            ]
        );

        $this->add_control(
            'project_info_type',
            [
                'label' => esc_html__( 'Project Info Type', 'qode-listing' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'title' => esc_html__( 'Title', 'qode-listing' ),
                    'category' => esc_html__( 'Category', 'qode-listing' ),
                    'tag' => esc_html__( 'Tag', 'qode-listing' ),
                    'author' => esc_html__( 'Author', 'qode-listing' ),
                    'date' => esc_html__( 'Date', 'qode-listing' ),
                ],
                'default' => 'title'
            ]
        );

        $this->add_control(
            'project_info_title_type_tag',
            [
                'label' => esc_html__( 'Project Info Title Type Tag', 'qode-listing' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => qode_listing_get_title_tag(true, array('p' => 'p')),
                'default' => 'h4',
                'condition' => [
                    'project_info_type' => 'title'
                ]
            ]
        );

        $this->add_control(
            'project_info_title',
            [
                'label' =>  esc_html__( 'Project Info Title', 'qode-listing' ),
                'description' => esc_html__( 'Add project info title before project info element/s', 'qode-listing' ),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'project_info_title_tag',
            [
                'label' => esc_html__( 'Project Info Title Tag', 'qode-listing' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => qode_listing_get_title_tag(true, array('p' => 'p')),
                'condition' => [
                    'project_info_title!' => ''
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

        $project_id  = $params['project_id'] = !empty($params['project_id']) ? $params['project_id'] : get_the_ID();

        $html = '';

        $html .= '<div class="qode-listing-project-info">';

        if(!empty($project_info_title)) {
            $html .= '<'.esc_attr($project_info_title_tag).' class="qode-lpi-label">'.esc_html($project_info_title).'</'.esc_attr($project_info_title_tag).'>';
        }

        switch ($project_info_type) {
            case 'title':
                $html .= $this->getItemTitleHtml($params);
                break;
            case 'category':
                $html .= $this->getItemCategoryHtml($params);
                break;
            case 'tag':
                $html .= $this->getItemTagHtml($params);
                break;
            case 'author':
                $html .= $this->getItemAuthorHtml($params);
                break;
            case 'date':
                $html .= $this->getItemDateHtml($params);
                break;
            default:
                $html .= $this->getItemTitleHtml($params);
                break;
        }

        $html .= '</div>';

        echo bridge_qode_get_module_part( $html );
    }

    /**
     * Generates listing project title html based on id
     *
     * @param $params
     *
     * @return html
     */
    public function getItemTitleHtml($params){
        $html = '';
        $project_id = $params['project_id'];
        $title = get_the_title($project_id);
        $project_info_title_type_tag = $params['project_info_title_type_tag'];

        if(!empty($title)) {
            $html = '<'.esc_attr($project_info_title_type_tag).' itemprop="name" class="qode-lpi-title entry-title">';
            $html .= '<a itemprop="url" href="'.esc_url(get_the_permalink($project_id)).'">'.esc_html($title).'</a>';
            $html .= '</'.esc_attr($project_info_title_type_tag).'>';
        }

        return $html;
    }

    /**
     * Generates listing project categories html based on id
     *
     * @param $params
     *
     * @return html
     */
    public function getItemCategoryHtml($params){

        $html = qode_listing_get_listing_categories_by_listing_id($params['project_id']);
        return $html;
    }

    /**
     * Generates portfolio project tags html based on id
     *
     * @param $params
     *
     * @return html
     */
    public function getItemTagHtml($params){
        $html = '';
        $project_id = $params['project_id'];
        $tags = wp_get_post_terms($project_id, 'job_listing_tag');

        if(!empty($tags)) {
            $html = '<div class="qode-lpi-tag">';
            foreach ($tags as $tag) {
                $html .= '<a itemprop="url" class="qode-lpi-tag-item" href="'.esc_url(get_term_link($tag->term_id)).'">'.esc_html($tag->name).'</a>';
            }
            $html .= '</div>';
        }

        return $html;
    }

    /**
     * Generates listing project authors html based on id
     *
     * @param $params
     *
     * @return html
     */
    public function getItemAuthorHtml($params){
        $html = '';
        $project_id = $params['project_id'];
        $project_post = get_post($project_id);
        $autor_id = $project_post->post_author;
        $author = get_the_author_meta('display_name', $autor_id);

        if(!empty($author)) {
            $html = '<div class="qode-lpi-author">'.esc_html($author).'</div>';
        }

        return $html;
    }

    /**
     * Generates listing project date html based on id
     *
     * @param $params
     *
     * @return html
     */
    public function getItemDateHtml($params){
        $html = '';
        $project_id = $params['project_id'];
        $date = get_the_time(get_option('date_format'), $project_id);

        if(!empty($date)) {
            $html = '<div class="qode-lpi-date">'.esc_html($date).'</div>';
        }

        return $html;
    }


}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeListingElementorListingProjectInfo() );