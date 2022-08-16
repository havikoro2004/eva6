<?php

namespace App\Controller\pages;


use App\Entity\Target;
use App\Form\TargetType;
use App\Repository\MissionRepository;
use App\Repository\TargetRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TargetController extends AbstractController
{
    #[Route('/target', name: 'app_target')]
    #[IsGranted('ROLE_USER')]
    public function index(PaginatorInterface $paginator ,Request $request ,TargetRepository $targetRepository): Response
    {
        $error=null;
        $result = $targetRepository->findAll();
        $targets = $paginator->paginate($result,$request->query->getInt('page',1,),5);
        return $this->render('target/index.html.twig', [
            'controller_name' => 'TargetController','targets'=>$targets,'errors'=>$error
        ]);
    }

    #[Route('target/add',name:'app_target_add')]
    #[IsGranted('ROLE_USER')]
    public function add(ManagerRegistry $manager,Request $request,ValidatorInterface $validator,TargetRepository $targetRepository):Response{

        $cible = new Target();
        $em = $manager->getManager();
        $form = $this->createForm(TargetType::class);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($cible);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            if ($targetRepository->findOneBy([
                'code'=>$form->get('code')->getViewData(),
                'firstName'=>$form->get('firstName')->getViewData(),
                'lastName'=>$form->get('lastName')->getViewData()
            ])){
                $this->addFlash('alert','Il semble que ce code cible existe deja ');
            } else {
                $em->persist($data);
                $em->flush();
                $this->addFlash('success','La nouvelle cible a bien été enregistré');
                return $this->redirectToRoute('app_target');
            }

        }
        return $this->render('target/add.html.twig',[
            'form'=>$form->createView(),'errors'=>$error
        ]);
    }

    #[Route('/target/{id}/edit')]
    #[IsGranted('ROLE_USER')]
    #[Entity('target', options: ['id' => 'id'])]
    public function edit(Target $target,ManagerRegistry $manager,Request $request,ValidatorInterface $validator , TargetRepository $targetRepository):Response{
        $em = $manager->getManager();
        $form = $this->createForm(TargetType::class,$target);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($target);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $resultmission= $targetRepository->findOneBy([
                'code'=>$form->get('code')->getViewData()
            ]);

            /** Vérifier s'il n'y a pas une cible du même code et si oui si ce n'est pas le formulaire a modifier en question si c'est le cas on peut modifier **/
            if ($resultmission && ($resultmission->getId() != $target->getId() )){
                $this->addFlash('alert','Il semble qu\'il y a deja une cible avec ce code ');
            } else {
                $em->flush();
                $this->addFlash('success','La cible a bien été modifiée');
                return $this->redirectToRoute('app_target');
            }
        }
        $targetInfo = $targetRepository->findAll();
        return $this->render('target/edit.html.twig', [
            'form'=>$form->createView(),
            'errors'=>$error,'targetInfo'=>$targetInfo
        ]);
    }

    #[Route('/target/{id}/delete')]
    #[IsGranted('ROLE_USER')]
    public function delete(MissionRepository $mission,Target $target ,ManagerRegistry $manager):Response {
        $missions = $mission->findOneBy([
            'id'=>$target->getId()
        ]);
        if ($missions){
            $this->addFlash('alert','La cible ne peut pas être supprimer car elle appartient à la mission '.$missions->getCode().'');
        } else {
            $em = $manager->getManager();
            $em->remove($target);
            $em->flush();
            $this->addFlash('success','La cible a bien été supprimée');
        }
        return $this->redirectToRoute('app_target');
    }

}