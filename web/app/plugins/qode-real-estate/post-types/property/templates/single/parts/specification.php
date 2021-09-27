<?php
$specification_items = qodef_re_get_property_specification_items();
$additional_specification_items = qodef_re_get_property_additional_specification_items();
?>
<div class="qodef-property-specification qodef-property-label-items-holder">
    <div class="qodef-property-spec-label qodef-property-label-style">
        <h5 class="qodef-property-spec-title">
            <?php esc_html_e('Specification', 'qode-real-estate'); ?>
        </h5>
    </div>
    <div class="qodef-property-spec-items qodef-property-items-style clearfix">
        <div class="qodef-spec">
            <div class="qode-grid-row">
                <?php foreach($specification_items as $item) { ?>
                    <div class="qode-grid-col-6">
                        <div class="qodef-spec-item qodef-label-items-item">
                            <span class="qodef-spec-item-label qodef-label-items-label">
                                <span class="qodef-label-icon">
                                    <?php print bridge_qode_get_module_part($item['icon']); ?>
                                </span>
                                <span class="qodef-label-text">
                                    <?php echo esc_html($item['label']); ?>
                                </span>
                            </span>
                            <span class="qodef-spec-item-value qodef-label-items-value">
                                <?php echo esc_html($item['value']); ?>
                            </span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="qodef-additional-spec">
            <div class="qode-grid-row">
                <?php foreach($additional_specification_items as $item) { ?>
                    <div class="qode-grid-col-6">
                        <div class="qodef-spec-item qodef-label-items-item">
                            <span class="qodef-spec-item-label qodef-label-items-label">
                                <span class="qodef-label-icon">
                                    <?php print bridge_qode_get_module_part($item['icon']); ?>
                                </span>
                                    <span class="qodef-label-text">
                                    <?php echo esc_html($item['label']); ?>
                                </span>
                            </span>
                            <span class="qodef-spec-item-value qodef-label-items-value">
                                <?php echo esc_html($item['value']); ?>
                            </span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
