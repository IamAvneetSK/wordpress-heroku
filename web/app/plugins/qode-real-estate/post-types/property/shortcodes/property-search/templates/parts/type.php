<?php
if(isset($enable_type) && $enable_type === 'yes') {
    $property_list_params = array(
        'number_of_columns'         => '6',
        'skin'                      => $skin,
        'space_between_items'       => 'normal',
        'used_for_search'           => true
    );
?>
<div class="qodef-search-top-part qodef-search-type-section">
    <input type="hidden" id="qodef-search-type" name="qodef-search-type"/>
    <?php echo bridge_qode_execute_shortcode('qodef_property_type_list', $property_list_params); ?>
</div>
<?php } ?>