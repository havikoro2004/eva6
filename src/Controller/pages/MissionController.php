<?php

namespace App\Controller\pages;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\ContactRepository;
use App\Repository\MissionRepository;
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
        $error=null;
        $missions = $missionRepository->findAll();
        $resulta = $paginator->paginate($missions,$request->query->getInt('page',1,),10);
        return $this->render('mission/index.html.twig', [
            'controller_name' => 'missionController','missions'=>$resulta,'errors'=>$error
        ]);
    }

    #[Route('/mission/add', name: 'app_mission_add')]
    #[IsGranted('ROLE_ADMIN')]
    public function add(ContactRepository $contactRepository ,MissionRepository $missionRepository ,ManagerRegistry $manager,Request $request,ValidatorInterface $validator): Response
    {
        $mission = new Mission();
        $em = $manager->getManager();
        $form = $this->createForm(MissionType::class);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($mission);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){

        $contactData = $form->get('contactMission')->getViewData();
        $countMissionCountry=0;
                foreach ($contactData as $contact){
                    $testeContact = $contactRepository->findOneBy([
                        'id'=>$contact
                    ]);
                    if($testeContact->getNationality() === $form->get('country')->getViewData()){
                        $countMissionCountry++;
                    }
                }
            if ($countMissionCountry < count($contactData)){
                $this->addFlash('alert','Les contact doivent avoir la même nationalité que le pays de la mission');
            } elseif($missionRepository->findOneBy([
                'code'=>$form->get('code')->getViewData()
            ])){
                $this->addFlash('alert','Il existe deja une mission avec ce code');
            }elseif (!$form->get('agentMission')->getViewData()){
                $this->addFlash('alert','Il Faut au moins un agent pour cette mission');
            }else {
                $em->persist($data);
                $em->flush();
                $this->addFlash('success','La mission a bien été enregistrée');
                return $this->redirectToRoute('app_mission');
            }
        }
        return $this->render('mission/add.html.twig', [
            'form'=>$form->createView(),
            'errors'=>$error
        ]);
    }


    #[Route('/mission/{id}/edit')]
    #[Entity('mission', options: ['id' => 'id'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(ContactRepository $contactRepository,Mission $mission,ManagerRegistry $manager,Request $request,ValidatorInterface $validator , MissionRepository $missionRepository): Response
    {
        $missions = new Mission();
        $em = $manager->getManager();
        $form = $this->createForm(MissionType::class,$mission);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($missions);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $missionAgent = $missionRepository->findOneBy([
                'code'=>$form->get('code')->getViewData()
            ]);
            $contactData = $form->get('contactMission')->getViewData();
            $countMissionCountry=0;
            foreach ($contactData as $contact){
                $testeContact = $contactRepository->findOneBy([
                    'id'=>$contact
                ]);
                if($testeContact->getNationality() === $form->get('country')->getViewData()){
                    $countMissionCountry++;
                }
            }
            if ($countMissionCountry < count($contactData)){
                $this->addFlash('alert','Les contact doivent avoir la même nationalité que le pays de la mission');
            } elseif($missionAgent && ($missionAgent->getId() != $mission->getId())){
                $this->addFlash('alert','Il existe deja une mission avec ce code');
            }elseif (!$form->get('agentMission')->getViewData()){
                $this->addFlash('alert','Il Faut au moins un agent pour cette mission');
            }else {
                $em->flush();
                $this->addFlash('success','La mission a bien été modifiée');
                return $this->redirectToRoute('app_mission');
            }
        }
        return $this->render('mission/edit.html.twig', [
            'form'=>$form->createView(),
            'errors'=>$error
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