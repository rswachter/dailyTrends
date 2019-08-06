<?php

namespace App\Controller;

use App\Entity\Feed;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="app")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $feeds = $em->getRepository(Feed::class)->findIndexFeed();

        return $this->render('app/index.html.twig', [
            'feeds' => $feeds
        ]);
    }
}
