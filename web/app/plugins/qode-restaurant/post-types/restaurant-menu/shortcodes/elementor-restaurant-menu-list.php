<?php

class QodeRestaurantElementorRestaurantMenu extends \Elementor\Widget_Base{
    public function get_name() {
        return 'bridge_restaurant_menu';
    }

    public function get_title() {
        return esc_html__( 'Restaurant Menu', 'qode-restaurant' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-restaurant-menu';
    }

    public function get_categories() {
        return [ 'qode-restaurant' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__( 'General', 'qode-restaurant' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'restaurant_menu_title',
            [
                'label' => esc_html__('Title', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'restaurant_menu_title_title_tag',
            [
                'label' => esc_html__('Title Tag', 'qode'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_title_tag(false),
                'default' => 'h3'
            ]
        );

        $this->add_control(
            'restaurant_menu_label',
            [
                'label' => esc_html__('Label', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'restaurant_menu_label_title_tag',
            [
                'label' => esc_html__('Label Title Tag', 'qode'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_title_tag(false),
                'default' => 'h6'
            ]
        );

        $this->add_control(
            'restaurant_menu_sublabel',
            [
                'label' => esc_html__('Sublabel', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'show_featured_image',
            [
                'label' => esc_html__('Show Featured Image?', 'qode-restaurant'),
                'description' => esc_html__('Use this option to show featured image of menu items', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_yes_no_select_array(true, true),
                'default' => ''
            ]
        );

        $this->add_control(
            'skin',
            [
                'label' => esc_html__('Skin', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'dark' => esc_html__('Dark', 'qode-restaurant'),
                    'light' => esc_html__('Light', 'qode-restaurant'),
                ],
                'default' => 'dark'
            ]
        );

        $this->add_control(
            'padding',
            [
                'label' => esc_html__('Padding (ex. 10px 10px 10px 10px)', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'query',
            [
                'label' => esc_html__('Query and Layout Options', 'qode-restaurant'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label' => esc_html__('Order By', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'menu_order' => esc_html__('Menu Order', 'qode-restaurant'),
                    'title' => esc_html__('Title', 'qode-restaurant'),
                    'date' => esc_html__('Date', 'qode-restaurant'),
                ],
                'default' => 'date'
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'ASC' => 'ASC',
                    'DESC' => 'DESC',
                ],
                'default' => 'ASC'
            ]
        );

        $this->add_control(
            'restaurant_menu_category',
            [
                'label' => esc_html__('Restaurant Menu Category', 'qode-restaurant'),
                'description' => esc_html__('Enter one cafe menu category slug (leave empty for showing all cafe menu categories)', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'number',
            [
                'label' => esc_html__('Number of Restaurant Menu Items', 'qode-restaurant'),
                'description' => esc_html__('(enter -1 to show all)', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '-1'
            ]
        );

        $this->add_control(
            'restaurant_menu_item_title_tag',
            [
                'label' =>  esc_html__('Item Title Tag', 'qode'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_title_tag(false),
                'default' => 'h5'
            ]
        );

        $this->add_control(
            'restaurant_menu_item_description_title_tag',
            [
                'label' =>  esc_html__('Item Description Title Tag', 'qode'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_title_tag(false),
                'default' => 'h6'
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $params = $this->get_settings_for_display();

        $query_array = $this->getQueryArray($params);
        $query_results = new \WP_Query($query_array);

        $listItemParams = array(
            'show_featured_image' => $params['show_featured_image'],
            'restaurant_menu_item_title_tag' => $params['restaurant_menu_item_title_tag'],
            'restaurant_menu_item_description_title_tag' => $params['restaurant_menu_item_description_title_tag']
        );

        $holderClasses = $this->getHolderClasses($params);
        $holderStyles = $this->getHolderStyle($params); ?>

        <div <?php echo bridge_qode_get_class_attribute($holderClasses); ?> <?php echo bridge_qode_get_inline_style($holderStyles); ?>>
            <div class="qode-restaurant-menu-list-holder-title-holder">
                <<?php echo esc_attr( $params['restaurant_menu_title_title_tag'] );?> class="qode-restaurant-menu-list-holder-title"><?php echo esc_attr($params['restaurant_menu_title'] ); ?> </<?php echo esc_attr( $params['restaurant_menu_title_title_tag'] );?>>
                    <<?php echo esc_attr($params['restaurant_menu_label_title_tag']); ?> class="qode-restaurant-menu-list-holder-label"><?php echo esc_attr($params['restaurant_menu_label']); ?>
                        <span><?php echo esc_attr( $params['restaurant_menu_sublabel'] ); ?></span>
                    </<?php echo esc_attr( $params['restaurant_menu_sublabel'] ); ?>>
            </div>

        <?php

        if($query_results->have_posts()) { ?>
            <ul class="qode-rml-holder">
            <?php
            while($query_results->have_posts()) {
                $query_results->the_post();
                echo qode_restaurant_get_shortcode_module_template_part('restaurant-menu', 'templates/restaurant-menu-list-item', '', $listItemParams);
            } ?>

            </ul>
            <?php wp_reset_postdata();
        } else { ?>
            <p><?php echo esc_html__('Sorry, no menu items matched your criteria.', 'qode-restaurant'); ?></p>
        <?php } ?>

        </div>

    <?php
    }

    /**
     * Generates menu list query attribute array
     *
     * @param $params
     *
     * @return array
     */
    public function getQueryArray($params){

        $query_array = array(
            'post_type' => 'qode-restaurant-menu',
            'orderby' =>$params['order_by'],
            'order' => $params['order'],
            'posts_per_page' => $params['number']
        );

        if(!empty($params['restaurant_menu_category'])){
            $query_array['tax_query'] = array(
                array(
                    'taxonomy' => 'qode-restaurant-menu-category',
                    'field' => 'slug',
                    'terms' => array ($params['restaurant_menu_category'])
                )
            );
            //$query_array['qode-restaurant-menu-category'] = $params['restaurant_menu_category'];
        }

        return $query_array;
    }

    private function getHolderClasses($params) {
        $classes = array('qode-restaurant-menu-list');

        if($params['show_featured_image'] === 'yes') {
            $classes[] = 'qode-rml-with-featured-image';
        }

        if($params['skin'] === 'light') {
            $classes[] = 'qode-rml-light';
        }

        return $classes;
    }

    private function getHolderStyle($params) {

        $style = '';
        if($params['padding'] !== '') {
            $style .= 'padding: '.$params['padding'].';';
        }

        return $style;
    }

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeRestaurantElementorRestaurantMenu() );