// closure to avoid namespace collision
(function(){
	// creates the plugin
	tinymce.create('tinymce.plugins.shortcodes_options', {
		// creates control instances based on the control's id.
		// our button's id is "brankic_shortcodes_button"
		createControl : function(id, controlManager) {
			if (id == 'brankic_shortcodes_button') {
				// creates the button
					
				var button = controlManager.createButton('brankic_shortcodes_button', {
					title : 'Shortcodes', // title of the button
					image : '../wp-content/themes/bigbangwp/includes/bra_shortcodes.ico',
					
					onclick : function() {
						
						var shortcodes_visible = jQuery("#bra_shortcodes_menu_holder").length;
						
						if (shortcodes_visible){
							jQuery("#bra_shortcodes_menu_holder").remove();
						}
						else{
							jQuery("#content_toolbargroup").append("<div id='bra_shortcodes_menu_holder'></div>");							

						
						
                 	

                       	

						
                        jQuery('#bra_shortcodes_menu_holder').load('../wp-content/themes/bigbangwp/includes/bra_shortcodes_popup.html#bra_shortodes_popup', function(){


							var y = parseInt(jQuery("#content_brankic_shortcodes_button").offset().top) - 25;	
							var x = parseInt(jQuery("#content_brankic_shortcodes_button").offset().left) - parseInt(jQuery("#adminmenuwrap").width()) + 10;
							jQuery("#bra_shortcodes_menu_holder").css({top: y, left: x})
						
							jQuery("#close_bra_shortcodes_popup").click(function(){
								jQuery("#bra_shortcodes_menu_holder").remove();
							});
							
							
							jQuery("#Bra_graph_container").click(function(){
                                var shortcode = "[bra_graph_container]delete this text and insert graph bars[/bra_graph_container]"
								tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);                            
                            })
							
							jQuery("#Bra_graph").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Sliding Graph', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_graph-form' );                            
                            })
							
							jQuery("#Bra_photostream").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Photostream (Instagram, Dribbble, Pinterest or Flickr)', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_photostream-form' );                            
                            })
							
							jQuery("#Bra_google_map").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Map', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_google_map-form' );                            
                            })
							

							jQuery("#Bra_center_title").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Centered title', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_center_title-form' );                            
                            })
							
							jQuery("#Bra_icon_boxes").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Icon boxes', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_icon_boxes-form' );                            
                            })
							
							jQuery("#Bra_boxed_text").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Boxed text', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_boxed_text-form' );                            
                            })
							
							jQuery("#Bra_divider").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Divider shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_divider-form' );                            
                            })
							
							jQuery("#Bra_border_divider").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Border divider shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_border_divider-form' );                            
                            })
							
							jQuery("#Bra_buttons").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Buttons shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_buttons-form' );                            
                            })
							
							jQuery("#Bra_highlights").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Highlighted text shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_highlights-form' );                            
                            })
							
							jQuery("#Bra_dropcaps").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Dropcap shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_dropcaps-form' );                            
                            })
							
							jQuery("#Bra_blockquotes").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Blockquote shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_blockquotes-form' );                            
                            })
							
							jQuery("#Bra_toggle").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Toggle element shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_toggle-form' );                            
                            })
							
							jQuery("#Bra_portfolio").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Portfolio items', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_portfolio-form' );                            
                            })
							
							jQuery("#Bra_team_member").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Team member section', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_team_member-form' );                            
                            })
							
							jQuery("#Bra_grid").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'Grid wrapper', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_grid-form' );                            
                            })
							
							jQuery("#Bra_list").click(function(){
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W - 80;
                                H = H - 84;
                                tb_show( 'List wrapper', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes_list-form' );                            
                            })
							
							jQuery("#Bra_contact").click(function(){
                                var shortcode = "[bra_contact]"
								tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);                            
                            })
							
							jQuery("#Bra_social_icons").click(function(){
                                var shortcode = "[bra_social_icons]twitter, http://twitter.com/brankic1979, facebook, https://www.facebook.com/brankic1979themes[/bra_social_icons]"
								tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);                            
                            })
							
							jQuery("#Bra_1-1").click(function(){
                                var shortcode = "[one]<h3>Dummy</h3> Content[/one]"
								tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);                            
                            })
							
							jQuery("#Bra_1-3x1-3x1-3").click(function(){
                                var shortcode = "[one_third]<h3>Dummy</h3> Content[/one_third] [one_third]<h3>Dummy</h3> Content[/one_third] [one_third_last]<h3>Dummy</h3> Content[/one_third_last]"
								tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);                            
                            })
							
							jQuery("#Bra_1-3x2-3").click(function(){
                                var shortcode = "[one_third]<h3>Dummy</h3> Content[/one_third] [two_thirds_last]<h3>Dummy</h3> Content[/two_thirds_last]"
								tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);                            
                            })
							
							jQuery("#Bra_2-3x1-3").click(function(){
                                var shortcode = "[two_thirds]<h3>Dummy</h3> Content[/two_thirds] [one_third_last]<h3>Dummy</h3> Content[/one_third_last] "
								tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);                            
                            })
							
							jQuery("#Bra_1-2x1-2").click(function(){
                                var shortcode = "[one_half]<h3>Dummy</h3> Content[/one_half] [one_half_last]<h3>Dummy</h3> Content[/one_half_last]"
								tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);                            
                            })
							
							jQuery("#Bra_1-4x1-4x1-4x1-4").click(function(){
                                var shortcode = "[one_fourth]<h3>Dummy</h3> Content[/one_fourth] [one_fourth]<h3>Dummy</h3> Content[/one_fourth] [one_fourth]<h3>Dummy</h3> Content[/one_fourth] [one_fourth_last]<h3>Dummy</h3> Content[/one_fourth_last]"
								tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);                            
                            })
							

							
							
							
							
							
                        }) // end of jQuery('#bra_shortcodes_menu_holder').load
                       
					   } //end of else (if visible) 

					} // end of var button = controlManager.createButton('brankic_shortcodes_button' onClick
				}); // end of var button = controlManager.createButton('brankic_shortcodes_button', {
				
				return button;
			} // end of if (id == 'brankic_shortcodes_button') {

			return null;
		} // end of createControl : function(id, controlManager) {
	});	// end of tinymce.create('tinymce.plugins.shortcodes_options', {
		
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('shortcodes_options', tinymce.plugins.shortcodes_options);
	
								
	
	// executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked


		
