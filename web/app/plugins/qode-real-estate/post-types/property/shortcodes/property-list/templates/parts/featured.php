<?php
$item_featured_value =  get_post_meta( get_the_ID(), 'qodef_property_is_featured_meta', true);
$item_featured = ! empty( $item_featured_value ) && $item_featured_value === 'yes' ? true: false;
if($item_featured) {
?>
<div class="qodef-item-featured">
    <i class="icon-weather-lightning"></i>
</div>
<?php }
