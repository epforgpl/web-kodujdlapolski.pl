<div class="text-center large-text-left">
<?php $src = get_template_directory_uri(); ?>
<?php
$args = array(
		'post_type' => 'cities',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC'
);

$query = new WP_Query($args);
?>
<?php if ($query->have_posts()): ?>
	<?php while ($query->have_posts()): $query->the_post(); ?>
		<a href="<?php the_permalink(); ?>" class="city-link"><?php the_title(); ?></a>
	<?php endwhile; ?>
<?php endif; ?>
</div>
<a href="mailto:kontakt@kodujdlapolski.pl?subject=<?php echo urlencode('Chcę organizować spotkania w moim mieście'); ?>" class="add-meetup mt20">
	<span><?php _e('Organize events in your city!'); ?></span>
</a>