/////////////////////
//      GRAPH      //
/////////////////////
		var name0 = 'graph';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_template.php?name=" + name0 + "&fields[]=Title&fields[]=Percent&defaults[]=Graph&defaults[]=55&types[]=text&types[]=text&descriptions[]=Insert title&descriptions[]=Insert percent to fill bar&submit=Insert graph", function(data){

		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button

		    form.find('#shortcodes_' + name0 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
			    var options = { 
				    'Title'    : 'Graph',
					'Percent'  : '55'
				    };
			    var shortcode = '[bra_' + name0;
			    
			    for( var index in options) {
				    var value = table.find('#shortcodes_' + name0 + '-' + index).val();
				    
				    // attaches the attribute to the shortcode only if it's different from the default value
				    if ( value !== options[index] )
					    shortcode += ' ' + index + '="' + value + '"';
			    }			    
			    shortcode += ']';			    
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});
		
/////////////////////
//  PHOTOSTREAM    //
/////////////////////
		var name10 = 'photostream';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_photostream.php", function(data){

		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button

		    form.find('#shortcodes_' + name10 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
			    var options = { 
				    'user'    : 'brankic1979',
					'limit'    : '10',
					'social_network'  : 'dribbble',
					'layout' : 'small',
					'shape' : 'none'
				    };
			    var shortcode = '[bra_' + name10;
			    
			    for( var index in options) {
				    var value = table.find('#shortcodes_' + name10 + '-' + index).val();
				    
				    // attaches the attribute to the shortcode only if it's different from the default value
				    if ( value !== options[index] )
					    shortcode += ' ' + index + '="' + value + '"';
			    }			    
			    shortcode += ']';			    
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});		
		
		
/////////////////////
//  GOOGLE MAP     //
/////////////////////
		var name11 = 'google_map';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_template.php?name=" + name11 + "&fields[]=location&fields[]=zoom&defaults[]=Amsterdam&defaults[]=15&types[]=text&types[]=text&descriptions[]=Insert address, or city&descriptions[]=Zoom level&submit=Insert map", function(data){

		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button

		    form.find('#shortcodes_' + name11 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
			    var options = { 
				    'location'    : 'Amsterdam',
					'zoom'    : '15'
				    };
			    var shortcode = '[bra_' + name11;
			    
			    for( var index in options) {
				    var value = table.find('#shortcodes_' + name11 + '-' + index).val();
				    
				    // attaches the attribute to the shortcode only if it's different from the default value
				    if ( value !== options[index] )
					    shortcode += ' ' + index + '="' + value + '"';
			    }			    
			    shortcode += ']';			    
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});	
		
