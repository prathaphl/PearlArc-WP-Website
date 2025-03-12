<?php
/*
 * Created by Artureanec
*/

# Custom Fields
if ( class_exists( 'RWMB_Field' ) ) {
    class RWMB_Help_Field extends RWMB_Key_Value_Field {
        public static function html( $meta, $field ) {
            // Question.
            $key                            = isset( $meta[0] ) ? $meta[0] : '';
            $attributes                     = self::get_attributes( $field, $key );
            $attributes['placeholder']      = esc_attr__('Title', 'neuros');
            $html                           = sprintf( '<input %s>', self::render_attributes( $attributes ) );

            // Answer.
            $val                            = isset( $meta[1] ) ? $meta[1] : '';
            $attributes                     = self::get_attributes( $field, $val );
            $attributes['placeholder']      = esc_attr__('Text', 'neuros');
            $attributes['id']               = $attributes['id'] . esc_attr('_text');
            $attributes['value']            = false;
            $html                           .= sprintf( '<textarea %s>%s</textarea>', self::render_attributes( $attributes ), $val );

            return $html;
        }
    }

    class RWMB_Benefits_Field extends RWMB_Input_Field {
        public static function admin_enqueue_scripts() {
            wp_enqueue_style( 'rwmb-color', RWMB_CSS_URL . 'color.css', array( 'wp-color-picker' ), RWMB_VER );

            $dependencies = array( 'wp-color-picker' );
            $args         = func_get_args();
            $field        = reset( $args );
            if ( ! empty( $field['alpha_channel'] ) ) {
                wp_enqueue_script( 'wp-color-picker-alpha', RWMB_JS_URL . 'wp-color-picker-alpha/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), RWMB_VER, true );
                $dependencies = array( 'wp-color-picker-alpha' );
            }
            wp_enqueue_script( 'rwmb-color', RWMB_JS_URL . 'color.js', $dependencies, RWMB_VER, true );
        }

        public static function html( $meta, $field ) {

            $icon_container = neuros_icon_picker_popover(true, true, true, true);

            // Icon.
            $key                                    = isset( $meta[0] ) ? $meta[0] : '';
            $attributes                             = self::get_attributes( $field, $key );
            $attributes['placeholder']              = esc_attr__('Icon', 'neuros');
            $attributes['class']                    = esc_attr('icp icp-auto');
            $attributes['type']                     = esc_attr('text');
            $attributes['readonly']                 = true;
            $attributes['id']                       = $attributes['id'] . esc_attr('_icon');
            $attributes['data-options']             = false;
            $attributes['data-alpha-enabled']       = false;
            $attributes['data-alpha-color-type']    = false;
            $html                                   = '<div class="rwmb-benefits-icon-picker">';
            $html                                   .= '<div class="input-group icp-container">';
            $html                                   .= sprintf('<input data-placement="bottomRight" %s">', self::render_attributes($attributes) );

            if ( !empty($key) ) {
                $html .= '<span class="input-group-addon"><i class="' . esc_attr($key) . '"></i></span></div>' . sprintf('%s', $icon_container);
            } else {
                $html .= '<span class="input-group-addon"></span></div>' . sprintf('%s', $icon_container);
            };
            $html                                   .= '</div>';

            // Title.
            if ( $field['field_title'] ) {
                $val                                    = isset( $meta[1] ) ? $meta[1] : '';
                $attributes                             = self::get_attributes( $field, $val );
                $attributes['placeholder']              = esc_attr__('Title', 'neuros');
                $attributes['id']                       = $attributes['id'] . esc_attr('_title');
                $attributes['data-options']             = false;
                $attributes['data-alpha-enabled']       = false;
                $attributes['data-alpha-color-type']    = false;
                $html                                   .= '<div class="rwmb-benefits-title">';
                $html                                   .= sprintf( '<input %s>', self::render_attributes($attributes) );
                $html                                   .= '</div>';
            }

            // Color.
            if ( $field['field_color'] ) {
                $key                                    = isset( $meta[2] ) ? $meta[2] : '';
                $attributes                             = self::get_attributes( $field, $key );
                $attributes['placeholder']              = false;
                $attributes['class']                    = 'rwmb-color wp-color-picker';
                $attributes['id']                       = $attributes['id'] . esc_attr('_color');
                $html                                   .= '<div class="rwmb-benefits-color">';
                $html                                   .= sprintf( '<input %s>', self::render_attributes($attributes) );
                $html                                   .= '</div>';
            }

            return $html;
        }

        protected static function begin_html( array $field ) : string {
            $desc = $field['desc'] ? "<p id='{$field['id']}_description' class='description'>{$field['desc']}</p>" : '';
            if ( empty( $field['name'] ) ) {
                return '<div class="rwmb-input">' . $desc;
            }
            return sprintf(
                '<div class="rwmb-label">
				<label for="%s">%s</label>
			</div>
			<div class="rwmb-input">
			%s',
                $field['id'],
                $field['name'],
                $desc
            );
        }

        protected static function input_description( array $field ) : string {
            return '';
        }

        protected static function label_description( array $field ) : string {
            return '';
        }

        public static function esc_meta( $meta ) {
            foreach ( (array) $meta as $k => $pairs ) {
                $meta[ $k ] = array_map( 'esc_attr', (array) $pairs );
            }
            return $meta;
        }

        public static function value( $new, $old, $post_id, $field ) {
            foreach ( $new as &$arr ) {
                if ( empty( $arr[0] ) && empty( $arr[1] ) ) {
                    $arr = false;
                }
            }
            $new = array_filter( $new );
            return $new;
        }

        public static function normalize( $field ) {
            $field['clone']         = true;
            $field['multiple']      = true;
            $field                  = wp_parse_args(
                $field,
                array(
                    'alpha_channel' => false,
                    'js_options'    => array(),
                )
            );
            $field                  = wp_parse_args(
                $field,
                array(
                    'field_title'   => false,
                    'field_color'   => false,
                    'size'          => 30,
                    'maxlength'     => false,
                    'pattern'       => false,
                )
            );
            $field['js_options']    = wp_parse_args(
                $field['js_options'],
                array(
                    'defaultColor' => false,
                    'hide'         => true,
                    'palettes'     => true,
                )
            );
            $field             = parent::normalize( $field );

            $field['attributes']['type'] = 'text';
            $field['placeholder']        = wp_parse_args(
                (array) $field['placeholder'],
                array(
                    'key'   => esc_html__( 'Icon', 'neuros' ),
                    'value' => esc_html__( 'Title', 'neuros' ),
                )
            );
            return $field;
        }

        public static function format_clone_value( $field, $value, $args, $post_id ) {
            return sprintf( '<label>%s:</label> %s', $value[0], $value[1] );
        }

        public static function get_attributes( $field, $value = null ) {
            $attributes         = parent::get_attributes( $field, $value );
            $attributes         = wp_parse_args(
                $attributes,
                array(
                    'size'          => $field['size'],
                    'maxlength'     => $field['maxlength'],
                    'pattern'       => $field['pattern'],
                    'placeholder'   => $field['placeholder'],
                    'data-options'  => wp_json_encode( $field['js_options'] ),
                )
            );
            $attributes['type'] = 'text';

            if ( $field['alpha_channel'] ) {
                $attributes['data-alpha-enabled']    = 'true';
                $attributes['data-alpha-color-type'] = 'hex';
            }

            return $attributes;
        }

        public static function format_single_value( $field, $value, $args, $post_id ) {
            return sprintf( "<span style='display:inline-block;width:20px;height:20px;border-radius:50%%;background:%s;'></span>", $value );
        }
    }

    class RWMB_Iconpicker_Field extends RWMB_Input_Field {

        public static function html( $meta, $field ) {
            $icon_container = neuros_icon_picker_popover(true, true, true, true);

            // Icon.
            $attributes                              = self::call( 'get_attributes', $field, $meta );
            $attributes['placeholder']              = '';
            $attributes['class']                    = esc_attr('icp icp-auto');
            $attributes['type']                     = esc_attr('text');
            $attributes['readonly']                 = true;
            $html                                   = '<div class="rwmb-iconpicker-icon-picker">';
            $html                                   .= '<div class="input-group icp-container">';
            $html                                   .= sprintf('<input data-placement="bottomRight" %s">', self::render_attributes($attributes) );

            if ( !empty($meta) ) {
                $html .= '<span class="input-group-addon"><i class="' . esc_attr($meta) . '"></i></span></div>' . sprintf('%s', $icon_container);
            } else {
                $html .= '<span class="input-group-addon"></span></div>' . sprintf('%s', $icon_container);
            };
            $html                                   .= '</div>';

            return $html;
        }

        public static function normalize( $field ) {
            $field = parent::normalize( $field );

            $field = wp_parse_args(
                $field,
                array(
                    'size'      => 30,
                    'maxlength' => false,
                    'pattern'   => false,
                )
            );

            return $field;
        }

        public static function get_attributes( $field, $value = null ) {
            $attributes = parent::get_attributes( $field, $value );
            $attributes = wp_parse_args(
                $attributes,
                array(
                    'size'        => $field['size'],
                    'maxlength'   => $field['maxlength'],
                    'pattern'     => $field['pattern'],
                    'placeholder' => $field['placeholder'],
                )
            );

            return $attributes;
        }
    }
}

# RWMB check
if (!function_exists('neuros_post_options')) {
    function neuros_post_options()
    {
        if (class_exists('RWMB_Loader')) {
            return true;
        } else {
            return false;
        }
    }
}

# RWMB get option
if (!function_exists('neuros_get_post_option')) {
    function neuros_get_post_option($name, $default = false) {
        if (class_exists('RWMB_Loader')) {
            if (rwmb_meta($name)) {
                return rwmb_meta($name);
            } else {
                return $default;
            }
        } else {
            return $default;
        }
    }
}

# RWMB get value
if (!function_exists('neuros_get_post_value')) {
    function neuros_get_post_value($name, $default = false) {
        if (class_exists('RWMB_Loader')) {
            if (rwmb_the_value($name, null, null, false)) {
                return rwmb_the_value($name, null, null, false);
            } else {
                return $default;
            }
        } else {
            return $default;
        }
    }
}

# RWMB get image
if (!function_exists('neuros_get_post_image')) {
    function neuros_get_post_image($name, $size = 'large', $default = false) {
        if (class_exists('RWMB_Loader')) {
            if (rwmb_meta($name)) {
                $out = '';
                $images = rwmb_meta( $name, array( 'size' => $size ) );
                foreach ( $images as $image ) {
                    $out .= '<div class="image_wrapper"><img src="'. $image['url']. '" alt="'. $image['alt']. '"></div>';
                }
                return $out;
            } else {
                return $default;
            }
        } else {
            return $default;
        }
    }
}

# RWMB get time
if (!function_exists('neuros_get_post_time')) {
    function neuros_get_post_time($time, $default = false) {
        if (class_exists('RWMB_Loader')) {
            if (rwmb_meta($time)) {
                $time = ' ' . rwmb_meta($time);
                $time = str_replace(esc_html__(' 0 Hours', 'neuros'), '', $time);
                $time = str_replace(esc_html__(' 0 Minutes', 'neuros'), '', $time);
                $time = str_replace(esc_html__(' 1 Hours', 'neuros'), esc_html__(' 1 Hour', 'neuros'), $time);
                $time = str_replace(esc_html__(' 1 Minutes', 'neuros'), esc_html__('1 Minute', 'neuros'), $time);
                return trim($time);
            } else {
                return $default;
            }
        } else {
            return $default;
        }
    }
}

if (class_exists('RWMB_Loader')) {
    if (!function_exists('neuros_custom_meta_boxes')) {
        add_filter('rwmb_meta_boxes', 'neuros_custom_meta_boxes');

        function neuros_custom_meta_boxes($meta_boxes) {
            $sidebar_list_default = array(
                'default' => esc_html__('Default', 'neuros')
            );
            $sidebar_list = neuros_get_all_sidebar_list();
            $sidebar_list = $sidebar_list_default + $sidebar_list;

            # Quote Post Format
            $meta_boxes[] = array(
                'title'         => esc_html__('Quote Post Format Settings', 'neuros'),
                'post_types'    => array('post'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'            => 'post_media_quote_text',
                        'name'          => esc_html__('Quote Text', 'neuros'),
                        'placeholder'   => esc_html__('Enter Quote Text', 'neuros'),
                        'type'          => 'textarea',
                    ),
                    array(
                        'id'            => 'post_media_quote_author',
                        'name'          => esc_html__('Quote Author Name', 'neuros'),
                        'placeholder'   => esc_html__('Quote Author Name', 'neuros'),
                        'type'          => 'text',
                    ),
                ),
            );

            # Gallery Post Format
            $meta_boxes[] = array(
                'title'         => esc_html__('Gallery Post Format Settings', 'neuros'),
                'post_types'    => array('post'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'        => 'post_media_gallery_select',
                        'name'      => esc_html__('Select Images', 'neuros'),
                        'type'      => 'image_advanced',
                    ),
                ),
            );

            # Video Post Format
            $meta_boxes[] = array(
                'title'         => esc_html__('Video Post Format Settings', 'neuros'),
                'post_types'    => array('post'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'        => 'post_media_video_type',
                        'name'      => esc_html__('Video Source', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'link',
                        'options'   => array(
                            'link'      => esc_html__('Outer Link', 'neuros'),
                            'self'      => esc_html__('Self Hosted', 'neuros')
                        )
                    ),
                    array(
                        'id'            => 'post_media_video_url',
                        'name'          => esc_html__('Enter Video Link', 'neuros'),
                        'type'          => 'oembed',
                        'desc'          => esc_html__('Copy link to the video from YouTube or other video-sharing website.', 'neuros'),
                        'attributes'    => array(
                            'data-dependency-id'    => 'post_media_video_type',
                            'data-dependency-val'   => 'link'
                        )
                    ),
                    array(
                        'id'                => 'post_media_video_select',
                        'name'              => esc_html__('Select Video From Media Library', 'neuros'),
                        'type'              => 'video',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'attributes'        => array(
                            'data-dependency-id'    => 'post_media_video_type',
                            'data-dependency-val'   => 'self'
                        )
                    ),
                ),
            );

            # Content Output Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Single Post Settings', 'neuros'),
                'post_types'    => array('post'),
                'context'       => 'advanced',
                'fields'        => array(

                    //-- Single Post Settings
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Post Output Settings', 'neuros'),
                    ),

                    array(
                        'id'        => 'post_media_image_status',
                        'name'      => esc_html__('Show Media Block', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'post_category_status',
                        'name'      => esc_html__('Show Post Categories', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'post_date_status',
                        'name'      => esc_html__('Show Post Date', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'post_author_status',
                        'name'      => esc_html__('Show Post Author', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'post_comment_counter_status',
                        'name'      => esc_html__('Show Number of Post Comments', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'post_title_status',
                        'name'      => esc_html__('Show Post Title', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'post_tags_status',
                        'name'      => esc_html__('Show Post Tags', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'post_socials_status',
                        'name'      => esc_html__('Show Post Social Buttons', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Sticky Header
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Recent Posts', 'neuros'),
                    ),

                    array(
                        'id'        => 'recent_posts_status',
                        'name'      => esc_html__('Show Recent Posts', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'recent_posts_customize',
                        'name'      => esc_html__('Customize', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_section_heading',
                        'name'          => esc_html__('Recent Posts Section Title', 'neuros'),
                        'type'          => 'text',
                        'std'           => '',
                        'placeholder'   => neuros_get_theme_mod('recent_posts_section_heading'),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_number',
                        'name'          => esc_html__('Number of Posts', 'neuros'),
                        'type'          => 'select',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            '2'             => esc_html__('2 Items', 'neuros'),
                            '3'             => esc_html__('3 Items', 'neuros'),
                            '4'             => esc_html__('4 Items', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_order_by',
                        'name'          => esc_html__('Order By', 'neuros'),
                        'type'          => 'select',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'random'        => esc_html__('Random', 'neuros'),
                            'date'          => esc_html__('Date', 'neuros'),
                            'name'          => esc_html__('Name', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_order',
                        'name'          => esc_html__('Sort Order', 'neuros'),
                        'type'          => 'select',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'desc'          => esc_html__('Descending', 'neuros'),
                            'asc'           => esc_html__('Ascending', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_image',
                        'name'          => esc_html__('Show Recent Post Image', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'on'            => esc_html__('Yes', 'neuros'),
                            'off'           => esc_html__('No', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_category',
                        'name'          => esc_html__('Show Recent Post Categories', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'on'            => esc_html__('Yes', 'neuros'),
                            'off'           => esc_html__('No', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_date',
                        'name'          => esc_html__('Show Recent Post Date', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'on'            => esc_html__('Yes', 'neuros'),
                            'off'           => esc_html__('No', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_author',
                        'name'          => esc_html__('Show Recent Post Author', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'on'            => esc_html__('Yes', 'neuros'),
                            'off'           => esc_html__('No', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_title',
                        'name'          => esc_html__('Show Recent Post Title', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'on'            => esc_html__('Yes', 'neuros'),
                            'off'           => esc_html__('No', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_excerpt',
                        'name'          => esc_html__('Show Recent Post Excerpt', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'on'            => esc_html__('Yes', 'neuros'),
                            'off'           => esc_html__('No', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_excerpt_length',
                        'name'          => esc_html__('Recent Post Excerpt Length', 'neuros'),
                        'type'          => 'number',
                        'placeholder'   => neuros_get_theme_mod('recent_posts_excerpt_length'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_tags',
                        'name'          => esc_html__('Show Recent Post Tags', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'on'            => esc_html__('Yes', 'neuros'),
                            'off'           => esc_html__('No', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_more',
                        'name'          => esc_html__('Show Recent Post \'Read More\' Button', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'on'            => esc_html__('Yes', 'neuros'),
                            'off'           => esc_html__('No', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    )
                )
            );

            # Projects Custom Fields
            $meta_boxes[] = array(
                'title'         => esc_html__('Project Fields', 'neuros'),
                'post_types'    => array('neuros_project'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'        => 'project_view',
                        'name'      => esc_html__('Project View', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'advanced'  => esc_html__('Advanced', 'neuros')
                        )
                    ),
                    array(
                        'id'            => 'project_description',
                        'name'          => esc_html__('Project Description', 'neuros'),
                        'type'          => 'wysiwyg',
                        'options'       => array(
                            'textarea_rows' => 6
                        )
                    ),
                    array(
                        'id'                => 'project_logo_image',
                        'name'              => esc_html__('Project Logo Image', 'neuros'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'attributes'    => array(
                            'data-dependency-id'    => 'project_view',
                            'data-dependency-val'   => 'advanced'
                        )
                    ),
                    array(
                        'id'            => 'project_year',
                        'name'          => esc_html__('Year', 'neuros'),
                        'type'          => 'text'
                    ),
                    array(
                        'id'            => 'project_strategy',
                        'name'          => esc_html__('Strategy', 'neuros'),
                        'type'          => 'text',
                        'add_button'    => esc_html__('+ Add More', 'neuros'),
                        'clone'         => true
                    ),
                    array(
                        'id'            => 'project_design',
                        'name'          => esc_html__('Design', 'neuros'),
                        'type'          => 'text',
                        'add_button'    => esc_html__('+ Add More', 'neuros'),
                        'clone'         => true
                    ),
                    array(
                        'id'            => 'project_client',
                        'name'          => esc_html__('Client', 'neuros'),
                        'type'          => 'text'
                    ),
                    array(
                        'id'            => 'project_button',
                        'name'          => esc_html__('Link Button', 'neuros'),
                        'type'          => 'text_list',
                        'options'       => array(
                            esc_attr__('Link', 'neuros')   => esc_html__('Link', 'neuros'),
                            esc_attr__('Label', 'neuros')  => esc_html__('Label', 'neuros')
                        ),
                        'clone'         => false
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'        => 'post_media_video_type',
                        'name'      => esc_html__('Video Source', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'link',
                        'options'   => array(
                            'link'      => esc_html__('Outer Link', 'neuros'),
                            'self'      => esc_html__('Self Hosted', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'project_view',
                            'data-dependency-val'   => 'default'
                        )
                    ),
                    array(
                        'id'            => 'post_media_video_url',
                        'name'          => esc_html__('Enter Video Link', 'neuros'),
                        'type'          => 'oembed',
                        'desc'          => esc_html__('Copy link to the video from YouTube or other video-sharing website.', 'neuros'),
                        'attributes'    => array(
                            'data-dependency-id'    => 'post_media_video_type, project_view',
                            'data-dependency-val'   => 'link, default'
                        )
                    ),
                    array(
                        'id'                => 'post_media_video_select',
                        'name'              => esc_html__('Select Video From Media Library', 'neuros'),
                        'type'              => 'video',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'attributes'        => array(
                            'data-dependency-id'    => 'post_media_video_type, project_view',
                            'data-dependency-val'   => 'self, default'
                        )
                    ),
                    array(
                        'id'                => 'post_media_video_poster',
                        'name'              => esc_html__('Video Poster Image', 'neuros'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'attributes'    => array(
                            'data-dependency-id'    => 'project_view',
                            'data-dependency-val'   => 'default'
                        )
                    ),
                    array(
                        'id'            => 'project_gallery',
                        'name'          => esc_html__('Project Gallery', 'neuros'),
                        'type'          => 'image_advanced',
                        'attributes'    => array(
                            'data-dependency-id'    => 'project_view',
                            'data-dependency-val'   => 'default'
                        )
                    ),
                    array(
                        'id'                => 'project_audio_image',
                        'name'              => esc_html__('Audio Content Type Slider Image', 'neuros'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'thumbnail'
                    ),
                    array(
                        'id'                => 'project_audio_file',
                        'name'              => esc_html__('Slider Audio File', 'neuros'),
                        'type'              => 'file_advanced',
                        'max_file_uploads'  => 1,
                        'mime_type'        => 'audio',
                    ),
                    array(
                        'id'                => 'project_cards_image',
                        'name'              => esc_html__('Cards Listing Image', 'neuros'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full'
                    ),
                )
            );

            # Team Member Custom Fields
            $meta_boxes[] = array(
                'title'         => esc_html__('Team Member Fields', 'neuros'),
                'post_types'    => array('neuros_team_member'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'            => 'team_member_position',
                        'name'          => esc_html__('Position', 'neuros'),
                        'type'          => 'text'
                    ),
                    array(
                        'id'            => 'team_member_tag',
                        'name'          => esc_html__('Team Member Tag', 'neuros'),
                        'type'          => 'text'
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'team_member_short_text',
                        'name'          => esc_html__('Member Short Info', 'neuros'),
                        'type'          => 'wysiwyg',
                        'options'       => array(
                            'textarea_rows' => 6,
                            'teeny'         => true
                        ),
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'team_member_experience_title',
                        'name'          => esc_html__('Experience & Education Section Title', 'neuros'),
                        'type'          => 'text',
                        'std'           => wp_kses_post(__('My experience<br> & years of education', 'neuros'))
                    ),
                    array(
                        'id'            => 'team_member_education_list',
                        'name'          => esc_html__('Education List', 'neuros'),
                        'type'          => 'text_list',
                        'clone'         => true,
                        'options'       => array(                            
                            esc_attr__('Period', 'neuros')         => esc_html__('Period', 'neuros'),
                            esc_attr__('Title', 'neuros')          => esc_html__('Title', 'neuros'),
                            esc_attr__('Description', 'neuros')    => esc_html__('Description', 'neuros'),
                        ),
                        'add_button'    => esc_html__('+ Add More', 'neuros')
                    ),
                    array(
                        'id'            => 'team_member_experience_list',
                        'name'          => esc_html__('Experience List', 'neuros'),
                        'type'          => 'text_list',
                        'clone'         => true,
                        'options'       => array(
                            esc_attr__('Period', 'neuros')         => esc_html__('Period', 'neuros'),
                            esc_attr__('Title', 'neuros')          => esc_html__('Title', 'neuros'),                            
                            esc_attr__('Description', 'neuros')    => esc_html__('Description', 'neuros'),
                        ),
                        'add_button'    => esc_html__('+ Add More', 'neuros')
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'team_member_socials',
                        'name'          => esc_html__('Social Links', 'neuros'),
                        'type'          => 'key_value',
                        'placeholder'   => array(
                            'key'           => esc_attr__('Icon', 'neuros'),
                            'value'         => esc_attr__('Link', 'neuros')
                        ),
                        'add_button'    => esc_html__('+ Add More', 'neuros'),
                        'class'         => 'icon-picker',
                        'clone'         => true,
                        'sort_clone'    => true,
                        'max_clone'     => 7
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'team_member_contact_info_title',
                        'name'          => esc_html__('Contact Information Title', 'neuros'),
                        'type'          => 'text',
                        'std'           => esc_html__('Contact Information', 'neuros')
                    ),
                    array(
                        'id'            => 'team_member_contact_info_item',
                        'name'          => esc_html__('Contact Information Item', 'neuros'),
                        'type'          => 'text',
                        'clone'         => true,
                        'add_button'    => esc_html__('+ Add More', 'neuros')
                    ),
                    array(
                        'id'            => 'team_member_email',
                        'name'          => esc_html__('Contact Information E-mail', 'neuros'),
                        'type'          => 'text'
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'                => 'team_member_logo_image',
                        'name'              => esc_html__('Achievement Logo Image', 'neuros'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full'
                    ),
                    array(
                        'id'        => 'team_member_boxes',
                        'name'      => 'Achievement Boxes',
                        'type'      => 'text_list',
                        'clone'     => true,
                        'options'   => array(
                            esc_attr__('Value', 'neuros') => esc_html__('Value', 'neuros'),
                            esc_attr__('Title', 'neuros') => esc_html__('Title', 'neuros')
                        ),
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'team_member_responsibilities_title',
                        'name'          => esc_html__('Responsibilities Title', 'neuros'),
                        'type'          => 'text',
                        'std'           => esc_html__('Responsibilities', 'neuros')
                    ),
                    array(
                        'id'            => 'team_member_responsibilities_list',
                        'name'          => esc_html__('Responsibilities List', 'neuros'),
                        'type'          => 'text',
                        'clone'         => true,
                        'add_button'    => esc_html__('+ Add More', 'neuros')
                    ),                   
                )
            );

            # Career Custom Fields
            $meta_boxes[] = array(
                'title'         => esc_html__('Career Fields', 'neuros'),
                'post_types'    => array('neuros_vacancy'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'        => 'vacancy_occupation',
                        'name'      => esc_html__('Occupation', 'neuros'),
                        'type'      => 'text',
                        'desc'      => esc_html__('Full-time, part-time, contract, etc.', 'neuros')
                    ),
                    array(
                        'id'        => 'vacancy_location',
                        'name'      => esc_html__('Location', 'neuros'),
                        'type'      => 'text',
                    ),
                    array(
                        'id'        => 'vacancy_salary',
                        'name'      => esc_html__('Salary', 'neuros'),
                        'type'      => 'text',
                    ),
                    array(
                        'id'        => 'vacancy_responsibilities',
                        'name'      => esc_html__('Responsibilities', 'neuros'),
                        'type'      => 'wysiwyg',
                        'raw'       => false,
                        'options'   => array(
                            'textarea_rows' => 8,
                            'teeny'         => true,
                        ),
                    ),
                    array(
                        'id'        => 'vacancy_qualifications',
                        'name'      => esc_html__('Preferred Qualifications', 'neuros'),
                        'type'      => 'wysiwyg',
                        'raw'       => false,
                        'options'   => array(
                            'textarea_rows' => 8,
                            'teeny'         => true,
                        ),
                    ),
                    array(
                        'id'            => 'vacancy_button',
                        'name'          => esc_html__('Contact Button', 'neuros'),
                        'type'          => 'text_list',
                        'options'       => array(
                            esc_attr__('Link', 'neuros')   => esc_html__('Link', 'neuros'),
                            esc_attr__('Label', 'neuros')  => esc_html__('Label', 'neuros')
                        ),
                        'clone'         => false
                    ),

                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Recent Careers', 'neuros'),
                    ),

                    array(
                        'id'        => 'recent_vacancies_status',
                        'name'      => esc_html__('Show Recent Careers', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'recent_vacancies_customize',
                        'name'      => esc_html__('Customize', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'recent_vacancies_section_heading',
                        'name'          => esc_html__('Recent Careers Section Title', 'neuros'),
                        'type'          => 'textarea',
                        'std'           => '',
                        'placeholder'   => neuros_get_theme_mod('recent_vacancies_section_heading')
                    ),

                    array(
                        'id'            => 'recent_vacancies_number',
                        'name'          => esc_html__('Number of Posts', 'neuros'),
                        'type'          => 'number',
                        'min'           => 1,
                        'max'           => 20,
                        'step'          => 1,
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_vacancies_order_by',
                        'name'          => esc_html__('Order By', 'neuros'),
                        'type'          => 'select',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'random'        => esc_html__('Random', 'neuros'),
                            'date'          => esc_html__('Date', 'neuros'),
                            'name'          => esc_html__('Name', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_vacancies_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_vacancies_order',
                        'name'          => esc_html__('Sort Order', 'neuros'),
                        'type'          => 'select',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'desc'          => esc_html__('Descending', 'neuros'),
                            'asc'           => esc_html__('Ascending', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_vacancies_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                )
            );

            # Service Post Icon Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Service Icons', 'neuros'),
                'post_types'    => array('neuros_service'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'            => 'service_main_icon',
                        'type'          => 'iconpicker',
                        'name'          => esc_html__('Font Icon', 'neuros'),
                    ),
                    array(
                        'id'            => 'service_main_icon_color',
                        'name'          => esc_html__('Font Icon Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),
                    array(
                        'type' => 'textarea',
                        'name' => esc_html__( 'SVG Icon Code', 'neuros' ),
                        'id'   => 'service_icon_svg',
                        'rows' => 10,
                        'sanitize_callback' => 'none'
                    ),
                    array(
                        'id'            => 'service_svg_icon_color',
                        'name'          => esc_html__('SVG Icon Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),
                )
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Service Subtitle', 'neuros'),
                'post_types'    => array('neuros_service'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'        => 'service_subtitle',
                        'name'      => esc_html__('Service Subtitle', 'neuros'),
                        'type'      => 'text',
                    ),
                )
            );

            # Service Content Output Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Single Service Settings', 'neuros'),
                'post_types'    => array('neuros_service'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'        => 'service_title_status',
                        'name'      => esc_html__('Show Service Title', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),
                    array(
                        'id'        => 'service_media_status',
                        'name'      => esc_html__('Show Service Featured Image', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),
                )
            );

            # Project Content Output Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Single Post Settings', 'neuros'),
                'post_types'    => array('neuros_project'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'        => 'project_title_status',
                        'name'      => esc_html__('Show Project Title', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),
                )
            );

            # Case Study Custom Fields
            $meta_boxes[] = array(
                'title'         => esc_html__('Case Study Fields', 'neuros'),
                'post_types'    => array('neuros_case_study'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'                => 'case_study_logo',
                        'name'              => esc_html__('Logo Image', 'neuros'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full'
                    ),
                    array(
                        'id'        => 'case_study_client',
                        'name'      => esc_html__('Client', 'neuros'),
                        'type'      => 'text'
                    ),
                    array(
                        'id'            => 'case_study_sector',
                        'name'          => esc_html__('Sector', 'neuros'),
                        'type'          => 'text',
                        'add_button'    => esc_html__('+ Add More', 'neuros'),
                        'clone'         => true
                    ),

                    array(
                        'id'        => 'case_study_offering',
                        'name'      => esc_html__('Offering', 'neuros'),
                        'type'      => 'text'
                    ),                    
                    array(
                        'id'        => 'case_study_features',
                        'name'      => 'Features',
                        'type'      => 'wysiwyg',
                        'raw'       => false,
                        'options'   => array(
                            'textarea_rows' => 8,
                            'teeny'         => true,
                        ),
                    ),
                )
            );

            # Content Output Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Case Study Settings', 'neuros'),
                'post_types'    => array('neuros_case_study'),
                'context'       => 'advanced',
                'fields'        => array(

                    array(
                        'id'        => 'post_media_image_status',
                        'name'      => esc_html__('Show Media Block', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'post_category_status',
                        'name'      => esc_html__('Show Post Categories', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'post_date_status',
                        'name'      => esc_html__('Show Post Date', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'post_author_status',
                        'name'      => esc_html__('Show Post Author', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'post_title_status',
                        'name'      => esc_html__('Show Post Title', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'post_tags_status',
                        'name'      => esc_html__('Show Post Tags', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),
                )
            );

            # Post and Page Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Color Settings', 'neuros'),
                'post_types'    => array('post', 'page', 'neuros_project', 'neuros_team_member', 'neuros_vacancy', 'neuros_service', 'neuros_case_study', 'product'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(

                    # Color Options

                    //-- Standard colors
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Standard Colors', 'neuros'),
                    ),

                    array(
                        'id'            => 'standard_default_text_color',
                        'name'          => esc_html__('Default Text Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_dark_text_color',
                        'name'          => esc_html__('Dark Text Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_light_text_color',
                        'name'          => esc_html__('Light Text Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_accent_text_color',
                        'name'          => esc_html__('Accent Text Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),
                    array(
                        'id'            => 'standard_contrast_text_color',
                        'name'          => esc_html__('Contrast Text Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),  
                    array(
                        'id'            => 'standard_input_dark_color',
                        'name'          => esc_html__('Input Dark Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),              

                    array(
                        'type' => 'divider',
                    ),

                    array(
                        'id'            => 'standard_border_color',
                        'name'          => esc_html__('Border Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_border_hover_color',
                        'name'          => esc_html__('Hovered Border Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    array(
                        'id'            => 'standard_background_color',
                        'name'          => esc_html__('Background Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_background_alter_color',
                        'name'          => esc_html__('Alternative Background Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    array(
                        'id'            => 'standard_button_text_color',
                        'name'          => esc_html__('Button Text Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_button_border_color',
                        'name'          => esc_html__('Button Border Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_button_border_color_add',
                        'name'          => esc_html__('Button Border Color Additional', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_button_background_color',
                        'name'          => esc_html__('Button Background Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_button_background_color_add',
                        'name'          => esc_html__('Button Background Color Additional', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_button_text_hover',
                        'name'          => esc_html__('Button Text Hover', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_button_border_hover',
                        'name'          => esc_html__('Button Border Hover', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_button_border_hover_add',
                        'name'          => esc_html__('Button Border Hover Additional', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_button_background_hover',
                        'name'          => esc_html__('Button Background Hover', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_button_background_hover_add',
                        'name'          => esc_html__('Button Background Hover Additional', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'        => 'standard_button_border_style',
                        'name'      => esc_html__('Button Border Style', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'     => esc_html__('Default', 'neuros'),
                            'gradient'    => esc_html__('Gradient', 'neuros'),
                            'solid'       => esc_html__('Solid', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'standard_background_border_style',
                        'name'      => esc_html__('Button Background Style', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'     => esc_html__('Default', 'neuros'),
                            'gradient'    => esc_html__('Gradient', 'neuros'),
                            'solid'       => esc_html__('Solid', 'neuros')
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Contrast Colors
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Contrast Colors', 'neuros'),
                    ),

                    array(
                        'id'            => 'contrast_default_text_color',
                        'name'          => esc_html__('Default Text Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_dark_text_color',
                        'name'          => esc_html__('Dark Text Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_light_text_color',
                        'name'          => esc_html__('Light Text Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_accent_text_color',
                        'name'          => esc_html__('Accent Text Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_input_dark_color',
                        'name'          => esc_html__('Input Dark Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),    

                    array(
                        'type' => 'divider',
                    ),

                    array(
                        'id'            => 'contrast_border_color',
                        'name'          => esc_html__('Border Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_border_hover_color',
                        'name'          => esc_html__('Hovered Border Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    array(
                        'id'            => 'contrast_background_color',
                        'name'          => esc_html__('Background Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_background_alter_color',
                        'name'          => esc_html__('Alternative Background Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    array(
                        'id'            => 'contrast_button_text_color',
                        'name'          => esc_html__('Button Text Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_button_border_color',
                        'name'          => esc_html__('Button Border Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_button_border_color_add',
                        'name'          => esc_html__('Button Border Color Additional', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_button_background_color',
                        'name'          => esc_html__('Button Background Color', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_button_background_color_add',
                        'name'          => esc_html__('Button Background Color Additional', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_button_text_hover',
                        'name'          => esc_html__('Button Text Hover', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_button_border_hover',
                        'name'          => esc_html__('Button Border Hover', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_button_border_hover_add',
                        'name'          => esc_html__('Button Border Hover Additional', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_button_background_hover',
                        'name'          => esc_html__('Button Background Hover', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_button_background_hover_add',
                        'name'          => esc_html__('Button Background Hover Additional', 'neuros'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'        => 'contrast_button_border_style',
                        'name'      => esc_html__('Button Border Style', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'     => esc_html__('Default', 'neuros'),
                            'gradient'    => esc_html__('Gradient', 'neuros'),
                            'solid'       => esc_html__('Solid', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'contrast_button_background_style',
                        'name'      => esc_html__('Button Background Style', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'     => esc_html__('Default', 'neuros'),
                            'gradient'    => esc_html__('Gradient', 'neuros'),
                            'solid'       => esc_html__('Solid', 'neuros')
                        )
                    ),
                )
            );

             $meta_boxes[] = array(
                'title'         => esc_html__('Page Settings', 'neuros'),
                'post_types'    => array('post', 'page', 'neuros_project', 'neuros_team_member', 'neuros_vacancy', 'neuros_service', 'neuros_case_study', 'product'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'            => 'page_top_background_color',
                        'name'          => esc_html__('Page Top Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                    ),
                    array(
                        'id'        => 'page_top_border_radius',
                        'name'      => esc_html__('Page Top Border Radius', 'neuros'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('On', 'neuros'),
                            'off'       => esc_html__('Off', 'neuros')
                        )
                    ),
                    array(
                        'id'        => 'body_lines_status',
                        'name'      => esc_html__('Show page background lines', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'body_lines_color',
                        'name'          => esc_html__('Lines Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'body_lines_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),
                ),
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Top Bar Settings', 'neuros'),
                'post_types'    => array('post', 'page', 'neuros_team_member', 'neuros_vacancy', 'neuros_service', 'neuros_case_study', 'product'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(

                # Top Bar Options

                    //-- Top Bar General
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('General', 'neuros'),
                    ),

                    array(
                        'id'        => 'top_bar_status',
                        'name'      => esc_html__('Show Top Bar', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'top_bar_customize',
                        'name'      => esc_html__('Customize', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'top_bar_default_text_color',
                        'name'          => esc_html__('Default Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_dark_text_color',
                        'name'          => esc_html__('Dark Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_light_text_color',
                        'name'          => esc_html__('Light Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_accent_text_color',
                        'name'          => esc_html__('Accent Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_border_color',
                        'name'          => esc_html__('Border Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_border_hover_color',
                        'name'          => esc_html__('Hovered Border Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_background_color',
                        'name'          => esc_html__('Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_background_alter_color',
                        'name'          => esc_html__('Alternative Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_button_text_color',
                        'name'          => esc_html__('Button Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_button_border_color',
                        'name'          => esc_html__('Button Border Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_button_background_color',
                        'name'          => esc_html__('Button Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_button_text_hover',
                        'name'          => esc_html__('Button Text Hover', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_button_border_hover',
                        'name'          => esc_html__('Button Border Hover', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_button_background_hover',
                        'name'          => esc_html__('Button Background Hover', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Top Bar Social Buttons
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Social Buttons', 'neuros'),
                    ),

                    array(
                        'id'        => 'top_bar_socials_status',
                        'name'      => esc_html__('Show Social Buttons', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Top Bar Additional Text
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Additional Text', 'neuros'),
                    ),

                    array(
                        'id'        => 'top_bar_additional_text_status',
                        'name'      => esc_html__('Show Additional Text', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'top_bar_additional_text_title',
                        'name'          => esc_html__('Additional Text Title', 'neuros'),
                        'type'          => 'textarea',
                        'placeholder'   => neuros_get_theme_mod('top_bar_additional_text_title'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_additional_text_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_additional_text',
                        'name'          => esc_html__('Additional Text', 'neuros'),
                        'type'          => 'textarea',
                        'placeholder'   => neuros_get_theme_mod('top_bar_additional_text'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_additional_text_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Top Bar Contacts
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Contacts', 'neuros'),
                    ),

                    array(
                        'id'            => 'top_bar_contacts_title',
                        'name'          => esc_html__('Mobile Menu Contacts Title', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('top_bar_contacts_title'),
                        'std'           => ''
                    ),

                    array(
                        'id'        => 'top_bar_contacts_phone_status',
                        'name'      => esc_html__('Show Phone Number', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'top_bar_contacts_phone_title',
                        'name'          => esc_html__('Phone Title', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('top_bar_contacts_phone_title'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_contacts_phone_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_contacts_phone',
                        'name'          => esc_html__('Phone Number', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('top_bar_contacts_phone'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_contacts_phone_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'        => 'top_bar_contacts_email_status',
                        'name'      => esc_html__('Show Email Address', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                     array(
                        'id'            => 'top_bar_contacts_email_title',
                        'name'          => esc_html__('Email Title', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('top_bar_contacts_email_title'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_contacts_email_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_contacts_email',
                        'name'          => esc_html__('Email Address', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('top_bar_contacts_email'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_contacts_email_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),                    

                    array(
                        'id'        => 'top_bar_contacts_address_status',
                        'name'      => esc_html__('Show Address', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'top_bar_contacts_address_title',
                        'name'          => esc_html__('Address Title', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('top_bar_contacts_address_title'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_contacts_address_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_contacts_address',
                        'name'          => esc_html__('Address', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('top_bar_contacts_address'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_contacts_address_status',
                            'data-dependency-val'   => 'on'
                        )
                    )

                )
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Header Settings', 'neuros'),
                'post_types'    => array('post', 'page', 'neuros_project', 'neuros_team_member', 'neuros_vacancy', 'neuros_service', 'neuros_case_study', 'product'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(

                # Header Options

                    //-- Header General
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('General', 'neuros'),
                    ),

                    array(
                        'id'        => 'header_status',
                        'name'      => esc_html__('Show Header', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'header_style',
                        'name'      => esc_html__('Header Style', 'neuros'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'type-1'    => esc_html__('Style 1', 'neuros'),
                            'type-2'    => esc_html__('Style 2', 'neuros'),
                            'type-3'    => esc_html__('Style 3', 'neuros'),
                            'type-4'    => esc_html__('Style 4', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'header_position',
                        'name'      => esc_html__('Header Position', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'above'     => esc_html__('Above', 'neuros'),
                            'over'      => esc_html__('Over', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'header_transparent',
                        'name'          => esc_html__('Transparent Header', 'neuros'),
                        'type'          => 'checkbox',
                        'std'           => 0,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_position',
                            'data-dependency-val'   => 'over'
                        )
                    ),

                    array(
                        'id'        => 'header_border',
                        'name'      => esc_html__('Border Style', 'neuros'),
                        'type'      => 'select',
                        'options'   => array(
                            'default' => esc_html__('Default', 'neuros'),
                            'none'    => esc_html__('No Border', 'neuros'),
                            'border'  => esc_html__('Border', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'header_customize',
                        'name'      => esc_html__('Customize', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'header_offset_top',
                        'name'      => esc_html__('Header Offset Top, in px', 'neuros'),
                        'type'      => 'slider',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_default_text_color',
                        'name'          => esc_html__('Default Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_dark_text_color',
                        'name'          => esc_html__('Dark Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_light_text_color',
                        'name'          => esc_html__('Light Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_accent_text_color',
                        'name'          => esc_html__('Accent Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_current_text_color',
                        'name'          => esc_html__('Current Page/Post Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_current_background_color',
                        'name'          => esc_html__('Current Page/Post Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_border_color',
                        'name'          => esc_html__('Border Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_border_hover_color',
                        'name'          => esc_html__('Hovered Border Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_background_color',
                        'name'          => esc_html__('Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_background_alter_color',
                        'name'          => esc_html__('Alternative Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_text_color',
                        'name'          => esc_html__('Button Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_border_color',
                        'name'          => esc_html__('Button Border Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_border_color_add',
                        'name'          => esc_html__('Button Border Color Additional', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_background_color',
                        'name'          => esc_html__('Button Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_background_color_add',
                        'name'          => esc_html__('Button Background Color Additional', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_text_hover',
                        'name'          => esc_html__('Button Text Hover', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_border_hover',
                        'name'          => esc_html__('Button Border Hover', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_border_hover_add',
                        'name'          => esc_html__('Button Border Hover Additional', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_background_hover',
                        'name'          => esc_html__('Button Background Hover', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_background_hover_add',
                        'name'          => esc_html__('Button Background Hover Additional', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'        => 'header_button_border_style',
                        'name'      => esc_html__('Button Border Style', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'     => esc_html__('Default', 'neuros'),
                            'gradient'    => esc_html__('Gradient', 'neuros'),
                            'solid'       => esc_html__('Solid', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'        => 'header_button_background_style',
                        'name'      => esc_html__('Button Background Style', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'     => esc_html__('Default', 'neuros'),
                            'gradient'    => esc_html__('Gradient', 'neuros'),
                            'solid'       => esc_html__('Solid', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_menu_text_color',
                        'name'          => esc_html__('Header Menu Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_menu_text_color_hover',
                        'name'          => esc_html__('Header Menu Text Hover Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_menu_text_background_color_hover',
                        'name'          => esc_html__('Header Menu Text Background Hover Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_menu_background_color',
                        'name'          => esc_html__('Header Menu Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Sticky Header
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Sticky Header', 'neuros'),
                    ),

                    array(
                        'id'        => 'sticky_header_status',
                        'name'      => esc_html__('Show Sticky Header', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'sticky_header_blur',
                        'name'      => esc_html__('Sticky Header Blur', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'     => esc_html__('Default', 'neuros'),
                            'on'    => esc_html__('On', 'neuros'),
                            'off'   => esc_html__('Off', 'neuros')
                        ),
                        'attributes'        => array(
                            'data-dependency-id'    => 'sticky_header_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Mobile Header
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Mobile Header', 'neuros'),
                    ),

                    array(
                        'id'            => 'mobile_header_breakpoint',
                        'name'          => esc_html__('Mobile Header Breakpoint, in px', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('mobile_header_breakpoint'),
                        'std'           => ''
                    ),

                    array(
                        'id'        => 'mobile_header_menu_style',
                        'name'      => esc_html__('Mobile Header Menu Trigger Style', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'      => esc_html__('Default', 'neuros'),
                            'fullwidth'    => esc_html__('Fullwidth', 'neuros'),
                            'inline'       => esc_html__('Inline', 'neuros')
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Header Logo
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Logo', 'neuros'),
                    ),

                    array(
                        'id'        => 'header_logo_status',
                        'name'      => esc_html__('Show Header Logo', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'header_logo_customize',
                        'name'      => esc_html__('Customize', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),

                    array(
                        'id'                => 'header_logo_image',
                        'name'              => esc_html__('Logo Image', 'neuros'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'attributes'        => array(
                            'data-dependency-id'    => 'header_logo_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_logo_retina',
                        'name'          => esc_html__('Logo Retina', 'neuros'),
                        'type'          => 'checkbox',
                        'std'           => 1,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_logo_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'                => 'header_logo_mobile_image',
                        'name'              => esc_html__('Mobile Logo Image', 'neuros'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'attributes'        => array(
                            'data-dependency-id'    => 'header_logo_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_logo_mobile_retina',
                        'name'          => esc_html__('Mobile Logo Retina', 'neuros'),
                        'type'          => 'checkbox',
                        'std'           => 1,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_logo_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Header Callback
                    array(
                        'type'          => 'heading',
                        'name'          => esc_html__('Header Callback', 'neuros'),
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_style',
                            'data-dependency-val'   => 'type-2'
                        )
                    ),

                    array(
                        'id'            => 'header_callback_status',
                        'name'          => esc_html__('Show Header Callback Block', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'               => esc_html__('Default', 'neuros'),
                            'on'                    => esc_html__('Yes', 'neuros'),
                            'off'                   => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'header_callback_title',
                        'name'          => esc_html__('Header Callback Title', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('header_callback_title'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_callback_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_callback_text',
                        'name'          => esc_html__('Header Callback Text', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('header_callback_text'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_callback_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Header Button
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Header Button', 'neuros'),
                    ),

                    array(
                        'id'        => 'header_button_status',
                        'name'      => esc_html__('Show Header Button', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'header_button_text',
                        'name'          => esc_html__('Header Button Text', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('header_button_text'),
                        'std'           => ''
                    ),

                    array(
                        'id'            => 'header_button_url',
                        'name'          => esc_html__('Header Button Link', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('header_button_url'),
                        'std'           => ''
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Header Menu
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Header Menu', 'neuros'),
                    ),

                    array(
                        'id'        => 'header_menu_status',
                        'name'      => esc_html__('Show Main Menu', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'header_menu_style',
                        'name'      => esc_html__('Menu Style', 'neuros'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'standard'  => esc_html__('Standard', 'neuros'),
                            'compact'   => esc_html__('Compact', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'header_menu_bg_image_status',
                        'name'      => esc_html__('Show Header Menu Background Image', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        ),
                        'attributes'        => array(
                            'data-dependency-id'    => 'header_menu_style',
                            'data-dependency-val'   => 'compact'
                        )
                    ),

                    array(
                        'id'                => 'header_menu_bg_image',
                        'name'              => esc_html__('Header Menu Background Image', 'neuros'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'attributes'        => array(
                            'data-dependency-id'    => 'header_menu_style, header_menu_bg_image_status',
                            'data-dependency-val'   => 'compact, on'
                        )
                    ),

                    array(
                        'id'        => 'header_menu_select',
                        'name'      => esc_html__('Select Menu', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => neuros_get_all_menu_list()
                    ),

                    array(
                        'id'            => 'header_menu_label',
                        'name'          => esc_html__('Menu label', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('header_menu_label'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_menu_style',
                            'data-dependency-val'   => 'compact'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Header Side Panel
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Header Icons', 'neuros'),
                    ),

                    array(
                        'id'        => 'side_panel_status',
                        'name'      => esc_html__('Show side panel trigger', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'header_search_status',
                        'name'      => esc_html__('Show search icon', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'header_minicart_status',
                        'name'          => esc_html__('Show product cart', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'on'            => esc_html__('Yes', 'neuros'),
                            'off'           => esc_html__('No', 'neuros')
                        ),
                    ),
                ),
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Page Title Settings', 'neuros'),
                'post_types'    => array('post', 'page', 'neuros_project', 'neuros_team_member', 'neuros_vacancy', 'neuros_service', 'neuros_case_study', 'product'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(

                    # Page Title Options

                    //-- Page Title General
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('General', 'neuros'),
                    ),

                    array(
                        'id'        => 'page_title_status',
                        'name'      => esc_html__('Show Page Title', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'page_title_overlay_status',
                        'name'      => esc_html__('Show overlay', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'page_title_overlay_color',
                        'name'          => esc_html__('Overlay Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_overlay_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'        => 'page_title_customize',
                        'name'      => esc_html__('Customize', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'class'     => 'divider-before',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'page_title_height',
                        'name'          => esc_html__('Page Title Height', 'neuros'),
                        'type'          => 'number',
                        'placeholder'   => neuros_get_theme_mod('page_title_height'),
                        'std'           => '500',
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_default_text_color',
                        'name'          => esc_html__('Default Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_dark_text_color',
                        'name'          => esc_html__('Dark Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_light_text_color',
                        'name'          => esc_html__('Light Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_accent_text_color',
                        'name'          => esc_html__('Accent Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_border_color',
                        'name'          => esc_html__('Border Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_border_hover_color',
                        'name'          => esc_html__('Hovered Border Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_background_color',
                        'name'          => esc_html__('Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_background_alter_color',
                        'name'          => esc_html__('Alternative Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_button_text_color',
                        'name'          => esc_html__('Button Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_button_border_color',
                        'name'          => esc_html__('Button Border Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_button_border_color_add',
                        'name'          => esc_html__('Button Border Color Additional', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_button_background_color',
                        'name'          => esc_html__('Button Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_button_text_hover',
                        'name'          => esc_html__('Button Text Hover', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_button_border_hover',
                        'name'          => esc_html__('Button Border Hover', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_button_background_hover',
                        'name'          => esc_html__('Button Background Hover', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'                => 'page_title_background_image',
                        'name'              => esc_html__('Background Image', 'neuros'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'class'             => 'divider-before',
                        'attributes'        => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_background_position',
                        'name'          => esc_html__('Background Position', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'center center' => esc_html__('Center Center', 'neuros'),
                            'center left'   => esc_html__('Center Left', 'neuros'),
                            'center right'  => esc_html__('Center Right', 'neuros'),
                            'top center'    => esc_html__('Top Center', 'neuros'),
                            'top left'      => esc_html__('Top Left', 'neuros'),
                            'top right'     => esc_html__('Top Right', 'neuros'),
                            'bottom center' => esc_html__('Bottom Center', 'neuros'),
                            'bottom left'   => esc_html__('Bottom Left', 'neuros'),
                            'bottom right'  => esc_html__('Bottom Right', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_background_repeat',
                        'name'          => esc_html__('Background Repeat', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'no-repeat'     => esc_html__('No-repeat', 'neuros'),
                            'repeat'        => esc_html__('Repeat', 'neuros'),
                            'repeat-x'      => esc_html__('Repeat-x', 'neuros'),
                            'repeat-y'      => esc_html__('Repeat-y', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_background_size',
                        'name'          => esc_html__('Background Size', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'initial'       => esc_html__('Initial', 'neuros'),
                            'auto'          => esc_html__('Auto', 'neuros'),
                            'cover'         => esc_html__('Cover', 'neuros'),
                            'contain'       => esc_html__('Contain', 'neuros'),
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type'          => 'divider',
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'hide_page_title_background_mobile',
                        'name'          => esc_html__('Hide Background Image on Mobile Devices', 'neuros'),
                        'type'          => 'checkbox',
                        'std'           => 0,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'hide_page_title_background_tablet',
                        'name'          => esc_html__('Hide Background Image on Tablet Devices', 'neuros'),
                        'type'          => 'checkbox',
                        'std'           => 0,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    //-- Page Title Heading
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Heading', 'neuros'),
                    ),

                    array(
                        'id'        => 'page_title_heading_customize',
                        'name'      => esc_html__('Customize', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'page_title_heading_icon_status',
                        'name'      => esc_html__('Add Image Icon before Title', 'neuros'),
                        'type'      => 'select',
                        'std'       => neuros_get_theme_mod('page_title_heading_icon_status'),
                        'options'   => array(
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_heading_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'                => 'page_title_heading_icon_image',
                        'name'              => esc_html__('Icon Image', 'neuros'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'attributes'        => array(
                            'data-dependency-id'    => 'page_title_heading_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                     array(
                        'id'            => 'page_title_heading_icon_retina',
                        'name'          => esc_html__('Icon Image Retina', 'neuros'),
                        'type'          => 'checkbox',
                        'std'           => 1,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_heading_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Page Title Breadcrumbs
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Page Title Breadcrumbs', 'neuros'),
                    ),

                    array(
                        'id'        => 'page_title_breadcrumbs_status',
                        'name'      => esc_html__('Show Page Title Breadcrumbs', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Show', 'neuros'),
                            'off'       => esc_html__('Hide', 'neuros')
                        )
                    ),



                    //-- Page Title Additional Text
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Page Title Additional Text', 'neuros'),
                    ),

                    array(
                        'id'            => 'page_title_additional_text',
                        'name'          => esc_html__('Additional Text', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('page_title_additional_text'),
                        'std'           => ''
                    ),

                    array(
                        'id'        => 'page_title_additional_customize',
                        'name'      => esc_html__('Customize', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'page_title_additional_text_color',
                        'name'          => esc_html__('Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_additional_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_additional_text_bottom_position',
                        'name'          => esc_html__('Text Bottom Offset, %', 'neuros'),
                        'type'          => 'number',
                        'min'           => 0,
                        'max'           => 50,
                        'step'          => 1,
                        'std'           => neuros_get_theme_mod('page_title_additional_text_bottom_position'),
                        'size'          => 20,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_additional_customize',
                            'data-dependency-val'   => 'on'
                        )
                    )
                )
            );

            // Layout Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Layout Settings', 'neuros'),
                'post_types'    => array('page'),
                'context'       => 'advanced',
                'closed'        => true,
                'fields'        => array(

                    //-- Content Margin
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Content Margin', 'neuros'),
                    ),
                    array(
                        'id'        => 'content_top_margin',
                        'name'      => esc_html__('Remove Top Margin', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'content_bottom_margin',
                        'name'      => esc_html__('Remove Bottom Margin', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Sidebar Options
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Sidebar', 'neuros'),
                    ),

                    array(
                        'id'        => 'sidebar_position',
                        'name'      => esc_html__('Sidebar Position', 'neuros'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'left'      => esc_html__('Left', 'neuros'),
                            'right'     => esc_html__('Right', 'neuros'),
                            'none'      => esc_html__('None', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'page_sidebar_select',
                        'name'          => esc_html__('Select Sidebar', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => $sidebar_list
                    ),
                )
            );

            // Layout Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Layout Settings', 'neuros'),
                'post_types'    => array('neuros_service'),
                'context'       => 'advanced',
                'closed'        => true,
                'fields'        => array(

                    //-- Content Margin
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Content Margin', 'neuros'),
                    ),
                    array(
                        'id'        => 'content_top_margin',
                        'name'      => esc_html__('Remove Top Margin', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'content_bottom_margin',
                        'name'      => esc_html__('Remove Bottom Margin', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Sidebar Options
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Sidebar', 'neuros'),
                    ),

                    array(
                        'id'        => 'service_sidebar_position',
                        'name'      => esc_html__('Sidebar Position', 'neuros'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'left'      => esc_html__('Left', 'neuros'),
                            'right'     => esc_html__('Right', 'neuros'),
                            'none'      => esc_html__('None', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'service_sidebar_select',
                        'name'          => esc_html__('Select Sidebar', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => $sidebar_list
                    ),
                )
            );

            // Layout Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Layout Settings', 'neuros'),
                'post_types'    => array('neuros_vacancy'),
                'context'       => 'advanced',
                'closed'        => true,
                'fields'        => array(

                    //-- Content Margin
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Content Margin', 'neuros'),
                    ),
                    array(
                        'id'        => 'content_top_margin',
                        'name'      => esc_html__('Remove Top Margin', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'content_bottom_margin',
                        'name'      => esc_html__('Remove Bottom Margin', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Sidebar Options
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Sidebar', 'neuros'),
                    ),

                    array(
                        'id'        => 'vacancy_sidebar_position',
                        'name'      => esc_html__('Sidebar Position', 'neuros'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'left'      => esc_html__('Left', 'neuros'),
                            'right'     => esc_html__('Right', 'neuros'),
                            'none'      => esc_html__('None', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'vacancy_sidebar_select',
                        'name'          => esc_html__('Select Sidebar', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => $sidebar_list
                    ),
                )
            );

            // Layout Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Layout Settings', 'neuros'),
                'post_types'    => array('neuros_case_study'),
                'context'       => 'advanced',
                'closed'        => true,
                'fields'        => array(

                    //-- Content Margin
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Content Margin', 'neuros'),
                    ),
                    array(
                        'id'        => 'content_top_margin',
                        'name'      => esc_html__('Remove Top Margin', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'content_bottom_margin',
                        'name'      => esc_html__('Remove Bottom Margin', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Sidebar Options
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Sidebar', 'neuros'),
                    ),

                    array(
                        'id'        => 'case_study_sidebar_position',
                        'name'      => esc_html__('Sidebar Position', 'neuros'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'left'      => esc_html__('Left', 'neuros'),
                            'right'     => esc_html__('Right', 'neuros'),
                            'none'      => esc_html__('None', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'case_study_sidebar_select',
                        'name'          => esc_html__('Select Sidebar', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => $sidebar_list
                    ),
                )
            );

            // Layout Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Layout Settings', 'neuros'),
                'post_types'    => array('neuros_team_member', 'neuros_project'),
                'context'       => 'advanced',
                'closed'        => true,
                'fields'        => array(

                    //-- Content Margin
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Content Margin', 'neuros'),
                    ),
                    array(
                        'id'        => 'content_top_margin',
                        'name'      => esc_html__('Remove Top Margin', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'content_bottom_margin',
                        'name'      => esc_html__('Remove Bottom Margin', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),
                )
            );

            // Layout Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Layout Settings', 'neuros'),
                'post_types'    => array('post'),
                'context'       => 'advanced',
                'closed'        => true,
                'fields'        => array(

                    //-- Content Margin
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Content Margin', 'neuros'),
                    ),
                    array(
                        'id'        => 'content_top_margin',
                        'name'      => esc_html__('Remove Top Margin', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'content_bottom_margin',
                        'name'      => esc_html__('Remove Bottom Margin', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),

                    //-- Sidebar Options
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Sidebar', 'neuros'),
                    ),

                    array(
                        'id'        => 'post_sidebar_position',
                        'name'      => esc_html__('Sidebar Position', 'neuros'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'left'      => esc_html__('Left', 'neuros'),
                            'right'     => esc_html__('Right', 'neuros'),
                            'none'      => esc_html__('None', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'post_sidebar_select',
                        'name'          => esc_html__('Select Sidebar', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => $sidebar_list
                    ),
                )
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Side Panel Settings', 'neuros'),
                'post_types'    => array('post', 'page', 'neuros_project', 'neuros_team_member', 'neuros_vacancy', 'neuros_service', 'neuros_case_study', 'product'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(
                    //-- Side Panel Logo
                    array(
                        'id'        => 'sidebar_logo_status',
                        'name'      => esc_html__('Show Logo', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'                => 'sidebar_logo_image',
                        'name'              => esc_html__('Logo Image', 'neuros'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'attributes'        => array(
                            'data-dependency-id'    => 'sidebar_logo_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'sidebar_logo_retina',
                        'name'          => esc_html__('Logo Retina', 'neuros'),
                        'type'          => 'checkbox',
                        'std'           => 1,
                        'attributes'        => array(
                            'data-dependency-id'    => 'sidebar_logo_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),
                    
                    array(
                        'id'        => 'side_panel_bg_image_status',
                        'name'      => esc_html__('Show Side Panel Background Image', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'                => 'side_panel_bg_image',
                        'name'              => esc_html__('Side Panel Background Image', 'neuros'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'attributes'        => array(
                            'data-dependency-id'    => 'side_panel_bg_image_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'        => 'side_panel_socials_status',
                        'name'      => esc_html__('Show Social Buttons', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),
                )
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Footer Settings', 'neuros'),
                'post_types'    => array('post', 'page', 'neuros_project', 'neuros_team_member', 'neuros_vacancy', 'neuros_service', 'neuros_case_study', 'product'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(

                    # Footer Options

                    //-- Footer General
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('General', 'neuros'),
                    ),

                    array(
                        'id'        => 'footer_status',
                        'name'      => esc_html__('Show Footer', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'footer_style',
                        'name'      => esc_html__('Footer Style', 'neuros'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'type-1'    => esc_html__('Style 1', 'neuros'),
                            'type-2'    => esc_html__('Style 2', 'neuros'),
                            'type-3'    => esc_html__('Style 3', 'neuros'),
                            'type-4'    => esc_html__('Style 4', 'neuros'),
                            'type-5'    => esc_html__('Style 5', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'footer_border_radius',
                        'name'      => esc_html__('Footer Border Radius', 'neuros'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('On', 'neuros'),
                            'off'       => esc_html__('Off', 'neuros'),
                            'no-top-border-radius'       => esc_html__('No Top Border Radius', 'neuros'),
                            'no-bottom-border-radius'    => esc_html__('No Bottom Border Radius', 'neuros'),
                        )
                    ),

                    array(
                        'id'        => 'footer_customize',
                        'name'      => esc_html__('Customize', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'off'       => esc_html__('No', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'footer_default_text_color',
                        'name'          => esc_html__('Default Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_dark_text_color',
                        'name'          => esc_html__('Dark Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_light_text_color',
                        'name'          => esc_html__('Light Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_accent_text_color',
                        'name'          => esc_html__('Accent Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_input_dark_color',
                        'name'          => esc_html__('Input Dark Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),    

                    array(
                        'id'            => 'footer_border_color',
                        'name'          => esc_html__('Border Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_border_hover_color',
                        'name'          => esc_html__('Hovered Border Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_background_color',
                        'name'          => esc_html__('Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_background_alter_color',
                        'name'          => esc_html__('Alternative Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_text_color',
                        'name'          => esc_html__('Button Text Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_border_color',
                        'name'          => esc_html__('Button Border Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_border_color_add',
                        'name'          => esc_html__('Button Border Color Additional', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_background_color',
                        'name'          => esc_html__('Button Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_background_color_add',
                        'name'          => esc_html__('Button Background Color Additional', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_text_hover',
                        'name'          => esc_html__('Button Text Hover', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_border_hover',
                        'name'          => esc_html__('Button Border Hover', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_border_hover_add',
                        'name'          => esc_html__('Button Border Hover Additional', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_background_hover',
                        'name'          => esc_html__('Button Background Hover', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_background_hover_add',
                        'name'          => esc_html__('Button Background Hover Additional', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'        => 'footer_button_border_style',
                        'name'      => esc_html__('Button Border Style', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'     => esc_html__('Default', 'neuros'),
                            'gradient'    => esc_html__('Gradient', 'neuros'),
                            'solid'       => esc_html__('Solid', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'        => 'footer_button_background_style',
                        'name'      => esc_html__('Button Background Style', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'     => esc_html__('Default', 'neuros'),
                            'gradient'    => esc_html__('Gradient', 'neuros'),
                            'solid'       => esc_html__('Solid', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'                => 'footer_background_image',
                        'name'              => esc_html__('Background Image', 'neuros'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'attributes'        => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_background_position',
                        'name'          => esc_html__('Background Position', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'center center' => esc_html__('Center Center', 'neuros'),
                            'center left'   => esc_html__('Center Left', 'neuros'),
                            'center right'  => esc_html__('Center Right', 'neuros'),
                            'top center'    => esc_html__('Top Center', 'neuros'),
                            'top left'      => esc_html__('Top Left', 'neuros'),
                            'top right'     => esc_html__('Top Right', 'neuros'),
                            'bottom center' => esc_html__('Bottom Center', 'neuros'),
                            'bottom left'   => esc_html__('Bottom Left', 'neuros'),
                            'bottom right'  => esc_html__('Bottom Right', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_background_repeat',
                        'name'          => esc_html__('Background Repeat', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'no-repeat'     => esc_html__('No-repeat', 'neuros'),
                            'repeat'        => esc_html__('Repeat', 'neuros'),
                            'repeat-x'      => esc_html__('Repeat-x', 'neuros'),
                            'repeat-y'      => esc_html__('Repeat-y', 'neuros')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_background_size',
                        'name'          => esc_html__('Background Size', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'neuros'),
                            'initial'       => esc_html__('Initial', 'neuros'),
                            'auto'          => esc_html__('Auto', 'neuros'),
                            'cover'         => esc_html__('Cover', 'neuros'),
                            'contain'       => esc_html__('Contain', 'neuros'),
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Footer Widgets
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Footer Widgets', 'neuros'),
                    ),

                    array(
                        'id'        => 'footer_sidebar_status',
                        'name'      => esc_html__('Show Footer Widgets', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'footer_sidebar_select',
                        'name'          => esc_html__('Select Sidebar', 'neuros'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => $sidebar_list,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_sidebar_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Copyright
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Copyright', 'neuros'),
                    ),

                    array(
                        'id'        => 'footer_copyright_status',
                        'name'      => esc_html__('Show Copyright', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'            => 'footer_copyright_text',
                        'name'          => esc_html__('Copyright Text', 'neuros'),
                        'type'          => 'text',
                        'placeholder'   => neuros_get_theme_mod('footer_copyright_text'),
                        'std'           => '',
                        'sanitize_callback' => 'wp_kses_post'
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Footer Menu
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Footer Menu', 'neuros'),
                    ),

                    array(
                        'id'        => 'footer_menu_status',
                        'name'      => esc_html__('Show Footer Menu', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'footer_menu_select',
                        'name'      => esc_html__('Select Menu', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => neuros_get_all_menu_list()
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Footer Additional Menu
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Footer Additional Menu', 'neuros'),
                    ),

                    array(
                        'id'        => 'footer_additional_menu_status',
                        'name'      => esc_html__('Show Footer Additional Menu', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),

                    array(
                        'id'        => 'footer_additional_menu_select',
                        'name'      => esc_html__('Select Menu', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => neuros_get_all_menu_list()
                    )
                )
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Additional Settings', 'neuros'),
                'post_types'    => array('post', 'page', 'neuros_project', 'neuros_team_member', 'neuros_vacancy', 'neuros_service', 'neuros_case_study', 'product'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(                    

                    //-- Footer Scroll To Top
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Scroll To Top Button', 'neuros'),
                    ),

                    array(
                        'id'        => 'footer_scrolltop_status',
                        'name'      => esc_html__('Show Scroll To Top Button', 'neuros'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'neuros'),
                            'on'        => esc_html__('Yes', 'neuros'),
                            'off'       => esc_html__('No', 'neuros')
                        )
                    ),
                    array(
                        'id'            => 'footer_scrolltop_bg_color',
                        'name'          => esc_html__('Scroll To Top Button Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_scrolltop_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),
                    array(
                        'id'            => 'footer_scrolltop_bg_color_hover',
                        'name'          => esc_html__('Scroll To Top Button Hover Background Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_scrolltop_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),
                    array(
                        'id'            => 'footer_scrolltop_color',
                        'name'          => esc_html__('Scroll To Top Button Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_scrolltop_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),
                    array(
                        'id'            => 'footer_scrolltop_color_hover',
                        'name'          => esc_html__('Scroll To Top Button Hover Color', 'neuros'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_scrolltop_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),
                )
            );

            return $meta_boxes;
        }
    }
}