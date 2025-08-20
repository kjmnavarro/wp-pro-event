<?php
get_header();

$today = date('Y-m-d');
$args = array(
    'post_type' => 'event',
    'posts_per_page' => 5,
    'meta_key' => '_event_date',
    'meta_value' => $today,
    'meta_compare' => '>=',
    'orderby' => 'meta_value',
    'order' => 'ASC',
);

$events = new WP_Query($args);

if ($events->have_posts()) : ?>
    <section class="max-w-4xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Upcoming Events</h1>
        <ul class="space-y-6">
            <?php while ($events->have_posts()) : $events->the_post(); 
                $event_date = get_post_meta(get_the_ID(), '_event_date', true);
                $event_time = get_post_meta(get_the_ID(), '_event_time', true);
                $event_location = get_post_meta(get_the_ID(), '_event_location', true);
                $registration_link = get_post_meta(get_the_ID(), '_event_registration_link', true);
            ?>
                <li class="p-6 border border-gray-300 rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <h2 class="text-xl font-semibold text-blue-600 hover:underline mb-2">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="text-gray-700 mb-2">
                        <p><strong>Date:</strong> <?php echo esc_html($event_date); ?></p>
                        <p><strong>Time:</strong> <?php echo esc_html($event_time); ?></p>
                        <p><strong>Location:</strong> <?php echo esc_html($event_location); ?></p>
                    </div>
                    <?php if ($registration_link) : ?>
                        <a href="<?php echo esc_url($registration_link); ?>" target="_blank" rel="noopener" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Register Here
                        </a>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        </ul>
    </section>
<?php else : ?>
    <p class="text-center p-6 text-gray-500">No upcoming events found.</p>
<?php endif;

wp_reset_postdata();

get_footer();
?>
