<?php
/**
 * Top Header Image Customizer Controls
 *
 * @package Code95
 */

function code95_top_header_image_customizer($wp_customize) {
    // Top Header Image Section
    $wp_customize->add_section('code95_top_header_image', array(
        'title' => __('Top Header Image', 'code95'),
        'priority' => 25,
        'capability' => 'edit_theme_options',
    ));

    // Top Header Image Upload
    $wp_customize->add_setting('code95_top_header_image', array(
        'default' => get_template_directory_uri() . '/assets/img/top-header.webp',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'code95_top_header_image', array(
        'label' => __('Top Header Image', 'code95'),
        'description' => __('Upload or select the top header image (Recommended: 813x98px)', 'code95'),
        'section' => 'code95_top_header_image',
        'settings' => 'code95_top_header_image',
    )));

    // Top Header Image Alt Text
    $wp_customize->add_setting('code95_top_header_image_alt', array(
        'default' => 'Top Header Image',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('code95_top_header_image_alt', array(
        'label' => __('Image Alt Text', 'code95'),
        'description' => __('Enter alt text for accessibility', 'code95'),
        'section' => 'code95_top_header_image',
        'type' => 'text',
    ));

    // Show/Hide Top Header Image
    $wp_customize->add_setting('code95_show_top_header_image', array(
        'default' => true,
        'sanitize_callback' => 'code95_sanitize_checkbox',
    ));

    $wp_customize->add_control('code95_show_top_header_image', array(
        'label' => __('Show Top Header Image', 'code95'),
        'description' => __('Enable or disable the top header image', 'code95'),
        'section' => 'code95_top_header_image',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'code95_top_header_image_customizer');

// Sanitize checkbox function
function code95_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
} 