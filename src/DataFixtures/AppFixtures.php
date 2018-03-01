<?php
/**
 * Created by PhpStorm.
 * User: JibZ
 * Date: 01/03/2018
 * Time: 23:34
 */

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Adding 10 posts
        for ($i = 0; $i < 10; $i++){
            $post = new Post();
            $post->setTitle('Lorem article de test' .$i);
            $post->setSlug('1'.$i);  //not sure of the format
            $post->setSummary('Résumé de l\'article');
            $post->setAuthor('Toto');
            $post->setContent('Hohohoho i forgot to the add the content !!');
            $manager->persist($post); //Asking orm to persist the fixtures into bdd
        }
        $manager->flush(); //send the persist request
    }
}