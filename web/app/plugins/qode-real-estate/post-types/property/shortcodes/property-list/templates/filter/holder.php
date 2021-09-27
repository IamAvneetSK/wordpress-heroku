<?php if (isset($params['enable_filter']) && $params['enable_filter'] === 'yes') { ?>
    <div class="qodef-property-list-filter-part">
        <div class="qodef-filter-row qodef-filter-section-st">
            <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'filter/type', '', $params); ?>
            <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'filter/status', '', $params); ?>
        </div>
        <div class="qodef-filter-row qodef-filter-section-csp">
            <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'filter/price-range', '', $params); ?>
            <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'filter/city', '', $params); ?>
            <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'filter/size', '', $params); ?>
        </div>
        <div class="qodef-filter-row qodef-filter-section-sf">
            <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'filter/specification', '', $params); ?>
        </div>
        <div class="qodef-filter-row qodef-filter-section-sf">
            <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'filter/features', '', $params); ?>
        </div>
        <div class="qodef-filter-row qodef-filter-section-action clearfix">
            <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'filter/button', '', $params); ?>
        </div>
    </div>
    <?php echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-list', 'filter/loading-element'); ?>
<?php } ?>