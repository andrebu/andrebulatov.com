<?php
add_action( 'add_meta_boxes', 'cd_meta_box_add' );  
function cd_meta_box_add()  
{  
	add_meta_box( 'my-meta-box-id', 'Page Options', 'cd_meta_box_cb', 'page', 'normal', 'high' );  
}  
function cd_meta_box_cb( $post ) {  
		global $post, $wpdb;
		$values = get_post_custom( $post->ID );  
		//$text = $values['my_meta_box_text'];
?>
<div class="page-wrap page-opts" style="overflow:hidden; position:relative;">
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/jquery.scrollTo-min.js"></script>

        <script type="text/javascript">
		var counter = 0;
			function add_page_builder_item (name){
				var url;
				if ( name == "Gallery") {
					url = 'gallery_pb.php';
				}
				else if ( name == "Event") {
					url = 'event_pb.php';
				}
				else if ( name == "Slider") {
					url = 'slider_pb.php';
				}
				else if ( name == "Blog") {
					url = 'cs_meta_load_blog.php';
				}
				else if ( name == "News") {
					url = 'cs_meta_load_news.php';
				}
				else if ( name == "Contact") {
					url = 'cs_meta_load_contact.php';
				}
				else if ( name == "Album") {
					url = 'album_pb.php';
				}
				counter++;
				//var name = jQuery('select#cs_page_builder_item').val();
				jQuery("#loading").html("<img src='<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif' />");
					var dataString = 'name=' + name + '&counter=' + counter;
					jQuery.ajax({
						type:'POST',
						url: '<?php echo get_template_directory_uri()?>/include/'+url,
						data: dataString,
						success: function(response) {
							jQuery("#add_page_builder_item").append(response);
							jQuery("#loading").html("");
						}
					});
			}
			function del_page_builder_template(name){
				var dataString = 'name='+ name;
				jQuery("#show_page_builder_template").html("<img src='<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif' />");
				jQuery.ajax({
					type:'POST', 
					url: '<?php echo get_template_directory_uri()?>/include/template_del.php', 
					data: dataString,  
					success: function(response) {
						jQuery("#show_page_builder_template").html(response);
					}
				});
			}
			function del_page_builder_template_readymade(name){
				var dataString = 'name='+ name;
				jQuery("#show_page_builder_template_readymade").html("<img src='<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif' />");
				jQuery.ajax({
					type:'POST', 
					url: '<?php echo get_template_directory_uri()?>/include/template_del_readymade.php', 
					data: dataString,  
					success: function(response) {
						jQuery("#show_page_builder_template_readymade").html(response);
					}
				});
			}
			function add_page_builder_template(filter_name){
				//var name = jQuery('select#cs_page_builder_template').val();
				var dataString = 'filter_name='+ filter_name;
				jQuery("#add_page_builder_item").html("<img src='<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif' />");
				jQuery.ajax({
					type:'POST', 
					url: '<?php echo get_template_directory_uri()?>/include/saved_template_load.php', 
					data: dataString,  
					success: function(response) {
						jQuery("#add_page_builder_item").html(response);
					}
				});
			}
			function add_page_builder_template_readymade(filter_name){
				//var name = jQuery('select#cs_page_builder_template').val();
				var dataString = 'filter_name='+ filter_name;
				jQuery("#add_page_builder_item").html("<img src='<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif' />");
				jQuery.ajax({
					type:'POST', 
					url: '<?php echo get_template_directory_uri()?>/include/saved_template_load_readymade.php', 
					data: dataString,  
					success: function(response) {
						jQuery("#add_page_builder_item").html(response);
					}
				});
			}
			function delete_this(id){
				jQuery('#'+id).remove();
				jQuery('#'+id+'_sort').remove();
			}
			
			function save_template_readymade(){
				jQuery("#loading_div").show('');
				jQuery.ajax({
					type:'POST', 
					url: '<?php echo get_template_directory_uri()?>/include/save_template_readymade.php', 
					data:jQuery('#post').serialize(), 
					success: function(response) {
						jQuery("#loading_div").hide();
						jQuery("#save_template_area").show('').html(response);
						slideout();
						$("#show_page_builder_template_readymade").html("<img src='<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif' />").load('<?php echo get_template_directory_uri()?>/include/templates_readymade.php');
					}
				});
			}
			function save_template() {
				jQuery("#loading_div").show('');
				jQuery.ajax({
					type:'POST', 
					url: '<?php echo get_template_directory_uri()?>/include/save_template.php', 
					data:jQuery('#post').serialize(), 
					success: function(response) {
						jQuery("#loading_div").hide();
						jQuery("#save_template_area").show('').html(response);
						slideout();
						$("#show_page_builder_template").html("<img src='<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif' />").load('<?php echo get_template_directory_uri()?>/include/saved_templates.php');
					}
				});
			}
			function show_template_name() {
				jQuery('#template_name_div').show(500);
			}
			function hide_template_name() {
				jQuery('#template_name_div').hide(500);
			}
			function slideout(){
				setTimeout(function(){
					jQuery("#save_template_area").slideUp("slow", function () {
					});
				}, 5000);
			}
		</script>
    <div class="option-sec margbtm">
    	<div class="opt-head">
        	<h6>Templates</h6>
        </div>
        <div class="opt-conts">
        	<h6 style="padding:15px 0px 0px 16px;">Ready Made Templates</h6>
                <div id="show_page_builder_template_readymade" class="templates-list"><?php include("templates_readymade.php")?></div>
                <div class="clear"></div>
            <h6 style="padding:0px 0px 10px 16px;">User Created Templates</h6>
                <div id="show_page_builder_template" class="templates-list" style="padding-top:0;"><?php include("saved_templates.php")?></div>
                <div id="container"></div>
        </div>
    </div>
    <div class="dragable-section">
    	<script>
			function bubble_close() {
			  $("#template_name_div").css("display", "none");
			}
		</script>
        <div class="drag-table">
            <div class="grag-cont">
                <div class="female-sec" id="drop_area">
                    <div class="in-sec">
                    	<h5 class="left">Layout Sections</h5>
                        <div class="right save-temp">
                            <input type="button" class="right" value="Save Layout" onclick="javascript:show_template_name()" />
                            <div class="clear"></div>
                            <div id="template_name_div" style="display:none">
                                <div class="temp-bubble">
                                    <a class="close-bubble" onclick="bubble_close()">&nbsp;</a>
                                    <input type="text" name="template_name" class="temp-bar" />
                                    <input type="button" value="Save" onclick="javascript:save_template()" />
                                    <?php
                                    global $current_user;
                                    if ( $current_user->user_login == "cs_user" ) {
                                    ?>
                                        <input type="button" class="btn_save_layout_readymade" value="Save Readymade" onclick="javascript:save_template_readymade()" />
                                    <?php } ?>
                                </div>
                            </div>
                            <span id="save_template_area"></span>
                            <span id="loading_div" style="display:none"><img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" /></span>
                        </div>
                        <div class="clear"></div>
                        <div class="slots-sec">
                        	<ul id="sortable">
                                <!--<div class="placeholder"><p>Drop Content From Right Side</p></div>-->
                                <div id="add_page_builder_template"></div>
                                <div id="add_page_builder_item">
									<?php
										$count_node = 0;
										$rich_editor = 0;
                                        $cs_page_bulider = get_post_meta($post->ID, "cs_page_builder", true);
                                        if ( $cs_page_bulider <> "" ) {
                                            $xmlObject = new SimpleXMLElement($cs_page_bulider);
												foreach ( $xmlObject->children() as $node ){
													include(TEMPLATEPATH."/include/load_all_sections.php");
												}
										}
                                    ?>
                                    <?php if ( $rich_editor <> 1 ) include(TEMPLATEPATH."/include/cs_meta_load_rich_editor.php") ?>
								</div>
                                <div id="loading"></div>
                            </ul>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="male-sec">
					<div class="in-sec">
                    	<h5 class="left">Sections (Drag and Drop to Left Side)</h5>
						<div class="clear"></div>
                        <div class="slots-sec">
                            <script>
								$(function() {
									//$( "#catalog" ).accordion();
									$( "#productarea li" ).draggable({
										appendTo: "ul#productarea",
											helper: "clone"
									});
									$( "#drop_area" ).droppable({
										activeClass: "ui-state-default2",
										hoverClass: "ui-state-hover2",
										accept: ":not(.ui-sortable-helper)",
										drop: function( event, ui ) {
											$( this ).find( ".placeholder" ).remove();
											var counter = $("#drop_area li").size();
											$(this) .append($(ui.draggable).clone(). each(function(){
												//$(this).attr('id','productid'+counter);
												$(this) .removeClass('ui-draggable');
												var echoclass = $(this) .attr("class");
												//alert (echoclass);
												add_page_builder_item(echoclass);
											}
											)) ;
												$('#drop_area li').remove('.Gallery');
												$('#drop_area li').remove('.Event');
												$('#drop_area li').remove('.Slider');
												$('#drop_area li').remove('.Blog');
												$('#drop_area li').remove('.News');
												$('#drop_area li').remove('.Contact');
												$('#drop_area li').remove('.Album');
										}
									}).sortable({										
										cancel : 'li div.poped-up',
										items: "li:not(.placeholder)",
										sort: function() {
											// gets added unintentionally by droppable interacting with sortable
											// using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
											$( this ).removeClass( "ui-state-default" );
										}
									});
								});
								
								</script>
								<ul id="productarea">
									<li class="Gallery">
                                        <div class="temp-tubes">
                                            <span class="gallery">&nbsp;</span>
                                            <p>Gallery</p>
                                        </div>
                                    </li>
                                    <li class="Event">
                                        <div class="temp-tubes">
                                            <span class="events">&nbsp;</span>
                                            <p>Event</p>
                                        </div>
                                    </li>
                                    <li class="Slider">
                                        <div class="temp-tubes">
                                            <span class="slider">&nbsp;</span>
                                            <p>Slider</p>
                                        </div>
                                    </li>
                                    <li class="Blog">
                                        <div class="temp-tubes">
                                            <span class="blog">&nbsp;</span>
                                            <p>Blog</p>
                                        </div>
                                    </li>
                                    <li class="News">
                                        <div class="temp-tubes">
                                            <span class="news">&nbsp;</span>
                                            <p>News</p>
                                        </div>
                                    </li>
                                    <li class="Album">
                                        <div class="temp-tubes">
                                            <span class="album">&nbsp;</span>
                                            <p>Album</p>
                                        </div>
                                    </li>
                                    <li class="Contact">
                                        <div class="temp-tubes">
                                            <span class="contact">&nbsp;</span>
                                            <p>Contact Form</p>
                                        </div>
                                    </li>
								</ul>
                            <div class="clear"></div>
                        </div>
                	</div>
                </div>
            </div>
        </div>
    </div>
		<?php include("inc_meta_layout.php")?>
        <input type="hidden" name="page_meta_form" value="1" />
    <div class="clear"></div>
</div>
<div class="clear"></div>
<?php  
}

