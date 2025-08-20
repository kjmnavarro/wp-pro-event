<?php
function proevent_add_theme_settings_page() {
    add_menu_page(
        'Company Settings',
        'Company Settings',
        'manage_options',
        'proevent-settings',
        'proevent_settings_page_callback',
        'dashicons-admin-generic'
    );
}
add_action( 'admin_menu', 'proevent_add_theme_settings_page' );

function proevent_settings_page_callback() {
    ?>
    <div class="wrap">
        <h1>Company Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'proevent_settings_group' );
            do_settings_sections( 'proevent-settings' );
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Logo</th>
                    <td><input type="text" name="company_logo" value="<?php echo esc_attr( get_option( 'company_logo' ) ); ?>" class="widefat"></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Brand Color</th>
                    <td><input type="text" name="brand_color" value="<?php echo esc_attr( get_option( 'brand_color' ) ); ?>" class="widefat"></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Social Links</th>
                    <td><input type="url" name="social_links" value="<?php echo esc_attr( get_option( 'social_links' ) ); ?>" class="widefat"></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function proevent_register_settings() {
    register_setting( 'proevent_settings_group', 'company_logo' );
    register_setting( 'proevent_settings_group', 'brand_color' );
    register_setting( 'proevent_settings_group', 'social_links' );
}
add_action( 'admin_init', 'proevent_register_settings' );
?>
