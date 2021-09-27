<?php $reviews = get_post_meta(get_the_ID(), 'qode_album_reviews', true); ?>
<?php if(is_array($reviews) && count($reviews) > 0): ?>
	<div class="qode-single-album-reviews-holder">
		<h2 class="qode-single-album-reviews-title"><?php esc_html_e('Album Reviews', 'qode-music'); ?></h2>
		<div class="qode-single-album-reviews qode-owl-slider">
			<?php
				foreach($reviews as $review) : ?>
				<div class="qode-single-album-review">
					<?php if($review['qode_album_review_text'] != ''): ?>
						<p class="qode-single-album-text"><span class="fa fa-angle-double-left"></span>&nbsp<?php echo esc_html($review['qode_album_review_text']); ?>&nbsp<span class="fa fa-angle-double-right"></span></p>
					<?php endif; ?>
					<?php if($review['qode_album_review_author'] != ''): ?>
						<h4 class="qode-single-album-author"><?php echo esc_attr($review['qode_album_review_author']); ?></h4>
					<?php endif; ?>

				</div>
				<?php
					endforeach;
				?>
		</div>
	</div>
<?php endif; ?>