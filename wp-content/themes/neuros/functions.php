<?php
/*
 * Created by Artureanec
*/

# General
add_theme_support('title-tag');
add_theme_support('automatic-feed-links');
add_theme_support('post-formats', array('image', 'video', 'gallery', 'quote'));
add_theme_support('html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

if( !isset( $content_width ) ) $content_width = 1340;

# ADD Localization Folder
add_action('after_setup_theme', 'neuros_pomo');
if (!function_exists('neuros_pomo')) {
    function neuros_pomo() {
        load_theme_textdomain('neuros', get_template_directory() . '/languages');
    }
}

require_once(get_template_directory() . '/core/helper-functions.php');
require_once(get_template_directory() . '/core/layout-functions.php');
require_once(get_template_directory() . '/core/init.php');

# Register CSS/JS
add_action('wp_enqueue_scripts', 'neuros_css_js');
if (!function_exists('neuros_css_js')) {
    function neuros_css_js() {
        # CSS
        wp_enqueue_style('neuros-theme', get_template_directory_uri() . '/css/theme.css', array(), wp_get_theme()->get('Version'));
        wp_style_add_data('neuros-theme', 'rtl', 'replace'); 

        if (class_exists('WooCommerce')) {
            wp_enqueue_style('neuros-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', array(), wp_get_theme()->get('Version'));
            wp_style_add_data('neuros-woocommerce', 'rtl', 'replace');
            wp_enqueue_style('neuros-style', get_template_directory_uri() . '/style.css', array('neuros-theme', 'neuros-woocommerce'), wp_get_theme()->get('Version') );
        } else {
            wp_enqueue_style('neuros-style', get_template_directory_uri() . '/style.css', array('neuros-theme'), wp_get_theme()->get('Version') );
        }

        # JS
        wp_enqueue_script('jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.min.js', array('jquery'), false, true);
        wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), false, true);
        wp_enqueue_script('isotope', get_template_directory_uri() . '/js/isotope.min.js', array(), false, true );

        wp_register_script('neuros-theme', get_template_directory_uri() . '/js/theme.js', array('jquery', 'owl-carousel', 'isotope'), false, true);
        wp_localize_script( 'neuros-theme', 'ajax_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        wp_enqueue_script('neuros-theme');


        if (is_singular() && comments_open()) {
            wp_enqueue_script('comment-reply');
        }

        wp_localize_script('neuros-theme', 'neuros_ajaxurl',
            array(
                'url' => esc_url(admin_url('admin-ajax.php'))
            )
        );

        $localize_theme = array();
        $localize_theme['rtl'] = (bool)is_rtl();
        wp_localize_script('neuros-theme', 'theme',
            $localize_theme
        );

        # Colors
        require_once(get_template_directory() . "/css/custom/custom.php");

        global $neuros_custom_css;
        wp_add_inline_style('neuros-theme', $neuros_custom_css);
    }
}

# Register CSS/JS for Admin Settings
add_action('admin_enqueue_scripts', 'neuros_admin_css_js');
if (!function_exists('neuros_admin_css_js')) {
    function neuros_admin_css_js() {
        # CSS
        wp_enqueue_style('neuros-admin', get_template_directory_uri() . '/css/admin.css');
        # JS
        wp_enqueue_script('neuros-admin', get_template_directory_uri() . '/js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'), false, true);
    }
}

# Register Google Fonts
add_action('wp_enqueue_scripts', 'neuros_register_theme_fonts');
if (!function_exists('neuros_register_theme_fonts')) {
    function neuros_register_theme_fonts() {
        $fonts_list = array('header_menu_font', 'header_sub_menu_font', 'page_title_heading_font', 'page_title_breadcrumbs_font', 'page_title_additional_text_font', 'main_font', 'additional_font', 'headings_font', 'buttons_font');
        $font_control_list      = get_theme_mod('current_fonts', $fonts_list);
        $current_fonts_array    = array();
        $families               = array();
        $result                 = array();
        foreach ( $font_control_list as $control ) {
            $values = neuros_get_theme_mod($control);
            $values = json_decode($values, true);
            if ( isset($values['font_family']) && !empty($values['font_family']) ) {
                $current_font = array();
                $current_font['font_family'] = $values['font_family'];
                $current_font['font_styles'] = $values['font_styles'];
                $current_font['font_subset'] = $values['font_subset'];
                $current_fonts_array[$control] = $current_font;
            }
        }

        if ( !empty($current_fonts_array) && is_array($current_fonts_array) ) {
            foreach ( $current_fonts_array as $item ) {
                if ( !in_array($item['font_family'], $families) ) {
                    $families[] = $item['font_family'];
                }
            }
            foreach ( $families as $variant ) {
                foreach ( $current_fonts_array as $key => $item ) {
                    if ( $variant == $item['font_family'] ) {
                        $result[$variant]['font_styles'] = empty($result[$variant]['font_styles']) ? $item['font_styles'] : $result[$variant]['font_styles'] . ',' . $item['font_styles'];
                        $result[$variant]['font_subset'] = empty($result[$variant]['font_subset']) ? $item['font_subset'] : $result[$variant]['font_subset'] . ',' . $item['font_subset'];
                    }
                }
            }
            foreach ( $result as $key => $value ) {
                $styles = array_unique(explode(',', $result[$key]['font_styles']));
                asort($styles, SORT_NUMERIC );
                $subset = array_unique(explode(',', $result[$key]['font_subset']));
                asort($subset, SORT_NUMERIC );
                $result[$key]['font_styles'] = implode( ',', $styles );
                $result[$key]['font_subset'] = implode( ',', $subset );
            }
            if ( !empty($result) && is_array($result) ) {
                $fonts = array();
                foreach ( $result as $font_name => $font_params ) {
                    // exclude local fonts
                    if ( $font_name != 'Manrope Alt' ) {
                        $fonts[] = $font_name . ':' . $font_params['font_styles'] . '&subset=' . $font_params['font_subset'];
                    }
                }
                $fonts_url = '//fonts.googleapis.com/css?family=' . urlencode( implode('|', $fonts) );
                wp_enqueue_style('neuros-fonts', $fonts_url);
            }
        }
    }
}

add_action('pre_get_posts', 'neuros_archive_custom_query');
if (!function_exists('neuros_archive_custom_query')) {
    function neuros_archive_custom_query($query) {
        if ( ! is_admin() && $query->is_main_query() ) {
            if(is_post_type_archive('neuros_case_study')) {
                $posts_per_page = neuros_get_theme_mod('case_studies_archive_posts_per_page');
            } elseif(is_post_type_archive('neuros_portfolio')) {
                $posts_per_page = neuros_get_theme_mod('portfolio_archive_posts_per_page');
            } elseif(is_post_type_archive('neuros_project')) {
                $posts_per_page = neuros_get_theme_mod('project_archive_posts_per_page');
            } elseif(is_post_type_archive('neuros_service')) {
                $posts_per_page = neuros_get_theme_mod('service_archive_posts_per_page');
            } elseif(is_post_type_archive('neuros_team_member')) {
                $posts_per_page = neuros_get_theme_mod('team_archive_posts_per_page');
            } elseif(is_post_type_archive('neuros_vacancy')) {
                $posts_per_page = neuros_get_theme_mod('vacancy_archive_posts_per_page');
            }
            if(isset($posts_per_page)) {
                $query->set('posts_per_page', $posts_per_page);
            }            
        }
    }
}

# WP Footer
add_action('wp_footer', 'neuros_wp_footer');
if (!function_exists('neuros_wp_footer')) {
    function neuros_wp_footer() {
        Neuros_Helper::getInstance()->echoFooter();
    }
}

# Register Menu
add_action('init', 'neuros_register_menu');
if (!function_exists('neuros_register_menu')) {
    function neuros_register_menu() {
        register_nav_menus(
            [
                'main'              => esc_html__('Main menu', 'neuros'),
                'footer_menu'       => esc_html__('Footer Menu', 'neuros'),
                'footer_add_menu'   => esc_html__('Footer Additional Menu', 'neuros')
            ]
        );
    }
}


