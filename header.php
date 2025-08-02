<?php
/**
 * ========================================
 * THEME HEADER TEMPLATE
 * ========================================
 * 
 * This template displays the header section of the website.
 * It includes the HTML document structure, meta tags, and header content.
 * 
 * @package Code95
 * @version 1.0.0
 * 
 * ========================================
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <!-- ========================================
         META TAGS AND DOCUMENT SETUP
         ======================================== -->
    
    <!-- Character encoding for the document -->
    <meta charset="<?php bloginfo('charset'); ?>">
    
    <!-- Responsive viewport meta tag for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- XFN (XHTML Friends Network) profile link for social relationships -->
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Bootstrap Icons CDN for icon support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- WordPress head hook - includes necessary scripts, styles, and meta tags -->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- WordPress body open hook - allows plugins to add content right after body tag -->
<?php wp_body_open(); ?>

<!-- ========================================
     MAIN PAGE CONTAINER
     ======================================== -->
<div id="page" class="site">
    
    <!-- ========================================
         ACCESSIBILITY: SKIP TO CONTENT LINK
         ======================================== -->
    <!-- This link allows screen readers and keyboard users to skip navigation -->
    <a class="skip-link screen-reader-text" href="#primary">
        <?php esc_html_e('Skip to content', 'code95'); ?>
    </a>
    
    <!-- ========================================
         SITE HEADER TEMPLATE PART
         ======================================== -->
    <!-- Include the site header template part which contains navigation and branding -->
    <?php get_template_part('template-parts/header/site-header'); ?> 