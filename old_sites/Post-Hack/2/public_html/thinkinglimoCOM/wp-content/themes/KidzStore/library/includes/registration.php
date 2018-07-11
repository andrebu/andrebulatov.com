<?php
global $Cart,$General,$wpdb;
$userInfo = $General->getLoginUserInfo();
$_SESSION['checkout_as_guest'] = '';
global $current_user;
if($current_user->data->ID && $_GET['action'] != 'logout')
{
	wp_redirect(get_option( 'siteurl' ).'/?page=myaccount');
	exit;
}

include_once( 'wp-load.php' );
include_once(ABSPATH.'wp-includes/registration.php');

// Redirect to https login if forced to use SSL
if ( force_ssl_admin() && !is_ssl() ) {
	if ( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ) {
		wp_redirect(preg_replace('|^http://|', 'https://', $_SERVER['REQUEST_URI']));
		exit();
	} else {
		wp_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		exit();
	}
}

	$message = apply_filters('login_message', $message);
	if ( !empty( $message ) ) echo $message . "\n";


/**
 * Handles sending password retrieval email to user.
 *
 * @uses $wpdb WordPress Database object
 *
 * @return bool|WP_Error True: when finish. WP_Error on error
 */
function retrieve_password() {
	global $wpdb;

	$errors = new WP_Error();

	if ( empty( $_POST['user_login'] ) && empty( $_POST['user_email'] ) )
		$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.'));

	if ( strpos($_POST['user_login'], '@') ) {
		$user_data = get_user_by_email(trim($_POST['user_login']));
		if ( empty($user_data) )
			$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
	} else {
		$login = trim($_POST['user_login']);
		$user_data = get_userdatabylogin($login);
	}

	do_action('lostpassword_post');

	if ( $errors->get_error_code() )
		return $errors;

	if ( !$user_data ) {
		$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.'));
		return $errors;
	}

	// redefining user_login ensures we return the right case in the email
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	do_action('retreive_password', $user_login);  // Misspelled and deprecated
	do_action('retrieve_password', $user_login);

	$allow = apply_filters('allow_password_reset', true, $user_data->ID);

	////////////////////////////////////
	$user_email = $_POST['user_email'];
	$user_login = $_POST['user_login'];
	$user = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE user_login = \"$user_login\" or user_email= \"$user_login\"");

	$user_email = $user->user_email;
	
	$new_pass = wp_generate_password(12,false);
	global $General;
	wp_set_password($new_pass, $user->ID);
	update_usermeta($user->ID, 'default_password_nag', true); //Set up the Password change nag.
	$message  = '<p>'.sprintf(__('Username: %s'), $user_data->user_login) . '</p>';
	$message .= '<p>'.sprintf(__('Password: %s'), $new_pass) . "</p>";
	$message .= '<p>You can <a href="'.get_option( 'siteurl' ).'/?page=login">Login</a> now</p>';
	$title = sprintf(__('[%s] Your new password'), get_option('blogname'));
	$user_email = $user_data->user_email;
	$user_login = $user_data->user_login;
	$title = apply_filters('password_reset_title', $title);
	$message = apply_filters('password_reset_message', $message, $new_pass);
	$fromEmail = $General->get_site_emailId();
	$fromEmailName = $General->get_site_emailName();
	$General->sendEmail($fromEmail,$fromEmailName,$user_email,$user_login,$title,$message,$extra='');///To clidne email
	return true;
}

/**
 * Handles registering a new user.
 *
 * @param string $user_login User's username for logging in
 * @param string $user_email User's email address to send password and add
 * @return int|WP_Error Either user's ID or error on failure.
 */
