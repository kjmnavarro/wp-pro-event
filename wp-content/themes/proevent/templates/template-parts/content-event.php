<article class="border p-4 rounded shadow bg-white">
    <h2 class="text-xl font-semibold"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <p class="text-sm text-gray-600">
        <?php echo esc_html( get_post_meta( get_the_ID(), '_event_date', true ) ); ?> at
        <?php echo esc_html( get_post_meta( get_the_ID(), '_event_time', true ) ); ?>
    </p>
    <p class="text-sm text-gray-800"><?php echo esc_html( get_post_meta( get_the_ID(), '_event_location', true ) ); ?></p>
</article>
