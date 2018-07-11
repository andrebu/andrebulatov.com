<?php
global $wpdb,$upload_folder_path;
if($_POST)
{
	if($_FILES['bulk_upload_csv']['name']!='' && $_FILES['bulk_upload_csv']['error']=='0')
	{
		$filename = $_FILES['bulk_upload_csv']['name'];
		$filenamearr = explode('.',$filename);
		$extensionarr = array('csv','CSV');
		if(in_array($filenamearr[count($filenamearr)-1],$extensionarr))
		{
			$destination_path = ABSPATH . $upload_folder_path."csv/";
			$dest_arr = explode('/',$upload_folder_path."csv");
			$root_pth = ABSPATH;
			for($i=0;$i<count($dest_arr);$i++)
			{
				$root_pth .= $dest_arr[$i].'/';
				if (!file_exists($root_pth))
				{
					mkdir($root_pth, 0777);				
				}
			}
			
			$target_path = $destination_path . $filename;
			$csv_target_path = $target_path;
			
			if(@move_uploaded_file($_FILES['bulk_upload_csv']['tmp_name'], $target_path)) 
			{
				$fd = fopen ($target_path, "rt");

////////////////////////////post image directory start//////////
				global $General;
				$imagecustomkeyarray = array('productimage','productimage1','productimage2','productimage3','productimage4','productimage5','productimage6','digital_product'); // custom images and digital product html key names
				$imagepath = $General->get_product_imagepath();
				if($imagepath == ''){$imagepath = 'products_img';}
				$destination_path = ABSPATH . "$upload_folder_path".$imagepath."/";
				
				if (!file_exists($destination_path))
				{
					$imagepatharr = explode('/',$imagepath);
					$upload_path = ABSPATH . "$upload_folder_path";
					if (!file_exists($upload_path))
					{
						mkdir($upload_path, 0777);
					}
					for($i=0;$i<count($imagepatharr);$i++)
					{
					  if($imagepatharr[$i])
					  {
						  $year_path = ABSPATH . "$upload_folder_path".$imagepatharr[$i]."/";
						  if (!file_exists($year_path)){
							  mkdir($year_path, 0777);
						  }     
						  mkdir($destination_path, 0777);
						}
					}
				}
				$target_path = $destination_path . $name;
				$image_user_path = get_option( 'siteurl' ) ."/$upload_folder_path".$imagepath."/";
////////////////////////////post image directory end//////////

///////////post digital product start////////////
				$digital_product_path = $General->get_digital_productpath();
				if($digital_product_path == '')
				{
					$digital_product_path = 'digital_products';
				}
				$digital_destination_path = ABSPATH . "$upload_folder_path".$digital_product_path."/";
				
				$imagepatharr = array();
				if (!file_exists($digital_destination_path)){
				  $imagepatharr = explode('/',$digital_product_path);
				   $upload_path = ABSPATH . "$upload_folder_path";
				  if (!file_exists($upload_path)){
					mkdir($upload_path, 0777);
				  }
				  for($i=0;$i<count($imagepatharr);$i++)
				  {
					  if($imagepatharr[$i])
					  {
						  $year_path = ABSPATH . "$upload_folder_path".$imagepatharr[$i]."/";
						  if (!file_exists($year_path)){
							  mkdir($year_path, 0777);
						  }     
						  mkdir($digital_product_path, 0777);
						}
				  }
			   }
				$digital_target_path = $digital_destination_path . $name;
				$digital_user_path = get_option( 'siteurl' ) ."/$upload_folder_path".$digital_product_path."/".$name;
/////////////////post digital product end////////

				$taxonomysql = "select term_taxonomy_id,term_id from $wpdb->term_taxonomy where taxonomy='category'";
				$taxonomyres = $wpdb->get_results($taxonomysql);
				$term_taxonomy_array = array();
				foreach($taxonomyres as $taxonomyObj)
				{
					$term_taxonomy_array[$taxonomyObj->term_id] = $taxonomyObj->term_taxonomy_id; 
				}
				$rowcount = 0;
				$customKeyarray = array();
				while (!feof ($fd))
				{
					$buffer = fgetcsv($fd, 4096);
					if($rowcount == 0)
					{
						for($k=3;$k<count($buffer);$k++)
						{
							$customKeyarray[$k] = $buffer[$k];
						}
					}else
					{
						$post_title = addslashes($buffer[0]);
						$post_desc = addslashes($buffer[1]);
						$post_cat_arr = explode(',',$buffer[2]); // comma seperated category name
						
						if($post_title!='')
						{
							//////////////////////////////////////////////////////////
							$post_info_arr = array();
							$catids_arr = array();
							$my_post = array();
							if($post_cat_arr)
							{
								for($c=0;$c<count($post_cat_arr);$c++)
								{
									$catids_arr[] = get_cat_ID($post_cat_arr[$c]);
								}
							}else
							{
								$catids_arr[] = 1;
							}
							$my_post['post_title'] = $post_title;
							$my_post['post_content'] = $post_desc;
							if($post_info_arr['post_author'])
							{
								$my_post['post_author'] = $post_info_arr['post_author'];
							}else
							{
								$my_post['post_author'] = 1;
							}
							$my_post['post_status'] = 'publish';
							$my_post['post_category'] = $catids_arr;
							//$my_post['tags_input'] = $post_info_arr['post_tags'];
							
							$last_postid = wp_insert_post( $my_post );
							$customArr = array();
							for($c=3;$c<count($buffer);$c++)
							{
								if(in_array($customKeyarray[$c],$imagecustomkeyarray))
								{
									if(trim($buffer[$c])!='')
									{
										if(trim($buffer[$c]) == 'digital_product')
										{
											$customArr[$customKeyarray[$c]] = $digital_user_path.addslashes($buffer[$c]);
										}else
										{
											$customArr[$customKeyarray[$c]] = $image_user_path.addslashes($buffer[$c]);
										}	
									}
								}else
								{
									$customArr[$customKeyarray[$c]] = addslashes($buffer[$c]);
								}								
							}
							$customArr['posttype'] = 'product';
							if($customArr)
							{
								update_post_meta($last_postid, 'key', $customArr);
							}
							
							//////////////////////////////////////////////////////////
						}
					}
				$rowcount++;
				}
				
				echo '<br /><div id="message" class="updated below-h2">';
				echo __("<br><br>csv uploaded successfully");
				$rowcount = $rowcount-2;
				echo __("<br><br>Total of $rowcount records inserted</b>");
				echo __(sprintf("<br><br>Upload images to %s folder.</b>",$destination_path));
				echo '<br /><br /><br /></div>';
				@unlink($csv_target_path);
			}
			else
			{
				$msg = "muerror";
			}
		}
	}else
	{
		$msg = "ferror";
	}
}
?>

