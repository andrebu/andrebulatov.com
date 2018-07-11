<?php
/*
Template Name: Calibration
*/
?>
<?php 
	/*-----------------------------------------------------------------------------------*/
	/* Typography and Styles Calibration Page
	/*-----------------------------------------------------------------------------------*/
	/**
	 *
	 * This page is used to calibrate all general CSS
	 *
	 * @package WordPress
	 * @subpackage Profile
	 * @since Profile 1.0
	 */
?>



<?php get_header(); ?>






<nav class="navbar navbar-default" id="navbar-page" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".navbar-page">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<button type="button" class="navbar-toggle pull-left" data-toggle="collapse" data-target=".navbar-site">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-page">
		<ul class="nav navbar-nav">
			<li class="active"><a href="#intro">Intro</a></li>
			<li><a href="#headings">Headings</a></li>
			<li><a href="#paragraphs">Paragraphs</a></li>
			<li><a href="#lists">Lists</a></li>
			<li><a href="#forms">Forms</a></li>
			<li><a href="#tables">Tables</a></li>
			<li><a href="#blockquotes">blockquotes</a></li>
			<li><a href="#misc">Misc</a></li>
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





<div id="intro" class="container">

<!-- <h1 class="titleHeading">Heading 1</h1>

<p class="subHeading">A sub-heading or byline.
    
<h2 class="sectionHeading">Heading 2</h2>

<p class="">First paragraph in a section or series of paragraphs.&nbsp; This paragraph is indented and the first letter is a dropcap.</p>
<p>
    Sample Content to Plugin to Template 
</p>
-->

<h2>Introduction to Typography, Elements and CSS Calibration Page</h2>

<p>The purpose of this HTML is to help determine what default settings are with CSS and to make sure that all possible HTML Elements are included in this HTML so as to not miss any possible Elements when designing a site.</p>

<p>Below is just about every HTML element I might want to use in my blog posts. Until I provide proper documentation for ever class and element, the source code may be checked for any elements embedded in paragraphs or other elements.</p>

<p>If you have any suggestion about how to make this page better and more useful for web designers across the web, <a id="emailLink" href="mailto:moc.votaluberdna@tcatnoc" target="_blank" rel="nofollow">drop me a line</a> or contribute to this page <a href="https://github.com/iamandrebulatov/CSS-Calibration-Page" target="_blank" rel="nofollow">here on github</a>.</p>

</div><!-- END intro -->


<hr>


<div id="headings" class="container">

<h1>Heading 1</h1>


<h2>Heading 2</h2>


<h3>Heading 3</h3>


<h4>Heading 4</h4>


<h5>Heading 5</h5>


<h6>Heading 6</h6>

<h6 class="themeColor">.themeColor H6</h6>

<h6 class="profileHeading">.profileHeading H6</h6>

<h6 class="themeColor profileHeading">.themeColor .profileHeading H6</h6>

</div> <!--  END headings -->


<hr>


<div id="paragraphs" class="container">

<h2>Paragraph</h2>

<p>Lorem ipsum dolor sit amet, <a href="#" title="test link">test link</a> adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus.</p>

<p>Lorem ipsum dolor sit amet, <em>emphasis</em> consectetuer adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus.</p>

<p>Lorem ipsum dolor sit amet, <a title="test link" href="#">test link</a> adipiscing elit. <strong>This is strong.</strong> Nullam dignissim convallis est. Quisque aliquam. <em>This is emphasized.</em> Donec faucibus. Nunc iaculis suscipit dui. 5<sup>3</sup> = 125. Water is H<sub>2</sub>O. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. <cite>The New York Times</cite> (That’s a citation). <span style="text-decoration:underline;">Underline.</span> Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus. <abbr title="HyperText Markup Language">HTML</abbr> and <abbr title="Cascading Style Sheets">CSS</abbr> are our tools. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. To copy a file type <code>COPY <var>filename</var></code>.</p>

<p><del>Dinner’s at 5:00.</del><ins>Let’s make that 7.</ins></p>

<p>This <span style="text-decoration:line-through;">text</span> has been struck.</p>

