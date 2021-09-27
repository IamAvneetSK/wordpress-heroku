<?php

$costs_meta = get_post_meta(get_the_ID(), 'qodef_costs_meta', true);

if(is_array($costs_meta) && count($costs_meta)) { ?>
<div class="qodef-property-costs qodef-property-label-items-holder">
    <div class="qodef-property-cost-label qodef-property-label-style">
        <h5>
            <?php esc_html_e('Costs', 'qode-real-estate'); ?>
        </h5>
    </div>
    <div class="qodef-property-cost-items qodef-property-items-style clearfix">
        <div class="qode-grid-row">
            <?php foreach($costs_meta as $cost) { ?>
            <div class="qode-grid-col-6">
                <div class="qodef-costs qodef-label-items-item">
                    <span class="qodef-label-items-label">
                        <span class="qodef-label-icon">
                            <img src="<?php echo qodef_re_get_assets_icon_src('icon-' . $cost['icon'], 'png'); ?>" alt="<?php esc_attr_e('Costs Icon','qode-real-estate'); ?>"/>
                        </span>
                        <span class="qodef-label-text">
                            <?php echo esc_html($cost['label']) ?>
                        </span>
                    </span>
                    <span class="qodef-cost-value qodef-label-items-value">
                        <?php echo esc_html($cost['value']) ?>
                    </span>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>
