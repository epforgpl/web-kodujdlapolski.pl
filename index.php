<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>


<?php get_template_part('breadcrumbs'); ?>

<div class="row">
	<div class="small-12 columns">
		<h1 class="page-title">Blog</h1>
	</div>
</div>
<div class="row mb30 mt20">
	<div class="small-12 columns blog-city-list">
		<?php
		$ccat = get_query_var('cat');
		?>
		<a href="<?php echo get_permalink(icl_object_id('17', 'page')); ?>" <?php if (empty($ccat)): ?>class="current"<?php endif; ?>><?php _e('All'); ?></a> 
		<?php
		$categories = get_terms('category', array(
				'hide_empty' => 1,
				'parent' => 0
		));
		foreach ($categories as $cat):
			?>
			<a href="<?php echo get_category_link($cat); ?>" <?php if ($ccat == $cat->term_id): ?>class="current"<?php endif; ?>><?php echo $cat->name; ?></a> 
			<?php if ($cat->term_id == icl_object_id('6','category')): ?>
			<?php
				$sub_categories = get_terms('category', array(
						'hide_empty' => 1,
						'parent' => $cat->term_id
				));
				foreach ($sub_categories as $sub_cat): ?>
					<a href="<?php echo get_category_link($sub_cat); ?>" <?php if ($ccat == $sub_cat->term_id): ?>class="current"<?php endif; ?>><?php echo $sub_cat->name; ?></a> 
				<?php endforeach; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</div>
<div class="row post-list">

	<?php if (have_posts()): ?>
		<?php while (have_posts()): the_post(); ?>
			<?php get_template_part('post-on-list'); ?>
		<?php endwhile; ?>
	<?php else: ?>
		<div class="small-12 columns">
			<?php _e('Posts not found'); ?>
		</div>
	<?php endif; ?>
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

<?php get_footer() ?>
