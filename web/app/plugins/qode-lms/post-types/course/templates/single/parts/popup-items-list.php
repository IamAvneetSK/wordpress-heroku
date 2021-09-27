<?php
$course_sections = get_post_meta( get_the_ID(), 'qode_course_curriculum', true );
if ( ! empty( $course_sections ) ) { ?>
	<div class="qode-course-popup-items">
		<div class="qode-course-popup-items-list">
			<?php foreach ( $course_sections as $course_section ) { ?>
				<div class="qode-popup-items-section">
					<h6 class="qode-section-name">
						<?php echo esc_html( $course_section['section_name'] ) ?>
					</h6>
					<h5 class="qode-section-title">
						<?php echo esc_html( $course_section['section_title'] ) ?>
					</h5>
					<div class="qode-section-content">
						<?php
						if ( isset( $course_section['section_elements'] ) && $course_section['section_elements'] !== '' ) {
							$section_elements = $course_section['section_elements'];
							if ( ! empty( $section_elements ) ) {
								$list            = qode_lms_get_course_curriculum_list( $section_elements );
								$elements        = $list['elements'];
								$lessons_summary = $list['lessons_summary'];
								?>
								<div class="qode-section-elements">
									<?php if ( ! empty( $lessons_summary ) ) {
										$lesson_info = implode( ', ', $lessons_summary );
										?>
										<div class="qode-section-elements-summary">
											<i class="fa fa-folder-open" aria-hidden="true"></i>
											<span class="qode-summary-value"><?php echo esc_html( $lesson_info ); ?></span>
										</div>
									<?php } ?>
									<?php foreach ( $elements as $key => $element ) { ?>
										<div class="qode-section-element <?php echo esc_attr( $element['class'] ); ?> clearfix <?php echo qode_lms_get_course_item_completed_class( $element['id'] ); ?>" data-section-element-id="<?php echo esc_attr( $element['id'] ); ?>">
											<div class="qode-element-title">
                                                <span class="qode-element-icon">
                                                    <?php print $element['icon']; ?>
                                                </span>
												<span class="qode-element-label">
                                                    <?php echo esc_attr( $element['label'] ); ?>
                                                </span>
												<?php if ( qode_lms_course_is_preview_available( $element['id'] ) ) { ?>
													<a class="qode-element-name qode-element-link-open" itemprop="url" href="<?php echo esc_attr( $element['url'] ); ?>" title="<?php echo esc_attr( $element['title'] ); ?>" data-item-id="<?php echo esc_attr( $element['id'] ); ?>" data-course-id="<?php echo get_the_ID(); ?>">
														<?php echo esc_html( $element['title'] ); ?>
														<?php if ( ! qode_lms_user_has_course() || ! qode_lms_user_completed_prerequired_course() ) { ?>
															<span class="qode-element-preview-holder"><?php esc_html_e( 'preview', 'qode-lms' ); ?></span>
														<?php } ?>
													</a>
												<?php } else { ?>
													<?php echo esc_html( $element['title'] ); ?>
												<?php } ?>
											</div>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>
