# _plugins/hyperlink_first_word_occurance.rb
require "jekyll"
# require 'liquid'
require 'uri'


module Jekyll

	# Replace the first occurance of each post title in the content with the post's title hyperlink
	module HyperlinkFirstWordOccurance
		BODY_START_TAG = "<body"
		OPENING_BODY_TAG_REGEX = %r!<body(.*)>\s*!

		class << self
			# Public: Processes the content and updates the 
			# first occurance of each word that also has a post
			# of the same title, into a hyperlink.
			#
			# content - the document or page to be processes.
			def process(content)
				@site_url = content.site.config["url"]
				@posts = content.site.posts
				
# 				return unless content.output.include?(post.title)
				
				content.output = if content.output.include? BODY_START_TAG
									process_html(content)
								else
									process_words(content.output)
								end
			end
	
	
			# Public: Determines if the content should be processed.
			#
			# doc - the document being processes.
			def processable?(doc)
				(doc.is_a?(Jekyll::Page) || doc.write?) &&
					doc.output_ext == ".html" || (doc.permalink&.end_with?("/"))
			end
		
		
			private
			
			# Private: Processes html content which has a body opening tag.
			#
			# content - html to be processes.
			def process_html(content)
				head, opener, tail = content.output.partition(OPENING_BODY_TAG_REGEX)
				body_content, *rest = tail.partition("</body>")
				
				processed_markup = process_words(body_content)
				
				content.output = String.new(head) << opener << processed_markup << rest.join
			end
			
			# Private: Processes each word of the content and makes
			# the first occurance of each word that also has a post
			# of the same title, into a hyperlink.
			#
			# html = the html which includes all the content.
			def process_words(html)
				page_content = Nokogiri::HTML::DocumentFragment.parse(html)
				page_copy = page_content.css("page__content").content
# 				page_copy = html
# 				site = context.registers[:site]
# 				site.posts.each do |post|
# 				posts = context.registers[:posts]
				posts = @posts
				posts.docs.each do |post|
					post_title = post.data['title'] || post.name
					if page_copy.include? post_title
						page_copy = page_copy.sub(post_title, "<a href=\"#{ post.data['url'] }\">#{ post_title }</a>")
					end
				end
				page_content.to_html
# 				page_copy.to_html
# 				page_copy
			end

		# 		def generate(site)
		# 		  site.categories.each do |category|
		# 		    build_subpages(site, "category", category)
		# 		  end
		# 		
		# 		  site.tags.each do |tag|
		# 		    build_subpages(site, "tag", tag)
		# 		  end
		# 		end
		# 	
		# 		return words.split(' ').map(&:capitalize).join(' ')
		end
	end
end


# Liquid::Template.register_filter(HyperlinkFirstWordOccurance)
# Jekyll::Hooks.register :posts, :post_render do |post|
Jekyll::Hooks.register %i[posts pages documents], :post_render do |doc|
  # code to call after Jekyll renders a post
  Jekyll::HyperlinkFirstWordOccurance.process(doc) if Jekyll::HyperlinkFirstWordOccurance.processable?(doc)
end
