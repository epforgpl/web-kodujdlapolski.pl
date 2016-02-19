<?php
global $four_in_row;
$img = get_field('photo_alt');
if (!$img) {
	$img = get_field('photo_main');
}
?>

<div class="column project-box pb2">
	<a href="<?php the_permalink(); ?>" class="thumb" style="background-image:url(<?php echo $img['sizes']['large']; ?>)"></a>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
</div>