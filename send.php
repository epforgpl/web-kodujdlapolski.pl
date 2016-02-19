<?php

	if (file_exists("../../../wp-load.php"))
		require_once("../../../wp-load.php");
	

if (!empty($_GET['email']))
{
		
	$headers = 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: ' . $_GET['email'] . "\r\n" .
    'Reply-To: ' . $_GET['email'] . "\r\n";
	$title='Zapytanie ze strony';
	$content='Imię: '.$_GET['fname'].
					'<br>email: '.$_GET['email'].
					'<br>przedmiot: '.$_GET['object'].
					'<br>wiadomość: '.nl2br($_GET['message']);
	mail('contact@agatabielen.com',$title,$content,$headers);
	
	?>	
	<?php _e('Your message has been sent'); ?>


<?php
	
	
}
else {
	echo '';
}
?>