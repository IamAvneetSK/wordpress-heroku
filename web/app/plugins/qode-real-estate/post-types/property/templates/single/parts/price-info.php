<?php
$price = qodef_re_get_real_estate_item_price();
?>
<div class="qodef-property-price-info-holder">
    <div class="qodef-property-price-info-outer">
        <div class="qodef-property-price-info-inner">
			<div class="qodef-property-price">
			    <span>
			        <?php echo qodef_re_get_real_estate_price_html($price); ?>
			    </span>
			</div>
		</div>
	</div>
</div>