<?php if ( $filter == 'yes' ) { ?>
	<div class="qode-cl-filter-holder">
		<div class="qode-course-layout-filter">
			<span class="qode-active" data-type="gallery"><i class=" dripicons-view-apps" aria-hidden="true"></i></span>
			<span data-type="simple"><i class="dripicons-view-list" aria-hidden="true"></i></span>
		</div>
		<div class="qode-course-items-counter">
			<span class="counter-label"><?php esc_html_e( 'Showing', 'qode-lms' ); ?></span>
			<span class="counter-min-value"><?php echo esc_html( $pagination_values['min_value'] ) ?></span>
			<span class="counter-dash">&ndash;</span>
			<span class="counter-max-value"><?php echo esc_html( $pagination_values['max_value'] ) ?></span>
			<span class="counter-label"><?php esc_html_e( 'of', 'qode-lms' ); ?></span>
			<span class="counter-total"><?php echo esc_html( $pagination_values['total_items'] ) ?></span>
		</div>
		<div class="qode-course-items-order">
			<select class="qode-course-order-filter">
				<option data-type="date"
				        data-order="DESC"><?php esc_html_e( 'Newly Published', 'qode-lms' ); ?></option>
				<option data-type="name" data-order="ASC"><?php esc_html_e( 'A-Z', 'qode-lms' ); ?></option>
				<option data-type="name" data-order="DESC"><?php esc_html_e( 'Z-A', 'qode-lms' ); ?></option>
			</select>
		</div>
	</div>
<?php } ?>