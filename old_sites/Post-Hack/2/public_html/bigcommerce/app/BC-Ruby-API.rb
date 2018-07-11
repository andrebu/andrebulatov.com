# https://github.com/bigcommerce/bigcommerce-api-ruby

require 'bigcommerce'

api = Bigcommerce::Api.new({
  :store_url => "https://store.mybigcommerce.com",
  :username  => "username",
  :api_key   => "api_key"
})