# Register Sidebars
add_action('widgets_init', 'neuros_widgets_init');
if (!function_exists('neuros_widgets_init')) {
    function neuros_widgets_init() {
        register_sidebar(
            array(
                'name'          => esc_html__('Page Sidebar', 'neuros'),
                'id'            => 'sidebar',
                'description'   => esc_html__('Widgets in this area will be shown on all pages.', 'neuros'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title"><span>',
                'after_title'   => '</span></h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Post Sidebar', 'neuros'),
                'id'            => 'sidebar-post',
                'description'   => esc_html__('Widgets in this area will be shown on all posts.', 'neuros'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title"><span>',
                'after_title'   => '</span></h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Career Sidebar', 'neuros'),
                'id'            => 'sidebar-vacancy',
                'description'   => esc_html__('Widgets in this area will be shown on all career pages.', 'neuros'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title"><span>',
                'after_title'   => '</span></h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Service Sidebar', 'neuros'),
                'id'            => 'sidebar-service',
                'description'   => esc_html__('Widgets in this area will be shown on all service pages.', 'neuros'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title"><span>',
                'after_title'   => '</span></h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Case Study Sidebar', 'neuros'),
                'id'            => 'sidebar-case-study',
                'description'   => esc_html__('Widgets in this area will be shown on all case study pages.', 'neuros'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title"><span>',
                'after_title'   => '</span></h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Archive Sidebar', 'neuros'),
                'id'            => 'sidebar-archive',
                'description'   => esc_html__('Widgets in this area will be shown on all posts and archive pages.', 'neuros'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title"><span>',
                'after_title'   => '</span></h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('FAQ Sidebar', 'neuros'),
                'id'            => 'sidebar-faq',
                'description'   => esc_html__('Widgets in this area will be shown on FAQ page.', 'neuros'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title"><span>',
                'after_title'   => '</span></h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Side Panel Sidebar', 'neuros'),
                'id'            => 'sidebar-side',
                'description'   => esc_html__('Widgets in this area will be shown on side panel.', 'neuros'),
                'before_widget' => '<div id="%1$s" class="widget side-widget %2$s"><div class="widget-wrapper side-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title side-widget-title">',
                'after_title'   => '</h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Menu Sidebar', 'neuros'),
                'id'            => 'sidebar-menu',
                'description'   => esc_html__('Widgets in this area will be shown on compact menu panel.', 'neuros'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title"><span>',
                'after_title'   => '</span></h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 1)', 'neuros'),
                'id'            => 'sidebar-footer-style1',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'neuros'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title footer-widget-title">',
                'after_title'   => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 2)', 'neuros'),
                'id'            => 'sidebar-footer-style2',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'neuros'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title footer-widget-title">',
                'after_title'   => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 3)', 'neuros'),
                'id'            => 'sidebar-footer-style3',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'neuros'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title footer-widget-title">',
                'after_title'   => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 4)', 'neuros'),
                'id'            => 'sidebar-footer-style4',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'neuros'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title footer-widget-title">',
                'after_title'   => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 5)', 'neuros'),
                'id'            => 'sidebar-footer-style5',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'neuros'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title footer-widget-title">',
                'after_title'   => '</h6>',
            )
        );

        if (class_exists('WooCommerce')) {
            register_sidebar(
                array(
                    'name'          => esc_html__('Sidebar WooCommerce', 'neuros'),
                    'id'            => 'sidebar-woocommerce',
                    'description'   => esc_html__('Widgets in this area will be shown on Woocommerce Pages.', 'neuros'),
                    'before_widget' => '<div id="%1$s" class="widget wooсommerce-widget %2$s"><div class="widget-wrapper">',
                    'after_widget'  => '</div></div>',
                    'before_title'  => '<h5 class="widget-title"><span>',
                    'after_title'   => '</span></h5>',
                )
            );
        }
    }
}

// Init Custom Widgets
if ( function_exists('neuros_add_custom_widget') ) {
    neuros_add_custom_widget('Neuros_Nav_Menu_Widget');
    neuros_add_custom_widget('Neuros_Special_Text_Widget');
}

// Init Elementor for Custom Post Types
if (!function_exists('neuros_init_elementor_for_team_post_type')) {
    function neuros_init_elementor_for_team_post_type() {
        add_post_type_support('neuros_team_member', 'elementor');
    }
}
add_action('init', 'neuros_init_elementor_for_team_post_type');

if (!function_exists('neuros_init_elementor_for_portfolio_post_type')) {
    function neuros_init_elementor_for_portfolio_post_type() {
        add_post_type_support('neuros_service', 'elementor');
    }
}
add_action('init', 'neuros_init_elementor_for_portfolio_post_type');

//Custom Animation for Elementor
if (!function_exists('neuros_elementor_custom_animation')) {
    function neuros_elementor_custom_animation() {
        return array(
            'Neuros Animation' => [
                'neuros_heading_animation' => 'Heading Animation',
                'neuros_clip_down' => 'Clip Down',
                'neuros_clip_up' => 'Clip Up',
                'neuros_clip_right' => 'Clip Right',
                'neuros_clip_left' => 'Clip Left',
            ]
        );
    }
}
add_filter( 'elementor/controls/animations/additional_animations', 'neuros_elementor_custom_animation' );

# WooCommerce
if (class_exists('WooCommerce')) {
    require_once( get_template_directory() . '/woocommerce/wooinit.php');
}

// Remove standard WP gallery styles
add_filter( 'use_default_gallery_style', '__return_false' );

// Register custom image sizes
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1340, 638, true );
}
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'neuros_post_thumbnail_mobile', 575, 274, array('center', 'center') );
    add_image_size( 'neuros_post_thumbnail_tablet', 991, 472, array('center', 'center') );

    add_image_size( 'neuros_post_grid_2_columns', 960, 718, array('center', 'center') );
    add_image_size( 'neuros_post_grid_3_columns', 640, 478, array('center', 'center') );
    add_image_size( 'neuros_post_grid_4_columns', 500, 374, array('center', 'center') );
    add_image_size( 'neuros_post_grid_5_columns', 384, 287, array('center', 'center') );
    add_image_size( 'neuros_post_grid_6_columns', 320, 239, array('center', 'center') );

    add_image_size( 'neuros_portfolio_thumbnail', 835, 653, array('center', 'center') );
    add_image_size( 'neuros_portfolio_grid_1_columns', 1340, 1340, array('center', 'center') );
    add_image_size( 'neuros_portfolio_grid_2_columns', 960, 960, array('center', 'center') );
    add_image_size( 'neuros_portfolio_grid_3_columns', 640, 640, array('center', 'center') );
    add_image_size( 'neuros_portfolio_grid_4_columns', 500, 500, array('center', 'center') );
    add_image_size( 'neuros_portfolio_grid_5_columns', 384, 384, array('center', 'center') );
    add_image_size( 'neuros_portfolio_grid_6_columns', 320, 320, array('center', 'center') );

    add_image_size( 'neuros_project_modern_1_columns', 1340, 689, array('center', 'center') );

    add_image_size( 'neuros_portfolio_masonry_1_columns', 1920, 1920, array('center', 'center') );
    add_image_size( 'neuros_portfolio_masonry_2_columns', 960, 960, array('center', 'center') );
    add_image_size( 'neuros_portfolio_masonry_3_columns', 640, 640, array('center', 'center') );
    add_image_size( 'neuros_portfolio_masonry_4_columns', 500, 500, array('center', 'center') );
    add_image_size( 'neuros_portfolio_masonry_5_columns', 384, 384, array('center', 'center') );
    add_image_size( 'neuros_portfolio_masonry_6_columns', 320, 320, array('center', 'center') );

    add_image_size( 'neuros_team_thumbnail', 535, 551, array('right', 'center') );
}

