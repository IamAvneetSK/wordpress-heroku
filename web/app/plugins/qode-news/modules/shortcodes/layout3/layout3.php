<?php
namespace qodeNews\CPT\Shortcodes\Layout3;

use qodeNews\Lib;

class Layout3 extends Lib\NewsShortcodes {
	private $base;
	private $css_class;
	private $shortcode_title;
	private $icon_class;
	
	function __construct() {
		$this->base = 'qode_layout3';
		$this->css_class = 'qode-layout3';
		$this->shortcode_title = esc_html__('Layout 3','qode-news');
		$this->icon_class = 'qode-layout3 extended-custom-icon-qode';

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
			'title_tag' => 'h2',
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
			'display_button' => 'yes',
			'display_review' => 'yes',
			'display_hot_trending_icons' => 'no'
		);

    	return $default_atts;
    }

	public function render($atts, $content = null) {
		$default_atts = $this->getDefaultParams();
		
		$params = shortcode_atts($default_atts, $atts);

		$html = '';

        //Get HTML from template
        $html .= qode_news_get_shortcode_module_template_part('templates/layout3-template','layout3', '',$params);

		return $html;
	}

    /**
     * Generates posts class string
     *
     * @param $params
     *
     * @return string
     */
    public function getShortcodeParams($exclude_options = array()) {
    	$params_general_excluded = array();
    	$params_post_item_excluded = array();
    	$params_pagination_array = array();
    	$params_navigation_array = array();
	    	
        // Pagination Options - start
        $params_pagination_array = qode_news_get_pagination_shortcode_params();
        // Pagination Options - end
	    

    	// General Options - start
        $params_general_array = qode_news_get_general_shortcode_params(array('block_proportion'));
        // General Options - end

        // Post Item Options - start
        $params_post_item_array = qode_news_get_post_item_shortcode_params();
        // Post Item Options - end

        // Additional Options - start
        $params_additional_array = array(
			array(
				'type'		  => 'dropdown',
				'param_name'  => 'display_button',
				'heading'	  => esc_html__("Display 'Read More' Button",'qode-news'),
				'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
				'group' 	  => esc_html__('Post Item','qode-news'),
			),
        	array(
				'type'		  => 'dropdown',
				'param_name'  => 'display_review',
				'heading'	  => esc_html__('Display Review','qode-news'),
				'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
            	'group' 	  => esc_html__('Post Item','qode-news'),
    		)
    	);
        // Additional Options - end

        $params_array = array_merge(
            $params_general_array,
            $params_post_item_array,
            $params_additional_array,
            $params_pagination_array
        );

        if (is_array($exclude_options) && count($exclude_options)) {
            foreach ($exclude_options as $exclude_key) {
                foreach ($params_array as $params_item) {
                    if ($exclude_key == $params_item['param_name']) {
                        $key = array_search($params_item, $params_array);
                        unset($params_array[$key]);
                    }
                }
            }
        }

        return $params_array;
    }
}