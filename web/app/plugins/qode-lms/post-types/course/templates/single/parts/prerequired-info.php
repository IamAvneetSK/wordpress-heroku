<?php if ( isset( $prerequired ) && ! empty( $prerequired ) ) { ?>
	<div class="qode-course-prerequired-info">
		<a itemprop="url" target="_self" href="<?php the_permalink( $prerequired ); ?>"><?php echo esc_html__( 'Course', 'qode-lms' ) . ' ' . get_the_title( $prerequired ) . ' ' . esc_html__( 'must be completed first', 'qode-lms' ); ?></a>
	</div>
<?php } ?>