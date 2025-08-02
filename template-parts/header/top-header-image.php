<?php
/**
 * Top Header Image
 *
 * @package Code95
 */

$top_header_image = get_theme_mod('code95_top_header_image', get_template_directory_uri() . '/assets/img/top-header.webp');
$top_header_image_alt = get_theme_mod('code95_top_header_image_alt', 'Top Header Image');
?>

<?php if ($top_header_image) : ?>
<div class="top-header-image-container">
    <div class="container">
        <div class="top-header-image-wrapper">
            <img src="<?php echo esc_url($top_header_image); ?>" 
                 alt="<?php echo esc_attr($top_header_image_alt); ?>" 
                 class="top-header-image"
                 width="813" 
                 height="98">
        </div>
    </div>
</div>
<?php endif; ?> 