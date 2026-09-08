<?php
/**
 * The template for displaying all single posts — Clazar-style layout.
 *
 * @license GPL 2.0
 */
get_header();

$clz_posts_page = get_option( 'page_for_posts' );
$clz_back_url   = $clz_posts_page ? get_permalink( $clz_posts_page ) : home_url( '/' );
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="clz-single">

				<?php while ( have_posts() ) : the_post(); ?>

					<a class="clz-back" href="<?php echo esc_url( $clz_back_url ); ?>">&larr; <?php esc_html_e( 'Back to all articles', 'siteorigin-corp' ); ?></a>

					<header class="clz-post-head">
						<?php $clz_tags = clz_categories( 3 ); if ( $clz_tags ) : ?>
							<div class="clz-post-tags"><?php echo $clz_tags; ?></div>
						<?php endif; ?>

						<h1 class="clz-post-title"><?php the_title(); ?></h1>

						<div class="clz-post-meta">
							<?php echo clz_author( 40 ); ?>
							<span class="clz-post-meta-sep">·</span>
							<span class="clz-post-date"><?php echo get_the_date(); ?></span>
							<span class="clz-post-meta-sep">·</span>
							<span class="clz-post-read"><?php echo esc_html( clz_reading_time() ); ?></span>
						</div>
					</header>

					<?php if ( has_post_thumbnail() ) : ?>
						<figure class="clz-post-featured">
							<?php the_post_thumbnail( 'large' ); ?>
						</figure>
					<?php endif; ?>

					<div class="clz-post-content">
						<?php
						the_content();

						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'siteorigin-corp' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						) );
						?>
					</div>

					<?php if ( class_exists( 'Jetpack_Likes' ) ) :
						$custom_likes = new Jetpack_Likes();
						echo $custom_likes->post_likes( '' );
					endif; ?>

					<?php if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'sharedaddy' ) ) :
						echo sharing_display();
					endif; ?>

					<?php if ( siteorigin_setting( 'navigation_post' ) ) :
						siteorigin_corp_the_post_navigation();
					endif; ?>

					<?php if ( siteorigin_setting( 'blog_post_author_box' ) ) :
						siteorigin_corp_author_box();
					endif; ?>

					<?php
					$categories = get_the_category();
					if ( $categories ) :
						$category_ids = array();
						foreach ( $categories as $category ) {
							$category_ids[] = $category->term_id;
						}
						$related_args = array(
							'post_type'      => 'post',
							'posts_per_page' => 3,
							'post__not_in'   => array( get_the_ID() ),
							'category__in'   => $category_ids,
						);
						$related_query = new WP_Query( $related_args );
						if ( $related_query->have_posts() ) :
					?>
						<section class="clz-related">
							<h2 class="clz-related-title"><?php esc_html_e( 'Related articles', 'siteorigin-corp' ); ?></h2>
							<div class="clz-grid clz-grid--related">

								<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
									<article <?php post_class( 'clz-card' ); ?>>
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
										</div>
									</article>
								<?php endwhile; ?>

							</div>
						</section>
					<?php
						endif;
						wp_reset_postdata();
					endif;
					?>

					<?php if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif; ?>

				<?php endwhile; ?>

			</div><!-- .clz-single -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
