<?php  if(bridge_qode_options()->getOptionValue( 'album_comments' ) == 'yes') : ?>
    <?php comments_template('', true); ?>
<?php endif;  ?>
