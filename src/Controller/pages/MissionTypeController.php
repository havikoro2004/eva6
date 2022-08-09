<?php

namespace App\Controller\pages;

use App\Entity\MissionType;
use App\Form\MissionTypeType;
use App\Repository\MissionRepository;
use App\Repository\MissionTypeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MissionTypeController extends AbstractController
{
    #[Route('/type', name: 'app_mission_type')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(PaginatorInterface $paginator,ManagerRegistry $manager,Request $request,ValidatorInterface $validator , MissionTypeRepository $missionType): Response
    {
        $mission = new MissionType();
        $em = $manager->getManager();
        $form = $this->createForm(MissionTypeType::class);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($mission);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            if ($missionType->findOneBy([
                'name'=>$form->get('name')->getViewData()
            ])){
                $this->addFlash('alert','Il semble que ce type existe deja ');
            } else {
                $em->persist($data);
                $em->flush();
                $this->addFlash('success','Le type de mission a bien été enregistrée');
            }

        }

        $missionList = $missionType->findAll();
        $resulta = $paginator->paginate($missionList,$request->query->getInt('page',1,),10);
        return $this->render('mission_type/index.html.twig', [
            'controller_name' => 'MissionTypeController','form'=>$form->createView(),
            'errors'=>$error,'allMissionType'=>$resulta
        ]);
    }

    #[Route('/type/{id}/edit')]
    #[Entity('mission', options: ['id' => 'id'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edite(MissionType $mission,ManagerRegistry $manager,Request $request,ValidatorInterface $validator , MissionTypeRepository $missionTypeRepository):Response {
        $em = $manager->getManager();
        $form = $this->createForm(MissionTypeType::class,$mission);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($mission);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $resultUser= $missionTypeRepository->findOneBy([
                'name'=>$form->get('name')->getViewData()
            ]);

            /** Vérifier s'il n'y a pas de spécialité du même nom et si oui si ce n'est pas le formulaire a modifier en question si c'est le cas on peut modifier **/
            if ($resultUser && ($resultUser->getId() != $mission->getId() )){
                $this->addFlash('alert','Il semble que ce type existe deja ');
            } else {
                $em->flush();
                $this->addFlash('success','Le type a bien été modifiée');
                return $this->redirectToRoute('app_mission_type');
            }
        }

        $missions = $missionTypeRepository->findAll();
        return $this->render('mission_type/edit.html.twig', [
            'controller_name' => 'editTypemission','form'=>$form->createView(),
            'errors'=>$error,'allMissionType'=>$missions
        ]);

    }

    #[Route('/type/{id}/delete',name: 'app_mission_d')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(MissionRepository $missionRepository ,MissionType $missionType ,ManagerRegistry $manager):Response {

        $missionWithThisType = $missionRepository->findOneBy([
            'type'=>$missionType->getId()
        ]);

        if ($missionWithThisType){
            $this->addFlash('alert','Vous ne pouvez pas surppirmer ce type car il appartient à la mission '.$missionWithThisType->getCode().'');
        } else {
            $em = $manager->getManager();
            $em->remove($missionType);
            $em->flush();
            $this->addFlash('success','Le type de la mission a bien été surppimé');
        }
        return $this->redirectToRoute('app_mission_type');
    }
}
