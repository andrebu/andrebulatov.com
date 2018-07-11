<?php
global $General,$wpdb;

function is_product($productsId)
{
	$blogCategoryIdStr = get_inc_categories("cat_exclude_");
	$blogCategoryIdArr = explode(',',$blogCategoryIdStr);
	$postCatArr = wp_get_post_categories( $post_id = $productsId);
	if(count(array_intersect($blogCategoryIdArr,$postCatArr))==0)
	{
		$editproduct = 1;
	}else
	{
		$editproduct = 0;
	}
	return $editproduct;
}

$editproduct = 0;
if($_GET['action'] == 'edit')
{
	if(is_product($_GET['post']))
	{
		$editproduct = 1;
	}
}


if($_GET['ptype']=='prd' || $_POST || $editproduct==1){

	$key = "key";
	$meta_boxes = array();
	$meta_boxes['productimage'] = 
	array(
		"name" => "productimage",
		"title" => "Product Image",
		"type" 		=> "file",
		"default" 	=> "",
		"tabindex"	=>	'2',
		"description" => "Select product main Image.");
	
	$meta_boxes['productimage1'] = 
	array(
		"name" => "productimage1",
		"title" => "Additional Image1",
		"type" 		=> "file",
		"default" 	=> "",
		"tabindex"	=>	'2',
		"description" => "Select product Additional Image 1.");
	
	$meta_boxes['productimage2'] = 
	array(
		"name" => "productimage2",
		"title" => "Additional Image2",
		"type" 		=> "file",
		"default" 	=> "",
		"tabindex"	=>	'2',
		"description" => "Select product Additional Image 2.");
	
	$meta_boxes['productimage3'] = 
	array(
		"name" => "productimage3",
		"title" => "Additional Image3",
		"type" 		=> "file",
		"default" 	=> "",
		"tabindex"	=>	'2',
		"description" => "Select product Additional Image 3.");
		
	$meta_boxes['productimage4'] = 
	array(
		"name" => "productimage4",
		"title" => "Additional Image4",
		"type" 		=> "file",
		"default" 	=> "",
		"tabindex"	=>	'2',
		"description" => "Select product Additional Image 4.");
	
	$meta_boxes['productimage5'] = 
	array(
		"name" => "productimage5",
		"title" => "Additional Image5",
		"type" 		=> "file",
		"default" 	=> "",
		"tabindex"	=>	'2',
		"description" => "Select product Additional Image 5.");
	
	$meta_boxes['productimage6'] = 
	array(
		"name" => "productimage6",
		"title" => "Additional Image6",
		"type" 		=> "file",
		"default" 	=> "",
		"tabindex"	=>	'2',
		"description" => "Select product Additional Image 6.");
	
	
	if($General->is_storetype_digital())
	{
		$meta_boxes['digital_product'] = 
		array(
			"name" => "digital_product",
			"title" => "Upload Digital Product",
			"type" 		=> "file",
			"default" 	=> "",
			"tabindex"	=>	'2',
			"description" => "Select Digital Product to upload.");	
	}
			
	$meta_boxes['price'] = 
	array(
		"name" => "price",
		"title" => "Price",
		"type" 		=> "text",
		"tabindex"	=>	'2',
		"description" => "Enter Product Original Price (price is in USD($)).");
		
	
	$meta_boxes['spPrdLstDate'] = 
	array(
		"name" => "spPrdLstDate",
		"title" => "Last Date of your Special Product",
		"type" 		=> "date",
		"tabindex"	=>	'2',
		"description" => "Last Date of your product as special product (in '<strong>YYYY-mm-dd</strong>' format only. Example :- ".date('Y-m-d')."). After this date your product will not display in the special product list.");
		
	$meta_boxes['specialprice'] = 
	array(
		"name" => "specialprice",
		"title" => "Special Price",
		"type" 		=> "text",
		"default" 	=> "0.00",
		"tabindex"	=>	'2',
		"description" => "Enter Special Price to be display (price is in USD($)).");
	
	$meta_boxes['weight'] = 
	array(
		"name" => "weight",
		"title" => "Weight",
		"type" 		=> "text",
		"default" 	=> "",
		"tabindex"	=>	'2',
		"description" => "Enter Product Weight.");
		
	$meta_boxes['istaxable'] = 
	array(
		"name" => "istaxable",
		"title" => "Is taxable?",
		"type" 		=> "checkbox",
		"default" 	=> "0",
		"tabindex"	=>	'2',
		"description" => "Select whether product is taxable or not.");
		
	$meta_boxes['size'] = 
	array(
		"name" => "size",
		"title" => "Size",
		"type" 		=> "select",
		"tabindex"	=>	'2',
		"description" => "Product is available in various Sizes.  <b>Please press <u>Set Changes</u> button to get your changes effected.</b>'");
		
	$meta_boxes['color'] = 
	array(
		"name" => "color",
		"title" => "Color",
		"type" 		=> "select",
		"tabindex"	=>	'2',
		"description" => "Product is available in various Colors. <b>Please press <u>Set Changes</u> button to get your changes effected.</b>'");
	
	$meta_boxes['size_stock'] = 
	array(
		"name" => "size_stock",
		"title" => "",
		"type" 		=> "hidden",
		"default" 	=> "",
		"tabindex"	=>	'2',
		"description" => "");
		
	$meta_boxes['color_stock'] = 
	array(
		"name" => "color_stock",
		"title" => "",
		"type" 		=> "hidden",
		"default" 	=> "",
		"tabindex"	=>	'2',
		"description" => "");
	
	$meta_boxes['is_check_outofstock'] = 
	array(
		"name" => "is_check_outofstock",
		"title" => "Is apply Stock limit?",
		"type" 		=> "checkbox",
		"default" 	=> "0",
		"tabindex"	=>	'2',
		"description" => "Check this box in order to show your product as out of stock");
		
	$meta_boxes['initstock'] = 
	array(
		"name" => "initstock",
		"title" => "Opening Stock",
		"type" 		=> "text",
		"default" 	=> "",
		"tabindex"	=>	'2',
		"description" => "Mention opening stock of this product. If the product is out of stock, keep the value as \"0\". Leave this textbox blank if you want to show the stock as unlimited.");
		
	$meta_boxes['minstock'] = 
	array(
		"name" => "minstock",
		"title" => "Low Stock Notification",
		"type" 		=> "text",
		"default" 	=> "0",
		"tabindex"	=>	'2',
		"description" => "Mention product stock here when you want to get a notification alerting you about low stock. Leave it blank if you do not need notification.");
		
	$meta_boxes['isshowstock'] = 
	array(
		"name" => "isshowstock",
		"title" => "Show available stock on your store?",
		"type" 		=> "checkbox",
		"default" 	=> "0",
		"tabindex"	=>	'2',
		"description" => "Select this if you want to show the figure of the product quantity in stock.");
		
	$meta_boxes['affiliate_link'] = 
	array(
		"name" => "affiliate_link",
		"title" => "Set Custom Affiliate URL Link",
		"type" 		=> "textarea",
		"default" 	=> "",
		"tabindex"	=>	'2',
		"description" => "For this particular product, if you want to disable your shopping cart and want to take your visitor to some other website (for example an affiliate link to Amazon.com), mention the full URL here with necessary html tags will appear on your site that will take the user to new site. <br><b>example</b> &lt;a href=&quot;http://www.amazon.com&quot; class=&quot;normal_button fl&quot; &gt; My Link Title here &lt;/a&gt;");
	
	$meta_boxes['posttype'] = 
	array(
		"name" => "posttype",
		"title" => "",
		"type" 		=> "hidden",
		"default" 	=> "product",
		"tabindex"	=>	'2',
		"description" => "");
			
	function create_meta_box() {
	global $key;
	
	if( function_exists( 'add_meta_box' ) ) {
	add_meta_box( 'new-meta-boxes', ucfirst( 'key' ) . ' -> Product Attributes', 'display_meta_box', 'post', 'normal', 'high' );
	}
	}
	
	function display_meta_box() {
	global $post, $meta_boxes, $key;
	?>

<div class="form-wrap">
  <style>
	 .tbborder {border: 1px solid #C0C0C0;}
	 table {background: #EAF3FA;}
	.form-wrap label
	{
		display:inline;
		font-weight:bold;
	}
	</style>
  <script>var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
  <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/dhtmlgoodies_calendar.js"></script>
  <link href="<?php bloginfo('template_directory'); ?>/library/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />
  <script language="javascript" type="text/javascript">
		<!--
		function toggle(o){
			var e = document.getElementById(o);
			e.style.display = (e.style.display == 'none') ? 'block' : 'none';
			}
		function deleteMe(id_ref) {
					  var theImage = document.getElementById(id_ref);
					  theImage.value = '';
					  }
		function reloadFrame(imageName) {
						parent.frames[imageName].window.location.reload();						
					} 
		function addnewone(customfieldname)
		{
			
			addCustomField(customfieldname)  
		}
		
	
	function custom_evaluate(customfield)
	{
		var equationstr = '';
		var stockstr = '';
		var count = document.getElementById(customfield+'Count').value;
		for(i=0;i<=count;i++)
		{
			equationstr1 = '';
			if(eval(document.getElementById(customfield+'_name'+i)))
			{
				var name = document.getElementById(customfield+'_name'+i).value;
				var symbol = document.getElementById(customfield+'_amsym'+i).value;
				var price = document.getElementById(customfield+'_price'+i).value;
				var stock = document.getElementById(customfield+'_stock'+i).value;
				if(name != customfield && name != '')
				{
					equationstr1 = name;
					if(price != 'price' && price != '')
					{
						equationstr1 = equationstr1 + '(' + symbol + price + ')';
					}
					if(equationstr == '')
					{
						equationstr = equationstr1;
					}else
					{
						equationstr = equationstr + ',' + equationstr1;
					}
					stockstr = stockstr + ',' + stock;
				}				
			}			
		}
		document.getElementById(customfield+'_stock').value = stockstr;
		document.getElementById(customfield).value = equationstr;
		document.getElementById(customfield+'_success_span').innerHTML = 'Success ...';
		
	}
		//-->
	</script>
  <?php
	wp_nonce_field( plugin_basename( __FILE__ ), 'key' . '_wpnonce', false, true );
	
	foreach($meta_boxes as $meta_box) {
	$data = get_post_meta($post->ID,'key', true);
	?>
  <div class="form-field form-required" <?php if($meta_box['type'] == 'hidden'){ echo 'style="display:none;"';}?> >
    <label for="<?php echo $meta_box[ 'name' ]; ?>"><?php echo $meta_box[ 'title' ]; ?></label>
    <?php
	if($meta_box['type'] == '')
	{
		$meta_box['type'] = 'text'; //set default as textbox
	}
	if($meta_box['type'] == 'hidden')
	{
		if(htmlspecialchars($data[$meta_box['name']]) !='')
		{
			$productSpPrice = htmlspecialchars($data[$meta_box['name']]);
		}else
		{
			$productSpPrice = $meta_box['default'];
		}
	?>
    <input type="hidden" id="<?php echo $meta_box[ 'name' ]; ?>" name="<?php echo $meta_box[ 'name' ]; ?>" value="<?php echo $productSpPrice; ?>" tabindex="<?php echo $meta_box[ 'tabindex' ]; ?>" />
    <?php
	}else
	if($meta_box['type'] == 'text')
	{
		if($data[$meta_box['name']] != '')
		{
			$productSpPrice = htmlspecialchars($data[$meta_box['name']]);
		}else
		{
			$productSpPrice = $meta_box['default'];
		}
	?>
    <input type="text" name="<?php echo $meta_box[ 'name' ]; ?>" value="<?php echo $productSpPrice; ?>" tabindex="<?php echo $meta_box[ 'tabindex' ]; ?>" />
    <?php
	}
	if($meta_box['type'] == 'date')
	{
		if(htmlspecialchars($data[$meta_box['name']]))
		{
			$productSpPrice = htmlspecialchars($data[$meta_box['name']]);
		}else
		{
			$productSpPrice = $meta_box['default'];
		}
	?>
    <input type="text" name="<?php echo $meta_box[ 'name' ]; ?>"  id="<?php echo $meta_box[ 'name' ]; ?>" value="<?php echo $productSpPrice; ?>" style="width:100px;" tabindex="<?php echo $meta_box[ 'tabindex' ]; ?>" />
    &nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.post.<?php echo $meta_box[ 'name' ]; ?>,'yyyy-mm-dd',this)" style="cursor: pointer;" align="absmiddle" border="0">
    <?php
	}
	elseif($meta_box['type'] == 'textarea')
	{
	?>
    <textarea tabindex="<?php echo $meta_box[ 'tabindex' ]; ?>"  name="<?php echo $meta_box[ 'name' ]; ?>"  id="<?php echo $meta_box[ 'name' ]; ?>"><?php echo htmlspecialchars( $data[ $meta_box[ 'name' ] ] ); ?></textarea>
    <?php	
	}elseif($meta_box['type'] == 'select')
	{
	?>
    <input type="hidden" id="<?php echo $meta_box[ 'name' ]; ?>" name="<?php echo $meta_box[ 'name' ]; ?>" value="<?php echo htmlspecialchars($data[$meta_box['name']]); ?>" style="width:70%;"  tabindex="<?php echo $meta_box[ 'tabindex' ]; ?>" />
	
    <br />
    <div id="<?php echo $meta_box[ 'name' ]; ?>_div"></div>
    <input name="<?php echo $meta_box[ 'name' ]; ?>Id" id="<?php echo $meta_box[ 'name' ]; ?>Id" value="" type="hidden">
    <input name="<?php echo $meta_box[ 'name' ]; ?>Title" id="<?php echo $meta_box[ 'name' ]; ?>Title" value="" type="hidden">
    <input value="1" name="<?php echo $meta_box[ 'name' ]; ?>Count" id="<?php echo $meta_box[ 'name' ]; ?>Count" type="hidden">
    <a href="javascript:void(0)" class="smallLink" onClick="<?php echo $meta_box[ 'name' ]; ?>customClick('<?php echo $meta_box[ 'name' ]; ?>','','','');">
    <input type="button" tabindex="2" name="AddNew" value="Add New" style="width:auto;" />
    </a>&nbsp;
    <input type="button" tabindex="2" name="save" value="Set Changes" style="width:auto;" onclick="custom_evaluate('<?php echo $meta_box[ 'name' ]; ?>');" />
    <span id="<?php echo $meta_box[ 'name' ]; ?>_success_span"></span>
    <?php
        $custom_evalstr .= "custom_evaluate('".$meta_box[ 'name' ]."'); ";
		?>
    <script>
       	<?php echo $meta_box[ 'name' ]; ?>Row = 1;
		function <?php echo $meta_box[ 'name' ]; ?>customClick(customfield,nameval,signval,priceval,stockval)
		{
			<?php echo $meta_box[ 'name' ]; ?>Row++;
		
			var email_div = customfield+'_div';
			var emailDiv=document.getElementById(email_div);
			var newDiv=document.createElement('div');
			newDiv.setAttribute('id',email_div+<?php echo $meta_box[ 'name' ]; ?>Row);
			newDiv.setAttribute('style','margin-top:5px');
			var newTextBox=document.createElement('input');
			
			newTextBox.type='text';
			newTextBox.setAttribute('id',customfield+'_name'+<?php echo $meta_box[ 'name' ]; ?>Row);
			newTextBox.setAttribute('name',customfield+'_name'+<?php echo $meta_box[ 'name' ]; ?>Row);
			newTextBox.setAttribute('class','textbox');
			newTextBox.setAttribute('size','15');
			newTextBox.setAttribute('maxlength','50');
			newTextBox.setAttribute('tabindex','2');
			newTextBox.setAttribute('style','width:auto');
			if(nameval){newTextBox.setAttribute('value',nameval);}else{newTextBox.setAttribute('value',customfield);}			
			newTextBox.setAttribute("onblur","if(this.value=='') this.value = '"+customfield+"';");
			newTextBox.setAttribute("onfocus","if(this.value=='"+customfield+"') this.value= '';");
			
			var newTextBox2=document.createElement('input');			
			newTextBox2.type='text';
			newTextBox2.setAttribute('id',customfield+'_price'+<?php echo $meta_box[ 'name' ]; ?>Row);
			newTextBox2.setAttribute('name',customfield+'_price'+<?php echo $meta_box[ 'name' ]; ?>Row);
			newTextBox2.setAttribute('class','textbox');
			newTextBox2.setAttribute('size','15');
			newTextBox2.setAttribute('maxlength','50');
			newTextBox2.setAttribute('tabindex','2');
			newTextBox2.setAttribute('style','width:auto');
			if(priceval){newTextBox2.setAttribute('value',priceval);}else{newTextBox2.setAttribute('value','price');};
			
			newTextBox2.setAttribute("onblur","if(this.value=='') this.value = 'price';");
			newTextBox2.setAttribute("onfocus","if(this.value=='price') this.value= '';");
			
			var newTextBox3=document.createElement('input');
			newTextBox3.type='text';
			newTextBox3.setAttribute('id',customfield+'_stock'+<?php echo $meta_box[ 'name' ]; ?>Row);
			newTextBox3.setAttribute('name',customfield+'_price'+<?php echo $meta_box[ 'name' ]; ?>Row);
			newTextBox3.setAttribute('class','textbox');
			newTextBox3.setAttribute('size','15');
			newTextBox3.setAttribute('maxlength','50');
			newTextBox3.setAttribute('tabindex','2');
			newTextBox3.setAttribute('style','width:auto');
			if(stockval){newTextBox3.setAttribute('value',stockval);}else{newTextBox3.setAttribute('value','');};
			
			
			comboNameArr = new Array('+','-');
			comboValueArr = new Array('+','-');
			
			var newComboBox = document.createElement('select');
			newComboBox.name = customfield+'_amsym'+<?php echo $meta_box[ 'name' ]; ?>Row;
			newComboBox.setAttribute('id',customfield+'_amsym'+<?php echo $meta_box[ 'name' ]; ?>Row);
			newComboBox.setAttribute('tabindex','2');
			newComboBox.setAttribute('class','textbox');
			
			for(i=0;i<comboNameArr.length;i++)
			{
				comboOptions = document.createElement('option');
				
				comboOptions.text = comboNameArr[i];
				comboOptions.value = comboValueArr[i];
				if(comboValueArr[i] == signval)
				{
					comboOptions.setAttribute('selected','selected');
				}
				newComboBox.appendChild(comboOptions);
			}
			
			nameStr = document.getElementById(customfield+'Title').value;
			valueStr = document.getElementById(customfield+'Id').value;
			
			if(nameStr!="" && valueStr!="")
			{
				comboNameArr1 = nameStr.split(",");
				comboValueArr1 = valueStr.split(",");
				
				for(j=0;j<comboNameArr1.length;j++)
				{
					comboOptions = document.createElement('option');
				
					comboOptions.text = comboNameArr1[j];
					comboOptions.value = comboValueArr1[j];
					//newComboBox.appendChild(comboOptions);
					try {
					newComboBox.add(comboOptions, null); //Standard
					}catch(error) {
					newComboBox.add(comboOptions); // IE only
					}
				}
			}	
			
			var newLink = document.createElement('a');
			newLink.setAttribute('class','smallLink');
			newLink.setAttribute('href','javascript:void(0)');
			newLink.setAttribute('tabindex','2');
			
			document.getElementById('<?php echo $meta_box[ 'name' ]; ?>Count').value = <?php echo $meta_box[ 'name' ]; ?>Row;
			
			var linkText=document.createTextNode('Remove');
			newLink.appendChild(linkText);
			newLink.onclick=function RemoveEntry() { var imDiv=document.getElementById(email_div);
		
			emailDiv.removeChild(this.parentNode);	
			}
		
			newDiv.appendChild(newTextBox);
			newDiv.appendChild(document.createTextNode('\u00A0\u00A0\u0040\u00A0\u00A0'));
			newDiv.appendChild(newComboBox);
			newDiv.appendChild(document.createTextNode('\u00A0\u00A0\u00A0'));
			newDiv.appendChild(newTextBox2);
			newDiv.appendChild(document.createTextNode('\u00A0\u00A0'));
			newDiv.appendChild(document.createTextNode('\u00A0\u0053\u0074\u006F\u0063\u006B\u00A0'));
			newDiv.appendChild(newTextBox3);
			newDiv.appendChild(newLink);
			emailDiv.appendChild(newDiv);
		}
       <?php
	   	$customValue = htmlspecialchars($data[$meta_box['name']]);
      	$customValueArr = explode(',',$customValue);
		if($customValueArr)
		{
			for($i=0;$i<count($customValueArr);$i++)
			{
				$counter = $i+2;
				$name = html_entity_decode(preg_replace('/([(])([+-]+)(.*)/','',$customValueArr[$i]));
				preg_match('/([+-])/', $customValueArr[$i], $match2);
				$symbol = $match2[0];
				preg_match('/([+-])(.*)/', $customValueArr[$i], $match3);
				$price = substr($match3[0],1,strlen($match3[0])-2);
			
			$stock_customValue = htmlspecialchars($data[$meta_box['name'].'_stock']);
			
			$stock = '';
			$stock_customValue = substr($stock_customValue,1,strlen($stock_customValue));
			$stock_val_arr = explode(',',$stock_customValue);
			$stock = $stock_val_arr[$i];
			?>
			<?php echo $meta_box[ 'name' ]; ?>customClick('<?php echo $meta_box[ 'name' ]; ?>','<?php echo $name;?>','<?php echo $symbol;?>','<?php echo $price;?>','<?php echo $stock;?>');
			<?php 
			}
		}
		?>
	    </script>
    <?php
	}elseif($meta_box['type'] == 'checkbox')
	{
		if(htmlspecialchars($data[$meta_box['name']]) == 'on') { $checked = 'checked="checked"';} else {$checked='';}
	?>
    <input type="checkbox" name="<?php echo $meta_box[ 'name' ]; ?>" <?php echo $checked; ?> style="width:auto" tabindex="<?php echo $meta_box[ 'tabindex' ]; ?>"  />
    <?php
	}elseif($meta_box['type'] == 'radio')
	{
	
	}elseif($meta_box['type'] == 'file')
	{
	?>
    <input type="text" id="<?php echo $meta_box[ 'name' ]; ?>" name="<?php echo $meta_box[ 'name' ]; ?>" value="<?php echo htmlspecialchars( $data[ $meta_box[ 'name' ] ] ); ?>" style="width:30%;"  tabindex="<?php echo $meta_box[ 'tabindex' ]; ?>" />
    <?php if(htmlspecialchars( $data[ $meta_box[ 'name' ] ] )) 
	{
	?>
    <img src="<?php echo htmlspecialchars( $data[ $meta_box[ 'name' ] ] );?>" width="40"  />
    <?php
	}
	?>
    OR
    <!--<input  type="button" name="button" value="Upload" onclick="toggle('<?php // echo $meta_box[ 'name' ]; ?>_div');" style="width:auto;" tabindex="<?php // echo $meta_box[ 'tabindex' ]; ?>"  />-->
    <style>

#upload_target
{
	 width:				100%;
	 height:			80px;
	 text-align: 		center;
	 border:			none;
	 background-color: 	#fff;	
	 margin:			0px auto;
}


.iframe { float:right; width:50%; margin-top:0; _margin-top:-28px; }
*+html .iframe { float:right; width:50%; margin-top:-28px; }

</style>
    <?php /*?><div id="<?php echo $meta_box[ 'name' ]; ?>_div" style="display:none; background-color:#CCCCCC;"><?php */?>
    <div id="<?php echo $meta_box[ 'name' ]; ?>_div" class="iframe" >
      <iframe name="mktlogoframe" id="upload_target" style="border: none; width:100%; height: 75px;" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" src="<?php echo bloginfo('template_url');?>/upload/index.php?img=<?php echo $meta_box[ 'name' ]; ?>&nonce=mktnonce" ></iframe>
    </div>
    <?php
	}
	?>
    <p><?php echo $meta_box[ 'description' ]; ?></p>
  </div>
  <?php } ?>
  <?php /*?><?php
    if($custom_evalstr)
	{
	?>
  <script>
     $(function(){
            
            $("#post").submit(function(){
                dataString = $("#post").serialize();
                <?php echo $custom_evalstr;?>
            });
        });
        </script>
  <?php
    }
	?><?php */?>
</div>
<?php
	}
	
	function save_meta_box( $post_id ) {
	global $post, $meta_boxes, $key;
	
	foreach( $meta_boxes as $meta_box ) {
	$data[ $meta_box[ 'name' ] ] = $_POST[ $meta_box[ 'name' ] ];
	}
	
	if ( !wp_verify_nonce( $_POST['key' . '_wpnonce' ], plugin_basename(__FILE__) ) )
	return $post_id;
	
	if ( !current_user_can( 'edit_post', $post_id ))
	return $post_id;
	
	update_post_meta( $post_id, 'key', $data );
	}
	
	add_action( 'admin_menu', 'create_meta_box' );
	add_action( 'save_post', 'save_meta_box' );
}

////////////post listing field changes start ////////////////////
	add_action('load-edit.php', 'filtering');
	
	
	function get_blog_sub_cats_str($type='array')
	{
		$catid_str =  get_inc_categories("cat_exclude_");
		if($catid_str)
		{
			$catid_arr = explode(',',$catid_str);	
		}
		$blogcatids = '';
		$subcatids_arr = array();
		if($catid_arr){
			for($i=0;$i<count($catid_arr);$i++)
			{
				if($catid_arr[$i])
				{
					$subcatids_arr = array_merge($subcatids_arr,array($catid_arr[$i]),get_term_children( $catid_arr[$i],'category'));
				}
			}
		}
		if($subcatids_arr && $type=='string')
		{
			$blogcatids = implode(',',$subcatids_arr);
			return $blogcatids;	
		}else
		{
			return $subcatids_arr;
		}			
	}
	function filtering() {
		add_filter('posts_where', 'product_filter_join');
		add_action('restrict_manage_posts', 'search_manage_posts');
	}
	
	function product_filter_join($where) {
		global $wpdb;
	
		if( $_REQUEST['ptype'] == 'prd' ) {
			$blog_Cat = get_blog_sub_cats_str('string');
			if($blog_Cat){
			$where .= " and $wpdb->posts.ID not in (select $wpdb->term_relationships.object_id from $wpdb->term_relationships join $wpdb->term_taxonomy on $wpdb->term_relationships.term_taxonomy_id=$wpdb->term_taxonomy.term_taxonomy_id where term_id in ($blog_Cat))";
			}
		} 
		return $where;
	}
	
	function search_manage_posts() {
		?>
<select name='ptype' id='ptype' class='postform'>
  <option value="0">
  <?php _e('View all posts and products') ?>
  </option>
  <option value="prd" <?php if( isset($_GET['ptype']) && $_GET['ptype']=='prd') echo 'selected="selected"' ?>>
  <?php _e('View only products'); ?>
  </option>
</select>
<?php 
	} 


add_filter('manage_posts_columns', 'product_custom_columns');
function product_custom_columns($defaults)
{  //lets remove some un-needed columns if it's a post
	if($_GET['ptype']=='prd')
	{
		global $General;
		unset($defaults['date']);
		unset($defaults['comments']);
		unset($defaults['author']);
		unset($defaults['tags']);
		$defaults['price'] = __('Price').'('.$General->get_currency_symbol().')';
		$defaults['istaxable'] = __('Is Taxable');
		$defaults['initstock'] = __('Stock');
		$defaults['pli'] = __('Main Image');
		if($General->is_storetype_digital())
		{
			$defaults['digprd'] = __('Digital Product');
		}
		$defaults['thumbs'] = __('Thumbnails');
	}else
	{
		 $defaults['isproduct'] = __('Is Product');  //ad the product column to the normal post lists
	}
	return $defaults;
}

add_action('manage_posts_custom_column', 'custom_column', 10, 2);
function custom_column($column_name, $post_id)
{   //defines what goes in the new columns
	global $wpdb,$General;
	$data = get_post_meta( $post_id, 'key', true );
	if( $column_name == 'isproduct' )
	{
		if(is_product($post_id))
		{
			echo "<center><font style=\"color:#006600;\"> ".__('Yes')."</font></center>";
		}else
		{
			echo "<center><font style=\"\"> ".__('No')."</font></center>";
		}
	}
	if( $column_name == 'price' )
	{
		echo $General->get_amount_format($data['price'],0);
	}
	if( $column_name == 'istaxable' )
	{
		if($data['istaxable']!='')
		{
			echo "<font style=\"color:#006600;\">  ".__('Yes')."</font>";
		}else
		{
			echo "<font style=\"\">  ".__('No')."</font>";
		}
	}
	if( $column_name == 'initstock' )
	{
		if($data['initstock']=='')
		{
			echo "Unlimited";
		}elseif($data['initstock']=='0')
		{
			echo "Out of Stock";
		}else
		{
			echo $General->product_current_orders_count($post_id).'/'.number_format($data['initstock']);
		}
	}
	if( $column_name == 'pli' )
	{
		if($data['productimage'])
		{
			echo "<a href=\"".$data['productimage']."\" target=_blank title=\"View Large Image\" ><font style=\"color:#006600;\"> ".__('Yes')."</font></a>";
		}else
		{
			echo "<center><font style=\"\"> ".__('No')."</font>";
		}
	}
	if($General->is_storetype_digital())
	{
		if( $column_name == 'digprd' )
		{
			if($data['digital_product'])
			{
				echo "<a href=\"".$data['digital_product']."\" target=_blank title=\"Download/Check Product\" ><font style=\"color:#006600;\"> ".__('Yes')."</font></a>";
			}else
			{
				echo "<font style=\"\"> ".__('No')."</font>";
			}
		}
	}
	if( $column_name == 'thumbs' )
	{
		if($data['productimage1'])
		{
			echo "<a href=\"".$data['productimage1']."\" target=_blank title=\"View Large Image\" ><font style=\"\"> IMG1 </font></a>";
		}else
		{
			//echo "<font style=\"color:#FF0000; font-weight:bold;\"> IMG1  </font>";
		}
		if($data['productimage2'])
		{
			echo "<a href=\"".$data['productimage2']."\" target=_blank title=\"View Large Image\" ><font style=\"\"> IMG2 </font></a>";
		}else
		{
			//echo "<font style=\"color:#FF0000; font-weight:bold;\"> IMG2  </font>";
		}
		if($data['productimage3'])
		{
			echo "<a href=\"".$data['productimage3']."\" target=_blank title=\"View Large Image\" ><font style=\"\"> IMG3 </font></a>";
		}else
		{
			//echo "<font style=\"color:#FF0000; font-weight:bold;\"> IMG3  </font>";
		}
		if($data['productimage4'])
		{
			echo "<a href=\"".$data['productimage4']."\" target=_blank title=\"View Large Image\" ><font style=\"\"> IMG4 </font></a>";
		}else
		{
			//echo "<font style=\"color:#FF0000; font-weight:bold;\" title=\"View Large Image\"> IMG4 </font>";
		}
		if($data['productimage5'])
		{
			echo "<a href=\"".$data['productimage5']."\" target=_blank ><font style=\"\"> IMG5 </font></a>";
		}else
		{
			//echo "<font style=\"color:#FF0000; font-weight:bold;\" title=\"View Large Image\"> IMG5</font>";
		}
	}
	 
	 $plugin_path = get_bloginfo('wpurl') . '/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/';
     if( $column_name == 'pli' ) { $title = "Main image not found. Edit product to insert.";}
     if( $column_name == 'thumbs' ) {$title = "Thumnail not found. Edit product to insert.";}
     $error = ' <img src="'.$plugin_path.'imgs/error.png" title="'.$title.'"/>';
   
}
////////////post listing field changes end ////////////////////

////////////DASHBOARD CUSTOM WIDGETS START/////
/**
 * Content of Dashboard-Widget
 */
function my_shoppingcart_summary() 
{
	global $General;
	$orderInfoArr = $General->get_total_orders();
	$currentMonthOrders = $orderInfoArr[0];
	$AllOrders = $orderInfoArr[1];
	$totalOrders = 0;
	$totalOrders_currenmonth = 0;
	$processingOrders_currentmonth = count($currentMonthOrders['processing']);
	$processingOrders = count($AllOrders['processing']);
	$approveOrders_currentmonth = count($currentMonthOrders['approve']);
	$approveOrders = count($AllOrders['approve']);
	$rejectOrders_currentmonth = count($currentMonthOrders['reject']);
	$rejectOrders = count($AllOrders['reject']);
	$cancelOrders_currentmonth = count($currentMonthOrders['cancel']);
	$cancelOrders = count($AllOrders['cancel']);
	$shippingOrders_currentmonth = count($currentMonthOrders['shipping']);
	$shippingOrders = count($AllOrders['shipping']);
	$deliveredOrders_currentmonth = count($currentMonthOrders['delivered']);
	$deliveredOrders = count($AllOrders['delivered']);
	foreach($currentMonthOrders as $key=>$value)
	{
		$totalOrders = $totalOrders + count($currentMonthOrders[$key]);
	}
	foreach($AllOrders as $key1=>$value1)
	{
		$totalOrders_currenmonth = $totalOrders_currenmonth + count($AllOrders[$key1]);
	}
	$currentmonth = date('m');
	
?>
<table border="0" cellspacing="8" cellpadding="0">
  <tr>
    <td width="140">&nbsp;</td>
    <td width="110" align="center"><strong>Current  Month </strong></td>
    <td width="90" align="center"><strong>Up to 
      Date</strong></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="25%">Products</td>
    <td align="center"><a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/edit.php?ptype=prd&month=$currentmonth";?>"><?php echo $General->get_total_products(date('m'));?></a></td>
    <td align="center"><a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/edit.php?ptype=prd";?>"><?php echo $General->get_total_products();?></a></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="25%">Total Orders</td>
    <td align="center"><?php if($totalOrders){?>
      <a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders&month=$currentmonth";?>">
      <?php }?>
      <?php echo $totalOrders;?>
      <?php if($totalOrders){?>
      </a>
      <?php }?></td>
    <td align="center"><?php if($totalOrders_currenmonth){?>
      <a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders";?>">
      <?php }?>
      <?php echo $totalOrders_currenmonth;?>
      <?php if($totalOrders_currenmonth){?>
      </a>
      <?php }?></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="25%">Processing Orders</td>
    <td align="center"><?php if($processingOrders_currentmonth){?>
      <a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders&month=$currentmonth&srch_status=processing";?>">
      <?php }?>
      <?php echo $processingOrders_currentmonth;?>
      <?php if($processingOrders_currentmonth){?>
      </a>
      <?php }?></td>
    <td align="center"><?php if($processingOrders){?>
      <a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders&srch_status=processing";?>">
      <?php }?>
      <?php echo $processingOrders;?>
      <?php if($processingOrders){?>
      </a>
      <?php }?></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="25%">Approve Orders</td>
    <td align="center"><?php if($approveOrders_currentmonth){?>
      <a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders&month=$currentmonth&srch_status=approve";?>">
      <?php }?>
      <?php echo $approveOrders_currentmonth;?>
      <?php if($approveOrders_currentmonth){?>
      </a>
      <?php }?></td>
    <td align="center"><?php if($approveOrders_currentmonth){?>
      <a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders&srch_status=approve";?>">
      <?php }?>
      <?php echo $approveOrders;?>
      <?php if($approveOrders_currentmonth){?>
      </a>

      <?php }?></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="25%">Rejected Orders</td>
    <td align="center"><?php if($rejectOrders_currentmonth){?>
      <a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders&month=$currentmonth&srch_status=reject";?>">
      <?php }?>
      <?php echo $rejectOrders_currentmonth;?>
      <?php if($rejectOrders_currentmonth){?>
      </a>
      <?php }?></td>
    <td align="center"><?php if($rejectOrders){?>
      <a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders&srch_status=reject";?>">
      <?php }?>
      <?php echo $rejectOrders;?>
      <?php if($rejectOrders){?>
      </a>
      <?php }?></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="25%">Cancel Orders</td>
    <td align="center"><?php if($cancelOrders_currentmonth){?>
      <a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders&month=$currentmonth&srch_status=cancel";?>">
      <?php }?>
      <?php echo $cancelOrders_currentmonth;?>
      <?php if($cancelOrders_currentmonth){?>
      </a>
      <?php }?></td>
    <td align="center"><?php if($cancelOrders){?>
      <a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders&srch_status=cancel";?>">
      <?php }?>
      <?php echo $cancelOrders;?>
      <?php if($cancelOrders){?>
      </a>
      <?php }?></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="25%">Shipping Orders</td>
    <td align="center"><?php if($shippingOrders_currentmonth){?>
      <a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders&month=$currentmonth&srch_status=shipping";?>">
      <?php }?>
      <?php echo $shippingOrders_currentmonth;?>
      <?php if($shippingOrders_currentmonth){?>
      </a>
      <?php }?></td>
    <td align="center"><?php if($shippingOrders){?>
      <a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders&srch_status=shipping";?>">
      <?php }?>
      <?php echo $shippingOrders;?>
      <?php if($shippingOrders){?>
      </a>
      <?php }?></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="25%">Complete Orders</td>
    <td align="center"><?php if($deliveredOrders_currentmonth){?>
      <a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders&month=$currentmonth&srch_status=delivered";?>">
      <?php }?>
      <?php echo $deliveredOrders_currentmonth;?>
      <?php if($deliveredOrders_currentmonth){?>
      </a>
      <?php }?></td>
    <td align="center"><?php if($deliveredOrders){?>
      <a href="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders&srch_status=delivered";?>">
      <?php }?>
      <?php echo $deliveredOrders;?>
      <?php if($deliveredOrders){?>
      </a>
      <?php }?></td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<?php	
}
 
 function my_orders_summary()
 {
 	global $General;
	$dashboard_orders =$General->get_dashboard_display_orders();
	if(!is_int($dashboard_orders) || $dashboard_orders<0)
	{
		$dashboard_orders = 10;
	}
	$orders = $General->get_total_orders_bydate();
	krsort($orders);
	$orders_array = array_slice($orders,0,$dashboard_orders);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="8" >
  <?php
if($orders_array && count($orders_array)>0){
?>
  <tr>
    <td width="80" ><strong><?php _e('Order Number');?></strong></td>
    <td align="center" width="120" ><strong><?php _e('Date');?></strong></td>
    <td width="120"><strong><?php _e('Bill Amount');?></strong></td>
    <td ><strong><?php _e('Status');?></strong></td>
  </tr>
  <?php
for($o=0;$o<count($orders_array);$o++)
{
?>
  <tr>
    <td ><a href="<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=manageorders&oid=<?php echo $orders_array[$o]['order_id'];?>"><?php echo $orders_array[$o]['order_id'];?></a></td>
    <td align="center"><?php echo date('Y/m/d',strtotime($orders_array[$o]['order_date']));?></td>
    <td><?php echo $orders_array[$o]['payable_amt'];?></td>
    <td><?php echo $General->getOrderStatus($orders_array[$o]['order_status']);?></td>
  </tr>
  <?php }}else{?>
  <tr>
    <td colspan="4"><BR />
      <BR />
      <BR />
      <strong><?php _e('Sorry, Not a single order is there');?></strong><BR />
      <BR />
      <BR /></td>
  </tr>
  <?php }?>
</table>
<?php
 }
/**
 * add Dashboard Widget via function wp_add_dashboard_widget()
 */
function my_wp_dashboard_setup() 
{
	global $General;
	wp_add_dashboard_widget( 'my_shoppingcart_summary', __( 'Shopping Cart Summary' ), 'my_shoppingcart_summary' );
	if($General->get_dashboard_display_orders() != '' || $General->get_dashboard_display_orders()>0)
	{
		wp_add_dashboard_widget( 'my_orders_summary', __( 'Latest Order List' ), 'my_orders_summary' );
	}
}
 
/**
 * use hook, to integrate new widget
 */
if ( current_user_can( 'edit_post', $post_id ))
{
add_action('wp_dashboard_setup', 'my_wp_dashboard_setup');
}
///////////DASHBOARD CUSTOM WIDGETS END/////////
?>