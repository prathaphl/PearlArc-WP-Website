<?php
    if (class_exists('\Elementor\Plugin')) {
        if (did_action('elementor/init')) {            
            $active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
            if( !empty($active_breakpoints) ) {
                global $neuros_custom_css;
                function generateDecorationResponsiveCSS($breakpoint, $widget, $element) {
                    $custom_css = "\n" . $widget . $breakpoint . '-left ' . $element . ' {';
                    $custom_css .= 'padding: 20px 20px 0 0;';                                
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . $breakpoint . '-left ' . $element . ':before {';
                    $custom_css .= 'left: 0; right: initial; top: -20px; bottom: initial; border-radius: 0; border-bottom-left-radius: 20px;';                                
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . $breakpoint . '-left ' . $element . ':after {';
                    $custom_css .= 'right: 0; left: initial; top: initial; bottom: 0; border-radius: 0; border-bottom-left-radius: 20px;';                                
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . $breakpoint . '-right ' . $element . ' {';
                    $custom_css .= 'padding: 20px 0 0 20px;';                                
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . $breakpoint . '-right ' . $element . ':before {';
                    $custom_css .= 'left: initial; right: 0; top: -20px; bottom: initial; border-radius: 0; border-bottom-right-radius: 20px;';                                
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . $breakpoint . '-right ' . $element . ':after {';
                    $custom_css .= 'right: initial; left: 0; top: initial; bottom: 0; border-radius: 0; border-bottom-right-radius: 20px;';                                
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . $breakpoint . '-center ' . $element . ' {';
                    $custom_css .= 'padding: 0 20px 0 20px;';                                
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . $breakpoint . '-center ' . $element . ':before {';
                    $custom_css .= 'left: 0; right: initial; top: initial; bottom: 0; border-radius: 0; border-bottom-right-radius: 20px;';                                
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . $breakpoint . '-center ' . $element . ':after {';
                    $custom_css .= 'right: 0; left: initial; top: initial; bottom: 0; border-radius: 0; border-bottom-left-radius: 20px;';                                
                    $custom_css .= '}';

                    return $custom_css;
                }
                function generateIconBoxResponsiveCSS($breakpoint, $widget, $element) {
                    $custom_css = "\n" . $widget . '.icon-position-' . $breakpoint . '-top ' . $element . ' {';
                    $custom_css .= 'display: block;';
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.icon-position-' .$breakpoint . '-top.alignment-' . $breakpoint . '-left ' . $element . ' {';
                    $custom_css .= 'text-align: left;';
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.icon-position-' .$breakpoint . '-top.alignment-' . $breakpoint . '-right ' . $element . ' {';
                    $custom_css .= 'text-align: right;';
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.icon-position-' .$breakpoint . '-top.alignment-' . $breakpoint . '-center ' . $element . ' {';
                    $custom_css .= 'text-align: center;';
                    $custom_css .= '}';

                    $custom_css .= "\n" . $widget . '.icon-position-' . $breakpoint . '-left ' . $element . ' {';
                    $custom_css .= 'display: flex; justify-content: flex-start; align-items: flex-start;';
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.icon-position-' .$breakpoint . '-left.alignment-' . $breakpoint . '-left ' . $element . ' {';
                    $custom_css .= 'justify-content: flex-start; text-align: left;';
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.icon-position-' .$breakpoint . '-left.alignment-' . $breakpoint . '-right ' . $element . ' {';
                    $custom_css .= 'justify-content: flex-end; text-align: right;';
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.icon-position-' .$breakpoint . '-left.alignment-' . $breakpoint . '-center ' . $element . ' {';
                    $custom_css .= 'justify-content: center; text-align: center;';
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.icon-position-' .$breakpoint . '-left.alignment-' . $breakpoint . '-space-between ' . $element . ' {';
                    $custom_css .= 'justify-content: space-between; text-align: center;';
                    $custom_css .= '}';

                    $custom_css .= "\n" . $widget . '.icon-position-' . $breakpoint . '-right ' . $element . ' {';
                    $custom_css .= 'display: flex; flex-direction: row-reverse; justify-content: flex-end; align-items: flex-end;';
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.icon-position-' .$breakpoint . '-right.alignment-' . $breakpoint . '-left ' . $element . ' {';
                    $custom_css .= 'justify-content: flex-end; text-align: left;';
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.icon-position-' .$breakpoint . '-right.alignment-' . $breakpoint . '-right ' . $element . ' {';
                    $custom_css .= 'justify-content: flex-start; text-align: right;';
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.icon-position-' .$breakpoint . '-right.alignment-' . $breakpoint . '-center ' . $element . ' {';
                    $custom_css .= 'justify-content: center; text-align: center;';
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.icon-position-' .$breakpoint . '-right.alignment-' . $breakpoint . '-space-between ' . $element . ' {';
                    $custom_css .= 'justify-content: space-between; text-align: center;';
                    $custom_css .= '}';

                    $custom_css .= "\n" . $widget . '.icon-position-' . $breakpoint . '-bottom ' . $element . ' {';
                    $custom_css .= 'display: flex; flex-direction: column-reverse; justify-content: flex-end; align-items: flex-start;';
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.icon-position-' .$breakpoint . '-bottom.alignment-' . $breakpoint . '-left ' . $element . ' {';
                    $custom_css .= 'align-items:flex-start; text-align: left;';
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.icon-position-' .$breakpoint . '-bottom.alignment-' . $breakpoint . '-right ' . $element . ' {';
                    $custom_css .= 'align-items:flex-end; text-align: right;';
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.icon-position-' .$breakpoint . '-bottom.alignment-' . $breakpoint . '-center ' . $element . ' {';
                    $custom_css .= 'align-items:center; text-align: center;';
                    $custom_css .= '}';

                    $custom_css .= "\n" . $widget . '.v-alignment-' . $breakpoint . '-top ' . $element . ' {';
                    $custom_css .= "align-items: flex-start;";
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.v-alignment-' . $breakpoint . '-middle ' . $element . ' {';
                    $custom_css .= "align-items: center;";
                    $custom_css .= '}';
                    $custom_css .= "\n" . $widget . '.v-alignment-' . $breakpoint . '-bottom ' . $element . ' {';
                    $custom_css .= "align-items: flex-end;";
                    $custom_css .= '}';

                    return $custom_css;
                }
                $counter = 0;
                $prev_breakpoint = null;
                foreach ( $active_breakpoints as $breakpoint_key => $breakpoint ) {
                    $counter++;
                    if($breakpoint->get_name() === 'widescreen') {
                        $neuros_custom_css .= '
                        @media only screen and (min-width:' . $breakpoint->get_value() . 'px) {';
                            for ($i = 1, $j = 10; $i <= 10; $i++, $j--) {
                                $neuros_custom_css .= "\n.elementor-reverse-" . $breakpoint->get_name() . ' > .elementor-container > .elementor-row > ' . 
                                    ( $i == 1 ? ':first-child' : ':nth-child(' . $i . ')') . '{';
                                $neuros_custom_css .= 'order:' . $j . ';';
                                $neuros_custom_css .= '}';
                            }
                        $neuros_custom_css .= "\n}";
                        continue;
                    }
                    if($counter === 1) {
                        $neuros_custom_css .= '
                        @media only screen and (max-width:' . $breakpoint->get_value() . 'px) {';
                            for ($i = 1, $j = 10; $i <= 10; $i++, $j--) {
                                $neuros_custom_css .= "\n.elementor-reverse-" . $breakpoint->get_name() . ' > .elementor-container > .elementor-row > ' . 
                                    ( $i == 1 ? ':first-child' : ':nth-child(' . $i . ')') . '{';
                                $neuros_custom_css .= 'order:' . $j . ';';
                                $neuros_custom_css .= '}';
                            }
                        $neuros_custom_css .= "\n}";
                    } elseif ($counter !== 1 && $prev_breakpoint) {
                        $neuros_custom_css .= '
                        @media only screen and (min-width:' . ($prev_breakpoint + 1) . 'px) and (max-width:' . $breakpoint->get_value() . 'px) {';
                            for ($i = 1, $j = 10; $i <= 10; $i++, $j--) {
                                $neuros_custom_css .= "\n.elementor-reverse-" . $breakpoint->get_name() . ' > .elementor-container > .elementor-row > ' . 
                                    ( $i == 1 ? ':first-child' : ':nth-child(' . $i . ')') . '{';
                                $neuros_custom_css .= 'order:' . $j . ';';
                                $neuros_custom_css .= '}';
                            }
                        $neuros_custom_css .= "\n}";
                    }
                    $prev_breakpoint = $breakpoint->get_value();
                }
                
                $active_breakpoints = array_reverse($active_breakpoints);
                foreach ( $active_breakpoints as $breakpoint_key => $breakpoint ) {
                    if($breakpoint->get_name() === 'widescreen') {
                        $neuros_custom_css .= '
                        @media only screen and (min-width:' . $breakpoint->get_value() . 'px) {';
                            $neuros_custom_css .= generateDecorationResponsiveCSS($breakpoint->get_name(), '.elementor-widget-neuros_video_button.neuros-video-button-decoration-on.neuros-video-button-alignment-', '.elementor-custom-embed-image-overlay');
                        $neuros_custom_css .= "\n}";
                        continue;
                    } else {
                        $neuros_custom_css .= '
                        @media only screen and (max-width:' . $breakpoint->get_value() . 'px) {';
                            $neuros_custom_css .= generateDecorationResponsiveCSS($breakpoint->get_name(), '.elementor-widget-neuros_video_button.neuros-video-button-decoration-on.neuros-video-button-alignment-', '.elementor-custom-embed-image-overlay');
                        $neuros_custom_css .= "\n}";
                    }
                }

                foreach ( $active_breakpoints as $breakpoint_key => $breakpoint ) {
                    if($breakpoint->get_name() === 'widescreen') {
                        $neuros_custom_css .= '
                        @media only screen and (min-width:' . $breakpoint->get_value() . 'px) {';
                            $neuros_custom_css .= generateDecorationResponsiveCSS($breakpoint->get_name(), '.elementor-widget-icon.neuros-icon-decoration-on.neuros-icon-alignment-', '.elementor-icon-wrapper');
                        $neuros_custom_css .= "\n}";
                        continue;
                    } else {
                        $neuros_custom_css .= '
                        @media only screen and (max-width:' . $breakpoint->get_value() . 'px) {';
                            $neuros_custom_css .= generateDecorationResponsiveCSS($breakpoint->get_name(), '.elementor-widget-icon.neuros-icon-decoration-on.neuros-icon-alignment-', '.elementor-icon-wrapper');
                        $neuros_custom_css .= "\n}";
                    }
                }

                foreach ( $active_breakpoints as $breakpoint_key => $breakpoint ) {
                    if($breakpoint->get_name() === 'widescreen') {
                        $neuros_custom_css .= '
                        @media only screen and (min-width:' . $breakpoint->get_value() . 'px) {';
                            $neuros_custom_css .= generateIconBoxResponsiveCSS($breakpoint->get_name(), '.elementor-widget-neuros_icon_box', '.icon-box-item');
                        $neuros_custom_css .= "\n}";
                        continue;
                    } else {
                        $neuros_custom_css .= '
                        @media only screen and (max-width:' . $breakpoint->get_value() . 'px) {';
                            $neuros_custom_css .= generateIconBoxResponsiveCSS($breakpoint->get_name(), '.elementor-widget-neuros_icon_box', '.icon-box-item');
                        $neuros_custom_css .= "\n}";
                    }
                }

            }            
        }        
    }
?>