</div><!-- END paragraphs -->


<hr>


<div id="lists" class="container">

<h2>List Types</h2>

<h3>Unordered List</h3>
<p>Let’s start with an unordered list:</p>
<ul>
    <li>List Item 1</li>
    <li>List Item 2</li>
    <li>List Item 3</li>
</ul>

<h3>Definition List</h3>
<p>A definition list (these are rarely used, at lest by me):</p>
<dl>
<dt>Definition List Title</dt>

    <dd>This is a definition list division.</dd>
</dl>

<h3>Ordered List</h3>
<p>Ordered lists follow a simple numerical order from 1 to whatever:</p>
<ol>
    <li>List Item 1</li>
    <li>List Item 2</li>
    <li>List Item 3</li>
</ol>

<p>Now we'll move on to a more interesting ordered list:</p>
<ol>
    <li>one, two
        <ol>
            <li>buckle my shoe</li>
        </ol>
    </li>
    <li>three, four
        <ol>
            <li>knock at the door</li>
        </ol>
    </li>
    <li>Five, six
        <ol>
            <li>pick up sticks</li>
        </ol>
    </li>
    <li>Seven, eight, lay them straight
        <ol>
            <li>Nine, ten, a big fat hen</li>
            <li>Eleven, twelve, dig and delve</li>
            <li>Thirteen, fourteen, maids a’courting</li>
            <li>Fifteen, sixteen, maids in the kitchen</li>
            <li>Seventeen, eighteen, maids a’waiting</li>
            <li>Nineteen, twenty, my platter’s empty …</li>
        </ol>
    </li>
</ol>

</div><!-- END lists -->


<hr>


<div id="forms" class="container">

<h2>Forms</h2>

<fieldset>
    <legend>Legend</legend>
    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus.</p>

    <form>
        
	<h2>Form Element</h2>

        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui.</p>
        <p>
            <label for="text_field">Text Field:</label>
            <br>
            <input type="text" id="text_field">
        </p>
        <p>
            <label for="text_area">Text Area:</label>
            <br>
            <textarea id="text_area"></textarea>
        </p>
        <p>
            <label for="select_element">Select Element:</label>
            <br>
            <select name="select_element">
                <optgroup label="Option Group 1">
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                </optgroup>
                <optgroup label="Option Group 2">
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                </optgroup>
            </select>
        </p>
        <p>
            <label for="radio_buttons">Radio Buttons:</label>
        </p>
        <p>
            <input type="radio" class="radio" name="radio_button" value="radio_1">Radio 1
            <br>
            <br>
            <input type="radio" class="radio" name="radio_button" value="radio_2">Radio 2
            <br>
            <br>
            <input type="radio" class="radio" name="radio_button" value="radio_3">Radio 3
            <br>
        </p>
        <p>
            <label for="checkboxes">Checkboxes:</label>
        </p>
        <p>
            <input type="checkbox" class="checkbox" name="checkboxes" value="check_1">Radio 1
            <br>
            <br>
            <input type="checkbox" class="checkbox" name="checkboxes" value="check_2">Radio 2
            <br>
            <br>
            <input type="checkbox" class="checkbox" name="checkboxes" value="check_3">Radio 3
            <br>
        </p>
        <p>
            <label for="password">Password:</label>
        </p>
        <p>
            <input type="password" class="password" name="password">
        </p>
        <p>
            <label for="file">File Input:</label>
            <br>
            <input type="file" class="file" name="file">
        </p>
        <p>
            <input class="button" type="reset" value="Clear">
            <input class="button" type="submit" value="Submit">
        </p>
        <p></p>
    </form>
</fieldset>

</div><!-- END forms -->


<hr>


<div id="tables" class="container">

<h2>Tables</h2>

<table cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <th>Table Header 1</th>
            <th>Table Header 2</th>
            <th>Table Header 3</th>
        </tr>
        <tr>
            <td>Division 1</td>
            <td>Division 2</td>
            <td>Division 3</td>
        </tr>
        <tr class="even">
            <td>Division 1</td>
            <td>Division 2</td>
            <td>Division 3</td>
        </tr>
        <tr>
            <td>Division 1</td>
            <td>Division 2</td>
            <td>Division 3</td>
        </tr>
    </tbody>
