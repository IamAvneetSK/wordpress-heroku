<?php
    $map_style = bridge_qode_options()->getOptionValue('music_map_style');
    if($map_style != ''){
        $map_style = str_replace( '"', '``', $map_style);
    //var_dump($map_style);
        $args = array(
    		'address1' => $location,
        	'pin' => qode_music_get_attachment_id_from_url($pin),
        	'custom_map_style' => 'false',
        	'map_height' => '480',
        	'scroll_wheel' => 'false',
            'zoom'  => '16',
            'location_map' => 'yes',
            'snazzy_map_style' => 'yes',
            'snazzy_map_code'   => $map_style
        );
    }

    else{
        $args = array(
            'address1' => $location,
            'pin' => qode_music_get_attachment_id_from_url($pin),
            'custom_map_style' => 'false',
            'map_height' => '480',
            'scroll_wheel' => 'false',
            'zoom'  => '16',
            'location_map' => 'yes'
        );
    }

    if ($location != ''): 
?>
<div class="qode-event-item qode-event-info qode-event-map-holder">
    <div class="qode-event-item qode-event-info-content qode-event-map">
    	<?php echo bridge_qode_execute_shortcode('qode_google_map', $args); ?>
    </div>
</div>

<?php endif; ?>
