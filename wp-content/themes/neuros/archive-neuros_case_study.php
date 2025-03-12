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
 * @subpackage Neuro
 * @since Neuro 1.4.0
 */

get_header();

$sidebar_args = neuros_get_sidebar_args();
$sidebar_position = $sidebar_args['sidebar_position'];

$content_classes = 'content-wrapper';
$content_classes .= ( neuros_get_theme_mod('content_top_margin') == 'on' ? ' content-wrapper-remove-top-margin' : '' );
$content_classes .= ( neuros_get_theme_mod('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );
$content_classes .= ' content-wrapper-sidebar-position-' . esc_attr($sidebar_position);

$columns_number = neuros_get_theme_mod('case_studies_archive_columns_number');
?>

    <div class="<?php echo esc_attr($content_classes); ?>">
        <div class="content">
            <!-- Content Container -->
            <div class="content-inner">

                <div class="archive-listing">
                    <div class="archive-listing-wrapper case-study-listing-wrapper case-study-grid-listing<?php echo ( isset($columns_number) && !empty($columns_number) ? ' columns-' . esc_attr($columns_number) : '' ); ?>">
                        <?php
                            $item_counter = 0;
                            while( have_posts() ){
                                the_post();
                                $item_counter++;
                                get_template_part('content', 'neuros_case_study', array('item_counter' => $item_counter));
                            };
                            wp_reset_postdata();
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