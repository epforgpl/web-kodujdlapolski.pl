<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>


<?php get_template_part('breadcrumbs'); ?>

<div class="row page-single">

	<?php if (have_posts()): ?>
		<?php while (have_posts()): the_post(); ?>
			<div class="small-12 medium-9 columns post-content">
				<h1 class="page-title"><?php the_title(); ?></h1>
				<div class="content"><?php the_content(); ?></div>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>

	<div class="small-12 medium-3 columns post-author">
		<?php get_template_part('sidebar'); ?>
	</div>
</div>

<?php get_footer() ?>