//Remove 1536x1536 and 2048x2048 image sizes
if (!function_exists('neuros_remove_image_sizes')) {
    function neuros_remove_image_sizes() {
        remove_image_size('1536x1536');
        remove_image_size('2048x2048');
    }
}
add_action('init', 'neuros_remove_image_sizes');

// Media Upload
if (!function_exists('neuros_enqueue_media')) {
    function neuros_enqueue_media() {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'neuros_enqueue_media' );

// Responsive video
add_filter('embed_oembed_html', 'neuros_wrap_oembed_video', 99, 4);
if (!function_exists('neuros_wrap_oembed_video')) {
    function neuros_wrap_oembed_video($html, $url, $attr, $post_id) {
        return '<div class="video-embed">' . $html . '</div>';
    }
}

// Custom Search form
add_filter('get_search_form', 'neuros_get_search_form', 10, 2);
if ( !function_exists('neuros_get_search_form') ) {
    function neuros_get_search_form($form, $args) {
        $search_rand = mt_rand(0, 999);
        $search_js = 'javascript:document.getElementById("search-' . esc_js($search_rand) . '").submit();';
        $placeholder = ( $args['aria_label'] == 'global' ? esc_attr__('Type Your Search...', 'neuros') : esc_attr__('Search...', 'neuros') );

        $form = '<form name="search_form" method="get" action="' . esc_url(home_url('/')) . '" class="search-form" id="search-' . esc_attr($search_rand) . '">';
            $form .= '<span class="search-form-icon" onclick="' . esc_js($search_js) . '"></span>';
            $form .= '<input type="text" name="s" value="" placeholder="' . esc_attr($placeholder) . '" title="' . esc_attr__('Search', 'neuros') . '" class="search-form-field">';
        $form .= '</form>';

        return $form;
    }
}

// Customize WP Categories Widget
add_filter('wp_list_categories', 'neuros_customize_categories_widget', 10, 2);
if ( !function_exists('neuros_customize_categories_widget') ) {
    function neuros_customize_categories_widget($output, $args) {
        $args['use_desc_for_title'] = false;
        if ( $args['hierarchical'] ) {
            $output = str_replace('"cat-item', '"cat-item cat-item-hierarchical', $output);
        }

        return $output;
    }
}

// Add Buttons to Tiny MCE text editor
add_action( 'init', 'neuros_tiny_mce_background_color' );
if ( !function_exists('neuros_tiny_mce_background_color') ) {
    function neuros_tiny_mce_background_color() {
        add_filter('mce_buttons_2', 'neuros_tiny_mce_background_color_button', 999, 1);
    }
}
if ( !function_exists('neuros_tiny_mce_background_color_button') ) {
    function neuros_tiny_mce_background_color_button($buttons) {
        array_unshift($buttons, 'fontsizeselect');
        array_splice($buttons, 4, 0, 'backcolor');
        return $buttons;
    }
}
if ( !function_exists('neuros_tinymce_fontsize') ) {
    function neuros_tinymce_fontsize($sizes) {
        $sizes['fontsize_formats'] = "10px 14px 16px 20px 24px 28px 32px 36px 40px 46px 50px";
        return $sizes;
    }
}
add_filter('tiny_mce_before_init', 'neuros_tinymce_fontsize');

// Customize Comment fields
add_filter('comment_form_defaults', 'neuros_customize_comment_fields');
if ( !function_exists('neuros_customize_comment_fields') ) {
    function neuros_customize_comment_fields($args) {
        $format = current_theme_supports('html5', 'comment-form') ? 'html5' : 'xhtml';
        $commenter          = wp_get_current_commenter();
        $req                = get_option( 'require_name_email' );
        $html5              = 'html5' === $format;

        $html_req           = ( $html5 ? ' required' : ' required="required"' );
        $html_consent       = ( $html5 ? ' checked' : ' checked="checked"' );
        $consent            = empty( $commenter['comment_author_email'] ) ? '' : esc_attr($html_consent);
        $comment_form_args  = array(
            'title_reply'           => esc_html__('Leave a Comment', 'neuros'),
                'cancel_reply_link'     => esc_html__('(Cancel reply)', 'neuros'),
                'title_reply_to'        => esc_html__('Leave a Reply to %s', 'neuros'),
                'title_reply_before'    => '<h4 id="reply-title" class="comment-reply-title">',
                'title_reply_after'     => '</h4>',
                'fields'                => array(
                    'author'    => sprintf('<div class="form-fields"><div class="form-field form-name"><input placeholder="'. esc_attr__('Full name', 'neuros'). ( $req ? '*' : '' ) . '" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"%s/></div>', ( $req ? $html_req : '' )),
                    'email'     => sprintf('<div class="form-field form-email"><input placeholder="' . esc_attr__('Email', 'neuros') . ( $req ? '*' : '' ) . '" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"%s/></div>', ( $req ? $html_req : '' )),
                    'cookies'   => '<div class="form-field form-cookies comment-form-cookies-consent">'.
                                         sprintf( '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />', $consent ) . '
                                         <label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'neuros' ) . '</label>
                                    </div></div>',
                ),
                'comment_field'         => '<div class="form-field form-message"><textarea name="comment" cols="45" rows="6" placeholder="' . esc_attr__('Message', 'neuros') . '" id="comment-message"></textarea></div>',
                'label_submit'          => esc_html__('Send a message', 'neuros'),
                'logged_in_as'          => '<p><a class="logged-in-as">' . esc_html__('Logged in as ', 'neuros') . '<a href="' . esc_url(admin_url( 'profile.php' )) . '">' . esc_html(wp_get_current_user()->display_name) . '</a>. ' . '<a href="' . wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) . '">' . esc_html__('Log out?', 'neuros') . '</a>' . '</p>',
                'submit_button'         => '<button name="%1$s" id="%2$s" class="%3$s">%4$s<span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span></button>',
                'submit_field'          => '%1$s %2$s',
                'format' => $format
            );

        return $comment_form_args;
    }
}    

// Move Comment Message field in Comment form
add_filter( 'comment_form_fields', 'neuros_move_comment_fields' );
if ( !function_exists('neuros_move_comment_fields') ) {
    function neuros_move_comment_fields($fields) {
        if ( !function_exists('is_product') || !is_product() ) {
            $comment_field = $fields['comment'];
            $cookies_field = $fields['cookies'];
            unset($fields['comment']);
            unset($fields['cookies']);
            $fields['comment'] = $comment_field;
            $fields['cookies'] = $cookies_field;
        }
        return $fields;
    }
}

// WPForms Plugin Dropdown Menu Fix
if ( function_exists( 'wpforms') ) {
    add_action( 'wpforms_display_field_select', 'neuros_wpform_start_select_wrapper', 5, 1 );
    if ( !function_exists('neuros_wpform_start_select_wrapper') ) {
        function neuros_wpform_start_select_wrapper($field) {
            echo '<div class="select-wrap' . (isset($field['multiple']) && !empty($field['multiple']) ? ' multiple' : '') . (!empty($field['size']) && isset($field['size']) ? ' wpforms-field-' . esc_attr($field['size']) : '') . '">';
        }
    }
    add_action( 'wpforms_display_field_select', 'neuros_wpform_finish_select_wrapper', 15 );
    if ( !function_exists('neuros_wpform_finish_select_wrapper') ) {
        function neuros_wpform_finish_select_wrapper() {
            echo '</div>';
        }
    }
}

// Custom Password Form
add_filter( 'the_password_form', 'neuros_password_form' );
if ( !function_exists('neuros_password_form') ) {
    function neuros_password_form() {
        global $post;
        $out = '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" class="post-password-form" method="post"><p>' . esc_html__('This content is password protected. To view it please enter your password below:', 'neuros') . '</p><p><label for="password"><input name="post_password" id="password" type="password" placeholder="' . esc_attr__('Password', 'neuros') . '" size="20" required /></label><button name="Submit">' . esc_html__('Enter', 'neuros') . '</button></p></form>';
        return $out;
    }
}