</table>

</div><!-- END tables -->


<hr>


<div id="blockquotes" class="container">

<h2>Blockquotes</h2>

<p>Let’s keep it simple.</p>

<blockquote>
    <p>“This stylesheet is going to help so freaking much.”
        <br>-Blockquote</p>
</blockquote>

<p>And here's a bigger one with a link in it.</p>

<blockquote>
	<p>
		Good afternoon, gentlemen. I am a HAL 9000 computer. I became operational at the H.A.L. plant in Urbana, Illinois on the 12th of January 1992. My instructor was Mr. Langley, and he taught me to sing a song. If you’d like to hear it I can sing it for you. <cite>— <a href="http://en.wikipedia.org/wiki/HAL_9000">HAL 9000</a></cite>
	</p>
</blockquote>

<p>And here’s a bit of trailing text.</p>

</div><!-- END blockquotes -->


<hr>



<div id="misc" class="container">

<h2>Miscellaneous Stuff</h2>

<p>Here I'll cover the remaining miscellaneous HTML elements such as abbr, acronym, pre, code, sub, sup, etc.</p>

<h2>LaTeX</h2>

<p>Lorem <sup>superscript</sup> dolor <sub>subscript</sub> amet, consectetuer adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. <cite>cite</cite>. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy. <acronym title="National Basketball Association">NBA</acronym> Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus. <abbr title="Avenue">AVE</abbr>


<h3>Inline</h3>
<p>Hello <img src='https://s0.wp.com/latex.php?latex=LaTeX&#038;bg=ffffff&#038;fg=333333&#038;s=0' alt='LaTeX' title='LaTeX' class='latex' />, <a href="http://en.support.wordpress.com/latex/">how are you?</a></p>
<p>Hello $latex LaTeX$, <a href="http://en.support.wordpress.com/latex/">how are you?</a></p>
<p>Hello [latex]LaTeX[/latex], <a href="http://en.support.wordpress.com/latex/">how are you?</a></p>

