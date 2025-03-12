<?php

// ---------------------------- //
// ------ Header Colors ------- //
// ---------------------------- //
$header_default_text_color = neuros_get_prepared_option('header_default_text_color', 'standard_default_text_color', 'header_customize');
if ( !empty($header_default_text_color) ) {
    $neuros_custom_css .= '
        .header,
        .mobile-header {
            color: ' . esc_attr($header_default_text_color) . ';
        }
    ';
}

$header_dark_text_color = neuros_get_prepared_option('header_dark_text_color', 'standard_dark_text_color', 'header_customize');
if ( !empty($header_dark_text_color) ) {
    $neuros_custom_css .= '
        .site-search,
        .site-search .search-form .search-form-field,
        .header a,
        .header .main-menu > li > a,
        .header .logo-link .logo-site-name,
        .header .header-icon,
        .mobile-header a,
        .mobile-header .logo-link .logo-site-name,
        .mobile-header .header-icon,
        .mobile-header-menu-container a,
        .mobile-header-menu-container .logo-link .logo-site-name,
        .mobile-header-menu-container .header-icon,
        .error-404-header .logo-link .logo-site-name,
        .mini-cart .mini-cart-trigger,
        .mini-cart .mini-cart-trigger:hover,
        .header .mini-cart:hover .mini-cart-trigger,
        .mobile-header-menu-container,
        .header-type-2 .dropdown-trigger .dropdown-trigger-item:before,
        .header-type-3 .dropdown-trigger .dropdown-trigger-item:before,
        .callback .callback-text,
        .header-menu-style-compact .callback .callback-text:hover {
            color: ' . esc_attr($header_dark_text_color) . ';
        }
        .header .main-menu > li.current-menu-ancestor > a,
        .header .main-menu > li.current-menu-parent > a,
        .header .main-menu > li.current-menu-item > a,
        .header .main-menu > li.current-menu-ancestor > a:hover,
        .header .main-menu > li.current-menu-parent > a:hover,
        .header .main-menu > li.current-menu-item > a:hover,
        .header .mini-cart .mini-cart-trigger,
        .mobile-header .menu-trigger .hamburger span,
        .compact-menu-trigger:before, 
        .compact-menu-trigger:after {
            background-color: ' . esc_attr($header_dark_text_color) . ';
        }
    ';
}

$header_light_text_color = neuros_get_prepared_option('header_light_text_color', 'standard_light_text_color', 'header_customize');
if ( !empty($header_light_text_color) ) {
    $neuros_custom_css .= '
        .mobile-header-menu-container .header-mobile-contacts .contact-items-title {
            color: ' . esc_attr($header_light_text_color) . ';
        }
        .callback .callback-title {
            color: rgba(' . esc_attr(neuros_hex2rgb($header_light_text_color)) . ', 0.8);
        }        
        .site-search .search-form .search-form-field::-webkit-input-placeholder {
            color: ' . esc_attr($header_light_text_color) . ';
        }
        .site-search .search-form .search-form-field:-moz-placeholder {
            color: ' . esc_attr($header_light_text_color) . ';
        }
        .site-search .search-form .search-form-field::-moz-placeholder {
            color: ' . esc_attr($header_light_text_color) . ';
        }
        .site-search .search-form .search-form-field:-ms-input-placeholder {
            color: ' . esc_attr($header_light_text_color) . ';
        }
    ';
}

$header_accent_text_color = neuros_get_prepared_option('header_accent_text_color', 'standard_accent_text_color', 'header_customize');
if ( !empty($header_accent_text_color) ) {
    $neuros_custom_css .= '
        .mobile-header-menu-container a:hover,
        .mobile-header-menu-container .header-mobile-contacts .contact-item:before,
        .mobile-header-menu-container .main-menu > li.active > .sub-menu-trigger,
        .mobile-header-menu-container .main-menu li.active > a,
        .mobile-header-menu-container .main-menu li.current-menu-ancestor > a,
        .mobile-header-menu-container .main-menu li.current-menu-parent > a,
        .mobile-header-menu-container .main-menu li.current-menu-item > a,
        .mobile-header-menu-container .main-menu li.active > .sub-menu-trigger,
        .mobile-header-menu-container .main-menu li.current-menu-ancestor > .sub-menu-trigger,
        .mobile-header-menu-container .main-menu li.current-menu-parent > .sub-menu-trigger,
        .callback .callback-text:hover,
        .header-menu-style-compact .callback .callback-text {
            color: ' . esc_attr($header_accent_text_color) . ';
        }
    ';
}

