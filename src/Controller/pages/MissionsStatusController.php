<?php

namespace App\Controller\pages;

use App\Entity\MissionStatus;
use App\Form\MissionStatusType;
use App\Repository\MissionRepository;
use App\Repository\MissionStatusRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MissionsStatusController extends AbstractController
{
    #[Route('/status', name: 'app_mission_status')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(PaginatorInterface $paginator,ManagerRegistry $manager,Request $request,ValidatorInterface $validator , MissionStatusRepository $missionStatusRepository): Response
    {
        $missionStatus = new MissionStatus();
        $em = $manager->getManager();
        $form = $this->createForm(MissionStatusType::class);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($missionStatus);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            if ($missionStatusRepository->findOneBy([
                'name'=>$form->get('name')->getViewData()
            ])){
                $this->addFlash('alert','Il semble que le status existe deja ');
            } else {
                $em->persist($data);
                $em->flush();
                $this->addFlash('success','Le status a bien été enregistrée');
            }

        }

        $missionStatusList = $missionStatusRepository->findAll();
        $resulta = $paginator->paginate($missionStatusList,$request->query->getInt('page',1,),5);

        return $this->render('mission_status/index.html.twig', [
            'controller_name' => 'MissionsStatusController','form'=>$form->createView(),
            'errors'=>$error,'allStatus'=>$resulta
        ]);
    }

    #[Route('/status/{id}/edit')]
    #[Entity('mission', options: ['id' => 'id'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edite(MissionStatus $missionStatus,ManagerRegistry $manager,Request $request,ValidatorInterface $validator , MissionStatusRepository $missionStatusRepository):Response {
        $em = $manager->getManager();
        $form = $this->createForm(MissionStatusType::class,$missionStatus);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($missionStatus);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $resultUser= $missionStatusRepository->findOneBy([
                'name'=>$form->get('name')->getViewData()
            ]);

            /** Vérifier s'il n'y a pas de spécialité du même nom et si oui si ce n'est pas le formulaire a modifier en question si c'est le cas on peut modifier **/
            if ($resultUser && ($resultUser->getId() != $missionStatus->getId() )){
                $this->addFlash('alert','Il semble que ce type existe deja ');
            } else {
                $em->flush();
                $this->addFlash('success','Le type a bien été modifiée');
                return $this->redirectToRoute('app_mission_status');
            }
        }

        $status = $missionStatusRepository->findAll();
        return $this->render('mission_status/edit.html.twig', [
            'controller_name' => 'editStatusMission','form'=>$form->createView(),
            'errors'=>$error,'allStatus'=>$status
        ]);

    }

    #[Route('/status/{id}/delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(MissionRepository $missionRepository ,MissionStatus $missionStatus ,ManagerRegistry $manager):Response {
        $result = $missionRepository->findOneBy([
            'status'=>$missionStatus->getId()
        ]);
        if ($result){
            $this->addFlash('alert','Vous ne pouvez pas supprimer ce status car il appartient à la mission '.$result->getCode().'');
        } else {
            $em = $manager->getManager();
            $em->remove($missionStatus);
            $em->flush();
            $this->addFlash('success','Le status a bien été suprimé');
        }
        return $this->redirectToRoute('app_mission_status');
    }
}
