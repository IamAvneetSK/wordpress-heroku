<?php
namespace qodeNews\CPT\Shortcodes\Layout2;

use qodeNews\Lib;

class Layout2 extends Lib\NewsShortcodes {
	private $base;
	private $css_class;
	private $shortcode_title;
	private $icon_class;
	
	function __construct() {
		$this->base = 'qode_layout2';
		$this->css_class = 'qode-layout2';
		$this->shortcode_title = esc_html__('Layout 2','qode-news');
		$this->icon_class = 'qode-layout2 extended-custom-icon-qode';

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
			'title_tag' => 'h5',
			'image_size' => 'thumbnail',
			'custom_image_width' => '',
			'custom_image_height' => '',
			'excerpt_length' => '10',
			'date_format' => '',
			'display_excerpt' => 'no',
			'display_date' => 'yes',
			'display_categories' => 'no',
			'display_author' => 'no',
			'display_share' => 'no',
			'display_hot_trending_icons' => 'no'
		);

    	return $default_atts;
    }
	
	public function render($atts, $content = null) {
		$default_atts = $this->getDefaultParams();
		
		$params = shortcode_atts($default_atts, $atts);

		$html = '';

        //Get HTML from template
        $html .= qode_news_get_shortcode_module_template_part('templates/layout2-template','layout2', '',$params);

		return $html;
	}
}