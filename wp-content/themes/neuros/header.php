<?php
    defined( 'ABSPATH' ) or die();

    $slide_sidebar_classes = 'slide-sidebar-wrapper slide-sidebar-position-left';

    $header_classes = 'header';
    if ( !empty(neuros_get_prefered_option('header_style')) ) {
        $header_classes .= ' header-' . esc_attr(neuros_get_prefered_option('header_style'));
    }
    if ( !empty(neuros_get_prefered_option('header_position')) ) {
        $header_classes .= ' header-position-' . esc_attr(neuros_get_prefered_option('header_position'));
    }
    
    $page_for_posts = get_option( 'page_for_posts' );
    if( is_singular() || 
        (class_exists('WooCommerce') && is_woocommerce()) ||
        (is_home() && $page_for_posts)) {
            if(neuros_get_post_option('header_position') == 'default' && 
                !empty(neuros_get_theme_mod('header_transparent')) && 
                neuros_get_theme_mod('header_position') == 'over') {
                $header_classes .= ' header-transparent';
            } elseif( !empty(neuros_get_post_option('header_transparent')) && neuros_get_post_option('header_position') == 'over' ) {
                $header_classes .= ' header-transparent';
            }
    } else {
        if ( !empty(neuros_get_prefered_option('header_transparent')) && neuros_get_prefered_option('header_position') == 'over' ) {
            $header_classes .= ' header-transparent';
        }
    }
    
    if ( !empty(neuros_get_prefered_option('sticky_header_status')) ) {
        $header_classes .= ' sticky-header-' . esc_attr(neuros_get_prefered_option('sticky_header_status'));
    }

    if ( !empty(neuros_get_prefered_option('header_menu_style')) ) {
        $header_classes .= ' header-menu-style-' . esc_attr(neuros_get_prefered_option('header_menu_style'));
    }

    $mobile_classes = 'mobile-header';
    if ( !empty(neuros_get_prefered_option('header_position')) ) {
        $mobile_classes .= ' mobile-header-position-' . esc_attr(neuros_get_prefered_option('header_position'));
    }
    if ( !empty(neuros_get_prefered_option('sticky_header_status')) ) {
        $mobile_classes .= ' sticky-header-' . esc_attr(neuros_get_prefered_option('sticky_header_status'));
    }
    if ( !empty(neuros_get_prefered_option('header_style')) ) {
        $mobile_classes .= ' mobile-header-' . esc_attr(neuros_get_prefered_option('header_style'));
    }

    $sticky_header_classes = 'header sticky-header';
    if ( !empty(neuros_get_prefered_option('header_style')) ) {
        $sticky_header_classes .= ' header-' . esc_attr(neuros_get_prefered_option('header_style'));
    }
    if ( !empty(neuros_get_prefered_option('header_menu_style')) ) {
        $sticky_header_classes .= ' header-menu-style-' . esc_attr(neuros_get_prefered_option('header_menu_style'));
    }
    if ( neuros_get_prepared_option('sticky_header_blur', '', 'sticky_header_status') === 'on' ) {
        $sticky_header_classes .= ' sticky-header-blur-on';
    }

    $mobile_sticky_header_classes = 'mobile-header sticky-header';
    if ( !empty(neuros_get_prefered_option('header_style')) ) {
        $mobile_sticky_header_classes .= ' mobile-header-' . esc_attr(neuros_get_prefered_option('header_style'));
    }
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <?php wp_head(); ?>
    </head>

    <!-- Body -->
    <body <?php body_class(); ?>>
        <?php if ( function_exists( 'wp_body_open' ) ) {
                wp_body_open();
        } ?>
        <div class="body-overlay"></div>

        <?php if ( neuros_get_prefered_option('page_loader_status') == 'on' ) { ?>
            <!-- Page Pre Loader -->
            <div class="page-loader-container">
                <div class="page-loader">
                    <div class="page-loader-inner">
                        <?php
                            if ( !empty(neuros_get_prefered_option('page_loader_image')) ) {
                                $loader_image_metadata = wp_get_attachment_metadata(attachment_url_to_postid(neuros_get_prefered_option('page_loader_image')));
                                $loader_image_width = (isset($loader_image_metadata['width']) ? $loader_image_metadata['width'] : 0);
                                $loader_image_height = (isset($loader_image_metadata['height']) ? $loader_image_metadata['height'] : 0);
                                $loader_image_url = neuros_get_theme_mod('page_loader_image');

                                echo '<img width="' . esc_attr($loader_image_width) . '" height="' . esc_attr($loader_image_height) . '" src="' . esc_url($loader_image_url) . '" alt="' . esc_attr__('Page Loader Image', 'neuros') . '"  class="page-loader-logo" />';
                            } else {
                                echo '<svg viewBox="0 0 48 25" xmlns="http://www.w3.org/2000/svg">
																<path d="M11.9792 18.6581C11.9792 21.966 9.29754 24.6477 5.98958 24.6477C2.68163 24.6477 0 21.966 0 18.6581C0 15.3501 2.68163 12.6685 5.98958 12.6685C9.29754 12.6685 11.9792 15.3501 11.9792 18.6581Z"/>
																<path d="M23.9583 5.98958C23.9583 9.29754 21.2767 11.9792 17.9688 11.9792C14.6608 11.9792 11.9792 9.29754 11.9792 5.98958C11.9792 2.68163 14.6608 0 17.9688 0C21.2767 0 23.9583 2.68163 23.9583 5.98958Z"/>
																<path d="M35.5851 19.0104C35.5851 22.3184 32.9035 25 29.5956 25C26.2876 25 23.606 22.3184 23.606 19.0104C23.606 15.7025 26.2876 13.0208 29.5956 13.0208C32.9035 13.0208 35.5851 15.7025 35.5851 19.0104Z"/>
																<path d="M47.212 7.03125C47.212 10.3392 44.5304 13.0208 41.2224 13.0208C37.9145 13.0208 35.2328 10.3392 35.2328 7.03125C35.2328 3.72329 37.9145 1.04167 41.2224 1.04167C44.5304 1.04167 47.212 3.72329 47.212 7.03125Z"/>
																<path d="M17.6164 13.0208C13.5294 13.0208 12.1553 17.4683 11.9792 19.1712L5.65257 12.8446C7.35549 12.6684 11.8382 11.1534 11.9792 6.5027C21.7034 6.22083 24.0171 6.38525 23.9583 6.5027C23.6765 11.4353 28.6407 12.9033 30.6373 13.0208L23.606 19.1712C23.3124 17.4683 21.7034 13.0208 17.6164 13.0208Z"/>
																</svg>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ( neuros_get_prefered_option('header_search_status') == 'on' ) { ?>
            <!-- Search Panel -->
            <div class="site-search">
                <div class="site-search-close"></div>
                <?php
                    $search_args = array(
                        'echo'          => true,
                        'aria_label'    => 'global'
                    );
                    get_search_form($search_args);
                ?>
            </div>
        <?php } ?>

        <!-- Mobile Menu Panel -->
        <?php
            get_template_part( 'templates/header/header-mobile-aside' );
        ?>

        <!-- Compact Menu Block -->
        <?php
            if ( neuros_get_prefered_option('header_status') == 'on' && neuros_get_prefered_option('header_menu_style') === 'compact' && neuros_get_prefered_option('header_menu_status') == 'on' ) {
                get_template_part('templates/header/header-alter-menu');
            }
        ?>

        <div class="body-container">
            <?php if ( neuros_get_prefered_option('body_lines_status') == 'on' ) { ?>
                <div class="body-lines">
                    <div class="body-line body-line-l1"></div>
                    <div class="body-line body-line-l2"></div>
                    <div class="body-line body-line-r1"></div>
                    <div class="body-line body-line-r2"></div>
                </div>
            <?php } ?>

            <?php
            if ( neuros_get_prefered_option('side_panel_status') == 'on' && 
                (is_active_sidebar('sidebar-side') || neuros_get_prefered_option('sidebar_logo_status') == 'on' || neuros_get_prefered_option('side_panel_socials_status') == 'on') ) { ?>
                <!-- Side Panel -->
                <div class="<?php echo esc_attr($slide_sidebar_classes); ?>">
                    <div class="slide-sidebar-close"><?php echo esc_html__('Close', 'neuros'); ?></div>
                    <div class="slide-sidebar">
                        <?php 
                            if ( neuros_get_prefered_option('sidebar_logo_status') == 'on' ) {
                                // Side Panel Logo
                                echo '<div class="sidebar-logo-container">' . neuros_get_sidebar_logo_output() . '</div>';
                            }
                        ?>
                        <div class="slide-sidebar-content">
                            <?php dynamic_sidebar('sidebar-side'); ?>
                        </div>
                        <?php
                            if( neuros_get_prefered_option('side_panel_socials_status') == 'on' ) {
                                echo neuros_socials_output('wrapper-socials');
                            }
                        ?>
                    </div>
                    <span class="slide-sidebar-gradient"></span>
                </div>
            <?php
            } ?>

            <?php
                if ( neuros_get_prefered_option('top_bar_status') == 'on' ||
                     neuros_get_prefered_option('header_status') == 'on' || 
                     neuros_get_prefered_option('page_title_status') == 'on' ) {
                    $top_page_wrapper_classes = 'top-page-wrapper';
                    if ( !empty(neuros_get_prefered_option('header_style')) ) {
                        $top_page_wrapper_classes .= ' header-' . esc_attr(neuros_get_prefered_option('header_style'));
                    }
                    if ( !empty(neuros_get_prefered_option('page_top_border_radius')) ) {
                        $top_page_wrapper_classes .= ' top-page-wrapper-br-' . esc_attr(neuros_get_prefered_option('page_top_border_radius'));
                    }
                    if ( neuros_get_prefered_option('page_title_status') != 'on' ) {
                        $top_page_wrapper_classes .= ' no-page-title';
                    }
                    if ( !empty(neuros_get_prefered_option('header_position')) ) {
                        $top_page_wrapper_classes .= ' header-position-' . esc_attr(neuros_get_prefered_option('header_position'));
                    }
                    echo '<div class="' . esc_attr($top_page_wrapper_classes) . '">';
                }
            ?>

            <?php
                if ( neuros_get_prefered_option('top_bar_status') == 'on' ||
                     neuros_get_prefered_option('header_status') == 'on' ) {
                    $header_wrapper_classes = 'header-wrapper';
                    if ( !empty(neuros_get_prefered_option('header_position')) ) {
                        $header_wrapper_classes .= ' header-position-' . esc_attr(neuros_get_prefered_option('header_position'));
                    }
                    if ( neuros_get_prefered_option('header_status') != 'on' ) {
                        $header_wrapper_classes .= ' no-header';
                    }
                    echo '<div class="' . esc_attr($header_wrapper_classes) . '">';
                }
            ?>

            <!-- Top Bar -->
            <?php
                if ( neuros_get_prefered_option('top_bar_status') == 'on' ) {
                    get_template_part( 'templates/top-bar/top-bar' );
                }
            ?>

            <!-- Mobile Sticky Header -->
            <?php
            if( neuros_get_prefered_option('header_status') == 'on' && neuros_get_prefered_option('sticky_header_status') == 'on' ) {
                echo '<div class="' . esc_attr($mobile_sticky_header_classes) . '">';
                    get_template_part( 'templates/header/header-mobile' );
                echo '</div>';
            } ?>

            <!-- Mobile Header -->
            <?php
            if( neuros_get_prefered_option('header_status') == 'on' ) {
                echo '<div class="' . esc_attr($mobile_classes) . '">';
                    get_template_part( 'templates/header/header-mobile' );
                echo '</div>';
            } ?>

            <?php
            if ( neuros_get_prefered_option('header_status') == 'on' ) {                
                if(neuros_get_prefered_option('sticky_header_status') == 'on') { ?>
                    <!-- Sticky Header -->
                    <?php echo '<header class="' . esc_attr($sticky_header_classes) . '">';
                        if(neuros_get_prefered_option('header_menu_style') !== 'compact') {
                            switch (neuros_get_prefered_option('header_style')) {                            
                                case 'type-2' :
                                    get_template_part('templates/header/header-2');
                                    break;
                                case 'type-3' :
                                    get_template_part('templates/header/header-3');
                                    break;
                                case 'type-4' :
                                    get_template_part('templates/header/header-4');
                                    break;
                                default :
                                    get_template_part('templates/header/header-1');
                                    break;
                            }
                        } else {
                            get_template_part('templates/header/header-alter');
                        }
                    ?>
                    <?php echo '</header>'; 
                } ?>
                <!-- Header -->
                <?php
                echo '<header class="' . esc_attr($header_classes) . '">';
                    if(neuros_get_prefered_option('header_menu_style') !== 'compact') {
                        switch (neuros_get_prefered_option('header_style')) {
                            case 'type-2' :
                                get_template_part('templates/header/header-2');
                                break;
                            case 'type-3' :
                                get_template_part('templates/header/header-3');
                                break;
                            case 'type-4' :
                                get_template_part('templates/header/header-4');
                                break;
                            default :
                                get_template_part('templates/header/header-1');
                                break;
                        }
                    } else {
                        get_template_part('templates/header/header-alter');
                    }
                echo '</header>';
            }
            ?>

            <?php
                if ( neuros_get_prefered_option('top_bar_status') == 'on' ||
                     neuros_get_prefered_option('header_status') == 'on' ) {
                    echo '</div>';
                }
            ?>

            <?php
            // Page Title
            if (neuros_get_prefered_option('page_title_status') == 'on') {
                get_template_part( 'templates/page-title/page-title' );
            }
            ?>

            <?php
                if ( neuros_get_prefered_option('top_bar_status') == 'on' ||
                     neuros_get_prefered_option('header_status') == 'on' || 
                     neuros_get_prefered_option('page_title_status') == 'on' ) {
                    echo '</div>';
                }
            ?>