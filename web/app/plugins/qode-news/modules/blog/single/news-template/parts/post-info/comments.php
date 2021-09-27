<?php if(comments_open()) { ?>
	<div class="qode-post-info-comments-holder">
        <i class="dripicons-message"></i>
		<a itemprop="url" class="qode-post-info-comments" href="<?php comments_link(); ?>" target="_self">
			<?php comments_number('0 ' . esc_html__('comments','qode-news'), '1 '.esc_html__('comment','qode-news'), '% '.esc_html__('comments','qode-news') ); ?>
		</a>
	</div>
<?php } ?>