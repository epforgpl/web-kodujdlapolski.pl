<?php
require_once('engine/main.php');
require_once('recaptcha/autoload.php');

add_theme_support('post-thumbnails');

//add_image_size( 'homepage-standard', 200, 0, true );

add_image_size('w100', 1200, 0, true);

register_nav_menu('primary', 'Menu 1');
register_nav_menu('primary2', 'Menu 2');
register_nav_menu('footer', 'Menu stopka');


engine_register_partners_type('Partnerzy', 'partners', array('title', 'editor'), true);
engine_register_project_type('Projekty', 'projects', array('title', 'editor', 'author'), true);
engine_register_post_type('Spotkania', 'cities', array('title', 'editor'), true);

engine_register_taxonomy('Filtry', 'filters', array('projects'));

show_admin_bar(false);


if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
			'page_title' => 'Ogólne',
			'menu_title' => 'Ogólne',
			'menu_slug' => 'theme-general-settings',
			'capability' => 'edit_users',
			'redirect' => false
	));
}

function get_city_name($city) {

	$cities = array(
			'Poznan' => 'Poznań',
			'Srodmiescie' => 'Warszawa',
			'Gdansk' => 'Trójmiasto',
			'Gdynia' => 'Trójmiasto',
			'Sopot' => 'Trójmiasto',
			'Wroclaw' => 'Wrocław'
	);

	if (array_key_exists($city, $cities)) {
		return $cities[$city];
	} else {
		return $city;
	}
}

function add_roles_kdp() {
	add_role('project-leader', 'Project leader', array('read' => true, 'level_0' => false, 'level_1' => true));

	$role = get_role('project-leader');
	$role->add_cap('level_1');
}

add_action('admin_init', 'add_roles_kdp');


add_filter('authenticate', function($user, $email, $password) {

	//Check for empty fields
	if (empty($email) || empty($password)) {
		//create new error object and add errors to it.
		$error = new WP_Error();

		if (empty($email)) { //No email
			$error->add('empty_username', __('<strong>ERROR</strong>: Email field is empty.'));
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //Invalid Email
			$error->add('invalid_username', __('<strong>ERROR</strong>: Email is invalid.'));
		}

		if (empty($password)) { //No password
			$error->add('empty_password', __('<strong>ERROR</strong>: Password field is empty.'));
		}

		return $error;
	}

	//Check if user exists in WordPress database
	$user = get_user_by('email', $email);

	//bad email
	if (!$user) {
		$error = new WP_Error();
		$error->add('invalid', 'Błędny e-mail lub hasło');
		return $error;
	} else { //check password
		if (!wp_check_password($password, $user->user_pass, $user->ID)) { //bad password
			$error = new WP_Error();
			$error->add('invalid', 'Błędny e-mail lub hasło');
			return $error;
		} else {
			return $user; //passed
		}
	}
}, 20, 3);

function login_function() {
	add_filter('gettext', 'username_change', 20, 3);

	function username_change($translated_text, $text, $domain) {
		if ($text === 'Username') {
			$translated_text = 'E-mail';
		}
		return $translated_text;
	}

}

add_action('login_head', 'login_function');


add_filter('avatar_defaults', 'newgravatar');

function newgravatar($avatar_defaults) {
	$myavatar = 'http://kodujdlapolski.pl/wp-content/themes/kdp/images/blank-person.png';
	$avatar_defaults[$myavatar] = "KDP blank 2";
	return $avatar_defaults;
}

add_filter('map_meta_cap', 'my_map_meta_cap', 10, 4);

function my_map_meta_cap($caps, $cap, $user_id, $args) {

	if ('edit_project' == $cap || 'delete_project' == $cap || 'read_project' == $cap) {
		$post = get_post($args[0]);
		$post_type = get_post_type_object($post->post_type);

		$caps = array();
	}

	if ('edit_project' == $cap) {
		if ($user_id == $post->post_author)
			$caps[] = $post_type->cap->edit_posts;
		else
			$caps[] = $post_type->cap->edit_others_posts;
	}

	elseif ('delete_project' == $cap) {
		if ($user_id == $post->post_author)
			$caps[] = $post_type->cap->delete_posts;
		else
			$caps[] = $post_type->cap->delete_others_posts;
	}

	elseif ('read_project' == $cap) {

		if ('private' != $post->post_status)
			$caps[] = 'read';
		elseif ($user_id == $post->post_author)
			$caps[] = 'read';
		else
			$caps[] = $post_type->cap->read_private_posts;
	}

	if ('edit_post2' == $cap || 'delete_post2' == $cap || 'read_post2' == $cap) {
		$post = get_post($args[0]);
		$post_type = get_post_type_object($post->post_type);

		$caps = array();
	}

	if ('edit_post2' == $cap) {
		if ($user_id == $post->post_author)
			$caps[] = $post_type->cap->edit_posts;
		else
			$caps[] = $post_type->cap->edit_others_posts;
	}

	elseif ('delete_post2' == $cap) {
		if ($user_id == $post->post_author)
			$caps[] = $post_type->cap->delete_posts;
		else
			$caps[] = $post_type->cap->delete_others_posts;
	}

	elseif ('read_post2' == $cap) {

		if ('private' != $post->post_status)
			$caps[] = 'read';
		elseif ($user_id == $post->post_author)
			$caps[] = 'read';
		else
			$caps[] = $post_type->cap->read_private_posts;
	}

	if ('edit_partner' == $cap || 'delete_partner' == $cap || 'read_partner' == $cap) {
		$post = get_post($args[0]);
		$post_type = get_post_type_object($post->post_type);

		$caps = array();
	}

	if ('edit_partner' == $cap) {
		if ($user_id == $post->post_author)
			$caps[] = $post_type->cap->edit_posts;
		else
			$caps[] = $post_type->cap->edit_others_posts;
	}

	elseif ('delete_partner' == $cap) {
		if ($user_id == $post->post_author)
			$caps[] = $post_type->cap->delete_posts;
		else
			$caps[] = $post_type->cap->delete_others_posts;
	}

	elseif ('read_partner' == $cap) {

		if ('private' != $post->post_status)
			$caps[] = 'read';
		elseif ($user_id == $post->post_author)
			$caps[] = 'read';
		else
			$caps[] = $post_type->cap->read_private_posts;
	}

	return $caps;
}

