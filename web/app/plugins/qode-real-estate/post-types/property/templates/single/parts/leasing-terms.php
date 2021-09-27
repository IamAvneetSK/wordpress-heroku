<?php

$leasing_terms_meta = get_post_meta(get_the_ID(), 'qodef_leasing_terms_meta', true);

if(is_array($leasing_terms_meta) && count($leasing_terms_meta)) { ?>
<div class="qodef-property-leasing-terms qodef-property-label-items-holder">
    <div class="qodef-property-leasing-label qodef-property-label-style">
        <h5>
            <?php esc_html_e('Leasing Terms', 'qode-real-estate'); ?>
        </h5>
    </div>
    <div class="qodef-property-spec-items qodef-property-items-style clearfix">
        <div class="qode-grid-row">
            <?php foreach($leasing_terms_meta as $leasing_term) { ?>
            <div class="qode-grid-col-6">
                <div class="qodef-leasing-term qodef-label-items-item">
                    <span class="qodef-label-items-label">
                        <span class="qodef-label-icon">
                            <img src="<?php echo qodef_re_get_assets_icon_src('icon-' . $leasing_term['icon'], 'png'); ?>" alt="<?php esc_attr_e('Leasing Icon','qode-real-estate'); ?>"/>
                        </span>
                        <span class="qodef-label-text">
                            <?php echo esc_html($leasing_term['label']) ?>
                        </span>
                    </span>
                    <span class="qodef-leasing-value qodef-label-items-value">
                        <?php echo esc_html($leasing_term['value']) ?>
                    </span>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>
