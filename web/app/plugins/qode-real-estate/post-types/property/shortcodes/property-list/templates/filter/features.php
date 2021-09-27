<?php
$feature_set = isset($params['property_features']) && $params['property_features'] !== '';
$hide_active_filter = isset($params['hide_active_filter']) && $params['hide_active_filter'] === 'yes';
$features = qodef_re_get_taxonomy_list('property-feature');
$property_features = explode(',', $property_features);
?>
<?php if(!$feature_set || ($feature_set && !$hide_active_filter)) { ?>
<div class="qodef-filter-section qodef-filter-section-12 qodef-section-features">
    <div class="qodef-filter-features-holder">
        <div class="qodef-filter-features-wrapper clearfix">
            <?php foreach ($features as $key => $feature) { ?>
                <div class="qodef-feature-item">
                    <input type="checkbox" <?php echo !empty($property_features) && in_array($key, $property_features) ? 'checked' : ''; ?> class="qodef-feature-cb" data-id="<?php echo esc_attr($key); ?>" id="qodef-feature-<?php echo esc_attr($key); ?>" name="qodef-features[]" value="" />
                    <label class="qodef-checkbox-label" for="qodef-feature-<?php echo esc_attr($key); ?>">
                        <span class="qodef-label-view"></span>
                        <span class="qodef-label-text">
                            <?php echo esc_html($feature); ?>
                        </span>
                    </label>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>