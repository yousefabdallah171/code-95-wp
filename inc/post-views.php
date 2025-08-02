<?php
/**
 * ========================================
 * POST AND PAGE VIEWS SYSTEM
 * ========================================
 * 
 * This file implements a comprehensive post and page view tracking system
 * for the Code95 WordPress theme. It includes view counting, admin interface,
 * dashboard widgets, shortcodes, and REST API support.
 * 
 * @package Code95
 * @version 1.0.0
 * 
 * ========================================
 */

// ========================================
// SECURITY: PREVENT DIRECT ACCESS
// ========================================
// Prevent direct access to this file for security
if (!defined('ABSPATH')) {
    exit;
}

// ========================================
// VIEW TRACKING FUNCTION
// ========================================
/**
 * Tracks post/page views and stores them in post meta.
 * This function is called on every page load via wp_head hook.
 * It includes various checks to prevent spam and invalid tracking.
 * 
 * @param int|null $post_id Post ID to track (optional, uses current post if not provided)
 */
function code95_track_post_views($post_id = null) {
    // ========================================
    // ADMIN USER CHECK
    // ========================================
    // Don't track views for administrators to avoid inflating counts
    if (current_user_can('manage_options')) {
        return;
    }
    
    // ========================================
    // ADMIN PAGE CHECK
    // ========================================
    // Don't track views on admin pages
    if (is_admin()) {
        return;
    }
    
    // ========================================
    // GET POST ID
    // ========================================
    // Get post ID if not provided
    if (!$post_id) {
        global $post;
        $post_id = $post->ID;
    }
    
    // ========================================
    // VALIDATE POST ID
    // ========================================
    // Ensure post ID is valid and numeric
    if (!$post_id || !is_numeric($post_id)) {
        return;
    }
    
    // ========================================
    // POST TYPE VALIDATION
    // ========================================
    // Check if this is a valid post or page type
    $post_type = get_post_type($post_id);
    if (!in_array($post_type, array('post', 'page'))) {
        return;
    }
    
    // ========================================
    // TRACKING ELIGIBILITY CHECK
    // ========================================
    // Check if we should track this view (prevents spam)
    if (!code95_should_track_view($post_id)) {
        return;
    }
    
    // ========================================
    // INCREMENT VIEW COUNT
    // ========================================
    // Get current view count from post meta
    $views = get_post_meta($post_id, 'code95_post_views', true);
    $views = $views ? intval($views) : 0;
    
    // Increment the view count
    $views++;
    
    // ========================================
    // UPDATE POST META
    // ========================================
    // Save the updated view count
    update_post_meta($post_id, 'code95_post_views', $views);
    // Save the timestamp of last view
    update_post_meta($post_id, 'code95_last_viewed', current_time('timestamp'));
    
    // ========================================
    // SET COOKIE TO PREVENT SPAM
    // ========================================
    // Set a cookie to prevent multiple views from same user in 24 hours
    setcookie('code95_viewed_' . $post_id, '1', time() + (24 * 60 * 60), '/');
}
// Hook to wp_head to track views on every page load
add_action('wp_head', 'code95_track_post_views');

// ========================================
// TRACKING ELIGIBILITY CHECK
// ========================================
/**
 * Determines if a view should be tracked for a specific post.
 * This function implements various checks to prevent spam and invalid tracking.
 * 
 * @param int $post_id Post ID to check
 * @return bool True if view should be tracked, false otherwise
 */
function code95_should_track_view($post_id) {
    // ========================================
    // COOKIE CHECK (SPAM PREVENTION)
    // ========================================
    // Don't track if already viewed in last 24 hours (prevents spam)
    $cookie_name = 'code95_viewed_' . $post_id;
    if (isset($_COOKIE[$cookie_name])) {
        return false;
    }
    
    // ========================================
    // PAGE TYPE CHECK
    // ========================================
    // Don't track on non-single pages (archives, search, etc.)
    if (!is_single() && !is_page()) {
        return false;
    }
    
    // ========================================
    // POST STATUS CHECK
    // ========================================
    // Don't track if post is not published
    $post_status = get_post_status($post_id);
    if ($post_status !== 'publish') {
        return false;
    }
    
    return true;
}

// ========================================
// VIEW COUNT RETRIEVAL
// ========================================
/**
 * Gets the view count for a specific post.
 * 
 * @param int|null $post_id Post ID (optional, uses current post if not provided)
 * @return int Number of views
 */
