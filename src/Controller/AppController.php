<?php

namespace App\Controller;

use App\Entity\Feed;
use Goutte\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/scraper", name="scraper")
     */
    public function scraperAction()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.elpais.com' );

        $em = $this->getDoctrine()->getManager();
        $feed = new Feed();
        $feed->setTitle($crawler->filter('h2 > a')->eq(0)->text());
        $feed->setBody($crawler->filter('p')->eq(0)->text());
        $feed->setSource($crawler->filter('a[href]')->eq(0)->link());
        $feed->setImage($crawler->filter('meta*url')->eq(0)->text());
        $feed->setPublisher('El Pais');
        $em->persist($feed);
        $em->flush();


    }

}
