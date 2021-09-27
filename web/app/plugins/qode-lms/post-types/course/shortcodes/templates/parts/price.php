<?php
$price = qode_lms_calculate_course_price( get_the_ID() );
?>
<div class="qode-ci-price-holder">
	<?php if ( $price == 0 ) { ?>
		<span class="qode-ci-price-free">
        <?php esc_html_e( 'Free', 'qode-lms' ); ?>
      </span>
	<?php } else { ?>
		<span class="qode-ci-price-value">
          <?php
            if( function_exists( 'get_woocommerce_currency_symbol' ) ){
            	echo get_woocommerce_currency_symbol() . esc_html( $price );
            } else {
	            echo esc_html( $price );
            }
          ?>
      </span>
	<?php } ?>
</div>
