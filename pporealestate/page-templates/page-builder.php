<?php 
/*
  Template Name: Page Builder
 */
get_header(); 
?>

<section class="page-builder">
    <?php
    while (have_posts()) : the_post();
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php the_content(); ?>
    </article><!-- #post -->
    <div class="container">
        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()) {
            comments_template();
        }
        ?>
    </div>
    <?php endwhile; ?>
</section>
<?php get_footer(); ?>