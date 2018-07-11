<?php

   $to = 'contact@thinkinglimo.com' ;     //put your email address on which you want to receive the information
   $subject = 'Thinking Limo Lead';   //set the subject of email.
   $headers = 'MIME-Version: 1.0' . "\r\n" ;
   $headers .= "From: ".$_POST["email"]."\r\n"; 
   $headers .= "Reply-To: ".$_POST["email"]."\r\n"; 
   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
   $message = "<table style='width:600px;background:#1D2024;border:4px solid #393F45'><tbody><tr>
	            <td style='padding:5px;font-size:28px;font-family:Garamond;color:#F60'>Thinking Limo</td>
	            <td style='padding:5px;font-size:28px;color:#999'>1-888-961-6638</td>
	           </tr>
                   <tr><td style='padding:5px;padding-left:30px;color:#fff'>Your Name:</td>
                    <td style='padding:5px;color:#fff'>".$_POST['name']."</td></tr>
                   <tr><td style='padding:5px;padding-left:30px;color:#fff'>E-Mail:</td>
                    <td style='padding:5px;color:#fff'>".$_POST['email']."</td></tr>
                   <tr><td style='padding:5px;padding-left:30px;color:#fff'>Contact No:</td>
                    <td style='padding:5px;color:#fff'>".$_POST['phone']."</td></tr>
                   <tr><td style='padding:5px;padding-left:30px;color:#fff'>Company:</td>
                    <td style='padding:5px;color:#fff'>".$_POST['company']."</td></tr>
                   <tr><td style='padding:5px;padding-left:30px;color:#fff'>Service City:</td>
                    <td style='padding:5px;color:#fff'>".$_POST['city']."</td></tr> 



                   <tr><td style='padding:5px;padding-left:30px;color:#fff'>Message:</td>
                    <td style='padding:5px;color:#fff'>".$_POST['message']."</td></tr></tbody></table>" ;
   $sent = mail($to, $subject, $message, $headers);
   
 if($sent)
 {
 header("Location: http://www.thinkinglimo.com/contact-thx/");
 }
 else
 {print "We encountered an error sending your mail"; }

/*                    <tr><td style='padding:5px;padding-left:30px;color:#fff'>Contact method:</td> */
/*                     <td style='padding:5px;color:#fff'>".$_POST['contact-pref']."</td></tr>  */

?>