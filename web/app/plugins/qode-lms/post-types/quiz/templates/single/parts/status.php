<?php if ( ! $first_attempt ) { ?>
	<div class="qode-quiz-results">
		<?php if ( isset( $post_message ) && ! empty( $post_message ) ) { ?>
			<div class="qode-results-message">
				<?php echo esc_html( $post_message ); ?>
			</div>
		<?php } ?>
		<div class="qode-results-caption">
			<?php echo esc_html__( 'You have reached ', 'qode-lms' ) . $points . esc_html__( ' of ', 'qode-lms' ) . $points_t . esc_html__( ' points ', 'qode-lms' ) . '(' . $points_p . '%)'; ?>
		</div>
		<div class="qode-results-values">
			<div class="qode-results-correct"><?php echo esc_html__( 'Correct', 'qode-lms' ) . ' ' . $correct ?></div>
			<div class="qode-results-wrong"><?php echo esc_html__( 'Wrong', 'qode-lms' ) . ' ' . $wrong ?></div>
			<div class="qode-results-empty"><?php echo esc_html__( 'Empty', 'qode-lms' ) . ' ' . $empty ?></div>
			<div class="qode-results-points"><?php echo esc_html__( 'Points', 'qode-lms' ) . ' ' . $points . '/' . $points_t ?></div>
			<div class="qode-results-time"><?php echo esc_html__( 'Time', 'qode-lms' ) . ' ' . $time ?></div>
		</div>
	</div>
	<div class="qode-quiz-message">
		<?php if ( $points_p < $required_p ) { ?>
			<div class="qode-message-error">
				<?php echo esc_html__( 'Your quiz grade - failed. Quiz requirement', 'qode-lms' ) . ' ' . esc_attr( $required_p ) . '%'; ?>
			</div>
		<?php } else { ?>
			<div class="qode-message-error">
				<?php echo esc_html__( 'Your quiz grade - success.', 'qode-lms' ); ?>
			</div>
		<?php } ?>
	</div>
<?php } ?>
