<div class="qodef-item-top-section">
    <?php echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-list', 'parts/image', $params['type'], $params ); ?>
    <div class="qodef-item-top-section-content">
        <div class="qodef-item-top-section-content-inner">
            <div class="qodef-item-info-top">
                <?php echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-list', 'parts/taxonomy', 'status', $params ); ?>
                <?php echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-list', 'parts/featured', '', $params ); ?>
            </div>
            <div class="qodef-item-info-bottom">
                <div class="qodef-item-info-bottom-left">
                    <?php echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-list', 'parts/title', '', $params ); ?>
                    <?php echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-list', 'parts/address', '', $params ); ?>
                </div>
                <div class="qodef-item-info-bottom-right">
                    <?php echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-list', 'parts/price', '', $params ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