/////////////////////
// CENTER    TITLE //
/////////////////////
		var name12 = 'center_title';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_template.php?name=" + name12 + "&fields[]=title&fields[]=subtitle&defaults[]=Title&defaults[]=Subtitle&types[]=text&types[]=text&descriptions[]=Title&descriptions[]=Subtitle&submit=Insert Centered Title", function(data){

		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button

		    form.find('#shortcodes_' + name12 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
			    var options = { 
				    'title'    : 'title',
					'subtitle'  : 'subtitle'
				    };
			    var shortcode = '[bra_' + name12;
			    
			    for( var index in options) {
				    var value = table.find('#shortcodes_' + name12 + '-' + index).val();
				    
				    // attaches the attribute to the shortcode only if it's different from the default value
				    if ( value !== options[index] )
					    shortcode += ' ' + index + '="' + value + '"';
			    }			    
			    shortcode += ']';			    
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});

/////////////////////
//   ICON BOXES    //
/////////////////////
		var name2 = 'icon_boxes';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_icon_boxes.php", function(data){
		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button
		    form.find('#shortcodes_' + name2 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
				


					var icon_0 = table.find('#shortcodes_' + name2 + '-icon_0').val();
					var url_0 = table.find('#shortcodes_' + name2 + '-url_0').val();
					var target_0 = table.find('#shortcodes_' + name2 + '-target_0').val();
					var caption_0 = table.find('#shortcodes_' + name2 + '-caption_0').val();
					var about_0 = table.find('#shortcodes_' + name2 + '-about_0').val();
					
					var icon_1 = table.find('#shortcodes_' + name2 + '-icon_1').val();
					var url_1 = table.find('#shortcodes_' + name2 + '-url_1').val();
					var target_1 = table.find('#shortcodes_' + name2 + '-target_1').val();
					var caption_1 = table.find('#shortcodes_' + name2 + '-caption_1').val();
					var about_1 = table.find('#shortcodes_' + name2 + '-about_1').val();
					
					var icon_2 = table.find('#shortcodes_' + name2 + '-icon_2').val();
					var url_2 = table.find('#shortcodes_' + name2 + '-url_2').val();
					var target_2 = table.find('#shortcodes_' + name2 + '-target_2').val();
					var caption_2 = table.find('#shortcodes_' + name2 + '-caption_2').val();
					var about_2 = table.find('#shortcodes_' + name2 + '-about_2').val();
					
					var icon_3 = table.find('#shortcodes_' + name2 + '-icon_3').val();
					var url_3 = table.find('#shortcodes_' + name2 + '-url_3').val();
					var target_3 = table.find('#shortcodes_' + name2 + '-target_3').val();
					var caption_3 = table.find('#shortcodes_' + name2 + '-caption_3').val();
					var about_3 = table.find('#shortcodes_' + name2 + '-about_3').val();

					var shortcode = '[bra_icon_boxes_container]';
					
					shortcode += ' [bra_icon_box icon="' + icon_0 + '" url="' + url_0 + '" target="' + target_0 + '" caption="' + caption_0 + '"] ';
					shortcode += about_0;
					shortcode += ' [/bra_icon_box]';
					
					shortcode += ' [bra_icon_box icon="' + icon_1 + '" url="' + url_1 + '" target="' + target_1 + '" caption="' + caption_1 + '"] ';
					shortcode += about_1;
					shortcode += ' [/bra_icon_box]';
					
					shortcode += ' [bra_icon_box icon="' + icon_2 + '" url="' + url_2 + '" target="' + target_2 + '" caption="' + caption_2 + '"] ';
					shortcode += about_2;
					shortcode += ' [/bra_icon_box]';
					
					shortcode += ' [bra_icon_box icon="' + icon_3 + '" url="' + url_3 + '" target="' + target_3 + '" caption="' + caption_3 + '"] ';
					shortcode += about_3;
					shortcode += ' [/bra_icon_box]';

					shortcode += ' [/bra_icon_boxes_container]';

				
				
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});	

	

