<?php
if ( class_exists('BridgeQodeWidget') ) {
	class QodeREMortgageCalculatorWidget extends BridgeQodeWidget {
		public function __construct() {
			parent::__construct(
				'qodef_mortgage_calculator_widget',
				esc_html__('Qode Mortgage Calculator Widget', 'qode-real-estate'),
				array('description' => esc_html__('Display mortgage loan calculator', 'qode-real-estate'))
			);
			
			$this->setParams();
		}
		
		/**
		 * Sets widget options
		 */
		protected function setParams() {
			$this->params = array(
				array(
					'type'  => 'textfield',
					'name'  => 'widget_title',
					'title' => esc_html__('Widget Title', 'qode-real-estate')
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
			if ( !is_array($instance) ) {
				$instance = array();
			}
			
			$widget_title = !empty($instance['widget_title']) ? esc_html($instance['widget_title']) : esc_html__('Mortgage Calculator', 'qode-real-estate');
			
			?>
            <div class="widget qodef-mortgage-calculator-widget">
				<?php echo wp_kses_post($args['before_title']) . $widget_title . wp_kses_post($args['after_title']); ?>
                <div class="qodef-mortgage-calculator-holder">
                    <form method="POST" action="#">
                        <div class="qodef-mc-field-holder">
                            <label><?php esc_html_e('Sale price', 'qode-real-estate'); ?></label>
                            <input type="text" name="price" id="price" placeholder="<?php echo esc_attr('$') ?>"
                                   value=""/>
                        </div>
                        <div class="qodef-mc-field-holder">
                            <label><?php esc_html_e('Interest rate', 'qode-real-estate'); ?></label>
                            <input type="text" name="interest-rate" id="interest-rate"
                                   placeholder="<?php echo esc_attr('%') ?>" value=""/>
                        </div>
                        <div class="qodef-mc-field-holder">
                            <label><?php esc_html_e('Term', 'qode-real-estate'); ?></label>
                            <input type="text" name="term-years" id="term-years"
                                   placeholder="<?php esc_attr_e('Year', 'qode-real-estate') ?>" value=""/>
                        </div>
                        <div class="qodef-mc-field-holder">
                            <label><?php esc_html_e('Down payment', 'qode-real-estate'); ?></label>
                            <input type="text" name="down-payment" id="down-payment"
                                   placeholder="<?php echo esc_attr('$') ?>" value=""/>
                        </div>
                        <div class="qodef-mc-button-holder">
                            <input type="submit" class="qbutton default"
                                   value="<?php esc_attr_e('Calculate', 'qode-real-estate'); ?>"/>
                        </div>
                    </form>
                    <div class="qodef-mc-result-holder">
                        <div class="qodef-mc-payment">
                        <span class="qodef-mc-payment-label">
                            <?php esc_html_e('Monthly payment:', 'qode-real-estate') ?>
                        </span>
                            <span class="qodef-mc-payment-value">

                        </span>
                        </div>
                        <div class="qodef-mc-amount-financed">
                        <span class="qodef-mc-amount-financed-label">
                            <?php esc_html_e('Amount financed:', 'qode-real-estate') ?>
                        </span>
                            <span class="qodef-mc-amount-financed-value">

                        </span>
                        </div>
                        <div class="qodef-mc-mortgage-payments">
                        <span class="qodef-mc-mortgage-payments-label">
                            <?php esc_html_e('Mortgage payments:', 'qode-real-estate') ?>
                        </span>
                            <span class="qodef-mc-mortgage-payments-value">

                        </span>
                        </div>
                        <div class="qodef-mc-annual-costs">
                        <span class="qodef-mc-annual-costs-label">
                            <?php esc_html_e('Annual costs of loan:', 'qode-real-estate') ?>
                        </span>
                            <span class="qodef-mc-annual-costs-value">

                        </span>
                        </div>
                    </div>
                </div>
            </div>
			<?php
		}
	}
}