<p>This has a superscript <img src='https://s0.wp.com/latex.php?latex=M%5EM&#038;bg=ffffff&#038;fg=333333&#038;s=0' alt='M^M' title='M^M' class='latex' /> in it.</p>
<p>This has a subscript <img src='https://s0.wp.com/latex.php?latex=W_W&#038;bg=ffffff&#038;fg=333333&#038;s=0' alt='W_W' title='W_W' class='latex' /> in it.</p>
<p>This has both <img src='https://s0.wp.com/latex.php?latex=M%5EM_M&#038;bg=ffffff&#038;fg=333333&#038;s=0' alt='M^M_M' title='M^M_M' class='latex' /> zomg.</p>
<p>Getting crazy <img src='https://s0.wp.com/latex.php?latex=M%5E%7BM_M%7D&#038;bg=ffffff&#038;fg=333333&#038;s=0' alt='M^{M_M}' title='M^{M_M}' class='latex' /> woo.</p>
<p>Hey now <img src='https://s0.wp.com/latex.php?latex=M_%7BM%5EM%7D&#038;bg=ffffff&#038;fg=333333&#038;s=0' alt='M_{M^M}' title='M_{M^M}' class='latex' /> stop it.</p>
<p>One more: <img src='https://s0.wp.com/latex.php?latex=M%5EM_M++M%5E%7BM_M%7D+M_%7BM%5EM%7D&#038;bg=ffffff&#038;fg=333333&#038;s=0' alt='M^M_M  M^{M_M} M_{M^M}' title='M^M_M  M^{M_M} M_{M^M}' class='latex' /></p>
<p>Here&#8217;s a fancy formula <img src='https://s0.wp.com/latex.php?latex=displaystyle+P_nu%5E%7B-mu%7D%28z%29%3Dfrac%7Bleft%28z%5E2-1right%29%5E%7Bfrac%7Bmu%7D%7B2%7D%7D%7D%7B2%5Emu+sqrt%7Bpi%7DGammaleft%28mu%2Bfrac%7B1%7D%7B2%7Dright%29%7Dint_%7B-1%7D%5E1frac%7Bleft%281-t%5E2right%29%5E%7Bmu+-frac%7B1%7D%7B2%7D%7D%7D%7Bleft%28z%2Btsqrt%7Bz%5E2-1%7Dright%29%5E%7Bmu-nu%7D%7Ddt&#038;bg=ffffff&#038;fg=333333&#038;s=0' alt='displaystyle P_nu^{-mu}(z)=frac{left(z^2-1right)^{frac{mu}{2}}}{2^mu sqrt{pi}Gammaleft(mu+frac{1}{2}right)}int_{-1}^1frac{left(1-t^2right)^{mu -frac{1}{2}}}{left(z+tsqrt{z^2-1}right)^{mu-nu}}dt' title='displaystyle P_nu^{-mu}(z)=frac{left(z^2-1right)^{frac{mu}{2}}}{2^mu sqrt{pi}Gammaleft(mu+frac{1}{2}right)}int_{-1}^1frac{left(1-t^2right)^{mu -frac{1}{2}}}{left(z+tsqrt{z^2-1}right)^{mu-nu}}dt' class='latex' /> inline.</p>
<p>A more different fancy formula <img src='https://s0.wp.com/latex.php?latex=P_nu%5E%7B-mu%7D%28z%29%3Dfrac%7Bleft%28z%5E2-1right%29%5E%7Bfrac%7Bmu%7D%7B2%7D%7D%7D%7B2%5Emu+sqrt%7Bpi%7DGammaleft%28mu%2Bfrac%7B1%7D%7B2%7Dright%29%7Dint_%7B-1%7D%5E1frac%7Bleft%281-t%5E2right%29%5E%7Bmu+-frac%7B1%7D%7B2%7D%7D%7D%7Bleft%28z%2Btsqrt%7Bz%5E2-1%7Dright%29%5E%7Bmu-nu%7D%7Ddt&#038;bg=ffffff&#038;fg=333333&#038;s=0' alt='P_nu^{-mu}(z)=frac{left(z^2-1right)^{frac{mu}{2}}}{2^mu sqrt{pi}Gammaleft(mu+frac{1}{2}right)}int_{-1}^1frac{left(1-t^2right)^{mu -frac{1}{2}}}{left(z+tsqrt{z^2-1}right)^{mu-nu}}dt' title='P_nu^{-mu}(z)=frac{left(z^2-1right)^{frac{mu}{2}}}{2^mu sqrt{pi}Gammaleft(mu+frac{1}{2}right)}int_{-1}^1frac{left(1-t^2right)^{mu -frac{1}{2}}}{left(z+tsqrt{z^2-1}right)^{mu-nu}}dt' class='latex' /></p>
<h3>On a separate line</h3>
<p><img src='https://s0.wp.com/latex.php?latex=displaystyle+P_nu%5E%7B-mu%7D%28z%29%3Dfrac%7Bleft%28z%5E2-1right%29%5E%7Bfrac%7Bmu%7D%7B2%7D%7D%7D%7B2%5Emu+sqrt%7Bpi%7DGammaleft%28mu%2Bfrac%7B1%7D%7B2%7Dright%29%7Dint_%7B-1%7D%5E1frac%7Bleft%281-t%5E2right%29%5E%7Bmu+-frac%7B1%7D%7B2%7D%7D%7D%7Bleft%28z%2Btsqrt%7Bz%5E2-1%7Dright%29%5E%7Bmu-nu%7D%7Ddt&#038;bg=ffffff&#038;fg=333333&#038;s=0' alt='displaystyle P_nu^{-mu}(z)=frac{left(z^2-1right)^{frac{mu}{2}}}{2^mu sqrt{pi}Gammaleft(mu+frac{1}{2}right)}int_{-1}^1frac{left(1-t^2right)^{mu -frac{1}{2}}}{left(z+tsqrt{z^2-1}right)^{mu-nu}}dt' title='displaystyle P_nu^{-mu}(z)=frac{left(z^2-1right)^{frac{mu}{2}}}{2^mu sqrt{pi}Gammaleft(mu+frac{1}{2}right)}int_{-1}^1frac{left(1-t^2right)^{mu -frac{1}{2}}}{left(z+tsqrt{z^2-1}right)^{mu-nu}}dt' class='latex' /></p>
<p><img src='https://s0.wp.com/latex.php?latex=P_nu%5E%7B-mu%7D%28z%29%3Dfrac%7Bleft%28z%5E2-1right%29%5E%7Bfrac%7Bmu%7D%7B2%7D%7D%7D%7B2%5Emu+sqrt%7Bpi%7DGammaleft%28mu%2Bfrac%7B1%7D%7B2%7Dright%29%7Dint_%7B-1%7D%5E1frac%7Bleft%281-t%5E2right%29%5E%7Bmu+-frac%7B1%7D%7B2%7D%7D%7D%7Bleft%28z%2Btsqrt%7Bz%5E2-1%7Dright%29%5E%7Bmu-nu%7D%7Ddt&#038;bg=ffffff&#038;fg=333333&#038;s=0' alt='P_nu^{-mu}(z)=frac{left(z^2-1right)^{frac{mu}{2}}}{2^mu sqrt{pi}Gammaleft(mu+frac{1}{2}right)}int_{-1}^1frac{left(1-t^2right)^{mu -frac{1}{2}}}{left(z+tsqrt{z^2-1}right)^{mu-nu}}dt' title='P_nu^{-mu}(z)=frac{left(z^2-1right)^{frac{mu}{2}}}{2^mu sqrt{pi}Gammaleft(mu+frac{1}{2}right)}int_{-1}^1frac{left(1-t^2right)^{mu -frac{1}{2}}}{left(z+tsqrt{z^2-1}right)^{mu-nu}}dt' class='latex' /></p>

