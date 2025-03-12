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

$sidebar_args = neuros_get_sidebar_args();
$sidebar_position = $sidebar_args['sidebar_position'];
$sidebar_name     = $sidebar_args['sidebar_name'];

if($sidebar_position == 'none') {
    $sidebar_position = 'left';
}

$content_classes = 'content-wrapper';
$content_classes .= ( neuros_get_prefered_option('content_top_margin') == 'on' ? ' content-wrapper-remove-top-margin' : '' );
$content_classes .= ( neuros_get_prefered_option('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );
$content_classes .= ' content-wrapper-sidebar-position-' . esc_attr($sidebar_position);
?>

    <div class="<?php echo esc_attr($content_classes); ?>">

        <!-- Content Container -->
        <div class="content">

            <div id="vacancy-<?php the_ID(); ?>" class="single-vacancy">

                <div class="vacancy-post-content">

                    <?php
                        if ( !empty(get_the_content()) ) {
                            echo '<h3 class="vacancy-content-title">' . esc_html__('Job Description:', 'neuros') . '</h3>';
                            the_content();
                        }

                        if (!empty(neuros_get_post_option('vacancy_responsibilities'))) {
                            echo '<h3 class="vacancy-content-title">' . esc_html__('Responsibilities:', 'neuros') . '</h3>';
                            echo wp_kses_post( do_shortcode(wpautop(rwmb_meta('vacancy_responsibilities'))) );
                        }

                        if (!empty(neuros_get_post_option('vacancy_qualifications'))) {
                            echo '<h3 class="vacancy-content-title">' . esc_html__('Preferred Qualifications:', 'neuros') . '</h3>';
                            echo wp_kses_post( do_shortcode(wpautop(rwmb_meta('vacancy_qualifications'))) );
                        }

                    ?>

                    <?php
                        if ( !empty(neuros_get_post_option('vacancy_button')) ) {
                            $button = neuros_get_post_option('vacancy_button');
                            echo '<div class="vacancy-post-button">';
                                echo '<a href="' . esc_url( $button[0] ) . '" class="neuros-button">' . esc_html( $button[1] ) . '<span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span>                    
                                <span class="button-inner"></a>';
                            echo '</div>';
                        }
                    ?>

                </div>
            </div>

        </div>

        <!-- Sidebar Container -->
        <?php
            $sidebar_args              = neuros_get_sidebar_args();
            $additional_class          = $sidebar_args['additional_class'];

            echo '<div class="sidebar sidebar-position-' . esc_attr($sidebar_position) . esc_attr($additional_class) . '">';
                echo '<div class="vacancy-info">';

                    if ( !empty(neuros_get_post_option('vacancy_occupation')) || !empty(neuros_get_post_option('vacancy_location')) ) {
                        echo '<div class="vacancy-post-meta">';
                        if (!empty(neuros_get_post_option('vacancy_occupation'))) {
                            echo '<div class="vacancy-post-meta-item vacancy-occupation">';
                                echo esc_html(neuros_get_post_option('vacancy_occupation'));
                            echo '</div>';
                        }
                        if (!empty(neuros_get_post_option('vacancy_location'))) {
                            echo '<div class="vacancy-post-meta-item">';
                                echo esc_html(neuros_get_post_option('vacancy_location'));
                            echo '</div>';
                        }
                        echo '</div>';
                    }

                    if ( !empty(neuros_get_post_option('vacancy_salary')) ) {
                        echo '<div class="vacancy-salary">';
                            echo '<div class="vacancy-salary-value">' . esc_html(neuros_get_post_option('vacancy_salary')) . '</div>';
                        echo '</div>';
                    }

                echo '</div>';
                if ($sidebar_args['sidebar_position'] !== 'none' && is_active_sidebar($sidebar_name) ) {
                    dynamic_sidebar($sidebar_name);
                }
                echo '<div class="shop-hidden-sidebar-close"></div>';
            echo '</div>';
            echo '<div class="simple-sidebar-trigger"></div>';
        ?>

    </div>

    <?php
        if ( neuros_get_prefered_option('recent_vacancies_status') == 'on' ) {
            echo '<div class="content-wrapper content-wrapper-sidebar-position-none">';
                echo '<div class="content">';
                    if ( !empty(neuros_get_prefered_option('recent_vacancies_section_heading')) ) {
                        echo '<h2 class="related-vacancy-title neuros-heading">';
                            echo '<span class="neuros-subheading">' . esc_html__('Careers', 'neuros') . '</span>';
                            echo '<span class="team-post-title">' . neuros_get_prefered_option('recent_vacancies_section_heading') . '</span>';
                        echo '</h2>';
                    }

                    $query = new WP_Query( [
                        'post_type'         => 'neuros_vacancy',
                        'posts_per_page'    => neuros_get_prefered_option('recent_vacancies_number'),
                        'orderby'           => neuros_get_prefered_option('recent_vacancies_order_by'),
                        'order'             => neuros_get_prefered_option('recent_vacancies_order')
                    ] );

                    echo '<div class="archive-listing">';
                        echo '<div class="archive-listing-wrapper vacancy-listing-wrapper">';
                            while( $query->have_posts() ){
                                $query->the_post();
                                get_template_part('content', 'neuros_vacancy');
                            };
                            wp_reset_postdata();
                        echo '</div>';
                    echo '</div>';

                echo '</div>';
            echo '</div>';
        }
    ?>

<?php
get_footer();