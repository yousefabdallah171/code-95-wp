<?php
/**
 * ========================================
 * SCRIPT AND STYLE ENQUEUING
 * ========================================
 * 
 * This file handles the enqueuing of all scripts and styles
 * for the Code95 WordPress theme, including external libraries,
 * theme assets, and customizer-generated CSS.
 * 
 * @package Code95
 * @version 1.0.0
 * 
 * ========================================
 */

// ========================================
// MAIN ENQUEUE FUNCTION
// ========================================
/**
 * Enqueues all scripts and styles for the theme.
 * This function is hooked to 'wp_enqueue_scripts' to load
 * assets on the frontend of the website.
 */
function code95_scripts() {
    // ========================================
    // EXTERNAL LIBRARIES
    // ========================================
    
    // Enqueue Bootstrap 5 CSS from CDN
    // Bootstrap provides the grid system and UI components
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), '5.3.0');
    
    // ========================================
    // THEME STYLESHEETS
    // ========================================
    // Enqueue theme styles in dependency order
    
    // Main theme stylesheet (compiled from SCSS)
    wp_enqueue_style('code95-style', CODE95_URI . '/assets/css/style.css', array('bootstrap'), CODE95_VERSION);
    
    // Header-specific styles
    wp_enqueue_style('code95-header', CODE95_URI . '/assets/css/header.css', array('bootstrap', 'code95-style'), CODE95_VERSION);
    
    // Top header image styles
    wp_enqueue_style('code95-top-header-image', CODE95_URI . '/assets/css/top-header-image.css', array('bootstrap', 'code95-style'), CODE95_VERSION);
    
    // Single post page styles
    wp_enqueue_style('code95-single-post', CODE95_URI . '/assets/css/single-post.css', array('bootstrap', 'code95-style'), CODE95_VERSION);
    
    // ========================================
    // JAVASCRIPT FILES
    // ========================================
    
    // Enqueue Bootstrap 5 JavaScript bundle from CDN
    // Load in footer for better page load performance
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), '5.3.0', true);
    
    // Theme-specific JavaScript files
    // Main theme JavaScript (depends on jQuery)
    wp_enqueue_script('code95-main', CODE95_URI . '/assets/js/main.js', array('jquery'), CODE95_VERSION, true);
    
    // Menu overflow handling script (depends on Bootstrap)
    wp_enqueue_script('code95-menu-overflow', CODE95_URI . '/assets/js/menu-overflow.js', array('bootstrap'), CODE95_VERSION, true);
    
    // ========================================
    // SLIDER SETTINGS FOR JAVASCRIPT
    // ========================================
    // Pass customizer settings to JavaScript for slider functionality
    $slider_settings = array(
        'autoPlay' => get_theme_mod('code95_egy_news_auto_play', true),           // Auto-play slider
        'pauseOnHover' => get_theme_mod('code95_egy_news_pause_on_hover', true),   // Pause on hover
        'autoPlaySpeed' => get_theme_mod('code95_egy_news_auto_play_speed', 3) * 1000  // Speed in milliseconds
    );
    
    // Localize script to make settings available in JavaScript
    wp_localize_script('code95-main', 'code95SliderSettings', $slider_settings);
    
    // ========================================
    // CUSTOMIZER-GENERATED CSS
    // ========================================
    // Generate CSS from customizer settings and add inline
    $custom_css = code95_get_customizer_css();
    wp_add_inline_style('code95-style', $custom_css);
}
// Hook to WordPress enqueue scripts action
add_action('wp_enqueue_scripts', 'code95_scripts');

// ========================================
// CUSTOMIZER CSS GENERATION
// ========================================
/**
 * Generates CSS from WordPress customizer settings.
 * This function creates CSS variables and rules based on
 * user-selected colors, fonts, and other theme options.
 * 
 * @return string Generated CSS
 */
function code95_get_customizer_css() {
    // ========================================
    // GET CUSTOMIZER SETTINGS
    // ========================================
    // Retrieve color settings from customizer with fallbacks
    $main_color = get_theme_mod('code95_main_color', '#005fa3');           // Primary blue color
    $secondary_color = get_theme_mod('code95_secondary_color', '#dc3545'); // Secondary red color
    $dark_color = get_theme_mod('code95_dark_color', '#212529');           // Dark color
    $header_bg_color = get_theme_mod('code95_header_bg_color', '#000000'); // Header background
    
    // Font settings from customizer
    $heading_font = get_theme_mod('code95_heading_font', 'Roboto');        // Heading font
    $body_font = get_theme_mod('code95_body_font', 'Roboto');              // Body font
    
    // Section-specific color settings
    $top_stories_line_color = get_theme_mod('code95_top_stories_line_color', '#000000');
    $main_news_blue_badge_color = get_theme_mod('code95_main_news_blue_badge_color', '#005fa3');
    $main_news_separator_color = get_theme_mod('code95_main_news_separator_color', '#000000');
    $egy_news_divider_color = get_theme_mod('code95_egy_news_divider_color', '#000000');
    
    // ========================================
    // GENERATE CSS
    // ========================================
    $css = "
        /* ========================================
           CSS VARIABLES FROM CUSTOMIZER
           ======================================== */
        :root {
            --code95-main-color: {$main_color};
            --code95-secondary-color: {$secondary_color};
            --code95-dark: {$dark_color};
            --code95-heading-font: {$heading_font}, sans-serif;
            --code95-body-font: {$body_font}, sans-serif;
            --code95-top-stories-line-color: {$top_stories_line_color};
            --code95-main-news-blue-badge-color: {$main_news_blue_badge_color};
            --code95-main-news-separator-color: {$main_news_separator_color};
            --code95-egy-news-divider-color: {$egy_news_divider_color};
        }
        
        /* ========================================
           TYPOGRAPHY SETTINGS
           ======================================== */
        body {
            font-family: var(--code95-body-font);
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--code95-heading-font);
        }
        
        /* ========================================
           HEADER STYLING
           ======================================== */
        .navbar {
            background-color: {$header_bg_color} !important;
        }
        
        /* ========================================
           COMPONENT STYLING
           ======================================== */
        .badge-category {
            background-color: var(--code95-main-color);
        }
        .section-title {
            color: var(--code95-secondary-color);
        }
        .story-number {
            background-color: var(--code95-secondary-color) !important;
        }
        .bg-danger {
            background-color: var(--code95-secondary-color) !important;
        }
        .text-danger {
            color: var(--code95-secondary-color) !important;
        }
        .site-footer {
            background-color: var(--code95-dark) !important;
        }
        .slider-nav svg circle {
            fill: var(--code95-secondary-color);
        }
        .main-news-separator {
            background-color: {$main_news_separator_color} !important;
        }
        .egy-news-divider .line {
            background-color: {$egy_news_divider_color} !important;
        }
    ";
    
    return $css;
}

// ========================================
// CUSTOMIZER PREVIEW SCRIPTS
// ========================================
/**
 * Enqueues scripts for the WordPress customizer preview.
 * This allows for live preview of changes in the customizer.
 */
function code95_customize_preview_js() {
    wp_enqueue_script('code95-customizer', CODE95_URI . '/assets/js/customizer.js', array('customize-preview'), CODE95_VERSION, true);
}
// Hook to customizer preview initialization
add_action('customize_preview_init', 'code95_customize_preview_js'); 