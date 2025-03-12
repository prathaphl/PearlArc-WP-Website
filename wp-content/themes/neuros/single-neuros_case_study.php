<?php
/**
 * The template for displaying single case studies post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Neuro
 * @since Neuro 1.4.0
 */

the_post();
get_header();

$sidebar_args = neuros_get_sidebar_args();
$sidebar_position = neuros_get_prefered_option('case_study_sidebar_position');
$sidebar_name     = $sidebar_args['sidebar_name'];

$content_classes = 'content-wrapper';
$content_classes .= ( neuros_get_prefered_option('content_top_margin') == 'on' ? ' content-wrapper-remove-top-margin' : '' );
$content_classes .= ( neuros_get_prefered_option('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );
$content_classes .= ' content-wrapper-sidebar-position-' . esc_attr($sidebar_position);

$post_classes = 'single-post';
?>

    <div class="<?php echo esc_attr($content_classes); ?>">

        <!-- Content Container -->
        <div class="content">

            <div id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>

                <?php
                    if (
                        neuros_get_prefered_option('post_media_image_status') == 'on' &&
                        !empty(neuros_post_media_output())
                    ) {
                        echo '<div class="post-media-wrapper">';
                            echo neuros_post_media_output();
                        echo '</div>';
                    }

                    if (
                        ( neuros_get_prefered_option('post_category_status') == 'on' &&
                        !empty(neuros_case_studies_categories_output()) ) ||
                        ( neuros_get_prefered_option('post_date_status') == 'on' &&
                        !empty(neuros_post_date_output()) ) ||
                        ( neuros_get_prefered_option('post_author_status') == 'on' &&
                        !empty(neuros_post_author_output()) )
                    ) {
                        echo '<div class="post-meta-header">';                            
                            if (
                                ( neuros_get_prefered_option('post_date_status') == 'on' &&
                                !empty(neuros_post_date_output()) ) ||
                                ( neuros_get_prefered_option('post_author_status') == 'on' &&
                                !empty(neuros_post_author_output()) )
                            ) {
                                echo '<div class="post-meta-items-wrapper">';
                                    echo '<div class="post-meta-items">';
                                        if ( neuros_get_prefered_option('post_date_status') == 'on' && !empty(neuros_post_date_output()) ) {
                                            echo neuros_post_date_output(true);
                                        }
                                        if ( neuros_get_prefered_option('post_author_status') == 'on' && !empty(neuros_post_author_output()) ) {
                                            echo neuros_post_author_output(true);
                                        }
                                    echo '</div>';
                                echo '</div>';
                            }
                            if(neuros_get_prefered_option('post_category_status') == 'on' &&
                                !empty(neuros_case_studies_categories_output())) {
                                echo neuros_case_studies_categories_output(true);
                            }
                        echo '</div>';
                    }
                ?>

                <?php
                    if ( neuros_get_prefered_option('post_title_status') == 'on' && !empty(get_the_title()) ) {
                        echo '<h3 class="post-title">' . get_the_title() . '</h3>';
                    }
                ?>

                <div class="post-content">
                    <?php the_content(); ?>
                </div>

                <?php
                    wp_link_pages(
                        array(
                            'before' => '<div class="content-pagination"><nav class="pagination"><div class="nav-links">',
                            'after' => '</div></nav></div>',
                        		'link_before' => '<span class="button-inner"></span>'
                        )
                    );
                ?>
            </div>

        </div>

        <!-- Sidebar Container -->
        <?php
            if( $sidebar_position !== 'none' ) {
                $additional_class  = $sidebar_args['additional_class'];

                echo '<div class="sidebar sidebar-position-' . esc_attr($sidebar_position) . esc_attr($additional_class) . '">';
                    echo '<div class="case-study-side-info">';
                        if ( !empty(neuros_get_post_option('case_study_logo')) ) {
                            echo '<div class="case-study-info-logo">';
                                echo neuros_case_study_logo_output();
                            echo '</div>';
                        }
                        if ( !empty(neuros_get_post_option('case_study_client')) || 
                             !empty(neuros_get_post_option('case_study_sector')) || 
                             !empty(neuros_get_post_option('case_study_offering'))
                        ) {
                            echo '<div class="case-study-info-text">';
                                if ( !empty(neuros_get_post_option('case_study_client')) ) {
                                    echo '<div class="case-study-info-text-item client">';
                                        echo '<span class="case-study-info-text-item-label">';
                                            echo esc_html__('Client', 'neuros');
                                        echo '</span>';
                                        echo '<span class="case-study-info-text-item-value">';
                                            echo esc_html(neuros_get_post_option('case_study_client'));
                                        echo '</span>';
                                    echo '</div>';
                                }
                                if ( !empty(neuros_get_post_option('case_study_sector')) ) {
                                    echo '<div class="case-study-info-text-item">';
                                        echo '<span class="case-study-info-text-item-label">';
                                            echo esc_html__('Sector', 'neuros');
                                        echo '</span>';
                                        echo '<span class="case-study-info-text-item-value">';
                                            echo esc_html( implode(', ', neuros_get_post_option('case_study_sector')) );
                                        echo '</span>';
                                    echo '</div>';
                                }
                                if ( !empty(neuros_get_post_option('case_study_offering')) ) {
                                    echo '<div class="case-study-info-text-item">';
                                        echo '<span class="case-study-info-text-item-label">';
                                            echo esc_html__('Offering', 'neuros');
                                        echo '</span>';
                                        echo '<span class="case-study-info-text-item-value">';
                                            echo esc_html(neuros_get_post_option('case_study_offering'));
                                        echo '</span>';
                                    echo '</div>';
                                }
                            echo '</div>';
                        }
                        if ( neuros_get_prefered_option('post_tags_status') == 'on' && !empty(neuros_case_studies_tags_output()) ) {
                            echo neuros_case_studies_tags_output();
                        }
                    echo '</div>';
                    if ( $sidebar_args['sidebar_position'] !== 'none' && is_active_sidebar($sidebar_name) ) {
                        dynamic_sidebar($sidebar_name);
                    }
                    echo '<div class="shop-hidden-sidebar-close"></div>';
                echo '</div>';
                echo '<div class="simple-sidebar-trigger"></div>';
            }            
        ?>

    </div>

<?php
get_footer();