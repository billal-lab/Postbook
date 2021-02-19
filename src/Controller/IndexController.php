<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class IndexController extends AbstractController
{
    private $postRepo;
    public function __construct(PostRepository $postRepo) {
        $this->postRepo = $postRepo;
    }

    /**
     * @Route("/", name="app_index", methods={"GET"})
     */
    public function index(): Response
    {
        $posts = $this->postRepo->findAll();
        return $this->render('index/index.html.twig', compact("posts"));
    }

    /**
     * @Route("/", name="app_create", methods= {"POST"})
     */
    public function create(Request $request, EntityManagerInterface $em, ValidatorInterface $validator ): Response
    {
        $post = new Post;
        $post->setContent($request->request->get('content'));
        $post->setOwner($this->getUser());
        $errors = $validator->validate($post);
        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $this->addFlash("error","Your post can not be empty.");
            return $this->redirectToRoute('app_index');
        }

        $em->persist($post);
        $em->flush();
        $this->addFlash("success","Congratulations !");
        return $this->redirectToRoute('app_index');
    }

    /**
     * @Route("/", name="app_edit", methods= {"PUT"})
     */
    public function edit(Request $request, EntityManagerInterface $em, ValidatorInterface $validator ): Response
    {
        dd("edit");
        // $post = new Post;
        // $post->setContent($request->request->get('content'));
        // $post->setOwner($this->getUser());
        // $errors = $validator->validate($post);
        // if (count($errors) > 0) {
        //     /*
        //      * Uses a __toString method on the $errors variable which is a
        //      * ConstraintViolationList object. This gives us a nice string
        //      * for debugging.
        //      */
        //     $this->addFlash("error","Your post can not be empty.");
        //     return $this->redirectToRoute('app_index');
        // }

        // $em->persist($post);
        // $em->flush();
        // $this->addFlash("success","Congratulations !");
        // return $this->redirectToRoute('app_index');
    }
}
