<?php
namespace Sample;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
//use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;


ini_set('error_reporting', E_ALL);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

class PayPalClient
{
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    public static function environment()
    {
		$clientId="{CLIENT-ID}";
		$clientSecret = "{CLIENT-Secret}";       
		return new ProductionEnvironment($clientId, $clientSecret);
		
    }
}

?>