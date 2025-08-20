<?php
function proevent_add_event_meta_boxes() {
    add_meta_box(
        'event_details',
        'Event Details',
        'proevent_event_meta_box_callback',
        'event',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'proevent_add_event_meta_boxes' );

function proevent_event_meta_box_callback( $post ) {
    wp_nonce_field( 'proevent_save_event_details', 'proevent_event_nonce' );

    $event_date = get_post_meta( $post->ID, '_event_date', true );
    $event_time = get_post_meta( $post->ID, '_event_time', true );
    $event_location = get_post_meta( $post->ID, '_event_location', true );
    $registration_link = get_post_meta( $post->ID, '_event_registration_link', true );

    ?>
    <p><label for="event_date">Event Date</label><input type="date" name="event_date" id="event_date" value="<?php echo esc_attr( $event_date ); ?>" class="widefat"></p>
    <p><label for="event_time">Event Time</label><input type="time" name="event_time" id="event_time" value="<?php echo esc_attr( $event_time ); ?>" class="widefat"></p>
    <p><label for="event_location">Location</label><input type="text" name="event_location" id="event_location" value="<?php echo esc_attr( $event_location ); ?>" class="widefat"></p>
    <p><label for="registration_link">Registration Link</label><input type="url" name="registration_link" id="registration_link" value="<?php echo esc_attr( $registration_link ); ?>" class="widefat"></p>
    <?php
}

function proevent_save_event_details( $post_id ) {
    if ( ! isset( $_POST['proevent_event_nonce'] ) || ! wp_verify_nonce( $_POST['proevent_event_nonce'], 'proevent_save_event_details' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( isset( $_POST['event_date'] ) ) {
        update_post_meta( $post_id, '_event_date', sanitize_text_field( $_POST['event_date'] ) );
    }
    if ( isset( $_POST['event_time'] ) ) {
        update_post_meta( $post_id, '_event_time', sanitize_text_field( $_POST['event_time'] ) );
    }
    if ( isset( $_POST['event_location'] ) ) {
        update_post_meta( $post_id, '_event_location', sanitize_text_field( $_POST['event_location'] ) );
    }
    if ( isset( $_POST['registration_link'] ) ) {
        update_post_meta( $post_id, '_event_registration_link', esc_url_raw( $_POST['registration_link'] ) );
    }
}
add_action( 'save_post', 'proevent_save_event_details' );
?>
