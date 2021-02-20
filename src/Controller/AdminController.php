<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $userRepo;
    function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    /**
     * @Route("/admin", name="index_admin")
     */
    public function index(): Response
    {
        $users = $this->userRepo->findAll();
        return $this->render('admin/index.html.twig', compact("users"));
    }
}
