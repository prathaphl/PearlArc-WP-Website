<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Neuros
 * @since Neuros 1.0
 */

get_header();

$sidebar_args = neuros_get_sidebar_args();
$sidebar_position = $sidebar_args['sidebar_position'];

$content_classes = 'content-wrapper';
$content_classes .= ( neuros_get_theme_mod('content_top_margin') == 'on' ? ' content-wrapper-remove-top-margin' : '' );
$content_classes .= ( neuros_get_theme_mod('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );
$content_classes .= ' content-wrapper-sidebar-position-' . esc_attr($sidebar_position);

$posts_per_page = neuros_get_theme_mod('vacancy_archive_posts_per_page');
?>

    <div class="<?php echo esc_attr($content_classes); ?>">
        <div class="content">
            <!-- Content Container -->
            <div class="content-inner">

                <div class="archive-listing">
                    <div class="archive-listing-wrapper vacancy-listing-wrapper">
                        <?php
                            while( have_posts() ){
                                the_post();
                                get_template_part('content', 'neuros_vacancy');
                            };
                        ?>
                    </div>

                    <?php
                        global $wp_query;
                        if($wp_query->max_num_pages > 1) { ?>
                            <div class="content-pagination">
                                <?php
                                    echo get_the_posts_pagination(array(
                                        'end_size'  => 2,
                                        'before_page_number' => '<span class="button-inner"></span>',
                                        'prev_text' => esc_html__('Previous', 'neuros') . '<span class="button-inner"></span><span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span>',
                                        'next_text' => esc_html__('Next', 'neuros') . '<span class="button-inner"></span><span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span>'
                                    ));
                                ?>
                            </div>
                        <?php }
                    ?>
                </div>

            </div>
        </div>

        <!-- Sidebar Container -->
        <?php get_sidebar(); ?>

    </div>

<?php
get_footer();