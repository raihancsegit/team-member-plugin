<?php 

class Team_members_shortcode {

    private $post_type_name;
    private $url_slug;
    
    public function __construct() {
        add_shortcode( 'team_members', array( $this, 'team_members_shortcode' ) );
        // Retrieve settings
        $options = get_option( 'team_member_settings' );
        $this->post_type_name = isset( $options['post_type_name'] ) ? $options['post_type_name'] : 'Team Member';
        $this->url_slug = isset( $options['url_slug'] ) ? $options['url_slug'] : 'team-member';
    }
    // Shortcode to display team members
    public function team_members_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'number' => -1, // Default to show all team members
            'image_position' => 'top', // Default position of image
            'show_see_all_button' => true, // Default to show the "See all" button
            'paged' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1, // Get current page
        ), $atts );

        $args = array(
            'post_type' => $this->url_slug,
            'posts_per_page' => $atts['number'],
            'paged' => $atts['paged'], // Use current page number
            'tax_query' => array(),
            // 'meta_query'     => array(
            //     array(
            //         'key'   => '_team_member_position',
            //         'value' => $atts['image_position'],
            //     ),
            // ),
        );

        // Add taxonomy term filter if provided
        if ( ! empty( $atts['image_position'] ) ) {
            $args['tax_query'][] = array(
                'taxonomy' => 'member_type',
                'field'    => 'slug',
                'terms'    => $atts['image_position'],
            );
        }

        $team_members_query = new WP_Query( $args );

        $output = '<div class="team-members">';

        if ( $team_members_query->have_posts() ) {
            while ( $team_members_query->have_posts() ) {
                $team_members_query->the_post();

                $bio = get_post_meta( get_the_ID(), '_team_member_bio', true );
                $position = get_post_meta( get_the_ID(), '_team_member_position', true );

                // Check image position and choose template accordingly
                if ($atts['image_position'] === 'bottom') {
                    $output .= '<div class="team-member team-member-bottom">';
                    $output .= '<div class="content">';
                } else {
                    $output .= '<div class="team-member team-member-top">';
                    $output .= '<div class="content">';
                    $output .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail() . '</a>';
                }

                $output .= '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
                $output .= '<div class="position">' . esc_html( $position ) . '</div>';

                if ($atts['image_position'] === 'bottom') {
                    // Display image at the bottom
                    $output .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail() . '</a>';
                }

                $output .= '</div>'; // Close content div
                $output .= '</div>'; // Close team-member div
            }
            wp_reset_postdata();

            // Pagination
            $big = 999999999; // need an unlikely integer
            $output .= '<div class="pagination">';
            $output .= paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, $atts['paged'] ),
                'total' => $team_members_query->max_num_pages,
            ) );
            $output .= '</div>';
        } else {
            $output .= '<p>No team members found</p>';
        }

        $output .= '</div>';

        if ($atts['show_see_all_button']) {
            // Add "See all" button
            $output .= '<div class="see-all-button"><a href="' . get_post_type_archive_link( $this->url_slug ) . '">See all</a></div>';
        }

        return $output;
    }
}
new Team_members_shortcode();