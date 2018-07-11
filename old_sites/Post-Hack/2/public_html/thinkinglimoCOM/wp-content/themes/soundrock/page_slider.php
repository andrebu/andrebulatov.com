<?php wp_reset_query();
if(is_home() || is_front_page()){?>
<div id="banner">
	<div class="banner-in">
    <?php }else{?>
		<div class="slider">
	<?php }?>
<?php
$cs_sliders_setttings = get_option( "cs_sliders_setttings" );
	$xmlObject = new SimpleXMLElement($cs_sliders_setttings);

if ( $node->slider_type == "Nivo Slider" ) {
	// nivo code start
	$width = $node->width;
	$height = $node->height;
	?>
		<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/scripts/frontend/jquery.nivo.slider.js"></script>
				<?php
					if($xmlObject->nivo->auto_play == 'true'){$xmlObject->nivo->auto_play = 'false';}
					else if($xmlObject->nivo->auto_play == ''){$xmlObject->nivo->auto_play = 'true';}?>
				<script>	
					jQuery(function() {
						jQuery('#slidernivo<?php echo $counter_gal?>').nivoSlider({
							effect: "<?php echo $xmlObject->nivo->effect?>",
							manualAdvance: <?php echo $xmlObject->nivo->auto_play;?>,			
							animSpeed: <?php echo $xmlObject->nivo->animation_speed?>,
							pauseTime: <?php echo $xmlObject->nivo->pause_time?>,		
						});
					});
				</script>
				<style>
				.slider-wrapper<?php echo $counter_gal?> {
					width:<?php echo $width?>px;
				}*/
				</style>
				<!--    <h1 class="in-sec-heading">
						Slider: 
						<?php 
							//echo get_the_title("$node->slider");
							//echo " ( ".$node->slider_type." )";
						?>
					</h1>
				-->
				<?php 
						$cs_meta_slider_options = get_post_meta($node->slider, "cs_meta_slider_options", true);
						if ( $cs_meta_slider_options <> "" ) {?>
					<!--slider html-->
					<div class="slider-wrapper<?php echo $counter_gal?> theme-default">
						<div id="slidernivo<?php echo $counter_gal?>" class="nivoSlider">
							<?php
									$xmlObject = new SimpleXMLElement($cs_meta_slider_options);
										$counter_nivo_slider_start = 0;
										foreach ( $xmlObject->children() as $as_node ){
											$counter_nivo_slider_start++;
											$path_db = $as_node->path;
											$title_db = $as_node->title;
											$description_db = $as_node->description;
											$link_db = $as_node->link;
											$link_target_db = $as_node->link_target;
											$box_align_db = $as_node->box_align;
											//$image_url = wp_get_attachment_image_src($as_node->path, array(980,418),true);
											$image_url = cs_attachment_image_src($as_node->path, 960, 360);
										?>
											<img src="<?php echo $image_url?>" data-thumb="<?php echo $image_url?>" alt="" title="#id<?php echo $counter_nivo_slider_start;?>" />
										<?php }?>
						</div>
						 <?php 
									$xmlObject = new SimpleXMLElement($cs_meta_slider_options);
										$counter_nivo_slider = 0;
										 foreach ( $xmlObject->children() as $as_node ){
											 if($as_node->title != '' && $as_node->description != '' || $as_node->title != '' || $as_node->description != ''){
											 $counter_nivo_slider++
							?>
							<div id="id<?php echo $counter_nivo_slider?>" class="nivo-html-caption">                
								<div class="nivo-caption-in <?php echo $as_node->box_align?>">    
									<div class="capt-in">
										<h1><a target="<?php echo $as_node->link_target;?>" class="white" href="<?php echo $as_node->link?>"><?php echo substr($as_node->title, 0, 16); if ( strlen($as_node->title) > 16 ) echo "...";?></a></h1>
                                        <p>
                                            <?php 
												echo substr($as_node->description, 0, 150);
												if ( strlen($as_node->description) > 150 ) echo "...";
											?>
                                        </p>
                                        <a href="<?php echo $as_node->link?>" target="<?php echo $as_node->link_target;?>" class="banner-more"><span class="backcolr">Read More</span><span class="corner">&nbsp;</span></a>
									</div>
								</div>
							</div>
									<?php } //If Condition of title?>
								<?php } // foreach loop end?>                
					</div>
					<?php }?>

    <?php
	// nivo code end
}
else if ( $node->slider_type == "Sudo Slider" ) {
	// sudo code start
	$width = $node->width;
	$height = $node->height;
	?>
		<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/scripts/frontend/jquery.sudoSlider.min.js"></script>
            <!--    <h1 class="in-sec-heading">
                    Slider: 
                    <?php 
                        //echo get_the_title("$node->slider");
                        //echo " ( ".$node->slider_type." )";
                    ?>
                </h1>
            -->
            <?php
                $cs_meta_slider_options = get_post_meta($node->slider, "cs_meta_slider_options", true);
                if ( $cs_meta_slider_options <> "" ) {
            ?>
            <style>
            .sudoslider<?php echo $counter_gal?>{
                width:<?php echo $width?>px;
                height:<?php echo $height?>px;
                position:relative !important;
            }
            #sudoslider<?php echo $counter_gal?>{
                width:<?php echo $width?>px;
                height:<?php echo $height?>px;
                position:relative !important;
            }
            #sudoslider<?php echo $counter_gal?> img{
                width:<?php echo $width?>px;
                height:<?php echo $height?>px;
            }
            </style>
            <?php if($xmlObject->sudo->effect == 'Fade'){$xmlObject->sudo->effect = 'true';}?>
            <?php if($xmlObject->sudo->effect == 'Vertical'){$xmlObject->sudo->effect = 'false';}?>
            <?php if($xmlObject->sudo->auto_play == ''){$xmlObject->sudo->auto_play = 'false';}?>
            <script>
                $(function(){	
                    var ajaximages = [
                        <?php
                                        $xmlObject_sudo = new SimpleXMLElement($cs_meta_slider_options);
                                            foreach ( $xmlObject_sudo->children() as $as_node ){
                                                $path_db = $as_node->path;
                                                $title_db = $as_node->title;
                                                $description_db = $as_node->description;
                                                $link_db = $as_node->link;
                                                $link_target_db = $as_node->link_target;
                                                $box_align_db = $as_node->box_align;
                                            ?>
                                                '<?php 
                                                    //$image_url = wp_get_attachment_image_src($as_node->path, array(980,418),true);
                                                    $image_url = cs_attachment_image_src($as_node->path, 960, 360);
                                                    echo $image_url
                                                ?>',
                                            <?php
                                            }
                                ?>
                            ];
                            var imagestext = [
                               <?php 
                                            foreach ( $xmlObject_sudo->children() as $as_node ){
                                                if($as_node->title != '' && $as_node->description != '' || $as_node->title != '' || $as_node->description != ''){																						
                                                $path_db = $as_node->path;
                                                $title_db = $as_node->title;
                                                $description_db = $as_node->description;
                                                $link_db = $as_node->link;
                                                $link_target_db = $as_node->link_target;
                                                $box_align_db = $as_node->box_align;
                                            ?>
												'<h1><a target="<?php echo $as_node->link_target?>" href="<?php $as_node->link?>"><?php echo substr($as_node->title, 0, 16); if ( strlen($as_node->title) > 16 ) echo "...";?></a></h1><p><?php echo substr($as_node->description, 0, 150); if ( strlen($as_node->description) > 150 ) echo "...";?></p><a href="<?php $as_node->link?>" target="<?php $as_node->link_target?>" class="banner-more"><span class="backcolr">Read More</span><span class="corner">&nbsp;</span></a>',                                                
                                        <?php } ?>
                                    <?php } ?>																									
                            ];	
                                            var caption_text = [
                               <?php 
                                            foreach ( $xmlObject_sudo->children() as $as_node ){
                                                if($as_node->title != '' && $as_node->description != '' || $as_node->title != '' || $as_node->description != ''){																						
                                                //$path_db = $as_node->path;
                                                //$title_db = $as_node->title;
                                                //$description_db = $as_node->description;
                                                //$link_db = $as_node->link;
                                                //$link_target_db = $as_node->link_target;
                                                $box_align_db = $as_node->box_align;
                                            ?>
                                                '<?php 
                                                    echo $box_align_db;
                                                ?>',
                                        <?php } ?>
                                    <?php } ?>																									
                            ];	
                            var sudoSlider = $("#sudoslider<?php echo $counter_gal?>").sudoSlider({ 
                                fade:<?php echo $xmlObject->sudo->effect;?>,
                                auto: <?php echo $xmlObject->sudo->auto_play;?>, 
                                speed: <?php echo $xmlObject->sudo->animation_speed?>, 
                                pause: <?php echo $xmlObject->sudo->pause_time?>, 
                                //resumePause: 10000,
                                //prevNext:false,
                                prevNext: true,
                                numeric: false,					
                                continuous:true,
                                crossFade:false,
                                responsive:true,
                                //vertical:true,
                                ajax: ajaximages,
                                ajaxLoadFunction: function(t){
                                    $(this)
                                        .css("position","relative")
                                        .append('<div class="caption ' + caption_text[t-1] + '"><div class="capt-in">' + imagestext[t-1] + '</div></div>');
                                },
                                beforeAniFunc: function(t){ 
                                    $(this).children('.caption').hide();	
                                },
                                afterAniFunc: function(t){ 
                                    $(this).children('.caption').slideDown(400);
                                }
                            });
                        });	           
            </script>
                <?php }?>
                <div class="sudoslid sudoslider<?php echo $counter_gal?>">
                    <div id="sudoslider<?php echo $counter_gal?>" class="sudo-slider"></div>
                </div>
            
    <?php
	// sudo code end
}
else if ( $node->slider_type == "Anything Slider" ) {
	// anything code start
	if ( $xmlObject->anything->auto_play <> "true" ) {$xmlObject->anything->auto_play = "false";}
		$width = $node->width;
		$height = $node->height;?>
				<?php $inc_path_anything = get_template_directory_uri().'/scripts/anything_slider/';?>
                <style>
                #slider<?php echo $counter_gal?> {
                    width:<?php echo $width?>px;
                    height:<?php echo $height?>px;
                }
                </style>
                    <!-- jQuery (required) -->
                    <!-- Anything Slider optional plugins -->
                    <!-- AnythingSlider -->
                    <script src="<?php echo $inc_path_anything?>jquery.anythingslider.js"></script>
                    <script src="<?php echo $inc_path_anything?>jquery.anythingslider.fx.js"></script>
                    <!-- AnythingSlider video extension; optional, but needed to control video pause/play -->
                    <script src="<?php echo $inc_path_anything?>jquery.anythingslider.video.js"></script>
                    <script>
                    $(function(){
                        $('#slider<?php echo $counter_gal?>')
                        .anythingSlider({
                            mode          : "<?php echo $xmlObject->anything->effect?>", 
                            autoPlay      : <?php echo $xmlObject->anything->auto_play?>,
                            animationTime : <?php echo $xmlObject->anything->animation_speed?>,
                            delay         : <?php echo $xmlObject->anything->pause_time?>,
                            //buildNavigation     : true,
                            //buildStartStop      : true,
                            //navigationFormatter : function(i, panel){
                                //return ['Top', 'Right', 'Bottom', 'Left'][i - 1];
                            //}
                        })
                        .anythingSliderFx({
                            '.caption-top'    : [ 'caption-Top', '50px', '1000', 'easeOutBounce' ],
                            '.caption-right'  : [ 'caption-Right', '130px', '1000', 'easeOutBounce' ],
                            '.caption-bottom' : [ 'caption-Bottom', '50px', '1000', 'easeOutBounce' ],
                            '.caption-left'   : [ 'caption-Left', '130px', '1000', 'easeOutBounce' ]
                        })
                        // add a close button (x) to the caption
                        .find('div[class*=caption]')
                            .css({ position: 'absolute' })
                            //.prepend('<span class="as_close">Close</span>')
                            .find('.as_close').click(function(){
                                var cap = $(this).parent(),
                                    ani = { bottom : -50 }; // bottom
                                if (cap.is('.caption-top')) { ani = { top: -50 }; }
                                if (cap.is('.caption-left')) { ani = { left: -150 }; }
                                if (cap.is('.caption-right')) { ani = { right: -150 }; }
                                cap.animate(ani, 400);
                            });
                    });
                    </script>
                

                <!--    <h1 class="in-sec-heading">
                        Slider: 
                        <?php 
                            //echo get_the_title("$node->slider");
                            //echo " ( ".$node->slider_type." )";
                        ?>
                    </h1>
                -->
                    <?php
                        $cs_meta_slider_options = get_post_meta($node->slider, "cs_meta_slider_options", true);
                        if ( $cs_meta_slider_options <> "" ) {?>
                        <ul id="slider<?php echo $counter_gal?>">
                            <?php
                            $xmlObject = new SimpleXMLElement($cs_meta_slider_options);
                                foreach ( $xmlObject->children() as $as_node ){
                                    //$path_db = $as_node->path;
                                    //$title_db = $as_node->title;
                                    //$description_db = $as_node->description;
                                    //$link_db = $as_node->link;
                                    $link_target_db = $as_node->use_image_as;
                                    //$box_align_db = $as_node->video_code;
                                    //if ( $as_node->link <> "" ) $as_node->link = " href = '$as_node->link' target = '$as_node->link_target' ";
                                    //$image_url = wp_get_attachment_image_src($as_node->path, array(980,418),true);
                                    $image_url = cs_attachment_image_src($as_node->path, 960, 360);
                                    $video_id = (int) substr(parse_url($as_node->video_code, PHP_URL_PATH), 1); ?>
                                <li>
                                    
                                        <a target="<?php echo $as_node->link_target;?>" href="<?php echo $as_node->link?>" ><img src="<?php echo $image_url?>" /></a>

                                        <?php if($as_node->title != '' && $as_node->description != '' || $as_node->title != '' || $as_node->description != ''){?>
                                        <div class="any-caption caption-<?php echo $as_node->box_align?>">
                                            <div class="capt-in">
                                                <h1>
                                                    <a target="<?php echo $as_node->link_target;?>" class="white" href="<?php echo $as_node->link?>">									
                                                        <?php echo substr($as_node->title, 0, 16); if ( strlen($as_node->title) > 16 ) echo "...";?>
                                                    </a>
	                                            </h1>
                                                <p>
													<?php 
                                                        echo substr($as_node->description, 0, 150);
                                                        if ( strlen($as_node->description) > 150 ) echo "...";
                                                    ?>
                                                </p>
                                                <a href="<?php echo $as_node->link?>" target="<?php echo $as_node->link_target;?>" class="banner-more"><span class="backcolr">Read More</span><span class="corner">&nbsp;</span></a>
                                            </div>
                                        </div>
                                <?php }?>    
                                </li>
                                
                            <?php }?>
                        </ul>
                    <div class="clear"></div>
                <?php }
}
?>
<?php wp_reset_query();
if(is_home() || is_front_page()){?>
	</div>
</div>
<div class="clear"></div>
<?php }else{?>
</div><br />
<div class="clear"></div>
<?php }?>