<form action="<?php echo get_option('siteurl')?>/wp-admin/admin.php?page=bulkupload" method="post" name="bukl_upload_frm" enctype="multipart/form-data">
  <style>
h2 { color:#464646;font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;
font-size:24px;
font-size-adjust:none;
font-stretch:normal;
font-style:italic;
font-variant:normal;
font-weight:normal;
line-height:35px;
margin:0;
padding:14px 15px 3px 0;
text-shadow:0 1px 0 #FFFFFF;  }
</style>
  <h2><?php _e('Bulk Upload'); ?></h2>
  <?php if($_REQUEST['msg']=='exist'){?>
  <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
    <p><?php _e('Uploaded successully.'); ?></p>
  </div>
  <?php }?>
  <table width="75%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
    <tr>
      <td width="14%"><?php _e('Select CSV file'); ?></td>
      <td width="86%">:
        <input type="file" name="bulk_upload_csv" id="bulk_upload_csv"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="<?php _e('Submit'); ?>" onClick="return check_frm();" class="button-secondary action" >    </tr>
    <tr>
      <td>&nbsp;</td>
    <td>    </tr>
    <tr>
      <td colspan="2"><?php _e('You can download'); ?> <a href="<?php echo get_option('siteurl')?>/?page=csvdl"><?php _e('sample CSV file'); ?></a>    </td>
    </tr>
  </table>
</form>
<script>
function check_frm()
{
	if(document.getElementById('bulk_upload_csv').value == '')
	{
		alert("<?php _e('Please select csv file to upload');?>");
		return false;
	}
	return true;
}
</script>