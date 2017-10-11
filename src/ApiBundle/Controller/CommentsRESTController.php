<?php
namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;


class CommentsRESTController extends FOSRestController
{

    public function getCommentsAction()
    {

        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('ApiBundle\Entity\Comment');
        $comments = $repository->createQueryBuilder('c')
            ->select('c')
            ->getQuery()
            ->getResult();

        $comments = $this->container->get('serializer')->serialize($comments, 'json');

        return  new Response( $comments) ;
    }

}