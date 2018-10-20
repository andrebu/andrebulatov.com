<?php
/*
Template Name: Default
*/
?>



<?php get_header(); ?>



<div class="container hfeed h-feed" itemprop="hasPart" itemscope itemtype="http://schema.org/Blog">

<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Home loop
	/*-----------------------------------------------------------------------------------*/
	
	if( is_home() || is_archive() ) {
	
?>
			<?php $i = 0; ?>
			<?php if ( have_posts() ) : ?>

				<?php if ( function_exists('yoast_breadcrumb') ) {yoast_breadcrumb('<p id="breadcrumbs">','</p>');} ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php $i++; ?>
					<article class="post hentry h-entry <?php if ($i%2){echo "even";}else{echo "odd"; } ?>" 
						itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
						<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" 
							itemid="<?php echo site_url().'/'.get_page_uri( $page ); ?>"/>

						<h2 class="title entry-title" itemprop="headline">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
								<?php the_title() ?>
							</a>
						</h2>
						<div class="post-meta">
							<time class="entry-date date updated" itemprop="datePublished" datetime="<?php echo get_the_date( 'c' ); ?>">
								<?php the_time( get_option( 'date_format' ) ); ?> 
							</time>
							by 
							<span class="entry-author" itemprop="author" itemscope itemtype="http://schema.org/Person">
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"  class="entry-author-link" itemprop="url" rel="author" title="More posts by <?php comment_author(); ?>">
									<div class="entry-author-photo">
										<img src="<?php echo get_avatar_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author(); ?>'s Photo" alt="<?php the_author(); ?>'s Photo" itemprop="image" width="19" height="19" />
									</div>
									<span class="entry-author-name" itemprop="name">
						            	<span class="vcard author p-author h-card">
						            		<span class="fn"><?php the_author(); ?></span>
						            	</span>
									</span>
								</a>
							</span>
							<?php if( comments_open() ) : ?>
								<span class="comments-link">
									<?php comments_popup_link( __( 'Comment', 'break' ), __( '1 Comment', 'break' ), __( '% Comments', 'break' ) ); ?>
								</span>
							<?php endif; ?>
						
						</div><!--/post-meta -->
						<div class="the-content" itemprop="text">
							<?php if ( has_post_thumbnail() ): ?>
									<div class="thumb-container" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
											<img width="243" height="149" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>" class="" alt="<?php echo get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true); ?>" title="<?php the_title(); ?>">
											<meta itemprop="url" content="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>">
											<meta itemprop="width" content="243">
											<meta itemprop="height" content="149">
										</a>
									</div>
							<?php endif ?>
							<div class="entry-summary">
								<?php the_excerpt( 'Continue...' ); ?> <!-- Andre edited the_content to the_excerpt -->
							</div>
							
							<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
								<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
<!-- 									<img src="/wp-content/uploads/images/Andre.png" alt="Andre Bulatov" width="300" height="300" > -->
									<meta itemprop="url" content="https://andrebulatov.com/wp-content/uploads/images/Andre.png">
									<meta itemprop="width" content="300">
									<meta itemprop="height" content="300">
								</div>
								<meta itemprop="name" content="Andre Bulatov LLC">
							</div>
							<meta itemprop="datePublished" content="<?php echo get_the_date( 'c' ); ?>"/>
							<meta itemprop="dateModified" content="<?php echo get_the_modified_date( 'c' ); ?>"/>
							<?php wp_link_pages(); ?>
						</div><!-- the-content -->

						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>

<!-- 						The sidebar stuff goes in between, and then… -->
						
						<?php endif; ?>

						<div class="meta clearfix">
							<div class="category"><?php echo get_the_category_list(); ?></div>
							<span>| &nbsp;</span>
							<div class="tags"><?php echo get_the_tag_list( '&nbsp;', '&nbsp;' ); ?></div>
						</div><!-- Meta -->
						
					</article>

				<?php endwhile; ?>
				
				<!-- pagintation -->
				<div id="pagination" class="clearfix">
					<div class="past-page"><?php previous_posts_link( 'Newer &raquo;' ); ?></div>
					<div class="next-page"><?php next_posts_link( ' &laquo; Older' ); ?></div>
				</div><!-- pagination -->


			<?php else : ?>
				
				<article class="post error">
					<h1 class="404">Nothing posted yet</h1>
				</article>

			<?php endif; ?>

		
	<?php } //end is_home(); ?>

