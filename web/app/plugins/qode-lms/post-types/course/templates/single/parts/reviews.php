<?php if ( comments_open() ) { ?>
	<div class="qode-grid-col-4">
		<div class="qode-course-reviews">
			<div class="qode-course-reviews-label">
				<?php esc_html_e( 'Reviews:', 'qode-lms' ) ?>
			</div>
			<span class="qode-course-stars">
	            <?php
	            $review_rating = qode_lms_course_average_rating();
	            for ( $i = 1; $i <= $review_rating; $i ++ ) { ?>
		            <i class="fa fa-star" aria-hidden="true"></i>
	            <?php } ?>
			</span>
			<!-- This should change to open tab -->
			<a itemprop="url" class="qode-post-info-comments" href="<?php comments_link(); ?>" target="_self">
				<?php comments_number( '0 ' . esc_html__( 'Reviews', 'qode-lms' ), '1 ' . esc_html__( 'Review', 'qode-lms' ), '% ' . esc_html__( 'Reviews', 'qode-lms' ) ); ?>
			</a>
		</div>
	</div>
<?php } ?>