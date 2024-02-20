<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\CrudType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function index(): Response
    {
        $data= $this->getDoctrine()->getRepository(Articles::class)->findAll();
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'datas'=> $data,
        ]);
    }

     /**
     * @Route("/create", name="create", methods: ["GET","POST"])
     */
    public function create(Request $request): Response
    {
        $article = new Articles();
        $form = $this->createForm(CrudType::class, $article)
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

}
