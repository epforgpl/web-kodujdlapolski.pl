<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>


<div class="row page-single error-404-wrapper">
	<div class="small-12 columns post-content text-center">
		<h1 class="title-404">404</h1>
		<h2 class="subtitle-404"><?php _e('Page not found'); ?></h2>			
		<a href="<?php echo home_url(); ?>" class="btn red"><?php _e('Go to homepage'); ?></a>
	</div>

</div>

<?php get_footer() ?>
