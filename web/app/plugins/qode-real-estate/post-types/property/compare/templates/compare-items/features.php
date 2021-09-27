<?php
$features = get_terms(array(
    'taxonomy'   =>'property-feature',
    'hide_empty' => false
));
?>

<?php foreach($features as $feature) { ?>
    <li class="qodef-re-info-holder">
        <div>
            <?php echo esc_html($feature->name); ?>
        </div>
        <?php foreach($added_properties as $property) { ?>
            <?php $active_features = qodef_re_get_property_taxonomy('property-feature', $property); ?>
            <div>
                <?php if(in_array($feature, $active_features)) { ?>
                    <i class="icon_check" aria-hidden="true"></i>
                <?php } else { ?>
                    <i class="icon_close" aria-hidden="true"></i>
                <?php } ?>
            </div>
        <?php } ?>
    </li>
<?php } ?>