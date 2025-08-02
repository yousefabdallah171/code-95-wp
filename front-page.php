<?php
/**
 * ========================================
 * FRONT PAGE TEMPLATE
 * ========================================
 * 
 * This template is used for the front page of the website.
 * It acts as a wrapper that includes the home.php template
 * which contains the actual homepage content and sections.
 * 
 * @package Code95
 * @version 1.0.0
 * 
 * ========================================
 */

// ========================================
// INCLUDE HOME TEMPLATE
// ========================================
// Include the home.php template which contains the actual homepage content
// This allows for better organization by separating the front page logic
// from the actual homepage content display
include get_template_directory() . '/templates/home.php';
?> 