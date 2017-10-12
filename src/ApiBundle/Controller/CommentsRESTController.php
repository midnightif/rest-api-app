<?php
namespace ApiBundle\Controller;

use ApiBundle\Entity\Comment;
use ApiBundle\Form\CommentType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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

    public function postNewcommentAction(Request $request)
    {
        $comment = new Comment();

        $form = $this->createForm(new CommentType(), $comment);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

        }
        return array(
            'form' => $form,
            'comment' => $comment
        );
    }

}