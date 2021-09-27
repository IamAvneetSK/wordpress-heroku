<?php

if ( ! function_exists( 'qode_news_add_single_blog_template_meta' ) ) {
	function qode_news_add_single_blog_template_meta( $single_blog_templates_meta ) {
		$single_blog_templates_meta['news-template'] = 'News Template';

		return $single_blog_templates_meta;
	}
	add_filter( 'bridge_qode_filter_single_blog_templates_meta', 'qode_news_add_single_blog_template_meta' );
}

if (!function_exists('qode_news_map_post_meta')){
	function qode_news_map_post_meta($post_meta_box){

		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qode_news_post_featured_meta',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Featured Post', 'qode-news' ),
				'description'   => esc_html__( 'Choose whether post is featured or not', 'qode-news' ),
				'default_value' => 'no',
				'parent'        => $post_meta_box,
				'options'       => array(
					'no'       => esc_html__( 'No', 'qode-news' ),
					'yes' => esc_html__( 'Yes', 'qode-news' ),
				)
			)
		);

		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qode_news_post_trending_meta',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Trending Post', 'qode-news' ),
				'description'   => esc_html__( 'Choose whether post is trending or not', 'qode-news' ),
				'default_value' => 'no',
				'parent'        => $post_meta_box,
				'options'       => array(
					'no'       => esc_html__( 'No', 'qode-news' ),
					'yes' => esc_html__( 'Yes', 'qode-news' ),
				)
			)
		);

		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qode_news_post_hot_meta',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Hot Post', 'qode-news' ),
				'description'   => esc_html__( 'Choose whether post is hot or not', 'qode-news' ),
				'default_value' => 'no',
				'parent'        => $post_meta_box,
				'options'       => array(
					'no'       => esc_html__( 'No', 'qode-news' ),
					'yes' => esc_html__( 'Yes', 'qode-news' ),
				)
			)
		);
	}

	add_action( 'bridge_qode_action_blog_post_meta', 'qode_news_map_post_meta', 5, 1);
}