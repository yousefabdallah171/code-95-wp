<?php
/**
 * ========================================
 * MAIN INDEX TEMPLATE
 * ========================================
 * 
 * This is the main template file that WordPress uses as a fallback.
 * It displays the main content area with posts in a grid layout.
 * 
 * @package Code95
 * @version 1.0.0
 * 
 * ========================================
 */

// Include the header template
get_header();
?>

<!-- ========================================
     MAIN CONTENT AREA
     ======================================== -->
<main id="primary" class="site-main">
    <div class="container">
        <?php
        // ========================================
        // POST LOOP - DISPLAY POSTS
        // ========================================
        // Check if there are posts to display
        if (have_posts()) :
            ?>
            <!-- ========================================
                 POSTS GRID LAYOUT
                 ======================================== -->
            <div class="row">
                <?php
                // ========================================
                // LOOP THROUGH EACH POST
                // ======================================== -->
                while (have_posts()) :
                    // Set up post data for the current post
                    the_post();
                    ?>
                    <!-- ========================================
                         INDIVIDUAL POST CARD
                         ======================================== -->
                    <!-- Bootstrap grid: md-6 = 2 columns on medium screens, lg-4 = 3 columns on large screens -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <!-- Article element with WordPress post classes and Bootstrap card styling -->
                        <article id="post-<?php the_ID(); ?>" <?php post_class('card h-100'); ?>>
                            
                            <!-- ========================================
                                 POST FEATURED IMAGE
                                 ======================================== -->
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="card-img-top">
                                    <!-- Display the post thumbnail using our custom image size -->
                                    <?php the_post_thumbnail('code95-thumbnail'); ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- ========================================
                                 POST CONTENT
                                 ======================================== -->
                            <div class="card-body">
                                <!-- Post title as a link -->
                                <h2 class="card-title h5">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                
                                <!-- Post excerpt/summary -->
                                <div class="card-text">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </article>
                    </div>
                    <?php
                endwhile;
                ?>
            </div>
            <?php
            // ========================================
            // POST NAVIGATION
            // ========================================
            // Display pagination links for navigating between pages of posts
            the_posts_navigation();
            
        else :
            // ========================================
            // NO POSTS FOUND MESSAGE
            // ======================================== -->
            ?>
            <p><?php esc_html_e('No posts found.', 'code95'); ?></p>
            <?php
        endif;
        ?>
    </div>
</main>

<?php
// Include the footer template
get_footer();