<div class="qodef-property-intro-slider-holder">
    <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/slider', 'property', $params['item_layout'], $params); ?>
</div>

<div class="qodef-property-intro-info-holder">
    <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/title', 'property', '', $params);?>
</div>

<div class="container">
    <div class="container_inner clearfix">
        <div class="<?php echo esc_attr( $sidebar_layout_class ); ?>">
            <div class="column1">
                <div class="column_inner">
                    <div class="qodef-property-single-outer">
                        <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/specification', 'property', '', $params); ?>
                        <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/leasing-terms', 'property', '', $params); ?>
                        <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/costs', 'property', '', $params); ?>
                        <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/features', 'property', '', $params); ?>
                        <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/map', 'property', '', $params); ?>
                        <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/video', 'property', '', $params); ?>
                        <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/description', 'property', '', $params); ?>
                        <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/virtual-tour', 'property', '', $params); ?>
                        <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/multi-unit', 'property', '', $params); ?>
                        <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/floor-plans', 'property', '', $params); ?>
                        <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/tags', 'property', '', $params); ?>
                        <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/related-properties', 'property', '', $params); ?>
                        <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/reviews-list', 'property', '', $params); ?>
                    </div>
                </div>
            </div>
            <?php if ($sidebar_layout !== 'default' && $sidebar_layout !== '') { ?>
                <div class="column2">
                    <div class="column_inner">
                        <aside class="sidebar qodef-property-single-sidebar">
                            <?php qodef_re_single_property_sidebar(); ?>
                        </aside>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>