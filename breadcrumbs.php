<div class="row">
	<div class="small-12 columns breadcrumbs">
		<a href="<?php echo home_url(); ?>">Koduj dla Polski</a> / 
		<?php if (is_page()): ?>
			<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
		<?php elseif (is_home()): ?>
			<a href="<?php echo get_permalink(icl_object_id(17, 'page')); ?>">Blog</a>
		<?php elseif (is_archive()): ?>
			<?php
			$ccat = get_query_var('cat');
			$category = get_category($ccat);
			?>
			<a href="<?php echo get_permalink(icl_object_id(17, 'page')); ?>">Blog</a> / <a href="<?php echo get_category_link($category); ?>"><?php echo $category->name; ?></a>
			<?php elseif (is_singular('post')): ?>
				<?php
				$ccat = get_query_var('cat');
				$category = get_category($ccat);
				?>
				<a href="<?php echo get_permalink(icl_object_id(17, 'page')); ?>">Blog</a> / <?php the_category(' / '); ?> / <a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a>
			<?php elseif (is_singular('projects')): ?>
				<a href="<?php echo get_permalink(icl_object_id(11, 'page')); ?>"><?php echo get_the_title(icl_object_id(11, 'page')); ?></a> / <a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a>
			<?php elseif (is_singular('cities')): ?>
				<a href="<?php echo get_permalink(icl_object_id(9, 'page')); ?>"><?php echo get_the_title(icl_object_id(9, 'page')); ?></a> / <a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a>
			<?php endif; ?>
	</div>
</div>
