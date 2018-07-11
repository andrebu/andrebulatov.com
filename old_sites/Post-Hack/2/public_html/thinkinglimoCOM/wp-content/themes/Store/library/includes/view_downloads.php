 <h3><?php _e('My Downloads'); ?></h3>
        <table width="100%" class="table">
          <tr>
            <td width="100" class="title"><?php _e('Order Number'); ?></td>
            <td class="title"><?php _e('Products'); ?></td>
          </tr>
          <?php
			$ordersql = "select meta_value from $wpdb->usermeta where meta_key = 'user_order_info' and user_id='".$userInfo['ID']."'";
			$orderinfo = $wpdb->get_results($ordersql);
			if($orderinfo)
			{
			?>
          <?php
				foreach($orderinfo as $orderinfoObj)
				{
					$meta_value_arr = array();
					$meta_value = unserialize(unserialize($orderinfoObj->meta_value));
					if(count($meta_value))
					{
						for($i=0;$i<count($meta_value);$i++)
						{
							$user_info = $meta_value[$i][0]['user_info'];
							$cart_info = $meta_value[$i][0]['cart_info'];
							$payment_info = $meta_value[$i][0]['payment_info'];
							$order_info = $meta_value[$i][0]['order_info'];
							if($order_info['order_status'] == 'approve' || $order_info['order_status'] == 'delivered')
							{
								for($d=0;$d<count($cart_info['cart_info']);$d++)
								{
									//echo $cart_info['cart_info'][$d]['product_id'];
									//echo $cart_info['cart_info'][$d]['product_name'];
									$data = get_post_meta( $cart_info['cart_info'][$d]['product_id'], 'key', true );
									$digital_product = $data[ 'digital_product' ];
						if($data){
						?>
          <tr>
            <td class="row1"><?php echo $order_info['order_id'];?></td>
            <td class="row1">
            <?php if($digital_product){?>
            <a href="<?php echo $digital_product;?>" target="_blank"><?php echo $cart_info['cart_info'][$d]['product_name'];?> (<strong><?php _e('download');?></strong>)</a>
            <?php }else{?>
            <a href="#"><?php _e('no product to download');?></a>
            <?php }?>
           <?php /*?> <a href="<?php echo get_option('siteurl');?>/?page=download&id=<?php echo $order_info['order_id'];?>&pid=<?php echo $cart_info['cart_info'][$d]['product_id'];?>"><?php echo $cart_info['cart_info'][$d]['product_name'];?></a><?php */?>
            </td>
           
          </tr>
          <?php			}
								}
							}
						}
					}
				}
			}
		?>
          <tr>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>