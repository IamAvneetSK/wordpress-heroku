<?php
namespace QodeRestaurant\Shortcodes\ReservationForm;

use QodeRestaurant\Lib\ShortcodeInterface;

class ReservationForm implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'qode_reservation_form';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                      => esc_html__('Reservation Form', 'qode-restaurant'),
			'base'                      => $this->base,
			'category'                  => 'by QODE RESTAURANT',
			'icon'                      => 'icon-wpb-reservation-form extended-custom-icon-qode',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('OpenTable ID', 'qode-restaurant'),
					'param_name'  => 'open_table_id',
					'admin_label' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Skin', 'qode-restaurant'),
					'param_name'  => 'skin',
					'value'       => array(
						esc_html__('Dark', 'qode-restaurant')	=> 'dark',
						esc_html__('Light', 'qode-restaurant')	=> 'light'
					),
					'admin_label' => true
				)
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'open_table_id' =>	'',
			'skin' =>			''
		);

		$params = shortcode_atts($default_atts, $atts);

		$params['holderClasses'] = $this->getHolderClasses($params);
		$params['button_classes'] = $this->geButtonClasses($params);

		return qode_restaurant_get_template_part('modules/shortcodes/reservation-form/templates/reservation-form', '', $params, true);
	}

	private function getHolderClasses($params) {
		$classes = array('qode-rf-holder');

		if($params['skin'] === 'light') {
			$classes[] = 'qode-rf-light';
		}

		return $classes;
	}

	private function geButtonClasses($params) {
		$classes = array();

		if($params['skin'] === 'light') {
			$classes[] = 'white';
		}

		return implode(' ', $classes);
	}
}