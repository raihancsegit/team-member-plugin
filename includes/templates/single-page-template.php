<?php
get_header();

while ( have_posts() ) :
    the_post();
    // Get the bio of the team member
    $bio = get_post_meta( get_the_ID(), '_team_member_bio', true );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php if ( $bio ) : ?>
        <div class="bio">Bio: <?php echo wp_kses_post( $bio ); ?></div>
        <?php endif; ?>
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php endwhile; ?>

<?php get_footer(); ?>