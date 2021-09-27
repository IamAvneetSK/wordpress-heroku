<?php

foreach (glob(QODE_RESTAURANT_ABS_PATH . '/modules/widgets/*/load.php') as $widget_load) {
    include_once $widget_load;
}