function register_new_user($user_login, $user_email) {
	global $wpdb,$General;
	$errors = new WP_Error();

	$user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );

	// Check the username
	if ( $user_login == '' )
		$errors->add('empty_username', __('ERROR: Please enter a username.'));
	elseif ( !validate_username( $user_login ) ) {
		$errors->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.'));
		$user_login = '';
	} elseif ( username_exists( $user_login ) )
		$errors->add('username_exists', __('<strong>ERROR</strong>: This username is already registered, please choose another one.'));

	// Check the e-mail address
	if ($user_email == '') {
		$errors->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.'));
	} elseif ( !is_email( $user_email ) ) {
		$errors->add('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.'));
		$user_email = '';
	} elseif ( email_exists( $user_email ) )
		$errors->add('email_exists', __('<strong>ERROR</strong>: This email is already registered, please choose another one.'));

	do_action('register_post', $user_login, $user_email, $errors);

	$errors = apply_filters( 'registration_errors', $errors );
	global $registration_error_msg;
	$registration_error_msg = 0;
	foreach($errors as $errorsObj)
	{
		foreach($errorsObj as $key=>$val)
		{
			for($i=0;$i<count($val);$i++)
			{
				echo "<div class=error_msg>".$val[$i].'</div>';	
				$registration_error_msg = 1;
			}
		} 
	}
	

	if ( $errors->get_error_code() )
		return $errors;


	$user_pass = wp_generate_password(12,false);
	$user_id = wp_create_user( $user_login, $user_pass, $user_email );
	
	$user_add1 = stripslashes(str_replace("'","&acute;",$_POST['user_add1']));
	$user_add2 = stripslashes(str_replace("'","&acute;",$_POST['user_add2']));
	$user_city = stripslashes(str_replace("'","&acute;",$_POST['user_city']));
	$user_state = stripslashes(str_replace("'","&acute;",$_POST['user_state']));
	$user_country = stripslashes(str_replace("'","&acute;",$_POST['user_country']));
	$user_postalcode = stripslashes(str_replace("'","&acute;",$_POST['user_postalcode']));
	$user_phone = $_POST['user_phone'];
	$is_affiliate = $_POST['is_affiliate'];
	$user_address_info = array(
						"user_add1"		=> $user_add1,
						"user_add2"		=> $user_add2,
						"user_city"		=> $user_city,
						"user_state"	=> $user_state,
						"user_country"	=> $user_country,
						"user_postalcode"=> $user_postalcode,
						"user_phone"			=> $user_phone,
						"buser_name" 	=> stripslashes(str_replace("'","&acute;",$_POST['user_fname'])).' '.stripslashes(str_replace("'","&acute;",$_POST['user_lname'])),
						"buser_add1"	=> $user_add1,
						"buser_add2"	=> $user_add2,
						"buser_city"	=> $user_city,
						"buser_state"	=> $user_state,
						"buser_country"	=> $user_country,
						"buser_postalcode"=> $user_postalcode,
						"buser_phone"=> $user_phone,
						);
	update_usermeta($user_id, 'user_address_info', serialize($user_address_info)); // User Address Information Here
	update_usermeta($user_id, 'first_name', $_POST['user_fname']); // User Address Information Here
	update_usermeta($user_id, 'last_name', $_POST['user_lname']); // User Address Information Here
	$userName = $_POST['user_fname'].'  '.$_POST['user_lname'];
	$updateUsersql = "update $wpdb->users set user_nicename=\"$userName\", display_name=\"$userName\"  where ID=\"$user_id\"";
	$wpdb->query($updateUsersql);
	
	if ( !$user_id ) {
		$errors->add('registerfail', sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !'), get_option('admin_email')));
		return $errors;
	}

	if ( $user_id ) 
	{
		////AFFILIAGE START//
		if($General->is_active_affiliate())
		{
			if($is_affiliate)
			{
				//$user_role = get_usermeta($user_id,'wp_capabilities');
				$user_role['affiliate'] = 1;
				update_usermeta($user_id, 'wp_capabilities', $user_role);
			}
		}
		////AFFILIATE END///
		
		//wp_new_user_notification($user_id, $user_pass);
		///////REGISTRATION EMAIL START//////
		global $General;
		$fromEmail = $General->get_site_emailId();
		$fromEmailName = $General->get_site_emailName();
		$store_name = get_option('blogname');
		$order_info = $General->get_order_detailinfo_tableformat($orderInfoArray,1);
		$clientdestinationfile =   ABSPATH . $upload_folder_path."notification/emails/registration.txt";
		if(!file_exists($clientdestinationfile))
		{
		$client_message = '[SUBJECT-STR]'.__('Registration Email').'[SUBJECT-END]<p>Dear [#$user_name#],</p>
	<p>You can log in  with the following information:</p>
	<p>'.__('Username').': [#$user_login#]</p>
	<p>'.__('Password').': [#$user_password#]</p>
	<p>[#$store_login_url#]</p>
	<br>
	<p>'.__('We hope you enjoy shopping. Thanks!').'</p>
	<p>[#$store_name#]</p>';
		}else
		{
			$client_message = file_get_contents($clientdestinationfile);
		}
		$filecontent_arr1 = explode('[SUBJECT-STR]',$client_message);
		$filecontent_arr2 = explode('[SUBJECT-END]',$filecontent_arr1[1]);
		$subject = $filecontent_arr2[0];
		if($subject == '')
		{
			$subject = "Registration Email";
		}
		$client_message = $filecontent_arr2[1];
		$store_login = 'You can login to : <a href="'.get_option( 'siteurl' ).'/?page=login' . "\">Login</a> or the URL is :  ".get_option( 'siteurl' )."/?page=login";
		/////////////customer email//////////////
		$search_array = array('[#$user_name#]','[#$user_login#]','[#$user_password#]','[#$store_name#]','[#$store_login_url#]');
		$replace_array = array($_POST['user_fname'],$user_login,$user_pass,$store_name,$store_login);
		$client_message = str_replace($search_array,$replace_array,$client_message);		
		$General->sendEmail($fromEmail,$fromEmailName,$user_email,$userName,$subject,$client_message,$extra='');///To clidne email
		//////REGISTRATION EMAIL END////////
	}
	return array($user_id,$user_pass);
}			
?>

<?php
if(strstr($_SESSION['redirect_page'],'page=checkout'))
{
	$title = LOGIN_AS_CHECKOUT_TITLE;
	$title_cum = LOGIN_AS_CHECKOUT_TITLE;
}else
{
	$title = LOGIN_PAGE_TITLE;
	$title_cum = LOGIN_PAGE_TITLE;
}
?>
<?php get_header(); ?>
<div id="wrapperinner">
	<div id="mainheading">
		<div id="heading">
			<h2><?php echo $title;?></h2>
             <div class="breadcrumb clearfix">
			<?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',' &raquo;  '. __($title_cum)); } ?>
             </div>
		</div>
	</div>
</div>

</h1>
  
  <div class="container_16 clearfix">
    <div id="content" class="full_width" >
         
<?php
if($General->get_loginpage_top_statement())
{
	$topcontent = $General->get_loginpage_top_statement();
	$store_name = get_option('blogname');
	$search_array = array('[#$store_name#]');
	$replace_array = array($store_name);
	$instruction = str_replace($search_array,$replace_array,$topcontent);
	?>
    <p class="login_instruction"><?php 	echo $instruction;	?> </p>
    <?php
}else
{
	echo _e(LOGIN_PAGE_TOP_MSG);
}
$chekcout_method = $General->get_checkout_method();
if($chekcout_method == 'single' && $General->is_storetype_shoppingcart())
{
	$box_width = "29";
}else
{
	$box_width = "42";
}
?>

 <div class="registernchekout_m" style="width:<?php echo $box_width;?>%">
                    <h3> <?php _e(REGISTER_AND_CHECKOUT_TEXT); ?> </h3>
                    <p> <?php _e(REGISTER_CHECKOUT_MSG);?>  </p>
                     <input class="highlight_input_btn " type="button" onclick="showhide_registration();" value="<?php _e('Register &raquo;');?>" name="confirm"/>
                   </div>


<div class="sign_in_l" style="width:<?php echo $box_width;?>%" >
        <h3> <?php _e(SING_IN_TEXT);?> </h3>
        
        <p> <?php _e(SIGN_IN_MSG);?> </p>
        <p> <a href="javascript:void(0);showhide_forgetpw();"><u>forgot Password?</u></a></p>
       <input class="highlight_input_btn " type="button" onclick="showhide_login();" value="<?php _e('Sign In &raquo;');?>" name="confirm"/>
    </div>
    
    
   
   
   <?php
 $chekcout_method = $General->get_checkout_method();
 if($chekcout_method == 'single'  && $General->is_storetype_shoppingcart())
 {
 ?>
   <div class="checkout_r" style="width:29%" >
    <h3> <?php _e(GUEST_CHECKOUT_TEXT); ?> </h3>
    <p> <?php _e(GUEST_CHECKOUT_MSG);?>  </p>
     <input class="highlight_input_btn " type="button" onclick="window.location.href='<?php echo $General->get_ssl_normal_url(get_option( 'siteurl' ));?>/?page=checkout&checkout_as_guest=1'" value="<?php _e('Checkout');?> &raquo;" name="confirm"/>
   </div>
 <?php
 }
 ?>
<?php
$chekcout_method = $General->get_checkout_method();
if($chekcout_method == 'single' && $General->is_storetype_shoppingcart())
{
}
?>
     
<?php
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
$errors = new WP_Error();

if ( isset($_GET['key']) )
	$action = 'resetpass';

// validate action so as to default to the login screen
if ( !in_array($action, array('logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'register', 'login')) && false === has_filter('login_form_' . $action) )
	$action = 'login';

nocache_headers();

header('Content-Type: '.get_bloginfo('html_type').'; charset='.get_bloginfo('charset'));

if ( defined('RELOCATE') ) { // Move flag is set
	if ( isset( $_SERVER['PATH_INFO'] ) && ($_SERVER['PATH_INFO'] != $_SERVER['PHP_SELF']) )
		$_SERVER['PHP_SELF'] = str_replace( $_SERVER['PATH_INFO'], '', $_SERVER['PHP_SELF'] );

	$schema = ( isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ) ? 'https://' : 'http://';
	if ( dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) != get_option('siteurl') )
		update_option('siteurl', dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) );
}

//Set a cookie now to see if they are supported by the browser.
setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
if ( SITECOOKIEPATH != COOKIEPATH )
	setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);

// allow plugins to override the default actions, and to add extra actions if they want
do_action('login_form_' . $action);

$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
switch ($action) {

case 'logout' :
//check_admin_referer('log-out');
//wp_logout();
	wp_clear_auth_cookie();

	$redirect_to =  $_SERVER['HTTP_REFERER'];
	if ( isset( $_REQUEST['redirect_to'] ) )
		$redirect_to = $_REQUEST['redirect_to'];

	wp_safe_redirect($redirect_to);
	exit();

break;

case 'lostpassword' :
case 'retrievepassword' :
	if ( $http_post ) {
		$errors = retrieve_password();
		$error_message = $errors->errors['invalid_email'][0];
		if ( !is_wp_error($errors) ) {
			global $General;
			wp_redirect(get_option( 'siteurl' ).'/?page=login&action=login&checkemail=newpass');
			exit();
		}
	}

	if ( isset($_GET['error']) && 'invalidkey' == $_GET['error'] ) $errors->add('invalidkey', __('Sorry, that key does not appear to be valid.'));

	do_action('lost_password');
	$message = '<div class="sucess_msg">Please enter your username or e-mail address. You will receive a new password via e-mail.</div>';
	$user_login = isset($_POST['user_login']) ? stripslashes($_POST['user_login']) : '';

break;

case 'resetpass' :
case 'rp' :
	$errors = reset_password($_GET['key'], $_GET['login']);

	if ( ! is_wp_error($errors) ) {
		global $General;
		wp_redirect(get_option( 'siteurl' ).'/?page=login&action=login&checkemail=newpass');
		exit();
	}
	global $General;
	wp_redirect(get_option( 'siteurl' ).'/?page=login&action=lostpassword&error=invalidkey');
	exit();

break;

case 'register' :
	global $General;
	if ( !get_option('users_can_register') ) {
		wp_redirect(get_option( 'siteurl' ).'/?page=login&registration=disabled');
		exit();
	}

	$user_login = '';
	$user_email = '';
	if ( $http_post ) {
		//require_once( ABSPATH . WPINC . '/registration.php');

		$user_login = $_POST['user_login'];
		$user_email = $_POST['user_email'];
		$user_fname = $_POST['user_fname'];
		$user_lname = $_POST['user_lname'];		  
		$user_add1 = $_POST['user_add1'];
		$user_add2 = $_POST['user_add2'];
		$user_city = $_POST['user_city'];
		$user_state = $_POST['user_state'];
		$user_country = $_POST['user_country'];
		$user_postalcode = $_POST['user_postalcode'];
		$user_phone = $_POST['user_phone'];
		
		$errors = register_new_user($user_login, $user_email);
		if ( !is_wp_error($errors) ) 
		{
			$_POST['log'] = $user_login;
			$_POST['pwd'] = $errors[1];
			$_POST['testcookie'] = 1;
			
			$secure_cookie = '';
			// If the user wants ssl but the session is not ssl, force a secure cookie.
			if ( !empty($_POST['log']) && !force_ssl_admin() ) {
				$user_name = sanitize_user($_POST['log']);
				if ( $user = get_userdatabylogin($user_name) ) {
					if ( get_user_option('use_ssl', $user->ID) ) {
						$secure_cookie = true;
						force_ssl_admin(true);
					}
				}
			}
		
			$redirect_to = $_REQUEST['reg_redirect_link'];
			if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
				$secure_cookie = false;
		
			$user = wp_signon('', $secure_cookie);
		
			$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['reg_redirect_link'] ) ? $_REQUEST['reg_redirect_link'] : '', $user);
		
			if ( !is_wp_error($user) ) 
			{
				wp_safe_redirect($redirect_to);
				exit();
			}
			exit();
		}
	}
break;

case 'login' :
default:
	$secure_cookie = '';
	if ( !empty($_POST['log']) && !force_ssl_admin() ) {
		$user_name = sanitize_user($_POST['log']);
		if ( $user = get_userdatabylogin($user_name) ) {
			if ( get_user_option('use_ssl', $user->ID) ) {
				$secure_cookie = true;
				force_ssl_admin(true);
			}
		}
	}

	if ( isset( $_REQUEST['redirect_to'] ) ) {
		$redirect_to = $_REQUEST['redirect_to'];
		// Redirect to https if user wants ssl
		if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )
			$redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
	} else {
		$redirect_to = admin_url();
	}

	if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;

	$user = wp_signon('', $secure_cookie);

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);

	if ( !is_wp_error($user) ) {
		// If the user can't edit posts, send them to their profile.
		if ( !$user->has_cap('edit_posts') && ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' || $redirect_to == admin_url() ) )
			$redirect_to = admin_url('profile.php');
		wp_safe_redirect($redirect_to);
		exit();
	}

	$errors = $user;
	// Clear errors if loggedout is set.
	if ( !empty($_GET['loggedout']) )
		$errors = new WP_Error();

	// If cookies are disabled we can't log in even with a valid user+pass
	if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) )
		$errors->add('test_cookie', __("<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use WordPress."));

	// Some parts of this script use the main login form to display a message
	if( isset($_GET['loggedout']) && TRUE == $_GET['loggedout'] )
	{
		$successmsg = '<div class="sucess_msg">You are now logged out.</div>';
	}
	elseif( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )
	{
		$successmsg = 'User registration is currently not allowed.';
	}
	elseif( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )
	{
		$successmsg = 'Check your e-mail for the confirmation link.';
	}
	elseif( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )
	{
		$successmsg = 'Check your e-mail for your new password.';
	}
	elseif( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )
	{
		$successmsg = 'Registration complete. Please check your e-mail.';
	}

