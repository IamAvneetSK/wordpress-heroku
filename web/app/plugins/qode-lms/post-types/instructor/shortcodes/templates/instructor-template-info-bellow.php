<div class="qode-instructor qode-item-space <?php echo esc_attr( $instructor_layout ) ?>">
	<div class="qode-instructor-inner">
		<?php if ( get_the_post_thumbnail( $instructor_id ) !== '' ) { ?>
			<div class="qode-instructor-image">
				<a itemprop="url" href="<?php echo esc_url( get_the_permalink( $instructor_id ) ) ?>">
					<?php echo get_the_post_thumbnail( $instructor_id, 'thumbnail' ); ?>
				</a>
			</div>
		<?php } ?>
		<div class="qode-instructor-info">
			<div class="qode-instructor-title-holder">
				<<?php echo esc_attr($name_title_tag); ?> itemprop="name" class="qode-instructor-name entry-title">
					<a itemprop="url" href="<?php echo esc_url( get_the_permalink( $instructor_id ) ) ?>"><?php echo esc_html( $title ) ?></a>
				</<?php echo esc_attr($name_title_tag); ?>>
				
				<?php if ( ! empty( $position ) ) { ?>
					<<?php echo esc_attr($position_title_tag); ?> class="qode-instructor-position"><?php echo esc_html( $position ); ?></<?php echo esc_attr($position_title_tag); ?>>
				<?php } ?>
			</div>
			<?php if ( $enable_excerpt === 'yes' && ! empty( $excerpt ) ) { ?>
				<div class="qode-instructor-text">
					<div class="qode-instructor-text-inner">
						<div class="qode-instructor-description">
							<p itemprop="description" class="qode-instructor-excerpt"><?php echo esc_html( $excerpt ); ?></p>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="qode-instructor-social-holder-between">
				<div class="qode-instructor-social">
					<div class="qode-instructor-social-inner">
						<div class="qode-instructor-social-wrapp">
							<?php foreach ( $instructor_social_icons as $instructor_social_icon ) {
								echo wp_kses_post( $instructor_social_icon );
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>