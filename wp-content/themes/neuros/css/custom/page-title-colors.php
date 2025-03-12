<?php

// -------------------------------- //
// ------ Page Title Colors ------- //
// -------------------------------- //
$page_title_default_text_color = neuros_get_prepared_option('page_title_default_text_color', 'contrast_default_text_color', 'page_title_customize');
if ( !empty($page_title_default_text_color) ) {
    $neuros_custom_css .= '
        .page-title-container .breadcrumbs,
        .page-title-container .breadcrumbs a {
            color: ' . esc_attr($page_title_default_text_color) . ';
        }
    ';
}

$page_title_dark_text_color = neuros_get_prepared_option('page_title_dark_text_color', 'contrast_dark_text_color', 'page_title_customize');
if ( !empty($page_title_dark_text_color) ) {
    $neuros_custom_css .= '
        .page-title-wrapper,
        .body-container .page-title-wrapper a,
        .page-title-container .page-title-additional {
            color: ' . esc_attr($page_title_dark_text_color) . ';
        }
    ';
}

$page_title_light_text_color = neuros_get_prepared_option('page_title_light_text_color', 'contrast_light_text_color', 'page_title_customize');
if ( !empty($page_title_light_text_color) ) {
    $neuros_custom_css .= '        
        .breadcrumbs .delimiter {
            color: ' . esc_attr($page_title_light_text_color) . ';
        }
    ';
}

$page_title_accent_text_color = neuros_get_prepared_option('page_title_accent_text_color', 'contrast_accent_text_color', 'page_title_customize');
if ( !empty($top_bar_accent_text_color) ) {
    $neuros_custom_css .= '
        .page-title-container .breadcrumbs a:hover,
        .body-container .page-title-wrapper a:hover {
            color: ' . esc_attr($page_title_accent_text_color) . ';
        }
    ';
}

$page_title_border_color = neuros_get_prepared_option('page_title_border_color', 'contrast_border_color', 'page_title_customize');
if ( !empty($page_title_border_color) ) {
    $neuros_custom_css .= '';
}

$page_title_border_hover_color = neuros_get_prepared_option('page_title_border_hover_color', 'contrast_border_hover_color', 'page_title_customize');
if ( !empty($page_title_border_hover_color) ) {
    $neuros_custom_css .= '';
}

$page_title_background_color = neuros_get_prepared_option('page_title_background_color', 'contrast_background_color', 'page_title_customize');
if ( !empty($page_title_background_color) ) {
    $neuros_custom_css .= '
        .page-title-container {
            background-color: ' . esc_attr($page_title_background_color) . ';
        }
    ';
}

$page_title_background_alter_color = neuros_get_prepared_option('page_title_background_alter_color', 'page_top_background_color', 'page_title_customize');
if ( !empty($page_title_background_alter_color) ) {
    $neuros_custom_css .= '
        .breadcrumbs {
            background-color: ' . esc_attr($page_title_background_alter_color) . ';
        }
        .breadcrumbs-wrapper:before, 
        .breadcrumbs-wrapper:after {
            box-shadow: 0 20px 0 0 ' . esc_attr($page_title_background_alter_color) . ';
        }
    ';
}

$page_title_button_background_color = neuros_get_prepared_option('page_title_button_background_color', 'contrast_button_background_color', 'page_title_customize');
if ( !empty($page_title_button_background_color) ) {
    $neuros_custom_css .= '';
}

$page_title_overlay_color = neuros_get_prepared_option('page_title_overlay_color', '', 'page_title_overlay_status');
if ( !empty($page_title_overlay_color) ) {
    $neuros_custom_css .= '
        .page-title-bg {
            background-color: ' . esc_attr($page_title_overlay_color) . ';
        }
    ';
}

$page_title_button_border_color = neuros_get_prepared_option('page_title_button_border_color', 'standard_button_border_color', 'page_title_customize');
$page_title_button_border_color_add = neuros_get_prepared_option('page_title_button_border_color_add', 'standard_button_border_color_add', 'page_title_customize');
if( !empty($page_title_button_border_color) && !empty($page_title_button_border_color_add) ) {
    $neuros_custom_css .= '
        .breadcrumbs a:before {
            background: linear-gradient(var(--link-gradient-angle), ' . esc_attr($page_title_button_border_color) . ' var(--link-gradient-colorstop-1), ' . esc_attr($page_title_button_border_color_add) . ' var(--link-gradient-colorstop-2));
        }
    ';
} elseif ( !empty($page_title_button_border_color)) {
    $neuros_custom_css .= '
        .breadcrumbs a:before {
            background-color: ' . esc_attr($page_title_button_border_color) . ';
        }
    ';
}