echo "<p style=\"color:green\">".$successmsg.'</p>';	
//	login_header(__('Log In'), '', $errors);
?>
        <script type="text/javascript" >
<?php if ( $user_login ) { ?>
setTimeout( function(){ try{
d = document.getElementById('user_pass');
d.value = '';
d.focus();
} catch(e){}
}, 200);
<?php } else { ?>
try{document.getElementById('user_login').focus();}catch(e){}
<?php } ?>
</script>
        <?php

break;
} // end action switch
?>
        <?php
if($error_message)
{
	echo "<div class=error_msg>".$error_message.'</div>';
}
$forgot_password_error = 0;
if($message)
{
	//echo "".$message.'';
	$forgot_password_error = 1;
}
$login_invalid_error = 0;
if ( isset($_POST['log']) )
{
	if( 'incorrect_password' == $errors->get_error_code() || 'empty_password' == $errors->get_error_code() || 'invalid_username' == $errors->get_error_code() )
	{
		$login_invalid_error = 1;
		echo "<div class=\"error_msg\"> Invalid Username/Password. </div>";
	}
}
if($errors->get_error_code() == 'invalidcombo')
{
	$showforgotpwflag = 1;
	$errors = $errors->errors;
	echo "<div class=error_msg>".$errors['invalidcombo'][0].'</div>';
	global $General;
}
?>
     <script type="text/javascript" >
