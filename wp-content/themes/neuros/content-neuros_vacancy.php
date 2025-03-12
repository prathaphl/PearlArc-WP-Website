<?php 
    $excerpt_length = (!empty($args['excerpt_length']) ? $args['excerpt_length'] : neuros_get_theme_mod('vacancy_archive_excerpt_length'));
?>

<div <?php post_class('vacancy-item-wrapper'); ?>>
    <div class="vacancy-item">

        <?php
            if ( !empty(neuros_get_post_option('vacancy_occupation')) || !empty(neuros_get_post_option('vacancy_location')) || !empty(neuros_get_post_option('vacancy_salary')) ) {
                echo '<div class="vacancy-item-header">';
                    if ( !empty(neuros_get_post_option('vacancy_occupation')) || !empty(neuros_get_post_option('vacancy_location')) ) {
                        echo '<div class="vacancy-post-meta">';
                        if (!empty(neuros_get_post_option('vacancy_occupation'))) {
                            echo '<div class="vacancy-post-meta-item vacancy-occupation">';
                                echo esc_html(neuros_get_post_option('vacancy_occupation'));
                            echo '</div>';
                        }
                        if (!empty(neuros_get_post_option('vacancy_location'))) {
                            echo '<div class="vacancy-post-meta-item vacancy-city">';
                                echo esc_html(neuros_get_post_option('vacancy_location'));
                            echo '</div>';
                        }                        
                        echo '</div>';
                        if ( !empty(neuros_get_post_option('vacancy_salary')) ) {
                            echo '<div class="vacancy-salary">';
                                echo '<div class="vacancy-salary-value">' . esc_html(neuros_get_post_option('vacancy_salary')) . '</div>';
                            echo '</div>';
                        }
                    }
                echo '</div>';
            }
        ?>

        <div class="vacancy-item-excerpt">
            <?php
                if ( !empty(get_the_title()) ) {
                    echo '<h4 class="vacancy-post-title">' . get_the_title() . '</h4>';
                }
                echo '<div class="vacancy-excerpt">';                    
                    if (!empty($excerpt_length)) {
                        echo substr(get_the_excerpt(), 0, $excerpt_length);
                    } else {
                        the_excerpt();
                    }
                echo '</div>';
            ?>
        </div>

        <div class="vacancy-item-button">
            <?php
                echo '<a href="' . esc_url(get_the_permalink()) . '" class="neuros-button">';
                    esc_html_e('Explore more', 'neuros');
                    echo '<span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span>                    
                                <span class="button-inner">';
                echo '</a>';
            ?>
        </div>
    </div>
</div>