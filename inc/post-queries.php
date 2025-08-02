<?php
/**
 * ========================================
 * CUSTOM POST QUERIES
 * ========================================
 * 
 * This file contains custom WordPress query functions
 * for retrieving posts in different ways for various
 * sections of the theme (popular posts, category posts,
 * featured posts, main news, etc.).
 * 
 * @package Code95
 * @version 1.0.0
 * 
 * ========================================
 */

// ========================================
// POPULAR POSTS QUERY
// ========================================
/**
 * Retrieves posts ordered by view count.
 * This function queries posts that have the custom meta field
 * 'code95_post_views' and orders them by the view count.
 * 
 * @param int $number Number of posts to retrieve (default: 5)
 * @return WP_Query Query object with popular posts
 */
function code95_get_popular_posts($number = 5) {
    $args = array(
        'posts_per_page' => $number,           // Number of posts to show
        'meta_key' => 'code95_post_views',     // Custom meta field for view count
        'orderby' => 'meta_value_num',         // Order by numeric meta value
        'order' => 'DESC',                     // Descending order (most viewed first)
        'ignore_sticky_posts' => true,         // Don't prioritize sticky posts
    );
    
    return new WP_Query($args);
}

// ========================================
// CATEGORY POSTS QUERY
// ========================================
/**
 * Retrieves posts from a specific category.
 * This function gets posts from a given category ID,
 * useful for displaying category-specific content.
 * 
 * @param int $category_id The category ID to query
 * @param int $number Number of posts to retrieve (default: 4)
 * @return WP_Query Query object with category posts
 */
function code95_get_category_posts($category_id, $number = 4) {
    $args = array(
        'cat' => $category_id,                 // Category ID to filter by
        'posts_per_page' => $number,           // Number of posts to show
        'ignore_sticky_posts' => true,         // Don't prioritize sticky posts
    );
    
    return new WP_Query($args);
}

// ========================================
// FEATURED POSTS QUERY
// ========================================
/**
 * Retrieves featured posts either by specific post IDs
 * or by posts that have featured images.
 * 
 * @param array $post_ids Array of specific post IDs (optional)
 * @param int $number Number of posts to retrieve (default: 2)
 * @return WP_Query Query object with featured posts
 */
function code95_get_featured_posts($post_ids = array(), $number = 2) {
    if (empty($post_ids)) {
        // ========================================
        // QUERY POSTS WITH FEATURED IMAGES
        // ========================================
        // If no specific post IDs provided, get posts with thumbnails
        $args = array(
            'posts_per_page' => $number,       // Number of posts to show
            'meta_key' => '_thumbnail_id',     // Only posts with featured images
            'ignore_sticky_posts' => true,     // Don't prioritize sticky posts
        );
    } else {
        // ========================================
        // QUERY SPECIFIC POSTS BY ID
        // ========================================
        // If post IDs provided, get those specific posts
        $args = array(
            'post__in' => $post_ids,           // Array of specific post IDs
            'posts_per_page' => $number,       // Number of posts to show
            'orderby' => 'post__in',           // Maintain the order of provided IDs
            'ignore_sticky_posts' => true,     // Don't prioritize sticky posts
        );
    }
    
    return new WP_Query($args);
}

// ========================================
// MAIN NEWS QUERY
// ========================================
/**
 * Retrieves posts for the main news section.
 * This function supports different query types:
 * - 'recent': Most recent posts
 * - 'category': Posts from a specific category
 * - 'posts': Specific posts by ID
 * 
 * @param string $type Query type: 'recent', 'category', or 'posts'
 * @param string $value Category ID or comma-separated post IDs
 * @param int $number Number of posts to retrieve (default: 4)
 * @return WP_Query Query object with main news posts
 */
function code95_get_main_news($type = 'recent', $value = '', $number = 4) {
    // ========================================
    // BASE QUERY ARGUMENTS
    // ========================================
    $args = array(
        'posts_per_page' => $number,           // Number of posts to show
        'ignore_sticky_posts' => true,         // Don't prioritize sticky posts
        'meta_key' => '_thumbnail_id',         // Only posts with thumbnails
    );
    
    // ========================================
    // QUERY TYPE HANDLING
    // ========================================
    if ($type === 'category' && !empty($value)) {
        // Query posts from specific category
        $args['cat'] = intval($value);
        
    } elseif ($type === 'posts' && !empty($value)) {
        // Query specific posts by ID
        $post_ids = array_filter(array_map('intval', explode(',', $value)));
        if (!empty($post_ids)) {
            $args['post__in'] = $post_ids;     // Array of specific post IDs
            $args['orderby'] = 'post__in';     // Maintain the order of provided IDs
        }
    }
    // If type is 'recent' or invalid, use default recent posts query
    
    // ========================================
    // EXECUTE QUERY
    // ========================================
    $query = new WP_Query($args);
    
    // ========================================
    // DEBUG LOGGING
    // ========================================
    // Log query info if no posts found for debugging purposes
    if (!$query->have_posts()) {
        error_log('Code95: No posts found for Main News. Type: ' . $type . ', Value: ' . $value);
    }
    
    return $query;
} 