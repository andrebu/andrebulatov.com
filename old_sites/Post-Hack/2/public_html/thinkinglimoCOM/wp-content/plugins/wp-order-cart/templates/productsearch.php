<?php
/**
 * WP Order Cart Template for displaying Product Search Results.
 *
 * @package WordPress
 */
 
$wpordercart_default_currency = get_option("wpordercart_default_currency");
$wpordercart_default_currency_symbol = wpordercart_getsymbolfromcode($wpordercart_default_currency);

$searchquerystr = wpordercart_geturlstringvalue("s", "-1");
$skusearchstr = wpordercart_geturlstringvalue("sku", "-1");
$price_min = wpordercart_geturlstringvalue("pricemin", "-1");
$price_max = wpordercart_geturlstringvalue("pricemax", "-1");
get_header(); ?>

<div class='divproductsmain' >

<h1 style="padding-left:15px; padding-top:15px;" >Product Search</h1>
<br	/>
<?php 
	$resultsheadingstr = "";
	switch ($searchquerystr) {
		case "pricesearch":		
			$resultsheadingstr = "Showing products within the price range of <span style='font-weight:bold;' >" . $wpordercart_default_currency_symbol . " " . $price_min . "</span> and <span style='font-weight:bold;' >" . $wpordercart_default_currency_symbol . " " . $price_max . "</span>";
			break;
		default:
			if ($searchquerystr != "-1") { $resultsheadingstr = "Showing results for <span style='font-weight:bold;' >\"" . $searchquerystr . "\"</span>"; }
			break;	
	}
	
	echo "<div style='padding-left:15px;' >" . $resultsheadingstr . "</div>";

?>
<?php 

// The Query
//$the_query = new WP_Query( $args );
//$the_query = new WP_Query( array ( 'post_type' => 'products', 'orderby' => 'meta_value_num', 'meta_key' => 'price', 'order' => 'ASC' ) );

/*
custom query fields:

title
content
excerpt
sku
price

*/

/*$titlestr = strtoupper($searchquerystr);
$postids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE UCASE(post_title) LIKE '%$titlestr%'");*/

/*if ($ids) {
  $args=array(
  	'relation' => 'OR',
    'post_type' => 'products',
	//'post__in' => $ids,
	'meta_query' => array(
		'relation' => 'OR',
		array(
			'key' => 'sku',
			'value' => $searchquerystr,
			'compare' => 'LIKE'
		)
	)
  );
}
  $the_query = null;
  $the_query = new WP_Query($args);*/


/*$args = array(
	'post_type' => 'products',
	'post__in' => $postids,
	'orderby' => 'meta_value_num', 'meta_key' => 'price', 'order' => 'ASC',
	
	'meta_query' => array(
		'relation' => 'OR',
		array(
			'key' => 'price',
			'value' => array( 0, 150 ),
			'compare' => 'BETWEEN',
			'type' => 'numeric',
		),
		array(
			'key' => 'sku',
			'value' => $searchquerystr,
			'compare' => 'LIKE'
		)
	)
);*/

/*$the_query = new WP_Query($args);



//*/

if ($skusearchstr == "1") {
	$args = array(
		'post_type' => 'products',
		/*'orderby' => 'meta_value_num', 'meta_key' => 'price', 'order' => 'ASC',*/
		'meta_query' => array(
			'relation' => 'OR',
			array(
				'key' => 'sku',
				'value' => $searchquerystr,
				'compare' => 'LIKE'
			)
		)
	);
	$the_query = new WP_Query($args);
} else {
	if ($price_min != "-1" && $price_max != "-1") {
		$args = array(
			'post_type' => 'products',
			'orderby' => 'meta_value_num', 'meta_key' => 'price', 'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => 'price',
					'value' => array($price_min, $price_max),
					'compare' => 'BETWEEN',
					'type' => 'numeric',
				)
			)
		);
		$the_query = new WP_Query($args);
	} else {
		$the_query = $wp_query;
	}
}

$nuofproducts = $the_query->found_posts;

switch ($nuofproducts) {
	case 0: break;
	case 1: echo "<p style='padding-left:15px;' ><span style='font-weight:bold;' >" . 1 . "</span> product found." . "</p>"; break;
	default: echo "<p style='padding-left:15px;' ><span style='font-weight:bold;' >" . $nuofproducts . "</span> products found." . "</p>"; break;
}


//loop 
?>

<table class='tblproducts' >
	<tr>
    	<td style='width:70%;' >
			<table class='tblproductlist' >

