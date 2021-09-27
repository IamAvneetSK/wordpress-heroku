<?php 

$display_review = isset($display_review) && $display_review !== '' ? $display_review : 'yes';

$review_average = get_post_meta(get_the_ID(), 'qode_news_review_average', true);

if ($display_review == 'yes' && $review_average !== '') {
$review_average_params['style'] = 'width: ' . ($review_average * 20).'%'; //20 is 100/5, calculating percent
?>
<div class="qode-post-review">
	<?php echo qode_news_get_template_part('template/stars','review','', $review_average_params);?>
	<span class="qode-post-review-text">
		<?php echo esc_html($review_average);?>
		<?php esc_html_e('stars','qode-news');?>
	</span>
</div>
<?php } ?>