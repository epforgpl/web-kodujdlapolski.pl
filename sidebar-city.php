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
<div class="meetings-city show-for-medium">
	<?php
	if (false === ($events = get_transient('facebook-meetings'))):
		$fb = new Facebook\Facebook([
				'app_id' => '155938441448129',
				'app_secret' => '3da9ce4c1422685a66ccc5099f477037',
				'default_graph_version' => 'v2.5',
		]);
		try {
			$response = $fb->get('/KodujDlaPolski/events', '155938441448129|sH7mAZZROgilR_b0XiJjPO0iAUs');
		} catch (Facebook\Exceptions\FacebookResponseException $e) {
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}
		$events = $response->getDecodedBody();
		set_transient('facebook-meetings', $events, 12 * 3600);
	endif;
	$meetings = '';
	$i = 0;
	foreach ($events['data'] as $ev):
		if (in_array($ev['place']['location']['city'],$cities) && strtotime($ev['start_time']) + 3600 > time()) {
			$meetings .= '<div class="overflow mb15"><div class="cal-icon"><img src="' . $src . '/images/calendar-icon.png" /></div><a href="https://www.facebook.com/events/' . $ev['id'] . '">';
			$meetings .= '<span class="date">' . date_i18n('d F', strtotime($ev['start_time']) + 3600) . '</span>'
							. '<span class="name">' . $ev['name']. '</span></a></div>';
			$i++;
			if ($i == 3) {
				break;
			}
		}
	endforeach;
	?>
	<div class="title mb20"><?php _e('Next event'); ?></div>
	<?php if ($meetings): ?>
		<?php echo $meetings; ?>
	<?php else: ?>
		<div class="msg"><?php _e('No meetings in our schedule'); ?></div>
	<?php endif; ?>
</div>

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
