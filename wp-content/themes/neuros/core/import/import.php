<?php
# One Click Demo Content Import
if (!function_exists('neuros_ocdi_import_files')) {
    function neuros_ocdi_import_files() {
        return array(
            array(
                'import_file_name'              => 'Neuros',
                'categories'                    => array('With Images'),
                'import_file_url'               => trailingslashit(get_template_directory_uri()) . 'core/import/import.xml',
                'import_widget_file_url'        => trailingslashit(get_template_directory_uri()) . 'core/import/widgets.xml',
                'import_customizer_file_url'    => trailingslashit(get_template_directory_uri()) . 'core/import/customizer.xml',
                'import_preview_image_url'      => trailingslashit(get_template_directory_uri()) . 'screenshot.png',
                'preview_url'                   => 'https://demo.artureanec.com/themes/neuros',
            ),
            array(
                'import_file_name'              => 'Neuros Dark',
                'categories'                    => array('With Images'),
                'import_file_url'               => trailingslashit(get_template_directory_uri()) . 'core/import/import2.xml',
                'import_widget_file_url'        => trailingslashit(get_template_directory_uri()) . 'core/import/widgets2.xml',
                'import_customizer_file_url'    => trailingslashit(get_template_directory_uri()) . 'core/import/customizer2.xml',
                'import_preview_image_url'      => trailingslashit(get_template_directory_uri()) . 'screenshot2.png',
                'preview_url'                   => 'https://demo.artureanec.com/themes/neuros-dark',
            ),
        );
    }
}
add_filter( 'ocdi/import_files', 'neuros_ocdi_import_files' );

# Remove Branding Message
add_filter( 'ocdi/disable_pt_branding', '__return_true' );

# Disable Regenerate for Thumbs
//add_filter( 'ocdi/regenerate_thumbnails_in_content_import', '__return_false' ); // This will greatly improve the time needed to import the content (images), but only the original sized images will be imported.

if (!function_exists('neuros_after_activation')) {
    function neuros_after_activation() {
        function neuros_after_switch_theme_message() {
            echo '<div class="updated notice is-dismissible"><p>' . esc_html__('After activating all the recommended plugins, you can import all demo content in one-touch. Appearance > Import Demo Data.', 'neuros') . '</p></div>';
        }
        add_action('admin_notices', 'neuros_after_switch_theme_message');
    }
}
add_action('after_switch_theme', 'neuros_after_activation', 10 , 2);

# Remove all posts, pages and products before content import
if ( !function_exists('neuros_ocdi_before_content_import') ) {
    function neuros_ocdi_before_content_import() {
        $allposts= get_posts( array(
            'post_type'     => array('post', 'page', 'products', 'attachment', ''),
            'numberposts'   => -1
        ) );
        foreach ($allposts as $eachpost) {
            wp_delete_post( $eachpost->ID, true );
        }
    }
}
add_action( 'ocdi/before_content_import', 'neuros_ocdi_before_content_import' );

# Clear sidebars before the widgets get imported
if ( !function_exists('neuros_ocdi_before_widgets_import') ) {
    function neuros_ocdi_before_widgets_import() {
        update_option( 'sidebars_widgets', array() );
    }
}
add_action( 'ocdi/before_widgets_import', 'neuros_ocdi_before_widgets_import' );


