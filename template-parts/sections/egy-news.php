<?php
/**
 * EGY News Section
 *
 * @package Code95
 */

$category = get_theme_mod('code95_egy_news_category', '');
$number = get_theme_mod('code95_egy_news_number', 8);

if (empty($category)) {
    // If no category selected, get recent posts
    $args = array(
        'posts_per_page' => $number,
        'ignore_sticky_posts' => true,
        'meta_key' => '_thumbnail_id',
    );
} else {
    $args = array(
        'cat' => $category,
        'posts_per_page' => $number,
        'ignore_sticky_posts' => true,
        'meta_key' => '_thumbnail_id',
    );
}

$query = new WP_Query($args);

if ($query->have_posts()) :
?>
<section class="egy-news-section py-4">
    <div class="section-container">
        <h2 class="section-title text-danger mb-4"><?php echo esc_html(get_theme_mod('code95_egy_news_title', __('EGY NEWS', 'code95'))); ?></h2>
        
        <div class="egy-news-slider position-relative">
            <div class="egy-news-wrapper overflow-hidden">
                <div class="egy-news-track d-flex" id="egyNewsSlider">
                    <?php
                    $posts_array = array();
                    while ($query->have_posts()) : $query->the_post();
                        ob_start();
                    ?>
                        <div class="egy-news-item flex-shrink-0">
                            <article class="news-card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail position-relative">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('code95-thumbnail', array('class' => 'img-fluid w-100')); ?>
                                        </a>
                                        <div class="overlay-gradient"></div>
                                        <div class="post-content position-absolute bottom-0 start-0 p-3 text-white">
                                            <h3 class="h6 mb-0">
                                                <a href="<?php the_permalink(); ?>" class="text-white text-decoration-none">
                                                    <?php echo wp_trim_words(get_the_title(), 10); ?>
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </article>
                        </div>
                    <?php
                        $posts_array[] = ob_get_clean();
                    endwhile;
                    
                    // Ensure we have at least 8 items to fill the slider properly
                    $min_items = 8;
                    $total_items = count($posts_array);
                    
                    if ($total_items > 0) {
                        // If we have fewer items than minimum, duplicate some items
                        if ($total_items < $min_items) {
                            $duplicate_count = $min_items - $total_items;
                            for ($i = 0; $i < $duplicate_count; $i++) {
                                $posts_array[] = $posts_array[$i % $total_items];
                            }
                        }
                        
                        // Clone last 3 items at the beginning for infinite loop
                        echo $posts_array[count($posts_array) - 3];
                        echo $posts_array[count($posts_array) - 2];
                        echo $posts_array[count($posts_array) - 1];
                        
                        // Output all original items
                        foreach ($posts_array as $post_html) {
                            echo $post_html;
                        }
                        
                        // Clone first 3 items at the end for infinite loop
                        echo $posts_array[0];
                        echo $posts_array[1];
                        echo $posts_array[2];
                    }
                    ?>
                </div>
            </div>
            
            <button class="slider-nav slider-prev position-absolute top-50 start-0 translate-middle-y" type="button" aria-label="Previous">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="20" fill="#DC3545"/>
                    <path d="M23 14L17 20L23 26" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button class="slider-nav slider-next position-absolute top-50 end-0 translate-middle-y" type="button" aria-label="Next">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="20" fill="#DC3545"/>
                    <path d="M17 14L23 20L17 26" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
        
        <!-- Dynamic Broken Line Divider -->
        <div class="egy-news-divider d-flex align-items-center my-4">
            <div class="line left"></div>
            <div class="gap"></div>
            <div class="line right"></div>
        </div>
    </div>
</section>
<?php
endif;
wp_reset_postdata();
?> 