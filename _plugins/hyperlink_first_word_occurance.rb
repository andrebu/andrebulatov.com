# _plugins/hyperlink_first_word_occurance.rb
require 'liquid'
require 'uri'

# Capitalize all words of the input
module HyperlinkFirstWordOccurance
	def hyperlink_first_word_occurance(words)
	
		# return a.sub(post.title, "<a href="{{ post.url }}">{{ post.title }}</a>")
	
		return words.split(' ').map(&:capitalize).join(' ')
	end
end

# Liquid::Template.register_filter(HyperlinkFirstWordOccurance)
