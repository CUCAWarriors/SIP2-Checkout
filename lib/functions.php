<?php
function xmlToArray($xml, $main_heading = '') {
$deXml = simplexml_load_string($xml);
    $deJson = json_encode($deXml);
    $xml_array = json_decode($deJson,TRUE);
    if (! empty($main_heading)) {
        $returned = $xml_array[$main_heading];
        return $returned;
    } else {
        return $xml_array;
    }
}
function isCheckedOut($itemCode, $opacURL) {



}
function runCheckout($patronCode, $itemCode, $sipServer, $sipPort, $sipPatron, $sipPassword) {
	$mysip = new sip2;

	$mysip->hostname = $sipServer;

	$mysip->port = $sipPort;

	$result = $mysip->connect();

	if (!$result) {
		$mysip->disconnect();	
		return false;
	}
	$sc_login=$mysip->msgLogin($sipPatron,$sipPassword);
	$result = $mysip->parseLoginResponse($mysip->get_message($sc_login));

	$mysip->patron = $patronCode;
	$cko_action = $mysip->msgCheckout($itemCode);
	$cko_msg = $mysip->get_message($cko_action);

	
	if ($mysip->parseCheckoutResponse($cko_msg)['fixed']['Ok']== 2) {
		$mysip->disconnect();
		return $mysip->parseCheckoutResponse($cko_msg);
	}
	else 
	{
		$mysip->disconnect();
		return $cko_msg;
	}

}