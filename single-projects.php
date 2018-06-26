<?php
if (isset($_POST['g-recaptcha-response'])):

	require_once('recaptcha/autoload.php');
	$recaptcha = new \ReCaptcha\ReCaptcha('6LdZuB8TAAAAADNqj-Iv6YuAdRqJBEzMhJz_ZUmB');
	$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

	if (($resp->isSuccess())) {
		if (!empty($_POST['email']) && empty($_GET['firstname']) && empty($_GET['lastname'])) {
			$file_tmp = $_FILES['file']['tmp_name'];
			$file_name = $_FILES['file']['name'];
			$file_size = $_FILES['file']['size'];

			if (is_uploaded_file($file_tmp)) {
				move_uploaded_file($file_tmp, WP_CONTENT_DIR . "/uploads/$file_name");
				$attachments = array(WP_CONTENT_DIR . '/uploads/' . $file_name);
			}


			$pid = $_POST['pid'];

			$headers = 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= 'From: mailer@kodujdlapolski.pl' . "\r\n" .
							'Reply-To: ' . $_POST['email'] . "\r\n";
			if ($_POST['cc'] == '1') {
				$title = 'Kontakt z koordynatorem';
				$content = 'Imię: ' . $_POST['fname'] . ' ' . $_POST['lname'] .
								'<br>email: ' . $_POST['email'] .
								'<br>projekt: ' . get_the_title($pid) .
								'<br>wiadomość: ' . nl2br($_POST['message']);
			} else {
				$title = 'Zapytanie ze strony';
				$content = 'Imię: ' . $_POST['fname'] . ' ' . $_POST['lname'] .
								'<br>email: ' . $_POST['email'] .
								'<br>praca: ' . $_POST['job'] .
								'<br>projekt: ' . get_the_title($pid) .
								'<br>wiadomość: ' . nl2br($_POST['message']);
			}
			wp_mail($_POST['email'], $title, $content, $headers, $attachments);
			
			$headers .= 'Cc: kontakt@kodujdlapolski.pl';
			wp_mail(get_field('mail', $pid), $title, $content, $headers, $attachments);
			
			
			
			//wp_mail('piotr@kliks.eu', $title, $content, $headers, $attachments);
			unlink($attachments[0]);

			$success = 1;
		}
	} else {
		$success = 2;
	}
endif;
?>

<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>


<?php get_template_part('breadcrumbs'); ?>

