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

    <div class="error-404-wrapper">
        <div class="error-404-container">
            <div class="error-404-inner">
                <div class="error-404-text-column">
                    <span class="error-404-text">404</span>
                </div>
                <div class="error-404-content">
                    <?php
                        if ( neuros_get_prefered_option('error_logo_status') == 'on' && !empty(neuros_get_error_logo_output()) ) {
                            echo neuros_get_error_logo_output();
                        }
                        if ( !empty(neuros_get_theme_mod('error_title')) ) {
                            echo '<h1 class="error-404-title">' . wp_kses(neuros_get_theme_mod('error_title'), array('br' => array())) . '</h1>';
                        }
                        if ( !empty(neuros_get_theme_mod('error_text')) ) {
                            echo '<p class="error-404-info-text">' . esc_html(neuros_get_theme_mod('error_text')) . '</p>';
                        }
                        if ( !empty(neuros_get_theme_mod('error_button_text')) ) {
                            echo '<div class="error-404-button">';
                                echo '<a class="error-404-home-button neuros-button" href="' . esc_url(home_url('/')) . '">' . esc_html(neuros_get_theme_mod('error_button_text')) . '</a>';
                            echo '</div>';
                        }
                        if (neuros_get_theme_mod('error_socials_status') == 'on' && !empty(neuros_socials_output())) {
                            echo neuros_socials_output('wrapper-socials');
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php
    wp_footer();
?>
</body>
</html>