<?php

	$name=$_REQUEST['name'];
	$email=$_REQUEST['email'];
	$phone=$_REQUEST['phone'];
	$company=$_REQUEST['company'];
	$city=$_REQUEST['city'];
	$message=$_REQUEST['message'];
	$err_check=0;
	$err_msg='';
	$err_msg2='';
	$err_check1=0;
	 
	if(isset($name) && $name ==''){//name check
	     
	    $err_msg="Please enter your name!";
	    $err_check=1;
	}
	if(isset($email) && $email ==''){//email blank check
	 
	    $err_msg.="Please enter your <b>email</b> id!";
	    $err_check=1;
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
	    $err_msg2.="Please enter your <b>Vaild-email id</b>! ($email)";
	    $err_check1=2;
	}
	 
	if(isset($phone) && $phone ==''){//phone number blank check
	 
	    $err_msg.="Please enter your <b>phone number</b> !";
	    $err_check=1;
	}
	elseif (isset($phone) && !ctype_digit($phone)) {//phone number check
	    $err_msg2.="Please enter your <b>Vaild</b> phone number ! ($phone)";
	    $err_check1=2;
	}if (isset($phone) && (strlen($phone) < 10) ) {
	     
	    $err_msg2.="Please enter your <b>Minmum 10 digits</b> phone number ! ($phone)";
	    $err_check1=2;
	     
	}
	
	if(isset($company) && $company ==''){
	 
	    $err_msg.="Please enter your <b> Company name!</b>";
	    $err_check=1;
	}

	if(isset($city) && $city ==''){
	 
	    $err_msg.="Please enter <b> the city in which you need service!</b>";
	    $err_check=1;
	}
	
	if(isset($message) && $message ==''){
	 
	    $err_msg.="Please enter your <b> Message!</b>";
	    $err_check=1;
	}
	 
	if(isset($message) && (strlen($message) < 10) ){
	 
	    $err_msg2.="Please enter <b> Min 10 characters !</b>";
	    $err_check1=2;
	}
	 
	 
	if($err_check==1 && $err_check1==2){
	    echo '<div class="notification closeable error"><p><b>Errors:'.$name.'</b> '.$err_msg.' </p></div>';
	    echo '<div class="notification closeable  warning"><p><b>Errors:'.$name.'</b> '.$err_msg2.' </p></div>';
	     
	}elseif($err_check==1){
	    echo '<div class="notification closeable error"><p><b>Errors:'.$name.'</b> '.$err_msg.' </p></div>';
	}elseif($err_check1==2){
	    echo '<div class="notification closeable  warning"><p><b>Errors:'.$name.'</b> '.$err_msg2.' </p></div>';
	}else{
	        $msg_box='';
	        $msg='<table width="50%">
	                <tr><td colspan="2"><b>MAIL HEADING</b></td></tr>
	                <tr><td><b>Name</b></td><td>'.$name.'</td></tr>
	                <tr><td><b>Email :</b></td><td>'.$email.'</td></tr>
	                <tr><td><b>Phone :</b></td><td>'.$phone.'</td></tr>
	                <tr><td><b>Company :</b></td><td>'.$company.'</td></tr>
	                <tr><td><b>City :</b></td><td>'.$city.'</td></tr>
	                <tr><td><b>Message :</b></td><td>'.$message.'</td></tr>
	                </table>';
	         
	         
	        /* To send HTML mail, you can set the Content-type header. */
	        $headers  = "MIME-Version: 1.0\r\n";
	        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	        $headers .= 'Cc: contact@thinkinglimo.com' . "\r\n";
	        /* additional headers */
	        $headers .= 'Thinking Limo Lead' . "\r\n";
	         
	         
	        $to="contact@thinkinglimo.com";
	     
	        $subject="Enquiry form Sai deepa";
	        //send mag with condation
	        if(mail($to,$subject,$msg,$headers))
	        {
	            $msg_box= '<div class="notification closeable success"><p> Success! You did it, now relax and enjoy it. </p></div>';
	        }
	        else
	        {
	            $msg_box=
	            '<div class="notification closeable warning"><p> Warning! Change this and that and try again. </p></div>';
	        }
	    echo $msg_box;
	}

?>