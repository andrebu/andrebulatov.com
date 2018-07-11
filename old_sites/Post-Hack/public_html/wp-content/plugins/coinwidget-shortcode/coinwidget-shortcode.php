<?php
/*
 * Plugin Name: Coinbase-Shortcode
 * Version: 2.0
 * Plugin URI: http://notions.okuda.ca
 * Description: Shortcode for coinwidget.com buttons
 * Author: Kaz Okuda
 * Author URI: http://notions.okuda.ca
 * Requires at least: 3.0
 * Tested up to: 3.7.1
 */

class CoinWidget {

	public function __construct() {
		$this->coinwidget_url = trailingslashit( plugins_url( '/coinwidget.com/', __FILE__ ) );
		$this->root_url = trailingslashit( plugins_url( '/', __FILE__ ) );
		add_action('init', array( $this, 'on_init' ));
		add_shortcode('coinwidget', array( $this, 'handle_shortcode' ));
	}
	
	function on_init()
	{
		// Include the coin.js code with the other script includes
		wp_enqueue_script('ko-coinwidget', $this->root_url . 'coin_js_wrapper.php', array('jquery'));
	}

	function handle_shortcode($atts)
	{
		extract(shortcode_atts(array(
			'address' => null,
			'currency' => null,
			'counter' => null,
			'alignment' => null,
			'qrcode' => null,
			'auto_show' => null,
			'decimals' => null,
			'lbl_button' => null,
			'lbl_address' => null,
			'lbl_count' => null,
			'lbl_amount' => null,
		), $atts));

		ob_start();
		
		// Create a unique ID by using a static counter that increases for each instance.
		STATIC $count = 0;
		$count++;
		$id = "ko_coinwidget_" . $count;

		// Default the 'lbl_address' to the appropriate string depending on the 'currency' if not set.
		if  ($lbl_address == null)
		{
			switch ($currency) {
				case 'litecoin':
					$lbl_address = 'My Litecoin Address:';
					break;
				case 'dogecoin':
					$lbl_address = 'My Dogecoin Address:';
					break;
				case 'bitcoin':
				default:
					$lbl_address = 'My Bitcoin Address:';
					break;				
			}
		}

		?>
			<span id="<?php echo $id ?>"></span>
			<script>
			CoinWidgetCom.source = "<?php echo $this->coinwidget_url ?>"
			CoinWidgetCom.go({
				wallet_address: "<?php echo $address ?>"
<?php
				if ($currency) {echo ",currency: \"" . $currency . "\"";}
				if ($counter) {echo ",counter: \"" . $counter . "\"";}
				if ($alignment) {echo ",alignment: \"" . $alignment . "\"";}
				if ($qrcode) {echo ",qrcode: " . $qrcode;}
				if ($auto_show) {echo ",auto_show: " . $auto_show;}
				if ($decimals) {echo ",decimals: " . $decimals;}
				if ($lbl_button) {echo ",lbl_button: \"" . $lbl_button . "\"";}
				if ($lbl_address) {echo ",lbl_address: \"" . $lbl_address . "\"";}
				if ($lbl_count) {echo ",lbl_count: \"" . $lbl_count . "\"";}
				if ($lbl_amount) {echo ",lbl_amount: \"" . $lbl_amount . "\"";}
?>
			}, '#<?php echo $id?>');
			</script>
		<?php

		return ob_get_clean();
	}
}

$plugin_obj = new CoinWidget();
