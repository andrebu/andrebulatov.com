<?php
if($_POST && !$userInfo)
{
	require( 'wp-load.php' );
	require(ABSPATH.'wp-includes/registration.php');
	
	global $wpdb;
	$errors = new WP_Error();
	
	$user_email = $_POST['user_email'];
	$user_login = $user_email;
	$user_count = $wpdb->get_var("select count(ID) from $wpdb->users where user_email like \"$user_email\"");
	if($user_count>0)
	{
		//$maxuserid = $wpdb->get_var("select max(ID) from $wpdb->users");
		$user_login = str_replace('@',time().'@',$user_email);
		$user_email = $user_login;
	}
	$user_login = sanitize_user( $user_login );
	$user_email = sanitize_user( $user_login );
	
	
	// Check the username
	if ( $user_login == '' )
		$errors->add('empty_username', __('ERROR: Please enter a username.'));
	elseif ( !validate_username( $user_login ) ) {
		$errors->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.'));
		$user_login = '';
	} elseif ( username_exists( $user_login ) )
		$errors->add('username_exists', __('<strong>ERROR</strong>: '.$user_email.' This username is already registered, please choose another one.'));

	// Check the e-mail address
	if ($user_email == '') {
		$errors->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.'));
	} elseif ( !is_email( $user_email ) ) {
		$errors->add('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.'));
		$user_email = '';
	} 
	//elseif ( email_exists( $user_email ) )
		//$errors->add('email_exists', __('<strong>ERROR</strong>: '.$user_email.' This email is already registered, please choose another one.'));

	do_action('register_post', $user_login, $user_email, $errors);	
	
	$errors = apply_filters( 'registration_errors', $errors );
	if($errors)
	{
		echo "<br><br><br><br><br>";
		foreach($errors as $errorsObj)
		{
			foreach($errorsObj as $key=>$val)
			{
				for($i=0;$i<count($val);$i++)
				{
					echo "<div class=error_msg>".$val[$i].'</div>';	
				}
			} 
		}
		echo "<br><br><br>";
	}	
	if ( $errors->get_error_code() )
	{
		echo '<h6><b><a href="javascript:void(0);history.back();">Return to Checkout Page</a></b></h6>';
		exit;
	}
		
	$user_pass = wp_generate_password(12,false);
	$user_id = wp_create_user( $user_login, $user_pass, $user_email );
	
	if ( !$user_id ) {
		$errors->add('registerfail', sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !'), get_option('admin_email')));
		exit;
	}
	
		$user_phone = $_POST['user_phone'];
		$user_add1 = stripslashes(str_replace("'","&acute;",$_POST['user_add1']));
		$user_add2 = stripslashes(str_replace("'","&acute;",$_POST['user_add2']));
		$user_city = stripslashes(str_replace("'","&acute;",$_POST['user_city']));
		$user_state = stripslashes(str_replace("'","&acute;",$_POST['user_state']));
		$user_country = stripslashes(str_replace("'","&acute;",$_POST['user_country']));
		$user_postalcode = stripslashes(str_replace("'","&acute;",$_POST['user_postalcode']));
		
		$buser_add1 = stripslashes(str_replace("'","&acute;",$_POST['buser_add1']));
		$buser_add2 = stripslashes(str_replace("'","&acute;",$_POST['buser_add2']));
		$buser_city = stripslashes(str_replace("'","&acute;",$_POST['buser_city']));
		$buser_state = stripslashes(str_replace("'","&acute;",$_POST['buser_state']));
		$buser_country = stripslashes(str_replace("'","&acute;",$_POST['buser_country']));
		$buser_postalcode = stripslashes(str_replace("'","&acute;",$_POST['buser_postalcode']));
		$buser_phone = $_POST['buser_phone'];
		$user_address_info = array(
							"user_add1"		=> $user_add1,
							"user_add2"		=> $user_add2,
							"user_city"		=> $user_city,
							"user_state"	=> $user_state,
							"user_country"	=> $user_country,
							"user_postalcode"=> $user_postalcode,
							"user_phone"	 => $user_phone,
							"buser_name" 	=> stripslashes(str_replace("'","&acute;",$_POST['user_fname'])),
							"buser_add1"	=> $buser_add1,
							"buser_add2"	=> $buser_add2,
							"buser_city"	=> $buser_city,
							"buser_state"	=> $buser_state,
							"buser_country"	=> $buser_country,
							"buser_postalcode"=> $buser_postalcode,
							"buser_phone"=> $buser_phone,
							);
	update_usermeta($user_id, 'user_address_info', serialize($user_address_info)); // User Address Information Here
	update_usermeta($user_id, 'first_name', $_POST['user_fname']); // User Address Information Here
	$userName = $_POST['user_fname'];
	$updateUsersql = "update $wpdb->users set user_nicename=\"$userName\", display_name=\"$userName\"  where ID=\"$user_id\"";
	$wpdb->query($updateUsersql);
	
	//wp_new_user_notification($user_id, $user_pass);
	global $General;	
	if ( $user_id && $General->is_send_email_guest()) 
	{
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
		$client_message = '<p>Dear [#$user_name#],</p>
		<p>You can log in  with the following information:</p>
		<p>Username: [#$user_login#]</p>
		<p>Password: [#$user_password#]</p>
		<br>
		<p>We hope you enjoy your shipping. Thanks!</p>
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
		$store_login = get_option('siteurl').'/?page=login';
		/////////////customer email//////////////
		$search_array = array('[#$user_name#]','[#$user_login#]','[#$user_password#]','[#$store_name#]','[#$store_login_url#]');
		$replace_array = array($_POST['user_fname'],$user_login,$user_pass,$store_name,$store_login);
		$client_message = str_replace($search_array,$replace_array,$client_message);	
		$General->sendEmail($fromEmail,$fromEmailName,$user_email,$userName,$subject,$client_message,$extra='');///To clidne email
		//////REGISTRATION EMAIL END////////
	}
	
	$userInfoArray = array();
	$userInfoArray['ID'] = 	$user_id;
	$userInfoArray['display_name'] = 	$_POST['user_fname'];
	$userInfoArray['user_nicename'] = 	$_POST['user_fname'];
	$userInfoArray['user_email'] = 	$_POST['user_email'];
	$userInfoArray['user_id'] = 	$user_id;	
	$userInfo = $userInfoArray;
}
?>