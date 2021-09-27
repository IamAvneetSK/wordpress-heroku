<li class="qodef-re-info-holder">
    <div>
        <?php esc_html_e('Floor', 'qode-real-estate'); ?>
    </div>
    <?php foreach($added_properties as $property) { ?>
        <?php $value = get_post_meta($property, 'qodef_property_floor_meta', true); ?>
        <div>
            <?php echo esc_html($value); ?>
        </div>
    <?php } ?>
</li>