<?php
/**
 * ========================================
 * SINGLE POST TEMPLATE
 * ========================================
 * 
 * This template displays individual blog posts with full content,
 * meta information, social sharing, author box, and related posts.
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
    <div class="code95-single-post-container">
        <div class="container">
            <div class="row">
                <!-- ========================================
                     MAIN POST CONTENT COLUMN
                     ======================================== -->
                <div class="col-lg-8">
                    <?php
                    // ========================================
                    // POST LOOP
                    // ========================================
                    while (have_posts()) :
                        the_post();
                        ?>
                        
                        <!-- ========================================
                             MAIN POST ARTICLE
                             ======================================== -->
                        <article id="post-<?php the_ID(); ?>" <?php post_class('code95-single-post-article'); ?>>
                            
                            <!-- ========================================
                                 POST HEADER SECTION
                                 ======================================== -->
                            <header class="code95-post-header">
                                <!-- ========================================
                                     FEATURED IMAGE
                                     ======================================== -->
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="code95-post-featured-image">
                                        <?php the_post_thumbnail('large', array('class' => 'img-fluid w-100')); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- ========================================
                                     POST HEADER CONTENT
                                     ======================================== -->
                                <div class="code95-post-header-content">
                                    
                                    <!-- ========================================
                                         POST CATEGORIES
                                         ======================================== -->
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) :
                                    ?>
                                        <div class="code95-post-categories mb-3">
                                            <?php foreach ($categories as $category) : ?>
                                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="badge bg-danger text-decoration-none me-2">
                                                    <?php echo esc_html($category->name); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- ========================================
                                         POST TITLE
                                         ======================================== -->
                                    <h1 class="code95-post-title"><?php the_title(); ?></h1>
                                    
                                    <!-- ========================================
                                         POST META INFORMATION
                                         ======================================== -->
                                    <div class="code95-post-meta">
                                        <!-- Author information -->
                                        <div class="code95-meta-item">
                                            <i class="bi bi-person"></i>
                                            <span><?php the_author(); ?></span>
                                        </div>
                                        
                                        <!-- Publication date -->
                                        <div class="code95-meta-item">
                                            <i class="bi bi-calendar"></i>
                                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                                <?php echo esc_html(get_the_date()); ?>
                                            </time>
                                        </div>
                                        
                                        <!-- Publication time -->
                                        <div class="code95-meta-item">
                                            <i class="bi bi-clock"></i>
                                            <span><?php echo esc_html(get_the_time()); ?></span>
                                        </div>
                                        
                                        <!-- Comments count -->
                                        <div class="code95-meta-item">
                                            <i class="bi bi-eye"></i>
                                            <span><?php echo get_comments_number(); ?> comments</span>
                                        </div>
                                    </div>
                                </div>
                            </header>
                            
                            <!-- ========================================
                                 POST CONTENT
                                 ======================================== -->
                            <div class="code95-post-content">
                                <?php
                                // Display the main post content
                                the_content();
                                
                                // Display pagination for multi-page posts
                                wp_link_pages(array(
                                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'code95'),
                                    'after' => '</div>',
                                ));
                                ?>
                            </div>
                            
                            <!-- ========================================
                                 POST FOOTER
                                 ======================================== -->
                            <footer class="code95-post-footer">
                                
                                <!-- ========================================
                                     POST TAGS
                                     ======================================== -->
                                <?php
                                $tags = get_the_tags();
                                if ($tags) :
                                ?>
                                    <div class="code95-post-tags mb-4">
                                        <h5 class="code95-tags-title"><?php esc_html_e('Tags:', 'code95'); ?></h5>
                                        <div class="code95-tags-list">
                                            <?php foreach ($tags as $tag) : ?>
                                                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="code95-tag-link">
                                                    #<?php echo esc_html($tag->name); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- ========================================
                                     SOCIAL SHARING BUTTONS
                                     ======================================== -->
                                <div class="code95-post-share mb-4">
                                    <h5 class="code95-share-title"><?php esc_html_e('Share this post:', 'code95'); ?></h5>
                                    <div class="code95-share-buttons">
                                        <!-- Facebook sharing -->
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="code95-share-btn code95-share-facebook">
                                            <i class="bi bi-facebook"></i>
                                        </a>
                                        
                                        <!-- Twitter sharing -->
                                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="code95-share-btn code95-share-twitter">
                                            <i class="bi bi-twitter"></i>
                                        </a>
                                        
                                        <!-- LinkedIn sharing -->
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="code95-share-btn code95-share-linkedin">
                                            <i class="bi bi-linkedin"></i>
                                        </a>
                                        
                                        <!-- WhatsApp sharing -->
                                        <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" target="_blank" class="code95-share-btn code95-share-whatsapp">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- ========================================
                                     AUTHOR BOX
                                     ======================================== -->
                                <div class="code95-author-box">
                                    <!-- Author avatar -->
                                    <div class="code95-author-avatar">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                                    </div>
                                    
                                    <!-- Author information -->
                                    <div class="code95-author-info">
                                        <h5 class="code95-author-name"><?php the_author(); ?></h5>
                                        <p class="code95-author-bio"><?php echo esc_html(get_the_author_meta('description')); ?></p>
                                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="code95-author-posts-link">
                                            <?php esc_html_e('View all posts by', 'code95'); ?> <?php the_author(); ?>
                                        </a>
                                    </div>
                                </div>
                            </footer>
                        </article>
                        
                        <!-- ========================================
                             POST NAVIGATION
                             ======================================== -->
                        <nav class="code95-post-navigation">
                            <div class="row">
                                <!-- Previous post link -->
                                <div class="col-6">
                                    <?php
                                    $prev_post = get_previous_post();
                                    if ($prev_post) :
                                    ?>
                                        <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="code95-nav-link code95-nav-prev">
                                            <div class="code95-nav-arrow">←</div>
                                            <div class="code95-nav-content">
                                                <span class="code95-nav-label"><?php esc_html_e('Previous Post', 'code95'); ?></span>
                                                <h6 class="code95-nav-title"><?php echo esc_html($prev_post->post_title); ?></h6>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Next post link -->
                                <div class="col-6">
                                    <?php
                                    $next_post = get_next_post();
                                    if ($next_post) :
                                    ?>
                                        <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="code95-nav-link code95-nav-next">
                                            <div class="code95-nav-content">
                                                <span class="code95-nav-label"><?php esc_html_e('Next Post', 'code95'); ?></span>
                                                <h6 class="code95-nav-title"><?php echo esc_html($next_post->post_title); ?></h6>
                                            </div>
                                            <div class="code95-nav-arrow">→</div>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </nav>
                        
                        <!-- ========================================
                             RELATED POSTS
                             ======================================== -->
                        <?php
                        // Get current post categories
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            // Create array of category IDs
                            $category_ids = array();
                            foreach ($categories as $category) {
                                $category_ids[] = $category->term_id;
                            }
                            
                            // Query related posts from same categories
                            $related_posts = new WP_Query(array(
                                'category__in' => $category_ids,    // Posts in same categories
                                'post__not_in' => array(get_the_ID()), // Exclude current post
                                'posts_per_page' => 3,              // Show 3 related posts
                                'orderby' => 'rand'                 // Random order
                            ));
                            
                            // Display related posts if found
                            if ($related_posts->have_posts()) :
                            ?>
                                <div class="code95-related-posts">
                                    <h3 class="code95-related-title"><?php esc_html_e('Related Posts', 'code95'); ?></h3>
                                    <div class="row">
                                        <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                                            <div class="col-md-4">
                                                <article class="code95-related-post">
                                                    <!-- Related post thumbnail -->
                                                    <?php if (has_post_thumbnail()) : ?>
                                                        <div class="code95-related-thumbnail">
                                                            <a href="<?php the_permalink(); ?>">
                                                                <?php the_post_thumbnail('medium', array('class' => 'img-fluid')); ?>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <!-- Related post content -->
                                                    <div class="code95-related-content">
                                                        <h5 class="code95-related-post-title">
                                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                        </h5>
                                                        <div class="code95-related-post-meta">
                                                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                                                <?php echo esc_html(get_the_date()); ?>
                                                            </time>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                            <?php
                            endif;
                            // Reset post data to restore main query
                            wp_reset_postdata();
                        }
                        ?>
                        
                        <!-- ========================================
                             COMMENTS SECTION
                             ======================================== -->
                        <?php
                        // Display comments if enabled or if there are existing comments
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;
                        ?>
                        
                    <?php endwhile; ?>
                </div>
                
                <!-- ========================================
                     SIDEBAR COLUMN
                     ======================================== -->
                <div class="col-lg-4">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Include the footer template
get_footer();
?> 
