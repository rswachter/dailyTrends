<?php

namespace App\Controller;

use App\Entity\Feed;
use App\Form\FeedType;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CrudController extends AbstractController
{
    /**
     * Lists all feeds
     * @Route("/feed_list", name="feed_list")
     */
    public function feedListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $feeds = $em->getRepository(Feed::class)->findAll();

        return $this->render('app/feed_list.html.twig', [
            'feeds' => $feeds
        ]);
    }

    /**
     * Create feed
     * @Route("/feed_new", name="feed_new")
     */
    public function feedNewAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $feed = new Feed();

        $form = $this->createForm(FeedType::class, $feed);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            try{
                $em->persist($feed);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'Feed '.$feed->getTitle().' creado');
                return $this->redirect($this->generateUrl('feed_list'));
            }catch (DBALException $e){
                $this->get('session')->getFlashBag()->add('danger', 'No se ha podido realizar la acción. Error: '. $e->getMessage());
                return $this->redirect($this->generateUrl('feed_list'));
            }
        }
        return $this->render('app/feed_new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Read feed
     * @Route("/feed_read/{id}", name="feed_read")
     */
    public function feedReadAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $feed = $em->getRepository(Feed::class)->find($id);

        return $this->render('app/feed_read.html.twig', [
            'feed' => $feed
        ]);
    }

    /**
     * Upadate feed
     * @Route("/feed_update/{id}", name="feed_update")
     */
    public function feedUpdateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $feed = $em->getRepository(Feed::class)->find($id);

        $form = $this->createForm(FeedType::class, $feed);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            try{
                $em->persist($feed);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'Feed '.$feed->getTitle().' editado');
                return $this->redirect($this->generateUrl('feed_list'));
            }catch (DBALException $e){
                $this->get('session')->getFlashBag()->add('danger', 'No se ha podido realizar la acción. Error: '. $e->getMessage());
                return $this->redirect($this->generateUrl('feed_list'));
            }
        }

        return $this->render('app/feed_update.html.twig', [
            'feed' => $feed,
            'form' => $form->createView()
        ]);
    }

    /**
     * Delete feed
     * @Route("/feed_delete/{id}", name="feed_delete")
     */
    public function feedDeleteAction($id)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $feed = $em->getRepository(Feed::class)->find($id);
            $em->remove($feed);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Feed borrado');

        }catch (DBALException $e){
            $this->get('session')->getFlashBag()->add('danger', 'No se ha podido realizar la acción. Error: '. $e->getMessage());
        }
        return $this->redirect($this->generateUrl('feed_list'));
    }
}
