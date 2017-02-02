<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>


<?php get_template_part('breadcrumbs'); ?>

<div class="row post-single">

	<?php if (have_posts()): ?>
		<?php while (have_posts()): the_post(); ?>
			<?php
			$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
			$url = $thumb['0'];
			?>
			<div class="small-12 medium-9 columns post-content pb20">
				<h1><?php the_title(); ?></h1>
				<div class="date"><?php echo get_the_date(); ?> | <?php the_category(', '); ?></div>
			</div>
			<div class="small-12 medium-3 columns">&nbsp;</div>
			<div class="small-12 medium-9 columns post-content">
				<?php if ($url): ?>
					<img src="<?php echo $url; ?>" class="mb40" />
				<?php endif; ?>

				<div class="content text-justify"><?php the_content(); ?></div>
			</div>
			<div class="small-12 medium-3 columns post-author">
				<?php
				$author_id = get_the_author_meta('ID');
				$photo = get_field('photo', 'user_' . $author_id);
				$user_photo = $photo['sizes']['medium'];
				if (!$user_photo) {
					$user_photo = get_avatar_url($author_id, array('size' => 105));
				}
				if (!$user_photo) {
					$user_photo = $src . '/images/blank-person2.jpg';
				}
				?>
				<img src="<?php echo $user_photo; ?>" />
				<h4><?php the_author(); ?></h4>
				<div class="author-description"><?php the_author_meta('description'); ?></div>
				<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="btn red mt15"><?php _e('More from this author'); ?></a>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>
</div>

<div class="row mt40">
	<div class="small-12 columns">
		<h3 class="subtitle"><span><?php _e('See also'); ?></span></h3>
	</div>

</div>

<div class="row post-list mt40">
	<?php
	$args = array(
			'post_type' => 'post',
			'posts_per_page' => 3
	);

	$query = new WP_Query($args);
	?>
	<?php if ($query->have_posts()): ?>
		<?php while ($query->have_posts()): $query->the_post(); ?>
			<?php get_template_part('post-on-list'); ?>
		<?php endwhile; ?>
	<?php endif; ?>
</div>


<?php get_footer() ?>
