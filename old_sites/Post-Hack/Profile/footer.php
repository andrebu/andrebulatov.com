<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Footer
	/*-----------------------------------------------------------------------------------*/
	/**
	 *
	 * The template for displaying the footer
	 *
	 * Contains footer content and the closing of the #main and #page div elements.
	 *
	 * @package WordPress
	 * @subpackage Profile
	 * @since Profile 1.0
	 */
?>



		</div><!-- #content .site-content -->

	</div><!-- #primary .content-area -->

<!-- </div> -->  <!-- / container--> 



<footer class="site-footer container-fluid" role="contentinfo">
<!-- 	<a href="#" id="back-to-top"><span class="fa fa-chevron-up"></span></a> -->
	<div class="row">

<!-- Left side of sub-footer -->
		<div class="col-md-2 col-sm-6 col-xs-6 subFooter leftOne">
			<a class="btn btn-default btn-xs text-center" id="subFooterEmailLink" href="mailto:moc.votaluberdna@tcatnoc" target="_blank">
				<span class="fa fa-envelope"></span> Message Me
			</a>
		</div> 
		
<!--
		<div class="col-md-2"></div> 		
		<div class="col-md-2"></div> 
-->

<!-- Right side of sub-footer -->
<!-- License modal trigger -->
		<div class="license-info col-md-2 col-sm-6 col-xs-6">
			<img src="/wp-content/uploads/warrant-canary.png" alt="Warrant Canary! Hoot!" class="warrant-canary" data-toggle="tooltip" data-placement="top" title="Since my birth in 1984, I and any projects related to me, have received and complied with 0 (zero) government demands for information. If this notice disappears from my website, it will mean that I have been served with some sort of legal demand that requires my secrecy." />
			<span data-toggle="tooltip" data-placement="top"  title="Click for license info"class="license-tooltip-container">
				<a data-toggle="modal" data-target="#licenseModal" class="license-tooltip-trigger">
					<img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/88x31.png" />
				</a>
			</span>
		</div>
		<!-- License modal -->
		<div class="modal fade" id="licenseModal" tabindex="-1" role="dialog" aria-labelledby="licenseModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		        <h4 class="modal-title" id="myModalLabel">Creative Commons License</h4>
		      </div><!-- .modal-header -->
		      <div class="modal-body">
				<div class="gpl-license">
					<span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Andre's Website</span> 
					by 
					<a xmlns:cc="http://creativecommons.org/ns#" href="http://andrebulatov.com" property="cc:attributionName" rel="cc:attributionURL">Andre Bulatov</a> 
					is licensed under a 
					<a rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>
					.
					<br>
					Based on a work at 
					<a xmlns:dct="http://purl.org/dc/terms/" href="http://andrebulatov.com" rel="dct:source">http://andrebulatov.com</a>.
					<br>
					<br>
					<a rel="license" href="http://creativecommons.org/licenses/by/4.0/">
						<img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/88x31.png" />
					</a>
					<br>
					<br>
					<span class="made-with-love fa fa-heart" data-toggle="tooltip" data-placement="top" title="Made With Love"></span> <!--  data-delay='{"show":"5000", "hide":"3000"}'  -->
				</div><!-- .gpl-license .container -->
		      </div><!-- .modal-body -->
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div><!-- .modal-footer -->
		    </div><!-- .modal-content -->
		  </div><!-- .modal-dialog -->
		</div><!-- .modal .fade #licenseModal -->

<!-- Copyright copyleft site info  -->
		<div class="site-info col-md-8 col-sm-12 col-xs-12">
			<span class="copyleft">  
				<span class="copyleft-c" data-toggle="tooltip" data-placement="top" title="Copyleft">
					 © 
				</span>
				2014  Made by 
				<img id="Andre" src="/wp-content/uploads/Andre_normal.png" alt="Andre Bulatov" width="17" height="17" data-toggle="tooltip" data-placement="top" title="Andre">
				with 
				<span class="hide-visually">love</span>
				<span id="love">
					<i class="fa fa-heart"></i>
					<i class="fa fa-heart small" id="heart-one"></i>
					<i class="fa fa-heart small" id="heart-two"></i>
					<i class="fa fa-heart small" id="heart-three"></i>
				</span>
				and
				<span class="hide-visually">thought</span>
				<span id="thought">
				<i class="fa fa-lightbulb-o thirdStyle"></i>
				<i class="fa fa-bolt" id="bolt-one"></i>
				<i class="fa fa-bolt" id="bolt-two"></i>
				<i class="fa fa-bolt" id="bolt-three"></i>
			</span>
				All rights reserved? <i class="fa fa-hand-spock-o" id="live-long" data-toggle="tooltip" data-placement="top" title="Live long and prosper."></i>
			</span>		
		</div><!-- .site-info -->		

	</div><!-- .row -->
</footer><!-- .site-footer -->


<?php wp_footer(); ?>

</body>

</html>
