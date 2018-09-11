<?php
$src = get_template_directory_uri();
global $success;
?>
<?php if (!is_singular('cities') && !is_singular('projects') && !is_page_template('page-partners.php')): ?>
	<div class="row mt60">
		<div class="small-12 columns">
			<h3 class="subtitle"><span><?php _e('Partners'); ?></span></h3>
		</div>
	</div>
	<div class="row small-up-2 medium-up-5 large-up-5 mt25">
		<?php
		$posts = get_field('partners', 'options');
		if ($posts):
			foreach ($posts as $post):
				setup_postdata($post);
				$logo = get_field('logo');
				$url = get_field('url');
				?>
				<div class="column">
					<div class="partner-wrapper">
						<?php if ($url): ?>
							<a href="<?php echo $url; ?>"><img src="<?php echo $logo['sizes']['medium']; ?>" alt="<?php the_title(); ?>" /></a>
						<?php else: ?>
							<img src="<?php echo $logo['sizes']['medium']; ?>" alt="<?php the_title(); ?>" />
						<?php endif; ?>
					</div>
				</div>
				<?php
			endforeach;
			wp_reset_postdata();
			?>
		<?php endif; ?>
	</div>
	<div class="row mt40 mb80">
		<div class="small-12 columns text-center">
			<a href="<?php echo get_permalink(icl_object_id(13, 'page')); ?>" class="btn red"><?php _e('Show all partners'); ?></a>
		</div>
	</div>
<?php endif; ?>

<footer>
	<div class="row">
		<div class="small-12 columns text-center large-text-left">
			<?php wp_nav_menu(array('theme_location' => 'footer', 'menu_class' => 'footer-menu')); ?>
		</div>
	</div>
</footer>

<div class="reveal tiny" id="mailModal" data-reveal data-options="vOffset: 50;">
	<form role="form" id="form" class="contact-form" action="<?php echo get_permalink(); ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
			<label for="imie"><?php _e('First name'); ?></label>
			<input type="text" id="imie" name="fname" class="required">
    </div>
    <div class="form-group">
			<label for="nazwisko"><?php _e('Last name'); ?></label>
			<input type="text" id="nazwisko" name="lname" class="required">
    </div>
    <div class="form-group">
			<label for="email">Email</label>
			<input type="text" id="email" name="email" class="required">
    </div>
    <div class="form-group">
			<label for="stanowisko"><?php _e('Job'); ?></label>
			<input id="stanowisko" name="job" type="text" class="required">
    </div>
    <div class="form-group">
			<label for="tresc"><?php _e('Message'); ?></label>
			<textarea id="tresc" name="message" class="required"></textarea>
    </div>
    <div class="form-group">
			<label for="file"><?php _e('Attach file'); ?></label>
			<input type="file" id="file" name="file">
    </div>
		<div class="form-group fg2">
			<input name="firstname" type="text" value="" />
			<input name="lastname" type="text" value="" />
		</div>

		<div class="form-group">
			<div id="recaptcha1"></div>
		</div>
    <input type="hidden" value="<?php echo get_the_ID(); ?>" id="pid" name="pid">
    <button type="submit" class="btn red send-form"><?php _e('Send'); ?></button>
	</form>
  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>


<div class="reveal tiny" id="mailModal2" data-reveal data-options="vOffset: 50;">
	<form role="form" id="form" class="contact-form" action="<?php echo get_permalink(); ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
			<label for="imie"><?php _e('First name'); ?></label>
			<input type="text" id="imie" name="fname" class="required">
    </div>
    <div class="form-group">
			<label for="nazwisko"><?php _e('Last name'); ?></label>
			<input type="text" id="nazwisko" name="lname" class="required">
    </div>
    <div class="form-group">
			<label for="email">Email</label>
			<input type="text" id="email" name="email" class="required">
    </div>
    <div class="form-group">
			<label for="tresc"><?php _e('Message'); ?></label>
			<textarea id="tresc" name="message" class="required"></textarea>
    </div>
    <div class="form-group">
			<label for="file"><?php _e('Attach file'); ?></label>
			<input type="file" id="file" name="file">
    </div>

		<div class="form-group">
			<div id="recaptcha2"></div>
		</div>
    <input type="hidden" value="<?php echo get_the_ID(); ?>" id="pid" name="pid">
    <input type="hidden" value="1" name="cc">
    <button type="submit" class="btn red send-form"><?php _e('Send'); ?></button>
	</form>
  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="mobile-overlay text-center">
	<?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'text-center mobile-menu')); ?>
	<?php wp_nav_menu(array('theme_location' => 'primary2', 'menu_class' => 'text-center mobile-menu2')); ?>
</div>

<?php if ($success == 1): ?>

	<div class="reveal tiny" id="successModal" data-reveal data-options="vOffset: 50;">
		<?php _e('Message sent. Copy of it went to your mailbox.'); ?>
		<button class="close-button" data-close aria-label="Close modal" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php elseif ($success == 2): ?>

	<div class="reveal tiny" id="successModal" data-reveal data-options="vOffset: 50;">
		<?php _e('Message not sent.'); ?>
		<button class="close-button" data-close aria-label="Close modal" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php endif; ?>


<?php
wp_footer();
?>

<script>
		$(document).foundation();
		var src = '<?php echo $src; ?>';
</script>

<?php if ($success == 1): ?>
	<script>
		$('#successModal').foundation('open');
	</script>
<?php endif; ?>


</body>
</html>