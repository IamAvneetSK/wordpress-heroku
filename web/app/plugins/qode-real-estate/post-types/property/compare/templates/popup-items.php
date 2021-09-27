<ul id="qodef-re-popup-items">
    <li>
        <div class="qodef-re-empty-div">

        </div>
        <?php foreach($added_properties as $property) { ?>
            <?php
                $property_params = array();
                $property_params['id'] = $property;
                //$property_params['enable_remove_icon'] = true;
            ?>
            <div class="qodef-re-item-holder">
	            <div class="qodef-item-top-section">
		            <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/parts/remove', 'property', '', $property_params ); ?>
		            <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/parts/image', 'property', '', $property_params ); ?>
		            <div class="qodef-item-top-section-content">
			            <div class="qodef-item-top-section-content-inner">
				            <div class="qodef-item-info-top">
					            <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/parts/taxonomy-status', 'property', '', $property_params ); ?>
				            </div>
			            </div>
		            </div>
	            </div>
	            <div class="qodef-item-bottom-section">
		            <div class="qodef-item-bottom-section-content">
			            <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/parts/title', 'property', '', $property_params ); ?>
			            <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/parts/price', 'property', '', $property_params ); ?>
		            </div>
	            </div>
            </div>
        <?php } ?>
    </li>
    <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/compare-items/size', 'property', '', $params ); ?>
    <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/compare-items/bedrooms', 'property', '', $params ); ?>
    <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/compare-items/bathrooms', 'property', '', $params ); ?>
    <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/compare-items/floor', 'property', '', $params ); ?>
    <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/compare-items/year-built', 'property', '', $params ); ?>
    <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/compare-items/features', 'property', '', $params ); ?>
</ul>
