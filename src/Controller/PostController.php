<?php

namespace App\Controller;

use App\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * @Route("/post", name="post")
     */
    public function index()
    {
         $em = $this->getDoctrine()->getManager();

         $post = new Post();
         $post->setTitle('Bonjour, ceci est un article de test');
         $post->setSlug('1');
         $post->setSummary('Résumé du post');
         $post->setContent('Lorem ipsum dolor es bnafkf');
//         $post->setPublishedAt(dateTime);
         $post->setAuthor('Jean');

         //je veux save en bdd
        $em->persist($post);

        //je veux executer la requette
        $em->flush();

        return new Response('Post bien enregistré avec l\'id' .$post->getId());
    }

    /**
     * @Route("/post/{id}", name="post_show")
     */
    public function postShow($id)
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);

        if (!$post){
            throw $this->createNotFoundException(
                'No post found for id' .$id
            );
        }

        return new Response('Voici le titre de l\'article ' .$post->getTitle());
    }
}
