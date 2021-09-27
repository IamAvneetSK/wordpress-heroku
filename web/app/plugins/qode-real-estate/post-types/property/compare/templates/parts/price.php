<?php
$price = qodef_re_get_real_estate_item_price($id);
?>
<span class="qodef-ci-price">
   <?php echo qodef_re_get_real_estate_price_html($price, $id); ?>
</span>
