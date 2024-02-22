<?php

namespace App\Controller;

use App\Form\CrudType;
use App\Entity\Articles;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/create", name="create", methods= {"GET","POST"})
     */
    public function create(Request $request): Response
    {
        $article = new Articles();
        $form = $this->createForm(CrudType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sendDatabase = $this   ->getDoctrine()
                                    ->getManager();
            $sendDatabase->persist($article);
            $sendDatabase->flush();

            $this->addFlash("success", "L'article a bien été enregistré"); 
            return $this->redirectToRoute('app_main');
            }
        return $this->render('main/createForm.html.twig', [
            'controller_name' => 'MainController',
            'form'=>$form->createView(),
        ]);
    

}
}