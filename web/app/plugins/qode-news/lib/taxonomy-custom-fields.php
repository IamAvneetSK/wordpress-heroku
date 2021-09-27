<?php

if (!function_exists('qode_news_category_fields')) {
	function qode_news_category_fields() {

		$category_fields = bridge_qode_add_taxonomy_fields(
			array(
				'scope' => 'category',
				'name'  => 'news_category'
			)
		);

		bridge_qode_add_taxonomy_field(
			array(
				'name'        => 'category_color',
				'type'        => 'color',
				'label'       => esc_html__( 'Color', 'qode-news' ),
				'description' => '',
				'parent'      => $category_fields
			)
		);


	}
	add_action('bridge_qode_action_custom_taxonomy_fields', 'qode_news_category_fields');
}