<div class="row project-single">

	<?php if (have_posts()): ?>
		<?php while (have_posts()): the_post(); ?>
			<?php
			$img = get_field('photo_main');
			?>


			<div class="small-12 medium-9 columns post-content">
				<h1><?php the_title(); ?></h1>
				<img src="<?php echo $img['sizes']['large']; ?>" class="mb40" />
				<div class="row">
					<div class="small-12 medium-9 columns">
						<div class="content text-justify">
							<?php the_content(); ?>
							<?php
							$topics = wp_get_post_terms(get_the_ID(), 'filters');
							$ret = '';
							foreach ($topics as $topic):
								if ($topic->parent != icl_object_id(84, 'filters', true)) {
									$ret[$topic->parent] .= $topic->name . ', ';
								}
							endforeach;
							?>
							<div class="mt20 mb20">
								<strong><?php _e('Project page updated') ?>:</strong> <?php echo get_the_modified_date(); ?><br />
								<?php foreach ($ret as $key => $r): ?>
									<strong><?php
										$t = get_term($key, 'filters');
										echo $t->name;
										?>:</strong> <?php echo rtrim($r, ', '); ?><br />
								<?php endforeach; ?>
							</div>
							<?php
							$coordinator = get_field('btn_name');
							?>
							<div class="text-center mt20 mb30">
								<a data-open="mailModal2" class="btn red bigger">
									<?php
									if ($coordinator) {
										printf(__('Contact %s - project coordinator'), $coordinator);
									} else {
										_e('Contact coordinator');
									}
									?>
								</a>
							</div>

							<ul class="project-links">
								<?php
								$links = get_field('links');

								if ($links):
									foreach ($links as $link):
										?>
										<li>

											<?php if ($link['embed'] == true): ?>
												<?php if (strstr($link['url'], 'facebook')): ?>
													<div class="fb-page" data-href="<?php echo $link['url']; ?>" data-tabs="timeline" data-width="500" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?php echo $link['url']; ?>"><a href="<?php echo $link['url']; ?>"><?php echo $link['name']; ?></a></blockquote></div></div>
												<?php elseif (strstr($link['url'], 'slideshare.net')): ?>
													<?php echo wp_oembed_get($link['url']); ?>
												<?php elseif (strstr($link['url'], 'youtube')): ?>
													<?php echo wp_oembed_get($link['url']); ?>
												<?php elseif (strstr($link['url'], 'forum.koduj')): ?>
													<div class="show-for-large">
														<div class="embed-wrapper">
															<a href="<?php echo $link['url']; ?>/" class="btn red embed-link" target="_blank"><?php echo $link['name']; ?></a>
															<div id="discourse-comments"></div>
															<script type="text/javascript">
																var discourseUrl = "https://forum.kodujdlapolski.pl/";
																function showDiscourseTopic(topic) {
																	var comments = document.getElementById('discourse-comments');
																	var iframe = document.getElementById('discourse-embed-frame');
																	if (iframe) {
																		iframe.remove();
																	}
																	iframe = document.createElement('iframe');
																	iframe.src = '<?php echo $link['url']; ?>';
																	iframe.id = 'discourse-embed-frame';
																	iframe.width = '100%';
																	iframe.height = '500px';
																	iframe.frameBorder = '0';
																	iframe.scrolling = 'yes';
																	comments.appendChild(iframe);
																}
																;
																showDiscourseTopic('');
															</script>
															<div class="text-right">
															<a href="<?php echo $link['url']; ?>" target="_blank">Otwórz forum w nowym oknie &GT; </a>
															</div>
														</div>
													</div>
													<div class="hide-for-large">
														<a href="<?php echo $link['url']; ?>"><?php echo $link['name']; ?> &GT; </a>
													</div>
												<?php elseif (strstr($link['url'], 'docs.google')): ?>
													<?php
													$url = str_replace('/edit', '/embed', $link['url']);
													if (!strstr($url, 'embed')) {
														$url .= '/embed';
													}
													?>
													<iframe src="<?php echo $url; ?>?start=false&loop=false&delayms=10000" frameborder="0" width="480" height="375" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
												<?php elseif (strstr($link['url'], 'github')): ?>
													<div class="embed-wrapper">
														<?php
														$ar = explode('/', $link['url']);
														?>
														<a href="<?php echo $link['url']; ?>/" class="btn red embed-link" target="_blank"><?php _e('Github'); ?> - <?php echo $ar[4]; ?></a>
														<h3>GitHub: <?php echo $ar[3] . ' / ' . $ar[4]; ?></h3>
														<?php
														if (false === ($git_langs = get_transient('github_languages_' . $ar[3] . '_' . $ar[4]))):
															$ch = curl_init('https://api.github.com/repos/' . $ar[3] . '/' . $ar[4] . '/languages');
															curl_setopt($ch, CURLOPT_HEADER, 0);
															curl_setopt($ch, CURLOPT_USERAGENT, 'KdP');
															curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
															$git_langs = curl_exec($ch);
															curl_close($ch);
															set_transient('github_languages_' . $ar[3] . '_' . $ar[4], $git_langs, 12 * 3600);
														endif;

														$obj = json_decode($git_langs);
														$i = 0;
														$sum = 0;
														foreach ($obj as $key => $o) {
															$sum += $o;
															$i++;
														}
														$j = 0;
														?>
														<div class="row large-up-<?php echo $i; ?> languages">
															<?php foreach ($obj as $key => $o): ?>
																<div class="column"><?php /* <div class="color-dot" style="background:#<?php echo $j * 2; ?>1<?php echo $j; ?>1<?php echo $j; ?><?php echo $j; ?>;"></div> */ ?><?php echo $key; ?> <span><?php echo round($o / $sum * 100, 2); ?>%</span></div>
																<?php
																$j++;
															endforeach;
															?>
														</div>
														<?php
														if (false === ($git_issues = get_transient('tmp_github_issues_' . $ar[3] . '_' . $ar[4]))):
															$ch = curl_init('https://api.github.com/repos/' . $ar[3] . '/' . $ar[4] . '/issues');
															curl_setopt($ch, CURLOPT_HEADER, 0);
															curl_setopt($ch, CURLOPT_USERAGENT, 'KdP');
															curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
															$git_issues = curl_exec($ch);
															curl_close($ch);
															set_transient('tmp_github_issues_' . $ar[3] . '_' . $ar[4], $git_issues, 12 * 3600);
														endif;

														$obj = json_decode($git_issues);

														$b = 0;
														if ($obj):
															?>
															<div class="issues-wrapper mt20 mb20">
																<div class="title-row"><a href="<?php echo $link['url']; ?>/issues/" target="_blank"><?php _e('Issues from GitHub'); ?></a></div>
																<?php foreach ($obj as $o): ?>
																	<?php //print_r($o);   ?>
																	<div class="issue-row">
																		<div class="title-col">
																			<a href="<?php echo $o->url; ?>" target="_blank"><?php echo $o->title; ?></a>
																			<div class="meta-data">#<?php echo $o->number; ?> <?php _e('opened on'); ?> <?php echo date_i18n('d M Y', strtotime($o->created_at)); ?> <?php _e('by'); ?> <?php echo $o->user->login; ?> <?php _e('updated on'); ?> <?php echo date_i18n('d M Y', strtotime($o->updated_at)); ?></div>
																		</div>
																		<div class="assignee-col">
																			<?php
																			if ($o->assignee->gravatar_id) {
																				$av = $o->assignee->gravatar_id;
																			} else {
																				$av = $o->assignee->avatar_url;
																			}
																			if ($av):
																				?>
																				<img src="<?php echo $av; ?>" />
																			<?php else: ?>
																				&nbsp;
																			<?php endif; ?>
																		</div>
																		<div class="comments-col">
																			<i class="fa fa-comment-o"></i> <?php echo $o->comments; ?>
																		</div>
																	</div>

																	<?php
																	if ($b == 2) {
																		break;
																	}
																	?>
																	<?php
																	$b++;
																endforeach;
																?>
																<a href="<?php echo $link['url']; ?>/issues/" class="sm-link" target="_blank"><?php _e('See more'); ?> <i class="fa fa-angle-right"></i></a>
															</div>



															<?php
															if (false === ($git_commits = get_transient('github_commits_' . $ar[3] . '_' . $ar[4]))):
																$ch = curl_init('https://api.github.com/repos/' . $ar[3] . '/' . $ar[4] . '/commits');
																curl_setopt($ch, CURLOPT_HEADER, 0);
																curl_setopt($ch, CURLOPT_USERAGENT, 'KdP');
																curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
																$git_commits = curl_exec($ch);
																curl_close($ch);
																set_transient('github_commits_' . $ar[3] . '_' . $ar[4], $git_commits, 12 * 3600);
															endif;

															$obj = json_decode($git_commits);

															$b = 0;
															if ($obj):
																?>
																<div class="issues-wrapper mt20 mb20">
																	<div class="title-row"><a href="<?php echo $link['url']; ?>/commits/" target="_blank"><?php _e('Commits from GitHub'); ?></a></div>
																	<?php foreach ($obj as $o): ?>
																		<div class="issue-row">
																			<div class="title-col">
																				<a href="<?php echo $o->html_url; ?>" target="_blank"><?php echo $o->commit->message; ?></a>
																				<div class="meta-data"><?php echo date_i18n('d M Y', strtotime($o->commit->committer->date)); ?> <?php _e('by'); ?> <?php echo $o->commit->committer->name; ?></div>
																			</div>
																			<div class="assignee-col">
																				<?php
																				if ($o->committer->gravatar_id) {
																					$av = $o->committer->gravatar_id;
																				} else {
																					$av = $o->committer->avatar_url;
																				}
																				if ($av):
																					?>
																					<img src="<?php echo $av; ?>" />
																				<?php else: ?>
																					&nbsp;
																				<?php endif; ?>
																			</div>
																		</div>

																		<?php
																		if ($b == 2) {
																			break;
																		}
																		?>
																		<?php
																		$b++;
																	endforeach;
																	?>
																	<a href="<?php echo $link['url']; ?>/commits/" class="sm-link" target="_blank"><?php _e('See more'); ?> <i class="fa fa-angle-right"></i></a>	
																</div>
															<?php endif; ?>
														<?php endif; ?>
													</div>
												<?php else: ?>
													<a href="<?php echo $link['url']; ?>" class="btn red"><?php echo $link['name']; ?> &GT; </a>
												<?php
												endif;
												?>
											<?php else: ?>
												<a href="<?php echo $link['url']; ?>" class="btn red"><?php echo $link['name']; ?> &GT; </a>
											<?php endif; ?>
										</li>
									<?php endforeach; ?>
								<?php endif; ?>
							</ul>
						</div>
					</div>



					<div class="small-12 medium-3 columns team-list">
						<?php
						$team = get_field('osoby');
						if ($team):
							?>
							<h3><?php _e('Team'); ?></h3>
							<table>
								<?php foreach ($team as $member): ?>
									<?php if ($member['person']['ID']): ?>
										<tr>
											<td class="photo">
												<?php
												//$photo = get_field('photo', 'user_' . $member['person']['ID']);
												$photo = get_field('photo', 'user_' . $member['person']['ID']);
												$user_photo = $photo['sizes']['thumbnail'];
												if (!$user_photo) {
													$user_photo = get_avatar_url($member['person']['ID'], array('size' => 105));
												}
												if (!$user_photo) {
													$user_photo = $src . '/images/blank-person2.jpg';
												}
												?>
												<a href="<?php echo get_author_posts_url($member['person']['ID']); ?>"><img src="<?php echo $user_photo; ?>" alt="<?php echo $member['person']['display_name'] ?>" /></a>
											</td>
											<td class="desc">
												<h4><a href="<?php echo get_author_posts_url($member['person']['ID']); ?>"><?php echo $member['person']['display_name'] ?></a></h4>
												<div class="function"><?php echo $member['function']; ?></div>
											</td>
										</tr>
									<?php else: ?>
										<?php /*
										  <tr>
										  <td class="photo">
										  <a href="#" class="contact"><img src="<?php echo $src; ?>/images/blank-person.jpg" /></a>
										  </td>
										  <td class="desc">
										  <a class="contact open-contact" data-open="mailModal" data-job="<?php echo $member['function']; ?>">Dołącz jako<br /><?php echo $member['function']; ?></a>
										  </td>
										  </tr> */ ?>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
							<?php
							$terms = get_the_terms(get_the_ID(), 'filters');
							if ($terms && !is_wp_error($terms)) :

								foreach ($terms as $term) {
									if ($term->parent == icl_object_id(84, 'filters', true)) {
										?>
										<tr>
											<td class="photo">
												<a data-open="mailModal" data-job="<?php echo $term->name; ?>" class="contact"><img src="<?php echo $src; ?>/images/blank-person.jpg" /></a>
											</td>
											<td class="desc">
												<a class="contact open-contact" data-open="mailModal" data-job="<?php echo $term->name; ?>"><?php _e('Join as'); ?><br /><?php echo $term->name; ?></a>
											</td>
										</tr> 
										<?php
									}
								}
							endif;
							?>
						</table>
					</div>
				</div>
				<?php if (get_field('partners_template') == 'lista'): ?>
					<?php
					$posts = get_field('partners');
					if ($posts):
						?>
						<h3 class="section-title"><?php _e('Partners'); ?></h3>
						<?php
						foreach ($posts as $post):
							setup_postdata($post);
							$logo = get_field('logo');
							$url = get_field('url');
							$content = get_the_content();
							?>
							<div class="partner-box">
								<?php if ($url): ?>
									<div class="text-center">
										<a href="<?php echo $url; ?>"><img src="<?php echo $logo['sizes']['medium']; ?>" /></a>
									</div>
									<?php if (empty($content)): ?>
										<h3><a href="<?php echo $url; ?>"><?php the_title(); ?></a></h3>
									<?php endif; ?>
								<?php else: ?>
									<div class="text-center">
										<img src="<?php echo $logo['sizes']['medium']; ?>" />
									</div>
									<?php if (empty($content)): ?>
										<h3><?php the_title(); ?></h3>
									<?php endif; ?>
								<?php endif; ?>
								<div class="content">
									<?php the_content(); ?>
								</div>
							</div>
							<?php
						endforeach;
						wp_reset_postdata();
						?>
					<?php endif; ?>
				<?php endif; ?>

				<?php
				$github_owner = get_field('github_owner');
				$github_name = get_field('github_name');

				if ($github_name && $github_owner && false):
					?>
					<h3 class="section-title"><?php _e('Languages used'); ?></h3>
					<?php
					if (false === ($github_lang = get_transient('github_languages_' . $github_owner . '_' . $github_name))):

						set_transient('github_' . $github_owner . '_' . $github_name, $github_lang, 12 * 3600);
					endif;

					$client = new GitHubClient();
					$client->setPage();
					$client->setPageSize(2);
					$issues = $client->issues->listIssues($github_owner, $github_name);

					echo "Count: " . count($commits) . "\n";
					foreach ($commits as $commit) {
						/* @var $commit GitHubCommit */
						echo get_class($commit) . " - Sha: " . $commit->getSha() . "\n";
					}

					$commits = $client->getNextPage();

					echo "Count: " . count($commits) . "\n";
					foreach ($commits as $commit) {
						/* @var $commit GitHubCommit */
						echo get_class($commit) . " - Sha: " . $commit->getSha() . "\n";
					}

					//echo 'https://api.github.com/repos/'.$github_owner.'/'.$github_name.'/languages';
					print_r($json);
					$obj = json_decode($json);
					print_r($obj);
					?>
				<?php endif; ?>
			</div>
			<div class="small-12 medium-3 columns post-author">
				<?php get_template_part('sidebar'); ?>
			</div>
			<?php if (get_field('partners_template') == 'logo'): ?>
				<div class="small-12 columns mb50">
					<?php
					$posts = get_field('partners');
					if ($posts):
						?>

						<h3 class="section-title"><?php _e('Partners'); ?></h3>
						<div class="row small-up-2 medium-up-4 large-up-6 mt25">
							<?php
							foreach ($posts as $post):
								setup_postdata($post);
								$title = get_the_title();
								$logo = get_field('logo');
								$url = get_field('url');
								?>
								<div class="column">
									<div class="partner-wrapper text-center">
										<?php if ($url): ?>
											<a href="<?php echo $url; ?>"><img src="<?php echo $logo['sizes']['medium']; ?>" alt="<?php echo $title ?>" /></a>
										<?php else: ?>
											<img src="<?php echo $logo['sizes']['medium']; ?>" alt="<?php echo $title ?>" />
										<?php endif; ?>
									</div>
								</div>
								<?php
							endforeach;
							wp_reset_postdata();
							?>

						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endwhile; ?>
	<?php endif; ?>
</div>


<?php get_footer() ?>
