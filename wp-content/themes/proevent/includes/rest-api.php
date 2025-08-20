<?php
function proevent_register_rest_route() {
    register_rest_route( 'proevent/v1', '/next', array(
        'methods' => 'GET',
        'callback' => 'proevent_get_next_events',
    ) );
}
add_action( 'rest_api_init', 'proevent_register_rest_route' );

function proevent_get_next_events() {
    $args = array(
        'post_type' => 'event',
        'posts_per_page' => 5,
        'orderby' => 'date',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => '_event_date',
                'value' => current_time( 'mysql' ),
                'compare' => '>=',
                'type' => 'DATE',
            ),
        ),
    );
    $query = new WP_Query( $args );
    $events = array();

    while ( $query->have_posts() ) {
        $query->the_post();
        $events[] = array(
            'title' => get_the_title(),
            'date'  => get_post_meta( get_the_ID(), '_event_date', true ),
            'link'  => get_permalink(),
        );
    }

    return rest_ensure_response( $events );
}
?>
