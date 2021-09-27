<div class="qodef-container">
    <div class="qodef-container-inner clearfix">
        <div class="qode-grid-row">
            <div class="qodef-grid-col-12">
                <div class="qodef-re-author-holder">
                    <div class="qodef-re-author-info-section clearfix">
                        <div class="qodef-author-image">
                            <?php echo qodef_re_get_cpt_single_module_template_part( 'templates/author/parts/image', 'property', '', $params ); ?>
                        </div>
                        <div class="qodef-author-info">
                            <?php echo qodef_re_get_cpt_single_module_template_part( 'templates/author/parts/title', 'property', $role, $params ); ?>
                            <?php echo qodef_re_get_cpt_single_module_template_part( 'templates/author/parts/description', 'property', $role, $params ); ?>
                            <?php echo qodef_re_get_cpt_single_module_template_part( 'templates/author/parts/address', 'property', $role, $params ); ?>
                            <?php echo qodef_re_get_cpt_single_module_template_part( 'templates/author/parts/phone', 'property', $role, $params ); ?>
                            <?php echo qodef_re_get_cpt_single_module_template_part( 'templates/author/parts/email', 'property', $role, $params ); ?>
                            <?php echo qodef_re_get_cpt_single_module_template_part( 'templates/author/parts/social', 'property', $role, $params ); ?>
                        </div>
                    </div>
                    <div class="qodef-re-author-properties-section">
                        <h1 class="qodef-re-properties-title">
                            <?php esc_html_e('Property List', 'qode-real-estate'); ?>
                        </h1>
                        <?php qodef_re_get_archive_property_list('', '', $author->ID, 'no', 'no', 3); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>