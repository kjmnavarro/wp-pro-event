<?php
function proevent_register_event_category_taxonomy() {
    $args = array(
        'public' => true,
        'label'  => 'Event Categories',
        'hierarchical' => true,
        'rewrite' => array( 'slug' => 'event-category' ),
    );
    register_taxonomy( 'event-category', 'event', $args );
}
add_action( 'init', 'proevent_register_event_category_taxonomy' );
?>
