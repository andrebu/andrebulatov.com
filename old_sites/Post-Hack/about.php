<?php
/*
Template Name: About
*/
?>



<?php get_header(); ?>






<div class="frontPage"> <!-- aboutPage -->

<nav class="navbar navbar-default" id="navbar-page" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".navbar-page">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
<!--
		<button type="button" class="navbar-toggle pull-left" data-toggle="collapse" data-target=".navbar-site">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
-->
	</div>
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-page">
		<ul class="nav navbar-nav">
			<li class="active"><a href="#profile">Profile</a></li>
			<li><a href="#experience">Experience</a></li>
			<li><a href="#abilities">Abilities</a></li>
			<li><a href="#portfolio">Portfolio</a></li>
			<li><a href="#interests">Interests</a></li>
			<li><a href="#causes">Causes</a></li>
			<li><a href="#contact">Contact</a></li>
		</ul>
	
<!-- 		<div class="collapse navbar-collapse navbar-site"></div> -->
<!--
		<ul class="nav navbar-nav">
			<li class="active"><a href="#home">Home</a></li>
			<li><a href="#blog">Blog</a></li>
			<li><a href="#resume">Resume</a></li>
			<li><a href="#work">Work</a></li>
			<li><a href="#aboutme">About Me</a></li>
			<li><a href="#contactme">Contact Me</a></li>
		</ul>
-->
	</div><!-- /.navbar-collapse -->

</nav>






<div id="profile" class="container">
	<h2 class="themeColor profileHeading">Profile</h2>
	<p class="lead">Hi! I'm an aspiring full stack web developer, nanotech engineer, and corporate raider</p>
	<hr>
	<div class="row">
		<div class="col-md-4">
			<h3>About me</h3>
			<p>
				I am a front-end web developer, aspiring to be an all around computer scientist as well as a full stack developer.  I am a programmer with good knowledge of front and back-end techniques and a thirst and ability to learn. From large eCommerce operations, to personal portfolio or blogging sites, I build awesome websites that yield my clients the desired results.		
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





<div class="background-theme">
	<div id="experience" class="container">
		<h2 class="themeColor profileHeading">Experience</h2>
		<p class="lead">
			“And if my heart be scarred and burned,
			<br>
			The safer, I, for all I learned.” 
			<br>
			- Dorothy Parker
		</p>
		<hr>
		<h3>Work</h3>
		<div class="experience">
			<div class="experience row">
				<div class="col-md-4">
					<h4>Freelance</h4>
					<p class="experience-period">
						Mar 2003 - 
						present			
					</p>
				</div>
				<div class="col-md-8">
					<p>
						<strong>Freelance Work</strong>
						<span>
							I've learned a lot doing freelance work. A. LOT.
						</span>
						<span class="experience-details">
							<span class="location">
								<span class="fa fa-map-marker"></span>
								Earth					
							</span>
						</span>
					</p>
				</div>
			</div>
<!--
			<div class="experience row">
				<div class="col-md-4">
					<h4> </h4>
					<p class="experience-period">
						Aug 1999 - 
						Jun 2004			
					</p>
				</div>
				<div class="col-md-8">
					<p>
						<strong></strong>
						<span>
							I've learned a lot doing freelance work.
						</span>
						<span class="experience-details">
							<span class="location">
								<span class="fa fa-map-marker"></span>
								Edison, NJ					
							</span>
						</span>
					</p>
				</div>
			</div>
