<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * @Route("/post", name="page_posts")
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

         // J'enregistre dans la bdd
        $em->persist($post);

        // J'execute la requête
        $em->flush();

        // Je retourne un message si cela a bien fonctionné
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

    public function getPosts($first_result, $max_results = 10)
    {
        $qb = $this->createQueryBuilder('post');
        $qb
            ->select('post')
            ->setFirstResult($first_result)
            ->setMaxResults($max_results);

        $pag = new Paginator($qb);
        return $pag;
    }

    /**
     * @Route("/{page}", name="news", requirements={"page": "\d+"})
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page = 1)
    {
// Si la page est inférieure à 1 alors on affiche une exception.
        if ($page < 1) {
            throw new NotFoundHttpException('Page "' . $page . '" inexistante.');
        }
// On définie le nombre de news par page
        $nbPerPage = 5;
// On récupère la liste des Posts
// SELECT * FROM posts LEFT JOIN comments ON posts.id = comments.post_id;
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAll($page, $nbPerPage)
        ;
// On calcule le nombre de page grace au nombre de Posts
        $nbPages = ceil(count($posts) / $nbPerPage);
// On retournes les posts, le nombres de pages, la page, l'img de l'entête et sa position
return $this->render('news/news.html.twig', array(
    'posts' => $posts,
    'nbPages' => $nbPages,
    'page' => $page,
    'img' => 'assets/img/news.jpg',
    'position' => 'center'
));
}
}