if (!function_exists('neuros_ocdi_after_import_setup')) {
    function neuros_ocdi_after_import_setup($selected_import) {
        // Assign menus to their locations.
        $main_menu              = get_term_by('name', 'Main Menu', 'nav_menu');
        $footer_additional_menu = get_term_by('name', 'Footer Additional Menu', 'nav_menu');

        set_theme_mod('nav_menu_locations', array(
            'main'              => $main_menu->term_id,
            'footer_add_menu'   => $footer_additional_menu->term_id,
        ));

        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_path('/home/');
        # $blog_page_id  = get_page_by_path( '/blog/');
        update_option('show_on_front', 'page');
        update_option('page_on_front', $front_page_id->ID);
        // update_option( 'page_for_posts', $blog_page_id->ID );
        update_option( 'permalink_structure', '/%postname%/' );
        flush_rewrite_rules();

        // Set Mailchimp for WP options
        if ( function_exists( 'mc4wp' ) ) {
            $has_forms = get_posts(
                array(
                    'post_type'   => 'mc4wp-form',
                    'post_status' => 'publish',
                    'numberposts' => 1,
                )
            );
            update_option( 'mc4wp_default_form_id', $has_forms[0]->ID );
        }

        // Set WooCommerce options
        if ( class_exists('WooCommerce') ) {
            if (!wc_update_product_lookup_tables_is_running()) {
                wc_update_product_lookup_tables();
            }
            $args = array(
                'post_type'     => 'product',
                'post_status'   => 'publish',
                'orderby'       => 'date',
                'order'         => 'ASC'
            );
            $loop = new WP_Query($args);
            while ($loop->have_posts()) {
                $loop->the_post();
                global $product;
                wc_delete_product_transients($product->get_id());
            }

            $shop_page_id       = get_page_by_path('/shop/');
            $cart_page_id       = get_page_by_path('/cart/');
            $checkout_page_id   = get_page_by_path('/checkout/');
            $account_page_id    = get_page_by_path('/my-account/');
            update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );
            update_option( 'woocommerce_cart_page_id', $cart_page_id->ID );
            update_option( 'woocommerce_checkout_page_id', $checkout_page_id->ID );
            update_option( 'woocommerce_myaccount_page_id', $account_page_id->ID );            
        }

        // Set Elementor options
        if ( did_action('elementor/loaded') ) {

        	update_option('elementor_cpt_support', array('post', 'page', 'neuros_project', 'neuros_service', 'neuros_vacancy', 'neuros_case_study', 'neuros_team_member'));
            update_option('elementor_disable_color_schemes', 'yes');
            update_option('elementor_disable_typography_schemes', 'yes');

            update_option('elementor_optimized_gutenberg_loading', 0);
            update_option('elementor_unfiltered_files_upload', 1);

            update_option('elementor_experiment-container_grid', 'inactive');
            update_option('elementor_experiment-e_optimized_control_loading', 'inactive');
            update_option('elementor_experiment-editor_v2', 'inactive');
            update_option('elementor_experiment-landing-pages', 'active');
            update_option('elementor_experiment-nested-elements', 'inactive');
            update_option('elementor_experiment-e_lazyload', 'inactive');
            update_option('elementor_experiment-e_optimized_css_loading', 'inactive');
            update_option('elementor_experiment-e_font_icon_svg', 'inactive');
            update_option('elementor_experiment-e_font_icon_svg', 'inactive');
            update_option('elementor_experiment-additional_custom_breakpoints', 'active');
            update_option('elementor_experiment-container', 'inactive');
            update_option('elementor_experiment-e_swiper_latest', 'inactive');
            update_option('elementor_experiment-ai-layout', 'inactive');


            $kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend();
            $kit->update_settings(
                [
                    'container_width'       => [
                        'unit'  => 'px',
                        'size'  => 1340,
                        'sizes' => []
                    ],
                    'space_between_widgets' => [
                        'unit'  => 'px',
                        'size'  => 20,
                        'sizes' => []
                    ],
                    'viewport_mobile' => 575,
                    'viewport_mobile_extra' => 767,
                    'viewport_md' => 576,
                    'viewport_lg' => 992,
                    'viewport_tablet' => 991,
                    'viewport_tablet_extra' => 1279,
                    'viewport_widescreen' => 1921,
                    'viewport_laptop' => 1600,
                    'active_breakpoints' => [
                        'viewport_mobile',
                        'viewport_mobile_extra',
                        'viewport_tablet',
                        'viewport_tablet_extra',
                        'viewport_laptop',
                        'viewport_widescreen'
                    ],
                    'system_colors'         => [
                        0       => [
                            '_id'   => 'primary',
                            'title' => esc_html__('Primary', 'neuros'),
                            'color' => '#111111'
                        ],
                        1       => [
                            '_id'   => 'secondary',
                            'title' => esc_html__('Secondary', 'neuros'),
                            'color' => '#F0F2F4'
                        ],
                        2       => [
                            '_id'   => 'text',
                            'title' => esc_html__('Text', 'neuros'),
                            'color' => '#333333'
                        ],
                        3       => [
                            '_id'   => 'accent',
                            'title' => esc_html__('Accent', 'neuros'),
                            'color' => '#F14F44'
                        ]
                    ]
                ]
            );
        }

        // Import forms
        if ( function_exists('wpforms') ) {
            $title = esc_html__('Contact Form', 'neuros');
            $form_id = wpforms()->form->add($title);
            $form_id = wpforms()->form->update(
                $form_id,
                array(
                    'id'        => '67',
                    'field_id'  => 10,
                    'fields'    => array(
                        '1'                         => array(
                            'id'                        => '1',
                            'type'                      => 'text',
                            'label'                     => esc_html__('Full Name', 'neuros'),
                            'description'               => '',
                            'required'                  => '1',
                            'size'                      => 'large',
                            'placeholder'               => esc_attr__('Full Name', 'neuros'),
                            'default_value'             => '',
                            'input_mask'                => '',
                            'css'                       => '',
                            'label_hide'                => '1',
                            'sublabel_hide'             => '1',
                        ),
                        '3'                         => array(
                            'id'                        => '3',
                            'type'                      => 'email',
                            'label'                     => esc_html__('Email', 'neuros'),
                            'description'               => '',
                            'required'                  => '1',
                            'size'                      => 'large',
                            'placeholder'               => esc_attr__('Email', 'neuros'),
                            'confirmation_placeholder'  => '',
                            'default_value'             => '',
                            'filter_type'               => '',
                            'allowlist'                 => '',
                            'denylist'                  => '',
                            'css'                       => '',
                            'label_hide'                => '1',
                            'sublabel_hide'             => '1',
                        ),
                        '4'                         => array(
                            'id'                        => '4',
                            'type'                      => 'text',
                            'label'                     => esc_html__('Subject', 'neuros'),
                            'description'               => '',
                            'required'                  => '1',
                            'size'                      => 'large',
                            'placeholder'               => esc_attr__('Subject', 'neuros'),
                            'default_value'             => '',
                            'input_mask'                => '',
                            'css'                       => '',
                            'label_hide'                => '1',
                            'sublabel_hide'             => '1',
                        ),
                        '5'                         => array(
                            'id'                        => '5',
                            'type'                      => 'textarea',
                            'label'                     => esc_html__('Message', 'neuros'),
                            'description'               => '',
                            'size'                      => 'small',
                            'placeholder'               => esc_attr__('Message', 'neuros'),
                            'limit_count'               => '1',
                            'limit_mode'                => 'characters',
                            'default_value'             => '',
                            'css'                       => '',
                            'label_hide'                => '1',
                            'sublabel_hide'             => '1',
                        ),
                    ),
                    'settings' => array(
                        'form_title'                => $title,
                        'form_desc'                 => esc_html__('Define your goals and identify areas where AI can add value to your business', 'neuros'),
                        'submit_text'               => esc_html__('Send a Message', 'neuros'),
                        'submit_text_processing'    => esc_html__('Sending...', 'neuros'),
                        'antispam'                  => '1',
                        'form_class'                => '',
                        'submit_class'              => '',
                        'ajax_submit'               => '1',
                        'notification_enable'       => '1',
                        'notifications'             => array(
                            '1'                         => array(
                                'email'                     => '{admin_email}',
                                'subject'                   => esc_html__('New Contact Form Entry', 'neuros'),
                                'sender_name'               => 'Neuros',
                                'sender_address'            => '{admin_email}',
                                'replyto'                   => '',
                                'message'                   => '{all_fields}',
                            ),
                        ),
                        'confirmations'             => array(
                            '1'                         => array(
                                'type'                      => 'message',
                                'message'                   => '<p>' . esc_html__('Thanks for contacting us! We will be in touch with you shortly.', 'neuros') . '</p>',
                                'message_scroll'            => '1',
                                'page'                      => '395',
                                'redirect'                  => '',
                            ),
                        ),
                    ),
                    'meta'                      => array(
                        'template'                  => 'blank',
                    ),
                )
            );
            wp_update_post(
                array(
                    'ID'         => $form_id,
                    'post_title' => $title,
                )
            );

            $title1 = esc_html__('Image Generator Form', 'neuros');
            $form_id1 = wpforms()->form->add($title1);
            $form_id1 = wpforms()->form->update(
                $form_id1,
                array(
                    'id'        => '11289',
                    'field_id'  => 2,
                    'fields'    => array(
                        '1'                         => array(
                            'id'                        => '1',
                            'type'                      => 'text',
                            'label'                     => esc_html__('Describe what you want to see', 'neuros'),
                            'description'               => '',
                            'required'                  => '0',
                            'size'                      => 'large',
                            'placeholder'               => esc_attr__('Describe what you want to see', 'neuros'),
                            'default_value'             => '',
                            'input_mask'                => '',
                            'css'                       => '',
                            'label_hide'                => '1',
                        ),
                    ),
                    'settings' => array(
                        'form_title'                => $title1,
                        'form_desc'                 => '',
                        'submit_text'               => esc_html__('Submit', 'neuros'),
                        'submit_text_processing'    => esc_html__('Sending...', 'neuros'),
                        'antispam'                  => '1',
                        'form_class'                => '',
                        'submit_class'              => 'hide',
                        'ajax_submit'               => '1',
                        'notification_enable'       => '1',
                        'notifications'             => array(
                            '1'                         => array(
                                'email'                     => '{admin_email}',
                                'subject'                   => esc_html__('New Contact Form Entry', 'neuros'),
                                'sender_name'               => 'Neuros',
                                'sender_address'            => '{admin_email}',
                                'replyto'                   => '',
                                'message'                   => '{all_fields}',
                            ),
                        ),
                        'confirmations'             => array(
                            '1'                         => array(
                                'type'                      => 'message',
                                'message'                   => '<p>' . esc_html__('Thanks for contacting us! We will be in touch with you shortly.', 'neuros') . '</p>',
                                'message_scroll'            => '1',
                                'page'                      => '395',
                                'redirect'                  => '',
                            ),
                        ),
                    ),
                    'meta'                      => array(
                        'template'                  => 'blank',
                    ),
                )
            );
            wp_update_post(
                array(
                    'ID'         => $form_id1,
                    'post_title' => $title1,
                )
            );

            $title2 = esc_html__('Chatbot Form', 'neuros');
            $form_id2 = wpforms()->form->add($title2);
            $form_id2 = wpforms()->form->update(
                $form_id2,
                array(
                    'id'        => '11467',
                    'field_id'  => 3,
                    'fields'    => array(
                        '2'                         => array(
                            'id'                        => '2',
                            'type'                      => 'email',
                            'label'                     => esc_html__('Email', 'neuros'),
                            'description'               => '',
                            'required'                  => '1',
                            'size'                      => 'large',
                            'placeholder'               => esc_attr__('Enter your email', 'neuros'),
                            'confirmation_placeholder'  => '',
                            'default_value'             => '',
                            'filter_type'               => '',
                            'allowlist'                 => '',
                            'denylist'                  => '',
                            'css'                       => '',
                            'label_hide'                => '1',
                            'sublabel_hide'             => '1',
                        ),
                    ),
                    'settings' => array(
                        'form_title'                => $title2,
                        'form_desc'                 => '',
                        'submit_text'               => esc_html__('Submit', 'neuros'),
                        'submit_text_processing'    => esc_html__('Sending...', 'neuros'),
                        'antispam'                  => '1',
                        'form_class'                => '',
                        'submit_class'              => 'hide',
                        'ajax_submit'               => '1',
                        'notification_enable'       => '1',
                        'notifications'             => array(
                            '1'                         => array(
                                'email'                     => '{admin_email}',
                                'subject'                   => esc_html__('New Contact Form Entry', 'neuros'),
                                'sender_name'               => 'Neuros',
                                'sender_address'            => '{admin_email}',
                                'replyto'                   => '',
                                'message'                   => '{all_fields}',
                            ),
                        ),
                        'confirmations'             => array(
                            '1'                         => array(
                                'type'                      => 'message',
                                'message'                   => '<p>' . esc_html__('Thanks for contacting us! We will be in touch with you shortly.', 'neuros') . '</p>',
                                'message_scroll'            => '1',
                                'page'                      => '395',
                                'redirect'                  => '',
                            ),
                        ),
                    ),
                    'meta'                      => array(
                        'template'                  => 'blank',
                    ),
                )
            );
            wp_update_post(
                array(
                    'ID'         => $form_id2,
                    'post_title' => $title2,
                )
            );
        }

        if( class_exists( 'Mega_Menu' ) ) {
        	if( 'Neuros' == $selected_import['import_file_name'] ) {
        		update_option( 'megamenu_settings', array('main' => array('enabled' => '1', 'event' => 'hover_', 'effect' => 'fade_up', 'effect_speed' => '200', 'effect_mobile' => 'disabled', 'effect_speed_mobile' => '200', 'theme' => 'neuros_1731088309' )) );
        	} elseif ( 'Neuros Dark' == $selected_import['import_file_name']) {
        		update_option( 'megamenu_settings', array('main' => array('enabled' => '1', 'event' => 'hover_', 'effect' => 'fade_up', 'effect_speed' => '200', 'effect_mobile' => 'disabled', 'effect_speed_mobile' => '200', 'theme' => 'neuros_dark_1731522988' )) );
        	}
        }

    }
}
add_action( 'ocdi/after_import', 'neuros_ocdi_after_import_setup' );