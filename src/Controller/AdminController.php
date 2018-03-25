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
use App\Utils\Slugger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin/news", name="admin_news")
     *
     */
    public function indexAction(Request $request): Response
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

    /**
     * @Route("/admin", name="admin_index")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    public function postShow(){

    }

    /**
     * @Route("/admin/post/new", name="admin_post_new")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newPost(Request $request)
    {
        // Formulaire création de post
        $post = new Post();
        $post->setAuthor($this->getUser());
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $post->setSlug(Slugger::slugify($post->getTitle()));
            $post->setPublishedAt(new \DateTime('now'));
            $post->setImage('image');
            $post->setCategory('Vie de l\'association');
            $em->persist($post);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Actualité bien enregistrée !')
            );

            return $this->redirectToRoute('admin_news', ['page' => 1]);
        }

        return $this->render('admin/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Permet d'éditer un post
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_post_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        //$this->denyAccessUnlessGranted('edit', $post, 'Seul l\'auteur du post peut éditer');

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setSlug(Slugger::slugify($post->getTitle()));
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Post_édité_avec_succès');

            return $this->redirectToRoute('admin_news', ['id' => $post->getId()]);
        }

        return $this->render('admin/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

        /**
         * Efface un post
         *
         * @Route("/{id}/delete", name="admin_post_delete")
         */
        public function delete(Request $request, Post $post): Response
    {

        // supprime les tags liés à ce post (normalement fait automatiquement par doctrine
        $post->getTags()->clear();

        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        $this->addFlash('success', 'post supprimé avec sucès');

        return $this->redirectToRoute('admin_news');
    }

    /**
     * Affiche un post côté admin
     *
     * @Route("/admin/post/{id}", requirements={"id": "\d+"}, name="admin_post_show")
     * @Method("GET")
     */
    public function show(Post $post): Response
    {
        // This security check can also be performed
        // using an annotation: @Security("is_granted('show', post)")
        // $this->denyAccessUnlessGranted('show', $post, 'Les posts ne peuvent être affichés que par leur auteur');

        return $this->render('admin/post_show.html.twig', [
            'post' => $post,
        ]);
    }
}