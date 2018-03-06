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
    /**
     * @Route("/post/create", name="page_posts")
     */
    public function create(Request $request)
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

            return $this->redirectToRoute('news', ['page' => 1]);
        }

        return $this->render('news/create.html.twig', ['form' => $form->createView()]);
    }

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
     * @Route("/{page}", name="news", requirements={"page": "\d+"})
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
            ->getDoctrine()
            ->getRepository(Post::class)
            ->getPosts([
                'first' => $page,
                'limit' => $nbPerPage]);
        $nbPages = ceil(count($posts) / $nbPerPage);
        return $this
            ->render('news/news.html.twig', [
            'posts' => $posts,
            'nbPages' => $nbPages,
            'page' => $page,
        ]);
    }
}
