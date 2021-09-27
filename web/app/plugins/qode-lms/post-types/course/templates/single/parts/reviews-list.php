<div class="qode-course-reviews-main-title">
	<h4><?php esc_html_e( 'Ratings and Reviews', 'qode-lms' ) ?></h4>
</div>

<div class="qode-course-reviews-list-top">
	<div class="qode-grid-row">
		<div class="qode-grid-col-3">
			<div class="qode-course-reviews-number-wrapper">
				<span class="qode-course-reviews-number"><?php echo qode_lms_course_average_rating(); ?></span>
				<span class="qode-course-stars-wrapper">
					<span class="qode-course-stars">
						<?php
						$review_rating = qode_lms_course_average_rating();
						for ( $i = 1; $i <= $review_rating; $i ++ ) { ?>
							<i class="fa fa-star" aria-hidden="true"></i>
						<?php } ?>
					</span>
					<span class="qode-course-reviews-count">
						<?php echo esc_html__( 'Rated', 'qode-lms' ) . ' ' . qode_lms_course_average_rating() . ' ' . esc_html__( 'out of', 'qode-lms' ) . ' ';
						comments_number( '0 ' . esc_html__( 'Ratings', 'qode-lms' ), '1 ' . esc_html__( 'Rating', 'qode-lms' ), '% ' . esc_html__( 'Ratings', 'qode-lms' ) ); ?>
					</span>
				</span>
			</div>
		</div>
		<div class="qode-grid-col-9">
			<div class="qode-course-rating-percente-wrapper">
				<?php $ratings_array = qode_lms_course_ratings();
				$number              = qode_lms_course_number_of_ratings();
				foreach ( $ratings_array as $item => $value ) {
					$percentage = $number == 0 ? 0 : round( ( $value / $number ) * 100 );
					echo do_shortcode( '[progress_bar percent="' . $percentage . '" title="' . $item . esc_html__( ' stars', 'qode-lms' ) . '"]' );
				}
				?>
			</div>
		</div>
	</div>
</div>
<div class="qode-course-reviews-list">
	<?php comments_template( '', true ); ?>
</div>