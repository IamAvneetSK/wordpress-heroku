<?php
$views = qode_news_get_post_count_views(get_the_ID());
$display_views = isset($display_views) && $display_views !== '' ? $display_views : 'yes';

if (intval($views) > 1000) {
	$views = round($views/1000, 2) . esc_html__('k','qode-news');
}

if ($display_views == 'yes') { ?>
	<div class="qode-views-holder">
		<span class="fa fa-eye"></span>
		<span class="qode-views"><?php echo esc_html($views)?></span>
	</div>
<?php } ?>