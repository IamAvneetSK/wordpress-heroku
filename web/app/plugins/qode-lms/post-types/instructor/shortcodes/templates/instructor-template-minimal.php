<div class="qode-instructor qode-item-space <?php echo esc_attr( $instructor_layout ) ?>">
	<div class="qode-instructor-inner">
		<?php if ( get_the_post_thumbnail( $instructor_id ) !== '' ) { ?>
			<div class="qode-instructor-image">
				<a itemprop="url" href="<?php echo esc_url( get_the_permalink( $instructor_id ) ) ?>">
					<?php echo get_the_post_thumbnail( $instructor_id, 'full' ); ?>
				</a>
			</div>
		<?php } ?>
	</div>
</div>