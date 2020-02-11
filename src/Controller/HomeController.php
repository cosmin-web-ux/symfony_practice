<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index($id)
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/helloUser/{name?}", name="hello_user")
     */
    public function helloUser(Request $request)
    {
//    $name = $request->get('name');
        $form = $this->createFormBuilder()
            ->add('fullname')
            ->getForm();

        $person = [
            'firstname' => 'Cosmin',
            'lastname' => 'Dan',
            'age' => 23
        ];

        //store stuff in the database
        $post = new Post();
        $post->setTitle('Breathful Apps');
        $post->setDescription('organization');
        $em = $this->getDoctrine()->getManager();


        //create the sql
//    $em->persist($post);
        $em->flush();

        return $this->render('/posts/new_post.html.twig', [
            'person' => $person,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/post/{id}", name="post_show")
     */
    public function show(Post $post)
    {
        return $this->render('posts/show.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @Route("/new-post", name="new_post")
     */
    public function newPost(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('new_post');
        }

        return $this->render('/posts/new_post.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