/////////////////////
//     DIVIDER     //
/////////////////////
		var name4 = 'divider';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_template.php?name=" + name4 + "&fields[]=height&defaults[]=80&types[]=text&descriptions[]=Insert height of blank space&submit=Insert empty space", function(data){

		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button

		    form.find('#shortcodes_' + name4 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
			    var options = { 
				    height    : '80'
				    };
			    var shortcode = '[bra_' + name4;
			    
			    for( var index in options) {
				    var value = table.find('#shortcodes_' + name4 + '-' + index).val();
				    
				    // attaches the attribute to the shortcode only if it's different from the default value
				    if ( value !== options[index] )
					    shortcode += ' ' + index + '="' + value + '"';
			    }			    
			    shortcode += ']';			    
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});
		
/////////////////////
//  BORDER DIVIDER //
/////////////////////
		var name5 = 'border_divider';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_template.php?name=" + name5 + "&fields[]=top&fields[]=bottom&defaults[]=40&defaults[]=40&types[]=text&types[]=text&descriptions[]=Insert height of empty space above the divider&descriptions[]=Insert height of empty space below the divider&submit=Insert Border Divider", function(data){

		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button

		    form.find('#shortcodes_' + name5 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
			    var options = { 
				    'top'    : '40',
					'bottom'  : '40'
				    };
			    var shortcode = '[bra_' + name5;
			    
			    for( var index in options) {
				    var value = table.find('#shortcodes_' + name5 + '-' + index).val();
				    
				    // attaches the attribute to the shortcode only if it's different from the default value
				    if ( value !== options[index] )
					    shortcode += ' ' + index + '="' + value + '"';
			    }			    
			    shortcode += ']';			    
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});
		

/////////////////////
//     BUTTONS     //
/////////////////////
		var name6 = 'buttons';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_buttons.php", function(data){
		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button
		    form.find('#shortcodes_' + name6 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
				


					var text = table.find('#shortcodes_' + name6 + '-text').val();
					var url = table.find('#shortcodes_' + name6 + '-url').val();
					var target = table.find('#shortcodes_' + name6 + '-target').val();
					var size = table.find('#shortcodes_' + name6 + '-size').val();
					var style = table.find('#shortcodes_' + name6 + '-style').val();
					var color = table.find('#shortcodes_' + name6 + '-color').val();


					shortcode = ' [bra_button text="' + text + '" url="' + url + '" target="' + target  +  '" size="' + size + '" style="' + style  + '" color="' + color + '"]';

				
				
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});	
		
	
/////////////////////
//    HIGHLIGHTS   //
/////////////////////
		var name7 = 'highlights';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_highlights.php", function(data){
		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button
		    form.find('#shortcodes_' + name7 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
					var text = table.find('#shortcodes_' + name7 + '-text').val();
					var style = table.find('#shortcodes_' + name7 + '-style').val();

					shortcode = ' [bra_highlight style="' + style  + '"]' + text + '[/bra_highlight]';

				
				
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});	
		
/////////////////////
//    DROPCAPS     //
/////////////////////
		var name31 = 'dropcaps';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_dropcaps.php", function(data){
		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button
		    form.find('#shortcodes_' + name31 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
					var letter = table.find('#shortcodes_' + name31 + '-letter').val();
					var style = table.find('#shortcodes_' + name31 + '-style').val();

					shortcode = ' [bra_dropcaps style="' + style  + '"]' + letter + '[/bra_dropcaps]';

				
				
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});	
		
