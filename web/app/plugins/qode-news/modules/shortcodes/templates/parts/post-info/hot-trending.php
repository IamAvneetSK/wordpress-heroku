<?php

$display_hot_trending_icons = isset($display_hot_trending_icons) && $display_hot_trending_icons !== '' ? $display_hot_trending_icons : 'no';

$trending = get_post_meta(get_the_ID(),'qode_news_post_trending_meta', true) == 'yes' ? true : false;
$hot = get_post_meta(get_the_ID(),'qode_news_post_hot_meta', true) == 'yes' ? true : false;

if ($display_hot_trending_icons == 'yes' && ($trending || $hot)){ ?>
	<div class="qode-post-info-hot-trending">
		<?php if ($trending) { ?>
			<div class="qode-post-info-trending">
				<span class="qode-news-ht-icon qode-news-trending"></span>
			</div>
		<?php } ?>
		<?php if ($hot) { ?>
			<div class="qode-post-info-hot">
				<span class="qode-news-ht-icon qode-news-hot"></span>
			</div>
		<?php } ?>
	</div>
<?php } ?>