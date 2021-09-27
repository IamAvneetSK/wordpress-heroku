<thead>
<tr>
	<td>
		<?php esc_html_e( "Course program", "qode-lms" ); ?>
	</td>
	<?php if ( $enable_category == 'yes' ) { ?>
		<td>
			<?php esc_html_e( "Category", "qode-lms" ); ?>
		</td>
	<?php } ?>
	<?php if ( $enable_instructor == 'yes' ) { ?>
		<td>
			<?php esc_html_e( "Instructor", "qode-lms" ); ?>
		</td>
	<?php } ?>
	<?php if ( $enable_students == 'yes' ) { ?>
		<td>
			<?php esc_html_e( "Students", "qode-lms" ); ?>
		</td>
	<?php } ?>
	<?php if ( $enable_price == 'yes' ) { ?>
		<td>
			<?php esc_html_e( "Price", "qode-lms" ); ?>
		</td>
	<?php } ?>
	<td>
		&nbsp;
	</td>
</tr>
</thead>