-->
		</div>
		<hr>
		<h3>Education</h3>
		<div class="experience">
			<div class="experience row">
				<div class="col-md-4">
					<h4>Rutgers</h4>
					<p class="experience-period">
						Sep 2003 - 
						Jun 2005 (d/o)			
					</p>
				</div>
				<div class="col-md-8">
					<p>
						<strong>Bachelor's Degree - Economics Major (dropped out)</strong>
						<span>
							Above all, I learned how to learn.  In the painful process of learning the meaning and value of relationships, I also learned to listen, to be proactive, and to stand on my own feet.  In the sphere of practical knowledge, I gained much towards the understanding of economics and money -- from the creation of money itself to the collective behaviors of consumers and businesses, from the small beginnings of garage startups to the board room meetings of transnational corporations, from the basics of supply and demand theories to the stock exchange and credit ratings, whenever a topic in economics, money and finance is mentioned I am typically at least familiar with it.  Unfortunately, I learned almost nothing about code while I was in college.</span>
						<span class="experience-details">
							<span class="location">
								<span class="fa fa-map-marker"></span>
								New Brunswick, NJ					
							</span>
						</span>
					</p>
				</div>
			</div>
			<div class="experience row">
				<div class="col-md-4">
					<h4>J.P. Stevens</h4>
					<p class="experience-period">
						Aug 1999 - 
						Jun 2004			
					</p>
				</div>
				<div class="col-md-8">
					<p>
						<strong>High school</strong>
						<span>
							I <i>barely</i> graduated high school.  Looking back, I am happy I made it out alive with my mind in tact.  In spite of my savage self and my ignorant surroundings, I was able to learn one of the most important lessons of a human's life: "Feed the intellect and starve the beast."  The yields from learning this lesson and putting it to work wouldn't show up for years, but I enjoy them today.  Thank you Mr. Greer. <!-- I learned that learning was an independent endeavor, and that teachers are just people in need of a job, being severely underpaid by the government.  Quickly I learned not to depend on "adults" for anything, let alone real learning.  Yet still, there were some gems of teachers that Ive had the fortune to be taught by, one that comes to mind is Mr. Greer. -->
						</span>
						<span class="experience-details">
							<span class="location">
								<span class="fa fa-map-marker"></span>
								Edison, NJ					
							</span>
						</span>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>





<div id="abilities" class="container">
	<h2 class="themeColor profileHeading">Abilities</h2>
	<p class="lead">
		“Know yourself.”
		<br>
		- Temple of Apollo at Delphi
	</p>
	<hr>
	<h3>Languages</h3>
	<div class="row">
		<div class="col-md-6">
			<ul class="no-bullets">
				<li>
					<span class="ability-title">English (Doubleplusgood)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>
					<span class="ability-title">Russian (Fluent)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled" data-content="\f005"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>
					<span class="ability-title">Spanish (Un poco)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled" data-content="\f005"></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
			</ul>
		</div>
		<div class="col-md-6">
			<ul class="no-bullets">
				<li>
					<span class="ability-title">German (Ein bißchen)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>
					<span class="ability-title">French (Un petit peu)</span>
					<span class="ability-score">
						<span class="fa fa-star half-filled" data-content="\f005"></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li> 
					<span class="ability-title">Computer (01011001)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
					</span>
				</li>
			</ul>
		</div>
	</div>
	<hr>
	<h3>Skills</h3>
	<div class="row">
<!--
		<div class="col-sm-12 col-md-12 col-lg-12">
			<h4>Front End</h4>
		</div>
