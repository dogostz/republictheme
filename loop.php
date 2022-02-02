<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
	
		<div class="post">
			<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			<?php if ( $post->post_type == 'post' ): ?>

				<div class="post-date">
					<p><em><?php the_time('j F, Y') ?></em> <span>|</span> <?php comments_number( 'Няма коментари', 'Един коментар', '% коментари' ); ?></p>
					<div class="post-socials">
						<div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button" data-action="like" data-show-faces="true" data-share="false"></div>
						<!-- Поставете този маркер там, където искате да се изобразява вашият бутон +1. -->
						<div class="g-plusone" data-size="medium"></div>
					</div>
				</div>

			<?php endif ?>

			<?php if ( has_post_thumbnail() ) : ?>

				<div class="post-image">
					<a href="<?php the_permalink() ?>">
						<?php the_post_thumbnail( 'large' ); ?>
					</a>
				</div>

			<?php endif; ?>

			<div class="entry">
				<?php the_excerpt(); ?>

				<div class="post-navigation">
					<ul class="list-arrows">
						<li><a href="<?php the_permalink(); ?>">Прочети</a></li>
					</ul>
				</div>
			</div>
		</div>

	<?php endwhile; ?>

	<?php if (  $wp_query->max_num_pages > 1 ) : ?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries')); ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;')); ?></div>
		</div>
	<?php endif; ?>
	
<?php else : ?>
	<div id="post-0" class="post error404 not-found">
		<h2>Not Found</h2>
		
		<div class="entry">
			<?php  
				if ( is_category() ) { // If this is a category archive
					printf("<p>Sorry, but there aren't any posts in the %s category yet.</p>", single_cat_title('',false));
				} else if ( is_date() ) { // If this is a date archive
					echo("<p>Sorry, but there aren't any posts with this date.</p>");
				} else if ( is_author() ) { // If this is a category archive
					$userdata = get_userdatabylogin(get_query_var('author_name'));
					printf("<p>Sorry, but there aren't any posts by %s yet.</p>", $userdata->display_name);
				} else if ( is_search() ) {
					echo("<p>No posts found. Try a different search?</p>");
				} else {
					echo("<p>No posts found.</p>");
				}
			?>
			<?php get_search_form(); ?>
		</div>
	</div>
<?php endif; ?>