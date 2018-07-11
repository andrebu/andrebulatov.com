<?php
/*
Template Name: Product Details Page
*/
?>
<?php get_header(); ?>

 
<div id="wrapper">
    <div id="main_top"></div> <!--main top #end -->
    <div id="main_center" class="clearfix">
    
        <div id="content">        
       
    
<h1 class="head"><?php the_title(); ?></h1>
                <div class="breadcrumb clearfix">
                	<?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?>
                </div>
 
     	
		 			
                    <div class="product clearfix product_inner">
                    	
                         	<div class="pro_img"> 
                            <img src="<?php bloginfo('template_directory'); ?>/images/p_b1.png" alt=""  />
                         
                        
                            <div class="pro_thumb_img"> 
                            <a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/s1.png" alt=""   /></a>
                            <a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/s2.png" alt=""  /></a>
                            <a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/s1.png" alt=""  /></a> 
                            </div> <!-- pro thum img #end -->
                            
                            
                            </div>
                          
                                                 
                          
                          
                            
                            <div class="product_info product_details">
                                
                                <h3><a href="#">Good for me peas </a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis </p>
                                <p><strong>Price: <span class="price"> $18.99 </span></strong></p>
                                
                                
                                <div><strong>Qty :</strong> <input name="" type="text" class="textbox" /></div>
                                
                                
                                <div class="b_addtocart2"><a href="#">addtocart</a></div>
                             
                      </div>  <!-- productinfo #end -->
                        
                    
         		 </div> <!-- product #end -->
                 
                 
                   
                    
                    
                    
        
 	                    
   </div> <!-- content #end -->
 		 <?php get_sidebar(); ?>
         </div> <!-- maincenter #end-->
    <div id="main_bottom"></div> 
</div> <!-- wrapper #end -->

 <?php get_footer(); ?>
