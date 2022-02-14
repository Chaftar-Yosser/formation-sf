<?php
namespace App\Controller;


use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login" , name="login")
     */
    public function login( AuthenticationUtils $authenticationUtils, UserRepository $userRepository)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig' , [
            'last_Username' => $lastUsername,
            'error' => $error
        ]);

    }
}