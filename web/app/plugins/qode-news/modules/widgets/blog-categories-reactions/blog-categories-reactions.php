<?php

class qodeNewsClassBlogCategoriesReactions extends qodeNewsPhpClassWidget {
    public function __construct() {
        parent::__construct(
            'qode_blog_categories_reactions_widget',
            esc_html__('Qode Blog Categories/Reaction Widget', 'qode-news'),
            array( 'description' => esc_html__( 'Dropdown widget for blog categories and reactions', 'qode-news'))
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
				'name'  => 'title',
				'title' => esc_html__( 'Title', 'qode-news' )
			),
			array(
				'type'  => 'dropdown',
				'name'  => 'title_tag',
				'title' => esc_html__( 'Title Tag', 'qode-news' ),
				'options' => bridge_qode_get_title_tag( true )
			),
            array(
                'type' => 'dropdown',
                'title' => esc_html__('Show','qode-news'),
                'name' => 'show',
                'options' => array(
	                'cat_and_react' => esc_html__('Categories and Reactions','qode-news'),
	                'cat' => esc_html__('Categories','qode-news'),
	                'react' => esc_html__('Reactions','qode-news'),
                )
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
        if (!is_array($instance)) { $instance = array(); }
   
        if ($instance['title_tag'] == '') {
            $instance['title_tag'] = 'h4';
        }

        $categories_array = array();
        $reactions_array = array();

        switch ($instance['show']) {
        	case 'cat':
				$terms = get_categories(array(
					'orderby' => 'count'
				));

				foreach ($terms as $term) {
					if ($term->count > 0){
						$categories_array[] = array('archive_url' => get_category_link($term->term_id), 'slug' => $term->slug);
					}
				}
        		break;

        	case 'react':
				$terms = get_terms(array(
					'taxonomy' => 'news-reaction',
					'hide_empty' => false
				));
				foreach ($terms as $react_term) {
					$reactions_array[] = array('archive_url' => get_term_link($react_term->term_id), 'slug' => $react_term->slug, 'image' => get_term_meta($react_term->term_id, 'reaction_image', true));
				}
        		break;
        	
        	default:
				$cat_terms = get_categories(array(
					'orderby' => 'count'
				));

				foreach ($cat_terms as $cat_term) {
					if ($cat_term->count > 0){
						$categories_array[] = array('archive_url' => get_category_link($cat_term->term_id), 'slug' => $cat_term->slug);
					}
				}

				$react_terms = get_terms(array(
					'taxonomy' => 'news-reaction',
					'hide_empty' => false
				));

				foreach ($react_terms as $react_term) {
					$reactions_array[] = array('archive_url' => get_term_link($react_term->term_id), 'slug' => $react_term->slug, 'image' => get_term_meta($react_term->term_id, 'reaction_image', true));
				}
        		break;
        }

	    ?>

		<div class="qode-news-blog-cr-widget">
			<div class="qode-news-bcr-opener-holder">
				<div class="qode-news-bcr-opener">
					<span class="qode-bcr-circle"></span>
					<span class="qode-bcr-circle"></span>
					<span class="qode-bcr-circle"></span>
				</div>
			</div>
	    	<div class="qode-news-bcr-dropdown">
				<?php if ( ! empty( $instance['title'] ) ) { ?>
	            	<div class="qode-news-blog-cr-title-holder">
	            		<<?php echo esc_attr($instance['title_tag']);?> class="qode-news-bcr-title">
					    	<?php echo esc_html( $instance['title'] ); ?>
					    </<?php echo esc_attr($instance['title_tag']);?>>
					</div>
				<?php } ?>
				<?php if (count($categories_array)) { ?>
						<div class="qode-news-bcr-cats">
							<?php foreach ($categories_array as $category) { ?>
								<a href="<?php echo esc_url($category['archive_url']);?>" class="qode-news-bcr-category">
									<?php echo esc_html($category['slug']); ?>
								</a>
							<?php } ?>
						</div>
				<?php } ?>
				<?php if (count($reactions_array)) { ?>
						<div class="qode-news-bcr-reacts">
							<?php foreach ($reactions_array as $reaction) { ?>
								<a href="<?php echo esc_url($reaction['archive_url']);?>" class="qode-news-bcr-reaction">
									<?php echo wp_get_attachment_image($reaction['image']); ?>
									<?php echo esc_html($reaction['slug']); ?>
								</a>
							<?php } ?>
						</div>
				<?php } ?>
			</div>
	    </div>

	    <?php 
    }
}