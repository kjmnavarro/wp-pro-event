<?php get_header(); ?>

<main class="container mx-auto py-8">
    <h1 class="text-2xl font-bold">Latest Posts</h1>
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            get_template_part( 'template-parts/content', get_post_type() );
        endwhile;
    else :
        echo '<p>No posts found.</p>';
    endif;
    ?>
</main>

<?php get_footer(); ?>
