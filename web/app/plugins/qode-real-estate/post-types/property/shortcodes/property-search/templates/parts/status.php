<?php
$status_enabled = isset($enable_status) && $enable_status === 'yes';
$statuses = qodef_re_get_taxonomy_list('property-status');
?>
<?php if($status_enabled) { ?>
    <div class="qodef-search-bottom-part qodef-search-status-section">
        <select id="qodef-search-status" name="qodef-search-status">
            <option value=""><?php esc_html_e('All Statuses', 'qode-real-estate') ?></option>
            <?php foreach($statuses as $key => $status) { ?>
                <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($status); ?></option>
            <?php } ?>
        </select>
    </div>
<?php } ?>