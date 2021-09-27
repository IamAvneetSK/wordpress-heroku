<?php
if(post_password_required()) {
	echo get_the_password_form();
} else {
	$excerpt_length = isset($params['excerpt_length']) ? $params['excerpt_length'] : '';
	$excerpt = bridge_qode_excerpt($excerpt_length);
	
	if(!empty($excerpt)) { ?>
		<div class="qode-post-excerpt-holder">
			<p itemprop="description" class="qode-post-excerpt">
				<?php echo wp_kses_post($excerpt); ?>
			</p>
		</div>
	<?php }
} ?>