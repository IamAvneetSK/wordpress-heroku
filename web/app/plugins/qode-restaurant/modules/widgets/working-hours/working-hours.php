<?php

class QodeRestaurantWorkingHours extends WP_Widget {

    protected $params;

    public function __construct() {
        parent::__construct(
            'qode_restaurant_working_hours',
            esc_html__('Qode Restaurant Working Hours', 'qode-restaurant'),
            array( 'description' => esc_html__( 'Add Restaurant Working Hour Widget', 'qode-restaurant'))
        );

        $this->setParams();
    }

    /**
     * Sets widget options
     */
    protected function setParams() {
        $this->params = array(
            array(
                'type'    => 'textfield',
                'name'    => 'title',
                'title'   => esc_html__('Title', 'qode-restaurant')
            ),
            array(
                'type'    => 'textfield',
                'name'    => 'label',
                'title'   => esc_html__('Label', 'qode-restaurant'),
                'options' => array(
                )
            ),
            array(
                'type'    => 'textfield',
                'name'    => 'sublabel',
                'title'   => esc_html__('Sublabel', 'qode-restaurant')
            ),
            array(
                'type'    => 'dropdown',
                'name'    => 'items_title_tag',
                'title'   => esc_html__('Items Title Tag', 'qode-restaurant'),
                'options' => bridge_qode_get_title_tag(false)
            )

        );
    }

    public function getParams() {
        return $this->params;
    }

    /**
     * Generates widget's HTML
     *
     * @param array $args args from widget area
     * @param array $instance widget's options
     */
    public function widget($args, $instance) {
        $params = '';

        if (!is_array($instance)) { $instance = array(); }

        // Default values
        if (!isset($instance['items_title_tag'])) {
            $instance['items_title_tag'] = 'h4';
        }

        foreach ($instance as $key => $value) {
            if($value !== '') {
                $params .= $key .'='. esc_attr($value). ' ';
            }
        }

        echo '<div class="widget qode-restaurant-widget qode-restaurant-working-hours-widget">';
        echo do_shortcode("[qode_working_hours $params]"); // XSS OK
        echo '</div>';
    }

    public function form($instance) {
        foreach ($this->params as $param_array) {
            $param_name = $param_array['name'];
            ${$param_name} = isset( $instance[$param_name] ) ? esc_attr( $instance[$param_name] ) : '';
        }

        //user has connected with instagram. Show form
        foreach ($this->params as $param) {
            switch($param['type']) {
                case 'textfield':
                    ?>
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id( $param['name'] )); ?>"><?php echo
                            esc_html($param['title']); ?></label>
                        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( $param['name'] )); ?>" name="<?php echo esc_attr($this->get_field_name( $param['name'] )); ?>" type="text" value="<?php echo esc_attr( ${$param['name']} ); ?>" />
                    </p>
                    <?php
                    break;
                case 'dropdown':
                    ?>
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id( $param['name'] )); ?>"><?php echo
                            esc_html($param['title']); ?></label>
                        <?php if(isset($param['options']) && is_array($param['options']) && count($param['options'])) { ?>
                            <select class="widefat" name="<?php echo esc_attr($this->get_field_name( $param['name'] )); ?>" id="<?php echo esc_attr($this->get_field_id( $param['name'] )); ?>">
                                <?php foreach ($param['options'] as $param_option_key => $param_option_val) {
                                    $option_selected = '';
                                    if(${$param['name']} == $param_option_key) {
                                        $option_selected = 'selected';
                                    }
                                    ?>
                                    <option <?php echo esc_attr($option_selected); ?> value="<?php echo esc_attr($param_option_key); ?>"><?php echo esc_attr($param_option_val); ?></option>
                                <?php } ?>
                            </select>
                        <?php } ?>
                    </p>

                    <?php
                    break;
            }
        }
    }

}