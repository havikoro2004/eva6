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
    public function index(): Response
    {

        return $this->render('mission/index.html.twig', [
            'controller_name' => 'MissionController',

        ]);
    }


}