<?php
function proevent_register_blocks() {
    register_block_type( get_template_directory() . '/blocks/hero-cta' );
    register_block_type( get_template_directory() . '/blocks/event-grid', [
        'render_callback' => 'proevent_render_event_grid',
        'attributes' => [
            'limit' => [ 'type' => 'number', 'default' => 5 ],
            'category' => [ 'type' => 'string', 'default' => '' ],
            'order' => [ 'type' => 'string', 'default' => 'ASC' ],
        ],
    ] );
}
add_action( 'init', 'proevent_register_blocks' );

function proevent_render_event_grid( $attributes ) {
    $limit = $attributes['limit'] ?? 5;
    $category = $attributes['category'] ?? '';
    $order = $attributes['order'] ?? 'ASC';

    $args = [
        'post_type' => 'event',
        'posts_per_page' => $limit,
        'order' => $order,
        'orderby' => 'meta_value',
        'meta_key' => '_event_date',
    ];

    if ( $category ) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'event-category',
                'field'    => 'slug',
                'terms'    => $category,
            ],
        ];
    }

    $query = new WP_Query( $args );

    if ( ! $query->have_posts() ) {
        return '<p>No events found.</p>';
    }

    $output = '<div class="proevent-event-grid">';
    while ( $query->have_posts() ) {
        $query->the_post();

        $date = get_post_meta( get_the_ID(), '_event_date', true );
        $link = get_permalink();

        $output .= '<article class="event-card">';
        $output .= '<h3>' . get_the_title() . '</h3>';
        $output .= '<p>Date: ' . esc_html( $date ) . '</p>';
        $output .= '<a href="' . esc_url( $link ) . '" class="btn btn-secondary">View Event</a>';
        $output .= '</article>';
    }
    $output .= '</div>';

    wp_reset_postdata();

    return $output;
}

?>