function chk_form_login()
{
	if(document.getElementById('user_login').value=='')
	{
		alert('<?php _e('Please enter '.USERNAME_TEXT) ?>');
		document.getElementById('user_login').focus();
		return false;
	}
	if(document.getElementById('user_pass').value=='')
	{
		alert('<?php _e('Please enter '.PASSWORD_TEXT) ?>');
		document.getElementById('user_pass').focus();
		return false;
	}
}
</script>
          <div class="form login_form"  id="login_form_div_id" style="display:none;" >
            <h3> <?php _e(SING_IN_TEXT);?> </h3>
            <form name="loginform" id="loginform" action="<?php echo get_option( 'siteurl' ).'/?page=login'; ?>" method="post">
              <div class="form_row">
                <label>
                <?php _e(USERNAME_TEXT) ?>
                </label>
                <input type="text" name="log" id="user_login" value="<?php echo esc_attr($user_login); ?>" size="20" class="form_textfield"  />
              </div>
              <div class="form_row">
                <label>
                <?php _e(PASSWORD_TEXT) ?>
                </label>
                <input type="password" name="pwd" id="user_pass" class="form_textfield" value="" size="20" />
              </div>
              <?php do_action('login_form'); ?>
              <p class="forgetmenot">
                <input name="rememberme" type="checkbox" id="rememberme" value="forever" class="fl" />
                <?php esc_attr_e('Remember me on this computer'); ?>
              </p>
               <input class="highlight_input_btn login" type="submit" value="<?php _e('Sign In');?>" onclick="return chk_form_login();"  name="submit" />
			 <?php
			 global $General;
             if(strstr($_SESSION['redirect_page'],'page=checkout'))
            {
                $login_redirect_link = get_option( 'siteurl' ).'/?page=cart';
            }else
            {
                $login_redirect_link = get_option( 'siteurl' ).'/?page=login&action=register';
            }
            ?>
              <input type="hidden" name="redirect_to" value="<?php echo $login_redirect_link; ?>" />
              <span class="forgot_password"> <a href="javascript:void(0);showhide_forgetpw();"><?php _e(FORGET_PW_TEXT);?></a></span>
              <input type="hidden" name="testcookie" value="1" />
              </form>
          </div>
          <!-- login form #end -->


         <div class="lostpassword_form" id="lostpassword_form" style="display:none;">
            <h3><?php _e(FORGOT_PASSWORD_TEXT);?></h3>
            <form name="lostpasswordform" id="lostpasswordform" action="<?php echo get_option( 'siteurl' ).'/?page=login&action=lostpassword'; ?>" method="post">
              <label>
              <?php _e(USERNAME_EMAIL_TEXT) ?>
              </label>
              <input type="text" name="user_login" id="user_login1" value="<?php echo esc_attr($user_login); ?>" size="20" class="lostpass_textfield" />
              <?php do_action('lostpassword_form'); ?>
              <a  href="javascript:void(0);" onclick="document.lostpasswordform.submit();" class="highlight_button fl " ><?php _e(GET_NEW_PASSWORD_TEXT);?></a>
            </form>
          </div>
        
