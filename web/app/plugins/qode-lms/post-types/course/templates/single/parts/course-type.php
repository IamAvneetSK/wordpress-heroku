<?php
$course_free  = get_post_meta( get_the_ID(), 'qode_course_free_meta', true );
$course_class = $course_free === 'yes' ? 'qode-free-course' : '';
?>
<span class="qode-course-single-type <?php echo esc_attr( $course_class ); ?>">
  <?php if ( $course_free === 'yes' ) {
	  esc_html_e( 'Free', 'qode-lms' );
  } else {
  	    if( function_exists( 'get_woocommerce_currency_symbol' ) ){
	        echo get_woocommerce_currency_symbol() . qode_lms_calculate_course_price( get_the_ID() );
        } else {
	        echo qode_lms_calculate_course_price( get_the_ID() );
        }

  }
  ?>
</span>
