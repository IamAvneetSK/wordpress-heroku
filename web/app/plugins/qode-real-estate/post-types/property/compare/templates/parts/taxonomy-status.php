<?php
$statuses = qodef_re_get_property_taxonomy('property-status', $id);
if(is_array($statuses) && !empty($statuses)) { ?>
    <span class="qodef-ci-statuses">
    <?php foreach($statuses as $status) { ?>
        <?php
        $status_style = '';
        $color = get_term_meta( $status->term_id, 'property_status_color', true );
        $background_color = get_term_meta( $status->term_id, 'property_status_background_color', true );
        $background_color_opacity = get_term_meta( $status->term_id, 'property_status_background_opacity', true );

        if( empty( $background_color_opacity ) ){
            $background_color_opacity = 1;
        }

        if( ! empty( $background_color ) ){
            $background_color = bridge_qode_rgba_color( $background_color, $background_color_opacity );
        } else{
            $background_color = 'transparent';
        }

        $status_style .= 'background-color: ' . esc_attr( $background_color ) . ';';

        if( ! empty( $color ) ){
            $status_style .= 'color: ' . esc_attr( $color ) . ';';
        }
        ?>
        <span class="qodef-ci-status" style="<?php echo esc_attr( $status_style ); ?>">
            <?php echo esc_html($status->name); ?>
        </span>
    <?php  } ?>
    </span>
<?php }