<br>


<h2>Pre-formatted Text</h2>

<p>Typographically, preformatted text is not the same thing as code. Sometimes, a faithful execution of the text requires preformatted text that may not have anything to do with code. For&nbsp;example:</p>

<pre>“Beware the Jabberwock, my son!
    The jaws that bite, the claws that catch!
Beware the Jubjub bird, and shun
    The frumious Bandersnatch!”</pre>

<p>Here is another, bigger example with even more variation and other elements embedded inside it</p>
    
<pre>
<p>
This is a test of text inside a &lt;pre&gt; that is inside a &lt;p&gt; tag. 
Also, a sweet list of all character entities can be found at <a href="http://dev.w3.org/html5/html-author/charref" rel="nofollow" target="_blank">http://dev.w3.org/html5/html-author/charref</a>
Lorem ipsum dolor sit amet,
 consectetuer adipiscing elit.
 Nullam dignissim convallis est.
 Quisque aliquam. Donec faucibus. 
Nunc iaculis suscipit dui. 
Nam sit amet sem. 
Aliquam libero nisi, imperdiet at,
 tincidunt nec, gravida vehicula,
 nisl. 
Praesent mattis, massa quis 
    luctus fermentum, turpis mi 
       volutpat justo, eu volutpat 
           enim diam eget metus. 
Maecenas ornare tortor. 
Donec sed tellus eget sapien
 fringilla nonummy. 
<acronym title="National Basketball Association">NBA</acronym> 
Mauris a ante. Suspendisse
 quam sem, consequat at, 
commodo vitae, feugiat in, 
nunc. Morbi imperdiet augue
 quis tellus.  
<abbr title="Avenue">AVE</abbr>
</p>
</pre>

<h3>Code</h3>

<p>Code can be presented inline, like <code>&lt;?php bloginfo('stylesheet_url'); ?&gt;</code>, or within a <code>&lt;pre&gt;</code> block.</p>

<pre><code>#container { float: none; margin: 0 auto; width: 100%; }</code></pre>

</div><!-- END misc -->



</div>



<?php get_footer(); ?>


