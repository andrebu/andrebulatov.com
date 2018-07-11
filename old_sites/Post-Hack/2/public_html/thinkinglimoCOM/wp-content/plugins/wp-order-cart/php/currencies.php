<?php

function wpordercart_getcurrencyarray() {
	$returnarr = array(
		"ALL" => array("d" => "Albania Lek", "s" => "Lek"), 
		"ARS" => array("d" => "Argentina Peso", "s" => "$"), 
		"AWG" => array("d" => "Aruba Guilder", "s" => "&#402;"), 
		"AUD" => array("d" => "Australia Dollar", "s" => "$"),
		"BSD" => array("d" => "Bahamas Dollar", "s" => "$"),
		"BBD" => array("d" => "Barbados Dollar", "s" => "$"),
		"BYR" => array("d" => "Belarus Ruble", "s" => "p."),
		"BZD" => array("d" => "Belize Dollar", "s" => "BZ$"),
		"BMD" => array("d" => "Bermuda Dollar", "s" => "$"),
		"BOB" => array("d" => "Bolivia Boliviano", "s" => "\$b"),
		"BAM" => array("d" => "Bosnia and Herzegovina Convertible Marka", "s" => "KM"),
		"BWP" => array("d" => "Botswana Pula", "s" => "P"),
		"BRL" => array("d" => "Brazil Real", "s" => "R$"), 
		"BND" => array("d" => "Brunei Darussalam Dollar", "s" => "$"),
		"CAD" => array("d" => "Canada Dollar", "s" => "$"),
		"KYD" => array("d" => "Cayman Islands Dollar", "s" => "$"), 
		"CLP" => array("d" => "Chile Peso", "s" => "$"), 
		"CNY" => array("d" => "China Yuan Renminbi", "s" => "&#65509;"),
		"COP" => array("d" => "Colombia Peso", "s" => "$"), 
		"CRC" => array("d" => "Costa Rica Colon", "s" => "&#8353;"),
		"HRK" => array("d" => "Croatia Kuna", "s" => "kn"),
		"CZK" => array("d" => "Czech Republic Koruna", "s" => "Kc"),
		"DKK" => array("d" => "Denmark Krone", "s" => "kr"),
		"DOP" => array("d" => "Dominican Republic Peso", "s" => "RD$"),
		"XCD" => array("d" => "East Caribbean Dollar", "s" => "$"),
		"EGP" => array("d" => "Egypt Pound", "s" => "&pound;"),
		"SVC" => array("d" => "El Salvador Colon", "s" => "$"),
		"EEK" => array("d" => "Estonia Kroon", "s" => "kr"),
		"EUR" => array("d" => "Euro Member Countries", "s" => "&euro;"),
		"FKP" => array("d" => "Falkland Islands (Malvinas) Pound", "s" => "&pound;"),
		"FJD" => array("d" => "Fiji Dollar", "s" => "$"),
		"GHC" => array("d" => "Ghana Cedis", "s" => "GH&cent;"),				 						
		"GIP" => array("d" => "Gibraltar Pound", "s" => "&pound;"),
		"GTQ" => array("d" => "Guatemala Quetzal", "s" => "Q"),
		"GGP" => array("d" => "Guernsey Pound", "s" => "&pound;"),
		"GYD" => array("d" => "Guyana Dollar", "s" => "$"),
		"HNL" => array("d" => "Honduras Lempira", "s" => "L"),
		"HKD" => array("d" => "Hong Kong Dollar", "s" => "$"),
		"HUF" => array("d" => "Hungary Forint", "s" => "Ft"),
		"ISK" => array("d" => "Iceland Krona", "s" => "kr"),
		"IDR" => array("d" => "Indonesia Rupiah", "s" => "Rp"),
		"IMP" => array("d" => "Isle of Man Pound", "s" => "&pound;"),		
		"JMD" => array("d" => "Jamaica Dollar", "s" => "J$"),
		"JPY" => array("d" => "Japan Yen", "s" => "&yen;"),
		"JEP" => array("d" => "Jersey Pound", "s" => "&pound;"),
		"LVL" => array("d" => "Latvia Lat", "s" => "Ls"),
		"LBP" => array("d" => "Lebanon Pound", "s" => "&pound;"),
		"LRD" => array("d" => "Liberia Dollar", "s" => "$"),
		"LTL" => array("d" => "Lithuania Litas", "s" => "Lt"),
		"MYR" => array("d" => "Malaysia Ringgit", "s" => "RM"),
		"MXN" => array("d" => "Mexico Peso", "s" => "$"),
		"MZN" => array("d" => "Mozambique Metical", "s" => "MT"),
		"NAD" => array("d" => "Namibia Dollar", "s" => "$"),
		"ANG" => array("d" => "Netherlands Antilles Guilder", "s" => "&#402;"),
		"NZD" => array("d" => "New Zealand Dollar", "s" => "$"),
		"NIO" => array("d" => "Nicaragua Cordoba", "s" => "C$"),
		"NOK" => array("d" => "Norway Krone", "s" => "kr"),
		"PAB" => array("d" => "Panama Balboa", "s" => "B/."),
		"PYG" => array("d" => "Paraguay Guarani", "s" => "Gs"),
		"PEN" => array("d" => "Peru Nuevo Sol", "s" => "S/."),
		"PLN" => array("d" => "Poland Zloty", "s" => "zl"),
		"RON" => array("d" => "Romania New Leu", "s" => "lei"),
		"SHP" => array("d" => "Saint Helena Pound", "s" => "&pound;"),
		"SGD" => array("d" => "Singapore Dollar", "s" => "$"),
		"SBD" => array("d" => "Solomon Islands Dollar", "s" => "$"),
		"SOS" => array("d" => "Somalia Shilling", "s" => "S"),
		"ZAR" => array("d" => "South Africa Rand", "s" => "R"),
		"SEK" => array("d" => "Sweden Krona", "s" => "kr"),
		"CHF" => array("d" => "Switzerland Franc", "s" => "CHF"),
		"SRD" => array("d" => "Suriname Dollar", "s" => "$"),
		"SYP" => array("d" => "Syria Pound", "s" => "&pound;"),
		"TWD" => array("d" => "Taiwan New Dollar", "s" => "NT$"),
		"TTD" => array("d" => "Trinidad and Tobago Dollar", "s" => "TT$"),
		"TRL" => array("d" => "Turkey Lira", "s" => "&pound;"),
		"TVD" => array("d" => "Tuvalu Dollar", "s" => "$"),
		"GBP" => array("d" => "United Kingdom Pound", "s" => "&pound;"),
		"USD" => array("d" => "United States Dollar", "s" => "$"),
		"UYU" => array("d" => "Uruguay Peso", "s" => "\$U"),
		"VEF" => array("d" => "Venezuela Bolivar", "s" => "Bs"),
		"ZWD" => array("d" => "Zimbabwe Dollar", "s" => "Z$")																					
	);
	return $returnarr;
}

function wpordercart_getddlcurrencies($ddlid, $selected) {
	$ddlhtml = "<select id='" . $ddlid . "' >";
	$arr_currencies = wpordercart_getcurrencyarray();
	foreach($arr_currencies as $code => $description_symbol_arr) {
		$ddlhtml .= "<option value='" . $code . "'";
		if ($code == $selected) { $ddlhtml .= " selected='selected'"; }
		$ddlhtml .= " >" . $description_symbol_arr["d"] . " (" . $description_symbol_arr["s"] . ")</option>";
	}
	$ddlhtml .= "</select>";
	return $ddlhtml;
}

function wpordercart_getsymbolfromcode($code) {
	$arr_currencies = wpordercart_getcurrencyarray();
	return $arr_currencies[$code]["s"];
}

function wpordercart_getdescriptionfromcode($code) {
	$arr_currencies = wpordercart_getcurrencyarray();
	return $arr_currencies[$code]["d"];
}

?>