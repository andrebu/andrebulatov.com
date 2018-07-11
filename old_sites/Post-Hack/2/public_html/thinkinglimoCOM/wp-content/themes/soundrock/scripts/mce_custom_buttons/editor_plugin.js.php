<?php 
	require_once('../../../../../wp-load.php');
	require_once('../../../../../wp-admin/includes/admin.php');
	do_action('admin_init');
	
	if ( ! is_user_logged_in() )
		die('You must be logged in to access this script.');
	
	if(!isset($shortcodesES))
		$shortcodesES = new ShortcodesEditorSelector();
	
	global $shortcode_tags;
	$ordered_sct = array_keys($shortcode_tags);
	$neworder = sort($ordered_sct);

?>

(function() {
	tinymce.create('tinymce.plugins.<?php echo $shortcodesES->buttonName; ?>', {
		init : function(ed, url) {
		},	
		createControl : function(n, cm) {
			if(n=='<?php echo $shortcodesES->buttonName; ?>'){
                var mlb = cm.createListBox('<?php echo $shortcodesES->buttonName; ?>', {
                     title : 'Shortcode',
                         onselect : function(v) { //Add shortcode data onClick
                             if(v == 'toogle'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_toggle title="toggle title 1" content="toggle content 1"]<br /><br />');
                                }
                             else if(v == 'tabs'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_tab] <br />\
                                            [cs_tab_item title="Tab title 1"]Tab content 1[/cs_tab_item] <br />\
                                            [cs_tab_item title="Tab title 2"]Tab content 2[/cs_tab_item] <br />\
                                            [cs_tab_item title="Tab title 3"]Tab content 3[/cs_tab_item]<br />\
                                            [/cs_tab]<br /><br />');
                                }
                             else if(v == 'accordion'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_accordion] <br />\
                                            [cs_accordion_item title="Accordion title 1"]Accordion content 1[/cs_accordion_item] <br />\
                                            [cs_accordion_item title="Accordion title 2"]Accordion content 2[/cs_accordion_item] <br />\
                                            [cs_accordion_item title="Accordion title 3"]Accordion content 3[/cs_accordion_item] <br />\
                                            [/cs_accordion]<br /><br />');
                                }
                             else if(v == 'divider'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_divider title="Divider Text 1"]<br /><br />');
                                }
                             else if(v == 'quote'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_quote align="center" color="#999999"]Add_Content[/cs_quote]<br /><br />');
                                }
                             else if(v == 'button'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_button color="#COLOR_CODE" background="#COLOR_CODE" size="medium" src="LINK_URL"]Button_Content[/cs_button]<br /><br />');
                                }
                             else if(v == 'column'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_column size="1/2"]Add_Content_Here[/cs_column]<br /><br />');
                                }
                             else if(v == 'dropcap'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_dropcap color="#COLOR_CODE" background="#COLOR_CODE"]Add_Content_Here[/cs_dropcap]<br /><br />');
                                }
                             else if(v == 'social'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_social type="facebook"]#[/cs_social]<br />\
                                             [cs_social type="twitter"]#[/cs_social]<br />\
                                             [cs_social type="youtube"]#[/cs_social]\
                                             <br /><br />');
                                }
                             else if(v == 'message_box'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_message_box color="#Color Code" background="#Color Code" border_color="#Color Code" title="Message Title"]Add_Content_Here[/cs_message_box]<br /><br />');
                                }
                             else if(v == 'frame'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_frame src="IMAGE_SOURCE" width="IMAGE_WIDTH" height="IMAGE_HEIGHT" lightbox="on" title="IMAGE_TITLE"]<br /><br />');
                                }
                             else if(v == 'list'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_list type="default"]<br />\
                                                [ul]<br />\
                                                    [li]Default list item 1[/li]<br />\
                                                    [li]Default list item 2[/li]<br />\
                                                    [li]Default list item 3[/li]<br />\
                                                [/ul]<br />\
                                             [/cs_list]<br /><br />');
                                }
                             else if(v == 'table'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_table color="#Color_Code"]<br />\
                                            [table cellpadding="0" cellspacing="0" width="100%"]<br />\
                                                [thead]<br />\
                                                  [tr]<br />\
                                                    [th style="width:25%"]Column 1[/th]<br />\
                                                    [th style="width:25%"]Column 2[/th]<br />\
                                                    [th style="width:25%"]Column 3[/th]<br />\
                                                    [th style="width:25%"]Column 4[/th]<br />\
                                                  [/tr]<br />\
                                                [/thead]<br />\
                                                [tbody]<br />\
                                                  [tr]<br />\
                                                    [td]Item 1[/td]<br />\
                                                    [td]Item 2[/td]<br />\
                                                    [td]Item 3[/td]<br />\
                                                    [td]Item 4[/td]<br />\
                                                  [/tr]<br />\
                                                  [tr]<br />\
                                                    [td]Item 11[/td]<br />\
                                                    [td]Item 22[/td]<br />\
                                                    [td]Item 33[/td]<br />\
                                                    [td]Item 44[/td]<br />\
                                                  [/tr]<br />\
                                                [/tbody]<br />\
                                            [/table]<br />\
                                         [/cs_table]<br /><br />');
                                }
                             else if(v == 'gallery'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_minigallery width="WIDTH" autoplay="on" post_id="Gallery_Page_ID"]<br /><br />');
                                }
                     }
                });
                // Add Elements for DropDown
                	mlb.add('toogle','toogle');
                	mlb.add('tabs','tabs');
                	mlb.add('accordion','accordion');
                	mlb.add('divider','divider');
                	mlb.add('quote','quote');
                	mlb.add('button','button');
                	mlb.add('column','column');
                	mlb.add('dropcap','dropcap');
                	mlb.add('social','social');
                	mlb.add('message_box','message_box');
                	mlb.add('frame','frame');
                	mlb.add('list','list');
                	mlb.add('table','table');
                	mlb.add('gallery','gallery');
                // Return the new listbox instance
                return mlb;
             }
             return null;
		},
	});
	// Register plugin
	tinymce.PluginManager.add('<?php echo $shortcodesES->buttonName; ?>', tinymce.plugins.<?php echo $shortcodesES->buttonName; ?>);
})();
