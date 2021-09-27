<?php
$status_set = isset($params['property_status']) && $params['property_status'] !== '';
$hide_active_filter = isset($params['hide_active_filter']) && $params['hide_active_filter'] === 'yes';
$statuses = qodef_re_get_taxonomy_list('property-status');
?>
<?php if(!$status_set || ($status_set && !$hide_active_filter)) { ?>
<div class="qodef-filter-section qodef-filter-section-3 qodef-section-status">
    <div class="qodef-filter-status-holder" data-default-status="<?php echo esc_attr($params['property_status']); ?>" data-status="<?php echo esc_attr($params['property_status']); ?>">
        <select class="qodef-filter-statuses">
            <option value=""><?php esc_html_e('All Statuses', 'qode-real-estate') ?></option>
            <?php foreach($statuses as $key => $status) { ?>
                <option <?php echo esc_attr($params['property_status']) == $key ? 'selected' : ''; ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($status); ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<?php } ?>