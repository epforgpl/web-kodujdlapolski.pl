<?php $src = get_template_directory_uri(); ?>

<div class="row project-list">
	<div class="small-12 columns">
		<h2 class="subtitle2 mb20"><span><?php _e('See also'); ?></span></h2>
	</div>
	<?php
	$args = array(
			'post_type' => 'projects',
			'posts_per_page' => 1,
			'orderby' => 'rand',
			'post__not_in' => array(get_the_ID())
	);

	$query = new WP_Query($args);
	?>
	<?php if ($query->have_posts()): ?>
		<?php while ($query->have_posts()): $query->the_post(); ?>
			<?php
			$img = get_field('photo_alt');
			if (!$img) {
				$img = get_field('photo_main');
			}
			?>
			<div class="small-12 columns project-box">
				<a href="<?php the_permalink(); ?>" class="thumb" style="background-image:url(<?php echo $img['sizes']['large']; ?>)"></a>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<div class="excerpt"><?php the_excerpt(); ?></div>
			</div>

		<?php endwhile;
		wp_reset_query();
		?>
<?php endif; ?>
</div>

<a href="http://forum.kodujdlapolski.pl/t/jak-dodawac-nowe-pomysly/899" class="add-project">
	<img src="<?php echo $src; ?>/images/add-project-icon.png" class="icon" />
	<span><?php _e('Got an idea for an app?'); ?><br /><?php _e('Tell us!'); ?></span>
</a>