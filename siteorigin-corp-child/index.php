<?php
/**
 * The main template file (blog posts page) — Clazar-style layout.
 *
 * @license GPL 2.0
 */
get_header();

$posts_page  = get_option( 'page_for_posts' );
$blog_title  = $posts_page ? get_the_title( $posts_page ) : get_bloginfo( 'name' );
$blog_desc   = $posts_page ? get_the_excerpt( $posts_page ) : '';
$posts_url   = $posts_page ? get_permalink( $posts_page ) : home_url( '/' );
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="clz-blog">

				<?php if ( have_posts() ) : ?>

					<?php
					// Page 1 shows the featured post (latest) as a horizontal card.
					$clz_show_hero = ! is_paged();
					$clz_hero_done = false;
					$clz_grid_open = false;
					?>

					<section class="clz-sechead" data-aos="fade-up">
						<div class="clz-container">
							<div class="clz-sechead-inner">
								<span class="clz-kicker"><?php esc_html_e( 'Blog', 'siteorigin-corp' ); ?></span>
								<h1 class="clz-blog-title"><?php echo esc_html( $blog_title ); ?></h1>
								<?php if ( $blog_desc ) : ?>
									<p class="clz-blog-subtitle"><?php echo esc_html( $blog_desc ); ?></p>
								<?php endif; ?>
							</div>
						</div>
					</section>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php if ( $clz_show_hero && ! $clz_hero_done ) : $clz_hero_done = true; ?>

							<section class="clz-featured-section" data-aos="fade-up">
								<div class="clz-container">
									<article <?php post_class( 'clz-featured' ); ?>>
										<div class="clz-featured-body">
											<span class="clz-featured-read"><?php echo esc_html( clz_reading_time() ); ?></span>
											<h2 class="clz-featured-title">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h2>
											<?php $clz_excerpt = wp_trim_words( get_the_excerpt(), 28 ); if ( $clz_excerpt ) : ?>
												<p class="clz-featured-excerpt"><?php echo esc_html( $clz_excerpt ); ?></p>
											<?php endif; ?>
											<div class="clz-featured-meta">
												<?php echo clz_author( 32 ); ?>
												<span class="clz-post-meta-sep">·</span>
												<span><?php echo get_the_date(); ?></span>
											</div>
										</div>
										<a class="clz-featured-media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
											<?php if ( has_post_thumbnail() ) : ?>
												<?php the_post_thumbnail( 'large' ); ?>
											<?php else : ?>
												<span class="clz-ph" aria-hidden="true"></span>
											<?php endif; ?>
										</a>
									</article>
								</div>
							</section>
							<?php continue; ?>

						<?php endif; ?>

						<?php if ( ! $clz_grid_open ) :
							$clz_grid_open = true;
							$clz_cats = get_categories( array( 'hide_empty' => true, 'orderby' => 'name', 'order' => 'ASC' ) );
						?>

						<section class="clz-cards-section">
							<div class="clz-container">

								<?php if ( ! empty( $clz_cats ) ) : ?>
									<nav class="clz-filters" aria-label="<?php esc_attr_e( 'Blog categories', 'siteorigin-corp' ); ?>">
										<a class="clz-filter is-active" href="<?php echo esc_url( $posts_url ); ?>"><?php esc_html_e( 'All', 'siteorigin-corp' ); ?></a>
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
												<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
											<?php else : ?>
												<span class="clz-ph" aria-hidden="true"></span>
											<?php endif; ?>
										</a>
										<div class="clz-card-body">
											<div class="clz-card-meta">
												<span class="clz-card-date"><?php echo get_the_date(); ?></span>
												<span class="clz-card-read"><?php echo esc_html( clz_reading_time() ); ?></span>
											</div>
											<h3 class="clz-card-title">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h3>
											<div class="clz-card-foot">
												<?php echo clz_author( 24 ); ?>
												<?php $clz_tags = clz_categories( 1 ); if ( $clz_tags ) : ?>
													<div class="clz-card-tags"><?php echo $clz_tags; ?></div>
												<?php endif; ?>
											</div>
										</div>
									</article>

					<?php endwhile; ?>

						<?php if ( $clz_grid_open ) : ?>
								</div><!-- .clz-grid -->

								<div class="clz-pagination">
									<?php
									the_posts_pagination( array(
										'prev_text' => esc_html__( 'Previous', 'siteorigin-corp' ),
										'next_text' => esc_html__( 'View more', 'siteorigin-corp' ),
									) );
									?>
								</div>
							</div><!-- .clz-container -->
						</section><!-- .clz-cards-section -->
						<?php endif; ?>

					<section class="clz-cta" data-aos="fade-up">
						<div class="clz-container">
							<div class="clz-cta-inner">
								<h2 class="clz-cta-title"><?php esc_html_e( 'Get the latest insights in your inbox', 'siteorigin-corp' ); ?></h2>
								<div class="clz-cta-actions">
									<a class="clz-btn clz-btn--orange" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Get started', 'siteorigin-corp' ); ?></a>
									<a class="clz-btn clz-btn--ghost" href="<?php echo esc_url( $posts_url ); ?>"><?php esc_html_e( 'See all articles', 'siteorigin-corp' ); ?></a>
								</div>
							</div>
						</div>
					</section>

				<?php else : ?>

					<section class="clz-cards-section">
						<div class="clz-container">
							<p class="clz-empty"><?php esc_html_e( 'No posts found.', 'siteorigin-corp' ); ?></p>
						</div>
					</section>

				<?php endif; ?>

			</div><!-- .clz-blog -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
