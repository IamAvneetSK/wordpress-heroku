<div class="qodef-item-top-section">
    <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'parts/image', $params['type'], $params); ?>
    <div class="qodef-item-top-section-content">
        <div class="qodef-item-top-section-content-inner">
            <div class="qodef-item-info-top">
                <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'parts/featured', '', $params); ?>
                <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'parts/taxonomy', 'status', $params); ?>
            </div>
        </div>
    </div>
</div>
<div class="qodef-item-bottom-section">
    <div class="qodef-item-bottom-section-content">
        <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'parts/price', '', $params); ?>
        <div class="qodef-item-id-title">
            <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'parts/id', '', $params); ?>
            <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'parts/title', '', $params); ?>
        </div>
        <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'parts/address', '', $params); ?>
        <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'parts/features', '', $params); ?>
        <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'parts/compare', '', $params); ?>
    </div>
</div>
