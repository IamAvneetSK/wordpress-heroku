<?php
$property_id = get_post_meta(get_the_ID(), 'qodef_property_id_meta', true);
$title_tag    = ! empty( $title_tag ) ? $title_tag : 'h4';
?>
<<?php echo esc_attr( $title_tag ); ?> class="qodef-property-id">
   <?php echo esc_html($property_id); ?>
</<?php echo esc_attr( $title_tag ); ?>>
