<div class="qode-news-reaction-term">
	<a href="" class="qode-reaction <?php echo esc_attr($reacted);?>" data-reaction="<?php echo esc_attr($slug);?>">
		<div class="qode-rt-image-holder">
			<?php echo wp_get_attachment_image($image);?>
		</div>
		<div class="qode-rt-content">
			<div class="qode-rt-name">
				<?php echo esc_html($name);?>
			</div>
			<div class="qode-rt-value">
				<?php echo esc_html($reaction_value); ?>
			</div>
		</div>
	</a>
</div>