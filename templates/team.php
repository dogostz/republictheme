<?php 

/* Template name: Екип */

get_header();
	the_post();
?>

	<?php get_template_part( 'fragments/page-heading' ); ?>
	
	<div class="container container-secondary">
		<div class="main">
			<div class="container-head">
				<div class="shell">
					<h1>Мисия на фирмата</h1>
					<div class="content" style="width: 100%; float: none;">
						<div class="post">
							<?php the_content(); ?>
						</div><!-- /.post -->
					</div>
				</div><!-- /.shell -->

				<div class="shell">
					<h1><?php the_title(); ?></h1>
				</div><!-- /.shell -->
			</div>

			<?php get_template_part( 'fragments/loop-crew' ); ?>
			
		</div>
	</div>

<?php get_footer(); ?>