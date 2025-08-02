<?php
/**
 * Features Section
 *
 * @package Code95
 */

$feature_type = get_theme_mod('code95_features_type', 'recent');
$feature_category = get_theme_mod('code95_features_category', '');
$feature_posts = get_theme_mod('code95_features_posts', '');
$number = 2;

// Build query arguments
$args = array(
    'posts_per_page' => $number,
    'ignore_sticky_posts' => true,
    'meta_key' => '_thumbnail_id',
);

if ($feature_type === 'category' && !empty($feature_category)) {
    $args['cat'] = $feature_category;
} elseif ($feature_type === 'posts' && !empty($feature_posts)) {
    $post_ids = explode(',', $feature_posts);
    $args['post__in'] = array_map('intval', $post_ids);
    $args['orderby'] = 'post__in';
}

$query = new WP_Query($args);

// Also get Top Stories here for the combined section
$top_stories_number = get_theme_mod('code95_top_stories_number', 5);
$top_stories_args = array(
    'posts_per_page' => $top_stories_number,
    'meta_key' => 'code95_post_views',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
    'ignore_sticky_posts' => true,
);
$top_stories_query = new WP_Query($top_stories_args);

if ($query->have_posts() || $top_stories_query->have_posts()) :
?>
<section class="features-top-stories-section py-4">
    <div class="section-container">
        <div class="row">
            <!-- Features Column -->
            <div class="col-lg-8">
                <h2 class="section-title text-danger mb-4"><?php echo esc_html(get_theme_mod('code95_features_title', __('FEATURES', 'code95'))); ?></h2>
                <div class="row">
                    <?php
                    while ($query->have_posts()) : $query->the_post();
                    ?>
                        <div class="col-md-6 mb-4">
                            <article class="feature-item position-relative">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('code95-featured', array('class' => 'img-fluid w-100')); ?>
                                        </a>
                                        <div class="overlay-gradient"></div>
                                    </div>
                                <?php endif; ?>
                                <div class="post-content position-absolute bottom-0 start-0 p-3 text-white">
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) :
                                    ?>
                                        <span class="badge bg-danger mb-2"><?php echo esc_html($categories[0]->name); ?></span>
                                    <?php endif; ?>
                                    <h3 class="h5 mb-2">
                                        <a href="<?php the_permalink(); ?>" class="text-white text-decoration-none">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    <div class="excerpt small">
                                        <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
            
            <!-- Top Stories Column -->
            <?php if ($top_stories_query->have_posts()) : ?>
            <div class="col-lg-4">
                <h2 class="section-title text-danger mb-4"><?php echo esc_html(get_theme_mod('code95_top_stories_title', __('TOP STORIES', 'code95'))); ?></h2>
                <div class="top-stories-list">
                    <div class="top-stories-line"></div>
                    <?php
                    $counter = 0;
                    while ($top_stories_query->have_posts()) : $top_stories_query->the_post();
                        $counter++;
                    ?>
                        <article class="top-story-item d-flex align-items-start mb-3">
                            <span class="story-number text-white bg-danger rounded d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 32px; height: 32px; font-weight: 700;">
                                <?php echo $counter; ?>
                            </span>
                            <h3 class="h6 mb-0 lh-sm">
                                <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                        </article>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php
endif;
?> 
