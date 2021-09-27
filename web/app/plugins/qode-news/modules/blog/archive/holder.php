<div>
	<?php
	$qode_archive_params = array();

	$qode_object_id = get_queried_object_id();

	$qode_cat_slug = '';
	$author_id = '';
	$qode_tag_slug = '';

    if(is_category()){
		$qode_cat = get_category($qode_object_id);
		$qode_cat_slug = !empty($qode_cat) ? $qode_cat->slug : '';
    }
    if(is_author()){
		$author_id = $qode_object_id;
    }
    if(is_tag()){
		$qode_tag = get_tag($qode_object_id);
		$qode_tag_slug = !empty($qode_tag) ? $qode_tag->slug : '';
    }
    if(is_date()){
		$qode_archive_params['year'] = get_query_var('year');
		$qode_archive_params['monthnum'] = get_query_var('monthnum');
		$qode_archive_params['day'] = get_query_var('day');
    }

	$qode_archive_params['category_name'] = $qode_cat_slug;
	$qode_archive_params['author_id'] = $author_id;
	$qode_archive_params['tag'] = $qode_tag_slug;
	$qode_archive_params['column_number'] = 3;
	$qode_archive_params['posts_per_page'] = get_option( 'posts_per_page' );
	$qode_archive_params['display_pagination'] = 'yes';
	$qode_archive_params['pagination_type'] = 'standard';
	$qode_archive_params['space_between_items'] = 'normal';
	$qode_archive_params['excerpt_length'] = '20';
	$qode_archive_params['image_size'] = 'portfolio_slider';

    echo bridge_qode_execute_shortcode('qode_layout1', $qode_archive_params);
	?>
</div>
