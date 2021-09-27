<?php
$user_favorites = get_user_meta( get_current_user_id(), 'qode_course_wishlist', true );
?>
<div class="qode-lms-profile-favorites-holder">
	<?php if ( ! empty( $user_favorites ) ) { ?>
		<?php
		foreach ( $user_favorites as $user_favorite ) { ?>
			<div class="qode-lms-profile-favorite-item">
				<div class="qode-lms-profile-favorite-item-image">
					<?php
					if ( has_post_thumbnail( $user_favorite ) ) {
						$image = get_the_post_thumbnail_url( $user_favorite, 'thumbnail' );
					} else {
						$image = QODE_LMS_CPT_URL_PATH . '/course/assets/img/course_featured_image.jpg';
					}
					?>
					<img src="<?php echo esc_attr( $image ); ?>" alt="<?php echo esc_attr( 'Course thumbnail', 'qode-lms' ) ?>"/>
				</div>
				<div class="qode-lms-profile-favorite-item-title">
					<h4>
						<a href="<?php echo get_the_permalink( $user_favorite ); ?>">
							<?php echo get_the_title( $user_favorite ); ?>
						</a>
						<?php
						$icon = qode_lms_is_course_in_wishlist( $user_favorite ) ? 'fa-heart' : 'fa-heart-o';
						?>
						<a href="javascript:void(0)" class="qode-course-whishlist qode-icon-only" data-course-id="<?php echo esc_attr( $user_favorite ); ?>">
							<i class="fa <?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
						</a>
					</h4>
				</div>
			</div>
			<?php
		}
	} else { ?>
		<h3><?php esc_html_e( "Your favorites list is empty.", "qode-lms" ) ?> </h3>
	<?php } ?>
</div>