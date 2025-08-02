<?php
/**
 * The template for displaying all pages
 *
 * @package Code95
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container py-5">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header mb-4">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                </header>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail mb-4">
                        <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                    </div>
                <?php endif; ?>
                
                <div class="entry-content">
                    <?php
                    the_content();
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'code95'),
                        'after' => '</div>',
                    ));
                    ?>
                </div>
            </article>
            <?php
        endwhile;
        ?>
    </div>
</main>

<?php
get_footer(); 