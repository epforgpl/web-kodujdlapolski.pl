<?php
/*
 * Template name: Strona główna
 */
?>
<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>

<?php if (have_posts()): ?>
	<?php while (have_posts()): the_post(); ?>
		<?php
		$img = get_field('main_photo');
		?>
		<div class="row mt20">
			<div class="small-12 columns">
				<div class="main-photo" style="background-image:url(<?php echo $img['sizes']['w100']; ?>);">
					<div class="meetings show-for-large">
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
						$evs = array_reverse($events['data']);
						foreach ($evs as $ev):
							if (strtotime($ev['start_time']) + 3600 > time()) {
								$meetings .= '<div class="overflow mb15"><div class="cal-icon"><i class="icon-calendar"></i></div><a href="https://www.facebook.com/events/' . $ev['id'] . '" class="event-link">';
								$meetings .= '<span class="date">' . date_i18n('d F', strtotime($ev['start_time']) + 3600) . '</span>'
												. '<span class="city">' . get_city_name($ev['place']['location']['city']) . '</span></a></div>';
								$i++;
								if ($i == 3) {
									break;
								}
							}
						endforeach;
						?>
						<div class="title mb20"><?php _e('Upcoming events'); ?></div>
						<?php if ($meetings): ?>
							<?php echo $meetings; ?>
							<div class="text-center">
								<a href="https://www.facebook.com/KodujDlaPolski/events" class="btn border-white" target="_blank"><?php _e('Show all events'); ?></a>
							</div>
						<?php else: ?>
							<div class="msg"><?php _e('No meetings in our schedule'); ?></div>
						<?php endif; ?>
					</div>

					<div class="cont">
						<div class="text">
							<?php the_field('photo_text'); ?>
						</div>
					</div>
				</div>
				<div class="meetings hide-for-large">
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
					$evs = array_reverse($events['data']);
					foreach ($evs as $ev):
						if (strtotime($ev['start_time']) + 3600 > time()) {
							$meetings .= '<div class="overflow mb15"><div class="cal-icon"><i class="icon-calendar"></i></div><a href="https://www.facebook.com/events/' . $ev['id'] . '" class="event-link">';
							$meetings .= '<span class="date">' . date_i18n('d F', strtotime($ev['start_time']) + 3600) . '</span>'
											. '<span class="city">' . get_city_name($ev['place']['location']['city']) . '</span></a></div>';
							$i++;
							if ($i == 3) {
								break;
							}
						}
					endforeach;
					?>
					<div class="title mb20"><?php _e('Upcoming events'); ?></div>
					<?php if ($meetings): ?>
						<?php echo $meetings; ?>
						<div class="text-center">
							<a href="https://www.facebook.com/KodujDlaPolski/events" class="btn border-white" target="_blank"><?php _e('Show all events'); ?></a>
						</div>
					<?php else: ?>
						<div class="msg"><?php _e('No meetings in our schedule'); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="row mt60">
			<div class="small-12 columns">
				<h3 class="subtitle"><span><?php _e('Projects'); ?></span></h3>
			</div>
		</div>

		<div class="row small-up-2 large-up-6 project-list mt40">
			<?php
			$projects = get_field('projects');
			$i = 0;
			$notin = [];
			if ($projects):
				foreach ($projects as $post):
					setup_postdata($post);
					?>
					<?php get_template_part('project-on-list-main'); ?>
					<?php
					$i++;
					$notin[] = get_the_ID();
				endforeach;
				?>
			<?php endif; ?>
			<?php
			$to_rand = 5 - $i;
			if ($to_rand > 0):
				$args = array(
						'post_type' => 'projects',
						'posts_per_page' => $to_rand,
						'post__not_in' => $notin,
						'tax_query' => array(
								array(
										'taxonomy' => 'filters',
										'field' => 'id',
										'terms' => icl_object_id(42, 'filters'),
								),
						),
				);

				$query = new WP_Query($args);
				?>
				<?php if ($query->have_posts()): ?>
					<?php while ($query->have_posts()): $query->the_post(); ?>
						<?php get_template_part('project-on-list-main'); ?>
					<?php endwhile; ?>
				<?php endif; ?>
			<?php endif; ?>
			<div class="column project-box">
				<a href="http://forum.kodujdlapolski.pl/t/jak-dodawac-nowe-pomysly/899" class="add-project">
					<img src="<?php echo $src; ?>/images/add-project-icon.png" class="icon" alt="<?php _e('Share a challenge to solve!'); ?>" />
					<span><?php _e('Share a challenge to solve!'); ?></span>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns text-center">
				<a href="<?php echo get_permalink(icl_object_id(11, 'page')); ?>" class="btn red"><?php _e('Show all projects'); ?></a>
			</div>
		</div>


		<div class="row mt50">
			<div class="small-12 columns">
				<h3 class="subtitle"><span><?php _e('Blog'); ?></span></h3>
			</div>
		</div>

		<div class="row post-list mt40">
			<?php
			$args = array(
					'post_type' => 'post',
					'posts_per_page' => 3,
			);

			$query = new WP_Query($args);
			?>
			<?php if ($query->have_posts()): ?>
				<?php while ($query->have_posts()): $query->the_post(); ?>
					<?php get_template_part('post-on-list'); ?>
				<?php endwhile; ?>
			<?php endif; ?>
			<div class="small-12 columns text-center">
				<a href="<?php echo get_permalink(icl_object_id(17, 'page')); ?>" class="btn red"><?php _e('Read all posts'); ?></a>
			</div>
		</div>

		<div class="row mt50">
			<div class="small-12 columns">
				<h3 class="subtitle"><span><?php _e('Koduj dla Polski'); ?></span></h3>
			</div>
		</div>

		<div class="row mt40 stats-list text-center large-text-left show-for-large">
			<div class="small-12 medium-6 large-3 columns overflow pt15">
				<a href="https://forum.kodujdlapolski.pl/" class="dblock" target="_blank">
					<?php
					if (false === ($users = get_transient('forum-users'))) {
						$json = file_get_contents('https://forum.kodujdlapolski.pl/about.json');
						$obj = json_decode($json);
						$users = $obj->about->stats->user_count;
						set_transient('forum-users', $users, 12 * 3600);
					}
					?>
					<div class="icon">
						<img src="<?php echo $src; ?>/images/stats-forum.png" />
					</div>
					<div class="info">
						<div class="number"><?php echo $users; ?></div>
						<div class="txt"><?php _e('users on the forum'); ?></div>
					</div>
				</a>
			</div>
			<div class="small-12 medium-6 large-3 columns overflow pt15">
				<a href="https://forum.kodujdlapolski.pl/c/pomysly" class="dblock" target="_blank">
					<?php
					if (false === ($ideas = get_transient('ideas'))) {
						$ideas = 0;
						for ($i = 0; $i < 50; $i++) {
							$json = file_get_contents('https://forum.kodujdlapolski.pl/c/pomysly.json?page=' . $i);
							$obj = json_decode($json);
							$cur_page = count($obj->topic_list->topics);
							if ($cur_page == 0) {
								break;
							}
							$ideas += $cur_page;
						}
						set_transient('ideas', $ideas, 12 * 3600);
					}
					?>
					<div class="icon">
						<img src="<?php echo $src; ?>/images/stats-ideas.png" />
					</div>
					<div class="info">
						<div class="number"><?php echo $ideas; ?></div>
						<div class="txt"><?php _e('ideas'); ?></div>
					</div>
				</a>
			</div>
			<div class="small-12 medium-6 large-3 columns overflow pt15">
				<a href="<?php echo get_permalink(icl_object_id(9, 'page')); ?>" class="dblock">
					<?php
					if (false === ($cities = get_transient('cities'))) {
						$args = '';
						$args = array(
								'post_type' => 'cities',
								'posts_per_page' => -1,
								'fields' => 'ids'
						);

						$query = new WP_Query($args);
						$cities = $query->post_count;
						set_transient('cities', $cities, 12 * 3600);
					}
					?>
					<div class="icon">
						<img src="<?php echo $src; ?>/images/stats-citylab.png" />
					</div>
					<div class="info">
						<div class="number"><?php echo $cities ?></div>
						<div class="txt"><?php _e('local groups'); ?></div>
					</div>
				</a>
			</div>
			<?php wp_reset_query(); ?>
			<div class="small-12 medium-6 large-3 columns overflow pt15">
				<a href="<?php echo get_permalink(icl_object_id(11, 'page')); ?>" class="dblock">
					<?php
					if (false === ($projects = get_transient('projects'))) {
						$args = '';
						$args = array(
								'post_type' => 'projects',
								'posts_per_page' => -1,
								'fields' => 'ids'
						);

						$query = new WP_Query($args);
						$projects = $query->post_count;
						set_transient('projects', $projects, 12 * 3600);
					}
					?>
					<div class="icon">
						<img src="<?php echo $src; ?>/images/stats-projects.png" />
					</div>
					<div class="info">
						<div class="number"><?php echo $projects; ?></div>
						<div class="txt"><?php _e('projects'); ?></div>
					</div>
				</a>
				<?php wp_reset_query(); ?>
			</div>
		</div>

		<div class="row boxes mt70" id="dzialaj">
			<?php foreach (get_field('boxes') as $box): ?>
				<div class="small-12 large-4 columns small-pb20 large-pb0">
					<div class="content">
						<div class="photo">
							<a href="<?php echo $box['cta_url']; ?>"><img src="<?php echo $box['photo']['sizes']['large']; ?>" /></a>
						</div>
						<h3><a href="<?php echo $box['cta_url']; ?>"><?php echo $box['title']; ?></a></h3>
						<div class="txt"><?php echo $box['text']; ?></div>
						<a href="<?php echo $box['cta_url']; ?>" class="btn red"><?php echo $box['cta_text']; ?></a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>




	<?php endwhile; ?>
<?php endif; ?>


<?php get_footer() ?>
