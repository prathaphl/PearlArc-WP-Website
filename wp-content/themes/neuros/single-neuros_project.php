<?php
/**
 * The template for displaying single project item page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Neuros
 * @since Neuros 1.0
 */

the_post();
get_header();

$content_classes = $additional_classes = 'content-wrapper content-wrapper-sidebar-position-none';
$content_classes .= ( neuros_get_prefered_option('content_top_margin') == 'on' ? ' content-wrapper-remove-top-margin' : '' );

if ( neuros_get_post_option('project_view') !== 'advanced' ) {    
    $content_classes .= ( neuros_get_prefered_option('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );
} else {
    $additional_classes .= ( neuros_get_prefered_option('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );
}

?>
    <div id="project-<?php the_ID(); ?>" class="single-project-wrapper<?php echo neuros_get_post_option('project_view') === 'advanced' ? ' project-view-advanced' : ''; ?>">

        <section>
            <div class="<?php echo esc_attr($content_classes); ?>">

                <!-- Content Container -->
                <div class="content">

                    <div class="single-project">

                        <?php 
                            if ( neuros_get_post_option('project_view') !== 'advanced' &&
                                (
                                    !empty(neuros_media_gallery_output('project_gallery')) || 
                                    !empty(neuros_project_video_output()) 
                                ) ) {
                                echo '<div class="project-post-gallery">';
                                    echo neuros_project_video_output();
                                    echo neuros_media_gallery_output('project_gallery');
                                echo '</div>';
                            } elseif ( neuros_get_post_option('project_view') === 'advanced' && !empty(neuros_project_logo_output()) ) {
                                echo '<div class="project-post-gallery">';
                                    echo neuros_project_logo_output();
                                echo '</div>';
                            }
                        ?>

                        <div class="project-post-content">
                            <?php
                                if ( neuros_get_prefered_option('project_title_status') == 'on' && !empty(get_the_title()) ) {
                                    echo '<h2 class="project-post-title">' . get_the_title() . '</h2>';
                                }
                            ?>

                            <?php 
                                if ( neuros_get_post_option('project_view') === 'advanced' && !empty(neuros_get_post_option('project_description')) ) {
                                    echo '<div class="project-description">' . do_shortcode( wpautop( neuros_get_post_option('project_description') ) ) . '</div>';
                                } elseif ( neuros_get_post_option('project_view') !== 'advanced' ) {
                                    the_content(); 
                                }
                            ?>

                            <?php
                                if( !empty(neuros_get_post_option('project_strategy')) ||
                                    !empty(neuros_get_post_option('project_design')) ||
                                    !empty(neuros_get_post_option('project_client')) ) { ?>
                                        <div class="project-post-meta-wrapper">
                                            <div class="project-post-meta">
                                                <?php
                                                    if ( !empty(neuros_get_post_option('project_strategy')) ) {
                                                        echo '<div class="project-post-meta-item">';
                                                            echo '<div class="project-post-meta-label">' . esc_html__('Strategy', 'neuros') . '</div>';
                                                            $strategy_list = neuros_get_post_option('project_strategy');
                                                            echo wp_kses( implode('<br>', $strategy_list ), array('br' => array()) );
                                                        echo '</div>';
                                                    }
                                                    if ( !empty(neuros_get_post_option('project_design')) ) {
                                                        echo '<div class="project-post-meta-item">';
                                                            echo '<div class="project-post-meta-label">' . esc_html__('Design', 'neuros') . '</div>';
                                                            $design_list = neuros_get_post_option('project_design');
                                                            echo wp_kses( implode('<br>', $design_list ), array('br' => array()) );
                                                        echo '</div>';
                                                    }
                                                    if ( !empty(neuros_get_post_option('project_client')) ) {
                                                        echo '<div class="project-post-meta-item">';
                                                            echo '<div class="project-post-meta-label">' . esc_html__('Client', 'neuros') . '</div>';
                                                            echo esc_html(neuros_get_post_option('project_client'));
                                                        echo '</div>';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                <?php } ?>
                            <?php
                                if ( !empty(neuros_get_post_option('project_button')) ) {
                                    $button = neuros_get_post_option('project_button');
                                    echo '<div class="project-post-button">';
                                        echo '<a href="' . esc_url( $button[0] ) . '" class="neuros-button">' . esc_html( $button[1] ) . '<span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span>                    
                                        <span class="button-inner"></a>';
                                    echo '</div>';
                                }
                            ?>

                        </div>
                    </div>

                    <?php
                        if ( neuros_get_post_option('project_view') !== 'advanced' ) {
                            $args = array(
                                'prev_label'            => esc_html__('Prev project', 'neuros'),
                                'next_label'            => esc_html__('Next project', 'neuros'),
                                'taxonomy_name'         => 'neuros_project_category',
                                'taxonomy_separator'    => ' / '
                            );
                            echo neuros_post_navigation($args);
                        }                    
                    ?>

                </div>
            </div>
        </section>

        <?php
            if ( neuros_get_post_option('project_view') === 'advanced' ) {
                echo '<section>';
                    echo '<div class="' . esc_attr($additional_classes) . '">';
                        echo '<div class="content">';
                            echo '<div class="single-project-advanced">';
                                the_content();
                            echo '</div>';
                            $args = array(
                                'prev_label'            => esc_html__('Prev project', 'neuros'),
                                'next_label'            => esc_html__('Next project', 'neuros'),
                                'taxonomy_name'         => 'neuros_project_category',
                                'taxonomy_separator'    => ' / '
                            );
                            echo neuros_post_navigation($args);                            
                        echo '</div>';
                    echo '</div>';
                echo '</section>';
            }
        ?>
    </div>

<?php
get_footer();