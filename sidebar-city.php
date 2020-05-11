<?php $src = get_template_directory_uri(); ?>
<?php
	$fb_cities = get_field('fb_cities');
	if ($fb_cities) {
		$cities = [];
		foreach ($fb_cities as $fb_city) {
			$cities[] = $fb_city['city']; 
		}
	}
?>

<?php
$meetup = get_field('meetup_url');
$facebook = get_field('facebook_url');
?>
<?php if ($meetup): ?>
	<a href="<?php echo $meetup; ?>" class="meetup-box"><div><?php _e('Sign up on Meetup'); ?></div></a>
<?php endif; ?>
<?php if ($facebook): ?>
	<a href="<?php echo $facebook; ?>" class="facebook-box"><div><?php _e('Discuss on Facebook'); ?></div></a>
<?php endif; ?>

<a href="http://forum.kodujdlapolski.pl/t/jak-dodawac-nowe-pomysly/899" class="add-project">
	<img src="<?php echo $src; ?>/images/add-project-icon.png" class="icon" alt="<?php _e('Share a challenge to solve!'); ?>" />
	<span><?php _e('Share a challenge to solve!'); ?></span>
</a>
