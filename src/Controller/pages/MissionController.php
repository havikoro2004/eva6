<?php

namespace App\Controller\pages;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Form\SearchType;
use App\Repository\AgentRepository;
use App\Repository\ContactRepository;
use App\Repository\MissionRepository;
use App\Repository\PlanqueRepository;
use App\Repository\TargetRepository;
use App\Services\SearchFilter;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MissionController extends AbstractController
{
    #[Route('/mission', name: 'app_mission')]
    public function index(MissionRepository $missionRepository ,PaginatorInterface $paginator,Request $request): Response
    {
        $data = new SearchFilter();
        $data->page=$request->get('page',1);
        $form = $this->createForm(SearchType::class,$data);
        $form->handleRequest($request);
        $error =null;

        $resulta = $missionRepository->findByFilter($data);
        return $this->render('mission/index.html.twig', [
            'controller_name' => 'missionController','missions'=>$resulta,
            'errors'=>$error,'form'=>$form->createView()
        ]);
    }


    #[Route('/mission/add', name: 'app_mission_add')]
    #[IsGranted('ROLE_ADMIN')]
    public function add(PlanqueRepository $planqueRepository ,TargetRepository $targets,AgentRepository $agentRepository ,ContactRepository $contactRepository ,MissionRepository $missionRepository ,ManagerRegistry $manager,Request $request,ValidatorInterface $validator): Response
    {
        $mission = new Mission();
        $em = $manager->getManager();
        $form = $this->createForm(MissionType::class);
        $form->handleRequest($request);
        $error=null;
        $targetsNationality=[];
        $contactMission=[];
        $planqueMissionNationality=[];
        $contacts = $contactRepository->findAll();
        $cibles = $targets->findAll();
        $planques = $planqueRepository->findAll();
        $agentts = $agentRepository->findAll();

        $data = $form->getData($mission);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $codeMissionInsered =$missionRepository->findOneBy([
                'code'=>$form->get('code')->getViewData()
            ]);
            $formAgent = $form->get('agentMission')->getViewData();
            $formTargets = $form->get('targetMission')->getViewData();
            foreach ($formTargets as $target){
                $result = $targets->findOneBy([
                    'id'=>$target
                ]);
                $targetNationali = $result->getNationality();
                foreach ($formAgent as $agents){
                    $nbrAgent = $agentRepository->findOneBy([
                        'id'=>$agents
                    ]);

                    if ($nbrAgent->getNationality() == $targetNationali){
                        $targetsNationality +=[$nbrAgent->getCode() => $result->getCode()];
                    }
                }
            }
            foreach ($form->get('planqueMission')->getViewData() as $planque){
                $planqueNationality = $planqueRepository->findOneBy([
                    'id'=>$planque
                ]);
                if ($planqueNationality->getCountry() != $form->get('country')->getViewData()){
                    $planqueMissionNationality[]=$planqueNationality->getType();
                }
            }
            foreach ($form->get('contactMission')->getViewData() as $contacts){
                $contactNationality = $contactRepository->findOneBy([
                    'id'=>$contacts
                ]);
                if ($contactNationality->getNationality() != $form->get('country')->getViewData()){
                    $contactMission[]=$contactNationality->getCode();
                }
            }
            if ($targetsNationality){
                foreach ($targetsNationality as $key=>$value){
                    $this->addFlash('alert','l\'agent '.$key.' et la cible '.$value.' ne doivent pas avoir la même nationalité');
                }
            }elseif ($contactMission){
                foreach ($contactMission as $contactNvalide){
                    $this->addFlash('alert','le contact '.$contactNvalide.' doit avoir la même nationalité que le pays de la mission');
                }

            }elseif ($planqueMissionNationality){
                foreach ($planqueMissionNationality as $planque){
                    $this->addFlash('alert','la planque '.$planque.' doit avoir la même nationalité que le pays de la mission');
                }
            }elseif ($missionRepository->findOneBy([
                'code'=>$form->get('code')->getViewData()
            ])){
                $this->addFlash('alert','Il existe deja une mission avec ce code');
            }elseif (!$form->get('agentMission')->getViewData()){
                $this->addFlash('alert','Vous devez définir au moins un agent pour cette mission');
            }elseif (!$form->get('targetMission')->getViewData()){
                $this->addFlash('alert','Vous devez définir au moins une cible pour cette mission');
            }elseif (!$form->get('contactMission')->getViewData()){
                $this->addFlash('alert','Vous devez définir au moins un contact pour cette mission');
            }else{
                $em->persist($data);
                $em->flush();
                $this->addFlash('success','La nouvelle mission a bien été enregistrée');
            }

        }
        return $this->render('mission/add.html.twig', [
            'form'=>$form->createView(),
            'errors'=>$error,
            'contacts'=>$contacts,
            'planques'=>$planques,
            'agentts'=>$agentts,
            'cibles'=>$cibles
        ]);
    }


    #[Route('/mission/{id}/edit')]
    #[Entity('mission', options: ['id' => 'id'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(AgentRepository $agentRepository,TargetRepository $targets ,PlanqueRepository $planqueRepository,ContactRepository $contactRepository,Mission $mission,ManagerRegistry $manager,Request $request,ValidatorInterface $validator , MissionRepository $missionRepository): Response
    {
        $missions = new Mission();
        $contacts = $contactRepository->findAll();
        $cibles = $targets->findAll();
        $planques = $planqueRepository->findAll();
        $agentts = $agentRepository->findAll();
        $targetsNationality=[];
        $contactMission=[];
        $planqueMissionNationality=[];

        $em = $manager->getManager();
        $form = $this->createForm(MissionType::class,$mission);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($missions);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $codeMissionInsered =$missionRepository->findOneBy([
                'code'=>$form->get('code')->getViewData()
            ]);
            $formAgent = $form->get('agentMission')->getViewData();
            $formTargets = $form->get('targetMission')->getViewData();
            foreach ($formTargets as $target){
                $result = $targets->findOneBy([
                    'id'=>$target
                ]);
                $targetNationali = $result->getNationality();
                foreach ($formAgent as $agents){
                    $nbrAgent = $agentRepository->findOneBy([
                        'id'=>$agents
                    ]);

                    if ($nbrAgent->getNationality() == $targetNationali){
                        $targetsNationality +=[$nbrAgent->getCode() => $result->getCode()];
                    }
                }
            }
            foreach ($form->get('planqueMission')->getViewData() as $planque){
                $planqueNationality = $planqueRepository->findOneBy([
                    'id'=>$planque
                ]);
                if ($planqueNationality->getCountry() != $form->get('country')->getViewData()){
                    $planqueMissionNationality[]=$planqueNationality->getType();
                }
            }
            foreach ($form->get('contactMission')->getViewData() as $contacts){
                $contactNationality = $contactRepository->findOneBy([
                    'id'=>$contacts
                ]);
                if ($contactNationality->getNationality() != $form->get('country')->getViewData()){
                    $contactMission[]=$contactNationality->getCode();
                }
            }
            if ($targetsNationality){
                foreach ($targetsNationality as $key=>$value){
                    $this->addFlash('alert','l\'agent '.$key.' et la cible '.$value.' ne doivent pas avoir la même nationalité');
                }
            }elseif ($contactMission){
                foreach ($contactMission as $contactNvalide){
                    $this->addFlash('alert','le contact '.$contactNvalide.' doit avoir la même nationalité que le pays de la mission');
                }

            }elseif ($planqueMissionNationality){
                foreach ($planqueMissionNationality as $planque){
                    $this->addFlash('alert','la planque '.$planque.' doit avoir la même nationalité que le pays de la mission');
                }
            }
            elseif ($codeMissionInsered && ($codeMissionInsered->getId() != $mission->getId())){
                $this->addFlash('alert','Il existe deja une mission avec ce code');
            }elseif (!$form->get('agentMission')->getViewData()){
                $this->addFlash('alert','Vous devez définir au moins un agent pour cette mission');
            }elseif (!$form->get('targetMission')->getViewData()){
                $this->addFlash('alert','Vous devez définir au moins une cible pour cette mission');
            }elseif (!$form->get('contactMission')->getViewData()){
                $this->addFlash('alert','Vous devez définir au moins un contact pour cette mission');
            }else {
                $em->flush();
                $this->addFlash('success','La mission a bien été modifiée');
                return $this->redirectToRoute('app_mission');
            }
        }
        return $this->render('mission/edit.html.twig', [
            'form'=>$form->createView(),
            'errors'=>$error,
            'contacts'=>$contacts,
            'planques'=>$planques,
            'agentts'=>$agentts,
            'cibles'=>$cibles,
        ]);

    }

    #[Route('/mission/{id}',name:'app_mission_id')]
    #[Entity('mission', options: ['id' => 'id'])]
    public function shoPage(Mission $mission ,MissionRepository $missionRepository):Response
    {
        $mission = $missionRepository->findOneBy([
            'id'=>$mission->getId()
        ]);
        return $this->render('mission/mission_id.html.twig',[
            'mission'=>$mission
        ]);

    }

    #[Route('/mission/{id}/delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Mission $mission ,ManagerRegistry $manager):Response {
        $em = $manager->getManager();
        $em->remove($mission);
        $em->flush();
        $this->addFlash('success','La mission a bien été supprimé');
        return $this->redirectToRoute('app_mission');
    }

}