<?php
/**
 * @package Gather
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'module' ); ?>>

	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta entry-header-meta">
				<?php gather_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() ) { ?>
	<figure class="entry-image">
		<a href="<?php the_permalink() ?>" class="thumbnail">
		<?php the_post_thumbnail(); ?>
		</a>
	</figure>
	<?php } ?>

	<div class="entry-content clearfix">
		<?php if ( 'excerpt' == get_theme_mod( 'archive-content', 'excerpt' ) || has_excerpt() ) {
			the_excerpt();
		} else {
			the_content(
				wp_kses_post( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'gather' ) )
			);
		} ?>
		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gather' ),
			'after'  => '</div>',
		) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta entry-footer-meta">
		<?php gather_post_meta(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->