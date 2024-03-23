<?php 

class Team_members_post_type {

    private $post_type_name;
    private $url_slug;
    
    public function __construct()
    {
        add_action('init', array(&$this,'team_member_custom_post_type')); 
        add_action('init', array(&$this,'member_type_taxonomy')); 

         // Retrieve settings
         $options = get_option( 'team_member_settings' );
         $this->post_type_name = isset( $options['post_type_name'] ) ? $options['post_type_name'] : 'Team Member';
         $this->url_slug = isset( $options['url_slug'] ) ? $options['url_slug'] : 'team-member';

         // Add custom meta fields
        add_action( 'add_meta_boxes', array( $this, 'add_custom_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_custom_meta_fields' ) );

        // Add custom single page template
        add_filter( 'template_include', array( $this, 'include_custom_template' ) );
    }
    public function team_member_custom_post_type(){
        $labels = array(
            'name'                  => __( $this->post_type_name ,'team_members_orbit_technology'),
            'singular_name'         => __( $this->post_type_name ,'team_members_orbit_technology'),
            'menu_name'             => __($this->post_type_name,'team_members_orbit_technology'),
            'name_admin_bar'        => __( $this->post_type_name , 'team_members_orbit_technology' ),
            'archives'              => __( $this->post_type_name . ' Archives', 'team_members_orbit_technology' ),
            'attributes'            => __( $this->post_type_name.' Attributes', 'team_members_orbit_technology' ),
            'parent_item_colon'     => __( 'Parent '.$this->post_type_name, 'team_members_orbit_technology' ),
            'all_items'             => __( 'All '.$this->post_type_name, 'team_members_orbit_technology' ),
            'add_new_item'          => __( 'Add New '.$this->post_type_name, 'team_members_orbit_technology' ),
            'add_new'               => __( 'Add New '.$this->post_type_name, 'team_members_orbit_technology' ),
            'new_item'              => __( 'New '.$this->post_type_name, 'team_members_orbit_technology' ),
            'edit_item'             => __( 'Edit '.$this->post_type_name, 'team_members_orbit_technology' ),
            'update_item'           => __( 'Update '.$this->post_type_name, 'team_members_orbit_technology' ),
            'view_item'             => __( 'View '.$this->post_type_name, 'team_members_orbit_technology' ),
            'view_items'            => __( 'View '.$this->post_type_name, 'team_members_orbit_technology' ),
            'search_items'          => __( 'Search '.$this->post_type_name, 'team_members_orbit_technology' ),
            'not_found'             => __( 'Not found', 'team_members_orbit_technology' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'team_members_orbit_technology' ),
            'featured_image'        => __( 'Featured Image', 'team_members_orbit_technology' ),
            'set_featured_image'    => __( 'Set featured image', 'team_members_orbit_technology' ),
            'remove_featured_image' => __( 'Remove featured image', 'team_members_orbit_technology' ),
            'use_featured_image'    => __( 'Use as featured image', 'team_members_orbit_technology' ),
            'insert_into_item'      => __( 'Insert into team member', 'team_members_orbit_technology' ),
            'uploaded_to_this_item' => __( 'Uploaded to this team member', 'team_members_orbit_technology' ),
            'items_list'            => __( $this->post_type_name.' list', 'team_members_orbit_technology' ),
            'items_list_navigation' => __( $this->post_type_name.' list navigation', 'team_members_orbit_technology' ),
            'filter_items_list'     => __( 'Filter '.$this->post_type_name.' list', 'team_members_orbit_technology' ),
        );
        $args = array(
            'label'                 => __( $this->post_type_name ),
            'rewrite'               => array( 'slug' => $this->url_slug ),
            'description'           => __( $this->post_type_name.' Description', 'team_members_orbit_technology' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'thumbnail'),
            'taxonomies'            => array( 'member_type' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-groups',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( $this->url_slug, $args );
    }

    public function member_type_taxonomy(){
        $labels = array(
            'name'                       => _x( 'Member Types', 'Taxonomy General Name', 'team_members_orbit_technology' ),
            'singular_name'              => _x( 'Member Type', 'Taxonomy Singular Name', 'team_members_orbit_technology' ),
            'menu_name'                  => __( 'Member Type', 'team_members_orbit_technology' ),
            'all_items'                  => __( 'All Member Types', 'team_members_orbit_technology' ),
            'parent_item'                => __( 'Parent Member Type', 'team_members_orbit_technology' ),
            'parent_item_colon'          => __( 'Parent Member Type:', 'team_members_orbit_technology' ),
            'new_item_name'              => __( 'New Member Type Name', 'team_members_orbit_technology' ),
            'add_new_item'               => __( 'Add New Member Type', 'team_members_orbit_technology' ),
            'edit_item'                  => __( 'Edit Member Type', 'team_members_orbit_technology' ),
            'update_item'                => __( 'Update Member Type', 'team_members_orbit_technology' ),
            'view_item'                  => __( 'View Member Type', 'team_members_orbit_technology' ),
            'separate_items_with_commas' => __( 'Separate member types with commas', 'team_members_orbit_technology' ),
            'add_or_remove_items'        => __( 'Add or remove member types', 'team_members_orbit_technology' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'team_members_orbit_technology' ),
            'popular_items'              => __( 'Popular Member Types', 'team_members_orbit_technology' ),
            'search_items'               => __( 'Search Member Types', 'team_members_orbit_technology' ),
            'not_found'                  => __( 'Not Found', 'team_members_orbit_technology' ),
            'no_terms'                   => __( 'No member types', 'team_members_orbit_technology' ),
            'items_list'                 => __( 'Member types list', 'team_members_orbit_technology' ),
            'items_list_navigation'      => __( 'Member types list navigation', 'team_members_orbit_technology' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => false,
        );
        register_taxonomy( 'member_type', $this->url_slug, $args );
    }

    public function add_custom_meta_boxes() {
        add_meta_box(
            'team_member_meta_box',
            'Team Member Details',
            array( $this, 'render_custom_meta_box' ),
            $this->url_slug,
            'normal',
            'default'
        );
    }

    public function render_custom_meta_box( $post ) {
        wp_nonce_field( 'team_member_meta_box', 'team_member_meta_box_nonce' );
        $bio = get_post_meta( $post->ID, '_team_member_bio', true );
        $position = get_post_meta( $post->ID, '_team_member_position', true );

        ?>
<p>
    <label for="team_member_bio">Bio:</label>
</p>
<p>
    <textarea id="team_member_bio" name="team_member_bio" rows="5" cols="50"><?php echo esc_html( $bio ); ?></textarea>
</p>
<p>
    <label for="team_member_position">Position:</label>
</p>
<p>
    <input type="text" id="team_member_position" name="team_member_position"
        value="<?php echo esc_attr( $position ); ?>" />
</p>
<?php
    }

    public function save_custom_meta_fields( $post_id ) {
        if ( ! isset( $_POST['team_member_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['team_member_meta_box_nonce'], 'team_member_meta_box' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( isset( $_POST['team_member_bio'] ) ) {
            update_post_meta( $post_id, '_team_member_bio', sanitize_text_field( $_POST['team_member_bio'] ) );
        }

        if ( isset( $_POST['team_member_position'] ) ) {
            update_post_meta( $post_id, '_team_member_position', sanitize_text_field( $_POST['team_member_position'] ) );
        }
    }

    public function include_custom_template( $template ) {
        if ( is_singular( $this->url_slug ) ) {
            return plugin_dir_path( __FILE__ ) . 'templates/single-page-template.php';
        }
        return $template;
    }
}
new Team_members_post_type();