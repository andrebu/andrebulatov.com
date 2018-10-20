<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');    
  $instaAPI = file_get_contents("https://api.instagram.com/v1/users/884494772/?access_token=884494772.467ede5.1245ae48d2804488985e906cdf838c10");
//  echo json_encode($instaAPI);
  echo $instaAPI;
?>
