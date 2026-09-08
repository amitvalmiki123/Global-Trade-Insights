<?php
/**
 * The main template file (blog posts page) — Clazar-style layout.
 *
 * @license GPL 2.0
 */
get_header();

$posts_page = get_option( 'page_for_posts' );
$blog_title = $posts_page ? get_the_title( $posts_page ) : get_bloginfo( 'name' );
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="clz-blog">

				<h1 class="screen-reader-text"><?php echo esc_html( $blog_title ); ?></h1>

				<?php if ( have_posts() ) : ?>

					<?php
					// Only page 1 shows the featured hero (the latest post).
					$clz_show_hero  = ! is_paged();
					$clz_hero_done  = false;
					$clz_grid_open  = false;

					while ( have_posts() ) : the_post();

						// Featured hero (latest post).
						if ( $clz_show_hero && ! $clz_hero_done ) :
							$clz_hero_done = true;
							$clz_show_hero = false;
						?>
						<section class="clz-hero" data-aos="fade-up">
							<div class="clz-hero-body">
								<span class="clz-kicker"><?php echo esc_html( clz_reading_time() ); ?></span>
								<h2 class="clz-hero-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h2>
								<div class="clz-hero-author">
									<?php echo clz_author( 40 ); ?>
									<span class="clz-hero-sep">·</span>
									<span class="clz-hero-date"><?php echo get_the_date(); ?></span>
								</div>
								<p class="clz-hero-excerpt">
									<?php echo esc_html( wp_trim_words( get_the_excerpt(), 30 ) ); ?>
								</p>
								<div class="clz-hero-tags">
									<?php echo clz_categories( 3 ); ?>
								</div>
							</div>
							<a class="clz-hero-media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large', array( 'class' => 'clz-media-img' ) ); ?>
								<?php else : ?>
									<span class="clz-ph" aria-hidden="true"></span>
								<?php endif; ?>
							</a>
						</section>
						<?php
							continue; // this post is already shown as the hero
						endif;

						// Open the grid + filter pills once.
						if ( ! $clz_grid_open ) :
							$clz_grid_open = true;
							$clz_cats = get_categories( array( 'hide_empty' => true, 'orderby' => 'name', 'order' => 'ASC' ) );
						?>
						<?php if ( ! empty( $clz_cats ) ) : ?>
							<nav class="clz-filters" aria-label="<?php esc_attr_e( 'Blog categories', 'siteorigin-corp' ); ?>">
								<a class="clz-filter is-active" href="<?php echo esc_url( $posts_page ? get_permalink( $posts_page ) : home_url( '/' ) ); ?>">All</a>
								<?php foreach ( $clz_cats as $clz_cat ) : ?>
									<a class="clz-filter" href="<?php echo esc_url( get_category_link( $clz_cat->term_id ) ); ?>"><?php echo esc_html( $clz_cat->name ); ?></a>
								<?php endforeach; ?>
							</nav>
						<?php endif; ?>
						<div class="clz-grid">
						<?php endif; ?>

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
								<h3 class="clz-card-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<div class="clz-card-foot">
									<?php echo clz_author( 30 ); ?>
								</div>
								<?php $clz_tags = clz_categories( 2 ); if ( $clz_tags ) : ?>
									<div class="clz-card-tags"><?php echo $clz_tags; ?></div>
								<?php endif; ?>
							</div>
						</article>

					<?php endwhile; ?>

					<?php if ( $clz_grid_open ) : ?>
						</div><!-- .clz-grid -->
					<?php endif; ?>

					<div class="clz-pagination">
						<?php
						the_posts_pagination( array(
							'prev_text' => '&larr; Previous',
							'next_text' => 'Next &rarr;',
						) );
						?>
					</div>

				<?php else : ?>

					<p class="clz-empty"><?php esc_html_e( 'No posts found.', 'siteorigin-corp' ); ?></p>

				<?php endif; ?>

			</div><!-- .clz-blog -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
