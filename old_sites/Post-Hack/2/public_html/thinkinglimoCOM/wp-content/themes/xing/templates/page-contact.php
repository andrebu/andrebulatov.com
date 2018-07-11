<?php
/*
Template Name: Contact Page
*/

global $xng_sb_pos, $xng_email, $xng_success_msg, $xng_google_map;
if(isset($_POST['submit'])) {

	//Validate Name Field
	if(trim($_POST['username']) === '') {
		$name_err = __( 'Enter Your Name', 'xing' );
		$errorFlag = true;
	}
	else {
		$name = trim($_POST['username']);
	}

	//Validate E-mail Address
	if(trim($_POST['email']) === '')  {
		$email_err = __( 'An email is required', 'xing' );
		$errorFlag = true;
	} else if (!preg_match("/^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$/i", trim($_POST['email']))) {
		$email_err = __( 'Enter a valid email', 'xing' );
		$errorFlag = true;
	} else {
		$email = trim($_POST['email']);
	}

	//If URL is left blank. Allow form sending
	if(trim($_POST['url']) == '')  {
		$url = __( 'No URL provided', 'xing' );
	}
	elseif(trim($_POST['url']) != '')  {
		if (!preg_match("/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i", trim($_POST['url']))){
			$url_err = __( 'Please enter a valid URL', 'xing' );
			$errorFlag = true;
		}
		else
			$url = trim($_POST['url']);
	}

	//Validate Message
	if(trim($_POST['comment']) === '') {
		$comment_err = __( 'A comment is required', 'xing' );
		$errorFlag = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comment']));
		} else {
			$comments = trim($_POST['comment']);
		}
	}

	//If there were no errors, send the mail.
	if(!isset($errorFlag)) {
		$to			= ( $xng_email != '' ) ? $xng_email : get_option('admin_email');
		$subject	= sprintf( __( 'Message sent from your website by: %1$s', 'xing' ), $name );
		$body		= sprintf( __( 'Name: %1$s \nEmail: %2$s \nURL: %3$s \nComments: %4$s', 'xing' ), $name, $email, $url, $comments );
		$headers	= sprintf( __( 'From: My WebSite <%1$s>\r\nReply-To: %2$s', 'xing' ), $to, $email );

		if( mail( $to, $subject, $body, $headers ) )
			$sent = true;

		else	//the mail was not sent
			$sent = false;
	}
}
get_header(); ?>
<div id="content"<?php if ( $xng_sb_pos == 'left' ) echo (' class="content-right"'); ?> role="main">
	<?php show_breadcrumbs();
    if (have_posts()) :
		while (have_posts()) : the_post();
			the_content();
			if( $xng_google_map != '' ) {
			$column_class = 'half last';?>
            <div class="half">
            <?php echo stripslashes($xng_google_map); ?>
            </div><!-- .half -->
            <?php } // Google Map
			else $column_class = 'full';?>
            <div class="<?php echo $column_class; ?>">
			<?php if(isset($sent)) { ?>
                <div id="mail_success_no_JS" class="box box2">
                <?php echo stripslashes($xng_success_msg); ?>
                </div><!-- .mail_success_no_JS-->
			<?php }?>
			<form <?php if(isset($sent)) { ?>style="display:none"<?php }?> action="<?php the_permalink();?>" method="post" id="contactform" class="commentform">
			<p><input type="text" class="<?php if(isset($name_err) && $name_err != '') { ?>error<?php } ?>" id="name" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>" /><label for="name"><?php _e( 'Name*', 'xing' ); ?></label></p>
			<p><input type="text" id="email" name="email" class="<?php if(isset($email_err) && $email_err != '') { ?>error<?php } ?>" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" /><label for="email"><?php _e( 'E-mail*', 'xing' ); ?></label></p>
			<p><input type="text" id="url" name="url" class="<?php if(isset($url_err) && $url_err != '') { ?>error<?php } ?>" value="<?php if(isset($_POST['url']))  echo $_POST['url'];?>" /><label for="url"><?php _e( 'URL', 'xing' ); ?></label></p>
			<p><textarea name="comment" rows="10" cols="8" class="<?php if(isset($comment_err) && $comment_err != '') { ?>error<?php } ?>" id="comment" ><?php if(isset($_POST['comment'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comment']); } else { echo $_POST['comment']; } } ?></textarea><label for="comment"><?php _e( 'Message*', 'xing' ); ?></label></p>
			<p class="submit"><input name="submit" type="submit" class="submit" tabindex="5" value="<?php _e( 'Send Message', 'xing' ); ?>" /></p>
			</form>
			<div id="mail_success" class="box box2">
			<?php echo stripslashes($xng_success_msg); ?>
			</div>
            </div><!-- .half last -->
		<?php endwhile;
    else : ?>
        <h2><?php _e( 'Not Found', 'xing' ); ?></h2>
        <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'xing' ); ?></p>
    <?php endif;?>
</div><!-- #content -->
<?php get_sidebar(); ?>
</div><!-- #primary .wrap -->
</div><!-- #primary -->
<?php get_footer(); ?>