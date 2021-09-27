<div class="qodef-re-profile-favorites-holder">
	<?php if ( ! empty( $user_favorites ) ) { ?>
        <h2 class="qodef-membership-page-title"><?php esc_html_e('Property Wishlist', 'qode-real-estate'); ?></h2>
        <p><?php esc_html_e('Property wishlist', 'qode-real-estate'); ?></p>
		<?php foreach ( $user_favorites as $user_favorite ) { ?>
			<div class="qodef-re-profile-favorite-item">
				<div class="qodef-re-profile-favorite-item-image">
					<?php
					if ( has_post_thumbnail( $user_favorite ) ) {
						$image = get_the_post_thumbnail_url( $user_favorite, 'thumbnail' );
					} else {
						$image = QODE_RE_CPT_URL_PATH . '/property/assets/img/property_featured_image.jpg';
					}
					?>
					<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( 'Property thumbnail', 'qode-real-estate' ) ?>"/>
				</div>
				<div class="qodef-re-profile-favorite-item-title">
					<h4>
						<a href="<?php echo get_the_permalink( $user_favorite ); ?>">
							<?php echo get_the_title( $user_favorite ); ?>
						</a>
                        <?php qode_membership_get_favorite_template($user_favorite); ?>
					</h4>
				</div>
			</div>
			<?php
		}
	} else { ?>
		<h3><?php esc_html_e( 'Your favorites list is empty.', 'qode-real-estate' ) ?> </h3>
	<?php } ?>
</div>