<?php

namespace App\Controller\pages;

use App\Entity\PlanqueType;
use App\Form\PlanqueTypeType;
use App\Repository\PlanqueTypeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PlanqueTypeController extends AbstractController
{
    #[Route('/planque/type', name: 'app_planque_type')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(PaginatorInterface $paginator,ManagerRegistry $manager,Request $request,ValidatorInterface $validator , PlanqueTypeRepository $planqueTypeRepository): Response
    {
        $planqueType = new PlanqueType();
        $em = $manager->getManager();
        $form = $this->createForm(PlanqueTypeType::class);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($planqueType);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            if ($planqueTypeRepository->findOneBy([
                'name'=>$form->get('name')->getViewData()
            ])){
                $this->addFlash('alert','Il semble que le type de planque existe deja ');
            } else {
                $em->persist($data);
                $em->flush();
                $this->addFlash('success','Le type de planque a bien été enregistré');
            }

        }

        $PlanqueTypeList = $planqueTypeRepository->findAll();
        $resulta = $paginator->paginate($PlanqueTypeList,$request->query->getInt('page',1,),10);

        return $this->render('planque_type/index.html.twig', [
            'controller_name' => 'PlanqueTypeController','form'=>$form->createView(),
            'errors'=>$error,'allPlanque'=>$resulta
        ]);
    }
    #[Route('/planque/type/{id}/edit')]
    #[Entity('planqueType', options: ['id' => 'id'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edite(PlanqueType $planqueType,ManagerRegistry $manager,Request $request,ValidatorInterface $validator , PlanqueTypeRepository $planqueTypeRepository):Response {
        $em = $manager->getManager();
        $form = $this->createForm(PlanqueTypeType::class,$planqueType);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($planqueType);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $resultUser= $planqueTypeRepository->findOneBy([
                'name'=>$form->get('name')->getViewData()
            ]);

            /** Vérifier s'il n'y a pas de spécialité du même nom et si oui si ce n'est pas le formulaire a modifier en question si c'est le cas on peut modifier **/
            if ($resultUser && ($resultUser->getId() != $planqueType->getId() )){
                $this->addFlash('alert','Il semble que ce type existe deja ');
            } else {
                $em->flush();
                $this->addFlash('success','Le type a bien été modifiée');
                return $this->redirectToRoute('app_planque_type');
            }
        }

        $status = $planqueTypeRepository->findAll();
        return $this->render('planque_type/edit.html.twig', [
            'controller_name' => 'editPlanqueType','form'=>$form->createView(),
            'errors'=>$error,'allPlanque'=>$status
        ]);

    }

    #[Route('/planque/type/{id}/delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(PlanqueType $planqueType ,ManagerRegistry $manager):Response {
        $em = $manager->getManager();
        $em->remove($planqueType);
        $em->flush();
        $this->addFlash('success','Le type de planque a bien été suprimé');
        return $this->redirectToRoute('app_planque_type');
    }
}
