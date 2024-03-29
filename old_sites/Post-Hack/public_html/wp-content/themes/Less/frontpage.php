<?php
/*
Template Name: Home/Landing/Front
*/
?>
<?php 
	/*-----------------------------------------------------------------------------------*/
	/* Start Body of Home/Landing/Front Page
	/*-----------------------------------------------------------------------------------*/
	/**
	 *
	 * The main template file
	 *
	 * This is the front page/home
	 *
	 * @package WordPress
	 * @subpackage Profile
	 * @since Profile 1.0
	 */
?>



<?php get_header(); ?>






<div class="frontPage">

<nav class="navbar navbar-default" id="navbar-page" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".navbar-page">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-page">
		<ul class="nav navbar-nav">
			<li><a id="scroll-up" href="#"><i class="fa fa-chevron-up"></i></a></li>
			<li><a href="#profile">Profile</a></li>
			<li><a href="#services">Services</a></li>
			<li><a href="#clients">Clients</a></li>
			<li><a href="#portfolio">Portfolio</a></li>
			<li><a href="#abilities">Abilities</a></li>
			<li><a href="#contact">Contact</a></li>
			<li><a id="scroll-down" href="#"><i class="fa fa-chevron-down"></i></a></li>
		</ul>
	
	</div><!-- /.navbar-collapse -->

</nav>






<div id="profile" class="container page-section">
	<div class="row">
		<h2 class="themeColor profileHeading">Profile</h2>
		<p class="lead">I'm an aspiring full stack web developer</p>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-4">
			<h3>About me</h3>
			<p>
				I am a front-end web developer, aspiring to be an all around computer scientist as well as a full stack developer.  I am a programmer with good knowledge of front-end techniques and a thirst and ability to learn. From large eCommerce operations, to personal portfolio or blogging sites, I build awesome websites that yield my clients the desired results.		
			</p>
		</div>
		<div class="col-md-4 text-center">
			<img src="/wp-content/uploads/Andre_normal.png" alt="Andre Bulatov" width="300" height="300" onclick="alert('I love you too!')")>
		</div>
		<div class="col-md-4">
			<h3>Details</h3>
			<p>
				<strong>Name:</strong><br>
				Andre Bulatov<br>
				<strong>Age:</strong><br>
				30 years / &infin;<br>
				<strong>Location:</strong><br>
				Edison, NJ, USA, Earth<br>
				<!--	<strong>Race:</strong><br>
					Human<br>
					<strong>Really?:</strong><br>
					Yes<br> -->
			</p>
			<iframe id="twitter-widget-1" scrolling="no" frameborder="0" allowtransparency="true" src="http://platform.twitter.com/widgets/follow_button.9102a02e4157727d5d33e448662f9063.en.html#_=1417122609348&amp;id=twitter-widget-1&amp;lang=en&amp;screen_name=andrebulatov&amp;show_count=false&amp;show_screen_name=false&amp;size=l" class="twitter-follow-button twitter-follow-button" title="Twitter Follow Button" data-twttr-rendered="true" style="width: 79px; height: 28px;"></iframe>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		</div>
	</div>
</div>



<!--
	<div class="background-theme page-section">
		<div id="articles" class="container">
			<h2>Articles</h2>
		    <p class="lead">
			    “A quote about writing.” 
		        <br>
		        - Some Person
		    </p> 
		    <hr> 
		    <h3>Recent Posts</h3> 
		    <div class="row">
				<?php 
					$thumbnails = get_posts( 'numberposts=5' );
					foreach ( $thumbnails as $thumbnail ) {
						if ( has_post_thumbnail( $thumbnail->ID ) ) {
							echo '<div class="col-md-4"><a href="' . get_permalink( $thumbnail->ID ) . '" title="' . esc_attr( $thumbnail->post_title ) . '">';
							echo get_the_post_thumbnail( $thumbnail->ID, 'thumbnail' );
							echo '</a> </div>';
						}
					}
				?>
			</div>	
			<div class="text-center top-marginl">
				<p>Check out my blog for more posts.</p>
				<a href="http://andrebulatov.com/blog" class="btn btn-primary" target="_blank">See More Posts</a>
			</div>
		</div>
	</div>
	-->
