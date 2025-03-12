<?php
    defined( 'ABSPATH' ) or die();

    if ( is_home() ) {
        $page_title = esc_html__('Home', 'neuros');
    } elseif ( class_exists('WooCommerce') && is_product() ) {
        $page_title = sprintf(stripslashes(neuros_get_theme_mod('woo_single_product_title')), get_the_title());
    } elseif ( class_exists('WooCommerce') && is_product_category()  ) {
        $page_title = sprintf(stripslashes(neuros_get_theme_mod('woo_product_categories_title')), single_term_title('', false));
    } elseif ( class_exists('WooCommerce') && is_product_tag() ) {
        $page_title = sprintf(stripslashes(neuros_get_theme_mod('woo_product_tags_title')), single_term_title('', false));
    } elseif ( class_exists('WooCommerce') && is_search() ) {
        $page_title = sprintf(esc_html__('Search Results By "%s"', 'neuros'), get_search_query());
    } elseif (is_archive()) {
        if ( class_exists('WooCommerce') && is_woocommerce() ) {
            $page_title = get_the_title();
        } elseif ( !empty(get_queried_object()) && get_queried_object()->name == 'neuros_portfolio') {
            $page_title = sprintf(esc_html(neuros_get_theme_mod('portfolio_archive_page_title')), post_type_archive_title('', false));
        } elseif ( !empty(get_queried_object()) && get_queried_object()->name == 'neuros_project') {
            $page_title = sprintf(esc_html(neuros_get_theme_mod('project_archive_page_title')), post_type_archive_title('', false));
        } elseif ( !empty(get_queried_object()) && get_queried_object()->name == 'neuros_case_study') {
            $page_title = sprintf(esc_html(neuros_get_theme_mod('case_studies_archive_page_title')), post_type_archive_title('', false));
        } elseif ( !empty(get_queried_object()) && get_queried_object()->name == 'neuros_team_member') {
            $page_title = sprintf(esc_html(neuros_get_theme_mod('team_archive_page_title')), post_type_archive_title('', false));
        } elseif ( !empty(get_queried_object()) && get_queried_object()->name == 'neuros_vacancy') {
            $page_title = sprintf(esc_html(neuros_get_theme_mod('vacancy_archive_page_title')), post_type_archive_title('', false));
        } elseif ( !empty(get_queried_object()) && get_queried_object()->name == 'neuros_service') {
            $page_title = sprintf(esc_html(neuros_get_theme_mod('service_archive_page_title')), post_type_archive_title('', false));
        } else {
            $page_title = get_the_archive_title();
        }
    } elseif (is_search()) {
        $page_title = sprintf(esc_html__('Search Results By "%s"', 'neuros'), get_search_query());
    } elseif (is_singular('neuros_portfolio')) {
        $page_title = sprintf(stripslashes(neuros_get_theme_mod('portfolio_single_page_title')), get_the_title());
    } elseif (is_singular('neuros_project')) {
        $page_title = sprintf(stripslashes(neuros_get_theme_mod('project_single_page_title')), get_the_title());
    } elseif (is_singular('neuros_case_study')) {
        $page_title = sprintf(stripslashes(neuros_get_theme_mod('case_studies_single_page_title')), get_the_title());
    } elseif (is_singular('neuros_team_member')) {
        $page_title = sprintf(stripslashes(neuros_get_theme_mod('team_single_page_title')), get_the_title());
    } elseif (is_singular('neuros_vacancy')) {
        $page_title = sprintf(stripslashes(neuros_get_theme_mod('vacancy_single_page_title')), get_the_title());
    } elseif (is_singular('neuros_service')) {
        $page_title = sprintf(stripslashes(neuros_get_theme_mod('service_single_page_title')), get_the_title());
    } elseif (is_single()) {
        $page_title = sprintf(stripslashes(neuros_get_theme_mod('post_page_title')), get_the_title());
    } else {
        $page_title = get_the_title();
    }
    $breadcrumbs_status = neuros_get_prefered_option('page_title_breadcrumbs_status');
?>

<!-- Page Title -->
<div class="page-title-container">
    <div class="page-title-bg"></div>
    <div class="page-title-row">
        <div class="page-title-wrapper">
            <div class="page-title-box">                
                <?php
                    if ( neuros_get_prefered_option('page_title_heading_customize') == 'on' && neuros_get_prepared_option('page_title_heading_icon_status', '', 'page_title_heading_customize') == 'on') {
                        echo neuros_get_page_title_image_output();
                    }
                ?>
                <h1 class="page-title"><?php echo sprintf('%s', $page_title); ?></h1>
            </div>            
        </div>
    </div>
    <?php
        if ( !empty(neuros_get_prefered_option('page_title_additional_text')) ) {
            echo '<div class="page-title-additional">' . esc_html(neuros_get_prefered_option('page_title_additional_text')) . '</div>';
        }
        if ( $breadcrumbs_status == 'on' ) {
            echo '<div class="breadcrumbs-wrapper">';
                neuros_breadcrumbs();
            echo '</div>';
        }
    ?>
</div>