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
	error_log(print_r($cko_action, TRUE)); 
	error_log(print_r($cko_msg, TRUE)); 
	if ($mysip->parseCheckoutResponse($cko_msg)['fixed']['Ok']== 1) {
		$mysip->disconnect();
		return true;
	}
	else 
	{
		$mysip->disconnect();
		return false;
	}

}