<!--
	<ul>
	<?php
		$args = array( 'numberposts' => '3' );
		$recent_posts = wp_get_recent_posts( $args );
		foreach( $recent_posts as $recent ){
			echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
		}
		?>
	</ul>
	-->
<!--
	<?php $pages = get_pages( array( 'child_of' => 1 ) ); ?> 
	<ul>
		<?php foreach ( $pages as $page ) : ?>
			<li>
				<?php echo get_the_post_thumbnail( $page->ID, 'thumbnail' ); ?>
				<h1><?php echo apply_filters( 'the_title', $page->post_title, $page->ID ); ?></h1>
				<?php echo apply_filters( 'the_content', $page->post_content ); ?>
			</li>
		<?php endforeach; ?>
	</ul>
	-->
<!--
	<div class="background-theme">
		<div id="articles" class="container">
			<h2>Articles</h2>
		    <p class="lead">
			    “A quote about writing.” 
		        <br>
		        - Some Person
		    </p> 
		    <hr> 
		    <h3>Recent Posts</h3> 
			<ul>
			<?php
		$args = array( 'numberposts' => '3' );
		$recent_posts = wp_get_recent_posts( $args );
		foreach( $recent_posts as $recent ){
			echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
		}
		?>
			</ul>
		</div>
	</div>
	-->









<div class="background-theme page-section">
	<div id="services" class="container">
		<div class="row">
			<h2 class="themeColor profileHeading">Services</h2>
			<p class="lead">
				"The best way to find yourself is to lose yourself in the service of others."
				<br>
				- Mahatma Gandhi
			</p>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-12 col-sm-3 platform">
				<div class="circle"><i class="fa fa-wordpress service-icon"></i></div>
				<h4>WordPress Development</h4>
				<p class="service-desc">With over 7 years experience developing for and using WordPress, with over a dozen beautiful, functional projects under my belt, I can provide enterprise level, high quality custom site, plugin and theme development.</p>
			</div>
			<div class="col-xs-12 col-sm-3 front-end">
				<div class="circle"><i class="fa fa-paint-brush service-icon"></i></div>
				<h4>Front-end Design</h4>
				<p class="service-desc">As I tell my clients, when it comes to design, we make no sacrifice. There are almost no limitations to what we can do, as with me in tow we'll have control of every pixel on the screen.  We'll go where your vision takes us. I've plenty of experience designing sites and themes for clients, prior to coding them into live sites.</p>
			</div>
			<div class="col-xs-12 col-sm-3 ecommerce">
				<div class="circle"><i class="fa fa-cogs service-icon"></i></div>
				<h4>E-Commerce Applications</h4>
				<p class="service-desc">I have experience in building web applications with Javascript and Ruby. So, we can create anything from basic apps enhancing your site's functionality, to advanced API's doing much of the work for you. With over 23+ applications built for Shopify, BigCommerce and other platforms, I'm ready to built your solution for you.</p>
			</div>
			<div class="col-xs-12 col-sm-3 seo">
				<div class="circle"><i class="fa fa-line-chart service-icon"></i></div>
				<h4>SEO & Support Consultation</h4>
				<p class="service-desc">I have a passion--coupled with an economics education and business experience-- for tweaking the site's SEO and marketing vectors to bring desired results to my clients. Often, clients contact me with questions about how to gain more traction with their customers, or with broken sites that they cannot fix themselves. I'm happy to have a look, providing paid services to fix the site and carry out any updates to improve SEO ranking. </p>
			</div>
		</div>
	</div>
</div>




