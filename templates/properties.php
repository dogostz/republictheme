<?php 

/* Template name: Списък с имоти */

get_header();
	the_post();
?>

	<?php get_template_part( 'fragments/page-heading' ); ?>

	<div class="container container-secondary">
		<div class="shell">
			<div class="main">
				
				<div class="content content-tertiary">
					<?php get_template_part( 'fragments/loop-properties' ); ?>
				</div>
				
				<div class="sidebar sidebar-tertiary">
					<ul class="widgets">
						<li class="widget widget-search">
							<div class="widget-head">
								<h2>
									<span>Търсене на Имот</span>
								</h2>
							</div>

							<?php get_template_part( 'fragments/properties-filter' ) ?>

						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>