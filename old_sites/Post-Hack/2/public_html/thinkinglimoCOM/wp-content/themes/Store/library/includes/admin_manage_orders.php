<?php
global $wpdb,$Cart,$General;
if($_POST['submitact']=='delete')
{
	for($i=0;$i<count($_POST['list']);$i++)
	{
		$orderId = $_POST['list'][$i];
		$order_number = preg_replace('/([0-9]*([_]))/','',$orderId);
		$userId = preg_replace('/([_])([0-9]*)/','',$orderId);
		$ordersql = "select u.display_name,um.meta_value from $wpdb->usermeta as um join $wpdb->users as u on u.ID=um.user_id where um.meta_key = 'user_order_info' and um.user_id='".$userId."'";
		$orderinfo = $wpdb->get_results($ordersql);
		if($orderinfo)
		{
			foreach($orderinfo as $orderinfoObj)
			{
				$meta_value = unserialize(unserialize($orderinfoObj->meta_value)); 
				foreach($meta_value as $id=>$val)
				{
					if($val[0]['order_info']['order_id'] == $orderId)
					{
						unset($meta_value[$id]);
						///affiliate code start//
						$user_affiliate_data = get_usermeta($val[0]['affliate_info']['aid'],'user_affiliate_data');
						if($user_affiliate_data)
						{
							foreach($user_affiliate_data as $aindex=>$aval)
							{
								if($val['orderNumber']==$val[0]['order_info']['order_id'])
								{
									unset($user_affiliate_data[$aindex]);
								}
							}
							sort($user_affiliate_data);
							update_usermeta($val[0]['affliate_info']['aid'],'user_affiliate_data',$user_affiliate_data);
						}
						///affiliate code end///
					}
				}
				update_usermeta($userId, 'user_order_info', serialize($meta_value)); // Save Order Information Here
			}
		}
	}
	$ordersql = "select u.display_name,um.umeta_id,um.meta_value from $wpdb->usermeta as um join $wpdb->users as u on u.ID=um.user_id where um.meta_key = 'user_order_info'";
	$orderinfo = $wpdb->get_results($ordersql);
	if($orderinfo)
	{
		foreach($orderinfo as $orderinfoObj)
		{
			$meta_value = unserialize(unserialize($orderinfoObj->meta_value)); 
			$umeta_id = $orderinfoObj->umeta_id;
			if(count($meta_value)==0)
			{
				$user_order_sql = "delete from $wpdb->usermeta where meta_key = 'user_order_info' and umeta_id='".$umeta_id."'";
				$wpdb->query($user_order_sql);
			}else
			{
				foreach($meta_value as $id=>$val)
				{
					if($val[0]['order_info']['order_id'] == '')
					{
						$user_order_sql = "delete from $wpdb->usermeta where meta_key = 'user_order_info' and umeta_id='".$umeta_id."'";
						$wpdb->query($user_order_sql);
					}
				}
			}
		}
	}
	wp_redirect(get_option('siteurl')."/wp-admin/admin.php?page=manageorders&msg=delete");
}
?>
<script>
	function checkAll(field)
	{
	for (i = 0; i < field.length; i++)
		field[i].checked = true ;
	}
	
	function uncheckAll(field)
	{
	for (i = 0; i < field.length; i++)
		field[i].checked = false ;
	}
	
	function selectCheckBox()
	{
		field = document.getElementsByName('list[]');
		var i;
		ch	= document.getElementById('check');
		if(ch.checked)
		{
			checkAll(field);
		}
		else
		{
			uncheckAll(field);
		}
	}
	
	function recordAction()
	{
		var chklength = document.getElementsByName("list[]").length;
		var flag      = false;
		var temp	  ='';
		for(i=1;i<=chklength;i++)
		{
		   temp = document.getElementById("check_"+i+"").checked; 
		   if(temp == true)
		   {
		   		flag = true;
				break;
			}
		}
		
		if(flag == false)
		{
			alert("<?php _e('Please select atleast one record to delete.')?>");
			return false;
		}
		
		if(!confirm('<?php _e('Are you sure want to delete orders?');?>'))
		{
		 return false;
		}
		return true;
	}
 
