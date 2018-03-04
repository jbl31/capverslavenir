<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function getPosts($params)
    {
        // je lancer le querybuilder pour récupérer les posts
        $qb = $this->createQueryBuilder('post');
        $qb
            ->select('post', 'c') // Je sélectionne
            ->leftJoin('post.comments', 'c')
            ->setFirstResult($params['first'])
            ->setMaxResults($params['limit']);
        $pag = new Paginator($qb);
        return $pag;
    }
}



