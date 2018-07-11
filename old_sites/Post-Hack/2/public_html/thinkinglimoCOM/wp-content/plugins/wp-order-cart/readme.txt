=== WP Order Cart ===
Contributors: cpbrand
Donate link: http://webolution.co.za/
Tags: online catalogue shopping cart checkout send order
Requires at least: 3.1
Tested up to: 3.5
Stable tag: 1.2
License: GPLv2 or later

Create an online catalogue with products that can be ordered via shopping cart with checkout, details of orders are sent to specified email address.

== Description ==

WP Order Cart uses custom post types for products and product categories - create your online catalogue with unlimited number of products and sell them in any of 80 supported international currencies. Shopping cart functionality with checkout page with checkout form where the client can supply basic details - online payment is not included at present, payment and shipping arrangements is the responsibility of the seller after they receive the order email. 

Features:

 * Easy to install, configure and use
 * Sell in 80 different international currencies! 
 * Products and Product Categories using WordPress custom post types
 * Unlimited Products, Product Categories
 * Shopping Cart Widget
 * Checkout page with Checkout form to place order
 * Product Search Widget
 * Price Slider Search Widget
 * Extra widget areas for product pages, product listing pages as well as checkout page
 * Add single products to pages and posts via shortcode
 
 More information and demonstration - <http://wpordercart.webolution.co.za> 

== Installation ==

1. Upload `wpordercart` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Appearance - Widgets and add 'WPOCShoppingCartWidget' to 'WPOrderCart Shopping Cart Area', enter title e.g. 'Shopping Cart' and save
4. Optionally add 'WPOrderCartSearchWidget' (Product search) and 'WPOrderCartPriceSliderWidget' (Price slider search) to any available widget areas
5. Create a new page or decide on a current page to use as your checkout page - this will be set in step 6
6. Click on 'WP Order Cart' in WordPress admin menu to setup default settings 
7. Start adding product categories and products from 'WP Order Cart' sub menu items
8. To add product categories to your website navigation menu go to 'Appearance - Menus', ensure 'Products' and 'Product Categories' are checked under 'Screen Options' and drag and drop as required
9. Optionally add single products to pages and posts via the shortcode [wpordercart display="product" id="123"] where id is the product (post) id

== Frequently Asked Questions ==

= Does WP Order Cart include online payment and shipping options? =
No. WP Order Cart does not offer online payment nor shipping options at this point - payment and shipping arrangements are the responsibility of the seller after they receive the order email.

= Is it possible to include a custom message or instructions when orders are placed? =
Yes - in WP Order Cart settings there are textboxes for on site instructions to buyer when placing and order as well as thank you messages displayed on site when order is placed and in the order email which the user receives when placing the order. This could be utilised to include EFT payment details, Paypal account details or other payment details or instructions as well as any other information required when an order is placed.  

= Which currencies are supported in WP Order Cart? =
For a full list of supported international currencies visit <http://wpordercart.webolution.co.za/list-of-currencies>

= Can the plugin be used as an online catalogue only with price on request? =
Yes - in WP Order Cart settings there is a setting 'Show price' which has three options - Show price, Show P.O.R. (Price on request) and Don't show price which could be set depending on your requirements.

= Is it possible to change the look (css) of the buttons used in the WP Order Cart plugin? =
Yes - in WP Order Cart settings the setting 'Buttons CSS class' can be used to add a CSS class to all buttons used in the plugin - by default no additional styles or css is added to the buttons.

== Screenshots ==

1. Screenshot of category listing of products with Shopping Cart widget, Product Search and Price Range Slider on the right.
2. Checkout page with checkout form.
3. WP Order Cart Settings accessible through WP Admin menu 'WP Order Cart'.

== Changelog ==

= 1.0 =
* 20130105 Initial release.
= 1.1 =
* 20130105 Fixed a bug regarding location of plugin directory when loading WP Order Cart templates.
= 1.2 =
* 20130105 Version synching to 1.2.

== Upgrade Notice ==

= 1.0 =
Initial release.
= 1.1 =
Fixed a bug regarding location of plugin directory when loading WP Order Cart templates.
= 1.2 =
Version synching to 1.2.