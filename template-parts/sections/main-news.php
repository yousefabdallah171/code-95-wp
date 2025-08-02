<?php
/**
 * ========================================
 * MAIN NEWS SECTION TEMPLATE
 * ========================================
 * 
 * This template displays the main news section with a featured layout.
 * It shows posts in a grid with one large featured post, two medium posts,
 * and one image-only post. The layout is responsive and customizable.
 * 
 * @package Code95
 * @version 1.0.0
 * 
 * ========================================
 */

// ========================================
// GET CUSTOMIZER SETTINGS
// ========================================
// Retrieve main news section settings from WordPress customizer
$type = get_theme_mod('code95_main_news_type', 'recent');           // Query type: recent, category, or posts
$category = get_theme_mod('code95_main_news_category', '');         // Category ID for category query
$posts = get_theme_mod('code95_main_news_posts', '');              // Comma-separated post IDs
$number = get_theme_mod('code95_main_news_number', 4);             // Number of posts to display

// ========================================
// BUILD QUERY
// ========================================
// Get posts based on customizer settings
$query = code95_get_main_news($type, $type === 'category' ? $category : ($type === 'posts' ? $posts : ''), $number);

// ========================================
// DISPLAY SECTION
// ========================================
if ($query->have_posts()) :
?>
<!-- ========================================
     MAIN NEWS SECTION CONTAINER
     ======================================== -->
<section class="main-news-section py-5">
    <div class="section-container">
        
        <!-- ========================================
             MAIN NEWS LAYOUT GRID
             ======================================== -->
        <div class="main-news-layout">
            <?php
            // ========================================
            // LOOP THROUGH POSTS
            // ========================================
            $counter = 0;
            while ($query->have_posts()) : $query->the_post();
                $counter++;
                
                // ========================================
                // GET POST CATEGORY
                // ========================================
                // Get the first category of the post, or use 'Local' as fallback
                $categories = get_the_category();
                $category_name = !empty($categories) ? $categories[0]->name : __('Local', 'code95');
                
                // ========================================
                // POST 1: LARGE FEATURED POST (LEFT)
                // ========================================
                if ($counter === 1) : // Left card - large featured
                ?>
                    <div class="main-news-left">
                        <article class="main-news-featured">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <!-- Featured image with link -->
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('code95-featured', array('class' => 'img-fluid')); ?>
                                    </a>
                                    
                                    <!-- Gradient overlay for text readability -->
                                    <div class="overlay-gradient"></div>
                                    
                                    <!-- Post content overlay -->
                                    <div class="post-content">
                                        <!-- Category badge -->
                                        <span class="badge bg-danger"><?php echo esc_html($category_name); ?></span>
                                        
                                        <!-- Post title -->
                                        <h2 class="h3">
                                            <a href="<?php the_permalink(); ?>" class="text-white text-decoration-none">
                                                <?php the_title(); ?>
                                            </a>
                                        </h2>
                                        
                                        <!-- Post excerpt -->
                                        <p class="excerpt">
                                            <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </article>
                    </div>
                    
                <!-- ========================================
                     POST 2: FIRST MIDDLE CARD
                     ======================================== -->
                <?php
                elseif ($counter === 2) : // First middle card
                ?>
                    <div class="main-news-middle">
                        <div class="middle-cards">
                            <article class="main-news-item">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <!-- Post image with link -->
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('code95-thumbnail', array('class' => 'img-fluid')); ?>
                                        </a>
                                        
                                        <!-- Gradient overlay -->
                                        <div class="overlay-gradient"></div>
                                        
                                        <!-- Post content overlay -->
                                        <div class="post-content">
                                            <!-- Category badge -->
                                            <span class="badge bg-danger"><?php echo esc_html($category_name); ?></span>
                                            
                                            <!-- Post title (truncated) -->
                                            <h3 class="h6">
                                                <a href="<?php the_permalink(); ?>" class="text-white text-decoration-none">
                                                    <?php echo wp_trim_words(get_the_title(), 8, '...'); ?>
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </article>
                            
                <!-- ========================================
                     POST 3: SECOND MIDDLE CARD
                     ======================================== -->
                <?php
                elseif ($counter === 3) : // Second middle card
                ?>
                            <article class="main-news-item">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <!-- Post image with link -->
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('code95-thumbnail', array('class' => 'img-fluid')); ?>
                                        </a>
                                        
                                        <!-- Gradient overlay -->
                                        <div class="overlay-gradient"></div>
                                        
                                        <!-- Post content overlay -->
                                        <div class="post-content">
                                            <!-- Category badge (blue variant) -->
                                            <span class="badge bg-primary main-news-blue-badge"><?php echo esc_html($category_name); ?></span>
                                            
                                            <!-- Post title (truncated) -->
                                            <h3 class="h6">
                                                <a href="<?php the_permalink(); ?>" class="text-white text-decoration-none">
                                                    <?php echo wp_trim_words(get_the_title(), 8, '...'); ?>
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </article>
                        </div>
                    </div>
                    
                <!-- ========================================
                     POST 4: IMAGE-ONLY POST (RIGHT)
                     ======================================== -->
                <?php
                elseif ($counter === 4) : // Right card - image only
                ?>
                    <div class="main-news-right">
                        <article class="main-news-image-only">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <!-- Post image with link (no text overlay) -->
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('code95-featured', array('class' => 'img-fluid')); ?>
                                    </a>
                                    
                                    <!-- Gradient overlay -->
                                    <div class="overlay-gradient"></div>
                                </div>
                            <?php endif; ?>
                        </article>
                    </div>
                <?php
                endif;
            endwhile;
            
            // ========================================
            // RESET POST DATA
            // ========================================
            // Restore the main query after custom query
            wp_reset_postdata();
            ?>
        </div>
        
        <!-- ========================================
             SECTION SEPARATOR (OPTIONAL)
             ======================================== -->
        <?php if (get_theme_mod('code95_main_news_separator_enable', true)) : ?>
            <div class="main-news-separator"></div>
        <?php endif; ?>
    </div>
</section>
<?php
endif;
?>