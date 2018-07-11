<?php

$options[] = array(	"type" => "maintabletop");

    /// General Settings
	
	    $options[] = array(	"name" => "General Settings",
						"type" => "heading");
						
			$options[] = array(	"name" => "Customize Your Design",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Use Custom Stylesheet",
						            "desc" => "If you want to make custom design changes using CSS enable and <a href='". $customcssurl . "'>edit custom.css file here</a>.",
						            "id" => $shortname."_customcss",
						            "std" => "false",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Favicon",
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"desc" => "Paste the full URL for your favicon image here if you wish to show it in browsers. <a href='http://www.favicon.cc/'>Create one here</a>",
						            "id" => $shortname."_favicon",
						            "std" => "",
						            "type" => "text");	
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Header Your Logo Image Set",
						        "toggle" => "true",
								"type" => "subheadingtop");

                $options[] = array(	"name" => "Choose Your Logo Image",
				                    "desc" => "Paste the full URL to your logo image here.",
						            "id" => $shortname."_logo_url",
						            "std" => "",
						            "type" => "file");

				$options[] = array(	"name" => "Choose Blog Title over Logo",
				                    "desc" => "This option will overwrite your logo selection above - You can <a href='". $generaloptionsurl . "'>change your settings here</a>",
						            "label" => "Show Blog Title + Tagline.",
						            "id" => $shortname."_show_blog_title",
						            "std" => "true",
						            "type" => "checkbox");	

			$options[] = array(	"type" => "subheadingbottom");
			
									
			$options[] = array(	"name" => "Syndication / Feed",
						        "toggle" => "true",
								"type" => "subheadingtop");			
						
			$options[] = array( "desc" => "If you are using a service like Feedburner to manage your RSS feed, enter full URL to your feed into box above. If you'd prefer to use the default WordPress feed, simply leave this box blank.",
			    		            "id" => $shortname."_feedburner_url",
			    		            "std" => "",
			    		            "type" => "text");	
						
			$options[] = array(	"type" => "subheadingbottom");
								
/* $options[] = array(	"name" => "Image Setting (Tim thumb setting - Image Cutting Edge)",
						        "toggle" => "true",
								"type" => "subheadingtop");	

$options[] = array(	"name" => __("Default Image Cutting Edge"),
					                "desc" => __("Set Default Image Cutting Edge Position."),
					                "id" => $shortname."_image_x_cut",
					                "std" => "",
									"options" => array('center','top','bottom','left','right','top right','top left','bottom right','bottom left'),
					                "type" => "select");
				$options[] = array(	"type" => "subheadingbottom");*/
			 
			 					
		$options[] = array(	"type" => "maintablebreak");
		
		
    /// Navigation Settings												
				
		$options[] = array(	"name" => "Navigation Settings",
						    "type" => "heading");
										
				$options[] = array(	"name" => "Exclude Pages from Header Menu",
								"toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"type" => "multihead");
						
				$options = pages_exclude($options);
									
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Include Categories from Header Menu Category",
							"toggle" => "true",
							"type" => "subheadingtop");
					
			$options[] = array(	"label" => "Header Navigation Select Menu Category",
								"desc" => "Enter a comma-separated list of the <code>categories ID's</code> that you'd like to display in header (on the right). (ie. <code>1,2,3,4</code>)",
								"id" => $shortname."_categories_id",
								"std" => "",
								"type" => "text");	
					
		$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Breadcrumbs Navigation",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Show breadcrumbs navigation bar",
						            "desc" => "i.e. Home > Blog > Title - <a href='". $breadcrumbsurl . "'>Change options here</a>",
						            "id" => $shortname."_breadcrumbs",
						            "std" => "true",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
$options[] = array(	"name" => "Footer Navigation",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Show breadcrumbs navigation bar",
                	                "desc" => "Enter a comma-separated list of the <code>page ID's</code> that you'd like to display in footer (on the right). (ie. <code>1,2,3,4</code>)",
						            "id" => $shortname."_footerpages",
						            "std" => "",
						            "type" => "text");	
						
			$options[] = array(	"type" => "subheadingbottom");
						
		$options[] = array(	"type" => "maintablebreak");
		
		
  /// Home Page Banner Settings												
				
		$options[] = array(	"name" => "Home Page Banner Setting",
						    "type" => "heading");
										
		  $options[] = array(	"name" => "Title",
						"toggle" => "true",
						"type" => "subheadingtop");
		
		$options[] = array(	"desc" => "Title",
							"id" => $shortname."_banner_title",
							"std" => "",
							"type" => "text");
							
	$options[] = array(	"type" => "subheadingbottom");	
	
	
	$options[] = array(	"name" => "Description",
						"toggle" => "true",
						"type" => "subheadingtop");
		
		$options[] = array(	"desc" => "Description",
							"id" => $shortname."_banner_desc",
							"std" => "",
							"type" => "textarea");
							
	$options[] = array(	"type" => "subheadingbottom");
	
	$options[] = array(	"name" => "Button Name",
						"toggle" => "true",
						"type" => "subheadingtop");
		
		$options[] = array(	"desc" => "Button Name",
							"id" => $shortname."_btn_name",
							"std" => "",
							"type" => "text");
							
	$options[] = array(	"type" => "subheadingbottom");
	
	
		$options[] = array(	"name" => "Button URL",
						"toggle" => "true",
						"type" => "subheadingtop");
		
		$options[] = array(	"desc" => "Button URL",
							"id" => $shortname."_btn_url",
							"std" => "",
							"type" => "text");
							
	$options[] = array(	"type" => "subheadingbottom");
	
	$options[] = array(	"type" => "maintablebreak");
		
		
    /// Product Settings												
				
		$options[] = array(	"name" => "Product  Details Page Settings",
						    "type" => "heading");
										
		  $options[] = array(	"name" => "Product Detail Page Size Chart Add",
						"toggle" => "true",
						"type" => "subheadingtop");
		
		$options[] = array(	"desc" => "Enter Product Size Chart Image & Table Fromat Add",
							"id" => $shortname."_size_chart",
							"std" => "",
							"type" => "textarea");
							
	$options[] = array(	"type" => "subheadingbottom");
	
	
	$options[] = array(	"name" => "Product Detail Page Share This Feed Name setting",
						        "toggle" => "true",
								"type" => "subheadingtop");
				
				$options[] = array(	"desc" => "Feed name",
					                "id" => $shortname."_feed_name",
					                "std" => "",
					                "type" => "text");
				
				$options[] = array(	"type" => "subheadingbottom");

			
	$options[] = array(	"name" => "Product Detail Page Share This Feed URL link setting",
						        "toggle" => "true",
								"type" => "subheadingtop");
				
				$options[] = array(	"desc" => "Feed URL",
					                "id" => $shortname."_feed_url",
					                "std" => "",
					                "type" => "text");
				
				$options[] = array(	"type" => "subheadingbottom");

 ////////////////////start /////////////////
	  $options[] = array(	"name" => "Add to Cart/Send Inquiry Button Position",
						"toggle" => "true",
						"type" => "subheadingtop");
		
	$options[] = array(	"desc" => "Select Add to Cart Button Position in Product Detail Page",
							"id" => $shortname."_add_to_cart_button_position",
							"std" => "Select a CSS skin:",
							"type" => "select",
							"options" => array('Above Description','Below Description','Above and Below Description'));
							
	$options[] = array(	"type" => "subheadingbottom");
	
	/////////////////////////end///////////
													
