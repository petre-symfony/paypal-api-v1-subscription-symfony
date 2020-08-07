<?php

namespace App\Utils;

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

trait PayPalApiCredentialsTrait {
	private $apiContext;

	public function setCredentials(){
		$this->apiContext = new ApiContext(
			new OAuthTokenCredential(
				$_ENV['PAYPAL_CLIENT_ID'],
				$_ENV['PAYPAL_CLIENT_SECRET']
			)
		);
	}
}