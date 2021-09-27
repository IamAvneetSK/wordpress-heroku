<?php if ( $enable_image == 'yes' ) { ?>
	<?php echo qode_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/image', $item_layout, $params ); ?>
<?php } ?>

<div class="qode-cli-text-holder">
	<div class="qode-cli-text-wrapper">
		<div class="qode-cli-text">
			<?php echo qode_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/title', $item_layout, $params ); ?>
			<?php if ( $enable_instructor == 'yes' ) { ?>
				<?php echo qode_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/instructor-simple', $item_layout, $params ); ?>
			<?php } ?>
			<?php if ( $enable_price == 'yes' ) { ?>
				<?php echo qode_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/price', $item_layout, $params ); ?>
			<?php } ?>
		</div>
	</div>
</div>