$header_current_text_color = neuros_get_prepared_option('header_current_text_color', 'contrast_dark_text_color', 'header_customize');
if ( !empty($header_current_text_color) ) {
    $neuros_custom_css .= '
        .header .main-menu > li.current-menu-ancestor > a,
        .header .main-menu > li.current-menu-parent > a,
        .header .main-menu > li.current-menu-item > a,
        .header .main-menu > li.current-menu-ancestor > a:hover,
        .header .main-menu > li.current-menu-parent > a:hover,
        .header .main-menu > li.current-menu-item > a:hover,
        .header .mini-cart .mini-cart-trigger {
            color: ' . esc_attr($header_current_text_color) . ';
        }
    ';
}

$header_current_background_color = neuros_get_prepared_option('header_current_background_color', '', 'header_customize');
if ( !empty($header_current_background_color) ) {
    $neuros_custom_css .= '
        .header .main-menu > li.current-menu-ancestor > a,
        .header .main-menu > li.current-menu-parent > a,
        .header .main-menu > li.current-menu-item > a,
        .header .main-menu > li.current-menu-ancestor > a:hover,
        .header .main-menu > li.current-menu-parent > a:hover,
        .header .main-menu > li.current-menu-item > a:hover,
        .header .mini-cart .mini-cart-trigger {
            background-color: ' . esc_attr($header_current_background_color) . ';
        }
    ';
}

$header_border_color = neuros_get_prepared_option('header_border_color', 'standard_border_color', 'header_customize');
if ( !empty($header_border_color) ) {
    $neuros_custom_css .= '
        .site-search,
        .header-type-3 .dropdown-trigger,
        .mobile-header-menu-container .header-mobile-contacts:before {
            border-color: ' . esc_attr($header_border_color) . ';
        }
    ';
}

$header_border = neuros_get_prefered_option('header_border');

if(!empty($header_border) && $header_border === 'border' && !empty($header_border_color)) {
    $neuros_custom_css .= '
        .header:not(.sticky-header):before {
            border-color: ' . esc_attr($header_border_color) . ';
        }
    ';
}

$header_border_hover_color = neuros_get_prepared_option('header_border_hover_color', 'standard_border_hover_color', 'header_customize');
if ( !empty($header_border_hover_color) ) {
    $neuros_custom_css .= '';
}

$header_background_color = neuros_get_prepared_option('header_background_color', 'standard_background_color', 'header_customize');
if ( !empty($header_background_color) ) {
    $neuros_custom_css .= '
        .header,
        .mobile-header,
        .site-search,
        .mobile-header-menu-container,
        .header.sticky-header-on.sticky-ready .sticky-wrapper,
        .mobile-header.sticky-header-on.sticky-ready .sticky-wrapper {
            background-color: ' . esc_attr($header_background_color) . ';
        }
    ';
}

$header_background_alter_color = neuros_get_prepared_option('header_background_alter_color', 'standard_background_alter_color', 'header_customize');
if ( !empty($header_background_alter_color) ) {
    $neuros_custom_css .= '
        .header .main-menu > li > a:hover,
        .header .mini-cart:hover .mini-cart-trigger {
            background-color: ' . esc_attr($header_background_alter_color) . ';
        }
    ';
}

$header_button_text_color = neuros_get_prepared_option('header_button_text_color', 'standard_button_text_color', 'header_customize');
if ( !empty($header_button_text_color) ) {
    $neuros_custom_css .= '
        .header .neuros-button, 
        .mobile-header .neuros-button, 
        .mobile-header-menu-container .neuros-button {
            color: ' . esc_attr($header_button_text_color) . ';
        }
    ';
}

