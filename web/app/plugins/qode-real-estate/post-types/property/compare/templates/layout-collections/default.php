<div class="qodef-ci-item" data-item-id="<?php echo esc_attr($id); ?>">
    <div class="qodef-ci-item-inner">
        <div class="qodef-item-top-section">
	        <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/parts/remove', 'property', '', $params ); ?>
            <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/parts/image', 'property', '', $params ); ?>
            <div class="qodef-item-top-section-content">
                <div class="qodef-item-top-section-content-inner">
                    <div class="qodef-item-info-top">
                        <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/parts/taxonomy-status', 'property', '', $params ); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="qodef-item-bottom-section">
            <div class="qodef-item-bottom-section-content">
                <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/parts/title', 'property', '', $params ); ?>
                <?php echo qodef_re_cpt_single_module_template_part( 'compare/templates/parts/price', 'property', '', $params ); ?>
            </div>
        </div>
    </div>
</div>
