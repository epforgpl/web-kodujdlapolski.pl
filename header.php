<?php
$src = get_template_directory_uri();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<title><?php
			global $page, $paged;

			wp_title('|', true, 'right');

			bloginfo('name');

			$site_description = get_bloginfo('description', 'display');
			if ($site_description && ( is_home() || is_front_page() ))
				echo " | $site_description";
			?></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo $src ?>/css/normalize.css" />
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo $src ?>/css/foundation.min.css" />
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo $src ?>/style.css?v=1.03" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<link rel="icon" href="<?php echo $src ?>/images/favicon.png" type="image/png"/>
		<?php
		if (is_singular() && get_option('thread_comments'))
			wp_enqueue_script('comment-reply');


		wp_head();
		?>


		<meta name="viewport" content="width=device-width" />
	</head>


	<body <?php body_class(); ?> >
		<div id="fb-root"></div>
		<script>(function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id))
					return;
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/pl_PL/sdk.js#xfbml=1&version=v2.5&appId=155938441448129";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
		<header>
			<div class="ep-top">
				<div class="row">
					<div class="small-10 large-6 columns">
						<a href="http://fundament.ngo/" class="fundament"><img src="<?php echo $src; ?>/images/spolecznosc.svg" /></a>
					</div>
					<div class="small-2 large-6 columns text-right">
						<a href="https://www.facebook.com/KodujDlaPolski/" target="_blank"><img src="<?php echo $src; ?>/images/fb-icon.png" /></a>
					</div>
					<div class="small-12 columns show-for-large"><hr /></div>
				</div>
			</div>
			<div class="row">
				<div class="small-5 columns show-for-large">
					<?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'text-center main-menu')); ?>
				</div>
				<div class="small-6 large-2 columns large-text-center">
					<a href="<?php echo home_url(); ?>"><img src="<?php echo $src; ?>/images/logo.png" /></a>
				</div>
				<div class="small-5 columns show-for-large relative">
					<?php wp_nav_menu(array('theme_location' => 'primary2', 'menu_class' => 'text-center main-menu')); ?>
					<div class="lang">
						<?php
						$langs = icl_get_languages('skip_missing=0');
						$j = 0;
						foreach ($langs as $lang):
							?>
							<a href="<?php echo $lang['url']; ?>"<?php if ($lang['active'] == 1): ?> class="lang-active"<?php endif; ?>><?php echo $lang['language_code']; ?></a> <?php if ($j == 0): ?>/<?php endif; ?>
							<?php $j = 1; ?>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="small-6 columns hide-for-large">
					<div class="hamburger">
						<div class="line line1"></div>
						<div class="line line2"></div>
						<div class="line line3"></div>
					</div>
				</div>
			</div>
		</header>