$header_button_border_color = neuros_get_prepared_option('header_button_border_color', 'standard_button_border_color', 'header_customize');
if ( !empty($header_button_border_color) ) {
    $neuros_custom_css .= '
    ';
}

$header_button_border_style = neuros_get_prepared_option('header_button_border_style', 'standard_button_border_style', 'header_customize');
if ( $header_button_border_style == 'solid' ) {
    $neuros_custom_css .= '
        .header-icons-container .header-button-container .neuros-button .button-inner,
        .mobile-header-menu-container .neuros-button .button-inner {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
    ';
}
$header_button_border_color = neuros_get_prepared_option('header_button_border_color', 'standard_button_border_color', 'header_customize');
$header_button_border_color_add = neuros_get_prepared_option('header_button_border_color_add', 'standard_button_border_color_add', 'header_customize');
if( $header_button_border_style == 'gradient' && ( !empty($header_button_border_color) && !empty($header_button_border_color_add) )) {
    $neuros_custom_css .= '
        .header-icons-container .header-button-container .neuros-button:after,
        .mobile-header-menu-container .neuros-button:after {
            background: linear-gradient(var(--button-border-gradient-angle), ' . esc_attr($header_button_border_color) . ' var(--button-gradient-colorstop-1), ' . esc_attr($header_button_border_color_add) . ' var(--button-gradient-colorstop-2));
        }
    ';
} elseif ( $header_button_border_style == 'solid' && !empty($header_button_border_color)) {
    $neuros_custom_css .= '
        .header-icons-container .header-button-container .neuros-button,
        .mobile-header-menu-container .neuros-button {
            border-color: ' . esc_attr($header_button_border_color) . ';
        }
    ';
}

$header_button_background_style = neuros_get_prepared_option('header_button_background_style', 'standard_button_background_style', 'header_customize');
$header_button_background_color = neuros_get_prepared_option('header_button_background_color', 'standard_button_background_color', 'header_customize');
$header_button_background_color_add = neuros_get_prepared_option('header_button_background_color_add', 'standard_button_background_color_add', 'header_customize');
if( $header_button_background_style == 'gradient' && ( !empty($header_button_background_color) && !empty($header_button_background_color_add) )) {
    $neuros_custom_css .= '
        .header-icons-container .header-button-container .neuros-button .button-inner:before,
        .mobile-header-menu-container .neuros-button .button-inner:before {
            background: linear-gradient(var(--button-border-gradient-angle), ' . esc_attr($header_button_background_color) . ' var(--button-gradient-colorstop-1), ' . esc_attr($header_button_background_color_add) . ' var(--button-gradient-colorstop-2));
        }
    ';
} elseif ( $header_button_background_style == 'solid' && !empty($header_button_background_color)) {
    $neuros_custom_css .= '
        .header-icons-container .header-button-container .neuros-button,
        .mobile-header-menu-container .neuros-button {
            background-color: ' . esc_attr($header_button_background_color) . ';
        }
    ';
}

if ( !empty($header_button_background_color) ) {
    $neuros_custom_css .= '';
}

$header_button_text_hover = neuros_get_prepared_option('header_button_text_hover', 'standard_button_text_hover', 'header_customize');
if ( !empty($header_button_text_hover) ) {
    $neuros_custom_css .= '
        .header .neuros-button:hover, 
        .mobile-header .neuros-button:hover, 
        .mobile-header-menu-container .neuros-button:hover {
            color: ' . esc_attr($header_button_text_hover) . ';
        }
    ';
}

$header_button_border_hover = neuros_get_prepared_option('header_button_border_hover', 'standard_button_border_hover', 'header_customize');
$header_button_border_hover_add = neuros_get_prepared_option('header_button_border_hover_add', 'standard_button_border_hover_add', 'header_customize');
if( $header_button_border_style == 'gradient' && ( !empty($header_button_border_hover) && !empty($header_button_border_hover_add) )) {
    $neuros_custom_css .= '
        .header-icons-container .header-button-container .neuros-button:hover:after,
        .mobile-header-menu-container .neuros-button:hover:after {
            background: linear-gradient(var(--button-border-gradient-angle), ' . esc_attr($header_button_border_hover) . ' var(--button-gradient-colorstop-1), ' . esc_attr($header_button_border_hover_add) . ' var(--button-gradient-colorstop-2));
        }
    ';
} elseif ( $header_button_border_style == 'solid' && !empty($header_button_border_hover)) {
    $neuros_custom_css .= '
        .header-icons-container .header-button-container .neuros-button:hover,
        .mobile-header-menu-container .neuros-button:hover {
            border-color: ' . esc_attr($header_button_border_hover) . ';
        }
    ';
}

$header_button_border_hover = neuros_get_prepared_option('header_button_border_hover', 'standard_button_border_hover', 'header_customize');
if ( !empty($header_button_border_hover) ) {
    $neuros_custom_css .= '
    ';
}

$header_button_background_style = neuros_get_prepared_option('header_button_background_style', 'standard_button_background_style', 'header_customize');
$header_button_background_hover = neuros_get_prepared_option('header_button_background_hover', 'standard_button_background_hover', 'header_customize');
$header_button_background_hover_add = neuros_get_prepared_option('header_button_background_hover_add', 'standard_button_background_hover_add', 'header_customize');
if( $header_button_background_style == 'gradient' && ( !empty($header_button_background_hover) && !empty($header_button_background_hover_add) )) {
    $neuros_custom_css .= '
        .header-icons-container .header-button-container .neuros-button .button-inner:after,
        .mobile-header-menu-container .neuros-button .button-inner:after {
            background: linear-gradient(var(--button-border-gradient-angle), ' . esc_attr($header_button_background_hover) . ' var(--button-gradient-colorstop-1), ' . esc_attr($header_button_background_hover_add) . ' var(--button-gradient-colorstop-2));
        }
    ';
} elseif ( $header_button_background_style == 'solid' && !empty($header_button_background_hover)) {
    $neuros_custom_css .= '
        .header-icons-container .header-button-container .neuros-button:hover,
        .mobile-header-menu-container .neuros-button:hover {
            background-color: ' . esc_attr($header_button_background_hover) . ';
        }
    ';
}

if ( !empty($header_button_background_hover) ) {
    $neuros_custom_css .= '';
}

$header_menu_text_color = neuros_get_prepared_option('header_menu_text_color', '', 'header_customize');
if ( !empty($header_menu_text_color) ) {
    $neuros_custom_css .= '
        .header .main-menu > li > a {
            color: ' . esc_attr($header_menu_text_color) . ';
        }
    ';
}

$header_menu_text_color_hover = neuros_get_prepared_option('header_menu_text_color_hover', '', 'header_customize');
if ( !empty($header_menu_text_color_hover) ) {
    $neuros_custom_css .= '
        .header .main-menu > li > a:hover {
            color: ' . esc_attr($header_menu_text_color_hover) . ';
        }
    ';
}

$header_menu_text_background_color_hover = neuros_get_prepared_option('header_menu_text_background_color_hover', '', 'header_customize');
if ( !empty($header_menu_text_background_color_hover) ) {
    $neuros_custom_css .= '
        .header .main-menu > li > a:hover {
            background-color: ' . esc_attr($header_menu_text_background_color_hover) . ';
        }
    ';
}

$header_menu_background_color = neuros_get_prepared_option('header_menu_background_color', '', 'header_customize');
if ( !empty($header_menu_background_color) ) {
    $neuros_custom_css .= '
        .header .main-menu > li,
        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item {
            padding: 18px 0 20px;
        }
        .header #mega-menu-wrap-main #mega-menu-main {
            display: inline-block;
        }
        .header .main-menu,
        .header #mega-menu-wrap-main #mega-menu-main {
            padding: 0 22px;
            -webkit-border-radius: 999px;
            border-radius: 999px;
            background-color: ' . esc_attr($header_menu_background_color) . ';
        }
    ';
}