<div><!-- <div class="background-theme-2"> -->
	<div id="clients" class="container page-section">
		<div class="row">
			<h2 class="themeColor profileHeading">Clients</h2>
			<p class="lead">
				"I don't build in order to have clients. I have clients in order to build."
				<br>
				- Ayn Rand
			</p>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-12 col-md-4 text-center">
				<a href="http://bitseeds.org" target="_blank" rel="nofollow">
					<img src="/wp-content/uploads/clients/BitSeeds-square-logo-client.png" alt="BitSeeds Crypto Currency" title="BitSeeds Crypto Currency" >
				</a>
			</div>
			<div class="col-xs-12 col-md-4 text-center">
				<a href="http://greenlabsdenver.com" target="_blank" rel="nofollow">
					<img src="/wp-content/uploads/clients/Green_Labs_logo.png" alt="Green Labs Denver" title="Green Labs Denver" >
				</a>
			</div>
			<div class="col-xs-12 col-md-4 text-center">
				<a href="https://dankstop.com" target="_blank" rel="nofollow">
					<img src="/wp-content/uploads/clients/DankStop_logo.png" alt="DankStop" title="DankStop">
				</a>
			</div>
			<div class="col-xs-12 col-md-4 text-center">
				<a href="http://altspaceny.com" target="_blank" rel="nofollow">
					<img src="/wp-content/uploads/clients/AltSpace_logo.png" alt="AltSpace NY" title="AltSpace NY">
				</a>
			</div>
			<div class="col-xs-12 col-md-4 text-center">
				<a href="#" target="_blank" rel="nofollow">
					<img src="/wp-content/uploads/clients/Thinking-Limo-logo.png" alt="Thinking Limo" title="Thinking Limo">
				</a>
			</div>
			<div class="col-xs-12 col-md-4 text-center"></div>
		</div>
	</div>
</div>





<div class="background-theme page-section">
	<div id="portfolio" class="container">
		<div class"row">
			<h2 class="themeColor profileHeading">Portfolio</h2>
<!--
			<p class="lead">
				“If I had asked people what they wanted, they would have said faster horses.”	        
				<br>
				- Henry Ford
			</p>
-->
			<p class="lead">
				“If you’re good at something, never do it for free.”	        
				<br>
				- The Joker
			</p>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12">
				<figure class="effect">
					<img src="http://andrebulatov.com/wp-content/uploads/Thinking_Limo_Bootstrap_site-new-white-600x400-1.png" alt="Thinking Limo">
					<figcaption>
						<h3>Thinking Limo</h3>
						<p>Thinking Limo, a limo company located in NYC.</p>
						<p><strong>Tags:</strong> <br>Development, Wordpress, Bootstrap</p>
						<a href="http://thinkinglimo.com" target="_blank">View more</a>
						<span class="icon">
						<span class="glyphicon glyphicon-new-window"></span>
						</span>
					</figcaption>
				</figure>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<figure class="effect">
					<img src="http://andrebulatov.com/wp-content/uploads/DankStop_Bootstrap_site-new-white-600x400-1.png" alt="DankStop Online Headshop">
					<figcaption>
						<h3>DankStop</h3>
						<p>A thriving e-commerce store built on LAMP, using PHP, JS and more.</p>
						<p><strong>Tags:</strong> <br>Development, Design, PHP, JavaScript, e-commerce, jQuery, + more</p>
						<a href="http://dankstop.com" target="_blank">View more</a>
						<span class="icon">
						<span class="glyphicon glyphicon-new-window"></span>
						</span>
					</figcaption>
				</figure>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<figure class="effect">
					<img src="http://andrebulatov.com/wp-content/uploads/AltSpace_Bootstrap_site-new-white-600x400-1.png" alt="AltSpace NY Co-working">
					<figcaption>
						<h3>AltSpace NY</h3>
						<p>A clean, basic, one-page site for a local co-working space.</p>
						<p><strong>Tags:</strong> <br>Design, Development, Bootstrap</p>
						<a href="http://altspaceny.com" target="_blank">View more</a>
						<span class="icon">
						<span class="glyphicon glyphicon-new-window"></span>
						</span>
					</figcaption>
				</figure>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<figure class="effect">
					<img src="http://andrebulatov.com/wp-content/uploads/GreenLabs_Bootstrap_site-new-white-600x400-1.png" alt="Playful Arts Festival">
					<figcaption>
						<h3>Green Labs Denver</h3>
						<p>A clean, basic, one-page site for a Colorado co-working space.</p>
						<p><strong>Tags:</strong> <br>Development, Design, Bootstrap</p>
						<a href="http://greenlabsdenver.com" target="_blank">View more</a>
						<span class="icon">
						<span class="glyphicon glyphicon-new-window"></span>
						</span>
					</figcaption>
				</figure>
			</div>
		</div>
	</div>
