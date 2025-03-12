<?php

// ----------------------------- //
// ------ Header Settings ------ //
// ----------------------------- //

# Header Menu
$header_menu_font       = neuros_get_prepared_option('header_menu_font', 'main_font', 'header_menu_customize');
$header_menu_font_array = json_decode($header_menu_font, true);
if (
    !empty($header_menu_font_array['font_family']) ||
    !empty($header_menu_font_array['font_size']) ||
    !empty($header_menu_font_array['line_height']) ||
    !empty($header_menu_font_array['text_transform']) ||
    !empty($header_menu_font_array['letter_spacing']) ||
    !empty($header_menu_font_array['word_spacing']) ||
    !empty($header_menu_font_array['font_style']) ||
    !empty($header_menu_font_array['font_weight'])
) {
    $neuros_custom_css .= '
        .header .main-menu > li > a {' .
            neuros_print_font_styles( $header_menu_font, array('font_family', 'font_size', 'line_height', 'text_transform', 'letter_spacing', 'word_spacing', 'font_style', 'font_weight') ) .
        '}
        .mobile-header-menu-container .main-menu > li > a,
        .slide-extra .extra-menu > li > a {' .
            neuros_print_font_styles( $header_menu_font, array('font_family', 'text_transform', 'letter_spacing', 'word_spacing', 'font_style', 'font_weight') ) .
        '}
    ';
}

# Header Sub Menu
$header_sub_menu_font       = neuros_get_prepared_option('header_sub_menu_font', 'main_font', 'header_menu_customize');
$header_sub_menu_font_array = json_decode($header_sub_menu_font, true);
if (
    !empty($header_sub_menu_font_array['font_family']) ||
    !empty($header_sub_menu_font_array['font_size']) ||
    !empty($header_sub_menu_font_array['line_height']) ||
    !empty($header_sub_menu_font_array['text_transform']) ||
    !empty($header_sub_menu_font_array['letter_spacing']) ||
    !empty($header_sub_menu_font_array['word_spacing']) ||
    !empty($header_sub_menu_font_array['font_style']) ||
    !empty($header_sub_menu_font_array['font_weight'])
) {
    $neuros_custom_css .= '
        .header .main-menu > li ul.sub-menu > li > a {' .
            neuros_print_font_styles( $header_sub_menu_font, array('font_family', 'font_size', 'line_height', 'text_transform', 'letter_spacing', 'word_spacing', 'font_style', 'font_weight') ) .
        '}
        .mobile-header-menu-container .main-menu > li ul.sub-menu > li > a,
        .alter-menu-menu .main-menu > li > a,
        .slide-extra .extra-menu > li ul.sub-menu > li > a {' .
            neuros_print_font_styles( $header_sub_menu_font, array('font_family', 'text_transform', 'letter_spacing', 'word_spacing', 'font_style') ) .
        '}
    ';
}

# Mobile Header Breakpoint
$mobile_header_breakpoint = neuros_get_prepared_option('mobile_header_breakpoint');
if (
    !empty($mobile_header_breakpoint)
) {
    $neuros_custom_css .= '
        @media only screen and (min-width: ' . esc_attr($mobile_header_breakpoint) . 'px) {
            .top-bar {
                display: block;
            }
            .header {
                display: block !important;
            }
            .mobile-header {
                display: none !important;
            }
            .top-page-wrapper {
                padding: 0 40px 25px;
            }
            .header.sticky-header,
            .header-wrapper.header-position-over {
                width: calc(100% - 80px);
                left: 40px;
                right: 40px;
            }
        }
    ';
}

$header_menu_bg_image = neuros_get_prepared_img_url('header_menu_bg_image', 'header_menu_bg_image_status');

if(neuros_get_prefered_option('header_menu_bg_image_status') == 'on' && !empty($header_menu_bg_image)) {
    $neuros_custom_css .= '
        .alter-menu-wrapper:before {
            background-image: url("' . esc_attr($header_menu_bg_image) . '");
        }
    ';
}

# Side Panel Settings
$side_panel_bg_image = neuros_get_prepared_img_url('side_panel_bg_image', 'side_panel_bg_image_status');

if(neuros_get_prefered_option('side_panel_bg_image_status') == 'on' && !empty($side_panel_bg_image)) {
    $neuros_custom_css .= '
        .slide-sidebar-wrapper:before {
            background-image: url("' . esc_attr($side_panel_bg_image) . '");
        }
    ';
}

$header_offset_top = neuros_get_prepared_option('header_offset_top', '', 'header_customize');
if(!empty($header_offset_top) && empty($mobile_header_breakpoint)) {
    $neuros_custom_css .= '
        @media only screen and (min-width: 992px) {
            .top-page-wrapper .header-wrapper {
                padding-top: ' . esc_attr($header_offset_top) . 'px;
            }
        }        
    ';
} elseif(!empty($header_offset_top) && !empty($mobile_header_breakpoint)) {
    $neuros_custom_css .= '
        @media only screen and (min-width: ' . esc_attr($mobile_header_breakpoint) . 'px) {
            .top-page-wrapper .header-wrapper {
                padding-top: ' . esc_attr($header_offset_top) . 'px;
            }
        }        
    ';
}