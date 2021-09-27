<?php
$agency_name = get_user_meta($author->ID, 'qodef_agency_name', true);
$agency_licence = get_user_meta($author->ID, 'qodef_agency_licence', true);
?>
<div class="qodef-re-author-title-holder">
	<h1 class="qodef-re-author-description">
		<?php echo esc_html($agency_licence); ?>
	</h1>
	<h3 class="qodef-re-author-title">
        <?php echo esc_html($agency_name); ?>
    </h3>
</div>