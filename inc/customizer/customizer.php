<?php
/**
 * ========================================
 * WORDPRESS CUSTOMIZER CONFIGURATION
 * ========================================
 * 
 * This file contains all the WordPress customizer settings and controls
 * for the Code95 theme. It includes color options, typography settings,
 * section configurations, and various theme customization options.
 * 
 * @package Code95
 * @version 1.0.0
 * 
 * ========================================
 */

// ========================================
// INCLUDE CUSTOM CONTROLS
// ========================================
// Include custom control classes for enhanced functionality
require_once CODE95_DIR . '/inc/customizer/controls/section-order-control.php';
require_once CODE95_DIR . '/inc/customizer/top-header-image-control.php';

// ========================================
// CUSTOMIZER REGISTRATION FUNCTION
// ========================================
/**
 * Register all customizer settings and controls.
 * This function is hooked to 'customize_register' to add
 * all theme customization options to the WordPress customizer.
 * 
 * @param WP_Customize_Manager $wp_customize WordPress customizer manager object
 */
function code95_customize_register($wp_customize) {
    
    // ========================================
    // COLORS SECTION
    // ========================================
    /**
     * Colors section for theme color customization
     * Allows users to customize primary, secondary, and accent colors
     */
    $wp_customize->add_section('code95_colors', array(
        'title' => __('Colors', 'code95'),
        'priority' => 10,
    ));
    
    // ========================================
    // PRIMARY COLOR SETTING
    // ========================================
    // Main color setting (blue)
    $wp_customize->add_setting('code95_main_color', array(
        'default' => '#005fa3',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'code95_main_color', array(
        'label' => __('Primary Color (Blue)', 'code95'),
        'section' => 'code95_colors',
        'settings' => 'code95_main_color',
        'description' => __('Primary color used throughout the theme', 'code95'),
    )));
    
    // ========================================
    // SECONDARY COLOR SETTING
    // ========================================
    // Secondary color setting (red)
    $wp_customize->add_setting('code95_secondary_color', array(
        'default' => '#dc3545',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'code95_secondary_color', array(
        'label' => __('Secondary Color (Red)', 'code95'),
        'section' => 'code95_colors',
        'settings' => 'code95_secondary_color',
        'description' => __('Accent color for highlights and buttons', 'code95'),
    )));
    
    // ========================================
    // HEADER BACKGROUND COLOR
    // ========================================
    // Header background color setting
    $wp_customize->add_setting('code95_header_bg_color', array(
        'default' => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'code95_header_bg_color', array(
        'label' => __('Header Background Color', 'code95'),
        'section' => 'code95_colors',
        'settings' => 'code95_header_bg_color',
        'description' => __('Background color for the header area', 'code95'),
    )));
    
    // ========================================
    // FOOTER COLOR SETTING
    // ========================================
    // Footer/dark color setting
    $wp_customize->add_setting('code95_dark_color', array(
        'default' => '#212529',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'code95_dark_color', array(
        'label' => __('Footer Color', 'code95'),
        'section' => 'code95_colors',
        'settings' => 'code95_dark_color',
        'description' => __('Background color for the footer area', 'code95'),
    )));
    
    // ========================================
    // TYPOGRAPHY SECTION
    // ========================================
    /**
     * Typography section for font customization
     * Allows users to choose different fonts for headings and body text
     */
    $wp_customize->add_section('code95_typography', array(
        'title' => __('Typography', 'code95'),
        'priority' => 20,
    ));
    
    // ========================================
    // HEADING FONT SETTING
    // ========================================
    // Font selection for headings
    $wp_customize->add_setting('code95_heading_font', array(
        'default' => 'Roboto',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('code95_heading_font', array(
        'label' => __('Heading Font', 'code95'),
        'section' => 'code95_typography',
        'type' => 'select',
        'choices' => array(
            'Roboto' => 'Roboto',
            'Cairo' => 'Cairo',
            'Montserrat' => 'Montserrat',
            'Arial' => 'Arial',
            'Georgia' => 'Georgia',
        ),
        'description' => __('Font family for headings (h1, h2, h3, etc.)', 'code95'),
    ));
    
    // ========================================
    // BODY FONT SETTING
    // ========================================
    // Font selection for body text
    $wp_customize->add_setting('code95_body_font', array(
        'default' => 'Roboto',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('code95_body_font', array(
        'label' => __('Body Font', 'code95'),
        'section' => 'code95_typography',
        'type' => 'select',
        'choices' => array(
            'Roboto' => 'Roboto',
            'Cairo' => 'Cairo',
            'Montserrat' => 'Montserrat',
            'Arial' => 'Arial',
            'Georgia' => 'Georgia',
        ),
        'description' => __('Font family for body text', 'code95'),
    ));
    
    // ========================================
    // SECTION TITLES SECTION
    // ========================================
    /**
     * Section titles customization
     * Allows users to customize the titles of different homepage sections
     */
    $wp_customize->add_section('code95_section_titles', array(
        'title' => __('Section Titles', 'code95'),
        'priority' => 30,
    ));
    
    // ========================================
    // FEATURES SECTION TITLE
    // ========================================
    // Custom title for features section
    $wp_customize->add_setting('code95_features_title', array(
        'default' => __('FEATURES', 'code95'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('code95_features_title', array(
        'label' => __('Features Section Title', 'code95'),
        'section' => 'code95_section_titles',
        'type' => 'text',
        'description' => __('Enter the title for the Features section', 'code95'),
    ));
    
    // ========================================
    // EGY NEWS SECTION TITLE
    // ========================================
    // Custom title for EGY news section
    $wp_customize->add_setting('code95_egy_news_title', array(
        'default' => __('EGY NEWS', 'code95'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('code95_egy_news_title', array(
        'label' => __('EGY News Section Title', 'code95'),
        'section' => 'code95_section_titles',
        'type' => 'text',
        'description' => __('Enter the title for the EGY News section', 'code95'),
    ));
    
    // ========================================
    // TOP STORIES SECTION TITLE
    // ========================================
    // Custom title for top stories section
    $wp_customize->add_setting('code95_top_stories_title', array(
        'default' => __('TOP STORIES', 'code95'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('code95_top_stories_title', array(
        'label' => __('Top Stories Section Title', 'code95'),
        'section' => 'code95_section_titles',
        'type' => 'text',
        'description' => __('Enter the title for the Top Stories section', 'code95'),
    ));
    
    // ========================================
    // HOMEPAGE SECTIONS SECTION
    // ========================================
    /**
     * Homepage sections configuration
     * Allows users to enable/disable sections, set content sources,
     * and configure section-specific settings
     */
    $wp_customize->add_section('code95_homepage_sections', array(
        'title' => __('Homepage Sections', 'code95'),
        'priority' => 40,
    ));
    
    // ========================================
    // SECTION ORDER CONTROL
    // ========================================
    // Drag and drop section ordering
    $wp_customize->add_setting('code95_sections_order', array(
        'default' => 'main-news,egy-news,features',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control(new Code95_Section_Order_Control($wp_customize, 'code95_sections_order', array(
        'label' => __('Section Order', 'code95'),
        'section' => 'code95_homepage_sections',
        'settings' => 'code95_sections_order',
        'description' => __('Drag and drop to reorder homepage sections', 'code95'),
    )));
    
    // ========================================
    // MAIN NEWS SECTION SETTINGS
    // ========================================
    // Enable/disable main news section
    $wp_customize->add_setting('code95_enable_main_news', array(
        'default' => true,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_enable_main_news', array(
        'label' => __('Show Main News Section', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'checkbox',
    ));
    
    // Main news content source
    $wp_customize->add_setting('code95_main_news_type', array(
        'default' => 'recent',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('code95_main_news_type', array(
        'label' => __('Main News Source', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'select',
        'choices' => array(
            'recent' => __('Recent Posts', 'code95'),
            'category' => __('From Category', 'code95'),
            'posts' => __('Select Posts', 'code95'),
        ),
    ));
    
    // Main news category selection
    $wp_customize->add_setting('code95_main_news_category', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_main_news_category', array(
        'label' => __('Select Category', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'select',
        'choices' => code95_get_categories_list(),
        'description' => __('Choose a category for Main News posts', 'code95'),
    ));
    
    // Main news specific posts
    $wp_customize->add_setting('code95_main_news_posts', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('code95_main_news_posts', array(
        'label' => __('Post IDs (comma separated)', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'text',
        'description' => __('Enter specific post IDs separated by commas', 'code95'),
    ));
    
    // Main news post count
    $wp_customize->add_setting('code95_main_news_number', array(
        'default' => 4,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_main_news_number', array(
        'label' => __('Number of Posts', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 10,
        ),
    ));
    
    // ========================================
    // EGY NEWS SECTION SETTINGS
    // ========================================
    // Enable/disable EGY news section
    $wp_customize->add_setting('code95_enable_egy_news', array(
        'default' => true,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_enable_egy_news', array(
        'label' => __('Show EGY News Section', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'checkbox',
    ));
    
    // EGY news category selection
    $wp_customize->add_setting('code95_egy_news_category', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_egy_news_category', array(
        'label' => __('EGY News Category', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'select',
        'choices' => code95_get_categories_list(),
        'description' => __('Choose a category for EGY News posts', 'code95'),
    ));
    
    // EGY news post count
    $wp_customize->add_setting('code95_egy_news_number', array(
        'default' => 6,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_egy_news_number', array(
        'label' => __('Number of Posts', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 12,
        ),
    ));
    
    // ========================================
    // EGY NEWS SLIDER SETTINGS
    // ========================================
    // Auto-play enable/disable
    $wp_customize->add_setting('code95_egy_news_auto_play', array(
        'default' => true,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_egy_news_auto_play', array(
        'label' => __('Enable Auto-Play for EGY News Slider', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'checkbox',
        'description' => __('Automatically advance slides in the EGY News section', 'code95'),
    ));
    
    // Pause on hover setting
    $wp_customize->add_setting('code95_egy_news_pause_on_hover', array(
        'default' => true,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_egy_news_pause_on_hover', array(
        'label' => __('Pause Auto-Play on Hover', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'checkbox',
        'description' => __('Pause auto-play when hovering over the EGY News slider', 'code95'),
    ));
    
    // Auto-play speed setting
    $wp_customize->add_setting('code95_egy_news_auto_play_speed', array(
        'default' => 3,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_egy_news_auto_play_speed', array(
        'label' => __('Auto-Play Speed (seconds)', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 10,
            'step' => 0.5,
        ),
        'description' => __('Time between automatic slide transitions', 'code95'),
    ));
    
    // ========================================
    // FEATURES SECTION SETTINGS
    // ========================================
    // Enable/disable features section
    $wp_customize->add_setting('code95_enable_features', array(
        'default' => true,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_enable_features', array(
        'label' => __('Show Features Section', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'checkbox',
    ));
    
    // Features specific posts
    $wp_customize->add_setting('code95_features_posts', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('code95_features_posts', array(
        'label' => __('Featured Post IDs (comma separated)', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'text',
        'description' => __('Enter specific post IDs for the features section', 'code95'),
    ));
    
    // Features content source type
    $wp_customize->add_setting('code95_features_type', array(
        'default' => 'recent',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('code95_features_type', array(
        'label' => __('Features Source', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'select',
        'choices' => array(
            'recent' => __('Recent Posts', 'code95'),
            'category' => __('From Category', 'code95'),
            'posts' => __('Select Posts', 'code95'),
        ),
    ));
    
    // Features category selection
    $wp_customize->add_setting('code95_features_category', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_features_category', array(
        'label' => __('Features Category', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'select',
        'choices' => code95_get_categories_list(),
        'description' => __('Choose a category for Features posts', 'code95'),
    ));
    
    // ========================================
    // TOP STORIES SECTION SETTINGS
    // ========================================
    // Enable/disable top stories section
    $wp_customize->add_setting('code95_enable_top_stories', array(
        'default' => true,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_enable_top_stories', array(
        'label' => __('Show Top Stories Section', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'checkbox',
    ));
    
    // Top stories count
    $wp_customize->add_setting('code95_top_stories_number', array(
        'default' => 5,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_top_stories_number', array(
        'label' => __('Number of Top Stories', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 10,
        ),
    ));
    
    // ========================================
    // HEADER OPTIONS SECTION
    // ========================================
    /**
     * Header customization options
     * Allows users to configure header behavior and appearance
     */
    $wp_customize->add_section('code95_header_options', array(
        'title' => __('Header Options', 'code95'),
        'priority' => 50,
    ));
    
    // Sticky header setting
    $wp_customize->add_setting('code95_sticky_header', array(
        'default' => true,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_sticky_header', array(
        'label' => __('Enable Sticky Header', 'code95'),
        'section' => 'code95_header_options',
        'type' => 'checkbox',
        'description' => __('Make the header stick to the top when scrolling', 'code95'),
    ));
    
    // ========================================
    // FOOTER OPTIONS SECTION
    // ========================================
    /**
     * Footer customization options
     * Allows users to customize footer text and appearance
     */
    $wp_customize->add_section('code95_footer_options', array(
        'title' => __('Footer Options', 'code95'),
        'priority' => 60,
    ));
    
    // Footer text setting
    $wp_customize->add_setting('code95_footer_text', array(
        'default' => sprintf(__('© %s %s. All rights reserved.', 'code95'), date('Y'), get_bloginfo('name')),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'postMessage', // Enable live preview
    ));
    
    $wp_customize->add_control('code95_footer_text', array(
        'label' => __('Footer Text', 'code95'),
        'section' => 'code95_footer_options',
        'type' => 'textarea',
        'description' => __('Enter the footer text. You can use HTML tags like <strong> for bold text.', 'code95'),
        'input_attrs' => array(
            'placeholder' => sprintf(__('© %s %s. All rights reserved.', 'code95'), date('Y'), get_bloginfo('name')),
            'rows' => 3,
        ),
    ));
    
    // ========================================
    // SELECTIVE REFRESH FOR FOOTER
    // ========================================
    // Add selective refresh for footer text (live preview)
    $wp_customize->selective_refresh->add_partial('code95_footer_text', array(
        'selector' => '.site-footer p',
        'container_inclusive' => false,
        'render_callback' => function() {
            return wp_kses_post(get_theme_mod('code95_footer_text', sprintf(__('© %s %s. All rights reserved.', 'code95'), date('Y'), get_bloginfo('name'))));
        },
    ));
    
    // ========================================
    // ADDITIONAL COLOR SETTINGS
    // ========================================
    
    // Top stories line color
    $wp_customize->add_setting('code95_top_stories_line_color', array(
        'default' => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'code95_top_stories_line_color', array(
        'label' => __('Top Stories Line Color', 'code95'),
        'section' => 'code95_colors',
        'description' => __('Choose the color for the vertical line in Top Stories section', 'code95'),
    )));
    
    // Main news blue badge color
    $wp_customize->add_setting('code95_main_news_blue_badge_color', array(
        'default' => '#005fa3',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'code95_main_news_blue_badge_color', array(
        'label' => __('Main News Blue Badge Color', 'code95'),
        'section' => 'code95_colors',
        'description' => __('Choose the color for the blue badge in Main News section', 'code95'),
    )));
    
    // Main news separator color
    $wp_customize->add_setting('code95_main_news_separator_color', array(
        'default' => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage', // Enable live preview
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'code95_main_news_separator_color', array(
        'label' => __('Main News Separator Color', 'code95'),
        'section' => 'code95_colors',
        'description' => __('Choose the color for the separator line between Main News items', 'code95'),
    )));
    
    // EGY news divider color
    $wp_customize->add_setting('code95_egy_news_divider_color', array(
        'default' => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage', // Enable live preview
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'code95_egy_news_divider_color', array(
        'label' => __('EGY News Divider Color', 'code95'),
        'section' => 'code95_colors',
        'description' => __('Choose the color for the divider line in EGY News section', 'code95'),
    )));
    
    // EGY news separator enable/disable
    $wp_customize->add_setting('code95_egy_news_separator_enable', array(
        'default' => true,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('code95_egy_news_separator_enable', array(
        'label' => __('Show EGY News Separator Line', 'code95'),
        'section' => 'code95_homepage_sections',
        'type' => 'checkbox',
        'description' => __('Display separator line after EGY News section', 'code95'),
    ));
}
// Hook to WordPress customizer registration
add_action('customize_register', 'code95_customize_register');

// ========================================
// HELPER FUNCTIONS
// ========================================

/**
 * Get list of categories for customizer dropdowns.
 * This function retrieves all categories and formats them
 * for use in customizer select controls.
 * 
 * @return array Array of category choices for customizer
 */
function code95_get_categories_list() {
    // Get all categories
    $categories = get_categories(array(
        'hide_empty' => false,    // Include empty categories
        'orderby' => 'name',      // Sort by name
        'order' => 'ASC'          // Ascending order
    ));
    
    // Initialize choices array with default option
    $choices = array('' => __('Select Category', 'code95'));
    
    // Add categories to choices if they exist
    if (!empty($categories) && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $choices[$category->term_id] = $category->name;
        }
    }
    
    return $choices;
} 