<!DOCTYPE html>
<html lang="en-US">

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<!-- <meta name="viewport" content="width=1680"> -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php bloginfo( 'stylesheet_directory'); ?>/images/favicon.ico" />
<!--<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">-->
<!--<script src="https://apis.google.com/js/platform.js" async defer>-->
<!--  {lang: 'bg'}-->
<!--</script>-->

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>

<?php if ( is_singular('property') || is_singular('property-rental') ) : 
	$images = carbon_get_post_meta( get_the_ID(), 'property_images', 'complex' );
	if ( $images ) :
		$image = $images[0]['image'];
?>

	<meta property="og:image" content="<?php echo $image; ?>" />

	<?php endif; ?>
<?php endif; ?>

</head>
<body <?php body_class(); ?>>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5&appId=713354065432574";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<header class="header">
		<div class="shell">
			<a href="<?php echo home_url('/') ?>" class="logo"><?php bloginfo( 'name' ); ?></a>

			<div class="burger">
				<a class="link-menu" data-status="on" href="#">
					МЕНЮ <i class="ico-hamb"></i>
				</a>
			</div>
			<div class="nav-utilities">
				<ul>
					<?php if ( $main_mail = get_option( 'crb_main_email' ) ) : ?>
						
						<li>
							<a href="mailto: <?php echo $main_mail ?>"><i class="ico-mail"></i><?php echo $main_mail; ?></a>
						</li>

					<?php endif; ?>
						
					<?php if ( $phone = get_option( 'crb_main_phone' ) ) : ?>

						<li class="hide-sm">
							<a href="tel:<?php echo crb_get_clean_number($phone); ?>"><i class="ico-phone"></i><?php echo $phone; ?></a>
						</li>

					<?php endif; ?>

					<li class="header-socials">
						<?php get_template_part( 'fragments/socials' ); ?>
					</li>

				</ul>
			</div>
		</div><!-- /.shell -->

		<div class="nav">
			<?php
				$args = array(
					'menu_class' 		=> 'navigation-wrapper',
					'container_class' 	=> 'navigation-wrapper-list',
					'theme_location' 	=> 'main-menu'
				);
				wp_nav_menu( $args );
			?>
		</div>
	</header>