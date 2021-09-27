<div class="qode-event-content qode-events<?php echo esc_attr(get_the_ID()) ?>" <?php qode_music_inline_style($border_color_style); ?> >
	<div class="qode-event-date-holder">
		<?php  if (!empty($date)) { ?>
			<div class="qode-event-date-holder-left" <?php qode_music_inline_style($text_color_style); ?>>
                            <span class="qode-event-day-number-holder" <?php qode_music_inline_style($text_color_style); ?>>
                                <?php echo date( 'd' , strtotime( $date ) ); ?>
                            </span>
			</div>
			<div class="qode-event-date-holder-right">
                            <span class="qode-event-day-holder">
                                <?php echo date( 'M' , strtotime( $date ) ); ?>
                            </span>
                            <span class="qode-event-month-holder">
                                <?php echo date( 'D' , strtotime( $date ) ); ?>
                            </span>
			</div>
		<?php }  ?>


	</div>
	<div class="qode-event-title-holder">
		<<?php echo $title_tag ?> class="qode-event-title">
		<a href="<?php echo esc_url(get_permalink(get_the_ID())) ?>" target="_self" <?php qode_music_inline_style($text_color_style); ?>>
			<?php echo esc_attr($title); ?>
		</a>
        </<?php echo $title_tag ?>>
    </div>
    <div class="qode-event-buy-tickets-holder">
        <?php

        if($tickets_status == 'available'){ ?>
			<a href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>" class="qode-event-buy-tickets-button" <?php qode_music_inline_style($text_color_style); ?>>
                <span><?php echo esc_html__( 'buy tickets','qode-music' ); ?></span>
            </a>
        <?php
        }
        else if($tickets_status == 'sold')
        {
        ?>
            <span class="qode-event-sold-out-holder">
            <?php  echo esc_html__( 'sold out!','qode-music' ); ?>
            </span>
        <?php
        }
        else {
        ?>
            <span class="qode-event-sold-out-holder" <?php qode_music_inline_style($text_color_style); ?>>
            <?php  echo esc_html__( 'free!','qode-music' ); ?>
            </span>
        <?php
        }
        ?>
    </div>
</div>