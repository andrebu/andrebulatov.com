// A wrapper around the coinwidget.com script "coin.js"
// coin.js depends on jQuery existing and being accessible as $ (doesn't work in Wordpress)
// This exposes $ as a variable and includes coin.js so as to make it work within Wordpress.

var CoinWidgetCom_Internal

(function($) {
<?php include("./coinwidget.com/coin.js")?>
CoinWidgetCom_Internal = CoinWidgetCom
})(jQuery);

CoinWidgetCom = CoinWidgetCom_Internal