// Set Elementor Features Default Values
add_action( 'elementor/experiments/feature-registered', 'neuros_elementor_features_set_default', 10, 2 );
if ( !function_exists('neuros_elementor_features_set_default') ) {
    function neuros_elementor_features_set_default( Elementor\Core\Experiments\Manager $experiments_manager ) {
        $experiments_manager->set_feature_default_state('e_dom_optimization', 'inactive');
    }
}

// Set custom palette in customizer colorpicker
add_action( 'customize_controls_enqueue_scripts', 'neuros_custom_color_palette' );
if ( !function_exists('neuros_custom_color_palette') ) {
    function neuros_custom_color_palette() {
        $color_palettes = json_encode(neuros_get_custom_color_palette());
        wp_add_inline_script('wp-color-picker', 'jQuery.wp.wpColorPicker.prototype.options.palettes = ' . sprintf('%s', $color_palettes) . ';');
    }
}

// Filter for widgets
add_filter( 'dynamic_sidebar_params', 'neuros_dynamic_sidebar_params' );
if (!function_exists('neuros_dynamic_sidebar_params')) {
    function neuros_dynamic_sidebar_params($sidebar_params) {
        if (is_admin()) {
            return $sidebar_params;
        }
        global $wp_registered_widgets;
        $widget_id = $sidebar_params[0]['widget_id'];
        $wp_registered_widgets[$widget_id]['original_callback'] = $wp_registered_widgets[$widget_id]['callback'];
        $wp_registered_widgets[$widget_id]['callback'] = 'neuros_widget_callback_function';

        return $sidebar_params;
    }
}
add_filter( 'widget_output', 'neuros_output_filter', 10, 3 );
if (!function_exists('neuros_output_filter')) {
    function neuros_output_filter($widget_output, $widget_id_base, $widget_id) {
        if ($widget_id_base != 'woocommerce_product_categories' && $widget_id_base != 'wpforms-widget' && $widget_id_base != 'block') {
            $widget_output = str_replace('<select', '<div class="select-wrap"><select', $widget_output);
            $widget_output = str_replace('</select>', '</select></div>', $widget_output);
        }

        return $widget_output;
    }
}

// Admin Footer
add_filter('admin_footer', 'neuros_admin_footer');
if (!function_exists('neuros_admin_footer')) {
    function neuros_admin_footer() {
        if (strlen(get_page_template_slug())>0) {
            echo "<input type='hidden' name='' value='" . (get_page_template_slug() ? get_page_template_slug() : '') . "' class='neuros_this_template_file'>";
        }
    }
}

// Remove post format parameter
add_filter('preview_post_link', 'neuros_remove_post_format_parameter', 9999);
if (!function_exists('neuros_remove_post_format_parameter')) {
    function neuros_remove_post_format_parameter($url) {
        $url = remove_query_arg('post_format', $url);
        return $url;
    }
}

// Post excerpt customize
add_filter( 'excerpt_length', function() {
    return 41;
} );
add_filter( 'excerpt_more', function(){
    return '...';
} );

// Wrap pagination links
add_filter( 'paginate_links_output', 'neuros_wrap_pagination_links', 10, 2 );
if ( !function_exists('neuros_wrap_pagination_links') ) {
    function neuros_wrap_pagination_links($template, $args) {
        if(class_exists('WooCommerce') && (is_shop() || is_product_category() || is_product_taxonomy() || is_product_tag() || wc_get_loop_prop('is_shortcode'))) {
            $template = '<nav class="navigation pagination" role="navigation">' .
                '<h2 class="screen-reader-text">' . esc_html__('Pagination', 'neuros') . '</h2>' .
                '<div class="nav-links">' . 
                    $template . 
                '</div>' .
            '</nav>';
        }
        return $template;
    }
}

//Add Ajax Actions
add_action('wp_ajax_pagination', 'ajax_pagination');
add_action('wp_ajax_nopriv_pagination', 'ajax_pagination');

//Construct Loop & Results
function ajax_pagination() {
    $query_data         = $_POST;

    $paged              = ( isset($query_data['paged']) ) ? intval($query_data['paged']) : 1;
    $filter_term        = ( isset($query_data['filter_term']) ) ? $query_data['filter_term'] : null;
    $filter_taxonomy    = ( isset($query_data['filter_taxonomy']) ) ? $query_data['filter_taxonomy'] : null;
    $args               = ( isset($query_data['args']) ) ? json_decode(stripslashes($query_data['args']), true) : array();
    $args               = array_merge($args, array( 'paged' => sanitize_key($paged) ));
    if ( !empty($filter_term) && !empty($filter_taxonomy) && $filter_term != 'all' ) {
        $args   = array_merge($args, array( sanitize_key($filter_taxonomy) => sanitize_key($filter_term) ));
    }
    $post_type          = isset($args['post_type']) ? $args['post_type'] : 'post';
    $widget             = ( isset($query_data['widget']) ) ? json_decode(stripslashes($query_data['widget']), true) : array();
    $listing_type       = isset($widget['listing_type']) ? $widget['listing_type'] : '';
    $query              = new WP_Query($args);

    $wrapper_class      = isset($query_data['classes']) ? $query_data['classes'] : '';
    $id                 = isset($query_data['id']) ? $query_data['id'] : '';
    $link_base          = isset($args['link_base']) ? $args['link_base'] : '';

    echo '<div class="' . esc_attr($wrapper_class) . '">';
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('content', $post_type, $widget);
        };
        if ( $listing_type == 'masonry') {
            echo '<div class="grid-sizer"></div>';
        }
        wp_reset_postdata();
    echo '</div>';

    if(isset($widget['show_pagination']) && $widget['show_pagination'] == 'yes' && $query->max_num_pages > 1) {
        echo '<div class="content-pagination">';
            echo '<nav class="navigation pagination" role="navigation">';
                echo '<h2 class="screen-reader-text">' . esc_html__('Pagination', 'neuros') . '</h2>';
                echo '<div class="nav-links">';
                    echo paginate_links( array(
                        'base'      => $link_base . '/?' . esc_attr($id) . '-paged=%#%',
                        'current'   => max( 1, $paged ),
                        'total'     => $query->max_num_pages,
                        'end_size'  => 2,
                        'before_page_number' => '<span class="button-inner"></span>',
                        'prev_text' => esc_html__('Previous', 'neuros') . '<span class="button-inner"></span><span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span>',
                        'next_text' => esc_html__('Next', 'neuros') . '<span class="button-inner"></span><span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span>',                        
                        'add_args'  => false
                    ) );
                echo '</div>';
            echo '</nav>';
        echo '</div>';
    }

    die();
}

