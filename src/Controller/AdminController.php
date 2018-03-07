<?php
/**
 * Created by PhpStorm.
 * User: JibZ
 * Date: 25/02/2018
 * Time: 23:41
 */

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin/news", name="admin_news")
     */
    public function index(Request $request): Response
    {
        $posts = $this
            ->getDoctrine()
            ->getRepository(Post::class)
            ->findAll();

        return $this->render('admin/post.html.twig',
            [
            'posts' => $posts
            ]
        );
    }

    public function postShow(){

    }

    /**
     * @Route("/admin/post/new", name="admin_post_new")
     */
    public function newPost(Request $request)
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

        return $this->render('admin/create.html.twig', ['form' => $form->createView()]);
    }
}