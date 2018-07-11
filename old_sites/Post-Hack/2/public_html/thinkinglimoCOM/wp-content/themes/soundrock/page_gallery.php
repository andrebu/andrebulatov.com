
	<h1 class="heading colr"><?php echo get_the_title("$cs_gal_album_db");?></h1>
	<?php
    $cs_meta_gallery_options = get_post_meta($cs_gal_album_db, "cs_meta_gallery_options", true);
	  if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
        // pagination start
            if ( $cs_meta_gallery_options <> "" ) {
                $xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
                    if ( $cs_gal_pagination_db == "Show Pagination" and $cs_gal_media_per_page_db > 0 ) {
                            $limit_start = $cs_gal_media_per_page_db * ($_GET['page_id_all']-1);
                            $limit_end = $limit_start + $cs_gal_media_per_page_db;
                                if ( $limit_end > count($xmlObject) ) $limit_end = count($xmlObject);
                    }
                    else {
                        $limit_start = 0;
                        $limit_end = count($xmlObject);
                    }
            }
        // pagination end
    ?>
    <section id="gal-container">
    	<ul class="<?php echo $cs_gal_layout_db?> album-tracks">
            <?php
		        if ( $cs_meta_gallery_options <> "" ) {
					//foreach ( $xmlObject->children() as $node ) {
					for ( $i = $limit_start; $i < $limit_end; $i++ ) {
						$path = $xmlObject->gallery[$i]->path;
						$title = $xmlObject->gallery[$i]->title;
						$description = $xmlObject->gallery[$i]->description;
						$social_network = $xmlObject->gallery[$i]->social_network;
						$use_image_as = $xmlObject->gallery[$i]->use_image_as;
						$video_code = $xmlObject->gallery[$i]->video_code;
							//$image_url = wp_get_attachment_image_src($path, array(438,288),false);
							$image_url = cs_attachment_image_src($path, 476, 286);
							//$image_url_full = wp_get_attachment_image_src($path, 'full',false);
							$image_url_full = cs_attachment_image_src($path, 0, 0);
            ?>
                            <li>
                                <a href="<?php if($use_image_as==1)echo $video_code; else echo $image_url_full;?>" rel="<?php if($use_image_as==1)echo "prettyPhoto"; else echo "prettyPhoto[gallery1]"?>" name="<?php if($cs_gal_desc_db=="On")echo $description;?>" class="gal-thumb" >&nbsp;</a>
                                <?php echo "<img src='".$image_url."' alt='".$title."' />"?>
                                <?php
                                    if ( $cs_gal_title_db == "On" or $cs_gal_desc_db == "On" ) {
                                    ?>
                                        <div class="gal-caption <?php if($use_image_as==1)echo "video"; else echo"image"?>-bg">
                                            <h3 class="colr">
												<?php
                                                    if ( $cs_gal_title_db == "On" ) {
                                                        echo substr($title, 0, 30);
                                                        if ( strlen($title) > 30 ) echo " ...";
                                                    }
                                                ?>
                                            </h3>
                                            <p>
                                                <?php
                                                    if ( $cs_gal_desc_db == "On" ) {
                                                        echo substr($description, 0, 70);
                                                        if ( strlen($description) > 70 ) echo " ...";
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    <?php }?>
                            </li>
            <?php
                        }
                }
            ?>
            </ul>

	</section>
		<?php
        // pagination start
        $qrystr = '';
        if (cs_pagination( count($xmlObject), $cs_gal_media_per_page_db,$qrystr) <> ''){	
            if ( $cs_gal_pagination_db == "Show Pagination" and $cs_gal_media_per_page_db > 0 ) {
                echo "<div class='paging'><ul>";
                    $qrystr = '';
                    if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];						
                echo cs_pagination( count($xmlObject), $cs_gal_media_per_page_db,$qrystr );
                echo "</ul></div>";
            }
        }
        // pagination end
        ?>