// Customize WP-Blocks Output
if ( !function_exists('neuros_wpblock_widget_render') ) {
    function neuros_wpblock_widget_render($block_content, $block) {

        if ( $block['blockName'] == 'core/file' ) {
            $block_content = str_replace('</a></div>', '<span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span></a></div>', $block_content);
        }

        if ( $block['blockName'] == 'core/list' ) {
            $classes = 'wp-block-list';
            if(!empty($block['attrs']['fontSize'])) {
                $classes .= ' has-' . $block['attrs']['fontSize'] . '-font-size';
            }
            if(!empty($block['attrs']['textColor'])) {
                $classes .= ' has-text-color has-' . $block['attrs']['textColor'] . '-color';
            }
            if(!empty($block['attrs']['backgroundColor'])) {
                $classes .= ' has-background has-' . $block['attrs']['backgroundColor'] . '-background-color';
            }
            if(!empty($block['attrs']['style']['color']['background'])) {
                $classes .= ' has-background';
            }
            
            $block_content = str_replace('<ul', '<ul class="' . esc_attr($classes) . '"', $block_content);
        }

        if (
            isset($block['attrs']['displayAsDropdown']) && $block['attrs']['displayAsDropdown'] === true
        ) {
            $block_content = str_replace('<select', '<div class="select-wrap"><select', $block_content);
            $block_content = str_replace('</select>', '</select></div>', $block_content);
        }

        if ( $block['blockName'] == 'core/button' ) {
            if(strpos($block['innerHTML'], 'is-style-outline') === false && strpos($block['innerHTML'], 'is-style-fill') === false) {
                $block_content = str_replace('</a>', '<span class="button-inner"></span></a>', $block_content);
            }
        }

        if (
            ( $block['blockName'] == 'core/search') ||
            ( $block['blockName'] == 'woocommerce/product-search' )
        ) {
            $block_content = str_replace('</button>', '<span class="button-inner"></span></button>', $block_content);
        }

        if (
            ( $block['blockName'] == 'core/search' && isset($block['attrs']['buttonUseIcon']) && $block['attrs']['buttonUseIcon'] === true ) ||
            ( $block['blockName'] == 'woocommerce/product-search' )
        ) {
            $block_content = preg_replace('/<svg\s+.*(<\/svg>)/s', '', $block_content);
        }

        if ( $block['blockName'] == 'core/loginout' && isset($block['attrs']['displayLoginAsForm']) && $block['attrs']['displayLoginAsForm'] === true ) {
            $block_content = str_replace('id="user_login"', 'id="user_login" placeholder="' . esc_html__('Username or Email Address', 'neuros') . '"', $block_content);
            $block_content = str_replace('id="user_pass"', 'id="user_pass" placeholder="' . esc_html__('Password', 'neuros') . '"', $block_content);
            $block_content = preg_replace('/<label for.*<\/label>/', '', $block_content);
        }

        if (
            $block['blockName'] == 'core/latest-posts'
        ) {
            if ( isset($block['attrs']['displayFeaturedImage']) && $block['attrs']['displayFeaturedImage'] == true && isset($block['attrs']['featuredImageAlign']) && ($block['attrs']['featuredImageAlign'] == 'left' || $block['attrs']['featuredImageAlign'] == 'right') ) {
                $block_content = str_replace('<a class="wp-block-latest-posts__post-title', '<div class="wp-block-latest-posts__content"><a class="wp-block-latest-posts__post-title', $block_content);
                $block_content = str_replace('</li>', '</div></li>', $block_content);
            }
        }

        return $block_content;
    }
}

add_filter( 'render_block', 'neuros_wpblock_widget_render', 10, 2 );

// Adding New Style to WP Blocks
if ( !function_exists('filter_metadata_registration') ) {
    function filter_metadata_registration($metadata) {        
        if ( $metadata['name'] == 'core/button' ) {
            $styles_button = [
                [
                    'name'      => 'fill',
                    'label'     => esc_html__('Fill', 'neuros')
                ],
                [
                    'name'      => 'outline',
                    'label'     => esc_html__('Outline', 'neuros'),
                ],
                [
                    'name'      => 'mixed',
                    'label'     => esc_html__('Mixed', 'neuros'),
                    'isDefault' => true
                ],
            ];
            $metadata['styles'] = $styles_button;
        }
        return $metadata;
    }
}
add_filter( 'block_type_metadata', 'filter_metadata_registration', 10, 2 );

