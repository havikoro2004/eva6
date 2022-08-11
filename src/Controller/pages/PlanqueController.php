<?php

namespace App\Controller\pages;


use App\Entity\Planque;
use App\Form\PlanqueType;
use App\Repository\PlanqueRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PlanqueController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/planque', name: 'app_planque')]
    public function index(PaginatorInterface $paginator ,Request $request ,PlanqueRepository $planqueRepository): Response
    {
        $error=null;
        $result = $planqueRepository->findAll();
        $planques = $paginator->paginate($result,$request->query->getInt('page',1,),10);
        return $this->render('planque/index.html.twig', [
            'planques'=>$planques,'errors'=>$error
        ]);
        return $this->render('planque/index.html.twig', [
            'controller_name' => 'PlanqueController',
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/planque/add', name: 'app_planque_add')]
    public function add(PlanqueRepository $planqueRepository ,ManagerRegistry $manager,Request $request,ValidatorInterface $validator): Response
    {
        $planques = new Planque();
        $em = $manager->getManager();
        $form = $this->createForm(PlanqueType::class);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($planques);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $codePlanque = $planqueRepository->findOneBy([
                'code'=>$form->get('code')->getViewData()
            ]);

            if ($codePlanque){
                $this->addFlash('alert','Ce code est deja utilisé pour une autre planque');
            } else {
                $em->persist($data);
                $em->flush();
                $this->addFlash('success','La nouvelle planque a bien été enregistré');
                return $this->redirectToRoute('app_planque');
            }

        }
        return $this->render('planque/add.html.twig', [
            'form'=>$form->createView(),'errors'=>$error
        ]);
    }

    #[Route('/planque/{id}/edit')]
    #[IsGranted('ROLE_ADMIN')]
    #[Entity('planque', options: ['id' => 'id'])]
    public function edit(Planque $planque,ManagerRegistry $manager,Request $request,ValidatorInterface $validator , PlanqueRepository $planqueRepository):Response{
        $em = $manager->getManager();
        $form = $this->createForm(PlanqueType::class,$planque);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($planque);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $planqueVerif = $planqueRepository->findOneBy([
                'code'=>$form->get('code')->getViewData()
            ]);

            /** Vérifier s'il n'y a pas de spécialité du même nom et si oui si ce n'est pas le formulaire a modifier en question si c'est le cas on peut modifier **/
            if ($planqueVerif && ($planqueVerif->getId() != $planque->getId() )){
                $this->addFlash('alert','Il semble que ce code de planque existe deja ');
            } else {
                $em->flush();
                $this->addFlash('success','La planque a bien été modifiée');
                return $this->redirectToRoute('app_planque');
            }
        }
        return $this->render('planque/edit.html.twig', [
            'form'=>$form->createView(),
            'errors'=>$error
        ]);
    }

    #[Route('/planque/{id}/delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Planque $planque ,ManagerRegistry $manager):Response {
        $em = $manager->getManager();
        $em->remove($planque);
        $em->flush();
        $this->addFlash('success','La planque a bien été supprimé');
        return $this->redirectToRoute('app_planque');
    }
}