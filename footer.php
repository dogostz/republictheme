	<div class="footer">
		<div class="footer-bar">
			<div class="shell">
					
				<?php
					$args = array(
						'container_class' 	=> false,
						'theme_location' 	=> 'footer-menu',
						'menu_class' 		=> 'footer-nav'
					);
					wp_nav_menu( $args );
				?>

				<a href="#" class="link-top">
					ОБРАТНО ГОРЕ <i class="ico-top-arrow"></i>
				</a>
				
			</div>
		</div>
		
		<div class="footer-inner">
			<div class="shell">
				<ul class="list-contacts">
					<li>
						<i class="ico-footer-mail"></i>
						<span><?php echo get_option( 'crb_main_email' ) ?></span>
					</li>
					
					<li>
						<i class="ico-footer-tel"></i>
						<span>
                            <a class="white-link no-underline" href="tel:<?php echo crb_get_clean_number(get_option( 'crb_phone' )); ?>">
                                <?php echo get_option( 'crb_phone' ) ?>
                            </a>
                        </span>
					</li>
					
					<li>
						<i class="ico-footer-pin"></i>
						<span><?php echo get_option( 'crb_address' ) ?></span>
					</li>
					
					<li>
						<i class="ico-footer-clock"></i>
						<span><?php echo get_option( 'crb_working_hours' ) ?></span>
					</li>
				</ul>
			</div>
		</div>
		
		<div class="footer-content">
			<div class="shell">
				<div class="copyright">
					<a href="#" class="footer-logo"></a>

					<span>
						&copy; REPUBLIC.BG Всички права запазени!
					</span>
				</div>

				<?php get_template_part( 'fragments/socials' ); ?>
			</div>
		</div>
	</div>
	
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/bg_BG/sdk.js#xfbml=1&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<?php wp_footer(); ?>
</body>
</html>