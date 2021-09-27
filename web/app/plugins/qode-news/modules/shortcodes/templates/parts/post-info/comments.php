<?php if(comments_open()) { ?>
	<div class="qode-post-info-comments-holder">
		<a itemprop="url" class="qode-post-info-comments" href="<?php comments_link(); ?>" target="_self">
			<?php comments_number('0 ' . esc_html__('Comments','qode-news'), '1 '.esc_html__('Comment','qode-news'), '% '.esc_html__('Comments','qode-news') ); ?>
		</a>
	</div>
<?php } ?>