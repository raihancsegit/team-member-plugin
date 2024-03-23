<?php 

class Team_members_admin {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    public function add_plugin_page() {
        add_options_page(
            'Plugin Settings',
            'Plugin Settings',
            'manage_options',
            'plugin-settings',
            array( $this, 'create_admin_page' )
        );
    }

    public function create_admin_page() {
        ?>
<div class="wrap">
    <h1>Plugin Settings</h1>
    <form method="post" action="options.php">
        <?php
                settings_fields( 'team_member_settings' );
                do_settings_sections( 'plugin-settings' );
                submit_button();
                ?>
    </form>
</div>
<?php
    }

    public function page_init() {
        register_setting(
            'team_member_settings',
            'team_member_settings',
            array( $this, 'sanitize' )
        );

        add_settings_section(
            'team_member_settings_section',
            'Post Type Settings',
            array( $this, 'print_section_info' ),
            'plugin-settings'
        );

        add_settings_field(
            'post_type_name',
            'Post Type Name',
            array( $this, 'post_type_name_callback' ),
            'plugin-settings',
            'team_member_settings_section'
        );

        add_settings_field(
            'url_slug',
            'URL Slug',
            array( $this, 'url_slug_callback' ),
            'plugin-settings',
            'team_member_settings_section'
        );
    }

    public function sanitize( $input ) {
        $new_input = array();
        if ( isset( $input['post_type_name'] ) ) {
            $new_input['post_type_name'] = sanitize_text_field( $input['post_type_name'] );
        }

        if ( isset( $input['url_slug'] ) ) {
            $new_input['url_slug'] = sanitize_text_field( $input['url_slug'] );
        }

        return $new_input;
    }

    public function print_section_info() {
        print 'Enter your settings below:';
    }

    public function post_type_name_callback() {
        $options = get_option( 'team_member_settings' );
        printf(
            '<input type="text" id="post_type_name" name="team_member_settings[post_type_name]" value="%s" />',
            isset( $options['post_type_name'] ) ? esc_attr( $options['post_type_name'] ) : ''
        );
    }

    public function url_slug_callback() {
        $options = get_option( 'team_member_settings' );
        printf(
            '<input type="text" id="url_slug" name="team_member_settings[url_slug]" value="%s" />',
            isset( $options['url_slug'] ) ? esc_attr( $options['url_slug'] ) : ''
        );
    }
}
new Team_members_admin();