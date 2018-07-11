<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

	<?php if ( have_comments() ) : ?>
	<h3>Comments</h3>
    
	<b><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</b>
    
	 	<ul class="commentlist">
		<?php wp_list_comments('type=comment&avatar_size=48'); ?> 
	 	</ul>
    
    
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	
	<?php if ( !empty($comments_by_type['pings']) ) :  ?>
	<h3>Trackbacks</h3>
	<b>Check out what others are saying about this post...</b>
	<ol class="commentlist">
	<?php wp_list_comments('type=pings'); ?>
	</ol><br /><br />
	<?php endif; ?>
	
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<div id="respond">

<h3>Leave Comment</h3>

<div class="cancel-comment-reply">
	<?php cancel_comment_reply_link(); ?>
</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p></div>
<?php else : ?>

<form action="<?php echo get_settings('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
  <?php if ( $user_ID ) : ?>
  <p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>
  <?php else : ?>
  <p>
    <input type="text" name="author" id="author" class="textarea" value="<?php echo $comment_author; ?>" size="28" tabindex="1" />
    <label for="author">
    <?php _e('Name'); ?>
    </label>
    <?php if ($req) _e('(required)'); ?>
  </p>
  <p>
    <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="28" tabindex="2" class="textarea" />
    <label for="email">
    <?php _e('E-mail'); ?>
    </label>
    <?php if ($req) _e('(required)'); ?>
  </p>
  <p>
    <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="28" tabindex="3" class="textarea" />
    <label for="url">
    <?php _e('<acronym title="Uniform Resource Identifier">URI</acronym>'); ?>
    </label>
  </p>
  <?php endif; ?>
  <p>
    <label for="comment"><strong>Your Comment</strong></label>
    <br />
    <textarea name="comment" id="comment" cols="60" rows="10" tabindex="4" class="textarea"></textarea>
  </p>
  <p>
    <input name="submit" id="submit" type="submit" tabindex="5" value="<?php _e('submit'); ?>" class="Cbutton" />
    <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
    <input type="hidden" name="redirect_to" value="<?php echo wp_specialchars($_SERVER['REQUEST_URI']); ?>" />
  </p>
  <?php do_action('comment_form', $post->ID); ?>
</form>
</div>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>