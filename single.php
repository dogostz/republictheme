<?php get_header(); 
	the_post(); ?>
		
	<?php get_template_part( 'fragments/page-heading' ); ?>
	
	<div class="container container-secondary">
		<div class="shell">
			<div class="main">
				<div class="content">
					<div class="container-head">
						<h1><?php the_title(); ?></h1>
					</div>

					<div class="posts-container">
						<div class="post-date">
							<p><em><?php the_time('j F, Y') ?></em> <span>|</span> <?php comments_number( 'Няма коментари', 'Един коментар', '% коментари' ); ?></p>
							<div class="post-socials">
								<div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button" data-action="like" data-show-faces="true" data-share="false"></div>
								<!-- Поставете този маркер там, където искате да се изобразява вашият бутон +1. -->
								<div class="g-plusone" data-size="medium"></div>
							</div>
						</div>

						<?php if ( has_post_thumbnail() ) : ?>

							<div class="post-image">
								<?php the_post_thumbnail( 'large' ); ?>
							</div>

						<?php endif; ?>

						<div class="post">
							<?php the_content(); ?>

							<div class="post-comments">
								<?php comments_template(); ?>
							</div>
						</div><!-- /.post -->
					</div>

				</div>

				<?php get_sidebar(); ?>

			</div>
		</div>
	</div>

<?php get_footer(); ?>