-->
  		<div class="col-md-6">
			<ul class="no-bullets">
				<li>	
					<span class="ability-title">CSS(3)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">HTML(5)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">Bootstrap Framework</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">JQuery</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled" data-content="\f005"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">Javascript</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled" data-content="\f005"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">SASS</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled" data-content="\f005"></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">PHP</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled" data-content="\f005"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">MySQL</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">MongoDB</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">Ruby</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">Python</span>
					<span class="ability-score">
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">AngularJS</span>
					<span class="ability-score">
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">BackboneJS</span>
					<span class="ability-score">
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">C++</span>
					<span class="ability-score">
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">Apache</span>
					<span class="ability-score">
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">Linux</span>
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
		<div class="col-md-6">
			<ul class="no-bullets">
				<li>	
					<span class="ability-title">SEO</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">e-Commerce</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">BigCommerce</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">Shopify</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">Volusion</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled" data-content="\f005"></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">Wordpress</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled" data-content="\f005"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">XML</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">Command line</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled" data-content="\f005"></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
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
				<li>	
					<span class="ability-title">Java</span>
					<span class="ability-score">
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">ExpressJS</span>
					<span class="ability-score">
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">NodeJS</span>
					<span class="ability-score">
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">Swift</span>
					<span class="ability-score">
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">C#</span>
					<span class="ability-score">
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">Nginx</span>
					<span class="ability-score">
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</li>
				<li>	
					<span class="ability-title">AWS</span>
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
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>
					<span class="ability-title">Notepad++ (7 years)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>
					<span class="ability-title">Firefox (7 years)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>					
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>
					<span class="ability-title">Webkit (6 years)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>
					<span class="ability-title">Filezilla (5 years)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>
					<span class="ability-title">MS Office (10+ years)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
			</ul>
		</div>
		<div class="col-md-6">
			<ul class="no-bullets">
				<li>
					<span class="ability-title">Mac (5 years)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>
					<span class="ability-title">Coda2 (2 years)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>
					<span class="ability-title">IE 6+ (3 years)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled"></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>
					<span class="ability-title">Adobe PS (6 years)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>
					<span class="ability-title">Git (1 year)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
				<li>
					<span class="ability-title">My Noggin' (30+ years)</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
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
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
<!-- 						<span class="fa fa-plus filled"></span> -->
					</span>
				</li>
				<li>
					<span class="ability-title">Problem Solving</span>
					<span class="ability-score">
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
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
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star filled"></span>
						<span class="fa fa-star half-filled"></span>
					</span>
				</li>
				<li>
					<span class="ability-title">Sense of Humor</span>
					<span class="ability-score">
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
						<span class="fa fa-star "></span>
					</span>
				</li>
			</ul>
		</div>
	</div>
</div>



<div class="background-theme">
	<div id="portfolio" class="container">
		<h2 class="themeColor profileHeading">Portfolio</h2>
		<p class="lead">
			“If I had asked people what they wanted, they would have said faster horses. ”	        
			<br>
			- Henry Ford
		</p>
		<div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12">
				<figure class="effect">
					<img src="/wp-content/uploads/Thinking_Limo_Bootstrap_site-new-white-600x400-1.png" alt="Thinking Limo">
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
					<img src="/wp-content/uploads/DankStop_Bootstrap_site-new-white-600x400-1.png" alt="DankStop Online Headshop">
					<figcaption>
						<h3>DankStop</h3>
						<p>A big e-commerce wbesite built on LAMP, using PHP, JS and more.</p>
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
					<img src="/wp-content/uploads/AltSpace_Bootstrap_site-new-white-600x400-1.png" alt="AltSpace NY Co-working">
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
					<img src="/wp-content/uploads/GreenLabs_Bootstrap_site-new-white-600x400-1.png" alt="Playful Arts Festival">
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
			<!--
				<div class="col-md-6 col-sm-12 col-xs-12">
					<figure class="effect">
						<img src="/wp-content/uploads/Thinking_Limo_Bootstrap_site-new-white-600x400-1.png" alt="Thinking Limo">
						
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
						<img src="/wp-content/uploads/DankStop_Bootstrap_site-new-white-600x400-1.png" alt="DankStop Online Headshop">
						
						<figcaption>
							<h3>DankStop</h3>
							<p>A big e-commerce wbesite built on LAMP, using PHP, JS and more.</p>
							<p><strong>Tags:</strong> <br>Development, Design, PHP, JavaScript, e-commerce, jQuery, + more</p>
							<a href="http://dankstop.com" target="_blank">View more</a>
							<span class="icon">
								<span class="glyphicon glyphicon-new-window"></span>
							</span>
						</figcaption> 
					</figure>
				</div>
				       -->
		</div>
	</div>
</div>



<div id="interests" class="container">
	<h2 class="themeColor profileHeading">Interests</h2>
	<p class="lead">
