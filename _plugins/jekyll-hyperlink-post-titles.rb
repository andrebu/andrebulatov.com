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
# 				nokogiri_html = Nokogiri::HTML::DocumentFragment.parse(html)
# 				page_content = nokogiri_html.text
# 				page_content = Nokogiri::HTML(html).xpath('//text()').inner_text
				puts page_content
# 				page_content = page_content.css("page__content")
				@posts.docs.each do |post|
					post_title = post.data['title'] || post.name
					post_title_lowercase = post_title.downcase
					lowercase_title_regex = Regexp.new(/(?<= |^)#{post_title_lowercase}(?= |\.|,|$)/) 
					uppercase_title_regex = Regexp.new(/(?<= |^)#{post_title}(?= |\.|,|$)/) 
# 					puts "lc re " + lowercase_title_regex.to_s
# 					puts "UUPc re " + uppercase_title_regex.to_s
# 					if post_title != @title


# doc.xpath('p/text()').grep(/plane/) do |node|
#   node_content, *remaining_texts = node.content.split(/(plane)/)
# 
#   node.content = node_content
#   remaining_texts.each do |text|
#     if text == 'plane' 
#       node = node.add_next_sibling('<a href="/some/url">plane</a>').last
#     else
#       node = node.add_next_sibling(text).last
#     end
#   end
#   break # Since first instance of Post Title has been replaced 
# end


						if lowercase_title_regex =~ page_content
							puts "lowercase regexp matched in "+@title+", replacing with " + post_title.downcase
# 						if page_content.include?(" " + post_title_lowercase + " ") ||
# 							page_content.include?(post_title_lowercase + " ") ||
# 							page_content.include?(post_title_lowercase + ",") ||
# 							page_content.include?(post_title_lowercase + ".")
# 							if post_title_lowercase == "groller"
# 							puts "YES, " + post_title_lowercase + " will be replaced"
# 							end
							page_content = page_content.sub(lowercase_title_regex, "<a href=\"#{post.url}\">#{post_title.downcase}</a>")
						elsif uppercase_title_regex =~ page_content 
							puts "uppercase regexp matched in "+@title+", replacing with " + post_title
# 						elsif page_content.include?(" " + post_title + " ") ||
# 							page_content.include?(post_title + " ") ||
# 							page_content.include?(post_title + ",") ||
# 							page_content.include?(post_title + ".")
# 							if post_title == "Groller"
# 							puts "YES, " + post_title + " will be replaced"
# 							end
							page_content = page_content.sub(uppercase_title_regex, "<a href=\"#{post.url}\">#{post_title}</a>")
						end
# 					end
				end
# 				nokogiri_html.to_html
				page_content
			end
		end
	end
end


Jekyll::Hooks.register %i[posts], :post_render do |doc|
  # code to call after Jekyll renders a post
  Jekyll::HyperlinkFirstWordOccurance.process(doc) if Jekyll::HyperlinkFirstWordOccurance.processable?(doc)
end