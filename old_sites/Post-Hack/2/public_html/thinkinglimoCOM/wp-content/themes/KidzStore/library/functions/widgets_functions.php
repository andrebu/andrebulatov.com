<?php

// Register widgetized areas
if ( function_exists('register_sidebar') ) {
    register_sidebars(1,array('name' => 'Front Page Slider','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
    register_sidebars(1,array('name' => 'Page Sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	register_sidebars(1,array('name' => 'Header Navigation','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
}
	
// Check for widgets in widget-ready areas http://wordpress.org/support/topic/190184?replies=7#post-808787
// Thanks to Chaos Kaizer http://blog.kaizeku.com/
function is_sidebar_active( $index = 1){
	$sidebars	= wp_get_sidebars_widgets();
	$key		= (string) 'sidebar-'.$index;
 
	return (isset($sidebars[$key]));
}


// =============================== Feedburner Subscribe widget ======================================
function subscribeWidget()
{
	$settings = get_option("widget_subscribewidget");

	$id = $settings['id'];
	$title = $settings['title'];
	$text = $settings['text'];
	$rss = $settings['rss'];
?>

 
   <div id="flickr">
    <div class="flickr_bottom clearfix">
    <h5><?php echo $title; ?></h5>
    <p class="subscribe"><?php echo $text; ?></p>
    <form  action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow"  onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">    
     <input type="text" class="field" onFocus="if (this.value == 'Your Email Address') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Your Email Address';}" name="email"/>
     <input type="hidden" value="<?php echo $id; ?>" name="uri"/><input type="hidden" name="loc" value="en_US"/>
      <button class="replace" type="submit" name="submit">Subscribe</button>
    </form>
     
  </div>
 </div>

<?php
}

function subscribeWidgetAdmin() {

	$settings = get_option("widget_subscribewidget");

	// check if anything's been sent
	if (isset($_POST['update_subscribe'])) {
		$settings['id'] = strip_tags(stripslashes($_POST['subscribe_id']));
		$settings['title'] = strip_tags(stripslashes($_POST['subscribe_title']));
		$settings['text'] = strip_tags(stripslashes($_POST['subscribe_text']));	
		$settings['rss'] = strip_tags(stripslashes($_POST['subscribe_rss']));
		update_option("widget_subscribewidget",$settings);
	}

	echo '<p>
			<label for="subscribe_title">Title:
			<input id="subscribe_title" name="subscribe_title" type="text" class="widefat" value="'.$settings['title'].'" /></label></p>';
	echo '<p>
			<label for="subscribe_text">Text Under Title:
			<input id="subscribe_text" name="subscribe_text" type="text" class="widefat" value="'.$settings['text'].'" /></label></p>';
	echo '<p>
			<label for="subscribe_id">Feedburner ID: (example:- templatic/eKPs)
			<input id="subscribe_id" name="subscribe_id" type="text" class="widefat" value="'.$settings['id'].'" /></label></p>';		
		
	echo '<input type="hidden" id="update_subscribe" name="update_subscribe" value="1" />';

}

register_sidebar_widget('PT &rarr; Subscribe', 'subscribeWidget');
register_widget_control('PT &rarr; Subscribe', 'subscribeWidgetAdmin', 400, 200);


// =============================== Advt 220x220px Widget ======================================
class TextWidget extends WP_Widget {
	function TextWidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Advt 220x220px', 'description' => 'Front Page Text Widget' );		
		$this->WP_Widget('widget_text', 'PT &rarr; Advt 220x220px', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$advt1 = empty($instance['advt1']) ? '' : apply_filters('widget_advt1', $instance['advt1']);
		$advt_link1 = empty($instance['advt_link1']) ? '' : apply_filters('widget_advt_link1', $instance['advt_link1']);
		$advt2 = empty($instance['advt2']) ? '' : apply_filters('widget_advt2', $instance['advt2']);
		$advt_link2 = empty($instance['advt_link2']) ? '' : apply_filters('widget_advt_link2', $instance['advt_link2']);
		 ?>
<!--<h3><?php // echo $title; ?> </h3>-->
<div class="advt">
  <?php if ( $advt1 <> "" ) { ?>
  <a href="<?php echo $advt_link1; ?>"><img src="<?php echo $advt1; ?> " alt="" /></a>
  <?php } ?>
</div>
<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['advt1'] = ($new_instance['advt1']);
		$instance['advt_link1'] = ($new_instance['advt_link1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'advt1' => '', 'advt_link1' => '', 'advt2' => '', 'advt_link2' => '' ) );		
		$title = strip_tags($instance['title']);
		$advt1 = ($instance['advt1']);
		$advt_link1 = ($instance['advt_link1']);
 ?>
<p>
  <label for="<?php echo $this->get_field_id('advt1'); ?>">Advt 1 Image Path (ex.http://pt.com/images/banner.jpg)
  <input class="widefat" id="<?php echo $this->get_field_id('advt1'); ?>" name="<?php echo $this->get_field_name('advt1'); ?>" type="text" value="<?php echo attribute_escape($advt1); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('advt_link1'); ?>">Advt 1 link
  <input class="widefat" id="<?php echo $this->get_field_id('advt_link1'); ?>" name="<?php echo $this->get_field_name('advt_link1'); ?>" type="text" value="<?php echo attribute_escape($advt_link1); ?>" />
  </label>
</p>
<?php
	}}
register_widget('TextWidget');


// =============================== Advt Sidebar 220x105px Widget ======================================
class advtwidget extends WP_Widget {
	function advtwidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Advt 220x105px', 'description' => 'widget Advt 220x105px' );		
		$this->WP_Widget('widget_advt', 'PT &rarr; Sidebar Advt 220x105px', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$advt1 = empty($instance['advt1']) ? '' : apply_filters('widget_advt1', $instance['advt1']);
		$advt_link1 = empty($instance['advt_link1']) ? '' : apply_filters('widget_advt_link1', $instance['advt_link1']);
		$advt2 = empty($instance['advt2']) ? '' : apply_filters('widget_advt2', $instance['advt2']);
		$advt_link2 = empty($instance['advt_link2']) ? '' : apply_filters('widget_advt_link2', $instance['advt_link2']);
		 ?>
<!--<h3><?php // echo $title; ?> </h3>-->
<div class="advt">
  <?php if ( $advt1 <> "" ) { ?>
  <a href="<?php echo $advt_link1; ?>"><img src="<?php echo $advt1; ?> " alt="" /></a>
  <?php } ?>
</div>
<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['advt1'] = ($new_instance['advt1']);
		$instance['advt_link1'] = ($new_instance['advt_link1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'advt1' => '', 'advt_link1' => '', 'advt2' => '', 'advt_link2' => '' ) );		
		$title = strip_tags($instance['title']);
		$advt1 = ($instance['advt1']);
		$advt_link1 = ($instance['advt_link1']);
 ?>
<p>
  <label for="<?php echo $this->get_field_id('advt1'); ?>">Advt 1 Image Path (ex.http://pt.com/images/banner.jpg)
  <input class="widefat" id="<?php echo $this->get_field_id('advt1'); ?>" name="<?php echo $this->get_field_name('advt1'); ?>" type="text" value="<?php echo attribute_escape($advt1); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('advt_link1'); ?>">Advt 1 link
  <input class="widefat" id="<?php echo $this->get_field_id('advt_link1'); ?>" name="<?php echo $this->get_field_name('advt_link1'); ?>" type="text" value="<?php echo attribute_escape($advt_link1); ?>" />
  </label>
</p>
<?php
	}}
register_widget('advtwidget');


// =============================== Contact Widget ======================================
class ContactWidget extends WP_Widget {
	function ContactWidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget contact', 'description' => 'Front Page contact' );		
		$this->WP_Widget('widget_contact', 'PT &rarr; Contact Us', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$t1 = empty($instance['t1']) ? '' : apply_filters('widget_t1', $instance['t1']);
		$t2 = empty($instance['t2']) ? '' : apply_filters('widget_t2', $instance['t2']);
 		$t4 = empty($instance['t4']) ? '' : apply_filters('widget_t4', $instance['t4']);
		$desc1 = empty($instance['desc1']) ? '' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>
  <div class="browseproducts">
     <div class="browseproducts_bottom">
  <h5> <?php echo $title; ?> </h5>
  
    <?php if ( $desc1 <> "" ) { ?>
   		<p> <?php echo $desc1; ?> </p>
    <?php } ?>
     
      <p>
        <?php if ( $t1 <> "" ) { ?>
        <span class="cfield"> Tel </span> : <?php echo $t1; ?> <br />
        <?php } ?>
        <?php if ( $t2 <> "" ) { ?>
        <span class="cfield">Email </span> : <a href="mailto:<?php echo $t2; ?>" ><?php echo $t2; ?></a><br />
        <?php } ?>
      </p>
    </div>
    </div>
 	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['t1'] = ($new_instance['t1']);
		$instance['t2'] = ($new_instance['t2']);
 		$instance['img1'] = ($new_instance['img1']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'desc1' => '' ) );		
		$title = strip_tags($instance['title']);
		$t1 = ($instance['t1']);
		$t2 = ($instance['t2']);
		$t3 = ($instance['t3']);
		$img1 = ($instance['img1']);		
		$desc1 = ($instance['desc1']);
?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">Widget Title:
  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('desc1'); ?>">Company Address
  <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('desc1'); ?>" name="<?php echo $this->get_field_name('desc1'); ?>"><?php echo attribute_escape($desc1); ?></textarea>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('t1'); ?>">Tel
  <input class="widefat" id="<?php echo $this->get_field_id('t1'); ?>" name="<?php echo $this->get_field_name('t1'); ?>" type="text" value="<?php echo attribute_escape($t1); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('t2'); ?>">Email
  <input class="widefat" id="<?php echo $this->get_field_id('t2'); ?>" name="<?php echo $this->get_field_name('t2'); ?>" type="text" value="<?php echo attribute_escape($t2); ?>" />
  </label>
</p>
<?php
	}}
register_widget('ContactWidget');

 

// =============================== Normal Widget ======================================
class NormalWidget extends WP_Widget {
	function NormalWidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Text Widget', 'description' => 'Text Widget' );		
		$this->WP_Widget('widget_normal', 'PT &rarr; Text Widget', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>
<div class="widget">
  <h3> <?php echo $title; ?> </h3>
  <?php if ( $desc1 <> "" ) { ?>
  <?php echo $desc1; ?>
  <?php } ?>
</div>
<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'desc1' => '' ) );		
		$title = strip_tags($instance['title']);
		$desc1 = ($instance['desc1']);
?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">Widget Title:
  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('desc1'); ?>">Description Here
  <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('desc1'); ?>" name="<?php echo $this->get_field_name('desc1'); ?>"><?php echo attribute_escape($desc1); ?></textarea>
  </label>
</p>
<?php
	}}
register_widget('NormalWidget');

 // =============================== Flickr widget ======================================

function flickrWidget()
{
	$settings = get_option("widget_flickrwidget");

	$id = $settings['id'];
	$number = $settings['number'];
?>
<div id="flickr">
    <div class="flickr_bottom clearfix">
    <h5>Flickr</h5>
    <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script>
	</div>
</div>            
<?php
}
function flickrWidgetAdmin() {

	$settings = get_option("widget_flickrwidget");

	// check if anything's been sent
	if (isset($_POST['update_flickr'])) {
		$settings['id'] = strip_tags(stripslashes($_POST['flickr_id']));
		$settings['number'] = strip_tags(stripslashes($_POST['flickr_number']));

		update_option("widget_flickrwidget",$settings);
	}

	echo '<p>
			<label for="flickr_id">Flickr ID (<a href="http://www.idgettr.com">idGettr</a>):
			<input id="flickr_id" name="flickr_id" type="text" class="widefat" value="'.$settings['id'].'" /></label></p>';
	echo '<p>
			<label for="flickr_number">Number of photos:
			<input id="flickr_number" name="flickr_number" type="text" class="widefat" value="'.$settings['number'].'" /></label></p>';
	echo '<input type="hidden" id="update_flickr" name="update_flickr" value="1" />';

}

register_sidebar_widget('PT &rarr; Flickr Photos', 'flickrWidget');
register_widget_control('PT &rarr; Flickr Photos', 'flickrWidgetAdmin', 250, 200);



// =============================== Latest Posts Widget (particular category) ======================================

class LatestPosts extends WP_Widget {
	function LatestPosts() {
	//Constructor
		$widget_ops = array('classname' => 'widget latest posts', 'description' => 'List of latest posts in particular category' );
		$this->WP_Widget('widget_posts1', 'PT &rarr; Latest Slider Posts', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		//echo $before_widget;
 		$category = empty($instance['category']) ? '&nbsp;' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '&nbsp;' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '&nbsp;' : apply_filters('widget_post_link', $instance['post_link']);

		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		echo '<div id="featuredproduct"><div class="featuredproductbottom clearfix"><div class="coda-slider-wrapper"><div class="coda-slider preload" id="coda-slider-1">';

		        ?>
<?php 
			        global $post;
			        $latest_menus = get_posts('numberposts='.$post_number.'postlink='.$post_link.'&category='.$category.'');
                    foreach($latest_menus as $post) :
                    setup_postdata($post);
			    ?>
<?php $button = get_post_meta($post->ID, 'button', $single = true);	?>
<?php $button_url = get_post_meta($post->ID, 'button_url', $single = true);	?>
<?php
global $General,$Product;
$image_array = $General->get_post_image($post->ID);
if($Product->get_product_price_sale($post->ID)>0)
{
	 $price =  $General->get_amount_format($Product->get_product_price_sale($post->ID));
	 
}else
{
	if($General->is_storetype_catalog())
	 {
		if($Product->get_product_price_only($post->ID)>0)
		{
			 $price =  $General->get_amount_format($Product->get_product_price_only($post->ID));	
		}
	 }else
	 {
		 $price =  $General->get_amount_format($Product->get_product_price_only($post->ID));
	 }
 }
?>



<div class="panel">
  			
			<div id="featuredproductcontent"><a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
			<p class="featuredprice"><?php echo $price;?></p>
			<p><?php echo bm_better_excerpt(150, ' ... '); ?></p>
			<div class="button1"><a href="<?php the_permalink(); ?>">View Details</a></div>
			</div>
            
            <div id="productimage">
			<div class="xsnazzy" >
				<strong class="xtop"><strong class="xb1"></strong><strong class="xb2"></strong><strong class="xb3"></strong><strong class="xb4"></strong></strong>
				<div class="xboxcontent clearfix "> <a href="<?php the_permalink(); ?>"><img src="<?php echo $image_array[0];?>" width="204" height="220" border="0" alt="" title="" /></a> </div>
				<strong class="xbottom"><strong class="xb4"></strong><strong class="xb3"></strong><strong class="xb2"></strong><strong class="xb1"></strong></strong></div></div>
		
		 
</div>


<?php endforeach; ?>
<?php

	    echo '</div></div></div></div>';

		//echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);

?>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>">Categories (<code>IDs</code> separated by commas):
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>">Number of posts:
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
  </label>
</p>
<?php
	}

}

register_widget('LatestPosts');



// =============================== Popular Posts Widget ======================================

function PopularPostsSidebar()
{

    $settings_pop = get_option("widget_popularposts");

	$name = $settings_pop['name'];
	$number = $settings_pop['number'];
	if ($name <> "") { $popname = $name; } else { $popname = 'Popular Posts'; }
	if ($number <> "") { $popnumber = $number; } else { $popnumber = '10'; }

?>
<div class="widget popular">
  <h3 class="hl"><span><?php echo $popname; ?></span></h3>
  <ul>
    <?php
			global $wpdb;
            $now = gmdate("Y-m-d H:i:s",time());
            $lastmonth = gmdate("Y-m-d H:i:s",gmmktime(date("H"), date("i"), date("s"), date("m")-12,date("d"),date("Y")));
            $popularposts = "SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS 'stammy' FROM $wpdb->posts, $wpdb->comments WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish' AND post_date < '$now' AND post_date > '$lastmonth' AND comment_status = 'open' GROUP BY $wpdb->comments.comment_post_ID ORDER BY stammy DESC LIMIT $popnumber";
            $posts = $wpdb->get_results($popularposts);
            $popular = '';
            if($posts){
                foreach($posts as $post){
	                $post_title = stripslashes($post->post_title);
		               $guid = get_permalink($post->ID);
					   
					      $first_post_title=substr($post_title,0,26);
            ?>
    <li> <a href="<?php echo $guid; ?>" title="<?php echo $post_title; ?>"><?php echo $first_post_title; ?></a> <br style="clear:both" />
    </li>
    <?php } } ?>
  </ul>
</div>
<?php
}
function PopularPostsAdmin() {

	$settings_pop = get_option("widget_popularposts");

	// check if anything's been sent
	if (isset($_POST['update_popular'])) {
		$settings_pop['name'] = strip_tags(stripslashes($_POST['popular_name']));
		$settings_pop['number'] = strip_tags(stripslashes($_POST['popular_number']));

		update_option("widget_popularposts",$settings_pop);
	}

	echo '<p>
			<label for="popular_name">Title:
			<input id="popular_name" name="popular_name" type="text" class="widefat" value="'.$settings_pop['name'].'" /></label></p>';
	echo '<p>
			<label for="popular_number">Number of popular posts:
			<input id="popular_number" name="popular_number" type="text" class="widefat" value="'.$settings_pop['number'].'" /></label></p>';
	echo '<input type="hidden" id="update_popular" name="update_popular" value="1" />';

}

register_sidebar_widget('PT &rarr; Popular Posts', 'PopularPostsSidebar');
register_widget_control('PT &rarr; Popular Posts', 'PopularPostsAdmin', 250, 200);


// =============================== Twitter widget ======================================
// Plugin Name: Twitter Widget
// Plugin URI: http://seanys.com/2007/10/12/twitter-wordpress-widget/
// Description: Adds a sidebar widget to display Twitter updates (uses the Javascript <a href="http://twitter.com/badges/which_badge">Twitter 'badge'</a>)
// Version: 1.0.3
// Author: Sean Spalding
// Author URI: http://seanys.com/
// License: GPL

function widget_Twidget_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;

	function widget_Twidget($args) {

		// "$args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys." - These are set up by the theme
		extract($args);

		// These are our own options
		$options = get_option('widget_Twidget');
		$account = $options['account'];  // Your Twitter account name
		$title = $options['title'];  // Title in sidebar for widget
		$show = $options['show'];  // # of Updates to show
		$follow = $options['follow'];  // # of Updates to show

        // Output
		echo $before_widget ;

		// start
		echo '<div class="twitter clearfix"><div class="twitter_icon"><a href="http://www.twitter.com/'.$account.'/" title="'.$follow.'">'.$title.' </a></div>';              
		echo '<div class="twitter_post"><div id="twitter">';
		echo '<ul id="twitter_update_list"><li></li></ul>
		      <script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>';
		echo '<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/'.$account.'.json?callback=twitterCallback2&amp;count='.$show.'"></script>';
		echo '</div></div></div>';
			
				
		// echo widget closing tag
		echo $after_widget;
	}

	// Settings form
	function widget_Twidget_control() {

		// Get options
		$options = get_option('widget_Twidget');
		// options exist? if not set defaults
		if ( !is_array($options) )
			$options = array('account'=>'rbhavesh', 'title'=>'Twitter Updates', 'show'=>'3');

        // form posted?
		if ( $_POST['Twitter-submit'] ) {

			// Remember to sanitize and format use input appropriately.
			$options['account'] = strip_tags(stripslashes($_POST['Twitter-account']));
			$options['title'] = strip_tags(stripslashes($_POST['Twitter-title']));
			$options['show'] = strip_tags(stripslashes($_POST['Twitter-show']));
			$options['follow'] = strip_tags(stripslashes($_POST['Twitter-follow']));
			$options['linkedin'] = strip_tags(stripslashes($_POST['Twitter-linkedin']));
			$options['facebook'] = strip_tags(stripslashes($_POST['Twitter-facebook']));
			update_option('widget_Twidget', $options);
		}

		// Get options for form fields to show
		$account = htmlspecialchars($options['account'], ENT_QUOTES);
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$show = htmlspecialchars($options['show'], ENT_QUOTES);
		$follow = htmlspecialchars($options['follow'], ENT_QUOTES);

		// The form fields
		echo '<p style="text-align:left;">
				<label for="Twitter-account">' . __('Twitter Account ID:') . '
				<input style="width: 280px;" id="Twitter-account" name="Twitter-account" type="text" value="'.$account.'" />
				</label></p>';
		echo '<p style="text-align:left;">
				<label for="Twitter-title">' . __('Title:') . '
				<input style="width: 280px;" id="Twitter-title" name="Twitter-title" type="text" value="'.$title.'" />
				</label></p>';
		echo '<p style="text-align:left;">
				<label for="Twitter-show">' . __('Show Twitter Posts:') . '
				<input style="width: 280px;" id="Twitter-show" name="Twitter-show" type="text" value="'.$show.'" />
				</label></p>';
		echo '<input type="hidden" id="Twitter-submit" name="Twitter-submit" value="1" />';
	}


	// Register widget for use
	register_sidebar_widget(array('PT &rarr; Twitter', 'widgets'), 'Widget_Twidget');

	// Register settings for use, 300x200 pixel form
	register_widget_control(array('PT &rarr; Twitter', 'widgets'), 'Widget_Twidget_control', 300, 200);
	
}
// Run code and init
add_action('widgets_init', 'widget_Twidget_init');


// =============================== Product Categories Widget ======================================
// Plugin Name: Product Categories Widget
// License: GPL



class productsWidget extends WP_Widget {
 	function productsWidget() {
 	//Constructor
 		$widget_ops = array('classname' => 'widget Product Categories', 'description' => 'List of Product Categories' );
 		$this->WP_Widget('widget_product', 'PT &rarr; Product Categories', $widget_ops);
 	}



	function widget($args, $instance) {
 		extract($args, EXTR_SKIP);
 		//echo $before_widget;
  		$category = empty($instance['category']) ? '&nbsp;' : apply_filters('widget_category', $instance['category']);
 		$post_number = empty($instance['post_number']) ? '&nbsp;' : apply_filters('widget_post_number', $instance['post_number']);
 		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
 		if($post_number == ''){ $post_number = 10;}
 		echo "&nbsp;";

?>

 <div class="browseproducts">
     <div class="browseproducts_bottom clearfix">
         <h5><?php echo $title;?></h5>
         <ul>
 <?php
 		$ex_catIdArr = get_categories('exclude=9999999' . get_inc_categories("cat_exclude_") .',1');
 		$catIdArr = array();
 		foreach($ex_catIdArr as $ex_catIdArrObj)
 		{
 			$catIdArr[] = $ex_catIdArrObj->term_id;
 		}
 		$includeCats = implode(',',$catIdArr);
 		wp_list_categories('orderby=name&title_li=&include='.$includeCats);
 		$blogCategoryIdStr = get_inc_categories("cat_exclude_");
 		$blogCategoryIdArr = explode(',',$blogCategoryIdStr);
?>
 		</ul>
       </div>
 </div>

<?php
 	}
 
	function update($new_instance, $old_instance) {
 	//save the widget
 		$instance = $old_instance;
 		$instance['title'] = strip_tags($new_instance['title']);
 		$instance['category'] = strip_tags($new_instance['category']);
 		$instance['post_number'] = strip_tags($new_instance['post_number']);
 		return $instance;
	}



	function form($instance) {
 	//widgetform in backend
 		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
 		$title = strip_tags($instance['title']);
 		$category = strip_tags($instance['category']);
 		$post_number = strip_tags($instance['post_number']);
 ?>

<p>
   <label for="<?php echo $this->get_field_id('title'); ?>">Title:
   <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
   </label>
 </p>

<?php
 	}
}

register_widget('productsWidget');