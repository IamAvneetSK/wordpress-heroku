<?php
$tabs = apply_filters( 'qode_single_course_tabs', array() );
if ( ! empty( $tabs ) ) :
	?>
	
	<div class="qode-tabs qode-advanced-tabs qode-tabs-standard">
		<ul class="qode-tabs-nav clearfix">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<?php if ( isset( $tab['link'] ) ) { ?>
				<li class="qode-custom-tab-link">
					<a class="qode-external-link" href="<?php echo esc_attr( $tab['link'] ); ?>">
				<?php } else { ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab">
					<a href="#tab-<?php echo esc_attr( $key ); ?>">
				<?php } ?>
						<!-- <span class="qode-tab-icon">
		                    <?php print $tab['icon']; ?>
		                </span> -->
						<span class="qode-tab-title">
		                    <?php echo apply_filters( 'qode_sc_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?>
		                </span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<?php if ( ! isset( $tab['link'] ) ) { ?>
				<div class="qode-tab-container" id="tab-<?php echo sanitize_title( $key ); ?>">
					<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/' . $tab['template'], 'course', '', $params ); ?>
				</div>
			<?php } ?>
		<?php endforeach; ?>
	</div>

<?php endif; ?>