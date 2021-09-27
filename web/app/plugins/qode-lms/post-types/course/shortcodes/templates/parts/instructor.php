<?php
$instructor = get_post_meta( get_the_ID(), 'qode_course_instructor_meta', true );
?>
<a itemprop="url" href="<?php echo get_permalink( $instructor ); ?>" target="_self">
    <span class="qode-instructor-image">
        <?php echo get_the_post_thumbnail( $instructor, array( 80, 80 ) ); ?>
    </span>
	<span class="qode-instructor-name">
        <?php echo get_the_title( $instructor ); ?>
    </span>
</a>