<!-- 		"One person with a belief is equal to ninety-nine who have only interests." <br>- John Stuart Mill -->
		"There is much pleasure in useless knowledge." <br>— Bertrand Russell
	</p>
	<hr>
	<div class="row" id="algorithms">
		<div class="col-md-4 left">
			<img src="/wp-content/uploads/algorithms.png" alt="Algorithms" width="220" height="220">
		</div>
		<div class="col-md-8 interest-content">
			<h3>Algorithms</h3>
			<p>I love solving riddles and problems and building stuff from scratch. My strong suit is that I don't give up. When trying to find the solution to a problem, I will not quit until I find at least one. The satisfaction I get from solving a problem can really make my day.</p>
		</div>
	</div>
	<div class="row" id="music">
		<div class="col-md-4 right">
			<img class="heartBeatSOS" src="/wp-content/uploads/music.png" alt="Music" width="220" height="220">
		</div>
		<div class="col-md-8 interest-content">
			<h3>Music</h3>
			<p> I can listen to music all day, especially when I'm working.  As I sit here and type, rock, roll, swaying and bumping to the beat, I crunch out complex pages of code, while my mind dances freely to the song.  I love the juxtaposition of round, flowy, open-ended, music and the structured, rigid, strict order of computer code.  I love trying to work the order and freedom into each other, for a combination of the best of both worlds.</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 left">
			<img src="/wp-content/uploads/cats.png" alt="My Cats" width="220" height="220">
		</div>
		<div class="col-md-8 interest-content">
			<h3>My Cats</h3>
			<p>I don't own any cats or any other "pets."  However, I do care for a family of 9 stray cats, who have taken up residence behind my house.  I used to chase them away, like everyone else did.  But then the Mom cat gave birth to a litter of beauties (the first time), and I've been taking good care of them ever since, like my own. And though I like to tell people that "I just couldn't refuse help to a damsel in distress," but I think I just wanted to care for someone.</p>
		</div>
	</div>
	<div class="row" id="technology">
		<div class="col-md-4 right">
			<img src="/wp-content/uploads/technology.png" alt="Technology" width="220" height="220">
		</div>
		<div class="col-md-8 interest-content">
			<h3>Technology</h3>
			<p>I couldn't live without technology. On the weekend you'll find me on my computer.  I just love the adrenaline rush!</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 left">
			<img src="/wp-content/uploads/exercise.png" alt="Excercize" width="220" height="220">
		</div>
		<div class="col-md-8 interest-content">
			<h3>Exercise</h3>
			<p>At least once or twice a week, you'll find me at the gym or just doing pushups at home.  A strong body makes the mind strong.  Also, feed the intellect and starve the beast, but that's not really here nor there.</p>
		</div>
	</div>
	<div class="row" id="coolCode">
		<div class="col-md-4 right">
			<div class="stage" style="width: 120px; height: 120px;">
				<div class="cubespinner">
					<div class="face1">1</div>
					<div class="face2">2</div>
					<div class="face3">3</div>
					<div class="face4">4</div>
					<div class="face5">5</div>
					<div class="face6"><img src="/wp-content/uploads/borat_dancing.gif" alt="Borat dancing!"></div>
				</div>
			</div>
		</div>
		<div class="col-md-8 interest-content">
			<h3>Cool Code</h3>
			<p>I love awesome code and grreat dancing fun!</p>
			<p>Turn down the volume on your computer and 
				<button id="harlem-shake" class="btn btn-success">Click Me!</button></p>
		</div>
	</div>
</div>