</script>
<style>
h2 {
	color:#464646;
	font-family:Georgia, "Times New Roman", "Bitstream Charter", Times, serif;
	font-size:24px;
	font-size-adjust:none;
	font-stretch:normal;
	font-style:italic;
	font-variant:normal;
	font-weight:normal;
	line-height:35px;
	margin:0;
	padding:14px 15px 3px 0;
	text-shadow:0 1px 0 #FFFFFF;
}
</style>
<h2><?php _e('Manage Orders'); ?></h2>
<?php if($message){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php echo $message;?> </p>
</div>
<?php }?>
<table width="100%">
  <tr>
    <td><form method="post" action="<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=manageorders" name="ordersearch_frm">
        <table>
          <tr>
            <td valign="middle"><strong><?php _e('Search'); ?> : </strong></td>
            <td valign="top"><?php if ($_REQUEST['srch_orderno'])
{
	$srch_orderno=$_REQUEST['srch_orderno'];
}else
{
	$srch_orderno = 'order number';
}

?>
              <input type="text" value="<?php echo $srch_orderno;?>" name="srch_orderno" id="srch_orderno" onblur="if(this.value=='') this.value = '<?php _e('order number');?>';" onfocus="if(this.value=='<?php _e('order number');?>') this.value= '';"   /></td>
            <td valign="top"><?php
$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%' order by option_id";
$paymentinfo = $wpdb->get_results($paymentsql);
if($paymentinfo)
{
	foreach($paymentinfo as $paymentinfoObj)
	{
		$paymentInfo = unserialize($paymentinfoObj->option_value);
		$paymethodKeyarray[$paymentInfo['key']] = $paymentInfo['key'];
		ksort($paymethodKeyarray);
	}
}
?>
              <select name="srch_payment">
                <option value=""> <?php _e('Select Payment Type'); ?> </option>
                <?php
foreach($paymethodKeyarray as $key=>$value)
{
?>
                <option value="<?php echo $value;?>" <?php if($value==$_REQUEST['srch_payment']){?> selected<?php }?>><?php echo $value;?></option>
                <?php }?>
              </select></td>
            <td valign="top">&nbsp;</td>
            <td valign="top"><strong><?php _e('Order Status'); ?> :</strong>
              <select name="srch_status">
                <option value=""> <?php _e('Select Status');?> </option>
                    <option value="processing" <?php if($order_info['srch_status']=='processing'){?> selected<?php }?>><?php _e(ORDER_PROCESSING_TEXT);?></option>
                    <option value="approve" <?php if($order_info['srch_status']=='approve'){?> selected<?php }?>><?php _e(ORDER_APPROVE_TEXT);?></option>
                    <option value="reject" <?php if($order_info['srch_status']=='reject'){?> selected<?php }?>><?php _e(ORDER_REJECT_TEXT);?></option>
                    <option value="cancel" <?php if($order_info['srch_status']=='cancel'){?> selected<?php }?>><?php _e(ORDER_CANCEL_TEXT);?></option>
                    <option value="shipping" <?php if($order_info['srch_status']=='shipping'){?> selected<?php }?>><?php _e(ORDER_SHIPPING_TEXT);?></option>
                    <option value="delivered" <?php if($order_info['srch_status']=='delivered'){?> selected<?php }?>><?php _e(ORDER_DELIVERED_TEXT);?></option>
              </select></td>
            <td valign="top">&nbsp;&nbsp;
              <input type="submit" name="Search" value="<?php _e('Search'); ?>" class="button-secondary action" onclick="chkfrm();" />
              &nbsp;
              <script>
function chkfrm()
{
	if(document.getElementById('srch_orderno').value=='order number')
	{
		document.getElementById('srch_orderno').value = '';
	}
}
</script>
            </td>
            <td valign="top"><input type="button" name="Default" value="<?php _e('List All Orders'); ?>" onclick="window.location.href='<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=manageorders'" class="button-secondary action" /></td>
          </tr>
          <tr>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr>
    <td><?php
