<?php
/*
 * Created by Artureanec
*/

require_once(get_template_directory() . "/core/customizer/customizer-sanitize-functions.php");
require_once(get_template_directory() . "/core/customizer/customizer-defaults.php");
require_once(get_template_directory() . "/core/customizer/customizer-controls.php");

# Register Customizer
add_action('customize_register', 'neuros_customizer_register');
if (!function_exists('neuros_customizer_register')) {
    function neuros_customizer_register($wp_customize) {
        global $neuros_customizer_default_values;

        // ----------------------------------------------- //
        // ---------- Page Settings Panel ---------- //
        // ----------------------------------------------- //
        $wp_customize->add_panel('neuros_page_settings',
            array(
                'title'     => esc_html__('Page Settings', 'neuros'),
                'priority'  => 125
            )
        );

        // ---###################--- //
        // ---### Page Top Background ###--- //
        // ---###################--- //
        $wp_customize->add_section('neuros_page_top_bg',
            array(
                'title' => esc_html__('Page Top Background', 'neuros'),
                'panel' => 'neuros_page_settings'
            )
        );

        // --------------------------------- //
        // --- Page Top Background Color --- //
        // --------------------------------- //
        $wp_setting_name = 'page_top_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Page Top Background Color', 'neuros'),
                'section'       => 'neuros_page_top_bg',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ----------------------------- //
        // --- Footer Border Radius --- //
        // ---------------------------- //
        $wp_setting_name = 'page_top_border_radius';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Page Top Border Radius', 'neuros'),
                'section'       => 'neuros_page_top_bg',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'on'        => esc_html__('On', 'neuros'),
                    'off'       => esc_html__('Off', 'neuros')
                )
            )
        ));

        // ---###################--- //
        // ---### Body Lines ###--- //
        // ---###################--- //
        $wp_customize->add_section('neuros_page_body_lines',
            array(
                'title' => esc_html__('Body Lines', 'neuros'),
                'panel' => 'neuros_page_settings'
            )
        );

        // ------------------ //
        // --- Body Lines --- //
        // ------------------ //
        $wp_setting_name = 'body_lines_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show page background lines', 'neuros'),
                'section'   => 'neuros_page_body_lines',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------ //
        // --- Body Lines Color --- //
        // ------------------------ //
        $wp_setting_name = 'body_lines_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Lines Color', 'neuros'),
                'section'       => 'neuros_page_body_lines',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'body_lines_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------------------- //
        // ---------- Top Bar Settings Panel ---------- //
        // -------------------------------------------- //
        $wp_customize->add_panel('neuros_top_bar_settings',
            array(
                'title'     => esc_html__('Top Bar Settings', 'neuros'),
                'priority'  => 130
            )
        );

        // ---#######################--- //
        // ---### Top Bar General ###--- //
        // ---#######################--- //
        $wp_customize->add_section('neuros_top_bar_general',
            array(
                'title' => esc_html__('General', 'neuros'),
                'panel' => 'neuros_top_bar_settings'
            )
        );

        // ---------------------- //
        // --- Top Bar Status --- //
        // ---------------------- //
        $wp_setting_name = 'top_bar_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Top Bar', 'neuros'),
                'section'   => 'neuros_top_bar_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------- //
        // --- Top Bar Customize --- //
        // ------------------------- //
        $wp_setting_name = 'top_bar_customize';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Customize', 'neuros'),
                'section'   => 'neuros_top_bar_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ---------------------------------- //
        // --- Top Bar Default Text Color --- //
        // ---------------------------------- //
        $wp_setting_name = 'top_bar_default_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Default Text Color', 'neuros'),
                'section'       => 'neuros_top_bar_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // ------------------------------- //
        // --- Top Bar Dark Text Color --- //
        // ------------------------------- //
        $wp_setting_name = 'top_bar_dark_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Dark Text Color', 'neuros'),
                'section'       => 'neuros_top_bar_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- Top Bar Light Text Color --- //
        // -------------------------------- //
        $wp_setting_name = 'top_bar_light_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Light Text Color', 'neuros'),
                'section'       => 'neuros_top_bar_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // --------------------------------- //
        // --- Top Bar Accent Text Color --- //
        // --------------------------------- //
        $wp_setting_name = 'top_bar_accent_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Accent Text Color', 'neuros'),
                'section'       => 'neuros_top_bar_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------- //
        // --- Top Bar Border Color --- //
        // ---------------------------- //
        $wp_setting_name = 'top_bar_border_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Border Color', 'neuros'),
                'section'       => 'neuros_top_bar_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // ------------------------------------ //
        // --- Top Bar Hovered Border Color --- //
        // ------------------------------------ //
        $wp_setting_name = 'top_bar_border_hover_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Hovered Border Color', 'neuros'),
                'section'       => 'neuros_top_bar_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- Top Bar Background Color --- //
        // -------------------------------- //
        $wp_setting_name = 'top_bar_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Color', 'neuros'),
                'section'       => 'neuros_top_bar_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // -------------------------------------------- //
        // --- Top Bar Alternative Background Color --- //
        // -------------------------------------------- //
        $wp_setting_name = 'top_bar_background_alter_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Alternative Background Color', 'neuros'),
                'section'       => 'neuros_top_bar_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // --------------------------------- //
        // --- Top Bar Button Text Color --- //
        // --------------------------------- //
        $wp_setting_name = 'top_bar_button_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Text Color', 'neuros'),
                'section'       => 'neuros_top_bar_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // ----------------------------------- //
        // --- Top Bar Button Border Color --- //
        // ----------------------------------- //
        $wp_setting_name = 'top_bar_button_border_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Color', 'neuros'),
                'section'       => 'neuros_top_bar_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // --------------------------------------- //
        // --- Top Bar Button Background Color --- //
        // --------------------------------------- //
        $wp_setting_name = 'top_bar_button_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Color', 'neuros'),
                'section'       => 'neuros_top_bar_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // --------------------------------- //
        // --- Top Bar Button Text Hover --- //
        // --------------------------------- //
        $wp_setting_name = 'top_bar_button_text_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Text Hover', 'neuros'),
                'section'       => 'neuros_top_bar_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ----------------------------------- //
        // --- Top Bar Button Border Hover --- //
        // ----------------------------------- //
        $wp_setting_name = 'top_bar_button_border_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Hover', 'neuros'),
                'section'       => 'neuros_top_bar_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // --------------------------------------- //
        // --- Top Bar Button Background Hover --- //
        // --------------------------------------- //
        $wp_setting_name = 'top_bar_button_background_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Hover', 'neuros'),
                'section'       => 'neuros_top_bar_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));


        // ---##############################--- //
        // ---### Top Bar Social Buttons ###--- //
        // ---##############################--- //
        $wp_customize->add_section('neuros_top_bar_socials',
            array(
                'title' => esc_html__('Social Buttons', 'neuros'),
                'panel' => 'neuros_top_bar_settings'
            )
        );

        // ------------------------------ //
        // --- Top Bar Socials Status --- //
        // ------------------------------ //
        $wp_setting_name = 'top_bar_socials_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Social Buttons', 'neuros'),
                'section'   => 'neuros_top_bar_socials',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));


        // ---###############################--- //
        // ---### Top Bar Additional Text ###--- //
        // ---###############################--- //
        $wp_customize->add_section('neuros_top_bar_additional_text',
            array(
                'title' => esc_html__('Additional Text', 'neuros'),
                'panel' => 'neuros_top_bar_settings'
            )
        );

        // -------------------------------------- //
        // --- Top Bar Additional Text Status --- //
        // -------------------------------------- //
        $wp_setting_name = 'top_bar_additional_text_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Additional Text', 'neuros'),
                'section'   => 'neuros_top_bar_additional_text',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------------------- //
        // --- Top Bar Additional Text Title --- //
        // ------------------------------------- //
        $wp_setting_name = 'top_bar_additional_text_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'wp_kses_post'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Additional Text Title', 'neuros'),
                'section'       => 'neuros_top_bar_additional_text',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_additional_text_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------- //
        // --- Top Bar Additional Text --- //
        // ------------------------------- //
        $wp_setting_name = 'top_bar_additional_text';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'wp_kses_post'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Additional Text', 'neuros'),
                'section'       => 'neuros_top_bar_additional_text',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_additional_text_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));


        // ---########################--- //
        // ---### Top Bar Contacts ###--- //
        // ---########################--- //
        $wp_customize->add_section('neuros_top_bar_contacts',
            array(
                'title' => esc_html__('Contacts', 'neuros'),
                'panel' => 'neuros_top_bar_settings'
            )
        );

        // ---------------------------- //
        // --- Top Bar Contacts Title --- //
        // ---------------------------- //
        $wp_setting_name = 'top_bar_contacts_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Mobile Menu Contacts Title', 'neuros'),
                'section'       => 'neuros_top_bar_contacts',
                'type'          => 'text',
                'settings'      => $wp_setting_name
            )
        ));

        // ----------------------------------- //
        // --- Top Bar Phone Number Status --- //
        // ----------------------------------- //
        $wp_setting_name = 'top_bar_contacts_phone_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Phone Number', 'neuros'),
                'section'   => 'neuros_top_bar_contacts',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ---------------------------- //
        // --- Top Bar Phone Title --- //
        // ---------------------------- //
        $wp_setting_name = 'top_bar_contacts_phone_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Phone Title', 'neuros'),
                'section'       => 'neuros_top_bar_contacts',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_contacts_phone_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------- //
        // --- Top Bar Phone Number --- //
        // ---------------------------- //
        $wp_setting_name = 'top_bar_contacts_phone';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Phone Number', 'neuros'),
                'section'       => 'neuros_top_bar_contacts',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_contacts_phone_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------ //
        // --- Top Bar Email Address Status --- //
        // ------------------------------------ //
        $wp_setting_name = 'top_bar_contacts_email_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Email Address', 'neuros'),
                'section'   => 'neuros_top_bar_contacts',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ---------------------------- //
        // --- Top Bar Email Title --- //
        // ---------------------------- //
        $wp_setting_name = 'top_bar_contacts_email_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Email Title', 'neuros'),
                'section'       => 'neuros_top_bar_contacts',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_contacts_email_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ----------------------------- //
        // --- Top Bar Email Address --- //
        // ----------------------------- //
        $wp_setting_name = 'top_bar_contacts_email';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_email'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Email Address', 'neuros'),
                'section'       => 'neuros_top_bar_contacts',
                'type'          => 'email',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_contacts_email_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));        

        // ------------------------------ //
        // --- Top Bar Address Status --- //
        // ------------------------------ //
        $wp_setting_name = 'top_bar_contacts_address_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Address', 'neuros'),
                'section'   => 'neuros_top_bar_contacts',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

         // ------------------------- //
        // --- Top Address Title --- //
        // ------------------------- //
        $wp_setting_name = 'top_bar_contacts_address_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Address Title', 'neuros'),
                'section'       => 'neuros_top_bar_contacts',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_contacts_address_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ----------------------- //
        // --- Top Bar Address --- //
        // ----------------------- //
        $wp_setting_name = 'top_bar_contacts_address';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Address', 'neuros'),
                'section'       => 'neuros_top_bar_contacts',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'top_bar_contacts_address_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));


        // ------------------------------------------- //
        // ---------- Header Settings Panel ---------- //
        // ------------------------------------------- //
        $wp_customize->add_panel('neuros_header_settings',
            array(
                'title'     => esc_html__('Header Settings', 'neuros'),
                'priority'  => 130
            )
        );

        // ---######################--- //
        // ---### Header General ###--- //
        // ---######################--- //
        $wp_customize->add_section('neuros_header_general',
            array(
                'title' => esc_html__('General', 'neuros'),
                'panel' => 'neuros_header_settings'
            )
        );

        // --------------------- //
        // --- Header Status --- //
        // --------------------- //
        $wp_setting_name = 'header_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Header', 'neuros'),
                'section'   => 'neuros_header_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------- //
        // --- Header Type --- //
        // ------------------- //
        $wp_setting_name = 'header_style';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Header Style', 'neuros'),
                'section'   => 'neuros_header_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'type-1'    => esc_html__('Style Type 1', 'neuros'),
                    'type-2'    => esc_html__('Style Type 2', 'neuros'),
                    'type-3'    => esc_html__('Style Type 3', 'neuros'),
                    'type-4'    => esc_html__('Style Type 4', 'neuros')
                )
            )
        ));

        // ----------------------- //
        // --- Header Position --- //
        // ----------------------- //
        $wp_setting_name = 'header_position';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Header Position', 'neuros'),
                'section'   => 'neuros_header_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'above'     => esc_html__('Above', 'neuros'),
                    'over'      => esc_html__('Over', 'neuros')
                )
            )
        ));


        // ------------------------- //
        // --- Header Transparent --- //
        // ------------------------- //
        $wp_setting_name = 'header_transparent';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_checkbox'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Transparent Header', 'neuros'),
                'section'       => 'neuros_header_general',
                'type'          => 'checkbox',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_position',
                        'operator'  => '==',
                        'value'     => 'over'
                    ]
                ]
            )
        ));        

        // ------------------------- //
        // --- Header Border --- //
        // ------------------------- //
        $wp_setting_name = 'header_border';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Border Style', 'neuros'),
                'section'   => 'neuros_header_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'none'    => esc_html__('No Border', 'neuros'),
                    'border'  => esc_html__('Border', 'neuros')
                )
            )
        ));

        // ------------------------ //
        // --- Header Customize --- //
        // ------------------------ //
        $wp_setting_name = 'header_customize';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Customize', 'neuros'),
                'section'   => 'neuros_header_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------- //
        // --- Header Top Offset --- //
        // ------------------------- //
        $wp_setting_name = 'header_offset_top';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Header Offset Top, in px', 'neuros'),
                'section'       => 'neuros_header_general',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'           => 'header_customize',
                        'operator'          => '==',
                        'value'             => 'on'
                    ]
                ]
            )
        ));

        // --------------------------------- //
        // --- Header Default Text Color --- //
        // --------------------------------- //
        $wp_setting_name = 'header_default_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Default text color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // ------------------------------ //
        // --- Header Dark Text Color --- //
        // ------------------------------ //
        $wp_setting_name = 'header_dark_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Dark text color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------- //
        // --- Header Light Text Color --- //
        // ------------------------------- //
        $wp_setting_name = 'header_light_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Light text color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- Header Accent Text Color --- //
        // -------------------------------- //
        $wp_setting_name = 'header_accent_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Accent text color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- Header Current Text Color --- //
        // -------------------------------- //
        $wp_setting_name = 'header_current_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Current Page/Post Text Color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- Header Current Text Color --- //
        // -------------------------------- //
        $wp_setting_name = 'header_current_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Current Page/Post Background Color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // --------------------------- //
        // --- Header Border Color --- //
        // --------------------------- //
        $wp_setting_name = 'header_border_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Border color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // ----------------------------------- //
        // --- Header Hovered Border Color --- //
        // ----------------------------------- //
        $wp_setting_name = 'header_border_hover_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Hovered Border color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------- //
        // --- Header Background Color --- //
        // ------------------------------- //
        $wp_setting_name = 'header_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // ------------------------------------------- //
        // --- Header Background Alternative Color --- //
        // ------------------------------------------- //
        $wp_setting_name = 'header_background_alter_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Alternative background color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- Header Button Text Color --- //
        // -------------------------------- //
        $wp_setting_name = 'header_button_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Text color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // ---------------------------------- //
        // --- Header Button Border Color --- //
        // ---------------------------------- //
        $wp_setting_name = 'header_button_border_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------- //
        // --- Header Button Border Color 2 --- //
        // ---------------------------------- //
        $wp_setting_name = 'header_button_border_color_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border color Additional', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------------- //
        // --- Header Button Background Color --- //
        // -------------------------------------- //
        $wp_setting_name = 'header_button_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------------- //
        // --- Header Button Background Color 2 --- //
        // -------------------------------------- //
        $wp_setting_name = 'header_button_background_color_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Color Additional', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- Header Button Text Hover --- //
        // -------------------------------- //
        $wp_setting_name = 'header_button_text_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Text Hover', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------- //
        // --- Header Button Border Hover --- //
        // ---------------------------------- //
        $wp_setting_name = 'header_button_border_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Hover', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------- //
        // --- Header Button Border Hover 2 --- //
        // ---------------------------------- //
        $wp_setting_name = 'header_button_border_hover_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Hover Additional', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------------- //
        // --- Header Button Background Hover --- //
        // -------------------------------------- //
        $wp_setting_name = 'header_button_background_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Hover', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------------- //
        // --- Header Button Background Hover 2 --- //
        // -------------------------------------- //
        $wp_setting_name = 'header_button_background_hover_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Hover Additional', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------------- //
        // --- Header Button Border Style --- //
        // ---------------------------------------- //
        $wp_setting_name = 'header_button_border_style';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Button Border Style', 'neuros'),
                'section'   => 'neuros_header_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'gradient'    => esc_html__('Gradient', 'neuros'),
                    'solid'       => esc_html__('Solid', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------------- //
        // --- Header Button Background Style --- //
        // ---------------------------------------- //
        $wp_setting_name = 'header_button_background_style';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Button Background Style', 'neuros'),
                'section'   => 'neuros_header_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'gradient'    => esc_html__('Gradient', 'neuros'),
                    'solid'       => esc_html__('Solid', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------- //
        // --- Header Menu Text Color --- //
        // ---------------------------------- //
        $wp_setting_name = 'header_menu_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Header Menu Text Color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------- //
        // --- Header Menu Text Color --- //
        // ---------------------------------- //
        $wp_setting_name = 'header_menu_text_color_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Header Menu Text Hover Color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------------------ //
        // --- Header Menu Text Background Color Hover --- //
        // ----------------------------------------------- //
        $wp_setting_name = 'header_menu_text_background_color_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Header Menu Text Background Hover Color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------- //
        // --- Header Menu Background Color --- //
        // ---------------------------------- //
        $wp_setting_name = 'header_menu_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Header Menu Background Color', 'neuros'),
                'section'       => 'neuros_header_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));


        // ---#######################--- //
        // ---### Header Callback ###--- //
        // ---#######################--- //
        $wp_customize->add_section('neuros_header_callback',
            array(
                'title' => esc_html__('Header Callback', 'neuros'),
                'panel' => 'neuros_header_settings'
            )
        );

        // ----------------------- //
        // --- Header Callback --- //
        // ----------------------- //
        $wp_setting_name = 'header_callback_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Show header callback block', 'neuros'),
                'section'       => 'neuros_header_callback',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'on'            => esc_html__('Yes', 'neuros'),
                    'off'           => esc_html__('No', 'neuros')
                )
            )
        ));

        // ----------------------------- //
        // --- Header Callback Title --- //
        // ----------------------------- //
        $wp_setting_name = 'header_callback_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Header callback title', 'neuros'),
                'section'       => 'neuros_header_callback',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_callback_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------- //
        // --- Header Callback Text --- //
        // ---------------------------- //
        $wp_setting_name = 'header_callback_text';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Header callback text', 'neuros'),
                'section'       => 'neuros_header_callback',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_callback_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));


        // ---#####################--- //
        // ---### Sticky Header ###--- //
        // ---#####################--- //
        $wp_customize->add_section('neuros_header_sticky',
            array(
                'title' => esc_html__('Sticky Header', 'neuros'),
                'panel' => 'neuros_header_settings'
            )
        );


        // --------------------- //
        // --- Sticky Header --- //
        // --------------------- //
        $wp_setting_name = 'sticky_header_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Sticky Header', 'neuros'),
                'section'   => 'neuros_header_sticky',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------ //
        // --- Sticky Header Blur --- //
        // ------------------------- //
        $wp_setting_name = 'sticky_header_blur';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Sticky Header Blur', 'neuros'),
                'section'   => 'neuros_header_sticky',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'    => esc_html__('On', 'neuros'),
                    'off'   => esc_html__('Off', 'neuros'),
                ),
                'dependency'    => [
                    [
                        'control'   => 'sticky_header_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));



        // ---#####################--- //
        // ---### Mobile Header ###--- //
        // ---#####################--- //
        $wp_customize->add_section('neuros_header_mobile',
            array(
                'title' => esc_html__('Mobile Header', 'neuros'),
                'panel' => 'neuros_header_settings'
            )
        );

        // -------------------------------- //
        // --- Mobile Header Breakpoint --- //
        // -------------------------------- //
        $wp_setting_name = 'mobile_header_breakpoint';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Mobile Header Breakpoint, in px', 'neuros'),
                'section'       => 'neuros_header_mobile',
                'type'          => 'number',
                'settings'      => $wp_setting_name
            )
        ));        

        // -------------------------- //
        // --- Mobile Header Menu Style --- //
        // -------------------------- //
        $wp_setting_name = 'mobile_header_menu_style';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Mobile Header Menu Trigger Style', 'neuros'),
                'section'   => 'neuros_header_mobile',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'fullwidth'    => esc_html__('Fullwidth', 'neuros'),
                    'inline'       => esc_html__('Inline', 'neuros')
                )
            )
        ));


        // ---#####################--- //
        // ---### Logo Settings ###--- //
        // ---#####################--- //
        $wp_customize->add_section('neuros_header_logo',
            array(
                'title' => esc_html__('Logo', 'neuros'),
                'panel' => 'neuros_header_settings'
            )
        );

        // -------------------------- //
        // --- Header Logo Status --- //
        // -------------------------- //
        $wp_setting_name = 'header_logo_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Logo', 'neuros'),
                'section'   => 'neuros_header_logo',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ----------------------------- //
        // --- Header Logo Customize --- //
        // ----------------------------- //
        $wp_setting_name = 'header_logo_customize';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Customize', 'neuros'),
                'section'   => 'neuros_header_logo',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------- //
        // --- Header Logo --- //
        // ------------------- //
        $wp_setting_name = 'header_logo_image';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'esc_url_raw'
            )
        );
        $wp_customize->add_control(new Neuros_Image_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Logo Image', 'neuros'),
                'section'       => 'neuros_header_logo',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_logo_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------- //
        // --- Logo Retina --- //
        // ------------------- //
        $wp_setting_name = 'header_logo_retina';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_checkbox'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Logo Retina', 'neuros'),
                'section'       => 'neuros_header_logo',
                'type'          => 'checkbox',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_logo_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------- //
        // --- Mobile Header Logo --- //
        // -------------------------- //
        $wp_setting_name = 'header_logo_mobile_image';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'esc_url_raw'
            )
        );
        $wp_customize->add_control(new Neuros_Image_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Mobile Logo Image', 'neuros'),
                'section'       => 'neuros_header_logo',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_logo_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // -------------------------- //
        // --- Mobile Logo Retina --- //
        // -------------------------- //
        $wp_setting_name = 'header_logo_mobile_retina';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_checkbox'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Mobile Logo Retina', 'neuros'),
                'section'       => 'neuros_header_logo',
                'type'          => 'checkbox',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_logo_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));


        // ---#####################--- //
        // ---### Header Button ###--- //
        // ---#####################--- //
        $wp_customize->add_section('neuros_header_button',
            array(
                'title' => esc_html__('Header Button', 'neuros'),
                'panel' => 'neuros_header_settings'
            )
        );

        // --------------------- //
        // --- Header Button --- //
        // --------------------- //
        $wp_setting_name = 'header_button_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show header button', 'neuros'),
                'section'   => 'neuros_header_button',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // -------------------------- //
        // --- Header Button Text --- //
        // -------------------------- //
        $wp_setting_name = 'header_button_text';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Header button text', 'neuros'),
                'section'       => 'neuros_header_button',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_button_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------- //
        // --- Header Button URL ---- //
        // -------------------------- //
        $wp_setting_name = 'header_button_url';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'esc_url_raw'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Header button link', 'neuros'),
                'section'       => 'neuros_header_button',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_button_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));


        // ---############################--- //
        // ---### Header Menu Settings ###--- //
        // ---############################--- //
        $wp_customize->add_section('neuros_header_menu',
            array(
                'title' => esc_html__('Header Menu', 'neuros'),
                'panel' => 'neuros_header_settings'
            )
        );

        // -------------------------- //
        // --- Header Menu Status --- //
        // -------------------------- //
        $wp_setting_name = 'header_menu_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show header menu', 'neuros'),
                'section'   => 'neuros_header_menu',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------- //
        // --- Header Menu Style --- //
        // ------------------------- //
        $wp_setting_name = 'header_menu_style';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Menu Style', 'neuros'),
                'section'       => 'neuros_header_menu',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'standard'      => esc_html__('Standard', 'neuros'),
                    'compact'       => esc_html__('Compact', 'neuros')
                )
            )
        ));

        // ------------------------------- //
        // --- Header Menu Image Status --- //
        // ------------------------------ //
        $wp_setting_name = 'header_menu_bg_image_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Header Menu Background Image', 'neuros'),
                'section'   => 'neuros_header_menu',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'header_menu_style',
                        'operator'  => '==',
                        'value'     => 'compact'
                    ]
                ]
            )
        ));

        // ------------------------------------- //
        // --- Header Menu Background Image --- //
        // ------------------------------------ //
        $wp_setting_name = 'header_menu_bg_image';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_control(new Neuros_Image_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Header Menu Background Image', 'neuros'),
                'section'       => 'neuros_header_menu',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_menu_bg_image_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ],
                    [
                        'control'   => 'header_menu_style',
                        'operator'  => '==',
                        'value'     => 'compact'
                    ]
                ]
            )
        ));

        // -------------------------- //
        // --- Header Menu Select --- //
        // -------------------------- //
        $wp_setting_name = 'header_menu_select';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Select Menu', 'neuros'),
                'section'       => 'neuros_header_menu',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => neuros_get_all_menu_list()
            )
        ));

        // ------------------------- //
        // --- Header Menu Label --- //
        // ------------------------- //
        $wp_setting_name = 'header_menu_label';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Menu label', 'neuros'),
                'section'       => 'neuros_header_menu',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'header_menu_style',
                        'operator'  => '==',
                        'value'     => 'compact'
                    ]
                ]
            )
        ));

        // ----------------------------- //
        // --- Header Menu Customize --- //
        // ----------------------------- //
        $wp_setting_name = 'header_menu_customize';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Customize', 'neuros'),
                'section'   => 'neuros_header_menu',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------- //
        // --- Header Font --- //
        // ------------------- //
        $wp_setting_name = 'header_menu_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Menu Font', 'neuros'),
                'section'       => 'neuros_header_menu',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_family'       => true,
                    'font_backup'       => true,
                    'font_styles'       => true,
                    'font_subset'       => true,
                    'font_size'         => true,
                    'line_height'       => true,
                    'text_transform'    => true,
                    'letter_spacing'    => true,
                    'word_spacing'      => true,
                    'font_style'        => true,
                    'font_weight'       => true
                ],
                'dependency'            => [
                    [
                        'control'           => 'header_menu_customize',
                        'operator'          => '==',
                        'value'             => 'on'
                    ]
                ]
            )
        ));

        // --------------------- //
        // --- Sub Menu Font --- //
        // --------------------- //
        $wp_setting_name = 'header_sub_menu_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Sub Menu Font', 'neuros'),
                'section'       => 'neuros_header_menu',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_family'       => true,
                    'font_backup'       => true,
                    'font_styles'       => true,
                    'font_subset'       => true,
                    'font_size'         => true,
                    'line_height'       => true,
                    'text_transform'    => true,
                    'letter_spacing'    => true,
                    'word_spacing'      => true,
                    'font_style'        => true,
                    'font_weight'       => true
                ],
                'separator'     => 'before',
                'dependency'    => [
                    [
                        'control'           => 'header_menu_customize',
                        'operator'          => '==',
                        'value'             => 'on'
                    ]
                ]
            )
        ));


        // ---####################--- //
        // ---### Header Icons ###--- //
        // ---####################--- //
        $wp_customize->add_section('header_icons',
            array(
                'title' => esc_html__('Header Icons', 'neuros'),
                'panel' => 'neuros_header_settings'
            )
        );

        // ------------------------- //
        // --- Header Side Panel --- //
        // ------------------------- //
        $wp_setting_name = 'side_panel_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show side panel trigger', 'neuros'),
                'section'   => 'header_icons',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // --------------------- //
        // --- Header Search --- //
        // --------------------- //
        $wp_setting_name = 'header_search_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show header search', 'neuros'),
                'section'   => 'header_icons',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));


        if ( class_exists('WooCommerce') ) {
            // ------------------------ //
            // --- Header Mini Cart --- //
            // ------------------------ //
            $wp_setting_name = 'header_minicart_status';
            $wp_customize->add_setting(
                $wp_setting_name,
                array(
                    'default'           => $neuros_customizer_default_values[$wp_setting_name],
                    'sanitize_callback'	=> 'neuros_sanitize_choice'
                )
            );
            $wp_customize->add_control(new Neuros_Customize_Control(
                $wp_customize,
                $wp_setting_name,
                array(
                    'label'     => esc_html__('Show product cart', 'neuros'),
                    'section'   => 'header_icons',
                    'type'      => 'select',
                    'settings'  => $wp_setting_name,
                    'choices'   => array(
                        'on'        => esc_html__('Yes', 'neuros'),
                        'off'       => esc_html__('No', 'neuros')
                    )
                )
            ));
        }


        // ------------------------------- //
        // ---------- Page Tile ---------- //
        // ------------------------------- //
        $wp_customize->add_panel('neuros_page_title_settings',
            array(
                'title'     => esc_html__('Page Title Settings', 'neuros'),
                'priority'  => 140
            )
        );

        // ---########################--- //
        // ---### General Settings ###--- //
        // ---########################--- //
        $wp_customize->add_section('neuros_page_title_general',
            array(
                'title' => esc_html__('General', 'neuros'),
                'panel' => 'neuros_page_title_settings'
            )
        );

        // ------------------------- //
        // --- Page Title Status --- //
        // ------------------------- //
        $wp_setting_name = 'page_title_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show page title', 'neuros'),
                'section'   => 'neuros_page_title_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // -------------------------- //
        // --- Page Title Overlay --- //
        // -------------------------- //
        $wp_setting_name = 'page_title_overlay_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show overlay', 'neuros'),
                'section'   => 'neuros_page_title_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // -------------------------------- //
        // --- Page Title Overlay Color --- //
        // -------------------------------- //
        $wp_setting_name = 'page_title_overlay_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Overlay color', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_overlay_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------- //
        // --- Page Title Customize --- //
        // ---------------------------- //
        $wp_setting_name = 'page_title_customize';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Customize', 'neuros'),
                'section'   => 'neuros_page_title_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                ),
                'separator' => 'before'
            )
        ));

        // ------------------------------- //
        // --- Page Title Block Height --- //
        // ------------------------------- //
        $wp_setting_name = 'page_title_height';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Page title height, in px', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------- //
        // --- Page Title Default Text Color --- //
        // ------------------------------------- //
        $wp_setting_name = 'page_title_default_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Default text color', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // ---------------------------------- //
        // --- Page Title Dark Text Color --- //
        // ---------------------------------- //
        $wp_setting_name = 'page_title_dark_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Dark text color', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ----------------------------------- //
        // --- Page Title Light Text Color --- //
        // ----------------------------------- //
        $wp_setting_name = 'page_title_light_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Light text color', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------ //
        // --- Page Title Accent Text Color --- //
        // ------------------------------------ //
        $wp_setting_name = 'page_title_accent_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Accent text color', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------- //
        // --- Page Title Border Color --- //
        // ------------------------------- //
        $wp_setting_name = 'page_title_border_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Border color', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // --------------------------------------- //
        // --- Page Title Hovered Border Color --- //
        // --------------------------------------- //
        $wp_setting_name = 'page_title_border_hover_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Hovered border color', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ----------------------------------- //
        // --- Page Title Background Color --- //
        // ----------------------------------- //
        $wp_setting_name = 'page_title_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background color', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // ----------------------------------------------- //
        // --- Page Title Alternative Background Color --- //
        // ----------------------------------------------- //
        $wp_setting_name = 'page_title_background_alter_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Alternative background color', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------ //
        // --- Page Title Button Text Color --- //
        // ------------------------------------ //
        $wp_setting_name = 'page_title_button_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Text Color', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // -------------------------------------- //
        // --- Page Title Button Border Color --- //
        // -------------------------------------- //
        $wp_setting_name = 'page_title_button_border_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Color', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------------- //
        // --- Page Title Button Border Color 2 --- //
        // -------------------------------------- //
        $wp_setting_name = 'page_title_button_border_color_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Color Additional', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------------ //
        // --- Page Title Button Background Color --- //
        // ------------------------------------------ //
        $wp_setting_name = 'page_title_button_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Color', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------ //
        // --- Page Title Button Text Hover --- //
        // ------------------------------------ //
        $wp_setting_name = 'page_title_button_text_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Text Hover', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------------- //
        // --- Page Title Button Border Hover --- //
        // -------------------------------------- //
        $wp_setting_name = 'page_title_button_border_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Hover', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------------ //
        // --- Page Title Button Background Hover --- //
        // ------------------------------------------ //
        $wp_setting_name = 'page_title_button_background_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Hover', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ----------------------------------- //
        // --- Page Title Background Image --- //
        // ----------------------------------- //
        $wp_setting_name = 'page_title_background_image';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'esc_url_raw'
            )
        );
        $wp_customize->add_control(new Neuros_Image_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Image', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // -------------------------------------- //
        // --- Page Title Background Position --- //
        // -------------------------------------- //
        $wp_setting_name = 'page_title_background_position';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Position', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => neuros_get_background_position_options(),
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------ //
        // --- Page Title Background Repeat --- //
        // ------------------------------------ //
        $wp_setting_name = 'page_title_background_repeat';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Repeat', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => neuros_get_background_repeat_options(),
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------- //
        // --- Page Title Background Size --- //
        // ---------------------------------- //
        $wp_setting_name = 'page_title_background_size';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Size', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => neuros_get_background_size_options(),
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------------------------- //
        // --- Hide Page Title Background on Mobile Devices --- //
        // ---------------------------------------------------- //
        $wp_setting_name = 'hide_page_title_background_mobile';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_checkbox'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Hide Background Image on Mobile Devices', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'type'          => 'checkbox',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------------------------- //
        // --- Hide Page Title Background on Tablet Devices --- //
        // ---------------------------------------------------- //
        $wp_setting_name = 'hide_page_title_background_tablet';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_checkbox'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Hide Background Image on Tablet Devices', 'neuros'),
                'section'       => 'neuros_page_title_general',
                'type'          => 'checkbox',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));


        // ---########################--- //
        // ---### Heading Settings ###--- //
        // ---########################--- //
        $wp_customize->add_section('neuros_page_title_heading',
            array(
                'title' => esc_html__('Heading', 'neuros'),
                'panel' => 'neuros_page_title_settings'
            )
        );

        // ------------------------------------ //
        // --- Page Title Heading Customize --- //
        // ------------------------------------ //
        $wp_setting_name = 'page_title_heading_customize';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Customize', 'neuros'),
                'section'       => 'neuros_page_title_heading',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

         // ------------------------------- //
        // --- Page Title Heading Icon --- //
        // ------------------------------- //
        $wp_setting_name = 'page_title_heading_icon_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Add Image Icon before Title', 'neuros'),
                'section'       => 'neuros_page_title_heading',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'page_title_heading_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------- //
        // --- Page Title Heading Icon Image --- //
        // ------------------------------------- //
        $wp_setting_name = 'page_title_heading_icon_image';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_control(new Neuros_Image_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Icon Image', 'neuros'),
                'section'       => 'neuros_page_title_heading',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_heading_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ],
                    [
                        'control'   => 'page_title_heading_icon_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // --------------------------------- //
        // --- Heading Icon Image Retina --- //
        // --------------------------------- //
        $wp_setting_name = 'page_title_heading_icon_retina';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_checkbox'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Icon Image Retina', 'neuros'),
                'section'       => 'neuros_page_title_heading',
                'type'          => 'checkbox',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_heading_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ],
                    [
                        'control'   => 'page_title_heading_icon_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------- //
        // --- Page Title Heading Font --- //
        // ------------------------------- //
        $wp_setting_name = 'page_title_heading_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Heading Font', 'neuros'),
                'section'       => 'neuros_page_title_heading',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_family'       => true,
                    'font_backup'       => true,
                    'font_styles'       => true,
                    'font_subset'       => true,
                    'font_size'         => true,
                    'line_height'       => true,
                    'text_transform'    => true,
                    'letter_spacing'    => true,
                    'word_spacing'      => true,
                    'font_style'        => true,
                    'font_weight'       => true
                ],
                'dependency'            => [
                    [
                        'control'           => 'page_title_heading_customize',
                        'operator'          => '==',
                        'value'             => 'on'
                    ]
                ]
            )
        ));


        // ---###########################--- //
        // ---### Subheading Settings ###--- //
        // ---###########################--- //
        $wp_customize->add_section('neuros_page_title_breadcrumbs',
            array(
                'title' => esc_html__('Breadcrumbs', 'neuros'),
                'panel' => 'neuros_page_title_settings'
            )
        );

        // ------------------------------------- //
        // --- Page Title Breadcrumbs Status --- //
        // ------------------------------------- //
        $wp_setting_name = 'page_title_breadcrumbs_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show page title breadcrumbs', 'neuros'),
                'section'   => 'neuros_page_title_breadcrumbs',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ---------------------------------------- //
        // --- Page Title Breadcrumbs Customize --- //
        // ---------------------------------------- //
        $wp_setting_name = 'page_title_breadcrumbs_customize';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Customize', 'neuros'),
                'section'   => 'neuros_page_title_breadcrumbs',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ----------------------------------- //
        // --- Page Title Breadcrumbs Font --- //
        // ----------------------------------- //
        $wp_setting_name = 'page_title_breadcrumbs_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Breadcrumbs Font', 'neuros'),
                'section'       => 'neuros_page_title_breadcrumbs',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_family'       => true,
                    'font_backup'       => true,
                    'font_styles'       => true,
                    'font_subset'       => true,
                    'font_size'         => true,
                    'line_height'       => true,
                    'text_transform'    => true,
                    'letter_spacing'    => true,
                    'word_spacing'      => true,
                    'font_style'        => true,
                    'font_weight'       => true
                ],
                'dependency'            => [
                    [
                        'control'           => 'page_title_breadcrumbs_customize',
                        'operator'          => '==',
                        'value'             => 'on'
                    ]
                ]
            )
        ));


        // ---################################--- //
        // ---### Additional Text Settings ###--- //
        // ---################################--- //
        $wp_customize->add_section('neuros_page_title_additional',
            array(
                'title' => esc_html__('Heading Additional Text', 'neuros'),
                'panel' => 'neuros_page_title_settings'
            )
        );

        // ----------------------- //
        // --- Additional Text --- //
        // ----------------------- //
        $wp_setting_name = 'page_title_additional_text';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Additional Text', 'neuros'),
                'section'       => 'neuros_page_title_additional',
                'type'          => 'text',
                'settings'      => $wp_setting_name
            )
        ));

        // --------------------------------- //
        // --- Additional Text Customize --- //
        // --------------------------------- //
        $wp_setting_name = 'page_title_additional_customize';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Customize', 'neuros'),
                'section'   => 'neuros_page_title_additional',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ----------------------------- //
        // --- Additional Text Color --- //
        // ----------------------------- //
        $wp_setting_name = 'page_title_additional_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_color'
            )
        );
        $wp_customize->add_control(new Neuros_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Additional text color', 'neuros'),
                'section'       => 'neuros_page_title_additional',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'page_title_additional_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------- //
        // --- Page Title Additional Text Font --- //
        // ------------------------------------- //
        $wp_setting_name = 'page_title_additional_text_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Additional Text Font', 'neuros'),
                'section'       => 'neuros_page_title_additional',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_family'       => true,
                    'font_backup'       => true,
                    'font_styles'       => true,
                    'font_subset'       => true,
                    'text_transform'    => true,
                    'letter_spacing'    => true,
                    'word_spacing'      => true,
                    'font_style'        => true,
                    'font_weight'       => true
                ],
                'dependency'            => [
                    [
                        'control'           => 'page_title_additional_customize',
                        'operator'          => '==',
                        'value'             => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------- //
        // --- Page Title Additional Text Position --- //
        // ------------------------------------- //
        $wp_setting_name = 'page_title_additional_text_bottom_position';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Additional Text Offset Bottom, in %', 'neuros'),
                'section'       => 'neuros_page_title_additional',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'           => 'page_title_additional_customize',
                        'operator'          => '==',
                        'value'             => 'on'
                    ]
                ]
            )
        ));


        // -------------------------------- //
        // ---------- Typography ---------- //
        // -------------------------------- //
        $wp_customize->add_panel('neuros_typography_settings',
            array(
                'title'     => esc_html__('Typography Settings', 'neuros'),
                'priority'  => 140
            )
        );

        // ---#################--- //
        // ---### Main Font ###--- //
        // ---#################--- //
        $wp_customize->add_section('neuros_typography_main_font',
            array(
                'title' => esc_html__('Main Font', 'neuros'),
                'panel' => 'neuros_typography_settings'
            )
        );

        // ----------------- //
        // --- Main Font --- //
        // ----------------- //
        $wp_setting_name = 'main_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Main Font', 'neuros'),
                'section'       => 'neuros_typography_main_font',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_family'       => true,
                    'font_backup'       => true,
                    'font_styles'       => true,
                    'font_subset'       => true,
                    'font_size'         => true,
                    'line_height'       => true,
                    'text_transform'    => true,
                    'letter_spacing'    => true,
                    'word_spacing'      => true,
                    'font_style'        => true,
                    'font_weight'       => true
                ]
            )
        ));

        // ---#######################--- //
        // ---### Additional Font ###--- //
        // ---#######################--- //
        $wp_customize->add_section('neuros_typography_additional_font',
            array(
                'title' => esc_html__('Additional Font', 'neuros'),
                'panel' => 'neuros_typography_settings'
            )
        );

        // ----------------------- //
        // --- Additional Font --- //
        // ----------------------- //
        $wp_setting_name = 'additional_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Additional Font', 'neuros'),
                'section'       => 'neuros_typography_additional_font',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_family'       => true,
                    'font_backup'       => true,
                    'font_styles'       => true,
                    'font_subset'       => true,
                    'font_size'         => true,
                    'line_height'       => true,
                    'font_style'        => true,
                    'font_weight'       => true
                ]
            )
        ));

        // ---################--- //
        // ---### Headings ###--- //
        // ---################--- //
        $wp_customize->add_section('neuros_typography_headings',
            array(
                'title' => esc_html__('Headings', 'neuros'),
                'panel' => 'neuros_typography_settings'
            )
        );

        // --------------------- //
        // --- Headings Font --- //
        // --------------------- //
        $wp_setting_name = 'headings_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Headings Font', 'neuros'),
                'section'       => 'neuros_typography_headings',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_family'       => true,
                    'font_backup'       => true,
                    'font_styles'       => true,
                    'font_subset'       => true,
                    'text_transform'    => true,
                    'font_style'        => true
                ]
            )
        ));

        // --------------- //
        // --- H1 Font --- //
        // --------------- //
        $wp_setting_name = 'h1_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('H1 Font', 'neuros'),
                'section'       => 'neuros_typography_headings',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_size'         => true,
                    'line_height'       => true,
                    'letter_spacing'    => true,
                    'word_spacing'      => true,
                    'font_weight'       => true
                ],
                'separator'             => 'before'
            )
        ));

        // --------------- //
        // --- H2 Font --- //
        // --------------- //
        $wp_setting_name = 'h2_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('H2 Font', 'neuros'),
                'section'       => 'neuros_typography_headings',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_size'         => true,
                    'line_height'       => true,
                    'letter_spacing'    => true,
                    'word_spacing'      => true,
                    'font_weight'       => true
                ],
                'separator'             => 'before'
            )
        ));

        // --------------- //
        // --- H3 Font --- //
        // --------------- //
        $wp_setting_name = 'h3_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('H3 Font', 'neuros'),
                'section'       => 'neuros_typography_headings',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_size'         => true,
                    'line_height'       => true,
                    'letter_spacing'    => true,
                    'word_spacing'      => true,
                    'font_weight'       => true
                ],
                'separator'             => 'before'
            )
        ));

        // --------------- //
        // --- H4 Font --- //
        // --------------- //
        $wp_setting_name = 'h4_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('H4 Font', 'neuros'),
                'section'       => 'neuros_typography_headings',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_size'         => true,
                    'line_height'       => true,
                    'letter_spacing'    => true,
                    'word_spacing'      => true,
                    'font_weight'       => true
                ],
                'separator'             => 'before'
            )
        ));

        // --------------- //
        // --- H5 Font --- //
        // --------------- //
        $wp_setting_name = 'h5_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('H5 Font', 'neuros'),
                'section'       => 'neuros_typography_headings',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_size'         => true,
                    'line_height'       => true,
                    'letter_spacing'    => true,
                    'word_spacing'      => true,
                    'font_weight'       => true
                ],
                'separator'             => 'before'
            )
        ));

        // --------------- //
        // --- H6 Font --- //
        // --------------- //
        $wp_setting_name = 'h6_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('H6 Font', 'neuros'),
                'section'       => 'neuros_typography_headings',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_size'         => true,
                    'line_height'       => true,
                    'letter_spacing'    => true,
                    'word_spacing'      => true,
                    'font_weight'       => true
                ],
                'separator'             => 'before'
            )
        ));

        // ---###############--- //
        // ---### Buttons ###--- //
        // ---###############--- //
        $wp_customize->add_section('neuros_typography_buttons',
            array(
                'title' => esc_html__('Buttons', 'neuros'),
                'panel' => 'neuros_typography_settings'
            )
        );

        // --------------------------- //
        // --- Buttons Font Family --- //
        // --------------------------- //
        $wp_setting_name = 'buttons_font';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Google_Font_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Buttons Font', 'neuros'),
                'section'       => 'neuros_typography_buttons',
                'settings'      => $wp_setting_name,
                'show_field'    => [
                    'font_family'       => true,
                    'font_backup'       => true,
                    'font_styles'       => true,
                    'font_subset'       => true,
                    'font_size'         => true,
                    'text_transform'    => true,
                    'letter_spacing'    => true,
                    'word_spacing'      => true,
                    'font_style'        => true,
                    'font_weight'       => true
                ]
            )
        ));


        // ---------------------------------- //
        // ---------- Social Links ---------- //
        // ---------------------------------- //
        $wp_customize->add_section('neuros_socials_settings',
            array(
                'title'     => esc_html__('Social Links', 'neuros'),
                'priority'  => 145
            )
        );

        // ---------------------- //
        // --- Socials Target --- //
        // ---------------------- //
        $wp_setting_name = 'socials_target';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_checkbox'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Open Socials in New Tab', 'neuros'),
                'section'       => 'neuros_socials_settings',
                'type'          => 'checkbox',
                'settings'      => $wp_setting_name
            )
        ));

        // ---------------------- //
        // --- Social Buttons --- //
        // ---------------------- //
        $wp_setting_name = 'social_buttons';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'sanitize_callback' => 'neuros_sanitize_repeater'
            )
        );
        $wp_customize->add_control( new Neuros_Customize_Socials_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'                 => esc_html__('Social Buttons', 'neuros'),
                'section'               => 'neuros_socials_settings',
                'separator'             => 'before'
            )
        ));


        // ------------------------------------ //
        // ---------- Color Settings ---------- //
        // ------------------------------------ //
        $wp_customize->add_panel('neuros_color_settings',
            array(
                'title'     => esc_html__('Color Settings', 'neuros'),
                'priority'  => 150
            )
        );

        // ---################--- //
        // ---### STANDARD ###--- //
        // ---################--- //
        $wp_customize->add_section('neuros_standard_colors',
            array(
                'title' => esc_html__('Standard Colors', 'neuros'),
                'panel' => 'neuros_color_settings'
            )
        );

        // ----------------------------------- //
        // --- Standard Default Text Color --- //
        // ----------------------------------- //
        $wp_setting_name = 'standard_default_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Default Text Color', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // -------------------------------- //
        // --- Standard Dark Text Color --- //
        // -------------------------------- //
        $wp_setting_name = 'standard_dark_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Dark Text Color', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // --------------------------------- //
        // --- Standard Light Text Color --- //
        // --------------------------------- //
        $wp_setting_name = 'standard_light_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Light Text Color', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------- //
        // --- Standard Accent Text Color --- //
        // ---------------------------------- //
        $wp_setting_name = 'standard_accent_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Accent Text Color', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------- //
        // --- Standard Contrast Text Color --- //
        // ---------------------------------- //
        $wp_setting_name = 'standard_contrast_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Contrast Text Color', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------- //
        // --- Standard Input Dark Color --- //
        // ---------------------------------- //
        $wp_setting_name = 'standard_input_dark_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Input Dark Color', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));
        

        // ----------------------------- //
        // --- Standard Border Color --- //
        // ----------------------------- //
        $wp_setting_name = 'standard_border_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Border Color', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'separator'     => 'before'
            )
        ));

        // ----------------------------------- //
        // --- Standard Border Hover Color --- //
        // ----------------------------------- //
        $wp_setting_name = 'standard_border_hover_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Border Hover Color', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // --------------------------------- //
        // --- Standard Background Color --- //
        // --------------------------------- //
        $wp_setting_name = 'standard_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Color', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'separator'     => 'before'
            )
        ));

        // --------------------------------------- //
        // --- Standard Background Alter Color --- //
        // --------------------------------------- //
        $wp_setting_name = 'standard_background_alter_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Alternative Background Color', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------- //
        // --- Standard Button Text Color --- //
        // ---------------------------------- //
        $wp_setting_name = 'standard_button_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Text Color', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'separator'     => 'before'
            )
        ));

        // ------------------------------------ //
        // --- Standard Button Border Color --- //
        // ------------------------------------ //
        $wp_setting_name = 'standard_button_border_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Color', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ------------------------------------ //
        // --- Standard Button Border Color 2 --- //
        // ------------------------------------ //
        $wp_setting_name = 'standard_button_border_color_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Color Additional', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------------- //
        // --- Standard Button Background Color --- //
        // ---------------------------------------- //
        $wp_setting_name = 'standard_button_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Color', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------------- //
        // --- Standard Button Background Color 2 --- //
        // ---------------------------------------- //
        $wp_setting_name = 'standard_button_background_color_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Color Additional', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------- //
        // --- Standard Button Text Hover --- //
        // ---------------------------------- //
        $wp_setting_name = 'standard_button_text_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Text Hover', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ------------------------------------ //
        // --- Standard Button Border Hover --- //
        // ------------------------------------ //
        $wp_setting_name = 'standard_button_border_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Hover', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ------------------------------------ //
        // --- Standard Button Border Hover 2 --- //
        // ------------------------------------ //
        $wp_setting_name = 'standard_button_border_hover_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Hover Additional', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------------- //
        // --- Standard Button Background Hover --- //
        // ---------------------------------------- //
        $wp_setting_name = 'standard_button_background_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Hover', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------------- //
        // --- Standard Button Background Hover 2 --- //
        // ---------------------------------------- //
        $wp_setting_name = 'standard_button_background_hover_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Hover Additional', 'neuros'),
                'section'       => 'neuros_standard_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));


        // ---------------------------------------- //
        // --- Standard Button Border Style --- //
        // ---------------------------------------- //
        $wp_setting_name = 'standard_button_border_style';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Button Border Style', 'neuros'),
                'section'   => 'neuros_standard_colors',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'gradient'    => esc_html__('Gradient', 'neuros'),
                    'solid'       => esc_html__('Solid', 'neuros')
                )
            )
        ));

        // ---------------------------------------- //
        // --- Standard Button Background Style --- //
        // ---------------------------------------- //
        $wp_setting_name = 'standard_button_background_style';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Button Background Style', 'neuros'),
                'section'   => 'neuros_standard_colors',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'gradient'    => esc_html__('Gradient', 'neuros'),
                    'solid'       => esc_html__('Solid', 'neuros')
                )
            )
        ));

        // ---################--- //
        // ---### CONTRAST ###--- //
        // ---################--- //
        $wp_customize->add_section('neuros_contrast_colors',
            array(
                'title' => esc_html__('Contrast Colors', 'neuros'),
                'panel' => 'neuros_color_settings'
            )
        );

        // ----------------------------------- //
        // --- Contrast Default Text Color --- //
        // ----------------------------------- //
        $wp_setting_name = 'contrast_default_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Default Text Color', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // -------------------------------- //
        // --- Contrast Dark Text Color --- //
        // -------------------------------- //
        $wp_setting_name = 'contrast_dark_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Dark Text Color', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // --------------------------------- //
        // --- Contrast Light Text Color --- //
        // --------------------------------- //
        $wp_setting_name = 'contrast_light_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Light Text Color', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------- //
        // --- Contrast Accent Text Color --- //
        // ---------------------------------- //
        $wp_setting_name = 'contrast_accent_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Accent Text Color', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------- //
        // --- Contrast Input Dark Color --- //
        // ---------------------------------- //
        $wp_setting_name = 'contrast_input_dark_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Input Dark Color', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ----------------------------- //
        // --- Contrast Border Color --- //
        // ----------------------------- //
        $wp_setting_name = 'contrast_border_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Border Color', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'separator'     => 'before'
            )
        ));

        // ----------------------------------- //
        // --- Contrast Border Hover Color --- //
        // ----------------------------------- //
        $wp_setting_name = 'contrast_border_hover_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Border Hover Color', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // --------------------------------- //
        // --- Contrast Background Color --- //
        // --------------------------------- //
        $wp_setting_name = 'contrast_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Color', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'separator'     => 'before'
            )
        ));

        // --------------------------------------- //
        // --- Contrast Background Alter Color --- //
        // --------------------------------------- //
        $wp_setting_name = 'contrast_background_alter_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Alternative Background Color', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------- //
        // --- Contrast Button Text Color --- //
        // ---------------------------------- //
        $wp_setting_name = 'contrast_button_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Text Color', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'separator'     => 'before'
            )
        ));

        // ------------------------------------ //
        // --- Contrast Button Border Color --- //
        // ------------------------------------ //
        $wp_setting_name = 'contrast_button_border_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Color', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ------------------------------------ //
        // --- Contrast Button Border Color 2 --- //
        // ------------------------------------ //
        $wp_setting_name = 'contrast_button_border_color_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Color Additional', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------------- //
        // --- Contrast Button Background Color --- //
        // ---------------------------------------- //
        $wp_setting_name = 'contrast_button_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Color', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------------- //
        // --- Contrast Button Background Color 2 --- //
        // ---------------------------------------- //
        $wp_setting_name = 'contrast_button_background_color_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Color Additional', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------- //
        // --- Contrast Button Text Hover --- //
        // ---------------------------------- //
        $wp_setting_name = 'contrast_button_text_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Text Hover', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ------------------------------------ //
        // --- Contrast Button Border Hover --- //
        // ------------------------------------ //
        $wp_setting_name = 'contrast_button_border_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Hover', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ------------------------------------ //
        // --- Contrast Button Border Hover 2 --- //
        // ------------------------------------ //
        $wp_setting_name = 'contrast_button_border_hover_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Hover Additional', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------------- //
        // --- Contrast Button Background Hover --- //
        // ---------------------------------------- //
        $wp_setting_name = 'contrast_button_background_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Hover', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------------- //
        // --- Contrast Button Background Hover 2 --- //
        // ---------------------------------------- //
        $wp_setting_name = 'contrast_button_background_hover_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Hover Additional', 'neuros'),
                'section'       => 'neuros_contrast_colors',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // ---------------------------------------- //
        // --- Contrast Button Border Style --- //
        // ---------------------------------------- //
        $wp_setting_name = 'contrast_button_border_style';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Button Border Style', 'neuros'),
                'section'   => 'neuros_contrast_colors',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'gradient'    => esc_html__('Gradient', 'neuros'),
                    'solid'       => esc_html__('Solid', 'neuros')
                )
            )
        ));

        // ---------------------------------------- //
        // --- Contrast Button Background Style --- //
        // ---------------------------------------- //
        $wp_setting_name = 'contrast_button_background_style';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Button Background Style', 'neuros'),
                'section'   => 'neuros_contrast_colors',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'gradient'    => esc_html__('Gradient', 'neuros'),
                    'solid'       => esc_html__('Solid', 'neuros')
                )
            )
        ));


        // ------------------------------------------- //
        // ---------- Footer Settings Panel ---------- //
        // ------------------------------------------- //
        $wp_customize->add_panel('neuros_footer_settings',
            array(
                'title'     => esc_html__('Footer Settings', 'neuros'),
                'priority'  => 160
            )
        );

        // ---###############--- //
        // ---### General ###--- //
        // ---###############--- //
        $wp_customize->add_section('neuros_footer_general',
            array(
                'title' => esc_html__('General', 'neuros'),
                'panel' => 'neuros_footer_settings'
            )
        );

        // --------------------- //
        // --- Footer Status --- //
        // --------------------- //
        $wp_setting_name = 'footer_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Footer', 'neuros'),
                'section'   => 'neuros_footer_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // -------------------- //
        // --- Footer Style --- //
        // -------------------- //
        $wp_setting_name = 'footer_style';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Footer Style', 'neuros'),
                'section'       => 'neuros_footer_general',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'type-1'        => esc_html__('Style 1', 'neuros'),
                    'type-2'        => esc_html__('Style 2', 'neuros'),
                    'type-3'        => esc_html__('Style 3', 'neuros'),
                    'type-4'        => esc_html__('Style 4', 'neuros'),
                    'type-5'        => esc_html__('Style 5', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'footer_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ----------------------------- //
        // --- Footer Border Radius --- //
        // ---------------------------- //
        $wp_setting_name = 'footer_border_radius';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Footer Border Radius', 'neuros'),
                'section'       => 'neuros_footer_general',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'on'        => esc_html__('On', 'neuros'),
                    'off'       => esc_html__('Off', 'neuros'),
                    'no-top-border-radius'       => esc_html__('No Top Border Radius', 'neuros'),
                    'no-bottom-border-radius'    => esc_html__('No Bottom Border Radius', 'neuros'),
                ),
                'dependency'    => [
                    [
                        'control'   => 'footer_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------ //
        // --- Footer Customize --- //
        // ------------------------ //
        $wp_setting_name = 'footer_customize';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Customize', 'neuros'),
                'section'   => 'neuros_footer_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // --------------------------------- //
        // --- Footer Default Text Color --- //
        // --------------------------------- //
        $wp_setting_name = 'footer_default_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Default Text Color', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // ------------------------------ //
        // --- Footer Dark Text Color --- //
        // ------------------------------ //
        $wp_setting_name = 'footer_dark_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Dark Text Color', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------- //
        // --- Footer Light Text Color --- //
        // ------------------------------- //
        $wp_setting_name = 'footer_light_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Light Text Color', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- Footer Accent Text Color --- //
        // -------------------------------- //
        $wp_setting_name = 'footer_accent_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Accent Text Color', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- Footer Input Dark Color --- //
        // -------------------------------- //
        $wp_setting_name = 'footer_input_dark_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Input Dark Color', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- Footer Border Text Color --- //
        // -------------------------------- //
        $wp_setting_name = 'footer_border_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Border Color', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // ---------------------------------------- //
        // --- Footer Hovered Border Text Color --- //
        // ---------------------------------------- //
        $wp_setting_name = 'footer_border_hover_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Hovered Border Color', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------- //
        // --- Footer Background Color --- //
        // ------------------------------- //
        $wp_setting_name = 'footer_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Color', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // ------------------------------------------- //
        // --- Footer Alternative Background Color --- //
        // ------------------------------------------- //
        $wp_setting_name = 'footer_background_alter_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Alternative Background Color', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------ //
        // --- Page Title Button Text Color --- //
        // ------------------------------------ //
        $wp_setting_name = 'page_title_button_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Text Color', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // ---------------------------------- //
        // --- Footer Button Border Color --- //
        // ---------------------------------- //
        $wp_setting_name = 'footer_button_border_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Color', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------- //
        // --- Footer Button Border Color 2 --- //
        // ---------------------------------- //
        $wp_setting_name = 'footer_button_border_color_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Color Additional', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------------- //
        // --- Footer Button Background Color --- //
        // -------------------------------------- //
        $wp_setting_name = 'footer_button_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Color', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------------- //
        // --- Footer Button Background Color 2 --- //
        // -------------------------------------- //
        $wp_setting_name = 'footer_button_background_color_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Color Additional', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- Footer Button Text Hover --- //
        // -------------------------------- //
        $wp_setting_name = 'footer_button_text_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Text Hover', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------- //
        // --- Footer Button Border Hover --- //
        // ---------------------------------- //
        $wp_setting_name = 'footer_button_border_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Hover', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------- //
        // --- Footer Button Border Hover 2 --- //
        // ---------------------------------- //
        $wp_setting_name = 'footer_button_border_hover_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Border Hover Additional', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------------- //
        // --- Footer Button Background Hover --- //
        // -------------------------------------- //
        $wp_setting_name = 'footer_button_background_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Hover', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------------- //
        // --- Footer Button Background Hover 2 --- //
        // -------------------------------------- //
        $wp_setting_name = 'footer_button_background_hover_add';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Button Background Hover Additional', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------------- //
        // --- Footer Button Border Style --- //
        // ---------------------------------------- //
        $wp_setting_name = 'footer_button_border_style';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Button Border Style', 'neuros'),
                'section'   => 'neuros_footer_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'gradient'    => esc_html__('Gradient', 'neuros'),
                    'solid'       => esc_html__('Solid', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------------- //
        // --- Footer Background Border Style --- //
        // ---------------------------------------- //
        $wp_setting_name = 'footer_button_background_style';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Button Background Style', 'neuros'),
                'section'   => 'neuros_footer_general',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'gradient'    => esc_html__('Gradient', 'neuros'),
                    'solid'       => esc_html__('Solid', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------- //
        // --- Footer Background Image --- //
        // ------------------------------- //
        $wp_setting_name = 'footer_background_image';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'esc_url_raw'
            )
        );
        $wp_customize->add_control(new Neuros_Image_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Bottom Image', 'neuros'),
                'section'       => 'neuros_footer_general',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'separator'     => 'before'
            )
        ));

        // ---------------------------------- //
        // --- Footer Background Position --- //
        // ---------------------------------- //
        $wp_setting_name = 'footer_background_position';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Position', 'neuros'),
                'section'       => 'neuros_footer_general',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => neuros_get_background_position_options(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- Footer Background Repeat --- //
        // -------------------------------- //
        $wp_setting_name = 'footer_background_repeat';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Repeat', 'neuros'),
                'section'       => 'neuros_footer_general',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => neuros_get_background_repeat_options(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------ //
        // --- Footer Background Size --- //
        // ------------------------------ //
        $wp_setting_name = 'footer_background_size';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Size', 'neuros'),
                'section'       => 'neuros_footer_general',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => neuros_get_background_size_options(),
                'dependency'    => [
                    [
                        'control'   => 'footer_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));


        // ---######################--- //
        // ---### Footer Widgets ###--- //
        // ---######################--- //
        $wp_customize->add_section('neuros_footer_sidebar',
            array(
                'title' => esc_html__('Footer Sidebar', 'neuros'),
                'panel' => 'neuros_footer_settings'
            )
        );

        // ----------------------------- //
        // --- Footer Widgets Status --- //
        // ----------------------------- //
        $wp_setting_name = 'footer_sidebar_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Footer Widgets', 'neuros'),
                'section'   => 'neuros_footer_sidebar',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ----------------------------- //
        // --- Footer Sidebar Select --- //
        // ----------------------------- //
        $wp_setting_name = 'footer_sidebar_select';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Select Sidebar', 'neuros'),
                'section'       => 'neuros_footer_sidebar',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => neuros_get_all_sidebar_list(),
                'dependency'    => [
                    [
                        'control'   => 'footer_sidebar_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));


        // ---#################--- //
        // ---### Copyright ###--- //
        // ---#################--- //
        $wp_customize->add_section('neuros_footer_copyright',
            array(
                'title' => esc_html__('Copyright', 'neuros'),
                'panel' => 'neuros_footer_settings'
            )
        );

        // ------------------------ //
        // --- Copyright Status --- //
        // ------------------------ //
        $wp_setting_name = 'footer_copyright_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Copyright', 'neuros'),
                'section'   => 'neuros_footer_copyright',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ---------------------- //
        // --- Copyright Text --- //
        // ---------------------- //
        $wp_setting_name = 'footer_copyright_text';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'wp_kses_post'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Copyright Text', 'neuros'),
                'section'       => 'neuros_footer_copyright',
                'type'          => 'text',
                'settings'      => $wp_setting_name
            )
        ));

        // ---###################--- //
        // ---### Footer Menu ###--- //
        // ---###################--- //
        $wp_customize->add_section('neuros_footer_menu',
            array(
                'title' => esc_html__('Footer Menu', 'neuros'),
                'panel' => 'neuros_footer_settings'
            )
        );

        // -------------------------- //
        // --- Footer Menu Status --- //
        // -------------------------- //
        $wp_setting_name = 'footer_menu_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Footer Menu', 'neuros'),
                'section'   => 'neuros_footer_menu',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // -------------------------- //
        // --- Footer Menu Select --- //
        // -------------------------- //
        $wp_setting_name = 'footer_menu_select';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Select Menu', 'neuros'),
                'section'   => 'neuros_footer_menu',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => neuros_get_all_menu_list()
            )
        ));

        // ---##############################--- //
        // ---### Footer Additional Menu ###--- //
        // ---##############################--- //
        $wp_customize->add_section('neuros_footer_additional_menu',
            array(
                'title' => esc_html__('Footer Additional Menu', 'neuros'),
                'panel' => 'neuros_footer_settings'
            )
        );

        // ------------------------------------- //
        // --- Footer Additional Menu Status --- //
        // ------------------------------------- //
        $wp_setting_name = 'footer_additional_menu_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Additional Footer Menu', 'neuros'),
                'section'   => 'neuros_footer_additional_menu',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------------------- //
        // --- Footer Additional Menu Select --- //
        // ------------------------------------- //
        $wp_setting_name = 'footer_additional_menu_select';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Select Menu', 'neuros'),
                'section'   => 'neuros_footer_additional_menu',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => neuros_get_all_menu_list()
            )
        ));

        // ------------------------------ //
        // ---------- Layout Settings ---------- //
        // ------------------------------ //
        $wp_customize->add_section('neuros_layout_settings',
            array(
                'title'     => esc_html__('Layout Settings', 'neuros'),
                'priority'  => 170
            )
        );

        // ----------------------------- //
        // --- Remove Top Margin --- //
        // ----------------------------- //
        $wp_setting_name = 'content_top_margin';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Remove Content Top Margin', 'neuros'),
                'section'   => 'neuros_layout_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'      => esc_html__('Yes', 'neuros'),
                    'off'     => esc_html__('No', 'neuros')
                )
            )
        ));

        // ----------------------------- //
        // --- Remove Bottom Margin --- //
        // ----------------------------- //
        $wp_setting_name = 'content_bottom_margin';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Remove Content Bottom Margin', 'neuros'),
                'section'   => 'neuros_layout_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'      => esc_html__('Yes', 'neuros'),
                    'off'     => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------------ //
        // ---------- Sidebars ---------- //
        // ------------------------------ //
        $wp_customize->add_section('neuros_sidebar_settings',
            array(
                'title'     => esc_html__('Sidebars', 'neuros'),
                'priority'  => 190
            )
        );

        // ----------------------------- //
        // --- Page Sidebar Position --- //
        // ----------------------------- //
        $wp_setting_name = 'sidebar_position';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Page Sidebar Position', 'neuros'),
                'section'   => 'neuros_sidebar_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'left'      => esc_html__('Left', 'neuros'),
                    'right'     => esc_html__('Right', 'neuros'),
                    'none'      => esc_html__('None', 'neuros')
                )
            )
        ));

        // -------------------------------- //
        // --- Archive Sidebar Position --- //
        // -------------------------------- //
        $wp_setting_name = 'archive_sidebar_position';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Archive Sidebar Position', 'neuros'),
                'section'   => 'neuros_sidebar_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'left'      => esc_html__('Left', 'neuros'),
                    'right'     => esc_html__('Right', 'neuros'),
                    'none'      => esc_html__('None', 'neuros')
                )
            )
        ));

        // ------------------------------------ //
        // --- Single Post Sidebar Position --- //
        // ------------------------------------ //
        $wp_setting_name = 'post_sidebar_position';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Single Post Sidebar Position', 'neuros'),
                'section'   => 'neuros_sidebar_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'left'      => esc_html__('Left', 'neuros'),
                    'right'     => esc_html__('Right', 'neuros'),
                    'none'      => esc_html__('None', 'neuros')
                )
            )
        ));

        // -------------------------------- //
        // --- Career Sidebar Position --- //
        // -------------------------------- //
        $wp_setting_name = 'vacancy_sidebar_position';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Career Sidebar Position', 'neuros'),
                'section'   => 'neuros_sidebar_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'left'      => esc_html__('Left', 'neuros'),
                    'right'     => esc_html__('Right', 'neuros'),
                    'none'      => esc_html__('None', 'neuros')
                )
            )
        ));

        // -------------------------------- //
        // --- Service Sidebar Position --- //
        // -------------------------------- //
        $wp_setting_name = 'service_sidebar_position';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Service Sidebar Position', 'neuros'),
                'section'   => 'neuros_sidebar_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'left'      => esc_html__('Left', 'neuros'),
                    'right'     => esc_html__('Right', 'neuros'),
                    'none'      => esc_html__('None', 'neuros')
                )
            )
        ));

        // -------------------------------- //
        // --- Case Study Sidebar Position --- //
        // -------------------------------- //
        $wp_setting_name = 'case_study_sidebar_position';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Case Study Sidebar Position', 'neuros'),
                'section'   => 'neuros_sidebar_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'left'      => esc_html__('Left', 'neuros'),
                    'right'     => esc_html__('Right', 'neuros'),
                    'none'      => esc_html__('None', 'neuros')
                )
            )
        ));

        if ( class_exists('WooCommerce')) {
            // -------------------------------------------- //
            // --- WooCommerce Catalog Sidebar Position --- //
            // -------------------------------------------- //
            $wp_setting_name = 'catalog_sidebar_position';
            $wp_customize->add_setting(
                $wp_setting_name,
                array(
                    'default'           => $neuros_customizer_default_values[$wp_setting_name],
                    'sanitize_callback'	=> 'neuros_sanitize_choice'
                )
            );
            $wp_customize->add_control(new Neuros_Customize_Control(
                $wp_customize,
                $wp_setting_name,
                array(
                    'label'     => esc_html__('Catalog Sidebar Position', 'neuros'),
                    'section'   => 'neuros_sidebar_settings',
                    'type'      => 'select',
                    'settings'  => $wp_setting_name,
                    'choices'   => array(
                        'left'      => esc_html__('Left', 'neuros'),
                        'right'     => esc_html__('Right', 'neuros'),
                        'none'      => esc_html__('None', 'neuros')
                    )
                )
            ));
        }

        // ---------------------------------------- //
        // ---------- Side Panel Sidebar ---------- //
        // ---------------------------------------- //
        $wp_customize->add_section('neuros_side_panel_settings', array(
                'title'     => esc_html__('Side Panel Settings', 'neuros'),
                'priority'  => 195
            )
        );

        // ------------------------------- //
        // --- Side Panel Logo Status --- //
        // ------------------------------ //
        $wp_setting_name = 'sidebar_logo_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Logo', 'neuros'),
                'section'   => 'neuros_side_panel_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------ //
        // --- Side Panel Logo --- //
        // ----------------------- //
        $wp_setting_name = 'sidebar_logo_image';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_control(new Neuros_Image_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Logo Image', 'neuros'),
                'section'       => 'neuros_side_panel_settings',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'sidebar_logo_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------- //
        // --- Logo Retina --- //
        // ------------------- //
        $wp_setting_name = 'sidebar_logo_retina';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_checkbox'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Logo Retina', 'neuros'),
                'section'       => 'neuros_side_panel_settings',
                'type'          => 'checkbox',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'sidebar_logo_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));
        
        // ------------------------------- //
        // --- Side Panel Image Status --- //
        // ------------------------------ //
        $wp_setting_name = 'side_panel_bg_image_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Side Panel Background Image', 'neuros'),
                'section'   => 'neuros_side_panel_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------ //
        // --- Side Panel Background Image --- //
        // ----------------------- //
        $wp_setting_name = 'side_panel_bg_image';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_control(new Neuros_Image_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Side Panel Background Image', 'neuros'),
                'section'       => 'neuros_side_panel_settings',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'side_panel_bg_image_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------ //
        // --- Side Panel Socials Status --- //
        // ------------------------------ //
        $wp_setting_name = 'side_panel_socials_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Social Buttons', 'neuros'),
                'section'   => 'neuros_side_panel_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // --------------------------------- //
        // ---------- Single Post ---------- //
        // --------------------------------- //
        $wp_customize->add_section('neuros_single_post_settings',
            array(
                'title'     => esc_html__('Single Post', 'neuros'),
                'priority'  => 200
            )
        );

        // ------------------------------ //
        // --- Single Post Page Title --- //
        // ------------------------------ //
        $wp_setting_name = 'post_page_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Single Post Page Title', 'neuros'),
                'section'       => 'neuros_single_post_settings',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'description'   => esc_html__('Use variable \'%s\' for display Post name', 'neuros')
            )
        ));

        // ------------------------------- //
        // --- Post Media Image Status --- //
        // ------------------------------- //
        $wp_setting_name = 'post_media_image_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Media Image', 'neuros'),
                'section'   => 'neuros_single_post_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ---------------------------- //
        // --- Post Category Status --- //
        // ---------------------------- //
        $wp_setting_name = 'post_category_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Post Categories', 'neuros'),
                'section'   => 'neuros_single_post_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------ //
        // --- Post Date Status --- //
        // ------------------------ //
        $wp_setting_name = 'post_date_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Post Date', 'neuros'),
                'section'   => 'neuros_single_post_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // -------------------------- //
        // --- Post Author Status --- //
        // -------------------------- //
        $wp_setting_name = 'post_author_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Post Author', 'neuros'),
                'section'   => 'neuros_single_post_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // -------------------------- //
        // --- Post Author Status --- //
        // -------------------------- //
        $wp_setting_name = 'post_comment_counter_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Number of Post Comments', 'neuros'),
                'section'   => 'neuros_single_post_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------- //
        // --- Post Title Status --- //
        // ------------------------- //
        $wp_setting_name = 'post_title_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Post Title', 'neuros'),
                'section'   => 'neuros_single_post_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------ //
        // --- Post Tags Status --- //
        // ------------------------ //
        $wp_setting_name = 'post_tags_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Post Tags', 'neuros'),
                'section'   => 'neuros_single_post_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // --------------------------- //
        // --- Post Socials Status --- //
        // --------------------------- //
        $wp_setting_name = 'post_socials_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Post Social Buttons', 'neuros'),
                'section'   => 'neuros_single_post_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // --------------------------- //
        // --- Recent Posts Status --- //
        // --------------------------- //
        $wp_setting_name = 'recent_posts_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Recent Posts', 'neuros'),
                'section'   => 'neuros_single_post_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------------ //
        // --- Recent Posts Customize --- //
        // ------------------------------ //
        $wp_setting_name = 'recent_posts_customize';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Customize', 'neuros'),
                'section'   => 'neuros_single_post_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                ),
                'separator' => 'before'
            )
        ));

        // ---------------------------- //
        // --- Recent Posts Heading --- //
        // ---------------------------- //
        $wp_setting_name = 'recent_posts_section_heading';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Recent Posts Section Title', 'neuros'),
                'section'       => 'neuros_single_post_settings',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'recent_posts_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ----------------------- //
        // --- Number of Posts --- //
        // ----------------------- //
        $wp_setting_name = 'recent_posts_number';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Number of Posts', 'neuros'),
                'section'       => 'neuros_single_post_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    '2'         => esc_html__('2 Items', 'neuros'),
                    '3'         => esc_html__('3 Items', 'neuros'),
                    '4'         => esc_html__('4 Items', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'recent_posts_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------- //
        // --- Order By --- //
        // ---------------- //
        $wp_setting_name = 'recent_posts_order_by';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Order By', 'neuros'),
                'section'       => 'neuros_single_post_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'random'        => esc_html__('Random', 'neuros'),
                    'date'          => esc_html__('Date', 'neuros'),
                    'name'          => esc_html__('Name', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'recent_posts_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------ //
        // --- Sort Order --- //
        // ------------------ //
        $wp_setting_name = 'recent_posts_order';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Sort Order', 'neuros'),
                'section'       => 'neuros_single_post_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'desc'  => esc_html__('Descending', 'neuros'),
                    'asc'   => esc_html__('Ascending', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'recent_posts_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------ //
        // --- Show Recent Post Image --- //
        // ------------------------------ //
        $wp_setting_name = 'recent_posts_image';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Recent Posts Featured Image', 'neuros'),
                'section'       => 'neuros_single_post_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'on'    => esc_html__('Show', 'neuros'),
                    'off'   => esc_html__('Hide', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'recent_posts_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // --------------------------------- //
        // --- Show Recent Post Category --- //
        // --------------------------------- //
        $wp_setting_name = 'recent_posts_category';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Recent Posts Categories', 'neuros'),
                'section'       => 'neuros_single_post_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'on'    => esc_html__('Show', 'neuros'),
                    'off'   => esc_html__('Hide', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'recent_posts_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ----------------------------- //
        // --- Show Recent Post Date --- //
        // ----------------------------- //
        $wp_setting_name = 'recent_posts_date';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Recent Posts Date', 'neuros'),
                'section'       => 'neuros_single_post_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'on'    => esc_html__('Show', 'neuros'),
                    'off'   => esc_html__('Hide', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'recent_posts_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------- //
        // --- Show Recent Post Author --- //
        // ------------------------------- //
        $wp_setting_name = 'recent_posts_author';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Recent Posts Author', 'neuros'),
                'section'       => 'neuros_single_post_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'on'    => esc_html__('Show', 'neuros'),
                    'off'   => esc_html__('Hide', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'recent_posts_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------ //
        // --- Show Recent Post Title --- //
        // ------------------------------ //
        $wp_setting_name = 'recent_posts_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Recent Posts Title', 'neuros'),
                'section'       => 'neuros_single_post_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'on'    => esc_html__('Show', 'neuros'),
                    'off'   => esc_html__('Hide', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'recent_posts_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- Show Recent Post Excerpt --- //
        // -------------------------------- //
        $wp_setting_name = 'recent_posts_excerpt';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Recent Posts Excerpt', 'neuros'),
                'section'       => 'neuros_single_post_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'on'    => esc_html__('Show', 'neuros'),
                    'off'   => esc_html__('Hide', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'recent_posts_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // --------------------------------------- //
        // --- Show Recent Post Excerpt Length --- //
        // --------------------------------------- //
        $wp_setting_name = 'recent_posts_excerpt_length';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Recent Posts Excerpt Length', 'neuros'),
                'section'       => 'neuros_single_post_settings',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'recent_posts_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'input_attrs' => [
                    'min'   => 0,
                    'step'  => 1
                ]
            )
        ));

        // ----------------------------- //
        // --- Show Recent Post Tags --- //
        // ----------------------------- //
        $wp_setting_name = 'recent_posts_tags';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Recent Posts Tags', 'neuros'),
                'section'       => 'neuros_single_post_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'on'    => esc_html__('Show', 'neuros'),
                    'off'   => esc_html__('Hide', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'recent_posts_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ----------------------------------------- //
        // --- Show Recent Post Read More Button --- //
        // ----------------------------------------- //
        $wp_setting_name = 'recent_posts_more';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Recent Posts \'Read More\' Button', 'neuros'),
                'section'       => 'neuros_single_post_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'on'    => esc_html__('Show', 'neuros'),
                    'off'   => esc_html__('Hide', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'recent_posts_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------ //
        // ---------- Projects Panel ---------- //
        // ------------------------------------ //
        $wp_customize->add_panel('neuros_projects_settings',
            array(
                'title'     => esc_html__('Projects', 'neuros'),
                'priority'  => 206
            )
        );

        // ---########################--- //
        // ---### Projects Archive ###--- //
        // ---########################--- //
        $wp_customize->add_section('neuros_project_archive',
            array(
                'title' => esc_html__('Archive Settings', 'neuros'),
                'panel' => 'neuros_projects_settings'
            )
        );

        // ---------------------------------- //
        // --- Project Archive Page Title --- //
        // ---------------------------------- //
        $wp_setting_name = 'project_archive_page_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Project Archive Page Title', 'neuros'),
                'section'       => 'neuros_project_archive',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'description'   => esc_html__('Use variable \'%s\' for display Post type name', 'neuros')
            )
        ));

        // -------------------------------------- //
        // --- Project Archive Columns Number --- //
        // -------------------------------------- //
        $wp_setting_name = 'project_archive_columns_number';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Project Archive Columns Number', 'neuros'),
                'section'       => 'neuros_project_archive',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'input_attrs' => [
                    'min'   => 1,
                    'max'   => 4,
                    'step'  => 1
                ]
            )
        ));

        // -------------------------------------- //
        // --- Project Archive Posts per Page --- //
        // -------------------------------------- //
        $wp_setting_name = 'project_archive_posts_per_page';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Project Posts Per Page', 'neuros'),
                'section'       => 'neuros_project_archive',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'input_attrs' => [
                    'min'   => 1,
                    'step'  => 1
                ]
            )
        ));

        // ---######################--- //
        // ---### Project Single ###--- //
        // ---######################--- //
        $wp_customize->add_section('neuros_project_single',
            array(
                'title' => esc_html__('Single Page Settings', 'neuros'),
                'panel' => 'neuros_projects_settings'
            )
        );

        // --------------------------------- //
        // --- Project Single Page Title --- //
        // --------------------------------- //
        $wp_setting_name = 'project_single_page_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Project Single Page Title', 'neuros'),
                'section'       => 'neuros_project_single',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'description'   => esc_html__('Use variable \'%s\' for display Post name', 'neuros')
            )
        ));

        // ------------------------- //
        // --- Project Title Status --- //
        // ------------------------- //
        $wp_setting_name = 'project_title_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Project Title', 'neuros'),
                'section'   => 'neuros_project_single',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------------------------------------ //
        // --- Project Single Navigation Max Word Count --------- //
        // ------------------------------------------------------ //
        $wp_setting_name = 'project_single_navigation_max_length';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Project Navigation Max Words Count', 'neuros'),
                'section'       => 'neuros_project_single',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'input_attrs' => [
                    'min'   => 1,
                    'max'   => 20,
                    'step'  => 1
                ]
            )
        ));

        // ---------------------------------------- //
        // ---------- Case Studies Panel ---------- //
        // ---------------------------------------- //
        $wp_customize->add_panel('neuros_case_studies_settings',
            array(
                'title'     => esc_html__('Case Studies', 'neuros'),
                'priority'  => 207
            )
        );

        // ---############################--- //
        // ---### Case Studies Archive ###--- //
        // ---############################--- //
        $wp_customize->add_section('neuros_case_studies_archive',
            array(
                'title' => esc_html__('Archive Settings', 'neuros'),
                'panel' => 'neuros_case_studies_settings'
            )
        );

        // --------------------------------------- //
        // --- Case Studies Archive Page Title --- //
        // --------------------------------------- //
        $wp_setting_name = 'case_studies_archive_page_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Case Studies Archive Page Title', 'neuros'),
                'section'       => 'neuros_case_studies_archive',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'description'   => esc_html__('Use variable \'%s\' for display Post type name', 'neuros')
            )
        ));

        // ------------------------------------------- //
        // --- Case Studies Archive Excerpt Length --- //
        // ------------------------------------------- //
        $wp_setting_name = 'case_studies_archive_excerpt_length';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Case Studies Excerpt Length', 'neuros'),
                'section'       => 'neuros_case_studies_archive',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'input_attrs' => [
                    'min'   => 0,
                    'step'  => 1
                ]
            )
        ));

        // ------------------------------------------- //
        // --- Case Studies Archive Columns Number --- //
        // ------------------------------------------- //
        $wp_setting_name = 'case_studies_archive_columns_number';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Case Studies Columns Number', 'neuros'),
                'section'       => 'neuros_case_studies_archive',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'input_attrs' => [
                    'min'   => 1,
                    'max'   => 4,
                    'step'  => 1
                ]
            )
        ));

        // ------------------------------------------- //
        // --- Case Studies Archive Posts per Page --- //
        // ------------------------------------------- //
        $wp_setting_name = 'case_studies_archive_posts_per_page';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Case Studies Posts Per Page', 'neuros'),
                'section'       => 'neuros_case_studies_archive',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'input_attrs' => [
                    'min'   => 1,
                    'step'  => 1
                ]
            )
        ));

        // ---###########################--- //
        // ---### Case Studies Single ###--- //
        // ---###########################--- //
        $wp_customize->add_section('neuros_case_studies_single',
            array(
                'title' => esc_html__('Single Page Settings', 'neuros'),
                'panel' => 'neuros_case_studies_settings'
            )
        );

        // ------------------------------------ //
        // --- Portfolio Single Page Title --- //
        // ------------------------------------ //
        $wp_setting_name = 'case_studies_single_page_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Case Study Single Page Title', 'neuros'),
                'section'       => 'neuros_case_studies_single',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'description'   => esc_html__('Use variable \'%s\' for display Post name', 'neuros')
            )
        ));
                

        // ---------------------------------------- //
        // ---------- Team Members Panel ---------- //
        // ---------------------------------------- //
        $wp_customize->add_panel('neuros_team_settings',
            array(
                'title'     => esc_html__('Team Members', 'neuros'),
                'priority'  => 208
            )
        );

        // ---############################--- //
        // ---### Team Members Archive ###--- //
        // ---############################--- //
        $wp_customize->add_section('neuros_team_archive',
            array(
                'title' => esc_html__('Archive Settings', 'neuros'),
                'panel' => 'neuros_team_settings'
            )
        );

        // --------------------------------------- //
        // --- Team Members Archive Page Title --- //
        // --------------------------------------- //
        $wp_setting_name = 'team_archive_page_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Team Members Archive Page Title', 'neuros'),
                'section'       => 'neuros_team_archive',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'description'   => esc_html__('Use variable \'%s\' for display Post type name', 'neuros')
            )
        ));

        // ------------------------------------------- //
        // --- Team Members Archive Columns Number --- //
        // ------------------------------------------- //
        $wp_setting_name = 'team_archive_columns_number';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Team Members Archive Columns Number', 'neuros'),
                'section'       => 'neuros_team_archive',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'input_attrs' => [
                    'min'   => 1,
                    'max'   => 4,
                    'step'  => 1
                ]
            )
        ));

        // ------------------------------------------- //
        // --- Team Members Archive Posts per Page --- //
        // ------------------------------------------- //
        $wp_setting_name = 'team_archive_posts_per_page';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Team Members Posts Per Page', 'neuros'),
                'section'       => 'neuros_team_archive',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'input_attrs' => [
                    'min'   => 1,
                    'step'  => 1
                ]
            )
        ));

        // ---##########################--- //
        // ---### Team Member Single ###--- //
        // ---##########################--- //
        $wp_customize->add_section('neuros_team_single',
            array(
                'title' => esc_html__('Single Page Settings', 'neuros'),
                'panel' => 'neuros_team_settings'
            )
        );

        // ------------------------------------- //
        // --- Team Member Single Page Title --- //
        // ------------------------------------- //
        $wp_setting_name = 'team_single_page_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Team Member Single Page Title', 'neuros'),
                'section'       => 'neuros_team_single',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'description'   => esc_html__('Use variable \'%s\' for display Post name', 'neuros')
            )
        ));


        // ------------------------------------- //
        // ---------- Careers Panel ---------- //
        // ------------------------------------- //
        $wp_customize->add_panel('neuros_vacancies_settings',
            array(
                'title'     => esc_html__('Careers', 'neuros'),
                'priority'  => 209
            )
        );

        // ---#########################--- //
        // ---### Careers Archive ###--- //
        // ---#########################--- //
        $wp_customize->add_section('neuros_vacancy_archive',
            array(
                'title' => esc_html__('Archive Settings', 'neuros'),
                'panel' => 'neuros_vacancies_settings'
            )
        );

        // ------------------------------------ //
        // --- Careers Archive Page Title --- //
        // ------------------------------------ //
        $wp_setting_name = 'vacancy_archive_page_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Careers Archive Page Title', 'neuros'),
                'section'       => 'neuros_vacancy_archive',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'description'   => esc_html__('Use variable \'%s\' for display Post type name', 'neuros')
            )
        ));

        // ---------------------------------------- //
        // --- Careers Archive Excerpt Length --- //
        // ---------------------------------------- //
        $wp_setting_name = 'vacancy_archive_excerpt_length';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Career Excerpt Length', 'neuros'),
                'section'       => 'neuros_vacancy_archive',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'input_attrs' => [
                    'min'   => 0,
                    'step'  => 1
                ]
            )
        ));

        // ---------------------------------------- //
        // --- Careers Archive Posts per Page --- //
        // ---------------------------------------- //
        $wp_setting_name = 'vacancy_archive_posts_per_page';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Career Posts Per Page', 'neuros'),
                'section'       => 'neuros_vacancy_archive',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'input_attrs' => [
                    'min'   => 1,
                    'step'  => 1
                ]
            )
        ));

        // ---######################--- //
        // ---### Career Single ###--- //
        // ---######################--- //
        $wp_customize->add_section('neuros_vacancy_single',
            array(
                'title' => esc_html__('Single Page Settings', 'neuros'),
                'panel' => 'neuros_vacancies_settings'
            )
        );

        // --------------------------------- //
        // --- Career Single Page Title --- //
        // --------------------------------- //
        $wp_setting_name = 'vacancy_single_page_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Career Single Page Title', 'neuros'),
                'section'       => 'neuros_vacancy_single',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'description'   => esc_html__('Use variable \'%s\' for display Post name', 'neuros')
            )
        ));

        // ------------------------------- //
        // --- Recent Careers Status --- //
        // ------------------------------- //
        $wp_setting_name = 'recent_vacancies_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Recent Careers', 'neuros'),
                'section'   => 'neuros_vacancy_single',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ---------------------------------- //
        // --- Recent Careers Customize --- //
        // ---------------------------------- //
        $wp_setting_name = 'recent_vacancies_customize';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Customize', 'neuros'),
                'section'   => 'neuros_vacancy_single',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                ),
                'separator' => 'before'
            )
        ));

        // -------------------------------- //
        // --- Recent Careers Heading --- //
        // -------------------------------- //
        $wp_setting_name = 'recent_vacancies_section_heading';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'wp_kses_post'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Recent Careers Section Title', 'neuros'),
                'section'       => 'neuros_vacancy_single',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'recent_vacancies_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ----------------------- //
        // --- Number of Posts --- //
        // ----------------------- //
        $wp_setting_name = 'recent_vacancies_number';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Number of Posts', 'neuros'),
                'section'       => 'neuros_vacancy_single',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'recent_vacancies_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ],
                'input_attrs'   => [
                    'min'   => 1,
                    'max'   => 20,
                    'step'  => 1
                ]
            )
        ));

        // ---------------- //
        // --- Order By --- //
        // ---------------- //
        $wp_setting_name = 'recent_vacancies_order_by';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Order By', 'neuros'),
                'section'       => 'neuros_vacancy_single',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'random'        => esc_html__('Random', 'neuros'),
                    'date'          => esc_html__('Date', 'neuros'),
                    'name'          => esc_html__('Name', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'recent_vacancies_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------ //
        // --- Sort Order --- //
        // ------------------ //
        $wp_setting_name = 'recent_vacancies_order';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Sort Order', 'neuros'),
                'section'       => 'neuros_vacancy_single',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'desc'  => esc_html__('Descending', 'neuros'),
                    'asc'   => esc_html__('Ascending', 'neuros')
                ),
                'dependency'    => [
                    [
                        'control'   => 'recent_vacancies_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));


        // ------------------------------------ //
        // ---------- Services Panel ---------- //
        // ------------------------------------ //
        $wp_customize->add_panel('neuros_services_settings',
            array(
                'title'     => esc_html__('Services', 'neuros'),
                'priority'  => 210
            )
        );

        // ---########################--- //
        // ---### Services Archive ###--- //
        // ---########################--- //
        $wp_customize->add_section('neuros_service_archive',
            array(
                'title' => esc_html__('Archive Settings', 'neuros'),
                'panel' => 'neuros_services_settings'
            )
        );

        // ----------------------------------- //
        // --- Services Archive Page Title --- //
        // ----------------------------------- //
        $wp_setting_name = 'service_archive_page_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Services Archive Page Title', 'neuros'),
                'section'       => 'neuros_service_archive',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'description'   => esc_html__('Use variable \'%s\' for display Post type name', 'neuros')
            )
        ));

        // --------------------------------------- //
        // --- Services Archive Excerpt Length --- //
        // --------------------------------------- //
        $wp_setting_name = 'service_archive_excerpt_length';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Services Excerpt Length', 'neuros'),
                'section'       => 'neuros_service_archive',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'input_attrs' => [
                    'min'   => 0,
                    'step'  => 1
                ]
            )
        ));

        // -------------------------------------- //
        // --- Service Archive Columns Number --- //
        // -------------------------------------- //
        $wp_setting_name = 'service_archive_columns_number';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Service Archive Columns Number', 'neuros'),
                'section'       => 'neuros_service_archive',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'input_attrs' => [
                    'min'   => 1,
                    'max'   => 4,
                    'step'  => 1
                ]
            )
        ));

        // --------------------------------------- //
        // --- Services Archive Posts per Page --- //
        // --------------------------------------- //
        $wp_setting_name = 'service_archive_posts_per_page';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'absint'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Service Posts Per Page', 'neuros'),
                'section'       => 'neuros_service_archive',
                'type'          => 'number',
                'settings'      => $wp_setting_name,
                'input_attrs' => [
                    'min'   => 1,
                    'step'  => 1
                ]
            )
        ));

        // ---######################--- //
        // ---### Service Single ###--- //
        // ---######################--- //
        $wp_customize->add_section('neuros_service_single',
            array(
                'title' => esc_html__('Single Page Settings', 'neuros'),
                'panel' => 'neuros_services_settings'
            )
        );

        // ---------------------------------- //
        // --- Services Single Page Title --- //
        // ---------------------------------- //
        $wp_setting_name = 'service_single_page_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Service Single Page Title', 'neuros'),
                'section'       => 'neuros_service_single',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'description'   => esc_html__('Use variable \'%s\' for display Post name', 'neuros')
            )
        ));

        // ------------------------- //
        // --- Service Title Status --- //
        // ------------------------- //
        $wp_setting_name = 'service_title_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Service Title', 'neuros'),
                'section'   => 'neuros_service_single',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------- //
        // --- Service Title Status --- //
        // ------------------------- //
        $wp_setting_name = 'service_media_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Service Featured Image', 'neuros'),
                'section'   => 'neuros_service_single',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));


        // ------------------------------ //
        // ------- 404 Error Page ------- //
        // ------------------------------ //
        $wp_customize->add_section('neuros_error_page_settings',
            array(
                'title'     => esc_html__('Error 404 Page', 'neuros'),
                'priority'  => 210
            )
        );

        // ----------------------- //
        // --- 404 Error Title --- //
        // ----------------------- //
        $wp_setting_name = 'error_title';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'wp_kses_post'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('404 Error Title', 'neuros'),
                'section'       => 'neuros_error_page_settings',
                'type'          => 'textarea',
                'settings'      => $wp_setting_name
            )
        ));

        // ---------------------- //
        // --- 404 Error Text --- //
        // ---------------------- //
        $wp_setting_name = 'error_text';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'wp_kses_post'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('404 Error Info Text', 'neuros'),
                'section'       => 'neuros_error_page_settings',
                'type'          => 'textarea',
                'settings'      => $wp_setting_name
            )
        ));

        // ----------------------------- //
        // --- 404 Error Logo Status --- //
        // ----------------------------- //
        $wp_setting_name = 'error_logo_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Show Logo Image', 'neuros'),
                'section'       => 'neuros_error_page_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => array(
                    'on'    => esc_html__('Yes', 'neuros'),
                    'off'   => esc_html__('No', 'neuros')
                )
            )
        ));

        // --------------------------- //
        // --- 404 Page Logo Image --- //
        // --------------------------- //
        $wp_setting_name = 'error_logo_image';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'esc_url_raw'
            )
        );
        $wp_customize->add_control(new Neuros_Image_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Logo Image', 'neuros'),
                'section'       => 'neuros_error_page_settings',
                'settings'      => $wp_setting_name
            )
        ));        

        // ------------------------------------ //
        // --- 404 Error Home Button Status --- //
        // ------------------------------------ //
        $wp_setting_name = 'error_button_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Home Button', 'neuros'),
                'section'   => 'neuros_error_page_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ----------------------------- //
        // --- 404 Error Button Text --- //
        // ----------------------------- //
        $wp_setting_name = 'error_button_text';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'sanitize_text_field'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Home Button Text', 'neuros'),
                'section'       => 'neuros_error_page_settings',
                'type'          => 'text',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'error_button_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- 404 Error Socials Status --- //
        // -------------------------------- //
        $wp_setting_name = 'error_socials_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Social Buttons', 'neuros'),
                'section'   => 'neuros_error_page_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // --------------------------------- //
        // --- 404 Page Text Color --- //
        // --------------------------------- //
        $wp_setting_name = 'error_text_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Text Color', 'neuros'),
                'section'       => 'neuros_error_page_settings',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // --------------------------------- //
        // --- 404 Page Text Hover Color --- //
        // --------------------------------- //
        $wp_setting_name = 'error_text_hover_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Text Hover Color', 'neuros'),
                'section'       => 'neuros_error_page_settings',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette()
            )
        ));

        // -------------------------------------- //
        // --- 404 Error Background Customize --- //
        // -------------------------------------- //
        $wp_setting_name = 'error_background_customize';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Customize Background', 'neuros'),
                'section'   => 'neuros_error_page_settings',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // --------------------------------- //
        // --- 404 Page Background Color --- //
        // --------------------------------- //
        $wp_setting_name = 'error_background_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Color', 'neuros'),
                'section'       => 'neuros_error_page_settings',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'error_background_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // --------------------------------- //
        // --- 404 Page Background Image --- //
        // --------------------------------- //
        $wp_setting_name = 'error_background_image';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'esc_url_raw'
            )
        );
        $wp_customize->add_control(new Neuros_Image_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Image', 'neuros'),
                'section'       => 'neuros_error_page_settings',
                'settings'      => $wp_setting_name,
                'dependency'    => [
                    [
                        'control'   => 'error_background_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------------------ //
        // --- 404 Page Background Position --- //
        // ------------------------------------ //
        $wp_setting_name = 'error_background_position';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Position', 'neuros'),
                'section'       => 'neuros_error_page_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => neuros_get_background_position_options(),
                'dependency'    => [
                    [
                        'control'   => 'error_background_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ---------------------------------- //
        // --- 404 Page Background Repeat --- //
        // ---------------------------------- //
        $wp_setting_name = 'error_background_repeat';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Repeat', 'neuros'),
                'section'       => 'neuros_error_page_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => neuros_get_background_repeat_options(),
                'dependency'    => [
                    [
                        'control'   => 'error_background_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // -------------------------------- //
        // --- 404 Page Background Size --- //
        // -------------------------------- //
        $wp_setting_name = 'error_background_size';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Background Size', 'neuros'),
                'section'       => 'neuros_error_page_settings',
                'type'          => 'select',
                'settings'      => $wp_setting_name,
                'choices'       => neuros_get_background_size_options(),
                'dependency'    => [
                    [
                        'control'   => 'error_background_customize',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        if ( class_exists('WooCommerce') ) {

            // ------------------------------------------ //
            // ---------- WooCommerce Settings ---------- //
            // ------------------------------------------ //

            // ---######################--- //
            // ---### Single Product ###--- //
            // ---######################--- //
            $wp_customize->add_section('neuros_woocommerce_single_product',
                array(
                    'title' => esc_html__('Single Product', 'neuros'),
                    'panel' => 'woocommerce'
                )
            );

            // ----------------------------------------------- //
            // --- Single Product Related Products Section --- //
            // ----------------------------------------------- //
            $wp_setting_name = 'woo_single_product_show_related_section';
            $wp_customize->add_setting(
                $wp_setting_name,
                array(
                    'default'           => $neuros_customizer_default_values[$wp_setting_name],
                    'sanitize_callback'	=> 'neuros_sanitize_choice'
                )
            );
            $wp_customize->add_control(new Neuros_Customize_Control(
                $wp_customize,
                $wp_setting_name,
                array(
                    'label'     => esc_html__('Show Related Products', 'neuros'),
                    'section'   => 'neuros_woocommerce_single_product',
                    'type'      => 'select',
                    'settings'  => $wp_setting_name,
                    'choices'   => array(
                        'on'        => esc_html__('Yes', 'neuros'),
                        'off'       => esc_html__('No', 'neuros')
                    )
                )
            ));

            // -------------------------------- //
            // --- Related Products Heading --- //
            // -------------------------------- //
            $wp_setting_name = 'woo_related_title';
            $wp_customize->add_setting(
                $wp_setting_name,
                array(
                    'default'           => $neuros_customizer_default_values[$wp_setting_name],
                    'sanitize_callback'	=> 'sanitize_text_field'
                )
            );
            $wp_customize->add_control(new Neuros_Customize_Control(
                $wp_customize,
                $wp_setting_name,
                array(
                    'label'         => esc_html__('Related Products Section Title', 'neuros'),
                    'section'       => 'neuros_woocommerce_single_product',
                    'type'          => 'text',
                    'settings'      => $wp_setting_name,
                    'dependency'    => [
                        [
                            'control'   => 'woo_single_product_show_related_section',
                            'operator'  => '==',
                            'value'     => 'on'
                        ]
                    ]
                )
            ));

            // --------------------------------- //
            // --- Single Product Page Title --- //
            // --------------------------------- //
            $wp_setting_name = 'woo_single_product_title';
            $wp_customize->add_setting(
                $wp_setting_name,
                array(
                    'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                    'sanitize_callback'	=> 'sanitize_text_field'
                )
            );
            $wp_customize->add_control(new Neuros_Customize_Control(
                $wp_customize,
                $wp_setting_name,
                array(
                    'label'         => esc_html__('Single Product Page Title', 'neuros'),
                    'section'       => 'neuros_woocommerce_single_product',
                    'type'          => 'text',
                    'settings'      => $wp_setting_name,
                    'description'   => esc_html__('Use variable \'%s\' for display Product title', 'neuros')
                )
            ));

            // ------------------------- //
            // --- Show Product Name --- //
            // ------------------------- //
            $wp_setting_name = 'woo_single_product_show_name';
            $wp_customize->add_setting(
                $wp_setting_name,
                array(
                    'default'           => $neuros_customizer_default_values[$wp_setting_name],
                    'sanitize_callback'	=> 'neuros_sanitize_checkbox'
                )
            );
            $wp_customize->add_control(new Neuros_Customize_Control(
                $wp_customize,
                $wp_setting_name,
                array(
                    'label'         => esc_html__('Show Product name above the Price', 'neuros'),
                    'section'       => 'neuros_woocommerce_single_product',
                    'type'          => 'checkbox',
                    'settings'      => $wp_setting_name
                )
            ));


            // --------------------------------- //
            // --- Up-sells Products Heading --- //
            // --------------------------------- //
            $wp_setting_name = 'woo_upsells_title';
            $wp_customize->add_setting(
                $wp_setting_name,
                array(
                    'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                    'sanitize_callback'	=> 'sanitize_text_field'
                )
            );
            $wp_customize->add_control(new Neuros_Customize_Control(
                $wp_customize,
                $wp_setting_name,
                array(
                    'label'         => esc_html__('Up-sells Section Title', 'neuros'),
                    'section'       => 'neuros_woocommerce_single_product',
                    'type'          => 'text',
                    'settings'      => $wp_setting_name
                )
            ));

            // ---##########################--- //
            // ---### Product Categories ###--- //
            // ---##########################--- //
            $wp_customize->add_section('neuros_woocommerce_product_archive',
                array(
                    'title' => esc_html__('Product Archive', 'neuros'),
                    'panel' => 'woocommerce'
                )
            );

            // -------------------------------- //
            // --- Product Categories Title --- //
            // -------------------------------- //
            $wp_setting_name = 'woo_product_categories_title';
            $wp_customize->add_setting(
                $wp_setting_name,
                array(
                    'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                    'sanitize_callback'	=> 'sanitize_text_field'
                )
            );
            $wp_customize->add_control(new Neuros_Customize_Control(
                $wp_customize,
                $wp_setting_name,
                array(
                    'label'         => esc_html__('Product Category Page Title', 'neuros'),
                    'section'       => 'neuros_woocommerce_product_archive',
                    'type'          => 'text',
                    'settings'      => $wp_setting_name,
                    'description'   => esc_html__('Use variable \'%s\' for display Product category name', 'neuros')
                )
            ));

            // -------------------------- //
            // --- Product Tags Title --- //
            // -------------------------- //
            $wp_setting_name = 'woo_product_tags_title';
            $wp_customize->add_setting(
                $wp_setting_name,
                array(
                    'default'           => stripslashes($neuros_customizer_default_values[$wp_setting_name]),
                    'sanitize_callback'	=> 'sanitize_text_field'
                )
            );
            $wp_customize->add_control(new Neuros_Customize_Control(
                $wp_customize,
                $wp_setting_name,
                array(
                    'label'         => esc_html__('Product Tag Page Title', 'neuros'),
                    'section'       => 'neuros_woocommerce_product_archive',
                    'type'          => 'text',
                    'settings'      => $wp_setting_name,
                    'description'   => esc_html__('Use variable \'%s\' for display Product tag name', 'neuros')
                )
            ));

        }        

        // ----------------------------------------------- //
        // ---------- Additional Settings Panel ---------- //
        // ----------------------------------------------- //
        $wp_customize->add_panel('neuros_additional_settings',
            array(
                'title'     => esc_html__('Additional Settings', 'neuros'),
                'priority'  => 220
            )
        );

        // ---###################--- //
        // ---### Page Loader ###--- //
        // ---###################--- //
        $wp_customize->add_section('neuros_page_loader',
            array(
                'title' => esc_html__('Page Loader', 'neuros'),
                'panel' => 'neuros_additional_settings'
            )
        );

        // -------------------------- //
        // --- Page Loader Status --- //
        // -------------------------- //
        $wp_setting_name = 'page_loader_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Page Loader', 'neuros'),
                'section'   => 'neuros_page_loader',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // ------------------------- //
        // --- Page Loader Image --- //
        // ------------------------- //
        $wp_setting_name = 'page_loader_image';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback'	=> 'esc_url_raw'
            )
        );
        $wp_customize->add_control(new Neuros_Image_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Page Loader Image', 'neuros'),
                'section'       => 'neuros_page_loader',
                'settings'      => $wp_setting_name,
                'description'   => esc_html__('Maximum 100x100px', 'neuros'),
                'dependency'    => [
                    [
                        'control'   => 'page_loader_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // ------------------------- //
        // --- Footer Scroll To Top --- //
        // ------------------------- //

        $wp_customize->add_section('neuros_footer_scrolltop',
            array(
                'title' => esc_html__('Scroll To Top Button', 'neuros'),
                'panel' => 'neuros_additional_settings'
            )
        );

        // ------------------------------------- //
        // --- Footer Scroll To Top Status --- //
        // -------------------------------------- //
        $wp_setting_name = 'footer_scrolltop_status';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_choice'
            )
        );
        $wp_customize->add_control(new Neuros_Customize_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'     => esc_html__('Show Scroll To Top Button', 'neuros'),
                'section'   => 'neuros_footer_scrolltop',
                'type'      => 'select',
                'settings'  => $wp_setting_name,
                'choices'   => array(
                    'on'        => esc_html__('Yes', 'neuros'),
                    'off'       => esc_html__('No', 'neuros')
                )
            )
        ));

        // --------------------------------- //
        // --- Scroll Top Button Background Color --- //
        // --------------------------------- //
        $wp_setting_name = 'footer_scrolltop_bg_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Scroll To Top Button Background Color', 'neuros'),
                'section'       => 'neuros_footer_scrolltop',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_scrolltop_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));   

        $wp_setting_name = 'footer_scrolltop_bg_color_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Scroll To Top Button Hover Background Color', 'neuros'),
                'section'       => 'neuros_footer_scrolltop',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_scrolltop_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        // --------------------------------- //
        // --- Scroll Top Button Background Color --- //
        // --------------------------------- //
        $wp_setting_name = 'footer_scrolltop_color';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Scroll To Top Button Color', 'neuros'),
                'section'       => 'neuros_footer_scrolltop',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_scrolltop_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

        $wp_setting_name = 'footer_scrolltop_color_hover';
        $wp_customize->add_setting(
            $wp_setting_name,
            array(
                'default'           => $neuros_customizer_default_values[$wp_setting_name],
                'sanitize_callback' => 'neuros_sanitize_alpha_color'
            )
        );
        $wp_customize->add_control(new Neuros_Alpha_Color_Custom_Control(
            $wp_customize,
            $wp_setting_name,
            array(
                'label'         => esc_html__('Scroll To Top Button Hover Color', 'neuros'),
                'section'       => 'neuros_footer_scrolltop',
                'settings'      => $wp_setting_name,
                'show_opacity'  => true,
                'palette'       => neuros_get_custom_color_palette(),
                'dependency'    => [
                    [
                        'control'   => 'footer_scrolltop_status',
                        'operator'  => '==',
                        'value'     => 'on'
                    ]
                ]
            )
        ));

    }
}
