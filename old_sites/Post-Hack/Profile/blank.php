<?php
/*
Template Name: Blank
*/
?>

<style>
/* Navigation */
#navIcon {
	position:relative;
	top:6px;
	left:65px;
	width:40px;
	height:40px;
	overflow:hidden;
	cursor:pointer;
	background:#FF9000;
	border-radius:6px 0 0 0;
	-moz-transition: all 0.6s ease-in-out 0s; -webkit-transition: all 0.6s ease-in-out 0s;
	-o-transition: all 0.6s ease-in-out 0s; transition: all 0.6s ease-in-out 0s;
}
#navIcon div {
	position:absolute;
	background:transparent;
	cursor: pointer;
}
#navIcon div:nth-child(1) {
	position:absolute;
	width:0;
	height:0;
	top:50%;
	left:20px;
	border-width:7px 0 7px 8px;
	border-style:solid;
	border-color:transparent #fff;
	margin-top:-7px;
}
#navIcon div:nth-child(2) {
	position:absolute;
	top:50%;
	left:12px;
	width:8px;
	height:6px;
	margin-top:-3px;
	background:#fff;
}
#simpleNav {
	position: fixed;
	top:10px;
	width: 100px;
	height:0;
	-webkit-user-select:none;
	-moz-user-select:none;
	-ms-user-select: none;
	z-index: 999;
}
#nav-switch {
	display: none;
}
#simpleNav .navLabel {
	display: block;
	cursor: pointer;
}
#simpleNav .navBox {
	position:absolute;
	width: 100%;
	left: -100px;
	-moz-transition: left 0.3s ease-in-out 0s; -webkit-transition: left 0.3s ease-in-out 0s;
	-o-transition: left 0.3s ease-in-out 0s; transition: left 0.3s ease-in-out 0s;
}
#simpleNav .navBox > div {
	float: left;
	width: 50%;
	padding: 0;
}
#simpleNav .navBox .nav-on {
	padding-left: 0;
	color: #fff;
}
#simpleNav .navBox .nav-off {
	width:40px;
	height:40px;
	padding-right: 10px;
}
#nav-switch:checked + .navLabel .navBox {
	left: 10px;
}
#nav-switch:checked + .navLabel #navIcon {
	background:#0065CB;
	-webkit-transform:rotate(-180deg);
	-moz-transform:rotate(-180deg);
	-ms-transform:rotate(-180deg);
	-o-transform:rotate(-180deg);
	transform:rotate(-180deg);
	border-radius:0 0 6px 0;
}
.navTitle {
	position: absolute;
	top: 2px;
	margin:0;
	padding:0;
	left: 170px;
	font-size:24px;
	line-height:40px;
	height:40px;
	font-family: "Segoe UI Light", "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
	font-weight:lighter;
	color:#000;
	white-space: nowrap;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	-o-user-select: none;
	user-select: none;
}
.navMenu {
	position: relative;
	left: 0;
	top: 6px;
	list-style-type:none;
	margin:0;
	padding:0;
	font-family: "Segoe UI Light", "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
	font-weight:lighter;
	color: #000;
	font-size:1em;
	cursor:pointer;
}
.navMenu li {
	position:relative;
	list-style:none;
	cursor: pointer;
	width: 100px;
	height: 40px;
	border-right:#222 solid 1px;
}
.navMenu a {
	position:relative;
	text-decoration: none;
	display:block;
	line-height:40px;
	color:#000;
	padding-left:40px;
	border: none;
}
.navMenu li a:hover, .navMenu  li a:focus, .navMenu  li a:active {
	background:#ff9000;
}
#simpleNav li:before,
#simpleNav li:after,
#simpleNav li a:before,
#simpleNav li a:after {
	content:"";
	position:absolute;
	top:50%;
	margin-left:10px;
	box-sizing: initial; 
}
#simpleNav .home a:before {
	left:2px;
	border-style:solid;
	border-color:transparent;
	border-width:8px 7px;
	border-bottom-color:#000;
	margin-top:-16px;
}
#simpleNav .home a:after {
	left:4px;
	width:2px;
	height:4px;
	border-style:solid;
	border-color:#000 #000 transparent;
	border-width:3px 4px 0;
	margin-top:0;
}
#simpleNav .arrow a:before {
	left:8px;
	border-width:7px 0 7px 8px;
	border-style:solid;
	border-color:transparent #000;
	margin-top:-7px;
}
#simpleNav .arrow a:after {
	left:0;
	width:8px;
	height:6px;
	margin-top:-3px;
	background:#000;
}
#simpleNav .arrow.back a:before {
	left:0;
	border-width:7px 8px 7px 0;
}
#simpleNav .arrow.back a:after {
	left:8px;
}
#simpleNav .list a:before {
	top:14px;
	left:5px;
	width:12px;
	height:2px;
	border-width:6px 0;
	border-style:double;
	border-color:#000;
	background:transparent;
}
#simpleNav .list a:after{
	top:14px;
	left:1px;
	width:2px;
	height:2px;
	border-width:6px 0;
	border-style:double;
	border-color:#000;
	background:transparent;
}
</style>

<div id="simpleNav">
	<input type="checkbox" name="nav-switch" id="nav-switch">
	<label class="navLabel" for="nav-switch">
		<div class="navBox">
			<div class="nav-on">
				<ul class="navMenu">
					<li class="home"><a href="/">Home</a></li>
					<li class="list"><a href="/blog">Blog</a></li>
					<li class="list"><a href="/about">About</a></li>
					<li class="list"><a href="/awesome-code">Awsm</a></li>
					<li class="list"><a href="/contact">Contact</a></li>
					<li class="arrow back"> <?php previous_post_link('%link', 'Prev', TRUE); ?> </li>				
					<li class="arrow"> <?php next_post_link('%link', 'Next', TRUE); ?> </li>				
				</ul>
			</div>
			<div class="nav-off">
				<div id="navIcon"><div></div><div></div></div>
				<h1 class="navTitle"></h1>
			</div>
		</div>
	</label>
</div> 




<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Single loop
	/*-----------------------------------------------------------------------------------*/
	
	if( is_single() ) {
?>


			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

							<?php if( comments_open() ) : ?>
								<span class="comments-link">
									<?php comments_popup_link( __( 'Comment', 'less' ), __( '1 Comment', 'less' ), __( '% Comments', 'less' ) ); ?>
								</span>
							<?php endif; ?>
						
				<?php endwhile; ?>
				
				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				?>


			<?php else : ?>
				
				<article class="post error">
					<h1 class="404">Nothing posted yet</h1>
				</article>

			<?php endif; ?>


	<?php } //end is_single(); ?>
	
<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Page loop
	/*-----------------------------------------------------------------------------------*/
	
	if( is_page()) {
?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

							<?php the_content(); ?>
							
				<?php endwhile; ?>

			<?php else : ?>
				
				<article class="post error">
					<h1 class="404">Nothing posted yet</h1>
				</article>

			<?php endif; ?>

		<?php } // end is_page(); ?>






 