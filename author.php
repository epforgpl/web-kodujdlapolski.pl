<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>

<?php get_template_part('breadcrumbs'); ?>

<div class="row mb40">
	<div class="small-2 columns">
		<?php
		$author_id = get_the_author_meta('ID');
		$display_name = get_the_author_meta('display_name');
		$photo = get_field('photo', 'user_' . $author_id);
		$user_photo = $photo['sizes']['medium'];
		if (!$user_photo) {
			$user_photo = get_avatar_url($author_id, array('size' => 105));
		}
		if (!$user_photo) {
			$user_photo = $src . '/images/blank-person.png';
		}
		?>
		<img src="<?php echo $user_photo; ?>" alt="<?php echo $display_name ?>" />
	</div>
	<div class="small-10 columns">
		<h1 class="page-title author-title"><?php the_author(); ?></h1>
		<?php if (ICL_LANGUAGE_CODE == 'pl'): ?>
			<h2 class="author-function mb20"><?php the_field('function', 'user_' . $author_id); ?></h2>
			<div class="author-description"><?php the_author_meta('description'); ?></div>
		<?php else: ?>
			<h2 class="author-function mb20"><?php the_field('function_en', 'user_' . $author_id); ?></h2>
			<div class="author-description"><?php the_field('description_en', 'user_' . $author_id); ?></div>
		<?php endif; ?>
	</div>
	<div class="small-12 columns"><hr /></div>
</div>

<?php
$per = [];
for ($i = 0; $i < 20; $i++) {
	$per[] = array(
			'key' => 'osoby_' . $i . '_person',
			'value' => $author_id,
			'compare' => '='
	);
}
$args = array(
		'post_type' => 'projects',
		'posts_per_page' => -1,
		'meta_query' => array(
				'relation' => 'OR',
				$per[0],
				$per[1],
				$per[2],
				$per[3],
				$per[4],
				$per[5],
				$per[6],
				$per[7],
				$per[8],
				$per[9],
				$per[10],
				$per[11],
				$per[12],
				$per[13],
				$per[14],
				$per[15],
				$per[16],
				$per[17],
				$per[18],
				$per[19],
		)
);

$query = new WP_Query($args);
$four_in_row = 1;
?>
<?php if ($query->have_posts()): ?>

	<div class="row mb20">
		<div class="small-12 columns">
			<h3 class="section-title"><?php _e('Takes part in projects'); ?></h3>
		</div>
	</div>
	<div class="row project-list">

		<?php while ($query->have_posts()): $query->the_post(); ?>
			<?php get_template_part('project-on-list'); ?>
		<?php endwhile; ?>

	</div>
<?php endif; ?>


<?php if (have_posts()): ?>
	<div class="row mb20">
		<div class="small-12 columns">
			<h3 class="section-title"><?php _e('Posts'); ?></h3>
		</div>
	</div>
	<div class="row post-list">
		<?php while (have_posts()): the_post(); ?>
			<?php get_template_part('post-on-list'); ?>
		<?php endwhile; ?>
	</div>
	<div class="row">
		<div class="small-12 columns">
			<div class="paginate">
				<?php
				global $wp_query;
				$big = 999999999;
				echo paginate_links(array(
						'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
						'format' => '?paged=%#%',
						'current' => max(1, get_query_var('paged')),
						'total' => $wp_query->max_num_pages,
						'prev_text' => '&LT;',
						'next_text' => '&GT;'
				));
				?> 
			</div>
		</div>
	</div>
<?php endif; ?>


<?php get_footer() ?>
