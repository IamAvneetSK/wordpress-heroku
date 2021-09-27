<?php
namespace qodeNews\CPT\Shortcodes\VideoLayout1;

use qodeNews\Lib;

class VideoLayout1 extends Lib\NewsShortcodes {
	private $base;
	private $css_class;
	private $shortcode_title;
	private $icon_class;
	
	function __construct() {
		$this->base = 'qode_video_layout1';
		$this->css_class = 'qode-video-layout1';
		$this->shortcode_title = esc_html__('Video Layout 1','qode-news');
		$this->icon_class = 'qode-video-layout1 extended-custom-icon-qode';

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
			'display_author' => '',
			'display_share' => 'no'
		);

    	return $default_atts;
    }

	public function render($atts, $content = null) {
		$default_atts = $this->getDefaultParams();
		
		$params = shortcode_atts($default_atts, $atts);

		$params['video_type'] = get_post_meta( get_the_ID(), "video_format_choose", true );
		$params['has_video_link'] = get_post_meta(get_the_ID(), "video_format_webm", true) !== '' || get_post_meta(get_the_ID(), "video_format_mp4", true) !== '' || get_post_meta(get_the_ID(), "video_format_ogv", true) !== '' || get_post_meta(get_the_ID(), "video_format_link", true) !== '';

	    if ( $params['video_type'] == 'youtube' || $params['video_type'] == 'vimeo' ) {
	    	$params['video_link'] = get_post_meta( get_the_ID(), "video_format_link", true );
	    } else {
	    	$params['video_link_webm'] = get_post_meta(get_the_ID(), "video_format_webm", true);
	    	$params['video_link_mp4'] = get_post_meta(get_the_ID(), "video_format_mp4", true);
	    	$params['video_link_ogv'] = get_post_meta(get_the_ID(), "video_format_ogv", true);
	    }

		$html = '';

		if($params['has_video_link']) {
	        //Get HTML from template
	        $html .= qode_news_get_shortcode_module_template_part('templates/video-layout1-template','video-layout1', '',$params);
	    }

		return $html;
	}

    public function getShortcodeParams($exclude_options = array()) {
    	$params_general_excluded = array();
    	$params_post_item_excluded = array();

        $params_general_excluded[] = 'block_proportion';

        $params_post_item_excluded[] = 'image_size';
		$params_post_item_excluded[] = 'custom_image_width';
		$params_post_item_excluded[] = 'custom_image_height';
        $params_post_item_excluded[] = 'display_excerpt';
        $params_post_item_excluded[] = 'excerpt_length';
        $params_post_item_excluded[] = 'display_categories';
        $params_post_item_excluded[] = 'display_date';
        $params_post_item_excluded[] = 'date_format';
    	$params_post_item_excluded[] = 'display_hot_trending_icons';

    	// General Options - start
        $params_general_array = qode_news_get_general_shortcode_params($params_general_excluded);
        // General Options - end

        // Post Item Options - start
        $params_post_item_array = qode_news_get_post_item_shortcode_params($params_post_item_excluded);
        // Post Item Options - end

        // Pagination Options - start
        $params_pagination_array = qode_news_get_pagination_shortcode_params();
        // Pagination Options - end
        
        $params_array = array_merge(
            $params_general_array,
            $params_post_item_array,
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

    /**
     * Returns if shortcode is Video Element or not
     *
     * @return boolean
     */
    public function isVideoElement() {
        return true;
    }
}