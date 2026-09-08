<?php
/**
 * The template for displaying archive pages — Clazar-style layout.
 *
 * @license GPL 2.0
 */
get_header();

$clz_posts_page   = get_option( 'page_for_posts' );
$clz_current_term = is_category() ? get_queried_object_id() : 0;

if ( is_category() ) {
	$clz_title = single_cat_title( '', false );
} elseif ( is_tag() ) {
	$clz_title = single_tag_title( '', false );
} elseif ( is_author() ) {
	$clz_title = get_the_author();
} else {
	$clz_title = wp_strip_all_tags( get_the_archive_title() );
}
$clz_desc = get_the_archive_description();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="clz-blog">

				<header class="clz-archive-head">
					<h1 class="clz-archive-title"><?php echo esc_html( $clz_title ); ?></h1>
					<?php if ( $clz_desc ) : ?>
						<p class="clz-archive-desc"><?php echo wp_kses_post( $clz_desc ); ?></p>
					<?php endif; ?>
				</header>

				<?php
				$clz_cats = get_categories( array( 'hide_empty' => true, 'orderby' => 'name', 'order' => 'ASC' ) );
				if ( ! empty( $clz_cats ) ) :
				?>
				<nav class="clz-filters" aria-label="<?php esc_attr_e( 'Blog categories', 'siteorigin-corp' ); ?>">
					<a class="clz-filter" href="<?php echo esc_url( $clz_posts_page ? get_permalink( $clz_posts_page ) : home_url( '/' ) ); ?>">All</a>
					<?php foreach ( $clz_cats as $clz_cat ) : ?>
						<a class="clz-filter<?php echo ( $clz_cat->term_id === $clz_current_term ) ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_category_link( $clz_cat->term_id ) ); ?>"><?php echo esc_html( $clz_cat->name ); ?></a>
					<?php endforeach; ?>
				</nav>
				<?php endif; ?>

				<?php if ( have_posts() ) : ?>

					<div class="clz-grid">

						<?php while ( have_posts() ) : the_post(); ?>

							<article <?php post_class( 'clz-card' ); ?> data-aos="fade-up">
								<a class="clz-card-media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'medium_large', array( 'class' => 'clz-media-img', 'loading' => 'lazy' ) ); ?>
									<?php else : ?>
										<span class="clz-ph" aria-hidden="true"></span>
									<?php endif; ?>
								</a>
								<div class="clz-card-body">
									<div class="clz-card-meta">
										<span class="clz-card-date"><?php echo get_the_date(); ?></span>
										<span class="clz-card-dot">·</span>
										<span class="clz-card-read"><?php echo esc_html( clz_reading_time() ); ?></span>
									</div>
									<h2 class="clz-card-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h2>
									<div class="clz-card-foot">
										<?php echo clz_author( 30 ); ?>
									</div>
									<?php $clz_tags = clz_categories( 2 ); if ( $clz_tags ) : ?>
										<div class="clz-card-tags"><?php echo $clz_tags; ?></div>
									<?php endif; ?>
								</div>
							</article>

						<?php endwhile; ?>

					</div><!-- .clz-grid -->

					<div class="clz-pagination">
						<?php
						the_posts_pagination( array(
							'prev_text' => '&larr; Previous',
							'next_text' => 'Next &rarr;',
						) );
						?>
					</div>

				<?php else : ?>

					<?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; ?>

			</div><!-- .clz-blog -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
