<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="user_index", methods= "GET")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


     /**
     * @Route("/profil", name="user_edit_id", methods={"POST", "PATCH"})
     */
    public function edit(Request $request, ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder,  EntityManagerInterface $em): Response
    {
        $newUser = $this->getUser();
        $email = $newUser->getEmail();
        $username = $newUser->getUsername();
        $newUser->setUsername($request->request->get('username'));
        $newUser->setEmail($request->request->get('email'));
        $errors = $validator->validate($newUser);
        if(count($errors)>0){
            $newUser->setUsername($username);
            $newUser->setEmail($email);
            $this->addFlash("danger", "Informations Invalid");
            return $this->redirectToRoute('user_edit_id', compact('errors'));
        }
        $em->flush();
        $this->addFlash("success", "Your profil have been edited succesfully.");
        return $this->redirectToRoute('app_index');
    }
}

// $oldToken = $this->container->get('security.token_storage')->getToken();
//         $token = new UsernamePasswordToken(
//             $oldUser, //user object with updated username
//             null,
//             $oldToken->getProviderKey(),
//             $oldToken->getRoleNames());

//         $this->container->get('security.token_storage')->setToken($token);