<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Single loop
	/*-----------------------------------------------------------------------------------*/
	
	if( is_single() ) {
?>


			<?php if ( have_posts() ) : ?>

				<?php if ( function_exists('yoast_breadcrumb') ) {yoast_breadcrumb('<p id="breadcrumbs">','</p>');} ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<article class="post hentry h-entry " itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
						<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" 
							itemid="<?php echo site_url().'/'.get_page_uri( $page ); ?>"/>
					
						<h1 class="title entry-title" itemprop="headline"><?php the_title() ?></h1>
						<div class="post-meta">
							<time class="entry-date date updated" itemprop="datePublished" datetime="<?php echo get_the_date( 'c' ); ?>">
								<?php the_time( get_option( 'date_format' ) ); ?> 
							</time>
							by 
							<span class="entry-author" itemprop="author" itemscope itemtype="http://schema.org/Person">
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"  class="entry-author-link" itemprop="url" rel="author" title="More posts by <?php the_author(); ?>">
									<div class="entry-author-photo">
										<img src="<?php echo get_avatar_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author(); ?>'s Photo" alt="<?php the_author(); ?>'s Photo" itemprop="image" width="19" height="19" />
									</div>
									<span class="entry-author-name" itemprop="name">
						            	<span class="vcard author p-author h-card">
						            		<span class="fn"><?php the_author(); ?></span>
						            	</span>
									</span>
								</a>
							</span>
							<?php if( comments_open() ) : ?>
								<span class="comments-link">
									<?php comments_popup_link( __( 'Comment', 'less' ), __( '1 Comment', 'less' ), __( '% Comments', 'less' ) ); ?>
								</span>
							<?php endif; ?>
						
						</div><!--/post-meta -->
						
						<div class="the-content" itemprop="text">
							<?php if ( has_post_thumbnail() ): ?>
							<div class="image-container" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
								<img width="728" height="446" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>" class="" alt="<?php echo get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true); ?>" title="<?php the_title(); ?>">
								<meta itemprop="url" content="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>">
								<meta itemprop="width" content="728">
								<meta itemprop="height" content="446">
							</div>
							<?php endif ?>
							<?php the_content( 'Continue...' ); ?>
							
							<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
								<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
<!-- 									<img src="/wp-content/uploads/images/Andre.png" alt="Andre Bulatov" width="300" height="300" > -->
									<meta itemprop="url" content="https://andrebulatov.com/wp-content/uploads/images/Andre.png">
									<meta itemprop="width" content="300">
									<meta itemprop="height" content="300">
								</div>
								<meta itemprop="name" content="Andre Bulatov LLC">
							</div>
							<meta itemprop="datePublished" content="<?php echo get_the_date( 'c' ); ?>"/>
							<meta itemprop="dateModified" content="<?php echo get_the_modified_date( 'c' ); ?>"/>
							<?php wp_link_pages(); ?>
						</div><!-- the-content -->
						
						<div class="meta clearfix">
							<div class="category"><?php echo get_the_category_list(); ?></div>
							<span>| &nbsp;</span>
							<div class="tags"><?php echo get_the_tag_list( '&nbsp;', '&nbsp;' ); ?></div>
						</div><!-- Meta -->						
						
					</article>

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

					<article class="post hentry h-entry " itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
						<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" 
							itemid="<?php echo site_url().'/'.get_page_uri( $page ); ?>"/>
					
						<h1 class="title entry-title" itemprop="headline"><?php the_title() ?></h1>
						
						<div class="the-content" itemprop="text">
							<?php if ( has_post_thumbnail() ): ?>
							<div class="image-container" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
								<img width="728" height="446" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>" class="" alt="<?php echo get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true); ?>" title="<?php the_title(); ?>">
								<meta itemprop="url" content="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>">
								<meta itemprop="width" content="728">
								<meta itemprop="height" content="446">
							</div>
							<?php endif ?>
							<?php the_content(); ?>
							
							<span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
								<span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
									<meta itemprop="url" content="https://andrebulatov.com/wp-content/uploads/images/Andre.png">
									<meta itemprop="width" content="300">
									<meta itemprop="height" content="300">
								</span>
								<meta itemprop="name" content="Andre Bulatov LLC">
							</span>
							<meta itemprop="datePublished" content="<?php echo get_the_date( 'c' ); ?>"/>
							<meta itemprop="dateModified" content="<?php echo get_the_modified_date( 'c' ); ?>"/>
							<?php wp_link_pages(); ?>
						</div><!-- the-content -->
						
					</article>

				<?php endwhile; ?>

			<?php else : ?>
				
				<article class="post error">
					<h1 class="404">Nothing posted yet</h1>
				</article>

			<?php endif; ?>

	<?php } // end is_page(); ?>


</div><!-- / container-->



<?php get_footer(); ?>


 