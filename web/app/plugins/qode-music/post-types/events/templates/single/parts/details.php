<?php 
$event_types   = wp_get_post_terms(get_the_ID(), 'qode-event-type');
$event_types_names = array();
if (($date != '') || ($time != '') || ($location != '') || ($website != '') || ($organized_by != '') || (is_array($event_types) && count($event_types))): ?>
<div class="qode-event-item qode-event-info qode-event-details-holder">
    <h2 class='qode-event-section-title'><?php esc_html_e('Details', 'qode-music'); ?></h2>
    <div class="qode-event-item qode-event-info-content qode-event-details">
        <?php if (($date != '') || ($time != '')): ?>
   		<div class="qode-event-item qode-event-details-time">
            <p>
                <span><?php esc_html_e('Time:', 'qode-music') ?></span>
                <span><?php print date_i18n( 'F d, Y' , strtotime( $date ) ).' '.$time ?></span>
            </p>
        </div>
        <?php endif; ?>
        <?php if ($location != ''): ?>
        <div class="qode-event-item qode-event-details-location">
            <p>
                <span><?php esc_html_e('Location:', 'qode-music') ?></span>
                <span><?php echo esc_attr($location); ?></span>
            </p>
        </div>
        <?php endif; ?>
        <?php if ($website != ''): ?>
        <div class="qode-event-item qode-event-details-website">
            <p>
                <span><?php esc_html_e('Website:', 'qode-music') ?></span>
                <span><a href="<?php echo esc_url($website); ?>" target = '_blank'><?php echo esc_url($website); ?></a></span>
            </p>
        </div>
        <?php endif; ?>
        <?php
            if(is_array($event_types) && count($event_types)) : ?>
        <div class="qode-event-item qode-event-details-event-type">
            <p>
                <span><?php esc_html_e('Event Type:', 'qode-music') ?></span>
                <span><?php
                        foreach($event_types as $event_type) {
                            $event_types_names[] = $event_type->name;
                        }
                        echo esc_html(implode(', ', $event_types_names)); 
                    ?>
                </span>
            </p>
        </div>
        <?php endif; ?>
        <?php if ($organized_by != ''): ?>
        <div class="qode-event-item qode-event-details-organized-by">
            <p>
                <span><?php esc_html_e('Organized By:', 'qode-music') ?></span>
                <span><?php echo esc_attr($organized_by); ?></span>
            </p>
        </div>
        <?php endif; ?>
	</div>
</div>

<?php endif; ?>