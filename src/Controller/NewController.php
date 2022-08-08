<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class NewController extends AbstractController
{
    #[Route('/new', name: 'app_new')]
    public function index(ManagerRegistry $manager,UserPasswordHasherInterface $passwordHasher): Response
    {
        // ... e.g. get the user data from a registration form
        $user = new User();
        $user->setFirstName('najib')->setLastName('flata')
            ->setEmail('havikoro2004@gmail.com')->setCreateAt(New \DateTime('now'));
        $plaintextPassword ='102030mp3';

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        $em =$manager->getManager();
        $em->persist($user);
        $em->flush();
        return $this->render('new/index.html.twig', [
            'controller_name' => 'NewController',
        ]);
    }
}
