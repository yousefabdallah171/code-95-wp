<?php
/**
 * ========================================
 * SITE HEADER TEMPLATE
 * ========================================
 * 
 * This template displays the main site header with navigation,
 * logo, search functionality, and responsive mobile menu.
 * It includes Bootstrap 5 navigation walker for proper menu structure.
 * 
 * @package Code95
 * @version 1.0.0
 * 
 * ========================================
 */

// ========================================
// GET CUSTOMIZER SETTINGS
// ========================================
// Retrieve header settings from WordPress customizer
$sticky_header = get_theme_mod('code95_sticky_header', true);           // Sticky header option
$header_bg_color = get_theme_mod('code95_header_bg_color', '#000000');  // Header background color
$show_top_header_image = get_theme_mod('code95_show_top_header_image', true); // Top header image option
?>

<!-- ========================================
     TOP HEADER IMAGE (OPTIONAL)
     ======================================== -->
<?php if ($show_top_header_image) : ?>
    <?php get_template_part('template-parts/header/top-header-image'); ?>
<?php endif; ?>

<!-- ========================================
     MAIN SITE HEADER
     ======================================== -->
<header id="masthead" class="site-header <?php echo $sticky_header ? 'sticky-top' : ''; ?>" style="background-color: <?php echo esc_attr($header_bg_color); ?>;">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="header-container">
            
            <!-- ========================================
                 SITE BRAND/LOGO
                 ======================================== -->
            <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                <?php
                // Display custom logo if set, otherwise show site name
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    bloginfo('name');
                }
                ?>
            </a>
            
            <!-- ========================================
                 DESKTOP NAVIGATION MENU
                 ======================================== -->
            <div class="navbar-collapse d-none d-lg-flex" id="desktop-menu">
                <div class="navbar-nav-wrapper">
                    
                    <!-- ========================================
                         PRIMARY NAVIGATION MENU
                         ======================================== -->
                    <?php
                    // Display the primary navigation menu
                    wp_nav_menu(array(
                        'theme_location' => 'primary',        // Menu location
                        'menu_class' => 'navbar-nav main-menu', // CSS classes
                        'container' => false,                 // No container div
                        'fallback_cb' => false,               // No fallback callback
                        'walker' => new Code95_Bootstrap_Nav_Walker(), // Custom walker for Bootstrap
                    ));
                    ?>
                    
                    <!-- ========================================
                         MORE MENU DROPDOWN
                         ======================================== -->
                    <!-- This dropdown shows additional menu items that don't fit in the main menu -->
                    <div class="more-menu-dropdown">
                        <button class="btn btn-link more-menu-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- Three dots icon for more menu -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                            </svg>
                        </button>
                        <ul class="dropdown-menu more-menu-items">
                            <!-- Additional menu items will be populated by JavaScript -->
                        </ul>
                    </div>
                </div>
                
                <!-- ========================================
                     SEARCH FORM
                     ======================================== -->
                <form class="d-flex" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <input class="form-control me-2" type="search" 
                           placeholder="<?php esc_attr_e('Search', 'code95'); ?>" 
                           aria-label="<?php esc_attr_e('Search', 'code95'); ?>" 
                           name="s" value="<?php echo get_search_query(); ?>">
                    <button class="btn btn-outline-light" type="submit">
                        <!-- Search icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </form>
            </div>
            
            <!-- ========================================
                 MOBILE TOGGLE BUTTON
                 ======================================== -->
            <!-- This button shows/hides the mobile menu on small screens -->
            <button class="navbar-toggler d-lg-none" type="button" 
                    data-bs-toggle="offcanvas" data-bs-target="#mobile-menu" 
                    aria-controls="mobile-menu" aria-expanded="false" 
                    aria-label="<?php esc_attr_e('Toggle navigation', 'code95'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
</header>

<!-- ========================================
     MOBILE OFFCANVAS MENU
     ======================================== -->
<!-- Bootstrap 5 offcanvas menu for mobile devices -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="mobile-menu" aria-labelledby="mobile-menu-label">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mobile-menu-label"><?php bloginfo('name'); ?></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        
        <!-- ========================================
             MOBILE NAVIGATION MENU
             ======================================== -->
        <?php
        // Display the same primary menu for mobile
        wp_nav_menu(array(
            'theme_location' => 'primary',        // Menu location
            'menu_class' => 'navbar-nav',         // CSS classes
            'container' => false,                 // No container div
            'fallback_cb' => false,               // No fallback callback
            'walker' => new Code95_Bootstrap_Nav_Walker(), // Custom walker for Bootstrap
        ));
        ?>
        
        <!-- ========================================
             MOBILE SEARCH FORM
             ======================================== -->
        <form class="d-flex mt-3" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input class="form-control me-2" type="search" 
                   placeholder="<?php esc_attr_e('Search', 'code95'); ?>" 
                   aria-label="<?php esc_attr_e('Search', 'code95'); ?>" 
                   name="s" value="<?php echo get_search_query(); ?>">
            <button class="btn btn-outline-light" type="submit">
                <!-- Search icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </button>
        </form>
    </div>
</div>

<?php
// ========================================
// BOOTSTRAP 5 NAVIGATION WALKER
// ========================================
/**
 * Custom navigation walker class for Bootstrap 5 compatibility.
 * This class extends WordPress's default Walker_Nav_Menu to output
 * Bootstrap 5 compatible HTML structure for navigation menus.
 */
class Code95_Bootstrap_Nav_Walker extends Walker_Nav_Menu {
    
    /**
     * Starts the list level (ul element).
     * 
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of menu item. Used for padding.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    /**
     * Starts the element output (li element).
     * 
     * @param string $output Passed by reference. Used to append additional content.
     * @param WP_Post $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     * @param int $id Current item ID.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        // ========================================
        // BUILD CSS CLASSES
        // ========================================
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $classes[] = 'nav-item';  // Bootstrap nav-item class
        
        // Add dropdown class for items with children
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'dropdown';
        }

        // Apply filters and join classes
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        // ========================================
        // BUILD ID ATTRIBUTE
        // ========================================
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        // ========================================
        // START LIST ITEM
        // ========================================
        $output .= $indent . '<li' . $id . $class_names .'>';

        // ========================================
        // BUILD LINK ATTRIBUTES
        // ========================================
        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';
        $atts['class'] = 'nav-link';  // Bootstrap nav-link class

        // Add dropdown classes for items with children
        if (in_array('menu-item-has-children', $classes)) {
            $atts['class'] .= ' dropdown-toggle';
            $atts['data-bs-toggle'] = 'dropdown';
            $atts['aria-expanded'] = 'false';
        }

        // Apply filters to attributes
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        // ========================================
        // BUILD ATTRIBUTES STRING
        // ========================================
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        // ========================================
        // BUILD LINK OUTPUT
        // ========================================
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        // Apply filters and append to output
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
?> 