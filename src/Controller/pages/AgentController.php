<?php

namespace App\Controller\pages;

use App\Entity\Agent;
use App\Form\AgentType;
use App\Repository\AgentRepository;
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

class AgentController extends AbstractController
{
    #[Route('/agent', name: 'app_agent')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(PaginatorInterface $paginator ,Request $request ,AgentRepository $agent): Response
    {
        $error=null;
        $agents = $agent->findAll();
        $resulta = $paginator->paginate($agents,$request->query->getInt('page',1,),5);
        return $this->render('agent/index.html.twig', [
            'controller_name' => 'AgentController','agents'=>$resulta,'errors'=>$error
        ]);
    }

    #[Route('/agent/add')]
    #[IsGranted('ROLE_ADMIN')]
    public function add(SpecialityRepository $specialityRepository ,ManagerRegistry $manager,Request $request,ValidatorInterface $validator,AgentRepository $agentRepository):Response{
        $specialitys = $specialityRepository->findAll();
        $agent = new Agent();
        $em = $manager->getManager();
        $form = $this->createForm(AgentType::class);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($agent);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            if ($agentRepository->findOneBy([
                'code'=>$form->get('code')->getViewData(),
            ])){
                $this->addFlash('alert','Il semble qu\'il y a deja un agent avec ce code ');
            }elseif (!$form->get('agentSpeciality')->getViewData()){
                $this->addFlash('alert','L\'agent doit avoir au moins une spécialité');
            } else {
                $em->persist($data);
                $em->flush();
                $this->addFlash('success','Le nouvel agent a bien été enregistré');
                return $this->redirectToRoute('app_agent');
            }

        }
        return $this->render('agent/add.html.twig',[
            'form'=>$form->createView(),'errors'=>$error,
            'specialitys'=>$specialitys
        ]);
    }

    #[Route('/agent/{id}/delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Agent $agent ,ManagerRegistry $manager):Response {
        $em = $manager->getManager();
        $em->remove($agent);
        $em->flush();
        $this->addFlash('success','L\'agent a bien été supprimé');
        return $this->redirectToRoute('app_agent');
    }


    #[Route('/agent/{id}/edit')]
    #[Entity('agent', options: ['id' => 'id'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edite(SpecialityRepository $specialityRepository ,Agent $agent,ManagerRegistry $manager,Request $request,ValidatorInterface $validator , AgentRepository $agentRepository):Response {
        $specialitys = $specialityRepository->findAll();

        $em = $manager->getManager();
        $form = $this->createForm(AgentType::class,$agent);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($agent);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $resultmission= $agentRepository->findOneBy([
                'code'=>$form->get('code')->getViewData()
            ]);

            /** Vérifier s'il n'y a pas agent du même code et si oui si ce n'est pas le formulaire a modifier en question si c'est le cas on peut modifier **/
            if ($resultmission && ($resultmission->getId() != $agent->getId() )){
                $this->addFlash('alert','Il semble qu\'il y a deja un agent avec ce code ');
            } elseif (!$form->get('agentSpeciality')->getViewData()){
                $this->addFlash('alert','L\'agent doit avoir au moins une spécialité');
            }else {
                $em->flush();
                $this->addFlash('success','L\'agent a bien été modifié');
                return $this->redirectToRoute('app_agent');
            }
        }

        $agentInfo = $agentRepository->findAll();
        return $this->render('agent/edit.html.twig', [
            'form'=>$form->createView(),
            'errors'=>$error,'agentInfo'=>$agentInfo,
            'specialitys'=>$specialitys
        ]);

    }
}