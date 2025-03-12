<?php
/*
 * Created by Artureanec
*/

$sidebar_args             = neuros_get_sidebar_args();
$neuros_sidebar_name      = $sidebar_args['sidebar_name'];
$neuros_sidebar_position  = $sidebar_args['sidebar_position'];
$additional_class         = $sidebar_args['additional_class'];

if ($neuros_sidebar_position !== 'none' && is_active_sidebar($neuros_sidebar_name) ) {
    echo '<div class="sidebar sidebar-position-' . esc_attr($neuros_sidebar_position) . esc_attr($additional_class) . '">';
        dynamic_sidebar($neuros_sidebar_name);
        echo '<div class="shop-hidden-sidebar-close"></div>';
    echo "</div>";
    if ( $additional_class == ' simple-sidebar' ) {
        echo '<div class="simple-sidebar-trigger"></div>';
    }
}