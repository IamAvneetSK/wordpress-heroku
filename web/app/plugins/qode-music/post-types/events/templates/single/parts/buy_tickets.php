<?php 
  if($tickets_status == 'available'){
                        
    $button_params = array( 
      'text'         => esc_html__( 'buy tickets','qode-music' ),
      'custom_class' => 'qode-event-buy-tickets-button',
      'link'         => $link,
      'target'       => $target,
      'type'         => 'solid'
    );

    //echo qode_execute_shortcode('button', $button_params);
    echo bridge_core_get_button_html($button_params);
    }
?>