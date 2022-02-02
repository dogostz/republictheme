<?php get_header(); ?>
		
	<?php get_template_part( 'fragments/page-heading' ); ?>
	
	<div class="container container-secondary">
		<div class="shell">
			<div class="main">
				<div class="content">
					<div class="container-head">
						<h1>Грешка 404 - Страницата не беше намерена</h1>
					</div>

					<div class="post">
						<p>
							<strong>Търсената от Вас страница е преместена или вече не съществува. <br /> За да стигнете до началната страница, моля натиснете <a href="<?php  bloginfo( 'home' ); ?>">тук</a>.</strong>
						</p>
					</div><!-- /.post -->
				</div>

				<?php get_sidebar(); ?>

			</div>
		</div>
	</div>

<?php get_footer(); ?>