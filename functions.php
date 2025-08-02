<?php
/**
 * ========================================
 * CODE95 THEME FUNCTIONS AND DEFINITIONS
 * ========================================
 * 
 * This file contains all the core functionality for the Code95 WordPress theme.
 * It handles theme setup, includes required files, and defines custom functions.
 * 
 * @package Code95
 * @version 1.0.0
 * @author Code95 Development Team
 * 
 * ========================================
 */

// ========================================
// THEME CONSTANTS
// ========================================
// Define version for cache busting and updates
define('CODE95_VERSION', '1.0.0');
// Define theme directory path for file includes
define('CODE95_DIR', get_template_directory());
// Define theme URI for asset loading
define('CODE95_URI', get_template_directory_uri());

// ========================================
// THEME SETUP FUNCTION
// ========================================
/**
 * Sets up theme defaults and registers support for various WordPress features.
 * This function is hooked to 'after_setup_theme' to ensure it runs after the theme is loaded.
 */
function code95_setup() {
    // ========================================
    // INTERNATIONALIZATION (I18N)
    // ========================================
    // Load theme text domain for translations
    // This allows the theme to be translated into different languages
    load_theme_textdomain('code95', CODE95_DIR . '/languages');
    
    // ========================================
    // THEME SUPPORT FEATURES
    // ========================================
    // Enable automatic title tag generation for better SEO
    add_theme_support('title-tag');
    
    // Enable post thumbnails (featured images) for posts and pages
    add_theme_support('post-thumbnails');
    
    // Enable HTML5 markup for various elements
    // This provides better semantic markup and accessibility
    add_theme_support('html5', array(
        'search-form',      // Better search form markup
        'comment-form',     // Better comment form markup
        'comment-list',     // Better comment list markup
        'gallery',          // Better gallery markup
        'caption',          // Better image caption markup
        'style',            // Better style tag markup
        'script',           // Better script tag markup
    ));
    
    // ========================================
    // CUSTOM IMAGE SIZES
    // ========================================
    // Define custom image sizes for different content areas
    // Format: add_image_size('name', width, height, crop)
    add_image_size('code95-featured', 750, 500, true);    // Featured post images
    add_image_size('code95-thumbnail', 350, 250, true);   // Post thumbnails
    add_image_size('code95-small', 150, 100, true);       // Small thumbnails
    
    // ========================================
    // NAVIGATION MENUS
    // ========================================
    // Register navigation menu locations
    // These menus can be managed from Appearance > Menus in WordPress admin
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'code95'), // Main navigation menu
    ));
}
// Hook the setup function to run after theme is loaded
add_action('after_setup_theme', 'code95_setup');

// ========================================
// INCLUDE REQUIRED FILES
// ========================================
// Load all the theme's functionality from separate files for better organization

// Enqueue scripts and styles
require_once CODE95_DIR . '/inc/enqueue.php';

// Theme support features
require_once CODE95_DIR . '/inc/theme-support.php';

// Custom post queries for different sections
require_once CODE95_DIR . '/inc/post-queries.php';

// Post view counting functionality
require_once CODE95_DIR . '/inc/post-views.php';

// WordPress customizer controls and settings
require_once CODE95_DIR . '/inc/customizer/customizer.php';

// ========================================
// CUSTOM BODY CLASSES
// ========================================
/**
 * Adds custom classes to the body element.
 * This is useful for conditional styling based on page type or features.
 * 
 * @param array $classes Array of existing body classes
 * @return array Modified array of body classes
 */
function code95_body_classes($classes) {
    // Add RTL (right-to-left) class for languages that read from right to left
    if (is_rtl()) {
        $classes[] = 'rtl-mode';
    }
    return $classes;
}
// Hook to filter body classes
add_filter('body_class', 'code95_body_classes');

// ========================================
// THEME ACTIVATION SETTINGS
// ========================================
/**
 * Sets up default theme settings when the theme is activated.
 * This function runs only once when the theme is switched to.
 */
function code95_after_switch_theme() {
    // ========================================
    // HOMEPAGE SETUP
    // ========================================
    // Try to find an existing 'Home' page
    $homepage = get_page_by_title('Home');
    
    // If no 'Home' page exists, create one
    if (!$homepage) {
        $homepage_id = wp_insert_post(array(
            'post_title' => 'Home',                    // Page title
            'post_type' => 'page',                     // Post type
            'post_status' => 'publish',                // Published status
            'page_template' => 'templates/home.php'    // Use custom home template
        ));
    } else {
        // Use existing homepage ID
        $homepage_id = $homepage->ID;
    }
    
    // ========================================
    // WORDPRESS READING SETTINGS
    // ========================================
    // Set the front page to display a static page
    update_option('show_on_front', 'page');
    // Set the specific page to use as the front page
    update_option('page_on_front', $homepage_id);
}
// Hook to run when theme is activated
add_action('after_switch_theme', 'code95_after_switch_theme'); 

// ========================================
// DEBUG FUNCTION (TEMPORARY)
// ========================================
/**
 * Temporary debug function to display available categories.
 * This function should be removed after testing is complete.
 * Only visible to administrators for security.
 */
function code95_debug_categories() {
    // Only show debug info to administrators
    if (current_user_can('manage_options')) {
        // Get all categories, including empty ones
        $categories = get_categories(array(
            'hide_empty' => false,    // Include categories with no posts
            'orderby' => 'name',      // Sort by name
            'order' => 'ASC'          // Ascending order
        ));
        
        // Display debug information in a styled container
        echo '<div style="background: #f0f0f0; padding: 10px; margin: 10px; border: 1px solid #ccc;">';
        echo '<h3>Debug: Available Categories</h3>';
        echo '<p>Total categories found: ' . count($categories) . '</p>';
        
        // Display each category if any exist
        if (!empty($categories)) {
            echo '<ul>';
            foreach ($categories as $category) {
                echo '<li>ID: ' . $category->term_id . ' - Name: ' . $category->name . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No categories found!</p>';
        }
        echo '</div>';
    }
}

