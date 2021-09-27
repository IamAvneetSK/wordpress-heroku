<?php
$title_tag    = ! empty( $title_tag ) ? $title_tag : 'h4';
?>
<<?php echo esc_attr( $title_tag ); ?> itemprop="name" class="qodef-pli-title entry-title">
<a itemprop="url" href="<?php echo get_permalink(); ?>" target="<?php echo esc_attr( "_self" ); ?>">
    <?php echo esc_html( get_the_title() ); ?>
</a>
</<?php echo esc_attr( $title_tag ); ?>>