<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
  /**
   * @Route("/home/{$id}", name="home")
   */
  public function index($id)
  {

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
      'firstname' => 'Marcel',
      'lastname' => 'Dan',
      'age' => 23
    ];

    //store stuff in the database
    $post = new Post();
    $post->setTitle('Overseas Media');
    $post->setDescription('youtybe channel for tutorials');
    $em = $this->getDoctrine()->getManager();


    //create the sql
//    $em->persist($post);
    $em->flush();

    return $this->render('home/greet.html.twig', [
      'person' => $person,
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/post/", name="post_show")
   */
  public function show()
  {
    $retreivedPost = $this->getDoctrine()->getRepository(Post::class)->findOneBy([
      'id'=> 1
    ]);

    dump($retreivedPost);

    return $this->render('posts/show.html.twig', [
      'retrievedPost' => $retreivedPost
  ]);
  }
}
