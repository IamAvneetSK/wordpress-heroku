<?php if ( isset( $instructor ) & ! empty( $instructor ) ) { ?>
	<div class="qode-grid-col-5">
		<div class="qode-course-instructor">
			<div class="qode-instructor-image">
				<?php echo get_the_post_thumbnail( $instructor, array( 80, 80 ) ); ?>
			</div>
			<div class="qode-instructor-info">
	            <span class="qode-instructor-label">
	                <?php esc_html_e( 'Instructor:', 'qode-lms' ) ?>
	            </span>
				<a itemprop="url" href="<?php echo get_permalink( $instructor ); ?>" target="_self">
	                <span class="qode-instructor-name">
	                    <?php echo get_the_title( $instructor ); ?>
	                </span>
				</a>
			</div>
		</div>
	</div>
<?php } ?>