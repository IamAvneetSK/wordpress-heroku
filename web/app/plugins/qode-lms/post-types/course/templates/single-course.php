<?php

get_header();

bridge_qode_get_title();

do_action( 'qode_before_main_content' );

qode_lms_get_single_course();

get_footer();