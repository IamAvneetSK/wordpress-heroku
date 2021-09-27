<?php
    $virtual_tour = get_post_meta(get_the_ID(), 'qodef_property_virtual_tour_meta', true);

    if( ! empty( $virtual_tour ) ) { ?>
    <div class="qodef-property-virtual-tour qodef-property-label-items-holder">
        <div class="qodef-property-virtual-tour-label qodef-property-label-style">
            <h5>
                <?php esc_html_e('Virtual Tour', 'qode-real-estate'); ?>
            </h5>
        </div>
        <div class="qodef-property-virtual-tour-items qodef-property-items-style clearfix">
            <?php print bridge_qode_get_module_part($virtual_tour); ?>
        </div>
    </div>
<?php } ?>