            <?php
                defined( 'ABSPATH' ) or die();

                if ( neuros_get_prefered_option('footer_status') == 'on' ) {

                    $footer_classes = 'footer';
                    $footer_classes .= !empty(neuros_get_prefered_option('footer_style')) ? ' footer-' . esc_attr(neuros_get_prefered_option('footer_style')) : '';
                    $footer_classes .= !empty(neuros_get_prefered_option('footer_border_radius')) ? ' footer-br-' . esc_attr(neuros_get_prefered_option('footer_border_radius')) : '';
                    ?>

                    <!-- Footer -->
                    <?php
                    echo '<footer class="footer-wrapper">';
                        echo '<div class="' . esc_attr($footer_classes) . '">';
                            echo '<span class="footer-bg"></span>';
                            get_template_part('templates/footer/footer-1');
                        echo '</div>';
                    echo '</footer>';
                }
                if( neuros_get_prefered_option('footer_scrolltop_status') == 'on' ) {
                    echo '<div class="footer-scroll-top">';
                        echo '<button class="fontello icon-arrow-top" aria-label="Scroll Up"></button>';
                    echo '</div>';
                }
            ?>
        </div>
        <?php
            wp_footer();
        ?>
    </body>
</html>