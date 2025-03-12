<?php

// ---------------------------- //
// ------ 404 Error Page ------ //
// ---------------------------- //

$error_text_color = !empty(neuros_get_theme_mod('error_text_color')) ? neuros_get_theme_mod('error_text_color') : neuros_get_theme_mod('standard_contrast_text_color');
$error_text_hover_color = !empty(neuros_get_theme_mod('error_text_hover_color')) ? neuros_get_theme_mod('error_text_hover_color') : neuros_get_theme_mod('contrast_accent_text_color');

if(!empty($error_text_color)) {
    $neuros_custom_css .= '
        .error-404-container .error-404-info-text,
        .error-404-container .error-404-title,
        .error-404-container .wrapper-socials a {
            color: ' . esc_attr($error_text_color) . ';
        }
        .error-404-container .error-404-text {
            -webkit-text-stroke: 1px ' . esc_attr($error_text_color) . ';
            text-stroke: 1px ' . esc_attr($error_text_color) . ';
        }
    ';
}
if(!empty($error_text_hover_color)) {
    $neuros_custom_css .= '
        .error-404-container .wrapper-socials a:hover {
            color: ' . esc_attr($error_text_hover_color) . ';
        }
    ';
}

$error_background_color     = neuros_get_prepared_option('error_background_color', 'standard_background_alter_color', 'error_background_customize');
$error_background_position  = neuros_get_prepared_option('error_background_position', '', 'error_background_customize');
$error_background_repeat    = neuros_get_prepared_option('error_background_repeat', '', 'error_background_customize');
$error_background_size      = neuros_get_prepared_option('error_background_size', '', 'error_background_customize');
$error_background_image     = neuros_get_prepared_img_url('error_background_image');
if ( !empty($error_background_color) ) {
    $neuros_custom_css .= '
        .error-404-wrapper {
            background-color: ' . esc_attr($error_background_color) . ';
        }
    ';
}
if ( !empty($error_background_position) || !empty($error_background_repeat) || !empty($error_background_size) || !empty($error_background_image) ) {
    $neuros_custom_css .= '
        .error-404-container {' .
            ( !empty($error_background_position) ? 'background-position: ' . esc_attr($error_background_position) . ';' : '' ) .
            ( !empty($error_background_repeat) ? 'background-repeat: ' . esc_attr($error_background_repeat) . ';' : '' ) .
            ( !empty($error_background_size) ? '-webkit-background-size: ' . esc_attr($error_background_size) . ';' : '' ) .
            ( !empty($error_background_size) ? 'background-size: ' . esc_attr($error_background_size) . ';' : '' ) .
            ( !empty($error_background_image) ? 'background-image: url("' . esc_attr($error_background_image) . '");' : '' ) .
        '}
    ';
}