$options[] = array(	"type" => "maintablebottom");
				
$options[] = array(	"type" => "maintabletop");


	/// Blog Section Settings												
		$options[] = array(	"name" => "Blog Section Settings",
						    "type" => "heading");
			
		    
			$options[] = array(	"name" => "Select Categories As Blog Categories",
								"toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"type" => "multihead");
						
				$options = category_exclude($options);
					
			$options[] = array(	"type" => "subheadingbottom");
			
			
		$options[] = array(	"name" => "Content Display",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Display Full Post Content",
						            "desc" => "Instead of default Post excerpts display Full Post Content in Blog Section",
						            "id" => $shortname."_postcontent_full",
						            "std" => "false",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
 						
		$options[] = array(	"type" => "maintablebreak");

    
		
	/// Stats and Scripts											
				
		$options[] = array(	"name" => "Stats and Scripts",
						    "type" => "heading");
										
			$options[] = array(	"name" => "Header Scripts",
						        "toggle" => "true",
								"type" => "subheadingtop");	
						
				$options[] = array(	"name" => "Header Scripts",
					                "desc" => "If you need to add scripts to your header (like <a href='http://haveamint.com/'>Mint</a> tracking code), do so here.",
					                "id" => $shortname."_scripts_header",
					                "std" => "",
					                "type" => "textarea");
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Footer Scripts",
						        "toggle" => "true",
								"type" => "subheadingtop");	
						
				$options[] = array(	"name" => "Footer Scripts",
					                "desc" => "If you need to add scripts to your footer (like <a href='http://www.google.com/analytics/'>Google Analytics</a> tracking code), do so here.",
					                "id" => $shortname."_google_analytics",
					                "std" => "",
					                "type" => "textarea");
			
			$options[] = array(	"type" => "subheadingbottom");
						
		$options[] = array(	"type" => "maintablebreak");
		

		
 
		
	/// SEO Options
				
		$options[] = array(	"name" => "SEO Options",
						    "type" => "heading");
						
			$options[] = array(	"name" => "Home Page <code>&lt;meta&gt;</code> tags",
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"name" => "Meta Description",
					                "desc" => "You should use meta descriptions to provide search engines with additional information about topics that appear on your site. This only applies to your home page.",
					                "id" => $shortname."_meta_description",
					                "std" => "",
					                "type" => "textarea");

				$options[] = array(	"name" => "Meta Keywords (comma separated)",
					                "desc" => "Meta keywords are rarely used nowadays but you can still provide search engines with additional information about topics that appear on your site. This only applies to your home page.",
						            "id" => $shortname."_meta_keywords",
						            "std" => "",
						            "type" => "text");
									
				$options[] = array(	"name" => "Meta Author",
					                "desc" => "You should write your <em>full name</em> here but only do so if this blog is writen only by one outhor. This only applies to your home page.",
						            "id" => $shortname."_meta_author",
						            "std" => "",
						            "type" => "text");
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Add <code>&lt;noindex&gt;</code> tags",
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to category archives.",
						            "id" => $shortname."_noindex_category",
						            "std" => "true",
						            "type" => "checkbox");
									
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to tag archives.",
						            "id" => $shortname."_noindex_tag",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to author archives.",
						            "id" => $shortname."_noindex_author",
						            "std" => "true",
						            "type" => "checkbox");
									
			    $options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to Search Results.",
						            "id" => $shortname."_noindex_search",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to daily archives.",
						            "id" => $shortname."_noindex_daily",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to monthly archives.",
						            "id" => $shortname."_noindex_monthly",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to yearly archives.",
						            "id" => $shortname."_noindex_yearly",
						            "std" => "true",
						            "type" => "checkbox");
				
						
			$options[] = array(	"type" => "subheadingbottom");
			
			
		$options[] = array(	"type" => "maintablebreak");
$options[] = array(	"type" => "maintablebottom");

?>
