<div class="qode-instructor qode-item-space <?php echo esc_attr( $instructor_layout ) ?>">
	<div class="qode-instructor-inner">
		<?php if ( get_the_post_thumbnail( $instructor_id ) !== '' ) { ?>
			<div class="qode-instructor-image">
				<a itemprop="url" href="<?php echo esc_url( get_the_permalink( $instructor_id ) ) ?>">
					<?php echo get_the_post_thumbnail( $instructor_id, 'full' ); ?>
				</a>
			</div>
		<?php } ?>
		<div class="qode-instructor-info">
			<div class="qode-instructor-title-holder">
				<<?php echo esc_attr($name_title_tag); ?> itemprop="name" class="qode-instructor-name entry-title">
					<a itemprop="url" href="<?php echo esc_url( get_the_permalink( $instructor_id ) ) ?>"><?php echo esc_html( $title ) ?></a>
				</<?php echo esc_attr($name_title_tag); ?>>
				<?php if ( ! empty( $position ) ) { ?>
					<<?php echo esc_attr($position_title_tag); ?>>
						<span class="qode-instructor-position"><?php echo esc_html( $position ); ?></span>
					</<?php echo esc_attr($position_title_tag); ?>>
				<?php } ?>
			</div>
		</div>
	</div>
</div>