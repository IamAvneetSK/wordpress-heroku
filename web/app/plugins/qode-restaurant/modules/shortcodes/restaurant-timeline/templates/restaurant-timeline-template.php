<div class="qode-restaurant-timeline">
    <div class="qode-restaurant-timeline-inner">
        <?php if(!empty($restaurant_items)) {
			$count = 0;
            ?>
            <?php foreach($restaurant_items as $restaurant_item):?>
                <div class="qode-rt-item">
                    <div class="qode-rt-item-inner">
                        <div class="qode-rt-item-title">
                           <h2><?php echo esc_html($restaurant_item['title']);?></h2>
                        </div>
                        <div class="qode-rt-item-line"></div>
                        <div class="qode-rt-item-image">
							<?php echo wp_get_attachment_image($restaurant_item['image'], 'full'); ?>
                        </div>
                        <div class="qode-rt-item-text">
                            <p>  <?php echo esc_html($restaurant_item['text']);?></p>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php }?>
    </div>
</div>