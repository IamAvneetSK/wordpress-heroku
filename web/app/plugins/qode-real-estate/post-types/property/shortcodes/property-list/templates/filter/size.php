<?php
$size_label = bridge_qode_options()->getOptionValue( 'property_size_label' );
?>
<div class="qodef-filter-section qodef-filter-section-4 qodef-section-size">
    <div class="qodef-filter-size-holder" data-size-min="" data-size-max="">
        <label><?php esc_html_e('Size', 'qode-real-estate') ?></label>
        <div class="qodef-inputs-holder clearfix">
            <span class="qodef-input-min-size">
                <input type="text" class="qodef-min-size" name="qodef-min-size" placeholder="<?php esc_attr_e('Min', 'qode-real-estate') ?>" value="<?php echo esc_attr($property_min_size); ?>" />
                <span class="qodef-sufix qodef-min-sufix"><?php esc_html_e($size_label); ?></span>
            </span>
            <span class="qodef-input-max-size">
                <input type="text" class="qodef-max-size" name="qodef-max-size" placeholder="<?php esc_attr_e('Max', 'qode-real-estate') ?>" value="<?php echo esc_attr($property_max_size); ?>" />
                <span class="qodef-sufix qodef-max-sufix"><?php esc_html_e($size_label); ?></span>
            </span>
        </div>
    </div>
</div>