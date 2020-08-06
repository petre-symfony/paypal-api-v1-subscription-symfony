<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController {
	/**
	 * @Route("/", name="videos")
	 */
	public function videos() {
		if ($this->canWatchVideos()) $canWatchVideos = true;
		else $canWatchVideos=false;
		return $this->render('subscription/videos.html.twig',
			compact('canWatchVideos')
		);
	}

	/**
	 * @Route("/pricing", name="pricing")
	 */
	public function pricing(){
		return $this->render('subscription/pricing.html.twig');
	}

	private function canWatchVideos(){
		if($this->getUser() && $this->getUser()->getSubscriptionStatus()){
			return true;
		}

		return false;
	}
}