$page_top_background_color = neuros_get_prefered_option('page_top_background_color');
if ( !empty('page_top_background_color') ) {
    $neuros_custom_css .= '
        .top-page-wrapper {
            background-color: ' . esc_attr($page_top_background_color) . '
        }
    ';
}

$body_lines_color = neuros_get_prepared_option('body_lines_color', 'standard_border_color', 'body_lines_status');
if ( !empty($body_lines_color) ) {
    $neuros_custom_css .= '
        .body-container .body-line {
            border-color: ' . esc_attr($body_lines_color) . ';
        }
    ';
}

if( class_exists( 'Mega_Menu' ) && (is_singular() || (class_exists('WooCommerce') && is_woocommerce())) ) {
	if( neuros_get_post_option('header_customize') == 'on' ) {
		$header_dark_text_color = neuros_get_post_option('header_dark_text_color');
		if ( !empty($header_dark_text_color) ) {
		    $neuros_custom_css .= '
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item > a.mega-menu-link,
		        .mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item > a.mega-menu-link,
		        .mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link,
		        .mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link, 
		        .mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link,
		        .mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link, 
		        .mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link,
		        .mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-flyout ul.mega-sub-menu > li.mega-menu-item h4.mega-block-title,
		        .mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-megamenu ul.mega-sub-menu > li.mega-menu-item h4.mega-block-title,
		        .mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-megamenu ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item h4.mega-block-title {
		            color: ' . esc_attr($header_dark_text_color) . ';
		        }
		    ';
		}

		$header_accent_text_color = neuros_get_post_option('header_accent_text_color');
		if ( !empty($header_accent_text_color) ) {
		    $neuros_custom_css .= '
		    	.mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item a.mega-menu-link:hover, 
		    	.mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link, 
		    	.mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link, 
		    	.mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-menu-item > a.mega-menu-link, 
		    	.mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link, 
		    	.mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link, 
		    	.mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:hover,
		    	.mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:focus,
		    	.mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:hover, 
		    	.mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:focus, 
		    	.mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link:hover,
		    	.mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link:focus,
		        .mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link,
		        .mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link, 
		        .mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link,
		        .mobile-header-menu-container #mega-menu-wrap-main #mega-menu-main > li.mega-menu-flyout.mega-menu-item.mega-toggle-on a.mega-menu-link {
		            color: ' . esc_attr($header_accent_text_color) . ';
		        }
		    ';
		}

		$header_current_text_color = neuros_get_post_option('header_current_text_color');
		if ( !empty($header_current_text_color) ) {
		    $neuros_custom_css .= '
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link, 
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link, 
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link,
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link:hover, 
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link:hover, 
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link:hover {
		            color: ' . esc_attr($header_current_text_color) . ';
		        }
		    ';
		}

		$header_current_background_color = neuros_get_post_option('header_current_background_color');
		if ( !empty($header_current_background_color) ) {
		    $neuros_custom_css .= '
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link, 
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link, 
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link,
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link:hover, 
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link:hover, 
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link:hover {
		            background-color: ' . esc_attr($header_current_background_color) . ';
		        }
		    ';
		}

		$header_menu_text_color = neuros_get_post_option('header_menu_text_color');
		if ( !empty($header_menu_text_color) ) {
		    $neuros_custom_css .= '
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item > a.mega-menu-link {
		            color: ' . esc_attr($header_menu_text_color) . ';
		        }
		    ';
		}

		$header_menu_text_color_hover = neuros_get_post_option('header_menu_text_color_hover');
		if ( !empty($header_menu_text_color_hover) ) {
		    $neuros_custom_css .= '
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item > a.mega-menu-link:hover,
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item > a.mega-menu-link:focus {
		            color: ' . esc_attr($header_menu_text_color_hover) . ';
		        }
		    ';
		}

		$header_menu_text_background_color_hover = neuros_get_post_option('header_menu_text_background_color_hover');
		if ( !empty($header_menu_text_background_color_hover) ) {
		    $neuros_custom_css .= '
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item > a.mega-menu-link:hover,
		        .header #mega-menu-wrap-main #mega-menu-main > li.mega-menu-item > a.mega-menu-link:focus {
		            background-color: ' . esc_attr($header_menu_text_background_color_hover) . ';
		        }
		    ';
		}

	}
}