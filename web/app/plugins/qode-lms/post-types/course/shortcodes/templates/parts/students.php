<?php
$students        = get_post_meta( get_the_ID(), 'qode_course_users_attended', true );
$students_number = '';
if( is_array($students) ){
    $students_number = count( $students );
}
?>
<div class="qode-students-number-holder">
	<span aria-hidden="true" class="dripicons-user qode-student-icon"></span>
	<span class="qode-student-number">
    <?php echo esc_html( $students_number ); ?>
    </span>
</div>
