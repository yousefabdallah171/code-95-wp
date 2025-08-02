<?php
/**
 * ========================================
 * THEME SIDEBAR TEMPLATE
 * ========================================
 * 
 * This template displays the sidebar area with various widgets.
 * It includes popular posts, categories, and tags widgets.
 * 
 * @package Code95
 * @version 1.0.0
 * 
 * ========================================
 */
?>

<!-- ========================================
     SIDEBAR CONTAINER
     ======================================== -->
<aside id="secondary" class="code95-sidebar widget-area">
    <div class="code95-sidebar-content">
        
        <!-- ========================================
             POPULAR POSTS WIDGET
             ======================================== -->
        <div class="code95-sidebar-widget">
            <h3 class="code95-widget-title"><?php esc_html_e('Popular Posts', 'code95'); ?></h3>
            <div class="code95-popular-posts">
                <?php
                // ========================================
                // POPULAR POSTS QUERY
                // ========================================
                // Query posts ordered by view count (custom meta field)
                $popular_posts = new WP_Query(array(
                    'posts_per_page' => 5,           // Show 5 popular posts
                    'meta_key' => 'code95_post_views', // Custom meta field for view count
                    'orderby' => 'meta_value_num',    // Order by numeric meta value
                    'order' => 'DESC',                // Descending order (most viewed first)
                    'ignore_sticky_posts' => true,    // Don't prioritize sticky posts
                ));
                
                // ========================================
                // DISPLAY POPULAR POSTS
                // ========================================
                if ($popular_posts->have_posts()) :
                    while ($popular_posts->have_posts()) : $popular_posts->the_post();
                ?>
                    <!-- ========================================
                         INDIVIDUAL POPULAR POST
                         ======================================== -->
                    <article class="code95-popular-post">
                        <!-- Featured image if available -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="code95-popular-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('thumbnail', array('class' => 'img-fluid')); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Post content -->
                        <div class="code95-popular-content">
                            <h4 class="code95-popular-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <div class="code95-popular-meta">
                                <!-- Publication date with proper datetime attribute -->
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo esc_html(get_the_date()); ?>
                                </time>
                            </div>
                        </div>
                    </article>
                <?php
                    endwhile;
                    // Reset post data to restore main query
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
        
        <!-- ========================================
             CATEGORIES WIDGET
             ======================================== -->
        <div class="code95-sidebar-widget">
            <h3 class="code95-widget-title"><?php esc_html_e('Categories', 'code95'); ?></h3>
            <ul class="code95-categories-list">
                <?php
                // ========================================
                // CATEGORIES QUERY
                // ========================================
                // Get categories ordered by post count
                $categories = get_categories(array(
                    'orderby' => 'count',    // Order by number of posts
                    'order' => 'DESC',       // Descending order (most posts first)
                    'number' => 10,          // Show top 10 categories
                ));
                
                // ========================================
                // DISPLAY CATEGORIES
                // ========================================
                foreach ($categories as $category) :
                ?>
                    <li class="code95-category-item">
                        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="code95-category-link">
                            <span class="code95-category-name"><?php echo esc_html($category->name); ?></span>
                            <span class="code95-category-count">(<?php echo esc_html($category->count); ?>)</span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <!-- ========================================
             TAGS WIDGET
             ======================================== -->
        <div class="code95-sidebar-widget">
            <h3 class="code95-widget-title"><?php esc_html_e('Tags', 'code95'); ?></h3>
            <div class="code95-tags-cloud">
                <?php
                // ========================================
                // TAGS QUERY
                // ========================================
                // Get tags ordered by usage count
                $tags = get_tags(array(
                    'orderby' => 'count',    // Order by number of posts
                    'order' => 'DESC',       // Descending order (most used first)
                    'number' => 20,          // Show top 20 tags
                ));
                
                // ========================================
                // DISPLAY TAGS
                // ========================================
                if ($tags) :
                    foreach ($tags as $tag) :
                ?>
                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="code95-tag-cloud-link">
                        #<?php echo esc_html($tag->name); ?>
                    </a>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>
</aside> 