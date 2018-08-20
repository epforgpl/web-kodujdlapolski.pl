<?php
/*
 * Template name: Partnerzy
 */
?>
<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>


<?php get_template_part('breadcrumbs'); ?>

<?php if (have_posts()): ?>
	<?php while (have_posts()): the_post(); ?>

		<div class="row">
			<div class="small-12 columns">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</div>
		</div>
		<div class="row mt25">
			<div class="small-12 medium-9 columns">
				<?php
				$lists = get_field('lists');

				if ($lists):
					foreach ($lists as $list):
						?>
						<h2 class="subtitle2 mb20"><span><?php echo $list['header']; ?></span></h2>
						<?php
						$posts = $list['partners'];
						if ($posts):
							foreach ($posts as $post):
								setup_postdata($post);
								$logo = get_field('logo');
								$url = get_field('url');
								$content = get_the_content();
								?>
								<div class="partner-box">
									<?php if ($url): ?>
										<div class="text-center">
											<a href="<?php echo $url; ?>"><img src="<?php echo $logo['sizes']['medium']; ?>" alt="<?php the_title(); ?>" /></a>
										</div>
										<?php if (empty($content)): ?>
											<h3><a href="<?php echo $url; ?>"><?php the_title(); ?></a></h3>
										<?php endif; ?>
									<?php else: ?>
										<div class="text-center">
											<img src="<?php echo $logo['sizes']['medium']; ?>" />
										</div>
										<?php if (empty($content)): ?>
											<h3><?php the_title(); ?></h3>
										<?php endif; ?>
									<?php endif; ?>
									<div class="content pt15">
										<?php the_content(); ?>
									</div>
								</div>
								<?php
							endforeach;
							wp_reset_postdata();
							?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<div class="small-12 medium-3 columns">
				<?php get_template_part('sidebar'); ?>
			</div>
		</div>


	<?php endwhile; ?>
<?php endif; ?>


<?php get_footer() ?>
