<?php
$features = qodef_re_get_property_features();
if(is_array($features)) { ?>
    <div class="qodef-property-features qodef-property-label-items-holder">
        <div class="qodef-property-features-label qodef-property-label-style">
            <h5>
                <?php esc_html_e('Features', 'qode-real-estate'); ?>
            </h5>
        </div>
        <div class="qodef-property-feature-items qodef-property-items-style clearfix">
            <div class="qode-grid-row">
                <?php foreach($features as $feature) { ?>
                <div class="qode-grid-col-4">
                    <div class="qodef-feature qodef-feature-<?php echo esc_attr($feature['status']) ?>">
                        <i class="qodef-feature-icon icon_check_alt2" aria-hidden="true"></i>
                        <span class="qodef-feature-name">
                            <?php echo esc_html($feature['name']) ?>
                        </span>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php }