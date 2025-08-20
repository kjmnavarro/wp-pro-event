<?php
get_header();

if (have_posts()) :
    while (have_posts()) : the_post();

        $event_date = get_post_meta(get_the_ID(), '_event_date', true);
        $event_time = get_post_meta(get_the_ID(), '_event_time', true);
        $event_location = get_post_meta(get_the_ID(), '_event_location', true);
        $registration_link = get_post_meta(get_the_ID(), '_event_registration_link', true);
?>
        <article class="max-w-3xl mx-auto p-6">
            <h1 class="text-4xl font-bold mb-4"><?php the_title(); ?></h1>
            <div class="prose mb-6"><?php the_content(); ?></div>
            <ul class="mb-6 space-y-2 text-gray-700">
                <li><strong>Date:</strong> <?php echo esc_html($event_date); ?></li>
                <li><strong>Time:</strong> <?php echo esc_html($event_time); ?></li>
                <li><strong>Location:</strong> <?php echo esc_html($event_location); ?></li>
                <?php if ($registration_link) : ?>
                    <li>
                        <a href="<?php echo esc_url($registration_link); ?>" target="_blank" rel="noopener" class="text-blue-600 hover:underline">
                            Register Here
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </article>

        <section class="max-w-3xl mx-auto p-6">
            <h2 class="text-2xl font-semibold mb-4">Related Events</h2>
            <ul class="list-disc list-inside space-y-2 text-blue-600">
                <?php
                $terms = wp_get_post_terms(get_the_ID(), 'event-category', ['fields' => 'ids']);
                if (!empty($terms)) {
                    $related_args = [
                        'post_type' => 'event',
                        'posts_per_page' => 3,
                        'post__not_in' => [get_the_ID()],
                        'tax_query' => [
                            [
                                'taxonomy' => 'event-category',
                                'field' => 'term_id',
                                'terms' => $terms,
                            ],
                        ],
                    ];
                    $related_events = new WP_Query($related_args);
                    if ($related_events->have_posts()) {
                        while ($related_events->have_posts()) {
                            $related_events->the_post();
                ?>
                            <li>
                                <a href="<?php the_permalink(); ?>" class="hover:underline">
                                    <?php the_title(); ?>
                                </a>
                            </li>
                <?php
                        }
                        wp_reset_postdata();
                    } else {
                        echo '<li class="text-gray-500">No related events found.</li>';
                    }
                } else {
                    echo '<li class="text-gray-500">No related events found.</li>';
                }
                ?>
            </ul>
        </section>
<?php
    endwhile;
endif;

get_footer();
?>
