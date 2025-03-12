<div <?php post_class('team-item-wrapper'); ?>>
    <div class="team-item">
        <a href="<?php the_permalink(); ?>" class="team-item-link">
            <?php
                echo '<span class="team-item-media">';
                    echo neuros_team_member_media_output(false);
                    if( !empty(neuros_get_post_option('team_member_tag')) ) {
                        echo '<span class="team-item-tag">';
                            echo esc_html(neuros_get_post_option('team_member_tag'));
                        echo '</span>';
                    }
                echo '</span>';                
            ?>
        </a>        
        <?php 
            echo '<div class="team-item-content">';
                if ( neuros_post_options() && !empty(neuros_get_post_option('team_member_socials')) ) {
                    echo '<div class="team-item-socials">';
                        echo '<span class="socials-trigger-wrapper">';
                            echo '<i class="socials-trigger fontello icon-button-arrow"></i>';
                        echo '</span>';
                        $social_items = neuros_get_post_option('team_member_socials');
                        echo '<div class="team-socials-wrapper">';
                            echo '<ul class="team-socials wrapper-socials">';
                            foreach ( $social_items as $item ) {
                                echo '<li>';
                                    echo '<a href="' . esc_url($item[1]) . '" target="_blank" class="fab ' . esc_attr($item[0]) . '"></a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                        echo '</div>';
                    echo '</div>';
                }
                if ( !empty(get_the_title()) ) {
                    echo '<a href="' . get_the_permalink() . '" class="post-title">' . get_the_title() . '</a>';
                }

                if ( neuros_post_options() && !empty(neuros_get_post_option('team_member_position')) ) {
                    echo '<span class="team-item-position">';
                        echo esc_html(neuros_get_post_option('team_member_position'));
                    echo '</span>';
                }
            echo '</div>';
        ?>        
    </div>
</div>