<?php

$display_hot_trending_icons = isset($display_hot_trending_icons) && $display_hot_trending_icons !== '' ? $display_hot_trending_icons : 'no';
$display_hot_trending_text = isset($display_hot_trending_text) && $display_hot_trending_text !== '' ? $display_hot_trending_text : false;
$hot_trending_class = $display_hot_trending_text ? 'qode-ht-with-text' : '';

$trending = get_post_meta(get_the_ID(),'qode_news_post_trending_meta', true) == 'yes' ? true : false;
$hot = get_post_meta(get_the_ID(),'qode_news_post_hot_meta', true) == 'yes' ? true : false;

if ($display_hot_trending_icons == 'yes' && ($trending || $hot)){ ?>
	<div class="qode-post-info-hot-trending <?php echo esc_attr($hot_trending_class); ?>">
		<?php if ($trending) { ?>
			<div class="qode-post-info-trending">
				<span class="qode-news-ht-icon qode-news-trending"></span>
				<?php if ($display_hot_trending_text) {
					esc_html_e('This post is trending','mikado-news');
				} ?>
			</div>
		<?php } ?>
		<?php if ($hot) { ?>
			<div class="qode-post-info-hot">
				<span class="qode-news-ht-icon qode-news-hot"></span>
				<?php if ($display_hot_trending_text) {
					esc_html_e('This post is hot','mikado-news');
				} ?>
			</div>
		<?php } ?>
	</div>
<?php } ?>