<div id="causes" class="container">
	<h2 class="themeColor profileHeading">Causes</h2>
	<p class="lead">
		"The strategic adversary is fascism... the fascism in us all, in our heads and in our everyday behavior, the fascism that causes us to love power, to desire the very thing that dominates and exploits us." <br>-Michel Foucault
	</p>
	<hr>
	<div class="row textcenter"><h3>Wikipedia</h3></div>
	<div class="row vertical-align" id="wikipedia">
		<div class="col-md-4 left">
			<a target="_blank" href="https://www.wikipedia.org/">
				<img src="/wp-content/uploads/causes/wikipedia.jpg" alt="Wikipedia Logo" title="Wikipedia">
			</a>
		</div>
		<div class="col-md-8 interest-content">
			<p>
				<blockquote>Wikipedia is a free-access, free content Internet encyclopedia, supported and hosted by the non-profit Wikimedia Foundation. Those who can access the site and follow its rules can edit most of its articles. Wikipedia is the seventh-most popular website and constitutes the Internet's largest and most popular general reference work.</blockquote>
			</p>
		</div>
	</div>
	<div class="row textcenter"><h3>Mozilla</h3></div>
	<div class="row vertical-align" id="mozilla">
		<div class="col-md-4 right">
			<a target="_blank" href="http://www.mozilla.org/">
				<img src="/wp-content/uploads/causes/mozilla.png" alt="Mozilla Logo" title="Mozilla">
			</a>
		</div>
		<div class="col-md-8 interest-content">
			<p>
				<blockquote>Mozilla is a free software community best known for producing the Firefox web browser. The Mozilla community uses, develops, spreads and supports Mozilla products, thereby promoting exclusively free software and open standards, with only minor exceptions. The community is supported institutionally by the Mozilla Foundation and its tax-paying subsidiary, the Mozilla Corporation.</blockquote>
			</p>
		</div>
	</div>
	<div class="row textcenter"><h3>The Pirate Bay</h3></div>
	<div class="row vertical-align" id="thepiratebay">
		<div class="col-md-4 right">
			<a target="_blank" href="https://www.thepiratebay.org/">
				<img src="/wp-content/uploads/causes/thepiratebay.png" alt="The Pirate Bay Logo" title="The Pirate Bay">
			</a>
		</div>
		<div class="col-md-8 interest-content">
			<p>
				<blockquote>The Pirate Bay (commonly abbreviated TPB) is an online index of digital content of mostly entertainment nature, where visitors can search, download and contribute magnet links and torrent files, which facilitate peer-to-peer file sharing among users of the BitTorrent protocol.</blockquote>
			</p>
		</div>
	</div>
	<div class="row textcenter"><h3>Electronic Frontier Foundation</h3></div>
	<div class="row vertical-align" id="eff">
		<div class="col-md-4 left">
			<a target="_blank" href="https://www.eff.org/">
				<img src="/wp-content/uploads/causes/eff.png" alt="Electronic Frontier Foundation Logo" title="Electronic Frontier Foundation">
			</a>
		</div>
		<div class="col-md-8 interest-content">
			<p>
				<blockquote>
				<p>The Electronic Frontier Foundation (EFF) is an international non-profit digital rights group based in the United States.</p>
				<p>EFF provides funds for legal defense in court, presents amici curiae briefs, defends individuals and new technologies from what it considers baseless or misdirected legal threats, works to expose government malfeasance, provides guidance to the government and courts, organizes political action and mass mailings, supports some new technologies which it believes preserve personal freedoms, maintains a database and web sites of related news and information, monitors and challenges potential legislation that it believes would infringe on personal liberties and fair use, and solicits a list of what it considers patent abuses with intentions to defeat those that it considers without merit.</p></blockquote>
			</p>
		</div>
	</div>
	<div class="row textcenter"><h3>American Civil Liberties Union</h3></div>
	<div class="row vertical-align" id="aclu">
		<div class="col-md-4 right">
			<a target="_blank" href="https://www.aclu.org/">
				<img src="/wp-content/uploads/causes/aclu.jpg" alt="American Civil Liberties Union Logo" title="American Civil Liberties Union">
			</a>
		</div>
		<div class="col-md-8 interest-content">
			<p>
				<blockquote>The American Civil Liberties Union (ACLU) is a nonpartisan non-profit organization whose stated mission is "to defend and preserve the individual rights and liberties guaranteed to every person in this country by the Constitution and laws of the United States."[5] It works through litigation, lobbying, and community empowerment. Founded in 1920 by Roger Baldwin, Crystal Eastman, and Walter Nelles, the ACLU has over 500,000 members and has an annual budget of over $100 million. Local affiliates of the ACLU are active in all 50 states and Puerto Rico. The ACLU provides legal assistance in cases when it considers civil liberties to be at risk. Legal support from the ACLU can take the form of direct legal representation, or preparation of amicus curiae briefs expressing legal arguments (when another law firm is already providing representation).</blockquote>
			</p>
		</div>
	</div>
	<div class="row textcenter"><h3>Wikileaks</h3></div>
	<div class="row vertical-align" id="wikileaks">
		<div class="col-md-4 left">
			<a target="_blank" href="http://wikileaks.org/">
				<img src="/wp-content/uploads/causes/wikileaks.png" alt="Wikileaks Logo" title="Wikileaks">	
			</a>
		</div>
		<div class="col-md-8 interest-content">
			<p>
				<blockquote>WikiLeaks is an international, non-profit, journalistic organization which publishes secret information, news leaks, and classified media from anonymous sources. Its website, initiated in 2006 in Iceland by the organization Sunshine Press, claimed a database of more than 1.2 million documents within a year of its launch. Julian Assange, an Australian Internet activist, is generally described as its founder, editor-in-chief, and director. Kristinn Hrafnsson, Joseph Farrell, and Sarah Harrison are the only other publicly known and acknowledged associates of Julian Assange. Hrafnsson is also a member of Sunshine Press Productions along with Assange, Ingi Ragnar Ingason, and Gavin MacFadyen.</blockquote>
			</p>
		</div>
	</div>
	<div class="row textcenter"><h3>Fight For The Future</h3></div>
	<div class="row vertical-align" id="ftff">
		<div class="col-md-4 left">
			<a target="_blank" href="http://www.fightforthefuture.org/">
				<img src="/wp-content/uploads/causes/fightforthefuture.png" alt="Fight For The Future Logo" title="Fight For The Future">
			</a>
		</div>
		<div class="col-md-8 interest-content">
			<p>
				<blockquote>Fight for the Future (often abbreviated fightfortheftr [or FFTF]) is a nonprofit advocacy group in the area of digital rights founded in 2011. The group aims to promote causes related to copyright legislation, as well as online privacy and censorship through the use of the Internet.</blockquote>
			</p>
		</div>
	</div>
	<div class="row textcenter"><h3>Free Press</h3></div>
	<div class="row vertical-align" id="freepress">
		<div class="col-md-4 right">
			<a target="_blank" href="http://www.freepress.net/">
				<img src="/wp-content/uploads/causes/freepress.jpg" alt="Free Press Logo" title="Free Press">
			</a>
		</div>
		<div class="col-md-8 interest-content">
			<p>
				<blockquote>Free Press is a nonpartisan organization fighting for people's rights to connect and communicate. Free Press works to save the free and open Internet, curb runaway media consolidation, protect press freedom, and ensure diverse voices are represented in our media.</blockquote>
			</p>
		</div>
	</div>
	<div class="row textcenter"><h3>Demand Progress</h3></div>
	<div class="vertical-align" id="demandprogress">
		<div class="col-md-4 right">
			<a target="_blank" href="http://www.demandprogress.org/">
				<img src="/wp-content/uploads/causes/demandprogress.jpg" alt="Demand Progress Logo" title="Demand Progress">
			</a>
		</div>
		<div class="col-md-8 interest-content">
			<p>
				<blockquote>Demand Progress is an internet activist-related 527 organization and 501(c)4 entity specializing in petitions to help gain traction for legal movements against internet censorship and related subjects. The organization has been deemed instrumental in fighting the Stop Online Piracy Act and the PROTECT IP Act, two highly controversial pieces of United States legislation. The organization continues to fight for its cause in the wake of the successful shelving of these two acts. Estimated membership numbers in early 2013 weigh in at over one million. As of late 2013, the organization encompasses the Demand Progress, Rootstrikers and Watchdog.net wings/brands.</blockquote>
			</p>
		</div>
	</div>
	<div class="row textcenter"><h3>Prism Break</h3></div>
	<div class="row vertical-align" id="prismbreak">
		<div class="col-md-4 right">
			<a target="_blank" href="https://prism-break.org/en/">
				<img src="/wp-content/uploads/causes/prismbreak.png" alt="Prism Break Logo" title="Prism Break">
			</a>
		</div>
		<div class="col-md-8 interest-content">
			<p>
				<blockquote><a href="https://prism-break.org/" rel="nofollow" target="_blank">PRISM-break.org</a> is an awesome, <a href="https://github.com/nylira/prism-break" rel="nofollow" target="_blank">open source</a> project that provides links to secure, open source alternatives to the most popular software and services.  Born out of the news of overreaching NSA spying on US citizens, PRISM-break.org is your go to resource for all your open source software and service needs.</blockquote>
			</p>
		</div>
	</div>
	<div class="row textcenter"><h3>Open Source Software Initiative</h3></div>
	<div class="row vertical-align" id="ossi">
		<div class="col-md-4 left">
			<a target="_blank" href="http://opensource.org/">
				<img src="/wp-content/uploads/causes/ossi.png" alt="Open Source Software Initiative Logo" title="Open Source Software Initiative">
			</a>
		</div>
		<div class="col-md-8 interest-content">
			<p>
				<blockquote>Wikipedia is a free-access, free content Internet encyclopedia, supported and hosted by the non-profit Wikimedia Foundation. Those who can access the site and follow its rules can edit most of its articles. Wikipedia is the seventh-most popular website and constitutes the Internet's largest and most popular general reference work.</blockquote>
			</p>
		</div>
	</div>
	<div class="row textcenter"><h3>Stop Watching Us</h3></div>
	<div class="row vertical-align" id="stopwatchingus">
		<div class="col-md-4 right">
			<a target="_blank" href="https://rally.stopwatching.us/">
				<img src="/wp-content/uploads/causes/stopwatchingus.png" alt="Stop Watching Us Logo" title="Stop Watching Us">
			</a>
		</div>
		<div class="col-md-8 interest-content">
			<p>
				<blockquote>Wikipedia is a free-access, free content Internet encyclopedia, supported and hosted by the non-profit Wikimedia Foundation. Those who can access the site and follow its rules can edit most of its articles. Wikipedia is the seventh-most popular website and constitutes the Internet's largest and most popular general reference work.</blockquote>
			</p>
		</div>
	</div>
