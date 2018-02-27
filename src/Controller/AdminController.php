<?php
/**
 * Created by PhpStorm.
 * User: JibZ
 * Date: 25/02/2018
 * Time: 23:41
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function index(Request $request): Response
    {
        return $this->render('/admin/admin_base.html.twig');
    }
}