function code95_get_post_views($post_id = null) {
    if (!$post_id) {
        global $post;
        $post_id = $post->ID;
    }
    
    $views = get_post_meta($post_id, 'code95_post_views', true);
    return $views ? intval($views) : 0;
}

// ========================================
// VIEW DISPLAY FUNCTION
// ========================================
/**
 * Displays post views with optional text formatting.
 * 
 * @param int|null $post_id Post ID (optional)
 * @param bool $show_text Whether to show "view/views" text
 * @return string Formatted view count
 */
function code95_display_post_views($post_id = null, $show_text = true) {
    $views = code95_get_post_views($post_id);
    
    if ($show_text) {
        $text = _n('view', 'views', $views, 'code95');
        return sprintf('%d %s', $views, $text);
    }
    
    return $views;
}

// ========================================
// POPULAR POSTS QUERY BY TYPE
// ========================================
/**
 * Gets popular posts query with support for different post types.
 * 
 * @param int $number Number of posts to retrieve
 * @param string $post_type Post type (post, page, etc.)
 * @return WP_Query Query object with popular posts
 */
function code95_get_popular_posts_by_type($number = 5, $post_type = 'post') {
    $args = array(
        'posts_per_page' => $number,           // Number of posts to show
        'post_type' => $post_type,             // Post type to query
        'meta_key' => 'code95_post_views',     // Meta field for view count
        'orderby' => 'meta_value_num',         // Order by numeric meta value
        'order' => 'DESC',                     // Descending order (most viewed first)
        'ignore_sticky_posts' => true,         // Don't prioritize sticky posts
    );
    
    return new WP_Query($args);
}

// ========================================
// RECENT POSTS WITH VIEWS
// ========================================
/**
 * Gets recent posts with view count support.
 * 
 * @param int $number Number of posts to retrieve
 * @param string $post_type Post type
 * @return WP_Query Query object with recent posts
 */
function code95_get_recent_posts_with_views($number = 5, $post_type = 'post') {
    $args = array(
        'posts_per_page' => $number,           // Number of posts to show
        'post_type' => $post_type,             // Post type to query
        'orderby' => 'date',                   // Order by publication date
        'order' => 'DESC',                     // Descending order (newest first)
        'ignore_sticky_posts' => true,         // Don't prioritize sticky posts
    );
    
    return new WP_Query($args);
}

// ========================================
// ADMIN COLUMN INTEGRATION
// ========================================

/**
 * Adds views column to admin post/page lists.
 * 
 * @param array $columns Existing columns
 * @return array Modified columns array
 */
function code95_add_views_column($columns) {
    $columns['code95_views'] = __('Views', 'code95');
    return $columns;
}
// Add views column to posts and pages admin lists
add_filter('manage_posts_columns', 'code95_add_views_column');
add_filter('manage_pages_columns', 'code95_add_views_column');

/**
 * Displays view count in admin column.
 * 
 * @param string $column Column name
 * @param int $post_id Post ID
 */
function code95_display_views_column($column, $post_id) {
    if ($column === 'code95_views') {
        $views = code95_get_post_views($post_id);
        $last_viewed = get_post_meta($post_id, 'code95_last_viewed', true);
        
        echo '<strong>' . $views . '</strong>';
        
        if ($last_viewed) {
            echo '<br><small>' . date('M j, Y', $last_viewed) . '</small>';
        }
    }
}
// Hook to display views in admin columns
add_action('manage_posts_custom_column', 'code95_display_views_column', 10, 2);
add_action('manage_pages_custom_column', 'code95_display_views_column', 10, 2);

/**
 * Makes views column sortable in admin.
 * 
 * @param array $columns Existing sortable columns
 * @return array Modified sortable columns array
 */
function code95_make_views_column_sortable($columns) {
    $columns['code95_views'] = 'code95_views';
    return $columns;
}
// Make views column sortable for posts and pages
add_filter('manage_edit-post_sortable_columns', 'code95_make_views_column_sortable');
add_filter('manage_edit-page_sortable_columns', 'code95_make_views_column_sortable');

/**
 * Handles sorting by views column in admin.
 * 
 * @param WP_Query $query The query object
 */
function code95_handle_views_column_sorting($query) {
    if (!is_admin()) {
        return;
    }
    
    $orderby = $query->get('orderby');
    
    if ($orderby === 'code95_views') {
        $query->set('meta_key', 'code95_post_views');
        $query->set('orderby', 'meta_value_num');
    }
}
// Hook to handle views column sorting
add_action('pre_get_posts', 'code95_handle_views_column_sorting');