</div>













<div class="background-footer">
	<div id="contact" class="container">
		<h2 class="themeColor profileHeading">Contact</h2>
		<p class="lead">
			“Invisible threads are the strongest ties.”		
			<br>
			- Friedrich Nietzsche
		</p>
		<hr>
		<div class="contactMe text-center">
			<h5 class="subHeading text-center">Want to have a chat? I'd love to hear from you!</h5>
			<p class="text-center">Whether you'd like to get a quote, ask a question or even just introduce yourself, don't hesitate to contact me. I'm always delighted to make new connections.</p>
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
						<a href="skype:andre.bulatov?call" target="_blank">
						<span class="fa fa-skype"></span>
						andre.bulatov				</a>
						<!-- <a href="callto://+***********">Link will initiate Skype to call my number!</a> -->
					</li>
					<li>
						<a id="emailLink" href="mailto:moc.votaluberdna@tcatnoc" target="_blank">
<!-- 						<a id="emailLink" href="mailto:moc.votaluberdna@tcatnoc"   onclick="window.open('mailto:moc.votaluberdna@tcatnoc', 'newwindow', 'width=500, height=600'); return false;" target="_blank"> -->
						<span class="fa fa-envelope"></span>
						<span class="contactEmail">
						moc.votaluberdna@tcatnoc					</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

</div><!-- END aboutPage -->



<?php get_footer(); ?>


