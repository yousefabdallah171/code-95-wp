<?php
/**
 * ========================================
 * THEME FOOTER TEMPLATE
 * ========================================
 * 
 * This template displays the footer section of the website.
 * It includes the footer content, closing tags, and WordPress footer hook.
 * 
 * @package Code95
 * @version 1.0.0
 * 
 * ========================================
 */
?>

    <!-- ========================================
         SITE FOOTER SECTION
         ======================================== -->
    <footer id="colophon" class="site-footer bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <!-- ========================================
                         FOOTER TEXT CONTENT
                         ======================================== -->
                    <!-- Display footer text from customizer with fallback -->
                    <!-- wp_kses_post() sanitizes HTML while allowing safe tags -->
                    <p class="mb-0" id="footer-text">
                        <?php 
                        // Get footer text from customizer or use default
                        echo wp_kses_post(
                            get_theme_mod(
                                'code95_footer_text', 
                                sprintf(
                                    __('© %s %s. All rights reserved.', 'code95'), 
                                    date('Y'), 
                                    get_bloginfo('name')
                                )
                            )
                        ); 
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<!-- ========================================
     WORDPRESS FOOTER HOOK
     ======================================== -->
<!-- This hook includes necessary scripts and allows plugins to add footer content -->
<?php wp_footer(); ?>

</body>
</html> 