<?php
$mandotary_info = $General->get_userinfo_mandatory_fields();
if($mandotary_info['bill_address1'])
{
	$bill_address1 = ' <span class="indicates">*</span>';
}
if($mandotary_info['bill_address2'])
{
	$bill_address2 = ' <span class="indicates">*</span>';
}
if($mandotary_info['bill_city'])
{
	$bill_city = ' <span class="indicates">*</span>';
}
if($mandotary_info['bill_state'])
{
	$bill_state = ' <span class="indicates">*</span>';
}
if($mandotary_info['bill_country'])
{
	$bill_country = ' <span class="indicates">*</span>';
}
if($mandotary_info['bill_zip'])
{
	$bill_zip = ' <span class="indicates">*</span>';
}
if($mandotary_info['bill_phone'])
{
	$bill_phone = ' <span class="indicates">*</span>';
}

global $General;
?>
<div id="reg_form_div_id" style="display:none;">
        <!-- form column #end -->
         <form name="registerform" id="registerform" action="<?php echo get_option( 'siteurl' ).'/?page=login&action=register';//echo site_url('wp-login.php?action=register', 'login_post') ?>" method="post">
        <?php
		if(strstr($_SESSION['redirect_page'],'page=checkout'))
		{
			$reg_redirect_link = $General->get_ssl_normal_url(get_option( 'siteurl' )).'/?page=checkout';
		}else
		{
			$reg_redirect_link = get_option( 'siteurl' ).'/?page=login&action=register';
		}
		?>
        <input type="hidden" name="reg_redirect_link" value="<?php echo $reg_redirect_link;?>" />
        <div class="form registration_form">
         <h3><?php _e(YOUR_INFO_TEXT);?> </h3>
          <p class="mandatory"> <span class="indicates">*</span> <?php _e(INDICATE_MENDATORY_MSG);?></p>
         <h5><?php _e(PERSONAL_INFO_TEXT);?> </h5>
         
            <div class="reg_row fl">
              <label>
              <?php _e(USERNAME_TEXT) ?>
              <span class="indicates">*</span></label>
              <input type="text" name="user_login" id="user_loginreg" class="reg_row_textfield" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="20"/>
            </div>
            <div class="reg_row fl">
              <label>
              <?php _e(EMAIL_TEXT) ?>
              <span class="indicates">*</span></label>
              <input type="text" name="user_email" id="user_emailreg" class="reg_row_textfield" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" />
            </div>
            <div class="reg_row fl">
              <label>
              <?php _e(FIRST_NAME_TEXT) ?>
              <span class="indicates">*</span></label>
              <input type="text" name="user_fname" id="user_fname" class="reg_row_textfield" value="<?php echo esc_attr(stripslashes($user_fname)); ?>" size="25"  />
            </div>
            <div class="reg_row fl">
              <label>
              <?php _e(LAST_NAME_TEXT) ?>
              </label>
              <input type="text" name="user_lname" id="user_lname" class="reg_row_textfield" value="<?php echo esc_attr(stripslashes($user_lname)); ?>" size="25"  />
            </div>
            <div class="fix"></div>
            <h5><?php _e(LOCATION_INFO_TEXT);?> </h5>
            <div class="reg_row fl">
              <label>
              <?php _e(ADDRESS1_TEXT) ?> <?php echo $bill_address1;?>
              </label>
              <input type="text" name="user_add1" id="user_add1" class="reg_row_textfield" value="<?php echo esc_attr(stripslashes($user_add1)); ?>" size="25" />
            </div>
            <div class="reg_row fl">
              <label>
              <?php _e(ADDRESS2_TEXT) ?> <?php echo $bill_address2;?>
              </label>
              <input type="text" name="user_add2" id="user_add2" class="reg_row_textfield" value="<?php echo esc_attr(stripslashes($user_add2)); ?>" size="25" />
            </div>
            <div class="reg_row fl">
              <label>
              <?php _e(CITY_TEXT) ?> <?php echo $bill_city;?>
              </label>
              <input type="text" name="user_city" id="user_city" class="reg_row_textfield" value="<?php echo esc_attr(stripslashes($user_city)); ?>" size="25" />
            </div>
            <div class="reg_row fl">
              <label>
              <?php _e(STATE_TEXT) ?> <?php echo $bill_state;?>
              </label>
              <input type="text" name="user_state" id="user_state" class="reg_row_textfield" value="<?php echo esc_attr(stripslashes($user_state)); ?>" size="25" />
            </div>
            <div class="reg_row fl">
              <label>
              <?php _e(COUNTRY_TEXT) ?> <?php echo $bill_country;?>
              </label>
              <input type="text" name="user_country" id="user_country" class="reg_row_textfield" value="<?php echo esc_attr(stripslashes($user_country)); ?>" size="25" />
             </div>
            <div class="reg_row fl">
              <label>
              <?php _e(POSTAL_CODE_TEXT) ?> <?php echo $bill_zip;?>
              </label>
              <input type="text" name="user_postalcode" id="user_postalcode" class="reg_row_textfield" value="<?php echo esc_attr(stripslashes($user_postalcode)); ?>" size="25" />
            </div>
             <div class="reg_row fl">
              <label>
              <?php  _e(PHONE_NUMBER_TEXT); ?> <?php echo $bill_phone;?>
              </label>
              <input type="text" name="user_phone" id="user_phone" class="reg_row_textfield" value="<?php echo esc_attr(stripslashes($user_phone)); ?>" size="25" />
            </div>
            <?php do_action('register_form'); ?>
            <div id="reg_passmail">
               <?php _e(REGISTRATION_EMAIL_MSG) ?>
            </div>
            <a  href="javascript:void(0);" onclick="return chk_form_reg();" class="highlight_button fl " ><?php _e(CREATE_ACCOUNT_BUTTON);?> </a>
       
        </div>
           </form>