function add_oembed_slideshare() {
	wp_oembed_add_provider('http://www.slideshare.net/*', 'http://api.embed.ly/v1/api/oembed');
}

add_action('init', 'add_oembed_slideshare');




add_action('register_form', 'kdp_add_registration_fields');

function kdp_add_registration_fields() {

	$first_name = ( isset($_POST['first_name']) ) ? $_POST['first_name'] : '';
	$last_name = ( isset($_POST['last_name']) ) ? $_POST['last_name'] : '';
	?>

	<p>
		<label for="first_name">Imię<br />
			<input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr(stripslashes($first_name)); ?>" size="25" /></label>
	</p>
	<p>
		<label for="last_name">Nazwisko<br />
			<input type="text" name="last_name" id="last_name" class="input" value="<?php echo esc_attr(stripslashes($last_name)); ?>" size="25" /></label>
	</p>

	<?php
}

add_filter('registration_errors', function($wp_error, $sanitized_user_login, $user_email) {
	if (isset($wp_error->errors['empty_username'])) {
		unset($wp_error->errors['empty_username']);
	}

	if (isset($wp_error->errors['username_exists'])) {
		unset($wp_error->errors['username_exists']);
	}
	return $wp_error;
}, 10, 3);

add_action('login_form_register', function() {
	if (isset($_POST['user_login']) && isset($_POST['user_email']) && !empty($_POST['user_email'])) {
		$_POST['user_login'] = str_replace(array('@', '.', '+'), '_', $_POST['user_email']);
	}
});


add_action('user_register', 'kdp_registration_save', 10, 1);

function kdp_registration_save($user_id) {
	if (isset($_POST['first_name'])) {
		update_user_meta($user_id, 'first_name', $_POST['first_name']);
	}
	if (isset($_POST['last_name'])) {
		update_user_meta($user_id, 'last_name', $_POST['last_name']);
	}
}

add_action('login_head', function() {
	?>
	<style>
		#registerform > p:first-child, #registerform .acf-field{
			display:none;
		}
		#registerform .acf-field-image {
			display:block;
		}
	</style>
	<?php
});

add_filter( 'xmlrpc_methods', 'remove_xmlrpc_pingback_ping' );
function remove_xmlrpc_pingback_ping( $methods ) {
	unset( $methods['pingback.ping'] );
	return $methods;
};

remove_action('wp_head', 'wp_generator');

function default_filter_customizer_register( $wp_customize ) {
	
	$wp_customize->add_setting( 'default_filter', array() );
	
	
	$wp_customize->add_section( 'default_filter_section', array(
		'title'		=> __( 'Default filter' ),
		'priority'	=> 30,
	) );
	
	$json = array();

	$terms = get_terms( array(
		'taxonomy' => 'filters',
		'hide_empty' => false
	) );

	foreach ( $terms as $term ) {
		$json[ $term->slug ] = $term->name;
	}
	
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'default_filter', array(
				'label'			=> __( 'Choose default filter on projects page' ),
				'section'		=> 'default_filter_section',
				'settings'		=> 'default_filter',
				'type'			=> 'select',
				'choices'		=> $json
			)
		)
	);

}

add_action( 'customize_register', 'default_filter_customizer_register' );


function enqueue_scripts_and_styles() {

	wp_enqueue_style( 'icomoon', get_template_directory_uri() . '/css/icomoon.css' );
	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/normalize.css' );
	wp_enqueue_style( 'foundation', get_template_directory_uri() . '/css/foundation.min.css' );
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );

	wp_enqueue_script( 'jquery2', get_template_directory_uri() . '/js/vendor/jquery.min.js', array(), null, true );
	wp_enqueue_script( 'foundation', get_template_directory_uri() . '/js/foundation.min.js', array(), null, true );
	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/isotope.min.js', array(), null, true );
	wp_enqueue_script( 'scrollTo', '//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js', array(), null, true );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array( 'jquery2' ), null, true );
	
	// Pass wordpress variables to javascript
	$site_parameters = array(
		'default_filter' => get_theme_mod( 'default_filter', 'rozwoj'),
		'plugins_url' => plugin_dir_url( __FILE__ ),
		'site_url' => get_site_url(),
		'theme_directory' => get_template_directory_uri()
	);

	wp_localize_script( 'main', 'site_parameters', $site_parameters );

}

add_action( 'wp_enqueue_scripts', 'enqueue_scripts_and_styles' );