// ========================================
// META BOX INTEGRATION
// ========================================

/**
 * Adds views meta box to post/page edit screens.
 */
function code95_add_views_meta_box() {
    add_meta_box(
        'code95_views_meta_box',               // Meta box ID
        __('Post Views', 'code95'),            // Meta box title
        'code95_display_views_meta_box',       // Callback function
        array('post', 'page'),                 // Post types
        'side',                                // Context (side panel)
        'high'                                 // Priority
    );
}
// Hook to add meta box
add_action('add_meta_boxes', 'code95_add_views_meta_box');

/**
 * Displays views meta box content.
 * 
 * @param WP_Post $post Post object
 */
function code95_display_views_meta_box($post) {
    $views = code95_get_post_views($post->ID);
    $last_viewed = get_post_meta($post->ID, 'code95_last_viewed', true);
    
    // Add nonce for security
    wp_nonce_field('code95_views_meta_box', 'code95_views_nonce');
    ?>
    <div class="code95-views-meta-box">
        <!-- Current views display -->
        <p>
            <strong><?php _e('Total Views:', 'code95'); ?></strong><br>
            <span style="font-size: 24px; color: #0073aa;"><?php echo $views; ?></span>
        </p>
        
        <!-- Last viewed timestamp -->
        <?php if ($last_viewed) : ?>
        <p>
            <strong><?php _e('Last Viewed:', 'code95'); ?></strong><br>
            <?php echo date('F j, Y g:i a', $last_viewed); ?>
        </p>
        <?php endif; ?>
        
        <!-- Manual views input -->
        <p>
            <label for="code95_manual_views">
                <strong><?php _e('Manual Views Count:', 'code95'); ?></strong>
            </label><br>
            <input type="number" id="code95_manual_views" name="code95_manual_views" 
                   value="<?php echo $views; ?>" min="0" style="width: 100%;">
        </p>
        
        <!-- Reset views button -->
        <p>
            <button type="button" id="code95_reset_views" class="button button-secondary">
                <?php _e('Reset Views', 'code95'); ?>
            </button>
        </p>
    </div>
    
    <!-- JavaScript for reset functionality -->
    <script>
    jQuery(document).ready(function($) {
        $('#code95_reset_views').on('click', function() {
            if (confirm('<?php _e('Are you sure you want to reset the views count to 0?', 'code95'); ?>')) {
                $('#code95_manual_views').val('0');
            }
        });
    });
    </script>
    <?php
}

/**
 * Saves views meta box data.
 * 
 * @param int $post_id Post ID
 */
function code95_save_views_meta_box($post_id) {
    // ========================================
    // SECURITY CHECKS
    // ========================================
    // Check nonce for security
    if (!isset($_POST['code95_views_nonce']) || 
        !wp_verify_nonce($_POST['code95_views_nonce'], 'code95_views_meta_box')) {
        return;
    }
    
    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // ========================================
    // SAVE MANUAL VIEWS COUNT
    // ========================================
    // Save manual views count if provided
    if (isset($_POST['code95_manual_views'])) {
        $views = intval($_POST['code95_manual_views']);
        update_post_meta($post_id, 'code95_post_views', $views);
    }
}
// Hook to save meta box data
add_action('save_post', 'code95_save_views_meta_box');

// ========================================
// DASHBOARD WIDGET
// ========================================

/**
 * Adds views dashboard widget to WordPress admin.
 */
function code95_add_views_dashboard_widget() {
    wp_add_dashboard_widget(
        'code95_views_dashboard_widget',        // Widget ID
        __('Most Viewed Content', 'code95'),   // Widget title
        'code95_display_views_dashboard_widget' // Callback function
    );
}
// Hook to add dashboard widget
add_action('wp_dashboard_setup', 'code95_add_views_dashboard_widget');

/**
 * Displays views dashboard widget content.
 */
