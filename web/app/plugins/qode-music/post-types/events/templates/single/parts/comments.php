<?php  if(bridge_qode_options()->getOptionValue( 'event_comments' ) == 'yes') : ?>
    <?php comments_template('', true); ?>
<?php endif;  ?>
