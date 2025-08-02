<?php
/**
 * The template for displaying archive pages
 *
 * @package Code95
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container py-5">
        <?php if (have_posts()) : ?>
            
            <header class="page-header mb-5">
                <?php
                the_archive_title('<h1 class="page-title">', '</h1>');
                the_archive_description('<div class="archive-description">', '</div>');
                ?>
            </header>
            
            <div class="row">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <article id="post-<?php the_ID(); ?>" <?php post_class('card h-100'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="card-img-top">
                                    <?php the_post_thumbnail('code95-thumbnail'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h2 class="card-title h5">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="card-text">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">
                                    <?php echo get_the_date(); ?>
                                </small>
                            </div>
                        </article>
                    </div>
                    <?php
                endwhile;
                ?>
            </div>
            
            <?php
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('Previous', 'code95'),
                'next_text' => __('Next', 'code95'),
                'class' => 'pagination justify-content-center',
            ));
            
        else :
            ?>
            <p><?php esc_html_e('No posts found.', 'code95'); ?></p>
            <?php
        endif;
        ?>
    </div>
</main>

<?php
get_footer(); 