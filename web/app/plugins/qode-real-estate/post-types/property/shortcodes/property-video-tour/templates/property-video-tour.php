<?php

$info = array();

$property_title = get_the_title( $id );
$info['property_title'] = $property_title;

$neighbourhoods = qodef_re_get_property_taxonomy('property-neighborhood', $id);
if( ! empty( $neighbourhoods ) ) {
    $info['neighbourhood_name'] = $neighbourhoods[0]->name;
}

$cities = qodef_re_get_property_taxonomy('property-city', $id);
if( ! empty( $cities ) ) {
    $info['city_name'] = $cities[0]->name;
}

?>

<div class="qodef-property-video-tour">
    <div class="qodef-property-video-tour-inner">
        <div class="qodef-pvt-video-holder">
            <?php echo bridge_qode_get_module_part( $video_tour_src ); ?>
        </div>
        <div class="qodef-pvt-info-holder">
            <span class="qodef-pvt-info">
                <?php echo implode(',', $info) ?>
            </span>
        </div>
    </div>
</div>