</div>
 <script type="text/javascript">
try{document.getElementById('user_login').focus();}catch(e){}
</script>
     </div>
    <!-- content #end -->
  </div>
  <!-- container 16-->
<script  type="text/javascript" >
function chk_form_reg()
{
	if(document.getElementById('user_loginreg').value == '')
	{
		alert("<?php _e('Please enter '.USERNAME_TEXT) ?>");
		document.getElementById('user_loginreg').focus();
		return false;
	}
	if(document.getElementById('user_emailreg').value == '')
	{
		alert("<?php _e('Please enter '.EMAIL_TEXT) ?>");
		document.getElementById('user_emailreg').focus();
		return false;
	}
	if(document.getElementById('user_fname').value == '')
	{
		alert("<?php _e('Please enter '.FIRST_NAME_TEXT) ?>");
		document.getElementById('user_fname').focus();
		return false;
	}
	<?php
	if($mandotary_info['bill_address1'])
	{
	?>
		if(document.getElementById('user_add1').value=='')
		{
			alert('<?php _e('Please enter '.ADDRESS1_TEXT) ?>');
			document.getElementById('user_add1').focus();
			return false;
		}
	<?php
	}
	?>
	<?php
	if($mandotary_info['bill_address2'])
	{
	?>
		if(document.getElementById('user_add2').value=='')
		{
			alert('<?php _e('Please enter '.ADDRESS2_TEXT) ?>');
			document.getElementById('user_add2').focus();
			return false;
		}
	<?php
	}
	?>
	<?php
	if($mandotary_info['bill_city'])
	{
	?>
		if(document.getElementById('user_city').value=='')
		{
			alert('<?php _e('Please enter '.CITY_TEXT) ?>');
			document.getElementById('user_city').focus();
			return false;
		}
	<?php
	}
	?>
	<?php
	if($mandotary_info['bill_state'])
	{
	?>
		if(document.getElementById('user_state').value=='')
		{
			alert('<?php _e('Please enter '.STATE_TEXT) ?>');
			document.getElementById('user_state').focus();
			return false;
		}
	<?php
	}
	?>
	<?php
	if($mandotary_info['bill_country'])
	{
	?>
		if(document.getElementById('user_country').value=='')
		{
			alert('<?php _e('Please enter '.COUNTRY_TEXT) ?>');
			document.getElementById('user_country').focus();
			return false;
		}
	<?php
	}
	?>
	<?php
	if($mandotary_info['bill_zip'])
	{
	?>
		if(document.getElementById('user_postalcode').value=='')
		{
			alert('<?php _e('Please enter '.POSTAL_CODE_TEXT) ?>');
			document.getElementById('user_postalcode').focus();
			return false;
		}
	<?php
	}
	?>
	<?php
	if($mandotary_info['bill_phone'])
	{
	?>
		if(document.getElementById('user_phone').value=='')
		{
			alert('Please enter <?php _e(PHONE_NUMBER_TEXT) ?>');
			document.getElementById('user_phone').focus();
			return false;
		}
	<?php
	}
	?>
	document.registerform.submit();
}