<?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>
	
        	<tr>
            	<td>
            		<table class='tblproduct' >
        				<tr><td style='min-width:185px;' ><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2></td></tr>
	            		<tr><td style='padding:25px;' >
		<?php 
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium');
	    echo '<a class="fancybox-effects-c" href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
   	    echo get_the_post_thumbnail($post->ID, 'thumbnail'); 
        echo '</a>';
		?>
				        </td></tr>
        	        </table>
            	</td>
                <td style='text-align:left; width:100%; padding:25px;' >
                	<table class='tblproductdetails' >
                    	<tr><td><?php the_excerpt(); ?></td></tr>
                        <tr>
                        	<td style='text-align:center;' > 
								<table class='tbladdtocartform' >
                                
                                	
                                        <?php
											$skustr = get_post_meta($post->ID, "sku", true);
											if ($skustr != "") {
												echo "
									<tr>
                                    	<td style='font-weight:bold;' >SKU:&nbsp;</td>
										<td colspan='2' >" . $skustr . "</td>
									</tr>	
										";	
											}
										?>
                                        
                                    <?php
											$porstr = "<span title='Price On Request' >P.O.R.</span>";
											$wpordercart_default_currency_description = wpordercart_getdescriptionfromcode($wpordercart_default_currency);
											$wpordercart_show_price = get_option("wpordercart_show_price");	
											switch ($wpordercart_show_price) {
												case "y":
													$pricestr = get_post_meta($post->ID, "price", true);
													if ($pricestr == "") {
														$pricestr = $porstr;
													} else {
														$pricestr = "<span title='" . $wpordercart_default_currency_description . "' >" . $wpordercart_default_currency_symbol . "</span>&nbsp;" . $pricestr;	
													}
													break;
												case "por":
													$pricestr = $porstr;
													break;
											}
											if ($wpordercart_show_price != "n") {
												?>
                                    <tr>
           	                           	<td style='font-weight:bold;' >Price:&nbsp;</td>
	                                    <td colspan="2" ><?php echo $pricestr; ?></td>
									</tr>                                                    
                                                <?php
											}
										?>    
                                    <tr>
										<td style='font-weight:bold;' >Quantity:&nbsp;</td>
                                        <?php echo "
										<td><input id='txtaddtocartqty_" . $post->ID . "' type='text' value='1' class='numbersOnly' maxlength='5' style='width:25px;' />&nbsp;</td>
										<td><a id='aaddtocart_" . $post->ID . "' class='aaddtocart' href='javascript:void(0);' ><img src='" . plugins_url('/img/cart_add.png', dirname(__FILE__) ) . "' title='Add to cart' style='border:none;' /></a></td>
										"; ?>
									</tr>	
								</table>				
							</td>
                        </tr>
                    </table>    
                </td>
            </tr>
<?php endwhile; ?>
	

<?php else : ?>
	<tr><td>
    	<br />
		<h2>No products found.</h2>
	</td></tr>

	
	
<?php endif; ?>


			</table>            
		</td>
        <td style='width:30%;' >
			<table>
            	<tr>
                	<td>
						<div id="wpordercart-widget-area-1" >
							<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('wpordercart-widget-area-1')) : else : ?>
							<div class="pre-widget">
								<p><strong>Shopping Cart here</strong></p>
								<p>Please add the WPOCShoppingCartWidget to this panel from Appearance-Widgets in WP-Admin.</p>
							</div>
							<?php endif; ?>
						</div>	       	
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
				<tr>
                	<td>
						<div id="wpordercart-widget-area-2" >
							<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('wpordercart-widget-area-2'); } ?>
						</div>	       	
                    </td>
                </tr>                         
                <tr><td>&nbsp;</td></tr>
				<tr>
                	<td>
						<div id="wpordercart-widget-area-3" >
							<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('wpordercart-widget-area-3'); } ?>
						</div>	       	
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
				<tr>
                	<td>
						<div id="wpordercart-widget-area-4" >
							<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('wpordercart-widget-area-4'); } ?>
						</div>	       	
                    </td>
                </tr>                                         
            </table>    
        </td>
	</tr>        
</table>
<div class="navigation">
		<div class="next-posts"><?php next_posts_link(); ?></div>
		<div class="prev-posts"><?php previous_posts_link(); ?></div>
</div>
<br />
</div>
<?php 
	// Reset Post Data
	wp_reset_postdata();
	// Restore's the loop's post object  
    //wp_reset_query();
?>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>