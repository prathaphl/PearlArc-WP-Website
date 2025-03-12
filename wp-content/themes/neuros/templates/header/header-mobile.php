<?php
    defined( 'ABSPATH' ) or die();
?>

    <div class="mobile-header-row">

        <!-- Logo Block -->
        <?php
            if ( neuros_get_prefered_option('header_logo_status') == 'on' ) {
                echo '<div class="logo-container">' . neuros_get_logo_output(true) . '</div>';
            }
        ?>

        <!-- Icons Block -->
        <?php
            if (
                neuros_get_prefered_option('header_search_status') == 'on' ||
                neuros_get_prefered_option('header_menu_status') == 'on' ||
                (
                    neuros_get_prefered_option('side_panel_status') == 'on' &&
                    is_active_sidebar('sidebar-side')
                ) ||
                (
                    class_exists('WooCommerce') && neuros_get_prefered_option('header_minicart_status') == 'on'
                ) ||
                neuros_get_prefered_option('header_login_status') == 'on'
            ) {
                echo '<div class="header-icons-container">';

                    // Burger Menu Trigger
                    if ( neuros_get_prefered_option('header_menu_status') == 'on' ) { ?>
                        <div class="header-icon menu-trigger">
                            <span class="menu-trigger-icon">
                                <span class="hamburger">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </span>
                            </span>
                        </div>
                    <?php }

                echo '</div>';
            }
        ?>

    </div>