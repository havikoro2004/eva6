<?php

namespace App\Controller\pages;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use App\Repository\MissionStatusRepository;
use App\Repository\MissionTypeRepository;
use App\Repository\SpecialityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
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
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {

        return $this->render('mission/index.html.twig', [
            'controller_name' => 'MissionController',

        ]);
    }


    #[Route('/mission/add', name: 'app_mission_add')]
    #[IsGranted('ROLE_ADMIN')]
    public function add(MissionRepository $missionRepository ,ManagerRegistry $manager,Request $request,ValidatorInterface $validator): Response
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
            if ($missionRepository->findOneBy([
                'code'=>$form->get('code')->getViewData()
            ])){
                $this->addFlash('alert','Il existe deja une mission du même code ');
            } else {
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

}