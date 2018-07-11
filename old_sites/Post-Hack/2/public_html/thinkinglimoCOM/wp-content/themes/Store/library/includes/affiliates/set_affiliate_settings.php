<?php
$wp_user_roles_arr = get_option('wp_user_roles');
if(strstr($_SERVER['REQUEST_URI'],'/themes.php'))
{
$wp_user_roles_arr['affiliate'] = array(
							"name"	=> "Affiliate",
							"capabilities" => array
												(
													"level_0" => 1,
													"read" => 1,
												)

							);
							
update_option('wp_user_roles', $wp_user_roles_arr);
}

function affiliates()
{
	if($_REQUEST['pagetype']=='addedit')
	{
		include_once(TEMPLATEPATH . '/library/includes/affiliates/admin_affiliates_frm.php');
	}else
	{
		include_once(TEMPLATEPATH . '/library/includes/affiliates/admin_affiliates.php');
	}
}

function affiliates_settings()
{
	include_once(TEMPLATEPATH . '/library/includes/affiliates/affiliates_settings.php');
}

function affiliate_report()
{
	include_once(TEMPLATEPATH . '/library/includes/affiliates/admin_affiliates_report.php');
}
?>