</div>











<div id="abilities" class="container page-section">
	<div class"row">
		<h2 class="themeColor profileHeading">Abilities</h2>
		<p class="lead">
			“Know yourself.”
			<br>
			- Temple of Apollo at Delphi
		</p>
	</div>
	<hr>
	<h3>Languages</h3>
	<div class="row">
		<div class="col-md-6">
			<ul class="no-bullets">
				<li>
					<span class="ability-title">English (Doubleplusgood)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>
					<span class="ability-title">Russian (Fluent)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star half-filled" data-content="\f005"></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>
					<span class="ability-title">Spanish (Un poco)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star half-filled" data-content="\f005"></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
			</ul>
		</div>
		<div class="col-md-6">
			<ul class="no-bullets">
				<li>
					<span class="ability-title">German (Ein bißchen)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>
					<span class="ability-title">French (Un petit peu)</span>
					<span class="ability-score">
						<i class="fa fa-star half-filled" data-content="\f005"></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li> 
					<span class="ability-title">Computer (00111111)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
					</span>
				</li>
			</ul>
		</div>
	</div>
	<hr>
	<h3>Skills</h3>
	<div class="row">
		<div class="col-md-6">
			<ul class="no-bullets">
				<li>	
					<span class="ability-title">CSS(3)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>	
					<span class="ability-title">HTML(5)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>	
					<span class="ability-title">Bootstrap Framework</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>	
					<span class="ability-title">JQuery</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star half-filled" data-content="\f005"></i>
						<span class="fa fa-star"></span>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>	
					<span class="ability-title">Javascript</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star half-filled" data-content="\f005"></i>
						<span class="fa fa-star"></span>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>	
					<span class="ability-title">SASS</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star half-filled" data-content="\f005"></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>	
					<span class="ability-title">PHP</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star half-filled" data-content="\f005"></i>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">MySQL</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">Ruby</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
			</ul>
		</div>
		<div class="col-md-6">
			<ul class="no-bullets">
				<li>	
					<span class="ability-title">SEO</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<span class="fa fa-star half-filled"></span>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>	
					<span class="ability-title">e-Commerce</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<span class="fa fa-star half-filled"></span>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>	
					<span class="ability-title">BigCommerce</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<span class="fa fa-star half-filled"></span>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>	
					<span class="ability-title">Shopify</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star"></span>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>	
					<span class="ability-title">Volusion</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star half-filled" data-content="\f005"></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>	
					<span class="ability-title">Wordpress</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star half-filled" data-content="\f005"></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>	
					<span class="ability-title">XML</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<span class="fa fa-star half-filled"></span>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>	
					<span class="ability-title">Command line</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star half-filled" data-content="\f005"></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>	
					<span class="ability-title">Rails</span>
					<span class="ability-score">
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
			</ul>
		</div>
	</div>
	
	<div class="text-center project-referal">
		<p>This website is a public domain project.  Feel free to fork it..</p>
		<a href="https://github.com/iamandrebulatov/profile" class="btn btn-primary" target="_blank">See project on Github</a>
	</div>
	
	<hr>
	<h3>Tools</h3>
	<div class="row">
		<div class="col-md-6">
			<ul class="no-bullets">
				<li>
					<span class="ability-title">Windows (10+ years)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>
					<span class="ability-title">Notepad++ (7 years)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>
					<span class="ability-title">Firefox (7 years)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<span class="fa fa-star filled"></span>					
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>
					<span class="ability-title">Webkit (6 years)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>
					<span class="ability-title">Filezilla (5 years)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>
					<span class="ability-title">MS Office (10+ years)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
			</ul>
		</div>
		<div class="col-md-6">
			<ul class="no-bullets">
				<li>
					<span class="ability-title">Mac (5 years)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>
					<span class="ability-title">Coda2 (2 years)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>
					<span class="ability-title">IE 6+ (3 years)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<span class="fa fa-star half-filled"></span>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>
					<span class="ability-title">Adobe PS (6 years)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>
					<span class="ability-title">Git (1 year)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
					</span>
				</li>
				<li>
					<span class="ability-title">My Noggin' (30+ years)</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<span class="fa fa-plus filled"></span>
					</span>
				</li>
			</ul>
		</div>
	</div>
	<hr>
	<h3>Super Powers</h3>
	<div class="row">
		<div class="col-md-6">
			<ul class="no-bullets">
				<li>
					<span class="ability-title">Learning</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
