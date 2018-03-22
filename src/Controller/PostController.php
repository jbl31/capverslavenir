<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
 //   /**
 //    * @Route("/post/create", name="post_create")
 //    */
    /*public function create(Request $request)
    {
        // Formulaire création de post
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post->setPublishedAt(new \DateTime('now'));
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('admin_news', ['page' => 1]);
        }

        return $this->render('news/create.html.twig', ['form' => $form->createView()]);
    }*/

    /**
     * @Route("/post/{id}", name="post_show")
     * @Method("GET")
     */
    public function show($id)
    {
        $post = $this
            ->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);
        if (!$post) {
            throw $this->createNotFoundException(
                'No post found for id' . $id
            );
        }
        return $this
            ->render('news/show.html.twig', [
                'post' => $post]
            );
    }

    /**
     * @Route("/news/{page}", name="page_news", requirements={"page": "\d+"})
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($page = 1)
    {
        if ($page < 1) {
            throw new NotFoundHttpException('Page "' . $page . '" inexistante.');
        }
        $nbPerPage = 5;
        $posts = $this
            ->getDoctrine()  // appelle doctrine
            ->getRepository(Post::class)  // appelle notre repository
            ->getPosts([  // appelle la liste des posts via la méthode dans le repository
                'first' => $page,   // les classe par page
                'limit' => $nbPerPage]); // et limite leur nombre par page à la valeur indiqué dans $nbPerPages,
        $nbPages = ceil(count($posts) / $nbPerPage);
        return $this
            ->render('news/news.html.twig', [   // Rendu de la page news
            'posts' => $posts,  // affecte la valeur de $posts à 'posts' pour les utiliser dans twig
            'nbPages' => $nbPages,
            'page' => $page,
        ]);
    }
}
