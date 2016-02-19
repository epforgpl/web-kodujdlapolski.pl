<?php
global $four_in_row;
$img = get_field('photo_alt');
if (!$img) {
	$img = get_field('photo_main');
}

$list = '';

$tech = get_the_terms(get_the_ID(), 'technology');

if (!empty($tech)) {
	foreach ($tech as $term) {
		$list[] = 'fl-'.$term->slug;
	}
}
$status = get_the_terms(get_the_ID(), 'status');
if (!empty($status)) {
	foreach ($status as $term) {
		$list[] = 'fl-'.$term->slug;
	}
}
$filters = get_the_terms(get_the_ID(), 'filters');
if (!empty($filters)) {
	foreach ($filters as $term) {
		$list[] = 'fl-'.$term->slug;
	}
}

?>
<div class="small-12 medium-6 <?php if ($four_in_row==1): ?>large-3<?php else: ?>large-4<?php endif; ?> columns fleft project-box <?php echo join(' ',$list); ?>">
	<a href="<?php the_permalink(); ?>" class="thumb" style="background-image:url(<?php echo $img['sizes']['large']; ?>)"></a>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<div class="excerpt"><?php the_excerpt(); ?></div>
</div>