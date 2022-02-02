<?php 

/* Template name: Кариера */

get_header(); 
	the_post();
?>
		
	<?php get_template_part( 'fragments/page-heading' ); ?>
	
	<div class="container container-secondary">
		<div class="shell">
			<div class="main">
				<div class="content">
					<div class="container-head">
						<div class="shell" style="height: 100%; overflow: hidden">
							<h1><?php the_title(); ?></h1>
							<div class="content">
								<!-- <div class="post">
									<?php 
										// echo apply_filters( 'the_content', crb_get_meta( '_career_page_description' ) );
									?>
								</div> -->
								<div class="post">
									<?php the_content(); ?>	
								</div><!-- /.post -->
							</div>
						</div><!-- /.shell -->
					</div>
				</div>

				<?php get_sidebar(); ?>

			</div>
		</div>
	</div>

<?php get_footer(); ?>