$userInfo = $General->getLoginUserInfo();
$ordersql = "select u.display_name,um.meta_value from $wpdb->usermeta as um join $wpdb->users as u on u.ID=um.user_id  where um.meta_key = 'user_order_info' ";
$ordersql .= " order by um.umeta_id asc";
$orderinfo = $wpdb->get_results($ordersql);
if($orderinfo)
{
	$myorderArray = array();
	foreach($orderinfo as $orderinfoObj)
	{
		$meta_value_arr = array();
		$meta_value = unserialize(unserialize($orderinfoObj->meta_value));
		$display_name= $orderinfoObj->display_name;
		foreach($meta_value as $oid=>$order_value)
		{
			$user_info = $order_value[0]['user_info'];
			$cart_info = $order_value[0]['cart_info'];
			$payment_info = $order_value[0]['payment_info'];
			$order_info = $order_value[0]['order_info'];
			//srch_orderno  srch_payment  srch_status
			$searchFlag1 =  1;
			$searchFlag2 =  1;
			$searchFlag3 =  1;
			if($_REQUEST['srch_orderno'])
			{
				if(strstr($order_info['order_id'],$_REQUEST['srch_orderno']))
				{
					$searchFlag1 = 1;
				}else
				{
					$searchFlag1 = 0;
				}
			}
			if($_REQUEST['srch_payment'])
			{
				if($payment_info['paydeltype']==$_REQUEST['srch_payment'])
				{
					$searchFlag2 =  1;
				}else
				{
					$searchFlag2 =  0;
				}
			}
			if($_REQUEST['srch_status'])
			{
				if($order_info['order_status']==$_REQUEST['srch_status'])
				{
					$searchFlag3 =  1;
				}else
				{
					$searchFlag3 =  0;
				}
			}
			if($searchFlag1 && $searchFlag2 && $searchFlag3)
			{
				$myorderArray[strtotime($order_info['order_date'])] = $order_value;
			}
		}
	}
}
$total_pages = count($myorderArray);
if($total_pages)
{
?>
      <form name="frmContentList1" action="" method="post">
      <input type="hidden" name="submitact" value="delete" />
        <table width="100%" cellpadding="5"  class="widefat post fixed" >
          <thead>
            <tr>
              <th width="28" ><input name="check" onClick="return selectCheckBox();" id="check" type="checkbox"></th>
              <th width="120" ><strong><?php _e('Order Number'); ?></strong></th>
              <th width="320" ><strong><?php _e('Customer Name'); ?></strong></th>
              <th width="100" ><strong><?php _e('Order Total'); ?></strong></th>
              <th width="100" ><strong><?php _e('Payment Type'); ?></strong></th>
              <th width="100" ><strong><?php _e('Date'); ?></strong></th>
              <th width="85" ><strong><?php _e('Status'); ?></strong></th>
              <th >&nbsp;</th>
            </tr>
            <?php
$targetpage = get_option('siteurl').'/wp-admin/admin.php?page=manageorders';
$recordsperpage = 30;
$pagination = $_REQUEST['pagination'];
if($pagination == '')
{
	$pagination = 1;
}
krsort($myorderArray);
$strtlimit = ($pagination-1)*$recordsperpage;
$endlimit = $strtlimit+$recordsperpage;
$myorderArray_cut = array_slice($myorderArray,$strtlimit,$endlimit);
$orderCount = 0;
foreach($myorderArray_cut as $key=>$value)
{
	$orderCount++;
	$user_info = $value[0]['user_info'];
	$cart_info = $value[0]['cart_info'];
	$payment_info = $value[0]['payment_info'];
	$order_info = $value[0]['order_info'];
	$userId = preg_replace('/([_])([0-9]*)/','',$order_info['order_id']);
	if($order_info['order_id'])
	{
?>
            <tr>
              <td align="center"><input name="list[]" id="check_<?php echo $orderCount;?>" value="<?php echo $order_info['order_id'];?>" type="checkbox"></td>
              <td><a href="<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=manageorders&oid=<?php echo $order_info['order_id'];?>"><?php echo $order_info['order_id'];?></a></td>
              <td><a href="<?php echo get_option('siteurl');?>/wp-admin/user-edit.php?user_id=<?php echo $userId;?>"><?php echo $user_info['user_name'];?></a></td>
              <td><?php echo $order_info['payable_amt'];?></td>
              <td><?php echo $payment_info['paydeltype'];?></td>
              <td><?php echo date('Y/m/d',strtotime($order_info['order_date']));?></td>
              <td><?php echo $General->getOrderStatus($order_info['order_status']);?></td>
              <td>&nbsp;</td>
            </tr>
            <?php
 	}
 }
?>
            <tr>
              <td colspan="8">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2"><input name="submit" value="<?php _e('Delete'); ?>" onclick="return recordAction();" type="submit"  class="button-secondary action" /></td>
              <td colspan="3" align="center"><?php
if($total_pages>$recordsperpage)
{
echo $General->get_pagination($targetpage,$total_pages,$recordsperpage,$pagination);
}?></td>
              <td colspan="3" align="right"><strong><?php _e('Total'); ?> : <?php echo $total_pages;?> <?php _e('orders'); ?></strong></td>
            </tr>
          </thead>
        </table>
      </form>
      <?php
}else
{
?>
      <br />
      <br />
      <p><strong><?php _e('No Orders Available'); ?></strong></p>
      <?php
}
?>
    </td>
  </tr>
</table>
