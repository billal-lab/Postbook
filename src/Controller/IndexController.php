<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Post;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends AbstractController
{
    private $postRepo;
    private $likeRepo;
    
    public function __construct(PostRepository $postRepo, LikeRepository $likeRepo) {
        $this->postRepo = $postRepo;
        $this->likeRepo = $likeRepo;
    }

    /**
     * @Route("/index", name="app_index", methods={"GET"})
     */
    public function index(): Response
    {
        $posts = $this->postRepo-> findBy([],['createdAt'=>"DESC"]);
        return $this->render('index/index.html.twig', compact("posts"));
    }

    /**
     * @Route("/index/create", name="app_create", methods= {"POST"})
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
     * @Route("/index/edit/{id}", name="app_edit", methods= {"PUT"})
     */
    public function edit(Post $post,Request $request ,EntityManagerInterface $em ): Response
    {
        $post->setContent($request->request->get('content'));
        $em->flush();
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
        $this->addFlash("success","Le post a été bien modifié !");
        return $this->redirectToRoute('app_index');
    }

    /**
     * @Route("/index/edit/{id}", name="app_delete", methods= {"DELETE"})
     */
    public function delete(Post $post, EntityManagerInterface $em ): Response
    {
        $em->remove($post);
        $em->flush();
        $this->addFlash("success","Le post a été bien suprimé");
        return $this->redirectToRoute('app_index');
    }

    /**
     * @Route("/index/like/{id}", name="app_like")
     */
    public function like(Post $post,  EntityManagerInterface $em){
        
        if(!$post->isLaked($this->getUser())){
            $like = new Like;
            $like->setUser($this->getUser());
            $like->setPost($post);
            $em->persist($like);
            $em->flush();
            $nb = $this->likeRepo->findBy(["post"=>$post]);
            return new JsonResponse([
                "code"=> 200,
                "message" => "",
                "action" => "dislike",
                "nbLike" => count($nb)
            ]);
        }else{
            $em->remove($this->likeRepo->findOneBy(["user"=>$this->getUser(),"post"=>$post]));
            $em->flush();
            $nb = $this->likeRepo->findBy(["post"=>$post]);
            return new JsonResponse([
                "code"=> 200,
                "message" => "",
                "action" => "like",
                "nbLike" => count($nb)
            ]);
        }
        $nb = $this->likeRepo->findBy(["post"=>$post]);
        return new JsonResponse([
            "code"=> 200,
            "message" => "",
            "nbLike" => count($nb)
        ]);
    }
}
