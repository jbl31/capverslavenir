<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * @Route("/post", name="page_posts")
     */
    public function create()
    {
        // Formulaire création de post
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
            ->render('news/news.html.twig', array(
            'posts' => $posts,
            'nbPages' => $nbPages,
            'page' => $page,
        ));
    }
}
