<?php
/**
 * WP Order Cart Template for displaying a single product.
 *
 * @package WordPress
 */

get_header(); ?>

<div class='divproductsmain' >

<?php

//title
if (is_post_type_archive()) {
    ?>
    <h1 style='padding:15px;' ><?php post_type_archive_title(); ?></h1>
    <?php
} else { 
	$term =	$wp_query->queried_object;
echo '<h1 style="padding:15px;" >'.$term->name.'</h1>'; }
?>
<br	/>
<?php 
//loop 
?>

<table class='tblproducts' >
	<tr>
    	<td style='width:70%;' >
			<table class='tblproductlist' >

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
        	<tr>
            	<td>
            		<table class='tblproduct' >
        				<tr><td style='min-width:285px;' ><h1><?php the_title(); ?></h1></td></tr>
	            		<tr><td style='padding:25px;' >
		<?php 
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
	    echo '<a class="fancybox-effects-c" href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
   	    echo get_the_post_thumbnail($post->ID, 'medium'); 
        echo '</a>';
		?>
				        </td></tr>
        	        </table>
            	</td>
                <td style='text-align:left; width:100%; padding:25px;' >
                	<table class='tblproductdetails' >
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
										$wpordercart_default_currency = get_option("wpordercart_default_currency");
										$wpordercart_default_currency_symbol = wpordercart_getsymbolfromcode($wpordercart_default_currency);
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
            <tr><td colspan='2' ><?php the_content(); ?></td></tr>
            <tr><td colspan='2' >
                        
<?php

$categoriesinfostr = "";  
$categoriesstr = get_the_term_list($post->ID, 'product_category', '<strong>Product Categories:&nbsp;</strong>', ', ', ''); 
if ($categoriesstr != "") {  
	$categoriesinfostr .= "$categoriesstr<br />";  
}  
if ($categoriesinfostr != "") { echo $categoriesinfostr; }  
?>  
                        
                        
                        </td></tr>
<?php endwhile; ?>
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
						<div id="wpordercart-widget-area-5" >
							<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('wpordercart-widget-area-5'); } ?>
						</div>	       	
                    </td>
                </tr>                         
                <tr><td>&nbsp;</td></tr>
				<tr>
                	<td>
						<div id="wpordercart-widget-area-6" >
							<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('wpordercart-widget-area-6'); } ?>
						</div>	       	
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
				<tr>
                	<td>
						<div id="wpordercart-widget-area-7" >
							<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('wpordercart-widget-area-7'); } ?>
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

<?php else : ?>

	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<h2>No products found.</h2>
	</div>

<?php endif; ?>
<br />
<br />
</div>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>