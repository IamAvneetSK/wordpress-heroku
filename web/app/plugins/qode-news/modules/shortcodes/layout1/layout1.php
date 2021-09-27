<?php
namespace qodeNews\CPT\Shortcodes\Layout1;

use qodeNews\Lib;

class Layout1 extends Lib\NewsShortcodes {
	private $base;
	private $css_class;
	private $shortcode_title;
	private $icon_class;
	
	function __construct() {
		$this->base = 'qode_layout1';
		$this->css_class = 'qode-layout1';
		$this->shortcode_title = esc_html__('Layout 1','qode-news');
		$this->icon_class = 'qode-layout1 extended-custom-icon-qode';

        parent::__construct($this->base, $this->css_class, $this->shortcode_title, $this->icon_class);
        
		add_action('vc_before_init', array($this, 'vcMap'));
	}
	
	public function getBase() {
		return $this->base;
	}

    /**
     * Returns default params for shortcode
     * @return array
     */
    public function getDefaultParams(){
		$default_atts = array(
			'title_tag' => 'h4',
			'image_size' => 'portfolio-landscape',
			'custom_image_width' => '',
			'custom_image_height' => '',
			'excerpt_length' => '',
			'date_format' => '',
			'display_excerpt' => 'no',
			'display_date' => 'yes',
			'display_categories' => 'yes',
			'display_author' => 'no',
			'display_share' => 'no',
			'display_hot_trending_icons' => 'no',
			'display_image' => 'yes',
			'content_alignment' => 'center',
			'show_numbers' => 'no',
			'year' => '',
			'monthnum' => '',
			'day' => ''
		);

    	return $default_atts;
    }
	
	public function render($atts, $content = null) {
		$default_atts = $this->getDefaultParams();
		$params = shortcode_atts($default_atts, $atts);

		$html = '';

        //Get HTML from template
        $html .= qode_news_get_shortcode_module_template_part('templates/layout1-template','layout1', '',$params);

		return $html;
	}

	/**
	 * Return additional holder classes
	 *
	 * @param $params
	 * @return array
	 */
	public function getAdditionalHolderClasses($params) {
		$classes = array();

		$classes[] = 'qode-'.$params['content_alignment'].'-alignment';

		if($params['show_numbers'] == 'yes') {
			$classes[] = 'qode-show-numbers';
		}

		return $classes;
	}
}