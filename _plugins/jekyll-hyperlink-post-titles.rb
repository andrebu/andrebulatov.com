# _plugins/jekyll-hyperlink-post-titles.rb
require "jekyll"
require 'uri'


module Jekyll

	# Replace the first occurance of each post title in the content with the post's title hyperlink
	module HyperlinkFirstWordOccurance
		POST_CONTENT_CLASS = "page__content"
		BODY_START_TAG = "<body"
		ASIDE_START_TAG = "<aside"
		CLOSING_ASIDE_TAG_REGEX = %r!</aside(.*)>\s*!

		class << self
			# Public: Processes the content and updates the 
			# first occurance of each word that also has a post
			# of the same title, into a hyperlink.
			#
			# content - the document or page to be processed.
			def process(content)
				@title = content.data['title']
				@posts = content.site.posts
				
				content.output = if content.output.include? BODY_START_TAG
									process_html(content)
								else
									process_words(content.output)
								end
			end
	
	
			# Public: Determines if the content should be processed.
			#
			# doc - the document being processed.
			def processable?(doc)
				(doc.is_a?(Jekyll::Page) || doc.write?) &&
					doc.output_ext == ".html" || (doc.permalink&.end_with?("/"))
			end
		
		
			private
			
			# Private: Processes html content which has a body opening tag.
			#
			# content - html to be processed.
			def process_html(content)
				content.output = if content.output.include? ASIDE_START_TAG
					head, opener, tail = content.output.partition(CLOSING_ASIDE_TAG_REGEX)
								else
					head, opener, tail = content.output.partition(POST_CONTENT_CLASS)
								end
				body_content, *rest = tail.partition("</body>")
				
				processed_markup = process_words(body_content)
				
				content.output = String.new(head) << opener << processed_markup << rest.join
			end
			
			# Private: Processes each word of the content and makes
			# the first occurance of each word that also has a post
			# of the same title, into a hyperlink.
			#
			# html - the html which includes all the content.
			def process_words(html)
				page_content = html
# 				page_content = Nokogiri::HTML::DocumentFragment.parse(html)
# 				page_content = page_content.css("page__content")
				@posts.docs.each do |post|
					post_title = post.data['title'] || post.name
					post_title_lowercase = post_title.downcase
# 					if post_title != @title

						if page_content.include?(" " + post_title_lowercase + " ") ||
							page_content.include?(post_title_lowercase + " ") ||
							page_content.include?(post_title_lowercase + ",") ||
							page_content.include?(post_title_lowercase + ".")
# 							if post_title_lowercase == "groller"
# 							puts "YES, " + post_title_lowercase + " will be replaced"
# 							end
							page_content = page_content.sub(post_title_lowercase, "<a href=\"#{post.url}\">#{post_title.downcase}</a>")
						elsif page_content.include?(" " + post_title + " ") ||
							page_content.include?(post_title + " ") ||
							page_content.include?(post_title + ",") ||
							page_content.include?(post_title + ".")
# 							if post_title == "Groller"
# 							puts "YES, " + post_title + " will be replaced"
# 							end
							page_content = page_content.sub(post_title, "<a href=\"#{post.url}\">#{post_title}</a>")
						end
# 					end
				end
# 				page_content.to_html
				page_content
			end
		end
	end
end


Jekyll::Hooks.register %i[posts], :post_render do |doc|
  # code to call after Jekyll renders a post
  Jekyll::HyperlinkFirstWordOccurance.process(doc) if Jekyll::HyperlinkFirstWordOccurance.processable?(doc)
end