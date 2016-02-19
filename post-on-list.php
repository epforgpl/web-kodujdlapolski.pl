<?php
$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
$url = $thumb['0'];
?>
<div class="small-12 medium-6 large-4 columns fleft post-box">
	<a href="<?php the_permalink(); ?>" class="thumb" style="background-image:url(<?php echo $url; ?>)"></a>
	<div class="date"><?php echo get_the_date(); ?> | <?php the_category(', '); ?></div>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<div class="excerpt"><?php the_excerpt(); ?></div>
</div>