<?php
$lkey = $_REQUEST['lkey'];
$aid = $_REQUEST['aid'];
$affiliate_links = get_option('affiliate_links');
if($affiliate_links)
{
	foreach($affiliate_links as $key=>$affiliate_links_Obj)
	{
		if($affiliate_links_Obj['link_key'] == $lkey)
		{
			$affiliate_settings = get_option('affiliate_settings');
			if($affiliate_settings['affiliate_cookie_lifetime']>0)
			{
				$alive_time = $affiliate_settings['affiliate_cookie_lifetime'];
				if($alive_time)
				{
					$alive_time  = $alive_time * 24 * 60 * 60;
				}
			}
			else
			{
				$alive_time  = 1 * 24 * 60 * 60;
			}
			$settings = $aid.'|'.$lkey;
			setcookie( 'affiliate-settings', $settings, time() + $alive_time, SITECOOKIEPATH,COOKIE_DOMAIN );
			wp_redirect($affiliate_links_Obj['link_url']);
			exit;
		}
	}
}
if($_REQUEST['report_detail'])
{
	include_once(TEMPLATEPATH . '/library/includes/affiliates/affiliate_sale_report.php');
	exit;
}
if($_REQUEST['report_export'])
{
	include_once(TEMPLATEPATH . '/library/includes/affiliates/export_report.php');
	exit;
}
if($_REQUEST['report_export_current'])
{
	include_once(TEMPLATEPATH . '/library/includes/affiliates/export_report_current.php');
	exit;
}

?>