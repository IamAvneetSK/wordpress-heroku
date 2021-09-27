<?php if ( ! empty( $quiz_results ) && ! $empty ) { ?>
	<div class="qode-quiz-retakes">
		<div class="qode-results-caption">
			<?php echo esc_html__( 'Other results', 'qode-lms' ); ?>
		</div>
		<table>
			<thead>
			<tr>
				<th>
					<?php echo esc_html__( '#', 'qode-lms' ); ?>
				</th>
				<th>
					<?php echo esc_html__( 'Date', 'qode-lms' ); ?>
				</th>
				<th>
					<?php echo esc_html__( 'Time', 'qode-lms' ); ?>
				</th>
				<th>
					<?php echo esc_html__( 'Result', 'qode-lms' ); ?>
				</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ( $quiz_results as $key => $quiz_result ) { ?>
				<?php if ( $quiz_result['status'] == 'completed' ) { ?>
					<tr>
						<td>
							<?php echo esc_html( $key + 1 ); ?>
						</td>
						<td>
							<?php echo esc_html( $quiz_result['timestamp'] ); ?>
						</td>
						<td>
							<?php echo esc_html( $quiz_result['time'] ); ?>
						</td>
						<td>
							<?php echo esc_html( $quiz_result['result'] ) . '%'; ?>
						</td>
					</tr>
				<?php } ?>
			<?php } ?>
			</tbody>
		</table>
	</div>
<?php }