<!-- 						<span class="fa fa-plus filled"></span> -->
					</span>
				</li>
				<li>
					<span class="ability-title">Problem Solving</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<span class="fa fa-star half-filled"></span>
					</span>
				</li>
			</ul>
		</div>
		<div class="col-md-6">
			<ul class="no-bullets">
				<li>
					<span class="ability-title">Reverse Engineering</span>
					<span class="ability-score">
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star filled"></i>
						<span class="fa fa-star half-filled"></span>
					</span>
				</li>
				<li>
					<span class="ability-title humor">Sense of Humor</span>
					<span class="ability-score humor">N/A
<!--
						<i class="fa fa-star filled"></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
						<i class="fa fa-star "></i>
-->
					</span>
				</li>
			</ul>
		</div>
	</div>
</div>












<div class="background-footer page-section">
	<div id="contact" class="container">
		<div class"row">
			<h2 class="themeColor profileHeading">Contact</h2>
			<p class="lead">
				“Invisible threads are the strongest ties.”		
				<br>
				- Friedrich Nietzsche
			</p>
		</div>
		<hr>
		<div class="contactMe text-center">
			<h5 class="subHeading text-center">Want to work with me?</h5>
<!--
			<h5 class="subHeading text-center">Want to have a chat? I'd love to hear from you!</h5>
			<p class="text-center">Whether you'd like to get a quote, ask a question or even just introduce yourself, don't hesitate to contact me. I'm always delighted to make new connections.</p>
-->
<!-- 		<a id="emailLink" href="mailto:moc.votaluberdna@tcatnoc"   onclick="window.open('mailto:moc.votaluberdna@tcatnoc', 'newwindow', 'width=500, height=600'); return false;" target="_blank"> -->
			<a class="btn btn-default text-center" id="emailLink" href="mailto:moc.votaluberdna@tcatnoc" target="_blank"><span class="fa fa-envelope"></span> Message Me</a>
		</div>
		<hr>
		<div class="row contactSocial">
			<div class="col-md-6">
				<ul class="no-bullets">
					<li>
						<a href="http://twitter.com/andrebulatov" target="_blank">
						<span class="fa fa-twitter"></span>
						@andrebulatov </a>
					</li>
					<li>
						<a href="http://www.linkedin.com/in/iamandrebulatov" target="_blank">
						<i class="fa fa-linkedin"></i>
						linkedin.com/in/andrebulatov</a>
					</li>
				</ul>
			</div>
			<div class="col-md-6">
				<ul class="no-bullets">
					<li>
						<!-- <a href="callto://+***********">Link will initiate Skype to call my number!</a> -->
						<a href="skype:andre.bulatov?call" target="_blank">
							<span class="fa fa-skype"></span>andre.bulatov
						</a>
					</li>
					<li>
						<a href="https://plus.google.com/+AndreBulatov/" target="_blank" >
							<span class="fa fa-google-plus"></span>+AndreBulatov
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

</div><!-- END frontPage -->



<?php get_footer(); ?>


