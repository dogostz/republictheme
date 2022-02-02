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

					<div class="post">
						<?php the_content(); ?>
					</div><!-- /.post -->		
				</div>

				<?php get_sidebar(); ?>

			</div>
		</div>
	</div>

<?php get_footer(); ?>