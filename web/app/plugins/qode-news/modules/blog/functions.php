<?php

if(!function_exists('qode_news_blog_single_types')) {

    function qode_news_blog_single_types($single) {
        global $post;

		if (qode_news_theme_installed()){
	    	$post_template = bridge_qode_get_meta_field_intersect('blog_single_type', bridge_qode_get_page_id());

	        if($post->post_type == 'post' && $post_template == 'news-template') {
	            return QODE_NEWS_BLOG_PATH.'/news-single.php';
	        }
	    }

        return $single;
    }

    add_filter('single_template', 'qode_news_blog_single_types');
}

if(!function_exists('qode_news_blog_category_archive')) {
	/**
	 * Changes archive page
	 */
	function qode_news_blog_category_archive($single) {
		global $post;

		if (qode_news_theme_installed()){

			if(is_author() || $post->post_type == 'post') {
				return QODE_NEWS_BLOG_PATH.'/news-archive.php';
			}
		}

		return $single;
	}

	add_filter('category_template', 'qode_news_blog_category_archive', 11);
	add_filter('archive_template', 'qode_news_blog_category_archive', 11);
}

if(!function_exists('qode_news_load_comment_template')){

	function qode_news_load_comment_template() {
		global $post;

		if (qode_news_theme_installed()) {
			$post_template = bridge_qode_get_meta_field_intersect('blog_single_type', bridge_qode_get_page_id());

			if ($post->post_type == 'post' && $post_template == 'news-template') {
				return QODE_NEWS_BLOG_PATH . '/single/news-template/parts/comments-form.php';
			}
		}
	}
	add_filter( 'comments_template', 'qode_news_load_comment_template');
}


foreach ( glob( QODE_NEWS_BLOG_PATH . '/admin/meta-boxes/*.php' ) as $meta_box_load ) {
	include_once $meta_box_load;
}

if(!function_exists('qode_news_get_blog_part')) {
	/**
	 * Loads blog template part.
	 *
	 * @param string $template name of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @return html
	 */
	function qode_news_get_blog_part($template, $holder, $slug = '', $params = array()) {
		
		//HTML Content from template
		$html          = '';
		$template_path = QODE_NEWS_BLOG_PATH.'/'.$holder;
		
		$temp = $template_path.'/'.$template;
		
		if(is_array($params) && count($params)) {
			extract($params);
		}
		
		$template = '';
		
		if (!empty($temp)) {
			if (!empty($slug)) {
				$template = "{$temp}-{$slug}.php";
				
				if(!file_exists($template)) {
					$template = $temp.'.php';
				}
			} else {
				$template = $temp.'.php';
			}
		}
		
		if ($template) {
			ob_start();
			include($template);
			$html = ob_get_clean();
		}
		
		return $html;
	}
}

if ( ! function_exists( 'qode_news_get_holder_params_blog' ) ) {
	/**
	 * Function which return holder class and holder inner class for blog pages
	 */
	function qode_news_get_holder_params_blog() {
		/**
		 * Available parameters for holder params
		 * -holder
		 * -inner
		 */
		return apply_filters( 'qode_news_blog_holder_params', $params = array() );
	}
}

if (!function_exists('qode_news_get_blog_single')){
	function qode_news_get_blog_single($post_template){

		$params = array(
			'blog_single_type'    => $post_template,
			'blog_single_classes' => 'qode-blog-single-' . $post_template
		);

		echo qode_news_get_blog_part($post_template.'/holder','single','',$params);
	}
}

if ( ! function_exists( 'qode_news_blog_get_single_post_format_html' ) ) {
	/**
	 * Function return all parts on single.php page
	 *
	 * @param $type - type of blog single layout
	 */
	function qode_news_blog_get_single_post_format_html( $blog_single_type ) {
		$post_format = bridge_qode_return_post_format();
		
		$params = array();
		/*
		 * Available parameters for template parts
		 * -image_size
		 * -title_tag
		 * -link_tag
		 * -quote_tag
		 * -share type
		 */
		$params['part_params'] = apply_filters( 'qode_news_filter_blog_part_params', array() );
		$params['blog_single_type'] = $blog_single_type;

		echo qode_news_get_blog_part( $blog_single_type.'/types/'. $post_format, 'single', '', $params );
	}
}

if ( ! function_exists( 'qode_news_blog_item_has_link' ) ) {
	/**
	 * Function returns true/false depends is single post or in loop
	 */
	function qode_news_blog_item_has_link() {
		$is_link = ( is_single() && ( get_the_ID() === bridge_qode_get_page_id() ) ) ? false : true;

		return $is_link;
	}
}

if (!function_exists('qode_news_comment')) {
	/**
	 * Function which modify default wordpress comments
	 *
	 * @return comments html
	 */
	function qode_news_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;

		global $post;

		$is_pingback_comment = $comment->comment_type == 'pingback';
		$is_author_comment  = $post->post_author == $comment->user_id;

		$comment_class = 'qode-comment clearfix';

		if($is_author_comment) {
			$comment_class .= ' qode-post-author-comment';
		}

		if($is_pingback_comment) {
			$comment_class .= ' qode-pingback-comment';
		}
		?>

		<li>
		<div class="<?php echo esc_attr($comment_class); ?>">
			<?php if(!$is_pingback_comment) { ?>
				<div class="qode-comment-image"> <?php echo bridge_qode_kses_img(get_avatar($comment, 'thumbnail')); ?> </div>
			<?php } ?>
			<div class="qode-comment-text">
				<div class="qode-edit-reply-holder">
					<?php
					comment_reply_link( array_merge( $args, array('reply_text' => esc_html__('reply', 'qode-news'), 'depth' => $depth, 'max_depth' => $args['max_depth'])));
					edit_comment_link(esc_html__('edit','qode-news'));
					?>
				</div>
				<div class="qode-comment-info">
					<h5 class="qode-comment-name vcard">
						<?php if($is_pingback_comment) { esc_html_e('Pingback:', 'qode-news'); } ?>
						<?php echo wp_kses_post(get_comment_author_link()); ?>
					</h5>
					<div class="qode-comment-date"><?php comment_time(get_option('date_format')); ?></div>
				</div>
				<?php if(!$is_pingback_comment) { ?>
					<div class="qode-text-holder" id="comment-<?php echo comment_ID(); ?>">
						<?php comment_text(); ?>
					</div>
				<?php } ?>

			</div>
		</div>
		<?php //li tag will be closed by WordPress after looping through child elements ?>
		<?php
	}
}

