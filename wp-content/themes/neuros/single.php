<?php
/**
 * The template for displaying single gallery post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Neuros
 * @since Neuros 1.0
 */

the_post();
get_header();

$sidebar_args = neuros_get_sidebar_args();
$sidebar_position = $sidebar_args['sidebar_position'];

$content_classes = 'content-wrapper';
$content_classes .= ' content-wrapper-sidebar-position-' . esc_attr($sidebar_position);
$content_classes .= ( neuros_get_prefered_option('content_top_margin') == 'on' ? ' content-wrapper-remove-top-margin' : '' );
$content_classes .= ( neuros_get_prefered_option('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );

$post_format = get_post_format();
$post_classes = 'single-post' . ( $post_format == 'quote' && neuros_post_options() && !empty(neuros_get_post_option('post_media_quote_text')) ? '  neuros-format-quote' : '' );
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
                        !empty(neuros_post_categories_output()) ) ||
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
                                !empty(neuros_post_categories_output())) {
                                echo neuros_post_categories_output(true);
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

                <?php
                    if (
                        ( neuros_get_prefered_option('post_tags_status') == 'on' && !empty(neuros_post_tags_output()) ) ||
                        ( neuros_get_prefered_option('post_socials_status') == 'on' && !empty(neuros_socials_output()) ) ||
                        ( neuros_get_prefered_option('post_author_status') == 'on' && !empty(neuros_post_author_output()) )
                    ) {
                        echo '<div class="post-meta-footer">';
                            if ( neuros_get_prefered_option('post_author_status') == 'on' && !empty(neuros_post_author_output()) ) {
                                echo neuros_post_author_output(true, esc_html__('By', 'neuros'));
                            }
                            if ( neuros_get_prefered_option('post_tags_status') == 'on' && !empty(neuros_post_tags_output()) ) {
                                echo neuros_post_tags_output();
                            }
                            if ( neuros_get_prefered_option('post_socials_status') == 'on' && !empty(neuros_socials_output()) ) {
                                echo '<div class="post-meta-item post-meta-item-socials">';
                                    echo neuros_socials_output('wrapper-socials');
                                echo '</div>';
                            }
                        echo '</div>';
                    }
                ?>

                <?php
                    if ( comments_open() || get_comments_number() || pings_open() ) {
                        comments_template(); 
                    }
                ?>

                <?php
                    if (neuros_get_prefered_option('recent_posts_status') == 'on') {
                        neuros_recent_posts_output(
                            array(
                                'orderby'               => neuros_get_prefered_option('recent_posts_order_by'),
                                'numberposts'           => neuros_get_prefered_option('recent_posts_number'),
                                'post_type'             => get_post_type(),
                                'order'                 => neuros_get_prefered_option('recent_posts_order'),
                                'show_media'            => neuros_get_prefered_option('recent_posts_image'),
                                'show_category'         => neuros_get_prefered_option('recent_posts_category'),
                                'show_title'            => neuros_get_prefered_option('recent_posts_title'),
                                'show_date'             => neuros_get_prefered_option('recent_posts_date'),
                                'show_author'           => neuros_get_prefered_option('recent_posts_author'),
                                'show_excerpt'          => neuros_get_prefered_option('recent_posts_excerpt'),
                                'excerpt_length'        => neuros_get_prefered_option('recent_posts_excerpt_length'),
                                'show_tags'             => neuros_get_prefered_option('recent_posts_tags'),
                                'show_more'             => neuros_get_prefered_option('recent_posts_more')
                            )
                        );
                    }
                ?>

            </div>

        </div>

        <!-- Sidebar Container -->
        <?php get_sidebar(); ?>

    </div>

<?php
get_footer();