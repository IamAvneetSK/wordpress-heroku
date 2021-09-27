<?php
namespace QodeRestaurant\Shortcodes\WorkingHours;

use QodeRestaurant\Lib\ShortcodeInterface;

class WorkingHours implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'qode_working_hours';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                      => esc_html__('Working Hours', 'qode-restaurant'),
			'base'                      => $this->base,
			'category'                  => 'by QODE RESTAURANT',
			'icon'                      => 'icon-wpb-working-hours extended-custom-icon-qode',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Title', 'qode-restaurant'),
					'param_name'  => 'title',
					'value'       => '',
					'admin_label' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Label', 'qode-restaurant'),
					'param_name'  => 'label',
					'value'       => '',
					'admin_label' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Sublabel', 'qode-restaurant'),
					'param_name'  => 'sublabel',
					'value'       => '',
					'admin_label' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Items Title Tag', 'qode-restaurant'),
					'param_name'  => 'items_title_tag',
					'value' => array(
						''   => '',
						'h2' => 'h2',
						'h3' => 'h3',
						'h4' => 'h4',
						'h5' => 'h5',
						'h6' => 'h6',
					)
				)
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'title' 			=> '',
			'label'				=> '',
			'sublabel'			=> '',
			'items_title_tag'	=> 'h5',
			'color'				=> ''
		);

		$params = shortcode_atts($default_atts, $atts);

		$params['working_hours']  = $this->getWorkingHours();
		$params['holder_classes'] = $this->getHolderClasses($params);
		$params['holder_styles']  = $this->getHolderStyles($params);
		$params['item_styles']	  = $this->getItemStyles($params);

		return qode_restaurant_get_template_part('modules/shortcodes/working-hours/templates/working-hours-template', '', $params, true);
	}

	private function getWorkingHours() {
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
				$workingHours['tuesday']['label'] = __('Tuesday', 'qode-restaurant');
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
				$workingHours['wednesday']['label'] = __('Wednesday', 'qode-restaurant');
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
				$workingHours['thursday']['label'] = __('Thursday', 'qode-restaurant');
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
				$workingHours['friday']['label'] = __('Friday', 'qode-restaurant');
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
				$workingHours['saturday']['label'] = __('Saturday', 'qode-restaurant');
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
				$workingHours['sunday']['label'] = __('Sunday', 'qode-restaurant');
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

	private function getHolderClasses($params) {
		$classes = array('qode-working-hours-holder');

		if(isset($params['enable_frame']) && $params['enable_frame'] === 'yes') {
			$classes[] = 'qode-wh-with-frame';
		}

		if(isset($params['bg_image']) && $params['bg_image'] !== '') {
			$classes[] = 'qode-wh-with-bg-image';
		}

		return $classes;
	}

	private function getHolderStyles($params) {
		$styles = array();

		if(isset($params['bg_image']) && $params['bg_image'] !== '') {
			$bg_url = wp_get_attachment_url($params['bg_image']);

			if(!empty($bg_url)) {
				$styles[] = 'background-image: url('.$bg_url.')';
			}
		}

		return $styles;
	}
	private function getItemStyles($params) {
		$styles = array();

		if(isset($params['color']) && $params['color'] !== '') {
			$styles[] = 'color: '.$params['color'];
		}

		return $styles;
	}

}
