<?php
    defined( 'ABSPATH' ) or die();
?>

<div class="header-row">

    <!-- Left Info Block -->
    <?php
        if (
            neuros_get_prefered_option('header_logo_status') == 'on' ||
            (
                neuros_get_prefered_option('side_panel_status') == 'on' && 
                (is_active_sidebar('sidebar-side') || neuros_get_prefered_option('sidebar_logo_status') == 'on' || neuros_get_prefered_option('side_panel_socials_status') == 'on')
            )
        ) {
            echo '<div class="header-icons-container">';
                if ( neuros_get_prefered_option('side_panel_status') == 'on' && is_active_sidebar('sidebar-side') ) {
                    // Header Side Panel
                    echo '<div class="header-icon dropdown-trigger">';
                        echo '<div class="dropdown-trigger-item"></div>';
                    echo '</div>';
                }
                if ( neuros_get_prefered_option('header_logo_status') == 'on' ) {
                    // Header Logo
                    echo '<div class="logo-container">' . neuros_get_logo_output() . '</div>';
                }
            echo '</div>';
        }
    ?>

    <!-- Menu Block -->
    <?php
        if ( neuros_get_prefered_option('header_menu_status') == 'on' ) {
            if ( !empty(neuros_get_prefered_option('header_menu_select')) && neuros_get_prefered_option('header_menu_select') != 'default' ) {
                wp_nav_menu(
                    array(
                        'menu'              => neuros_get_prefered_option('header_menu_select'),
                        'menu_class'        => 'main-menu',
                        'depth'             => 0,
                        'container'         => 'div',
                        'container_class'   => 'header-menu-container',
                        'fallback_cb'       => '',
                        'items_wrap'        => '<nav><ul id="%1$s" class="%2$s">%3$s</ul></nav>'
                    )
                );
            } else {
                $menu_locations = get_nav_menu_locations();
                if ( isset($menu_locations['main']) && $menu_locations['main'] !== 0 ) {
                    wp_nav_menu(
                        array(
                            'theme_location'    => 'main',
                            'menu_class'        => 'main-menu',
                            'depth'             => 0,
                            'container'         => 'div',
                            'container_class'   => 'header-menu-container',
                            'fallback_cb'       => '',
                            'items_wrap'        => '<nav><ul id="%1$s" class="%2$s">%3$s</ul></nav>'
                        )
                    );
                }
            }
        }
    ?>

    <!-- Right Info Block -->
    <?php
        if (
            neuros_get_prefered_option('header_search_status') == 'on' ||
            (
                neuros_get_prefered_option('header_button_status') == 'on' &&
                !empty(neuros_get_prefered_option('header_button_text'))
            ) ||
            (
                class_exists('WooCommerce') && neuros_get_prefered_option('header_minicart_status') == 'on'
            ) ||
            neuros_get_prefered_option('header_login_status') == 'on'
        ) {
            echo '<div class="header-icons-container">';

                // Header Search
                if ( neuros_get_prefered_option('header_search_status') == 'on' ) {
                    echo '<div class="header-icon search-trigger">';
                        echo '<span class="search-trigger-icon"></span>';
                    echo '</div>';
                }

                // Header Product Cart
                if ( class_exists('WooCommerce') && neuros_get_prefered_option('header_minicart_status') == 'on' ) {
                    echo '<div class="header-icon mini-cart">';
                        echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="mini-cart-trigger">';
                            echo '<i class="mini-cart-count">';
                                echo '<span>' . WC()->cart->cart_contents_count . '</span>';
                            echo '</i>';
                        echo '</a>';
                        echo '<div class="mini-cart-panel woocommerce">';
                            echo '<h4 class="mini-cart-title">' . esc_html__('Cart Items', 'neuros') . '</h4>';
                            woocommerce_mini_cart();
                        echo '</div>';
                    echo '</div>';
                }

                // Login/Logout
                if ( neuros_get_prefered_option('header_login_status') == 'on' ) {
                    if ( class_exists('WooCommerce') ) {
                        echo '<div class="header-icon login-logout">';
                        if (is_user_logged_in()) {
                            echo '<a href="' . wp_logout_url(home_url()) . '" title="' . esc_attr__('Logout', 'neuros') . '" class="link-logout"></a>';
                        } else {
                            echo '<a href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '" title="' . esc_attr__('Login/Register', 'neuros') . '" class="link-login"></a>';
                        };
                        echo '</div>';
                    } else {
                        echo '<div class="header-icon login-logout">';
                        if (is_user_logged_in()) {
                            echo '<a href="' . wp_logout_url(home_url()) . '" title="' . esc_attr__('Logout', 'neuros') . '" class="link-logout"></a>';
                        } else {
                            echo '<a href="' . wp_login_url(get_permalink()) . '" title="' . esc_attr__('Login/Register', 'neuros') . '" class="link-login"></a>';
                        };
                        echo '</div>';
                    }
                }

                // Header Button
                if ( neuros_get_prefered_option('header_button_status') == 'on' && !empty(neuros_get_prefered_option('header_button_text')) ) {
                    echo '<div class="header-icon header-button-container">';
                        echo '<a class="neuros-button" href="' . ( !empty(neuros_get_prefered_option('header_button_url')) ? esc_url(neuros_get_prefered_option('header_button_url')) : esc_js('javascript:void(0);')) . '">';
                            echo esc_html(neuros_get_prefered_option('header_button_text'));
                            echo '<span class="button-inner"></span>';
                        echo '</a>';
                    echo '</div>';
                }

            echo '</div>';
        }
    ?>

</div>