/////////////////////
//  LIST WRAPPER   //
/////////////////////
		var name32 = 'list';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_list.php", function(data){
		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button
		    form.find('#shortcodes_' + name32 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
					var style = table.find('#shortcodes_' + name32 + '-style').val();

					shortcode = ' [bra_list style="' + style  + '"]INSERT LIST HERE[/bra_list]';

				
				
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});	
		
		
/////////////////////
//    BLOCKQUOTES  //
/////////////////////
		var name8 = 'blockquotes';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_blockquotes.php", function(data){
		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button
		    form.find('#shortcodes_' + name8 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
					var text = table.find('#shortcodes_' + name8 + '-text').val();
					var align = table.find('#shortcodes_' + name8 + '-align').val();

					shortcode = ' [bra_blockquote align="' + align  + '"]' + text + '[/bra_blockquote]';

				
				
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});	
		
///////////////////////////////
//    TOGGLE ACCORDION       //
///////////////////////////////
		var name9 = 'toggle';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_toggle.php", function(data){
		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button
		    form.find('#shortcodes_' + name9 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
					var text = table.find('#shortcodes_' + name9 + '-text').val();
					var caption = table.find('#shortcodes_' + name9 + '-caption').val();
					var collapsable = table.find('#shortcodes_' + name9 + '-collapsable').val();

					shortcode = ' [bra_toggle collapsable="' + collapsable + '" caption="' + caption  + '"]' + text + '[/bra_toggle]';

				
				
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});	

/////////////////////
//    PORTFOLIO    //
/////////////////////
		var name21 = 'portfolio';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_portfolio.php", function(data){
		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button
		    form.find('#shortcodes_' + name21 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
				

					var title = table.find('#shortcodes_' + name21 + '-title').val();
					var cat_id = table.find('#shortcodes_' + name21 + '-cat_id').val();
					var no = table.find('#shortcodes_' + name21 + '-no').val();
					var show_filters = table.find('#shortcodes_' + name21 + '-show_filters').val();
					var columns = table.find('#shortcodes_' + name21 + '-columns').val();
					var shape = table.find('#shortcodes_' + name21 + '-shape').val();


					shortcode = ' [bra_portfolio title="' + title + '" cat_id="' + cat_id + '" no="' + no + '" show_filters="' + show_filters + '" columns="' + columns + '" shape="' + shape + '"]';

				
				
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});	
		
/////////////////////
//   TEAM MEMBER   //
/////////////////////
		var name22 = 'team_member';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_team_member.php", function(data){
		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button
		    form.find('#shortcodes_' + name22 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
				

					var member_name = table.find('#shortcodes_' + name22 + '-member_name').val();
					var member_position = table.find('#shortcodes_' + name22 + '-member_position').val();
					var member_img_src = table.find('#shortcodes_' + name22 + '-member_img_src').val();
					var member_social_list = table.find('#shortcodes_' + name22 + '-member_social_list').val();
					var member_columns = table.find('#shortcodes_' + name22 + '-member_columns').val();
					var member_text = table.find('#shortcodes_' + name22 + '-member_text').val();


					shortcode = ' [bra_team_member member_name="' + member_name + '" member_position="' + member_position + '" member_img_src="' + member_img_src + '" member_social_list="' + member_social_list + '" member_columns="' + member_columns + '"]' + member_text + '[/bra_team_member]';

				
				
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});	
		
/////////////////////
//   GRID          //
/////////////////////
		var name23 = 'grid';
	
		jQuery.get("../wp-content/themes/bigbangwp/includes/shortcodes_grid.php", function(data){
		   var form = jQuery(data);
		   var table = form.find('table');
	       form.appendTo('body').hide();
		   		// handles the click event of the submit button
		    form.find('#shortcodes_' + name23 + '-submit').click(function(){
			    // defines the options and their default values
			    // again, this is not the most elegant way to do this
			    // but well, this gets the job done nonetheless
				

					var grid_columns = table.find('#shortcodes_' + name23 + '-grid_columns').val();



					shortcode = ' [bra_grid grid_columns="' + grid_columns + '"]insert images here[/bra_grid]';

				
				
			    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);			    
			    tb_remove();
		    });
		});	
		
		
/////////////////////////////////////////////		
		
		
		

	});

})()

jQuery(window).load(function() {

})