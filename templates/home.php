<?php
/**
 * ========================================
 * HOMEPAGE TEMPLATE
 * ========================================
 * 
 * This template displays the homepage with dynamic sections
 * that can be reordered and enabled/disabled via the WordPress customizer.
 * 
 * @package Code95
 * @version 1.0.0
 * 
 * ========================================
 */

// Include the header template
get_header();
?>

<!-- ========================================
     HOMEPAGE MAIN CONTENT
     ======================================== -->
<main id="primary" class="site-main homepage">
    <?php
    // ========================================
    // DYNAMIC SECTION ORDERING
    // ========================================
    // Get the section order from WordPress customizer
    // Default order: main-news, egy-news, features
    $sections_order = get_theme_mod('code95_sections_order', 'main-news,egy-news,features');
    
    // Convert comma-separated string to array
    $sections = explode(',', $sections_order);
    
    // ========================================
    // LOOP THROUGH SECTIONS
    // ========================================
    // Loop through each section in the saved order
    foreach ($sections as $section) {
        // Remove any whitespace from section name
        $section = trim($section);
        
        // Create the setting name for checking if section is enabled
        // Convert hyphens to underscores for WordPress customizer compatibility
        $enabled_setting = 'code95_enable_' . str_replace('-', '_', $section);
        
        // ========================================
        // CHECK IF SECTION IS ENABLED
        // ========================================
        // Check if this section is enabled in the customizer
        // Default to true (enabled) if setting doesn't exist
        if (get_theme_mod($enabled_setting, true)) {
            // Include the section template part
            // Template parts are located in template-parts/sections/
            get_template_part('template-parts/sections/' . $section);
        }
    }
    ?>
</main>

<?php
// Include the footer template
get_footer();
?> 