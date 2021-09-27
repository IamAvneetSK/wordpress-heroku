<?php
	$list_params = array(

		'type' => 'advanced',
		'title' => get_the_title($id),
		'image' => get_post_thumbnail_id( $id ),
		'price' => $price,
		'additional_info' => $additional_info,
		'price_period' => $purchase_note,
		'show_button' => 'yes',
		'link'  => $link,
		'button_text'  => $button_text,

	);

	//set default params for elementor so we can use template directly
	if( isset( $is_elementor_listing_package ) && $is_elementor_listing_package ){
	    $list_params['is_elementor_listing_package'] = true;
	    $list_params['target'] = '_self';
	    $list_params['active'] = 'no';
	    $list_params['currency'] = esc_html__('$', 'bridge-core');
	    $list_params['subtitle'] = '';
	    $list_params['title_tag'] = 'h4';
	    $list_params['short_info'] = '';
	    $list_params['button_size'] = 'medium';
	    $list_params['content'] = $content;
    }

	echo bridge_core_get_pricing_table_item_html($list_params, do_shortcode($content));