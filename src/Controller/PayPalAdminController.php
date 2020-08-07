<?php

namespace App\Controller;

use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/admin")
 */
class PayPalAdminController extends AbstractController {
	/**
	 * @Route("/create-plan", name="create-plan")
	 */
	public function createPlan() {
		$apiContext = new ApiContext(
			new OAuthTokenCredential(
				$_ENV['PAYPAL_CLIENT_ID'],
				$_ENV['PAYPAL_CLIENT_SECRET']
			)
		);

		$plan = new Plan();
		$plan->setName('Pro plan');
		$plan->setDescription('Unlimited access HD available No ads on videos Help center access');
		$plan->setType('INFINITE'); //or FIXED. The plan has a fixed number of payment cycles

		$paymentDefinition = new PaymentDefinition();
		$paymentDefinition
			->setName('Regular Payment')
			->setType('REGULAR') //or TRIAL
			->setFrequency('Month') //or Week, Day, Year
			->setFrequencyInterval('1') //The interval at which the customer is charged. Value cannot be greater than 12 month
			->setAmount(new Currency(array('value' => 15, 'currency' => 'USD')))
			//->setCycles('12')
		;

		$merchantPreferences = new MerchantPreferences();
		$merchantPreferences->setReturnUrl(
			$this->generateUrl(
				'videos',
				['success' => true],
				UrlGeneratorInterface::ABSOLUTE_URL
			)
		); //Url where the customer can approve the agreement
		$merchantPreferences->setCancelUrl(
			$this->generateUrl(
				'videos',
				['success' => false],
				UrlGeneratorInterface::ABSOLUTE_URL
			)
		); //Url where the customer can cancel the agreement

		/**
		 * Allowed values: YES, NO
		 * Default is no
		 * Indicates whether PayPal automatically bills the outstanding balance
		 * in the next billing cycle
		 */
		$merchantPreferences->setAutoBillAmount("yes");
		/**
		 * Action to take if a failure occurs during initial payment
		 * Allowed values: CONTINUE, CANCEL
		 * Default is continue
		 */
		$merchantPreferences->setInitialFailAmountAction("CONTINUE");
		/**
		 * Total number of failed attempts allowed
		 * Default is 0 representing an infinite number of failed attempts
		 */
		$merchantPreferences->setMaxFailAttempts("0");
		/**
		 * The currency and amount of the set-up fee for the agreement.
		 * This fee is the initial, non recurring agreement amount
		 * that is due immediately when the billing agreement is created
		 */
		$merchantPreferences->setSetupFee(new Currency(array('value' => 15, 'currency' => 'USD')));

		$plan->setPaymentDefinitions(array($paymentDefinition));
		$plan->setMerchantPreferences($merchantPreferences);

		try {
			$createdPlan = $plan->create($apiContext);
		} catch (\Exception $e){
			print_r($e->getMessage());
			die();
		}

		dd($createdPlan);
	}
}
