<?php 

/* Template name: Страница с форма */

get_header();
	the_post();
?>

	<?php get_template_part( 'fragments/page-heading' ); ?>
	
	<div class="container container-secondary">
		<div class="shell">
			<div class="main">
				<div class="content">
					<div class="container-head">
						<h1><?php the_title(); ?></h1>
					</div>
	
					<div class="form form-inline">
						<div class="form-head">
							<?php the_content(); ?>
						</div><!-- /.form-head -->

						<?php 
							if ( $form_id = crb_get_meta( '_page_form_id' ) ) {
								crb_render_gform( $form_id, false );
							}
						?>
						
					</div><!-- /.form -->
				</div>
				
				<?php get_sidebar(); ?>

			</div>
		</div>
	</div>

<?php get_footer(); ?>