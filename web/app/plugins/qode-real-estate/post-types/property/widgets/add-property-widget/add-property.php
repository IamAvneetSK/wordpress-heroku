<?php
if ( class_exists('BridgeQodeWidget') ) {
	class QodeREAddPropertyWidget extends BridgeQodeWidget {
		public function __construct() {
			parent::__construct(
				'qodef_add_property_widget',
				esc_html__('Qode Add Property Widget', 'qode-real-estate'),
				array('description' => esc_html__('Button for leading user to add property page', 'qode-real-estate'))
			);
			
			$this->setParams();
		}
		
		
		/**
		 * Sets widget options
		 */
		protected function setParams() {
			$this->params = array(
				array(
					'type'        => 'textfield',
					'name'        => 'widget_margin',
					'title'       => esc_html__('Widget Margin', 'qode-real-estate'),
					'description' => esc_html__('Insert margin in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'qode-real-estate')
				),
				array(
					'type'  => 'textfield',
					'name'  => 'widget_text',
					'title' => esc_html__('Widget text', 'qode-real-estate')
				)
			);
		}
		
		/**
		 * Generates widget's HTML
		 *
		 * @param array $args args from widget area
		 * @param array $instance widget's options
		 */
		public function widget($args, $instance) {
			
			$holder_styles = array();
			if ( !empty($instance['widget_margin']) ) {
				$holder_styles[] = 'margin: ' . $instance['widget_margin'];
			}
			
			$widget_text = !empty($instance['widget_text']) ? $instance['widget_text'] : esc_html__('Add property', 'qode-real-estate');
			
			$custom_class = 'qodef-add-property-widget-button';
			if ( is_user_logged_in() ) {
				$link = qode_membership_get_dashboard_page_url();
				$package = qodef_re_property_addition_enabled();
				//stongly false because of the 0 key for packages
				if ( $package !== false ) {
					$link = esc_url(add_query_arg(array('user-action' => 'add-property'), $link));
				} else {
					$link = qodef_re_get_pricing_packages_page();
				}
				$custom_class .= ' qodef-user-logged-in';
			} else {
				$link = '#';
				$custom_class .= ' qodef-login-opener';
			}
			?>
            <div class="widget qodef-add-property-widget" <?php bridge_qode_inline_style($holder_styles); ?>>
				<?php
				echo bridge_core_get_button_v2_html(
					array(
						'custom_class' => $custom_class,
						'size'         => 'medium',
						'type'         => 'solid',
						'text'         => $widget_text,
						'link'         => $link,
						'icon_pack'    => 'font_elegant',
						'fe_icon'      => 'icon_plus'
					)
				);
				?>
            </div>
			<?php
		}
	}
}