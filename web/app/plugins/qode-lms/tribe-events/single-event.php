<?php

/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if(!defined('ABSPATH')) {
	die('-1');
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

global $post;

$event_id = get_the_ID();

$price_class = '';
if(tribe_get_cost(null, true) === 'Free') {
	$price_class = 'qode-free';
}
?>

<div id="tribe-events-content" class="tribe-events-single qode-tribe-events-single">
	<!-- Notices -->
	<?php tribe_the_notices() ?>

	<div class="qode-events-single-main-info clearfix">
		<div class="qode-events-single-date-holder">
			<div class="qode-events-single-date-inner">
				<span class="qode-events-single-date-day">
					<?php echo tribe_get_start_date(null, true, 'd'); ?>
				</span>

				<span class="qode-events-single-date-month">
					<?php echo tribe_get_start_date(null, true, 'M'); ?>
				</span>
			</div>
		</div>
		<div class="qode-events-single-title-holder">
			<h1 class="qode-events-single-title"><?php the_title(); ?></h1>
			<div class="qode-events-single-date">
				<span class="qode-events-single-info-icon">
					<span class="dripicons-clock"></span>
				</span>
				<?php echo tribe_events_event_schedule_details($event_id); ?>
			</div>
			<div class="qode-events-single-location">
				<span class="qode-events-single-info-icon">
					<span class="dripicons-location"></span>
				</span>
				<?php echo tribe_get_address(); ?>
			</div>
			<?php if(tribe_get_cost($event_id)) { ?>
			<div class="qode-events-single-cost <?php echo  esc_html($price_class)?>">
				<?php echo tribe_get_cost(null, true); ?>
			</div>
			<?php } ?>
		</div>
	</div>

	<div class="qode-events-single-main-content">
		<div class="qode-grid-row qode-events-single-media">
			<div class="qode-events-single-featured-image qode-grid-col-8">
				<?php echo tribe_event_featured_image($event_id, 'full', false); ?>
			</div>
			<div class="qode-events-single-map qode-grid-col-4">
				<?php tribe_get_template_part('modules/meta/map'); ?>
			</div>
		</div>
		<div class="qode-events-single-content-holder">
			<?php do_action('tribe_events_single_event_before_the_content') ?>

			<?php the_content(); ?>

			<?php //do_action('tribe_events_single_event_after_the_content') ?>
		</div>
	</div>

	<div class="qode-events-single-meta">
		<?php do_action('tribe_events_single_event_before_the_meta') ?>
		<h3><?php esc_html_e('Event Details', 'qode-lms'); ?></h3>

		<div class="qode-events-single-meta-holder qode-grid-row">
			<div class="qode-grid-col-4">
				<div class="qode-events-single-meta-item">
					<span class="qode-events-single-meta-icon">
						<span class="dripicons-calendar"></span>
					</span>
					<span class="qode-events-single-meta-label"><?php esc_html_e('Date:', 'qode-lms'); ?></span>
					<span class="qode-events-single-meta-value">
						<?php echo tribe_events_event_schedule_details(); ?>
					</span>
				</div>

				<div class="qode-events-single-meta-item">
					<span class="qode-events-single-meta-icon">
						<span class="dripicons-clock"></span>
					</span>
					<span class="qode-events-single-meta-label"><?php esc_html_e('Time:', 'qode-lms'); ?></span>
					<span class="qode-events-single-meta-value">
						<?php echo tribe_get_start_time(); ?> - <?php echo tribe_get_end_time(); ?>
					</span>
				</div>

				<?php if(tribe_has_venue()) : ?>
					<div class="qode-events-single-meta-item">
						<span class="qode-events-single-meta-icon">
							<span class="dripicons-copy"></span>
						</span>
						<span class="qode-events-single-meta-label"><?php esc_html_e('Venue:', 'qode-lms'); ?></span>
						<span class="qode-events-single-meta-value">
							<?php echo esc_html(tribe_get_venue()); ?>
						</span>
					</div>

					<?php if(tribe_address_exists()) : ?>
						<div class="qode-events-single-meta-item">
							<span class="qode-events-single-meta-icon">
								<span class="dripicons-location"></span>
							</span>
							<span class="qode-events-single-meta-label"><?php esc_html_e('Address:', 'qode-lms'); ?></span>
							<span class="qode-events-single-meta-value">
								<?php echo tribe_get_address(); ?>
							</span>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>

			<div class="qode-grid-col-4">
				<?php if(tribe_has_organizer()) : ?>
                    <?php 
                        $organizer_ids = tribe_get_organizer_ids(); 
                        foreach ( $organizer_ids as $organizer ) {
                    ?>
					<div class="qode-events-single-meta-item">
						<span class="qode-events-single-meta-icon">
							<span class="dripicons-user"></span>
						</span>
                        
						<span class="qode-events-single-meta-label"><?php esc_html_e('Organizer Name:', 'qode-lms'); ?></span>
						<span class="qode-events-single-meta-value">
                            
                        <?php 
                                echo tribe_get_organizer_link( $organizer );
                        ?>
                            
						</span>
					</div>
                    <?php
                        }
                    ?>
				<?php endif; ?>

				<?php if(tribe_get_organizer_phone()) : ?>
					<div class="qode-events-single-meta-item">
						<span class="qode-events-single-meta-icon">
							<span class="dripicons-phone"></span>
						</span>
						<span class="qode-events-single-meta-label"><?php esc_html_e('Phone:', 'qode-lms'); ?></span>
						<span class="qode-events-single-meta-value">
							<?php echo esc_html(tribe_get_organizer_phone()); ?>
						</span>
					</div>
				<?php endif; ?>

				<?php if(tribe_get_organizer_email()) : ?>
					<div class="qode-events-single-meta-item">
						<span class="qode-events-single-meta-icon">
							<span class="dripicons-mail"></span>
						</span>
						<span class="qode-events-single-meta-label"><?php esc_html_e('Email:', 'qode-lms'); ?></span>
						<span class="qode-events-single-meta-value">
							<a href="mailto: <?php echo tribe_get_organizer_email(); ?>">
								<?php echo esc_html(tribe_get_organizer_email()); ?>
							</a>
						</span>
					</div>
				<?php endif; ?>

				<?php if(tribe_get_organizer_website_link()) : ?>
					<div class="qode-events-single-meta-item">
						<span class="qode-events-single-meta-icon">
							<span class="dripicons-web"></span>
						</span>
						<span class="qode-events-single-meta-label"><?php esc_html_e('Website:', 'qode-lms'); ?></span>
						<span class="qode-events-single-meta-value">
							<a target="_blank" href="<?php echo tribe_get_organizer_website_url(); ?>">
								<?php echo tribe_get_organizer_website_url(); ?>
							</a>
						</span>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="qode-events-single-navigation-holder clearfix">
			<div class="qode-events-single-prev-event">
				<?php
				$prev_event = Tribe__Events__Main::instance()->get_closest_event($post, 'previous');
				if($prev_event !== null) {
				?>
				<a class="qode-events-nav-image" href="<?php echo esc_attr(tribe_get_event_link($prev_event)); ?>" target="_self" itemprop="url">
					<?php echo get_the_post_thumbnail($prev_event, 'thumbnail'); ?>
				</a>
				<span class="qode-events-nav-text">
                    <h4 class="qode-events-nav-text-title"><?php tribe_the_prev_event_link('%title%'); ?></h4>
                    <span class="qode-events-nav-label"><?php esc_html_e('Previous Post' , 'qode-lms')?></span>
				</span>
				<?php } ?>

			</div>

			<div class="qode-events-single-next-event">
				<?php
				$next_event = Tribe__Events__Main::instance()->get_closest_event($post, 'next');
				if($next_event !== null) {
				?>

				<span class="qode-events-nav-text">
                    <h4 class="qode-events-nav-text-title"><?php tribe_the_next_event_link('%title%'); ?></h4>
                    <span class="qode-events-nav-label"><?php esc_html_e('Next Post' , 'qode-lms')?></span>
				</span>
				<a class="qode-events-nav-image" href="<?php echo esc_attr(tribe_get_event_link($next_event)); ?>" target="_self" itemprop="url">
					<?php echo get_the_post_thumbnail($next_event, 'thumbnail'); ?>
				</a>
				<?php } ?>

			</div>
		</div>

		<?php do_action('tribe_events_single_event_after_the_meta'); ?>
	</div>
</div>