function showhide_forgetpw()
{
	if(document.getElementById('lostpassword_form').style.display=='none')
	{
		document.getElementById('lostpassword_form').style.display = ''
		document.getElementById('login_form_div_id').style.display = 'none';
		document.getElementById('reg_form_div_id').style.display = 'none';
		//document.getElementById('checkout_div_id').style.display = 'none';
	}else
	{
		//document.getElementById('lostpassword_form').style.display = 'none';
	}	
}
function showhide_login()
{
	if(document.getElementById('login_form_div_id').style.display=='none')
	{
		document.getElementById('login_form_div_id').style.display = ''
		document.getElementById('lostpassword_form').style.display = 'none';
		document.getElementById('reg_form_div_id').style.display = 'none';
		//document.getElementById('checkout_div_id').style.display = 'none';
	}else
	{
		//document.getElementById('login_form_div_id').style.display = 'none';
	}	
}
function showhide_registration()
{
	if(document.getElementById('reg_form_div_id').style.display=='none')
	{
		document.getElementById('reg_form_div_id').style.display = '';
		document.getElementById('lostpassword_form').style.display = 'none';
		document.getElementById('login_form_div_id').style.display = 'none';
	}else
	{
	}	
}
function showhide_checkout()
{
	if(document.getElementById('checkout_div_id').style.display=='none')
	{
		document.getElementById('checkout_div_id').style.display = '';
		document.getElementById('reg_form_div_id').style.display = 'none';
		document.getElementById('lostpassword_form').style.display = 'none';
		document.getElementById('login_form_div_id').style.display = 'none';
	}else
	{
	}	
}
</script>
<?php
if($login_invalid_error)
{
?>
<script language="javascript">showhide_login();</script>
<?php
}
if($forgot_password_error)
{
?>
<script language="javascript">showhide_forgetpw();</script>
<?php
}
if($registration_error_msg)
{
?>
<script language="javascript">showhide_registration();</script>
<?php
}
?>
<?php get_footer(); ?>