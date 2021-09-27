<?php
$categories = wp_get_post_terms( get_the_ID(), 'course-category' );
if ( is_array( $categories ) && count( $categories ) ) :
	?>
	<div class="qode-grid-col-3">
		<div class="qode-course-categories">
			<div class="qode-course-category-label">
				<?php esc_html_e( 'Categories:', 'qode-lms' ) ?>
			</div>
			<div class="qode-course-category-items">
				<?php foreach ( $categories as $cat ) { ?>
					<a itemprop="url" class="qode-course-category" href="<?php echo esc_url( get_term_link( $cat->term_id ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
				<?php } ?>
			</div>
		
		</div>
	</div>
<?php endif;