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
       /**
     * @Route("/update/{id}", name="update", methods= {"GET","POST"})
     */
    public function update(Request $request, $id) :Response
    {
        $article = $this->getDoctrine()->getRepository(Articles::class)->find($id);
        $form = $this-> createForm(CrudType::class,$article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $sendDatabase = $this   ->getDoctrine()
                                    ->getManager();
            $sendDatabase->persist( $article );
            $sendDatabase->flush();

            $this->addFlash('notice' , 'Modification réussie!');
            
            return $this->redirectToRoute('updateForm.html.twig');
        }
        return $this-> render('main/updateForm.html.twig' ,[
            'controller_name' => 'MainController',
            'form' => $form->createView()
        ]);
        }

   /**
     * @Route("/delete/{id}", name="delete", methods= {"GET","POST"})
     */
    public function delete ($id) :Response
    {
        $article = $this->getDoctrine()->getRepository(Articles::class)->find($id);
        
            $sendDatabase = $this   ->getDoctrine()
                                    ->getManager();
            $sendDatabase->remove($article);
            $sendDatabase->flush();

            $this->addFlash('notice' , 'Supression réussie!');
            
            return $this->redirectToRoute('updateForm.html.twig');
        
}
}