<?php get_header(); ?>
		
	<?php get_template_part( 'fragments/page-heading' ); ?>
	
	<div class="container container-secondary">
		<div class="shell">
			<div class="main">
				<div class="content">
					<div class="container-head">
						<h1><?php echo get_the_title( get_option( 'page_for_posts' ) ); ?></h1>
					</div>

					<div class="posts-container">
						<?php get_template_part( 'loop' ); ?>
					</div>
				</div>

				<?php get_sidebar(); ?>

			</div>
		</div>
	</div>

<?php get_footer(); ?>