<?php
/*
 * Template name: Miasta
 */
?>

<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>

<?php get_template_part('breadcrumbs'); ?>

<div class="row">
	<?php if (have_posts()): ?>
		<?php while (have_posts()): the_post(); ?>
			<div class="small-12 medium-9 columns post-content">
				<h1 class="page-title text-center large-text-left"><?php the_title(); ?></h1>
				<div class="map show-for-large">
					<img src="<?php echo $src; ?>/images/poland.jpg" />
					<?php
						$args = array(
								'post_type' => 'cities',
								'posts_per_page' => -1,
						);

						$query = new WP_Query($args);
						?>
						<?php if ($query->have_posts()): ?>
							<?php while ($query->have_posts()): $query->the_post(); ?>
								<a href="<?php the_permalink(); ?>" class="pin" style="left:<?php the_field('axis_x'); ?>%;bottom:<?php the_field('axis_y'); ?>%;"><img src="<?php echo $src; ?>/images/pin.png" alt="<?php the_title(); ?>" /></a>
							<?php endwhile; ?>
						<?php endif; ?>
				</div>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>
	<div class="small-12 medium-3 columns post-author">
		<?php get_template_part('sidebar-cities'); ?>
	</div>
</div>

<div class="row mt40">
	<div class="small-12 columns">
		<h3 class="subtitle"><span><?php _e('Blog'); ?></span></h3>
	</div>
</div>
<div class="row post-list mt40">
	<?php
	$args = array(
			'post_type' => 'post',
			'posts_per_page' => 3,
			'cat' => icl_object_id(6,'category')
	);

	$query = new WP_Query($args);
	?>
	<?php if ($query->have_posts()): ?>
		<?php while ($query->have_posts()): $query->the_post(); ?>
			<?php get_template_part('post-on-list'); ?>
		<?php endwhile; ?>
	<?php endif; ?>
	<div class="small-12 columns text-center">
		<a href="<?php echo get_permalink(icl_object_id(17,'page')); ?>" class="btn red"><?php _e('Read all posts'); ?></a>
	</div>
</div>

<?php get_footer() ?>
