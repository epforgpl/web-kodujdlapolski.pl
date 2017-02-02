<?php
/*
 * Template name: Kontakt
 */
?>

<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>

<?php get_template_part('breadcrumbs'); ?>

<div class="row page-single">

  <?php if (have_posts()): ?>
    <?php while (have_posts()): the_post(); ?>
      <div class="small-12 medium-9 columns post-content">
        <h1 class="page-title"><?php the_title(); ?></h1>
        <div class="contact-list">
          <div class="row mt40">
            <div class="small-12 medium-6 columns team-list">
              <table>
                <?php $member = get_field('main'); ?>
                <tr>
                  <td class="photo">
                    <?php
                    $photo = get_field('photo', 'user_' . $member['ID']);
                    $user_photo = $photo['sizes']['thumbnail'];

                    if (!$user_photo) {
                      $user_photo = get_avatar_url($member['ID'], array('size' => 105));
                    }
                    if (!$user_photo) {
                      $user_photo = $src . '/images/blank-person2.jpg';
                    }
                    $phone = get_field('phone_contact', 'user_' . $member['ID']);
                    $phone = get_field('phone_contact', 'user_' . $member['ID']);
                    $mail = get_field('mail_contact', 'user_' . $member['ID']);
                    if (ICL_LANGUAGE_CODE == 'pl') {
                      $function = get_field('function', 'user_' . $member['ID']);
                    } else {
                      $function = get_field('function_en', 'user_' . $member['ID']);
                    }
                    ?>
                    <a href="<?php echo get_author_posts_url($member['ID']); ?>"><img src="<?php echo $user_photo; ?>" /></a>
                  </td>
                  <td class="desc">
                    <h4><a href="<?php echo get_author_posts_url($member['ID']); ?>"><?php echo $member['display_name'] ?></a></h4>
                    <div class="function">
                      <?php echo $function; ?><br />
                      <?php if ($mail): ?><a href="mailto:<?php echo $mail; ?>"><?php echo $mail; ?></a><br /><?php endif; ?>
                      <?php if ($phone): ?><?php echo $phone; ?><?php endif; ?>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>


          <div class="row mt10">

            <?php $members = get_field('local'); ?>
            <?php foreach ($members as $member): ?>
              <div class="small-12 medium-6 columns team-list">
                <table>
                  <tr>
                    <td class="photo">
                      <?php
                      $photo = get_field('photo', 'user_' . $member['ID']);
                      $user_photo = $photo['sizes']['thumbnail'];

                      if (!$user_photo) {
                        $user_photo = get_avatar_url($member['ID'], array('size' => 105));
                      }
                      if (!$user_photo) {
                        $user_photo = $src . '/images/blank-person2.jpg';
                      }
                      $phone = get_field('phone_contact', 'user_' . $member['ID']);
                      $mail = get_field('mail_contact', 'user_' . $member['ID']);
                      if (ICL_LANGUAGE_CODE == 'pl') {
                        $function = get_field('function', 'user_' . $member['ID']);
                      } else {
                        $function = get_field('function_en', 'user_' . $member['ID']);
                      }
                      ?>
                      <a href="<?php echo get_author_posts_url($member['ID']); ?>"><img src="<?php echo $user_photo; ?>" /></a>
                    </td>
                    <td class="desc">
                      <h4><a href="<?php echo get_author_posts_url($member['ID']); ?>"><?php echo $member['display_name'] ?></a></h4>
                      <div class="function">
                        <?php echo $function; ?><br />
                        <?php if ($mail): ?><a href="mailto:<?php echo $mail; ?>"><?php echo $mail; ?></a><br /><?php endif; ?>
                        <?php if ($phone): ?><?php echo $phone; ?><?php endif; ?>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>

  <div class="small-12 medium-3 columns post-author">
    <?php get_template_part('sidebar'); ?>
  </div>
</div>

<?php get_footer() ?>
