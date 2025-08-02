<?php
/**
 * The template for displaying all single posts
 *
 * @package Code95
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header mb-4">
                            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                            
                            <div class="entry-meta text-muted">
                                <?php
                                printf(
                                    esc_html__('Posted on %1$s by %2$s', 'code95'),
                                    '<time datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time>',
                                    '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>'
                                );
                                ?>
                            </div>
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
                        
                        <footer class="entry-footer mt-4">
                            <?php
                            $categories_list = get_the_category_list(esc_html__(', ', 'code95'));
                            if ($categories_list) {
                                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'code95') . '</span>', $categories_list);
                            }
                            
                            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'code95'));
                            if ($tags_list) {
                                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'code95') . '</span>', $tags_list);
                            }
                            ?>
                        </footer>
                    </article>
                    
                    <?php
                    // Post navigation
                    the_post_navigation(array(
                        'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'code95') . '</span> <span class="nav-title">%title</span>',
                        'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'code95') . '</span> <span class="nav-title">%title</span>',
                    ));
                    
                    // Comments
                    if (comments_open() || get_comments_number()) {
                        comments_template();
                    }
                    
                endwhile;
                ?>
            </div>
            
            <div class="col-lg-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer(); 