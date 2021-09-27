<?php 

if (!function_exists('qode_news_reaction_taxonomy_register')) {
	function qode_news_reaction_taxonomy_register(){

		if (qode_news_theme_installed()){
	        $labels = array(
	            'name'              => esc_html__('News Reactions', 'qode-news'),
	            'singular_name'     => esc_html__('News Reaction', 'qode-news'),
	            'search_items'      => esc_html__('Search News Reactions','qode-news'),
	            'all_items'         => esc_html__('All News Reactions','qode-news'),
	            'parent_item'       => esc_html__('Parent News Reaction','qode-news'),
	            'parent_item_colon' => esc_html__('Parent News Reaction:','qode-news'),
	            'edit_item'         => esc_html__('Edit News Reaction','qode-news'),
	            'update_item'       => esc_html__('Update News Reaction','qode-news'),
	            'add_new_item'      => esc_html__('Add New News Reaction','qode-news'),
	            'new_item_name'     => esc_html__('New News Reaction Name','qode-news'),
	            'menu_name'         => esc_html__('News Reactions','qode-news')
	        );

	        register_taxonomy('news-reaction', 'post', array(
				'public'      		=> false,
	        	'hierarchical'      => false,
	            'labels'            => $labels,
	            'show_ui'           => true,
	            'query_var'         => true,
	            'show_admin_column' => false,
	            'show_in_quick_edit'=> false,
	    		'meta_box_cb'       => false,
	            'rewrite'           => array('slug' => 'news-reaction')
	        ));
		}
	}

	add_action( 'init', 'qode_news_reaction_taxonomy_register', 0);
}

if (!function_exists('qode_news_reaction_taxonomy_archive')) {
	function qode_news_reaction_taxonomy_archive($archive) {
		if (is_tax('news-reaction')) {
			return QODE_NEWS_REACTIONS_PATH . '/archive-reactions.php';
		}
		return $archive;
	}

    add_filter('archive_template', 'qode_news_reaction_taxonomy_archive');
}

if (!function_exists('qode_news_reaction_html')){
	function qode_news_reaction_html($post_ID = ''){
		if ($post_ID == ''){
			$post_ID = get_the_ID();
		}

		$all_reactions = get_terms(array(
			'taxonomy' => 'news-reaction',
			'hide_empty' => false
		));

		$html = '';
		if (is_array($all_reactions) && count($all_reactions)) {

			$html .= '<div class="qode-news-reactions-holder">';
			$html .= '<div class="qode-news-reactions" data-post-id="'.get_the_ID().'">';

			foreach ($all_reactions as $reaction) {
				$reaction_params = array();

				$reaction_params['id'] = $reaction->term_taxonomy_id;
				$reaction_params['name'] = $reaction->name;
				$reaction_params['slug'] = $reaction->slug;
				$reaction_params['image'] = get_term_meta($reaction->term_taxonomy_id, 'reaction_image', true);
				$reaction_params['reaction_value'] = get_post_meta($post_ID, 'qode_news_reaction_'.$reaction->slug, true);

				if ($reaction_params['reaction_value'] === ''){
					$reaction_params['reaction_value'] = 0;
				}

				$reaction_params['reacted'] = '';
				if(isset( $_COOKIE[ 'qode-reaction-' . $reaction->slug . '_' . $post_ID ] )){
					$reaction_params['reacted'] = 'reacted';
				}

				$html .= qode_news_get_template_part('template/reaction','reactions','',$reaction_params);
			}

			$html .= '</div>'; //closing qode-news-reactions
			$html .= '</div>'; //closing qode-news-reactions-holder
		}

		echo $html;
	}

	add_action('qode_news_after_article_content','qode_news_reaction_html', 10);
}


if (!function_exists('qode_news_reaction_update')){
	function qode_news_reaction_update(){

		if ( isset( $_POST['reaction_slug'] ) ) {
			$slug = $_POST['reaction_slug'];
			$post_ID = $_POST['post_ID'];
			if ( isset( $_COOKIE[ 'qode-reaction-' . $slug . '_' . $post_ID ] ) ) {
                return;
			} else {				
                $count = get_post_meta($post_ID, 'qode_news_reaction_'.$slug, true);
                if ($count === '') {
                    update_post_meta($post_ID, 'qode_news_reaction_'.$slug, 1);
                    setcookie('qode-reaction-' . $slug . '_' . $post_ID, $post_ID, time() * 20, '/');
                } else {
                    $count++;
                    update_post_meta($post_ID, 'qode_news_reaction_'.$slug, $count);
                    setcookie('qode-reaction-' . $slug . '_' . $post_ID, $post_ID, time() * 20, '/');
                }
			}
		}
		
		exit;

	}

	add_action( 'wp_ajax_qode_news_reaction_update', 'qode_news_reaction_update' );
    add_action( 'wp_ajax_nopriv_qode_news_reaction_update', 'qode_news_reaction_update' );
}