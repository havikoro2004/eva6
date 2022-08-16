<?php

namespace App\Controller\pages;

use App\Entity\Agent;
use App\Entity\Contact;
use App\Form\AgentType;
use App\Form\ContactType;
use App\Repository\AgentRepository;
use App\Repository\ContactRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(Request $request ,PaginatorInterface $paginator,ContactRepository $contactRepository): Response
    {
        $error=null;
        $contacts = $contactRepository->findAll();
        $resulta = $paginator->paginate($contacts,$request->query->getInt('page',1,),5);
        return $this->render('contact/index.html.twig', [
        'contacts'=>$resulta,'errors'=>$error
        ]);
    }

    #[Route('/contact/add', name: 'app_contact_add')]
    #[IsGranted('ROLE_ADMIN')]
    public function add(ManagerRegistry $manager,Request $request,ValidatorInterface $validator,ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $em = $manager->getManager();
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($contact);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            if ($contactRepository->findOneBy([
                'code'=>$form->get('code')->getViewData(),
            ])){
                $this->addFlash('alert','Il semble qu\'il y a deja un contact avec ce code ');
            }else {
                $em->persist($data);
                $em->flush();
                $this->addFlash('success','Le nouveau contact a bien été enregistré');
                return $this->redirectToRoute('app_contact');
            }
        }
        return $this->render('contact/add.html.twig',[
            'form'=>$form->createView(),'errors'=>$error
        ]);
    }

    #[Route('/contact/{id}/edit')]
    #[Entity('contact', options: ['id' => 'id'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edite(Contact $contact,ManagerRegistry $manager,Request $request,ValidatorInterface $validator , ContactRepository $contactRepository):Response {
        $em = $manager->getManager();
        $form = $this->createForm(ContactType::class,$contact);
        $form->handleRequest($request);
        $error=null;
        $data = $form->getData($contact);
        if ($data){
            $error = $validator->validate($data);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $resultmission= $contactRepository->findOneBy([
                'code'=>$form->get('code')->getViewData()
            ]);

            /** Vérifier s'il n'y a pas agent du même code et si oui si ce n'est pas le formulaire a modifier en question si c'est le cas on peut modifier **/
            if ($resultmission && ($resultmission->getId() != $contact->getId() )){
                $this->addFlash('alert','Il semble qu\'il y a deja un contact avec ce code ');
            }else {
                $em->flush();
                $this->addFlash('success','Le contact a bien été modifié');
                return $this->redirectToRoute('app_contact');
            }
        }

        $contactInfo = $contactRepository->findAll();
        return $this->render('contact/edit.html.twig', [
            'form'=>$form->createView(),
            'errors'=>$error,'contactInfo'=>$contactInfo
        ]);

    }

    #[Route('/contact/{id}/delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Contact $contact ,ManagerRegistry $manager):Response {
        $em = $manager->getManager();
        $em->remove($contact);
        $em->flush();
        $this->addFlash('success','Le contact a bien été supprimé');
        return $this->redirectToRoute('app_contact');
    }


}
