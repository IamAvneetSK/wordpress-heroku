<?php
namespace qodeNews\CPT\Shortcodes\Slider1;

use qodeNews\Lib;

class Slider1 extends Lib\NewsShortcodes {
	private $base;
	private $css_class;
	private $shortcode_title;
	private $icon_class;
	
	function __construct() {
		$this->base = 'qode_slider1';
		$this->css_class = 'qode-slider1';
		$this->shortcode_title = esc_html__('Post Slider 1','qode-news');
		$this->icon_class = 'qode-post-slider1 extended-custom-icon-qode';

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
			'content_in_grid' => 'yes',
			'column_number' => '1',
			'space_between_items' => 'no',
			'slider_size' => 'landscape',
			'title_tag' => 'h2',
			'title_length' => '',
			'image_size' => 'full',
			'custom_image_width' => '',
			'custom_image_height' => '',
			'excerpt_length' => '',
			'date_format' => '',
			'display_excerpt' => 'yes',
			'display_categories' => 'yes',
			'display_share' => 'yes',
			'content_padding' => '',
			'display_button' => 'yes'
		);

    	return $default_atts;
    }
	
	public function render($atts, $content = null) {
		$default_atts = $this->getDefaultParams();
		
		$params = shortcode_atts($default_atts, $atts);

		$html = '';

		$params['item_classes'] = $this->getClasses($params);
		$params['background_style'] = $this->getBackgroundStyle($params);
		$params['content_style'] = $this->getContentStyle($params);

		$params['item_data_params'] = $this->getItemDataParams($params);

        //Get HTML from template
        $html .= qode_news_get_shortcode_module_template_part('templates/slider1-template','post-slider1', '',$params);

		return $html;
	}

	public function getItemDataParams($params) {
    	extract($params);

    	$data = 'data-thumb-url="'.get_the_post_thumbnail_url(null,'thumbnail').'" ';
		$date_format = isset($date_format) && $date_format !== '' ? $date_format : 'published';
		$difference = human_time_diff( get_the_time('U'), current_time('timestamp') ) . esc_html__(' ago','qode-news');
		if ($date_format == 'published') {
			$date = get_the_time(get_option('date_format'));
		} else {
			$date = esc_html($difference);
		}

    	$data .= 'data-date="'. $date .'"';
		return $data;
	}

    /**
     * Returns if shortcode is Slider or not
     *
     * @return boolean
     */
    public function isSlider() {
        return true;
    }

    /**
     * Generates Data Params for News Shortcodes holder
     *
     * @param $params
     *
     * @return string
     */
    public function getNewsShortcodesHolderDataParams( $params ) {

        $data_params_string = qode_news_get_holder_data_params($params, $this->base);

        if($params['content_in_grid'] == 'yes'){
        	$data_params_string .= ' data-content-in-grid=yes ';
        }

        if($params['content_padding'] !== ''){
        	$data_params_string .= ' data-content-padding='.str_replace(" ", ",", $params['content_padding']).'';
        }

        return $data_params_string;

    }

    /**
     * Generates holder inner class string
     *
     * @param $params
     *
     * @return string
     */
    protected function getHolderInnerClasses() {
        $holder_inner_classes = array();
        $holder_inner_classes[] = 'qode-news-list-inner-holder';

        $holder_inner_classes[] = 'qode-slider1-owl';
        $holder_inner_classes[] = 'qode-owl-slider-style';

        return implode(' ', $holder_inner_classes);
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

    	//include/exclude params
    	$params_general_excluded[] = 'layout_title';
    	$params_general_excluded[] = 'layout_title_tag';
    	$params_general_excluded[] = 'block_proportion';
    	$params_general_excluded[] = 'column_number';
    	$params_general_excluded[] = 'space_between_items';
    	$params_general_excluded[] = 'show_filter';
    	$params_general_excluded[] = 'filter_by';

    	$params_post_item_excluded[] = 'display_hot_trending_icons';
    	$params_post_item_excluded[] = 'display_date';
    	$params_post_item_excluded[] = 'date_format';
    	$params_post_item_excluded[] = 'display_author';
    	$params_post_item_excluded[] = 'custom_image_width';
    	$params_post_item_excluded[] = 'custom_image_height';

    	// General Options - start
        $params_general_array = qode_news_get_general_shortcode_params($params_general_excluded);
        // General Options - end

        // Post Item Options - start
        $params_post_item_array = qode_news_get_post_item_shortcode_params($params_post_item_excluded);
        // Post Item Options - end

        $params_additional_general_array = array(
        	array(
        		'type' => 'dropdown',
	            'heading' => esc_html__('Slider Size','qode-news'),
	            'param_name' => 'slider_size',
	            'value' => array(
	                esc_html__('Default', 'qode-news') => '',
	                esc_html__('Landscape', 'qode-news') => 'landscape',
	                esc_html__('Square', 'qode-news') => 'square',
	                esc_html__('Full Screen', 'qode-news') => 'full-screen'
	            ),
	            'group' => esc_html__('General','qode-news')
    		),
        	array(
        		'type' => 'dropdown',
	            'heading' => esc_html__('Content in Grid','qode-news'),
	            'param_name' => 'content_in_grid',
	            'value' => array(
	                esc_html__('Default', 'qode-news') => '',
	                esc_html__('Yes', 'qode-news') => 'yes',
	                esc_html__('No', 'qode-news') => 'no'
	            ),
	            'group' => esc_html__('General','qode-news')
    		),
    		array(
    			'type' => 'textfield',
    			'heading' => esc_html__('Content Padding','qode-news'),
    			'param_name' => 'content_padding',
    			'description' => esc_html__('Insert content padding in (0px 5px 0px 5px) form','qode-news'),
	            'group' => esc_html__('General','qode-news')
			)
    	);

		$params_additional_item_array = array(
			array(
				'type'		  => 'dropdown',
				'param_name'  => 'display_button',
				'heading'	  => esc_html__("Display 'Read More' Button",'qode-news'),
				'value'		  => array_flip(bridge_qode_get_yes_no_select_array()),
				'group' 	  => esc_html__('Post Item','qode-news'),
			),
			array( //has to be here since it will not work without 'show date' field
				'type'        => 'dropdown',
				'heading'	  => esc_html__('Publication Date Format','qode-news'),
				'param_name'  => 'date_format',
				'value' 	  => array(
					esc_html__('Default','qode-news') => '',
					esc_html__('Time from Publication','qode-news') => 'difference',
					esc_html__('Date of Publication','qode-news') => 'published'
				),
				'group' 	  => esc_html__('Post Item','qode-news'),
			)

		);

        $params_array = array_merge(
            $params_general_array,
			$params_additional_general_array,
            $params_post_item_array,
			$params_additional_item_array
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

    /**
     * Returns background style for shortcode
     * @return string
     */
	private function getBackgroundStyle($params){
		$background_image = '';
		$image_size = 'full';
		$background_style = array();

		if ($params['image_size'] !== ''){
			$image_size = $params['image_size'];
		}

		$featured_image_meta = get_post_meta(get_the_ID(), 'qode_blog_list_featured_image_meta', true);

		if ($featured_image_meta !== ''){
			$background_image = $featured_image_meta;
		} else {
			$background_image = get_the_post_thumbnail_url(get_the_ID(),$image_size);
		}

		$background_style[] = 'background-image: url('.esc_url($background_image).')';

		return implode(';', $background_style);
	}

    /**
     * Returns style for content
     * @return string
     */
	private function getContentStyle($params){
		$content_style = array();

		if ($params['content_padding'] !== ''){
			$content_style[] = 'padding: '.$params['content_padding'];
		}

		return implode(';', $content_style);
	}

    /**
     * Returns classes for item
     * @return string
     */
	private function getClasses($params){
		$classes = array();

		if ($params['slider_size'] !== ''){
			$classes[] = 'qode-slider-size-'.$params['slider_size'];
		} else {
			$classes[] = 'qode-slider-size-landscape';
		}

        if($params['content_in_grid'] !== 'yes'){
			$classes[] = 'qode-slider1-item-wide';
        }

		return implode(' ', $classes);
	}
}