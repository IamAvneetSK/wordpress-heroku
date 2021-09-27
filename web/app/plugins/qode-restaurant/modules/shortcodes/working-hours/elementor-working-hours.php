<?php

class QodeRestaurantElementorWorkingHours extends \Elementor\Widget_Base{
    public function get_name() {
        return 'bridge_working_hours';
    }

    public function get_title() {
        return esc_html__( 'Working Hours', 'qode-restaurant' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-working_hours';
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
            'title',
            [
                'label' => esc_html__('Title', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'label',
            [
                'label' => esc_html__('Label', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'sublabel',
            [
                'label' => esc_html__('Sublabel', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'items_title_tag',
            [
                'label' => esc_html__('Items Title Tag', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => bridge_qode_get_title_tag(false),
                'default' => 'h5'
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $params = $this->get_settings_for_display();

        $params['working_hours']  = $this->getWorkingHours();
        $params['holder_classes'] = $this->getHolderClasses($params);
        $params['holder_styles']  = $this->getHolderStyles($params);
        $params['item_styles']	  = $this->getItemStyles($params);

        echo qode_restaurant_get_template_part('modules/shortcodes/working-hours/templates/working-hours-template', '', $params, true);
    }

    protected function getWorkingHours() {
        $workingHours = array();

        if(qode_restaurant_theme_installed()) {
            //monday
            if(bridge_qode_options()->getOptionValue('wh_monday_from') !== '') {
                $workingHours['monday']['label'] = __('Monday', 'qode-restaurant');
                $workingHours['monday']['from']  = bridge_qode_options()->getOptionValue('wh_monday_from');
            }
            if(bridge_qode_options()->getOptionValue('wh_monday_description') !== '') {
                $workingHours['monday']['description']  = bridge_qode_options()->getOptionValue('wh_monday_description');
            }
            if(bridge_qode_options()->getOptionValue('wh_monday_to') !== '') {
                $workingHours['monday']['to'] = bridge_qode_options()->getOptionValue('wh_monday_to');
            }

            if(bridge_qode_options()->getOptionValue('wh_monday_closed') !== '') {
                $workingHours['monday']['closed'] = bridge_qode_options()->getOptionValue('wh_monday_closed');
            }

            //tuesday
            if(bridge_qode_options()->getOptionValue('wh_tuesday_from') !== '') {
                $workingHours['tuesday']['label'] = esc_html__('Tuesday', 'qode-restaurant');
                $workingHours['tuesday']['from']  = bridge_qode_options()->getOptionValue('wh_tuesday_from');
            }

            if(bridge_qode_options()->getOptionValue('wh_tuesday_to') !== '') {
                $workingHours['tuesday']['to'] = bridge_qode_options()->getOptionValue('wh_tuesday_to');
            }

            if(bridge_qode_options()->getOptionValue('wh_tuesday_closed') !== '') {
                $workingHours['tuesday']['closed'] = bridge_qode_options()->getOptionValue('wh_tuesday_closed');
            }
            if(bridge_qode_options()->getOptionValue('wh_tuesday_description') !== '') {
                $workingHours['tuesday']['description']  = bridge_qode_options()->getOptionValue('wh_tuesday_description');
            }
            //wednesday
            if(bridge_qode_options()->getOptionValue('wh_wednesday_from') !== '') {
                $workingHours['wednesday']['label'] = esc_html__('Wednesday', 'qode-restaurant');
                $workingHours['wednesday']['from']  = bridge_qode_options()->getOptionValue('wh_wednesday_from');
            }

            if(bridge_qode_options()->getOptionValue('wh_wednesday_to') !== '') {
                $workingHours['wednesday']['to'] = bridge_qode_options()->getOptionValue('wh_wednesday_to');
            }

            if(bridge_qode_options()->getOptionValue('wh_wednesday_closed') !== '') {
                $workingHours['wednesday']['closed'] = bridge_qode_options()->getOptionValue('wh_wednesday_closed');
            }
            if(bridge_qode_options()->getOptionValue('wh_wednesday_description') !== '') {
                $workingHours['wednesday']['description']  = bridge_qode_options()->getOptionValue('wh_wednesday_description');
            }
            //thursday
            if(bridge_qode_options()->getOptionValue('wh_thursday_from') !== '') {
                $workingHours['thursday']['label'] = esc_html__('Thursday', 'qode-restaurant');
                $workingHours['thursday']['from']  = bridge_qode_options()->getOptionValue('wh_thursday_from');
            }

            if(bridge_qode_options()->getOptionValue('wh_thursday_to') !== '') {
                $workingHours['thursday']['to'] = bridge_qode_options()->getOptionValue('wh_thursday_to');
            }

            if(bridge_qode_options()->getOptionValue('wh_thursday_closed') !== '') {
                $workingHours['thursday']['closed'] = bridge_qode_options()->getOptionValue('wh_thursday_closed');
            }
            if(bridge_qode_options()->getOptionValue('wh_thursday_description') !== '') {
                $workingHours['thursday']['description']  = bridge_qode_options()->getOptionValue('wh_thursday_description');
            }
            //friday
            if(bridge_qode_options()->getOptionValue('wh_friday_from') !== '') {
                $workingHours['friday']['label'] = esc_html__('Friday', 'qode-restaurant');
                $workingHours['friday']['from']  = bridge_qode_options()->getOptionValue('wh_friday_from');
            }

            if(bridge_qode_options()->getOptionValue('wh_friday_to') !== '') {
                $workingHours['friday']['to'] = bridge_qode_options()->getOptionValue('wh_friday_to');
            }

            if(bridge_qode_options()->getOptionValue('wh_friday_closed') !== '') {
                $workingHours['friday']['closed'] = bridge_qode_options()->getOptionValue('wh_friday_closed');
            }
            if(bridge_qode_options()->getOptionValue('wh_friday_description') !== '') {
                $workingHours['friday']['description']  = bridge_qode_options()->getOptionValue('wh_friday_description');
            }
            //saturday
            if(bridge_qode_options()->getOptionValue('wh_saturday_from') !== '') {
                $workingHours['saturday']['label'] = esc_html__('Saturday', 'qode-restaurant');
                $workingHours['saturday']['from']  = bridge_qode_options()->getOptionValue('wh_saturday_from');
            }

            if(bridge_qode_options()->getOptionValue('wh_saturday_to') !== '') {
                $workingHours['saturday']['to'] = bridge_qode_options()->getOptionValue('wh_saturday_to');
            }

            if(bridge_qode_options()->getOptionValue('wh_saturday_closed') !== '') {
                $workingHours['saturday']['closed'] = bridge_qode_options()->getOptionValue('wh_saturday_closed');
            }
            if(bridge_qode_options()->getOptionValue('wh_saturday_description') !== '') {
                $workingHours['saturday']['description']  = bridge_qode_options()->getOptionValue('wh_saturday_description');
            }
            //sunday
            if(bridge_qode_options()->getOptionValue('wh_sunday_from') !== '') {
                $workingHours['sunday']['label'] = esc_html__('Sunday', 'qode-restaurant');
                $workingHours['sunday']['from']  = bridge_qode_options()->getOptionValue('wh_sunday_from');
            }

            if(bridge_qode_options()->getOptionValue('wh_sunday_to') !== '') {
                $workingHours['sunday']['to'] = bridge_qode_options()->getOptionValue('wh_sunday_to');
            }

            if(bridge_qode_options()->getOptionValue('wh_sunday_closed') !== '') {
                $workingHours['sunday']['closed'] = bridge_qode_options()->getOptionValue('wh_sunday_closed');
            }
            if(bridge_qode_options()->getOptionValue('wh_sunday_description') !== '') {
                $workingHours['sunday']['description']  = bridge_qode_options()->getOptionValue('wh_sunday_description');
            }
        }

        return $workingHours;
    }

    protected function getHolderClasses($params) {
        $classes = array('qode-working-hours-holder');

        if(isset($params['enable_frame']) && $params['enable_frame'] === 'yes') {
            $classes[] = 'qode-wh-with-frame';
        }

        if(isset($params['bg_image']) && $params['bg_image'] !== '') {
            $classes[] = 'qode-wh-with-bg-image';
        }

        return $classes;
    }

    protected function getHolderStyles($params) {
        $styles = array();

        if(isset($params['bg_image']) && $params['bg_image'] !== '') {
            $bg_url = wp_get_attachment_url($params['bg_image']);

            if(!empty($bg_url)) {
                $styles[] = 'background-image: url('.$bg_url.')';
            }
        }

        return $styles;
    }

    protected function getItemStyles($params) {
        $styles = array();

        if(isset($params['color']) && $params['color'] !== '') {
            $styles[] = 'color: '.$params['color'];
        }

        return $styles;
    }

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeRestaurantElementorWorkingHours() );