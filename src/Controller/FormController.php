<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    /**
     * @Route("/form", name="form")
     */
    public function index(Request $request)
    {
        $post = new Post();
//        $post->setTitle('Welcome');
//        $post->setDescription('this is a description');

        $form = $this->createForm(PostType::class, $post, [
            'action' => $this->generateUrl('form')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('form');
//            return $this->redirect($request->getUri());
        }

        return $this->render('form/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/delete/{id}")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$id)
        {
            throw $this->createNotFoundException('No ID found');
        }
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);

        if ($post != null)
        {
            $em->remove($post);
            $em->flush();
        }

        return new Response('Post was deleted');
    }

    /**
     * @return Response
     * @Route("/remove")
     */
    public function removeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->findOneBy([
            'id' => 4
        ]);

        $em->remove($post);
        $em->flush();

        return new Response('Post was removed');
    }
}
