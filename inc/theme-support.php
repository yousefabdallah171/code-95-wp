<?php
/**
 * ========================================
 * THEME SUPPORT FUNCTIONS
 * ========================================
 * 
 * This file contains various theme support functions including
 * RTL support, excerpt customization, Google Fonts integration,
 * and widget area registration.
 * 
 * @package Code95
 * @version 1.0.0
 * 
 * ========================================
 */

// ========================================
// RTL (RIGHT-TO-LEFT) SUPPORT
// ========================================
/**
 * Adds RTL (Right-to-Left) language support.
 * This function enqueues RTL-specific stylesheets for languages
 * that read from right to left (like Arabic, Hebrew, etc.).
 */
function code95_rtl_support() {
    // Check if the current language is RTL
    if (is_rtl()) {
        // Enqueue RTL stylesheet with dependency on main theme styles
        wp_enqueue_style('code95-rtl', CODE95_URI . '/assets/css/rtl.css', array('code95-style'), CODE95_VERSION);
    }
}
// Hook to enqueue scripts with priority 20 (after main styles)
add_action('wp_enqueue_scripts', 'code95_rtl_support', 20);

// ========================================
// EXCERPT CUSTOMIZATION
// ========================================

/**
 * Customizes the excerpt length for posts.
 * This function sets the number of words to display in post excerpts.
 * 
 * @param int $length Default excerpt length
 * @return int Custom excerpt length
 */
function code95_excerpt_length($length) {
    return 20; // Show 20 words in excerpts
}
// Hook to filter excerpt length
add_filter('excerpt_length', 'code95_excerpt_length');

/**
 * Customizes the excerpt "more" text.
 * This function changes the default "..." text that appears
 * at the end of truncated excerpts.
 * 
 * @param string $more Default "more" text
 * @return string Custom "more" text
 */
function code95_excerpt_more($more) {
    return '...'; // Use simple ellipsis
}
// Hook to filter excerpt more text
add_filter('excerpt_more', 'code95_excerpt_more');

// ========================================
// GOOGLE FONTS INTEGRATION
// ========================================
/**
 * Enqueues Google Fonts based on customizer settings.
 * This function loads the appropriate Google Fonts based on
 * the heading and body font selections in the WordPress customizer.
 */
function code95_google_fonts() {
    // ========================================
    // AVAILABLE FONTS
    // ========================================
    // Define available Google Fonts with their API URLs
    $fonts = array(
        'Roboto' => 'Roboto:300,400,500,700',      // Modern sans-serif
        'Cairo' => 'Cairo:300,400,600,700',        // Arabic-friendly font
        'Montserrat' => 'Montserrat:300,400,500,700', // Clean geometric font
    );
    
    // ========================================
    // GET CUSTOMIZER SETTINGS
    // ========================================
    // Retrieve font selections from WordPress customizer
    $heading_font = get_theme_mod('code95_heading_font', 'Roboto');
    $body_font = get_theme_mod('code95_body_font', 'Roboto');
    
    // ========================================
    // BUILD FONT FAMILIES ARRAY
    // ========================================
    $font_families = array();
    
    // Add heading font if it exists in our available fonts
    if (isset($fonts[$heading_font])) {
        $font_families[] = $fonts[$heading_font];
    }
    
    // Add body font if it's different from heading font
    if (isset($fonts[$body_font]) && $body_font !== $heading_font) {
        $font_families[] = $fonts[$body_font];
    }
    
    // ========================================
    // ENQUEUE GOOGLE FONTS
    // ========================================
    // Only enqueue if we have fonts to load
    if (!empty($font_families)) {
        // Build Google Fonts URL with all selected fonts
        $fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $font_families) . '&display=swap';
        // Enqueue Google Fonts stylesheet
        wp_enqueue_style('code95-google-fonts', $fonts_url, array(), null);
    }
}
// Hook to enqueue Google Fonts
add_action('wp_enqueue_scripts', 'code95_google_fonts');

// ========================================
// WIDGET AREAS
// ========================================
/**
 * Registers widget areas (sidebars) for the theme.
 * This function creates widget areas that can be populated
 * with widgets from the WordPress admin.
 */
function code95_widgets_init() {
    // ========================================
    // MAIN SIDEBAR
    // ========================================
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'code95'),           // Widget area name
        'id' => 'sidebar-1',                                 // Unique ID for the widget area
        'description' => esc_html__('Add widgets here.', 'code95'), // Description for admin
        'before_widget' => '<section id="%1$s" class="widget %2$s">', // HTML before each widget
        'after_widget' => '</section>',                      // HTML after each widget
        'before_title' => '<h2 class="widget-title">',      // HTML before widget title
        'after_title' => '</h2>',                           // HTML after widget title
    ));
}
// Hook to widgets initialization
add_action('widgets_init', 'code95_widgets_init'); 