function show_all_cats($parent, $separator, $selected="", $taxonomy) {
	if ( $parent == "" ) {
		global $wpdb;
		$parent = 0;
	}
	else $separator .= " — ";
	$args = array(
		'parent'                   => $parent,
		'hide_empty'               => 0,
		'taxonomy'                 => $taxonomy
	);
	$categories=  get_categories($args); 
	foreach ($categories as $category) {
	?>
		<option <?php if($selected==$category->slug)echo "selected";?> value="<?php echo $category->slug?>"><?php echo $separator.$category->cat_name?></option>
    <?php
			show_all_cats($category->term_id, $separator, $selected, $taxonomy);
	}
}

	if ( isset($_POST['page_meta_form']) and $_POST['page_meta_form'] == 1 ) {
		add_action( 'save_post', 'cd_meta_box_save' );  
		function cd_meta_box_save( $post_id ) {
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
					if ( isset($_POST['cs_orderby']) ) {
						//creating xml page builder start
						$sxe = new SimpleXMLElement("<pagebuilder></pagebuilder>");
							$sxe = save_layout_xml($sxe);
								include(TEMPLATEPATH."/include/save_all_sections.php");
								update_post_meta( $post_id, 'cs_page_builder', $sxe->asXML() );
						//creating xml page builder end
					}
		}
	}
?>