if( class_exists( 'Mega_Menu' ) ) {

	function megamenu_add_theme_neuros_1731088309($themes) {
	    $themes["neuros_1731088309"] = array(
	        'title' => 'Neuros',
	        'container_background_from' => 'rgba(0, 0, 0, 0)',
	        'container_background_to' => 'rgba(0, 0, 0, 0)',
	        'menu_item_align' => 'center',
	        'menu_item_background_from' => 'rgba(0, 0, 0, 0)',
	        'menu_item_background_hover_from' => 'rgb(240, 242, 244)',
	        'menu_item_background_hover_to' => 'rgb(240, 242, 244)',
	        'menu_item_spacing' => '17px',
	        'menu_item_link_color' => 'rgb(51, 51, 51)',
	        'menu_item_link_weight' => 'bold',
	        'menu_item_link_text_transform' => 'uppercase',
	        'menu_item_link_color_hover' => 'rgb(51, 51, 51)',
	        'menu_item_link_weight_hover' => 'bold',
	        'menu_item_link_padding_left' => '22px',
	        'menu_item_link_padding_right' => '21px',
	        'menu_item_link_border_radius_top_left' => '9999px',
	        'menu_item_link_border_radius_top_right' => '9999px',
	        'menu_item_link_border_radius_bottom_left' => '9999px',
	        'menu_item_link_border_radius_bottom_right' => '9999px',
	        'panel_background_from' => 'rgb(31, 31, 31)',
	        'panel_background_to' => 'rgb(31, 31, 31)',
	        'panel_width' => '850px',
	        'panel_border_radius_top_left' => '20px',
	        'panel_border_radius_top_right' => '20px',
	        'panel_border_radius_bottom_left' => '20px',
	        'panel_border_radius_bottom_right' => '20px',
	        'panel_header_color' => 'rgb(245, 245, 245)',
	        'panel_header_text_transform' => 'none',
	        'panel_padding_left' => '37px',
	        'panel_padding_right' => '31px',
	        'panel_padding_top' => '25px',
	        'panel_padding_bottom' => '25px',
	        'panel_widget_padding_left' => '0px',
	        'panel_widget_padding_right' => '0px',
	        'panel_widget_padding_top' => '0px',
	        'panel_widget_padding_bottom' => '0px',
	        'panel_font_size' => '14px',
	        'panel_font_color' => 'rgb(245, 245, 245)',
	        'panel_font_family' => 'inherit',
	        'panel_second_level_font_color' => 'rgb(245, 245, 245)',
	        'panel_second_level_font_color_hover' => 'rgb(241, 79, 68)',
	        'panel_second_level_text_transform' => 'none',
	        'panel_second_level_font' => 'inherit',
	        'panel_second_level_font_size' => '17px',
	        'panel_second_level_font_weight' => 'normal',
	        'panel_second_level_font_weight_hover' => 'normal',
	        'panel_second_level_text_decoration' => 'none',
	        'panel_second_level_text_decoration_hover' => 'none',
	        'panel_second_level_padding_right' => '20px',
	        'panel_second_level_padding_top' => '10px',
	        'panel_second_level_padding_bottom' => '10px',
	        'panel_third_level_font_color' => 'rgb(245, 245, 245)',
	        'panel_third_level_font_color_hover' => 'rgb(241, 79, 68)',
	        'panel_third_level_font' => 'inherit',
	        'panel_third_level_font_size' => '14px',
	        'panel_third_level_padding_right' => '20px',
	        'panel_third_level_padding_top' => '10px',
	        'panel_third_level_padding_bottom' => '10px',
	        'flyout_width' => '265px',
	        'flyout_menu_background_from' => 'rgb(31, 31, 31)',
	        'flyout_menu_background_to' => 'rgb(31, 31, 31)',
	        'flyout_border_radius_top_left' => '20px',
	        'flyout_border_radius_top_right' => '20px',
	        'flyout_border_radius_bottom_left' => '20px',
	        'flyout_border_radius_bottom_right' => '20px',
	        'flyout_padding_top' => '25px',
	        'flyout_padding_bottom' => '25px',
	        'flyout_link_padding_left' => '37px',
	        'flyout_link_padding_right' => '31px',
	        'flyout_link_padding_top' => '10px',
	        'flyout_link_padding_bottom' => '10px',
	        'flyout_link_height' => '25px',
	        'flyout_background_from' => 'rgba(241, 241, 241, 0)',
	        'flyout_background_to' => 'rgba(241, 241, 241, 0)',
	        'flyout_background_hover_from' => 'rgba(241, 241, 241, 0)',
	        'flyout_background_hover_to' => 'rgba(241, 241, 241, 0)',
	        'flyout_link_size' => '17px',
	        'flyout_link_color' => 'rgb(245, 245, 245)',
	        'flyout_link_color_hover' => 'rgb(241, 79, 68)',
	        'flyout_link_family' => 'inherit',
	        'responsive_breakpoint' => '1364px',
	        'line_height' => '1.5',
	        'transitions' => 'on',
	        'toggle_background_from' => '#222',
	        'toggle_background_to' => '#222',
	        'mobile_menu_padding_left' => '40px',
	        'mobile_menu_padding_right' => '40px',
	        'mobile_menu_padding_top' => '25px',
	        'mobile_menu_item_height' => '34px',
	        'mobile_background_from' => 'rgba(241, 241, 241, 0)',
	        'mobile_background_to' => 'rgba(241, 241, 241, 0)',
	        'mobile_menu_item_link_font_size' => '14px',
	        'mobile_menu_item_link_color' => 'rgb(51, 51, 51)',
	        'mobile_menu_item_link_text_align' => 'left',
	        'mobile_menu_item_link_color_hover' => 'rgb(241, 79, 68)',
	        'mobile_menu_item_background_hover_from' => 'rgba(241, 241, 241, 0)',
	        'mobile_menu_item_background_hover_to' => 'rgba(241, 241, 241, 0)',
	        'disable_mobile_toggle' => 'on',
	        'custom_css' => '/** Push menu onto new line **/ 
			#{$wrap} { 
			    clear: both;
				width: 100%;
				text-align: center;
			}
			#{$wrap} #{$menu} > li.mega-menu-item:last-child {
				margin: 0;
			}
			#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu,
			#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu {
				top: 100%;
			}
			#{$wrap} #{$menu} li.mega-align-bottom-left.mega-toggle-on > a.mega-menu-link {
				@include border-radius( $menu_item_link_border_radius_top_left, $menu_item_link_border_radius_top_right, $menu_item_link_border_radius_bottom_right, $menu_item_link_border_radius_bottom_left);
			}
			#{$wrap} #{$menu} li.mega-align-bottom-right.mega-toggle-on > a.mega-menu-link {
				@include border-radius( $menu_item_link_border_radius_top_left, $menu_item_link_border_radius_top_right, $menu_item_link_border_radius_bottom_right, $menu_item_link_border_radius_bottom_left);
			}
			/* Apply Hover Styling to active Mega Menu - Second Level Links */
			#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link,
			#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link {
			    color: $panel_second_level_font_color_hover;
			    font-weight: $panel_second_level_font_weight_hover;
			    text-decoration: $panel_second_level_text_decoration_hover;
			    @include background($panel_second_level_background_hover_from, $panel_second_level_background_hover_to);
			}
			 
			/* Apply Hover Styling to active Mega Menu - Third Level Links */
			#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item.mega-current-menu-item > a.mega-menu-link,
			#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item.mega-current-menu-item > a.mega-menu-link {
			    color: $panel_third_level_font_color_hover;
			    font-weight: $panel_third_level_font_weight_hover;
			    text-decoration: $panel_third_level_text_decoration_hover;
			    @include background($panel_third_level_background_hover_from, $panel_third_level_background_hover_to);
			}
			/* Apply Hover Styling to active Flyout Links and ancestors */
			#{$wrap} #{$menu} li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-menu-item > a.mega-menu-link,
			#{$wrap} #{$menu} li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link,
			#{$wrap} #{$menu} li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link {
			    @include background($flyout_background_hover_from, $flyout_background_hover_to);
			    font-weight: $flyout_link_weight_hover;
			    text-decoration: $flyout_link_text_decoration_hover;
			    color: $flyout_link_color_hover;
			}
			@include desktop {
				#{$wrap} #{$menu} > li.mega-menu-item {
					padding: 13px 0;
				}
				#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item ul.mega-sub-menu {
					top: -25px;
					margin: 0 0 0 1px;
				}
				#{$wrap} #{$menu} > li.mega-menu-item {
					&.mega-current-menu-item,
					&.mega-current-menu-ancestor,
					&.mega-current-page-ancestor {
						 > a.mega-menu-link {
							 background: #333;
							 color: #f5f5f5;					 
						}
					}
				}
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-item > a.mega-menu-link,
				#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link {
					transition: all .3s;
				}
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-item > a.mega-menu-link:before,
				#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link:before {
					content: \"\\\e82b\";
					font: 400 normal 5px / 5px \"fontello\";
					line-height: 25.5px;
					bottom: 6px;
					position: absolute;
					display: block;
					left: 0;
					right: initial;
					width: 16px;
					opacity: 0;
					-webkit-transition: opacity 0.4s;
					transition: opacity 0.4s;
				}
				#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link:before {
					left: 36px;
				}
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-item:hover > a.mega-menu-link,
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-item.mega-current-menu-item > a.mega-menu-link {
					padding: 10px 0px 10px 16px !important;
					&:before {
						opacity: 1;
					}
				}
				#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item:hover > a.mega-menu-link,
				#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-menu-item a.mega-menu-link{
					padding: 10px 31px 10px 53px !important;
					&:before {
						opacity: 1;
					}
				}
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-item-has-children > a.mega-menu-link > span.mega-indicator:after,
				#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item-has-children > a.mega-menu-link > span.mega-indicator:after {
					position: relative;
					bottom: 2px;
					content: \"\\\e801\" !important;
					font: 400 normal 5px / 5px \"fontello\";
					width: auto;
					height: 1em;
					text-align: center;
					-webkit-transition: transform 0.3s;
					transition: transform 0.3s;
				}
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-item-has-children:hover > a.mega-menu-link > span.mega-indicator:after,
				#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item-has-children:hover > a.mega-menu-link > span.mega-indicator:after {
					-webkit-transform: rotate(-90deg);
					-ms-transform: rotate(-90deg);
					transform: rotate(-90deg);
				}
				
				/* Animated top menu items */
				#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link {
					overflow: hidden;
				}
				#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link > span.text-active {
					display: inline-block;
					-webkit-transition: transform 0.3s, opacity 0.3s;
					transition: transform 0.3s, opacity 0.3s;
				}
				#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link:hover > span.text-active {
					opacity: 0;
					-webkit-transform: translateY(-150%);
					-ms-transform: translateY(-150%);
					transform: translateY(-150%);
				}
				#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link > span:not(.text-active):not(.mega-indicator) {
					position: absolute;
					padding: inherit;
					left: 0;
					top: 0;
					opacity: 0;
					-webkit-transition: transform 0.3s, opacity 0.3s;
					transition: transform 0.3s, opacity 0.3s;
					-webkit-transform: translateY(150%);
					-ms-transform: translateY(150%);
					transform: translateY(150%);
				}
				#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link:hover > span:not(.text-active):not(.mega-indicator) {
					opacity: 1;
					-webkit-transform: translateY(0);
					-ms-transform: translateY(0);
					transform: translateY(0);
				}
			}

			@include mobile {
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link, 
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link,
				#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link,
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link, 		
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link {
					font-size: 16px;
					font-weight: 600;
					padding: 8px 0;
					color: $mobile_menu_item_link_color;
			    }
				#{$wrap} #{$menu} > li.mega-menu-item a.mega-menu-link:hover,
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link, 
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link,
				#{$wrap} #{$menu} li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-menu-item > a.mega-menu-link, 
				#{$wrap} #{$menu} li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link, 
				#{$wrap} #{$menu} li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link,
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:hover, 
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:focus, 
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:hover, 
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:focus,
				#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link:hover,
				#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link:focus {
					font-weight: 600;
					color: $mobile_menu_item_link_color_hover;
			}
				#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link {
					font-weight: 700;
					padding: 0;
				}
				#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu,
				#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu {
					background: transparent;
				}
				#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu,
				#{$wrap} #{$menu} li.mega-menu-megamenu > ul.mega-sub-menu {
					padding: 5px 0 0 20px;
				}
				#{$wrap} #{$menu} li.mega-menu-item-has-children > a.mega-menu-link > span.mega-indicator:after {
					content: \"\\\e82b\" !important;
					font: 400 normal 5px / 20px \"fontello\";
		    		line-height: inherit;
				}
				#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu > li.mega-menu-item h4.mega-block-title,
				#{$wrap} #{$menu} > li.mega-menu-megamenu ul.mega-sub-menu > li.mega-menu-item h4.mega-block-title, 
				#{$wrap} #{$menu} > li.mega-menu-megamenu ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item h4.mega-block-title {
					color: $mobile_menu_item_link_color;
				}
			}

		/* Theme icon styles */

		@include desktop {
			#{$wrap} #{$menu} li.mega-menu-item-has-children > a.mega-menu-link > span.mega-indicator {
			    margin: 0 0 0 11px;
			}
			#{$wrap} #{$menu} li.mega-menu-item-has-children > a.mega-menu-link > span.mega-indicator:after {
				font: 400 normal 5px \"fontello\";
				line-height: inherit;
				content: \"\\\e82b\" !important;
				vertical-align: baseline;
				bottom: 2px;
			}
		}',
	    );
    return $themes;
    }
    add_filter("megamenu_themes", "megamenu_add_theme_neuros_1731088309");

    function megamenu_add_theme_neuros_dark_1731522988($themes) {
        $themes["neuros_dark_1731522988"] = array(
	        'title' => 'Neuros Dark',
	        'container_background_from' => 'rgba(0, 0, 0, 0)',
	        'container_background_to' => 'rgba(0, 0, 0, 0)',
	        'menu_item_align' => 'center',
	        'menu_item_background_from' => 'rgba(0, 0, 0, 0)',
	        'menu_item_background_hover_from' => 'rgb(51, 51, 51)',
	        'menu_item_background_hover_to' => 'rgb(51, 51, 51)',
	        'menu_item_spacing' => '17px',
	        'menu_item_link_color' => 'rgb(255, 255, 255)',
	        'menu_item_link_weight' => 'bold',
	        'menu_item_link_text_transform' => 'uppercase',
	        'menu_item_link_color_hover' => 'rgb(255, 255, 255)',
	        'menu_item_link_weight_hover' => 'bold',
	        'menu_item_link_padding_left' => '22px',
	        'menu_item_link_padding_right' => '21px',
	        'menu_item_link_border_radius_top_left' => '9999px',
	        'menu_item_link_border_radius_top_right' => '9999px',
	        'menu_item_link_border_radius_bottom_left' => '9999px',
	        'menu_item_link_border_radius_bottom_right' => '9999px',
	        'panel_background_from' => 'rgb(31, 31, 31)',
	        'panel_background_to' => 'rgb(31, 31, 31)',
	        'panel_width' => '850px',
	        'panel_border_radius_top_left' => '20px',
	        'panel_border_radius_top_right' => '20px',
	        'panel_border_radius_bottom_left' => '20px',
	        'panel_border_radius_bottom_right' => '20px',
	        'panel_header_color' => 'rgb(245, 245, 245)',
	        'panel_header_text_transform' => 'none',
	        'panel_padding_left' => '37px',
	        'panel_padding_right' => '31px',
	        'panel_padding_top' => '25px',
	        'panel_padding_bottom' => '25px',
	        'panel_widget_padding_left' => '0px',
	        'panel_widget_padding_right' => '0px',
	        'panel_widget_padding_top' => '0px',
	        'panel_widget_padding_bottom' => '0px',
	        'panel_font_size' => '14px',
	        'panel_font_color' => 'rgb(245, 245, 245)',
	        'panel_font_family' => 'inherit',
	        'panel_second_level_font_color' => 'rgb(245, 245, 245)',
	        'panel_second_level_font_color_hover' => 'rgb(241, 79, 68)',
	        'panel_second_level_text_transform' => 'none',
	        'panel_second_level_font' => 'inherit',
	        'panel_second_level_font_size' => '17px',
	        'panel_second_level_font_weight' => 'normal',
	        'panel_second_level_font_weight_hover' => 'normal',
	        'panel_second_level_text_decoration' => 'none',
	        'panel_second_level_text_decoration_hover' => 'none',
	        'panel_second_level_padding_right' => '20px',
	        'panel_second_level_padding_top' => '10px',
	        'panel_second_level_padding_bottom' => '10px',
	        'panel_third_level_font_color' => 'rgb(245, 245, 245)',
	        'panel_third_level_font_color_hover' => 'rgb(241, 79, 68)',
	        'panel_third_level_font' => 'inherit',
	        'panel_third_level_font_size' => '14px',
	        'panel_third_level_padding_right' => '20px',
	        'panel_third_level_padding_top' => '10px',
	        'panel_third_level_padding_bottom' => '10px',
	        'flyout_width' => '265px',
	        'flyout_menu_background_from' => 'rgb(31, 31, 31)',
	        'flyout_menu_background_to' => 'rgb(31, 31, 31)',
	        'flyout_border_radius_top_left' => '20px',
	        'flyout_border_radius_top_right' => '20px',
	        'flyout_border_radius_bottom_left' => '20px',
	        'flyout_border_radius_bottom_right' => '20px',
	        'flyout_padding_top' => '25px',
	        'flyout_padding_bottom' => '25px',
	        'flyout_link_padding_left' => '37px',
	        'flyout_link_padding_right' => '31px',
	        'flyout_link_padding_top' => '10px',
	        'flyout_link_padding_bottom' => '10px',
	        'flyout_link_height' => '25px',
	        'flyout_background_from' => 'rgba(241, 241, 241, 0)',
	        'flyout_background_to' => 'rgba(241, 241, 241, 0)',
	        'flyout_background_hover_from' => 'rgba(241, 241, 241, 0)',
	        'flyout_background_hover_to' => 'rgba(241, 241, 241, 0)',
	        'flyout_link_size' => '17px',
	        'flyout_link_color' => 'rgb(245, 245, 245)',
	        'flyout_link_color_hover' => 'rgb(241, 79, 68)',
	        'flyout_link_family' => 'inherit',
	        'responsive_breakpoint' => '1364px',
	        'line_height' => '1.5',
	        'transitions' => 'on',
	        'toggle_background_from' => '#222',
	        'toggle_background_to' => '#222',
	        'mobile_menu_padding_left' => '40px',
	        'mobile_menu_padding_right' => '40px',
	        'mobile_menu_padding_top' => '25px',
	        'mobile_menu_item_height' => '34px',
	        'mobile_background_from' => 'rgba(241, 241, 241, 0)',
	        'mobile_background_to' => 'rgba(241, 241, 241, 0)',
	        'mobile_menu_item_link_font_size' => '14px',
	        'mobile_menu_item_link_color' => 'rgb(255, 255, 255)',
	        'mobile_menu_item_link_text_align' => 'left',
	        'mobile_menu_item_link_color_hover' => 'rgb(241, 79, 68)',
	        'mobile_menu_item_background_hover_from' => 'rgba(241, 241, 241, 0)',
	        'mobile_menu_item_background_hover_to' => 'rgba(241, 241, 241, 0)',
	        'disable_mobile_toggle' => 'on',
	        'custom_css' => '/** Push menu onto new line **/ 
	            #{$wrap} { 
	                clear: both;
	                width: 100%;
	                text-align: center;
	            }
	            #{$wrap} #{$menu} > li.mega-menu-item:last-child {
	                margin: 0;
	            }
	            #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu,
	            #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu {
	                top: 100%;
	            }
	            #{$wrap} #{$menu} li.mega-align-bottom-left.mega-toggle-on > a.mega-menu-link {
	                @include border-radius( $menu_item_link_border_radius_top_left, $menu_item_link_border_radius_top_right, $menu_item_link_border_radius_bottom_right, $menu_item_link_border_radius_bottom_left);
	            }
	            #{$wrap} #{$menu} li.mega-align-bottom-right.mega-toggle-on > a.mega-menu-link {
	                @include border-radius( $menu_item_link_border_radius_top_left, $menu_item_link_border_radius_top_right, $menu_item_link_border_radius_bottom_right, $menu_item_link_border_radius_bottom_left);
	            }
	            /* Apply Hover Styling to active Mega Menu - Second Level Links */
	            #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link,
	            #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link {
	                color: $panel_second_level_font_color_hover;
	                font-weight: $panel_second_level_font_weight_hover;
	                text-decoration: $panel_second_level_text_decoration_hover;
	                @include background($panel_second_level_background_hover_from, $panel_second_level_background_hover_to);
	            }
	             
	            /* Apply Hover Styling to active Mega Menu - Third Level Links */
	            #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item.mega-current-menu-item > a.mega-menu-link,
	            #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item.mega-current-menu-item > a.mega-menu-link {
	                color: $panel_third_level_font_color_hover;
	                font-weight: $panel_third_level_font_weight_hover;
	                text-decoration: $panel_third_level_text_decoration_hover;
	                @include background($panel_third_level_background_hover_from, $panel_third_level_background_hover_to);
	            }
	            /* Apply Hover Styling to active Flyout Links and ancestors */
	            #{$wrap} #{$menu} li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-menu-item > a.mega-menu-link,
	            #{$wrap} #{$menu} li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link,
	            #{$wrap} #{$menu} li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link {
	                @include background($flyout_background_hover_from, $flyout_background_hover_to);
	                font-weight: $flyout_link_weight_hover;
	                text-decoration: $flyout_link_text_decoration_hover;
	                color: $flyout_link_color_hover;
	            }
	            @include desktop {
	                #{$wrap} #{$menu} > li.mega-menu-item {
	                    padding: 13px 0;
	                }
	                #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item ul.mega-sub-menu {
	                    top: -25px;
	                    margin: 0 0 0 1px;
	                }
	                #{$wrap} #{$menu} > li.mega-menu-item {
	                    &.mega-current-menu-item,
	                    &.mega-current-menu-ancestor,
	                    &.mega-current-page-ancestor {
	                         > a.mega-menu-link {
	                             background: #ffffff;
	                             color: #1f1f1f;                     
	                        }
	                    }
	                }
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-item > a.mega-menu-link,
	                #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link {
	                    transition: all .3s;
	                }
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-item > a.mega-menu-link:before,
	                #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link:before {
	                    content: \"\\\e82b\";
	                    font: 400 normal 5px / 5px \"fontello\";
	                    line-height: 25.5px;
	                    bottom: 6px;
	                    position: absolute;
	                    display: block;
	                    left: 0;
	                    right: initial;
	                    width: 16px;
	                    opacity: 0;
	                    -webkit-transition: opacity 0.4s;
	                    transition: opacity 0.4s;
	                }
	                #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link:before {
						left: 36px;
					}
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-item:hover > a.mega-menu-link,
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-item.mega-current-menu-item > a.mega-menu-link {
	                    padding: 10px 0px 10px 16px !important;
	                    &:before {
	                        opacity: 1;
	                    }
	                }
	                #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item:hover > a.mega-menu-link,
	                #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-menu-item a.mega-menu-link{
	                    padding: 10px 31px 10px 53px !important;
	                    &:before {
	                        opacity: 1;
	                    }
	                }
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-item-has-children > a.mega-menu-link > span.mega-indicator:after,
	                #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item-has-children > a.mega-menu-link > span.mega-indicator:after {
	                    position: relative;
	                    bottom: 2px;
	                    content: \"\\\e801\" !important;
	                    font: 400 normal 5px / 5px \"fontello\";
	                    width: auto;
	                    height: 1em;
	                    text-align: center;
	                    -webkit-transition: transform 0.3s;
	                    transition: transform 0.3s;
	                }
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-item-has-children:hover > a.mega-menu-link > span.mega-indicator:after,
	                #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item-has-children:hover > a.mega-menu-link > span.mega-indicator:after {
	                    -webkit-transform: rotate(-90deg);
	                    -ms-transform: rotate(-90deg);
	                    transform: rotate(-90deg);
	                }
	                
	                /* Animated top menu items */
	                #{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link {
	                    overflow: hidden;
	                }
	                #{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link > span.text-active {
	                    display: inline-block;
	                    -webkit-transition: transform 0.3s, opacity 0.3s;
	                    transition: transform 0.3s, opacity 0.3s;
	                }
	                #{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link:hover > span.text-active {
	                    opacity: 0;
	                    -webkit-transform: translateY(-150%);
	                    -ms-transform: translateY(-150%);
	                    transform: translateY(-150%);
	                }
	                #{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link > span:not(.text-active):not(.mega-indicator) {
	                    position: absolute;
	                    padding: inherit;
	                    left: 0;
	                    top: 0;
	                    opacity: 0;
	                    -webkit-transition: transform 0.3s, opacity 0.3s;
	                    transition: transform 0.3s, opacity 0.3s;
	                    -webkit-transform: translateY(150%);
	                    -ms-transform: translateY(150%);
	                    transform: translateY(150%);
	                }
	                #{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link:hover > span:not(.text-active):not(.mega-indicator) {
	                    opacity: 1;
	                    -webkit-transform: translateY(0);
	                    -ms-transform: translateY(0);
	                    transform: translateY(0);
	                }
	            }

	            @include mobile {
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link, 
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link,
	                #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link,
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link,      
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link {
	                    font-size: 16px;
	                    font-weight: 600;
	                    padding: 8px 0;
	                    color: $mobile_menu_item_link_color;
	                }
	                #{$wrap} #{$menu} > li.mega-menu-item a.mega-menu-link:hover,
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link, 
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item.mega-current-menu-item > a.mega-menu-link,
	                #{$wrap} #{$menu} li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-menu-item > a.mega-menu-link, 
	                #{$wrap} #{$menu} li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link, 
	                #{$wrap} #{$menu} li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-page-ancestor > a.mega-menu-link,
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:hover, 
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:focus, 
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:hover, 
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:focus,
	                #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link:hover,
	                #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link:focus {
	                    font-weight: 600;
	                    color: $mobile_menu_item_link_color_hover;
	            }
	                #{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link {
	                    font-weight: 700;
	                    padding: 0;
	                }
	                #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu,
	                #{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu {
	                    background: transparent;
	                }
	                #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu,
	                #{$wrap} #{$menu} li.mega-menu-megamenu > ul.mega-sub-menu {
	                    padding: 5px 0 0 20px;
	                }
	                #{$wrap} #{$menu} li.mega-menu-item-has-children > a.mega-menu-link > span.mega-indicator:after {
	                    content: \"\\\e82b\" !important;
	                    font: 400 normal 5px / 20px \"fontello\";
	                    line-height: inherit;
	                }
	                #{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu > li.mega-menu-item h4.mega-block-title,
	                #{$wrap} #{$menu} > li.mega-menu-megamenu ul.mega-sub-menu > li.mega-menu-item h4.mega-block-title, 
	                #{$wrap} #{$menu} > li.mega-menu-megamenu ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item h4.mega-block-title {
	                    color: $mobile_menu_item_link_color;
	                }
	            }

	        /* Theme icon styles */

	        @include desktop {
	            #{$wrap} #{$menu} li.mega-menu-item-has-children > a.mega-menu-link > span.mega-indicator {
	                margin: 0 0 0 11px;
	            }
	            #{$wrap} #{$menu} li.mega-menu-item-has-children > a.mega-menu-link > span.mega-indicator:after {
	                font: 400 normal 5px \"fontello\";
	                line-height: inherit;
	                content: \"\\\e82b\" !important;
	                vertical-align: baseline;
	                bottom: 2px;
	            }
	        }',
	    );
	    return $themes;
    }
    add_filter("megamenu_themes", "megamenu_add_theme_neuros_dark_1731522988");

	function megamenu_override_default_theme($value) {
	  // change 'primary' to your menu location ID
	  if ( !empty($value) && !isset($value['main']['theme']) ) {
	    $value['main']['theme'] = 'neuros_1731088309'; // change my_custom_theme_key to the ID of your exported theme
	  }
	 
	  return $value;
	}
	add_filter('default_option_megamenu_settings', 'megamenu_override_default_theme');
}