<?php

namespace App\Controller\pages;

use App\Entity\Speciality;
use App\Form\SpecialityType;
use App\Repository\MissionRepository;
use App\Repository\SpecialityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SpecialityController extends AbstractController
{
    #[Route('/speciality', name: 'app_speciality')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(PaginatorInterface $paginator,ManagerRegistry $manager,Request $request,ValidatorInterface $validator , SpecialityRepository $specialityRepository): Response
    {
        $speciality = new Speciality();
        $em = $manager->getManager();
        $form = $this->createForm(SpecialityType::class);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($speciality);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            if ($specialityRepository->findOneBy([
                'name'=>$form->get('name')->getViewData()
            ])){
                $this->addFlash('alert','Il semble que la spécialité existe deja ');
            } else {
                $em->persist($data);
                $em->flush();
                $this->addFlash('success','La spécialité a bien été enregistrée');
            }

        }

        $specialitysList = $specialityRepository->findAll();
        $resulta = $paginator->paginate($specialitysList,$request->query->getInt('page',1,),10);

        return $this->render('speciality/index.html.twig', [
            'controller_name' => 'SpecialityController','form'=>$form->createView(),
            'errors'=>$error,'allSpecialitys'=>$resulta
        ]);
    }

    #[Route('/speciality/{id}/edit')]
    #[Entity('speciality', options: ['id' => 'id'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edite(Speciality $speciality,ManagerRegistry $manager,Request $request,ValidatorInterface $validator , SpecialityRepository $specialityRepository):Response {
        $em = $manager->getManager();
        $form = $this->createForm(SpecialityType::class,$speciality);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($speciality);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $resultUser= $specialityRepository->findOneBy([
                'name'=>$form->get('name')->getViewData()
            ]);

            /** Vérifier s'il n'y a pas de spécialité du même nom et si oui si ce n'est pas le formulaire a modifier en question si c'est le cas on peut modifier **/
            if ($resultUser && ($resultUser->getId() != $speciality->getId() )){
                $this->addFlash('alert','Il semble que la spécialité existe deja ');
            } else {
                $em->flush();
                $this->addFlash('success','La spécialité a bien été modifiée');
                return $this->redirectToRoute('app_speciality');
            }
        }

        $specialitysList = $specialityRepository->findAll();
        return $this->render('speciality/edit.html.twig', [
            'controller_name' => 'editSpeciality','form'=>$form->createView(),
            'errors'=>$error,'allSpecialitys'=>$specialitysList
        ]);

    }

    #[Route('/speciality/{id}/delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(MissionRepository $missionRepository ,Speciality $speciality ,ManagerRegistry $manager):Response {
        $result = $missionRepository->findOneBy([
            'speciality'=>$speciality->getId()
        ]);
        if ($result){
            $this->addFlash('alert','Vous ne pouvez pas supprimer cette spécialité car elle appartient à la mission '.$result->getCode().'');
        } else {
            $em = $manager->getManager();
            $em->remove($speciality);
            $em->flush();
            $this->addFlash('success','La spécialité a bien été suprimé');
        }
        return $this->redirectToRoute('app_speciality');
    }


}