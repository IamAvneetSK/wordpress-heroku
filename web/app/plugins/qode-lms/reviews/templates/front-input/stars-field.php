<div class="qode-rating-form-title-holder">
	<div class="qode-comment-form-rating">
		<label><?php esc_html_e( 'Rating', 'qode-lms' ) ?><span class="required">*</span></label>
		<span class="qode-comment-rating-box">
			<?php for ( $i = 1; $i <= 5; $i ++ ) { ?>
				<span class="qode-star-rating" data-value="<?php echo esc_attr( $i ); ?>"></span>
			<?php } ?>
		</span>
	</div>
</div>