<?php
/**
 * Created by PhpStorm.
 * User: JibZ
 * Date: 22/02/2018
 * Time: 13:18
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request): Response
    {
        return $this->render('default/homepage.html.twig');
    }
}