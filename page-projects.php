<?php
/*
 * Template name: Projekty
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

			<div class="small-12 medium-3 columns projects-filters">
				<div class="show-filters hide-for-medium" data-sectxt="<?php _e('Hide filters -'); ?>"><?php _e('Show filters +'); ?></div>
				<div class="filters">
				<?php
				$terms = get_terms('filters', array('parent' => 0, 'hide_empty' => false));
				foreach ($terms as $term):
					$j = 0;
					?>
					<h3><?php echo $term->name; ?></h3>
					<ul>
						<?php
						$chs = get_terms('filters', array('parent' => $term->term_id, 'hide_empty' => false));
						foreach ($chs as $ch):
							echo '<li><a href="#" data-filter="' . $ch->slug . '" class="filter1 filter">' . $ch->name . '</a></li>';
							?>
						<?php endforeach; ?>
					</ul>
				<?php endforeach; ?>
				</div>
			</div>
			<div class="small-12 medium-9 columns project-list">
				<div class="row pr-list">
					<?php
					$args = array(
							'post_type' => 'projects',
							'posts_per_page' => -1,
					);

					$query = new WP_Query($args);
					?>
					<?php if ($query->have_posts()): ?>
						<?php while ($query->have_posts()): $query->the_post(); ?>
							<?php get_template_part('project-on-list'); ?>
						<?php endwhile; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>


	<?php endwhile; ?>
<?php endif; ?>


<?php get_footer() ?>
