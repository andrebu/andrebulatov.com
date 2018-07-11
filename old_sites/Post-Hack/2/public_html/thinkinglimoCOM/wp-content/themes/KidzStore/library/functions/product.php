<?php 
ob_start();
if (!class_exists('Product')) {

	class Product {
		// Class initialization
		function Product() {
		}

		function have_products()
		{
			global $wpdb;
			$productCount = 0;
           	$products = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $wpdb->posts WHERE post_status = 'publish'");
			if($products)
			{
				$productCount = $products;
			}
			return $productCount;
		}
		function get_product_price($product_id)
		{
			global $General;
			if($product_id)
			{
				$data = get_post_meta( $product_id, 'key', true );
				$price = $data['price'];
				$specialprice = $data['specialprice'];
				$spPrdLstDate = $data['spPrdLstDate'];
				if($spPrdLstDate!= ''  && $spPrdLstDate<date('Y-m-d'))
				{
					$specialprice = 0;
				}
				if($specialprice=='' || $specialprice==0 || $specialprice=='0.00')
				{
					$finalPrice = '<span class="prdprice">'.$General->get_amount_format($price) . '</span>';
				}else
				{
					$finalPrice = '<span class="specialpirce">'.$General->get_amount_format($price) . '</span>&nbsp;&nbsp;<span class="prdprice">'.$General->get_amount_format($specialprice).'</span>'; 	 
				}
				return $finalPrice;
			}		
		}
		function get_product_price_only($product_id)
		{
			global $General;
			if($product_id)
			{
				$data = get_post_meta( $product_id, 'key', true );
				return $price = $data['price'];
			}		
		}
		function get_product_price_sale($product_id)
		{
			global $General;
			if($product_id)
			{
				$data = get_post_meta( $product_id, 'key', true );
				$price = $data['price'];
				$specialprice = $data['specialprice'];
				$spPrdLstDate = $data['spPrdLstDate'];
				if($spPrdLstDate!= ''  && $spPrdLstDate<date('Y-m-d'))
				{
					$specialprice = 0;
				}

				$finalPrice = $specialprice; 	 
				return $finalPrice;
			}		
		}		
		function get_product_price_no_currency($product_id)
		{
			if($product_id)
			{
				$data = get_post_meta( $product_id, 'key', true );
				$price = $data['price'];
				$specialprice = $data['specialprice'];
				$spPrdLstDate = $data['spPrdLstDate'];
				if($spPrdLstDate!= ''  && $spPrdLstDate<date('Y-m-d'))
				{
					$specialprice = 0;
				}
				if($specialprice=='' || $specialprice==0 || $specialprice=='0.00')
				{
					$finalPrice = $price;
				}else
				{
					$finalPrice = $specialprice; 	 
				}
				return $finalPrice;
			}		
		}
		function get_product_qty($product_id)
		{
			$data = get_post_meta( $product_id, 'key', true );

			if($data['productquentity']=='0')
			{
				return "<strong>Out of Stock</strong>";
			}elseif($data['productquentity']=='')
			{
				return "<strong>Unlimited</strong>";
			}
			return $data['productquentity'];
		}
		function get_product_custom_dl($product_id,$customename,$customeId = '',$return_js='',$select_name='')
		{
			$data = get_post_meta( $product_id, 'key', true );
			if($data[$customename])
			{
				global $General;
				$attribute_ordered_count = $General->product_current_orders_count($product_id,array('attribute'=>trim(preg_replace('/[(]([+-]+)(.*)[)]/','',$data[$customename]))));
				if(!$attribute_ordered_count)
				{
					$attribute_ordered_count=0;	
				}
				//$att_str = $General->get_attribute_str($attribute_array);
				$returnarray = array();
				$customval = $data[$customename];
				$customval_stock = substr($data[$customename.'_stock'],1,strlen($data[$customename.'_stock']));
				$customval_stock_arr = explode(',',$customval_stock);
				if($customval != '')
				{
					if($customeId == '')
					{
						$customeId = $customename;
					}
					$customArr1 = explode(',',$customval);
					$dlstr = '';
					$dlstr .= '<select name="'.$customename.'" id="'.$customeId.'" onchange="checkstock(this.value)">'; 
					if($select_name=='')
					{
						$select_name = 	$customename;
					}
					$dlstr .= '<option value="">'.__($select_name).'</option>';	
					for($i=0;$i<count($customArr1);$i++)
					{
						//$cust_att =trim(preg_replace('/[(]([+-]+)(.*)[)]/','',$customArr1[$i]));
						if($customval_stock_arr[$i]!='')
						{
							$cust_stock = $customval_stock_arr[$i]-$attribute_ordered_count;
						}else
						{
							$cust_stock = '1';
						}
						//if($cust_stock>0)
						//{
							$dlstr .= '<option value="'.str_replace('"','',$customArr1[$i]).'">'.$customArr1[$i].'</option>';
						//}
						if($cust_stock<=0)
						{
							$js_string .= 'if(attval == "'.$customArr1[$i].'"){if(eval(\'document.getElementById("shoppingcart_button_1")\')){document.getElementById("shoppingcart_button_1").style.display="none";} if(eval(\'document.getElementById("shoppingcart_outofstock_msg1")\')){document.getElementById("shoppingcart_outofstock_msg1").innerHTML="this product is out of stock"}
							if(eval(\'document.getElementById("shoppingcart_button_2")\')){document.getElementById("shoppingcart_button_2").style.display="none";} if(eval(\'document.getElementById("shoppingcart_outofstock_msg2")\')){document.getElementById("shoppingcart_outofstock_msg2").innerHTML="this product is out of stock"}
							}';
						}
					}
					$dlstr .= '</select>';
				}else
				{
					$dlstr = '';
				}
			}
			if($return_js)
			{
				return $js_string;	
			}else
			{
				return $dlstr;
			}
		}
		function get_product_custom_dl_jscript($product_id,$customename_array)
		{
			$returnarray = array();
			$data = get_post_meta( $product_id, 'key', true );
			$prdprice = $this->get_product_price_no_currency($product_id);
			//$jscriptstr = '';
			//$jscriptstr .= '<script>';
			for($cust=0;$cust<count($customename_array);$cust++)
			{
				$customename = $customename_array[$cust];
				$customval = $data[$customename];	
				if($customval != '')
				{
					$customArr1 = explode(',',$customval);
					//$jscriptstr .= '
					//function '.$customename.'_set_amt("selectedval")
					//{ 
					//	alert(123);';
					for($i=0;$i<count($customArr1);$i++)
					{
						preg_match('/([+-])([a-zA-Z0-9])/', $customArr1[$i], $match2);
						$amount = preg_replace('/([+-])/','',$match2[0]);
						$symbol = preg_replace('/([0-9]*)/','',$match2[0]);
						if($symbol==''){$symbol='+';}
						$optionstr = $customArr1[$i];
						if($amount != '')
						{
							//$jscriptstr .= 'if(selectedval=="'.$optionstr.'"){';
							//$jscriptstr .= 'var prdprice = '.$prdprice.$symbol.$amount.';';
							//$jscriptstr .='}';
						}
						
					}
					//$jscriptstr .= '
					//}';
				}
			}
			//$jscriptstr .= '
			//<script>
			//';
			//echo $jscriptstr;
			$customval = $data[$customename];
			
			return $dlstr;
		}
		
	} 
	// Start this plugin once all other plugins are fully loaded
}
if(!$Product)
{
	$Product = new Product();
}
?>