function code95_display_views_dashboard_widget() {
    // Get popular posts and pages
    $popular_posts = code95_get_popular_posts_by_type(10, 'post');
    $popular_pages = code95_get_popular_posts_by_type(5, 'page');
    
    // Display popular posts
    echo '<h3>' . __('Most Viewed Posts', 'code95') . '</h3>';
    
    if ($popular_posts->have_posts()) {
        echo '<ul class="code95-popular-posts-list">';
        while ($popular_posts->have_posts()) {
            $popular_posts->the_post();
            $views = code95_get_post_views(get_the_ID());
            echo '<li>';
            echo '<a href="' . get_edit_post_link() . '">' . get_the_title() . '</a>';
            echo ' <span style="color: #666;">(' . $views . ' views)</span>';
            echo '</li>';
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo '<p>' . __('No posts with views yet.', 'code95') . '</p>';
    }
    
    // Display popular pages
    echo '<h3>' . __('Most Viewed Pages', 'code95') . '</h3>';
    
    if ($popular_pages->have_posts()) {
        echo '<ul class="code95-popular-posts-list">';
        while ($popular_pages->have_posts()) {
            $popular_pages->the_post();
            $views = code95_get_post_views(get_the_ID());
            echo '<li>';
            echo '<a href="' . get_edit_post_link() . '">' . get_the_title() . '</a>';
            echo ' <span style="color: #666;">(' . $views . ' views)</span>';
            echo '</li>';
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo '<p>' . __('No pages with views yet.', 'code95') . '</p>';
    }
}

// ========================================
// SHORTCODES
// ========================================

/**
 * Shortcode to display post views.
 * Usage: [post_views post_id="123" show_text="true"]
 * 
 * @param array $atts Shortcode attributes
 * @return string Formatted view count
 */
function code95_post_views_shortcode($atts) {
    $atts = shortcode_atts(array(
        'post_id' => null,     // Post ID (optional)
        'show_text' => 'true'  // Whether to show "view/views" text
    ), $atts);
    
    $post_id = $atts['post_id'] ? intval($atts['post_id']) : null;
    $show_text = $atts['show_text'] === 'true';
    
    return code95_display_post_views($post_id, $show_text);
}
// Register shortcode
add_shortcode('post_views', 'code95_post_views_shortcode');

/**
 * Shortcode to display popular posts.
 * Usage: [popular_posts number="5" post_type="post"]
 * 
 * @param array $atts Shortcode attributes
 * @return string HTML list of popular posts
 */
function code95_popular_posts_shortcode($atts) {
    $atts = shortcode_atts(array(
        'number' => 5,         // Number of posts to show
        'post_type' => 'post'  // Post type to query
    ), $atts);
    
    $number = intval($atts['number']);
    $post_type = $atts['post_type'];
    
    $query = code95_get_popular_posts_by_type($number, $post_type);
    
    if (!$query->have_posts()) {
        return '<p>' . __('No posts found.', 'code95') . '</p>';
    }
    
    $output = '<ul class="code95-popular-posts-list">';
    
    while ($query->have_posts()) {
        $query->the_post();
        $views = code95_get_post_views(get_the_ID());
        $output .= '<li>';
        $output .= '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
        $output .= ' <span class="views-count">(' . $views . ' views)</span>';
        $output .= '</li>';
    }
    
    $output .= '</ul>';
    wp_reset_postdata();
    
    return $output;
}
// Register shortcode
add_shortcode('popular_posts', 'code95_popular_posts_shortcode');

// ========================================
// REST API SUPPORT
// ========================================

/**
 * Adds post views to WordPress REST API.
 */
function code95_add_views_to_rest_api() {
    register_rest_field(array('post', 'page'), 'post_views', array(
        'get_callback' => function($post_arr) {
            return code95_get_post_views($post_arr['id']);
        },
        'schema' => array(
            'description' => __('Number of views for this post/page', 'code95'),
            'type' => 'integer'
        )
    ));
}
// Hook to REST API initialization
add_action('rest_api_init', 'code95_add_views_to_rest_api');

// ========================================
// ADMIN STYLES
// ========================================

/**
 * Adds admin-specific styles for views functionality.
 */
function code95_add_views_admin_styles() {
    if (is_admin()) {
        echo '<style>
        .code95-popular-posts-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .code95-popular-posts-list li {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .code95-popular-posts-list li:last-child {
            border-bottom: none;
        }
        .code95-views-meta-box {
            text-align: center;
        }
        .views-count {
            color: #666;
            font-size: 0.9em;
        }
        </style>';
    }
}
// Hook to admin head
add_action('admin_head', 'code95_add_views_admin_styles');

// ========================================
// FRONTEND STYLES
// ========================================

/**
 * Adds frontend styles for views functionality.
 */
function code95_add_views_frontend_styles() {
    if (!is_admin()) {
        echo '<style>
        .code95-popular-posts-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .code95-popular-posts-list li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .code95-popular-posts-list li:last-child {
            border-bottom: none;
        }
        .views-count {
            color: #666;
            font-size: 0.9em;
        }
        </style>';
    }
}
// Hook to wp_head for frontend styles
add_action('wp_head', 'code95_add_views_frontend_styles'); 