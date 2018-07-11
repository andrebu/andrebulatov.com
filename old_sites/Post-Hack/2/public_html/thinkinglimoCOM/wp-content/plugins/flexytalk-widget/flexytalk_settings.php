<?php 
// return tru if $str ends with $sub



	$message="Account Settings Updated";
	if($_POST['flexytalk_hidden'] == 'Y') {
		
		$widget_id=str_replace('"','',$_POST['ft_widget_id']);
		$ft_dept=$_POST['ft_dept'];
		$installation_mode=$_POST['ft_installation_mode'];
		update_option('ft_widget_id', $widget_id);
	    update_option('ft_installation_mode', $installation_mode);
	    update_option('ft_dept', $ft_dept);
		
		?>
		<div class=<?php echo($divclass);?>><p><strong><?php echo($message ); ?></strong></p></div>
		<?php
	}
	else {

	if(get_option('ft_installation_mode')=='')
	update_option('ft_installation_mode', '1');

		$widget_id =str_replace('"','',get_option('ft_widget_id')); 

		$ft_dept = get_option('ft_dept');
	    $installation_mode = get_option('ft_installation_mode');
		
		}
	
	
?>
<div class="wrap">
<?php    echo "<h2>" . __( 'FrescoChat Settings', 'flextalk_trdom' ) ."</h2>" ?>
<form name="flexytalk_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="flexytalk_hidden" value="Y">
<p class="submit">
	
	</p>
	<table class="wc_status_table widefat" cellspacing="0">

			<thead>
				<tr>
					<th colspan="2">Activation</th>
				</tr>
			</thead>

			<tbody>
                <tr>
                    <td><input  class="button button-primary" style="width:250px" name="Submit" value="Register for a FrescoChat Account" onclick="javascript:window.open('http://www.frescochat.com/','_blank');"> </td>
                    <td><i> You can signup for a FREE 14-days trial on our Plus or Corp Plan. No credit cards required for signing up. After the trial you can renew your plan with a monthly or annual payment (discount). You can also signup for our Free plan, which doesn’t require any payment at all. </i></td>
					
                </tr>
<tr>
                     <td style="width:20%">FrescoID  </td>
                    <td><input style="width:350px" name="ft_widget_id" value="<?php echo $widget_id; ?>" style="width:100%;" id="ft_widget_id" placeholder="Enter your FrescoID" autocomplete="off" /><i>Find your FrescoID in your dashboard</i></td>
                </tr>


<thead>
				<tr>
					<th colspan="2">Point this website to one of your existing departments</th>
				</tr>
			</thead>
			<tbody>
                <tr>
				<td style="width:20%">Department Code:</td>
                    <td><input style="width:150px" name="ft_dept" value="<?php echo $ft_dept; ?>" style="width:100%;" id="ft_dept" placeholder="Department Code" autocomplete="off" /><i> (optional) Find the department code on FrescoChat Dashboard</i><br><br><br><br></td>
				</tr>
				
				</tbody>
				<thead>
				<tr>
					<th colspan="2">Installation Mode</th>
				</tr>
			</thead>
			<tbody>
                <tr>
				<td colspan="2"><input class="radio" value="1" type="radio" <?php checked( $installation_mode, '1'); ?> name="ft_installation_mode" /> <label for="ft_installation_mode">Activate FrescoChat Live Chat on all the website pages</td>
				</tr>
				<tr>
				<td colspan="2"><input class="radio" value="0" type="radio" <?php checked( $installation_mode, '0');  ?> name="ft_installation_mode" /> <label for="ft_installation_mode">Don't activate the plugin. I'll use <a href="widgets.php">FrescoChat widget</a> instead </td>
				</tr>
				</tbody>
                
               
               
             	
			

		
<thead>
				<tr>
					<th colspan="2"></th>
				</tr>
			</thead>
			<tbody>
              
					<tr>
  <td colspan="2"><strong>Please</strong>, <a href="http://wordpress.org/support/view/plugin-reviews/flexytalk-widget" target="_blank">take a moment to rate this plugin</a>, <strong>thank you!</strong></td>
					
                    
                </tr>
               
               
			</tbody>

			
		</table>

	

	<p class="submit">
	<input type="submit" class="button button-primary" name="Submit" value="<?php _e('Update Options', 'flexytalk_trdom' ) ?>" />
	</p>
</form>

</div>	 