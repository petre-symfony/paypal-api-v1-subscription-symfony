<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController {
	/**
	 * @Route("/", name="videos")
	 */
	public function videos() {
		return $this->render('subscription/videos.html.twig');
	}

	/**
	 * @Route("/pricing", name="pricing")
	 */
	public function pricing(){
		return $this->render('subscription/pricing.html.twig');
	}

}
