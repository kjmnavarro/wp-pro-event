<?php get_header(); ?>

<main class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">All Events</h1>

    <?php
    if ( have_posts() ) :
        echo '<ul class="grid grid-cols-1 md:grid-cols-2 gap-6">';
        while ( have_posts() ) : the_post();
            get_template_part('template-parts/content', 'event');
        endwhile;
        echo '</ul>';
    else :
        echo '<p>No events found.</p>';
    endif;
    ?>
</main>

<?php get_footer(); ?>
