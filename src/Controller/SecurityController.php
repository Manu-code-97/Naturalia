<?php

namespace App\Controller;

use App\Dto\UtilisateurDto;
use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class SecurityController extends AbstractController
{

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }



    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    // route d'enregistrement si jamais on n'est logué ? 
    #[Route(path: '/register', name: 'app_register', methods: ['POST'])]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    )
    {

        if ( ! $this->isCsrfTokenValid('authenticate', $request->request->get('_csrf_token')) ) 
        {
            $this->addFlash('error', "Le token est invalide");

            return $this->redirectToRoute('app_login');
        }

        // Préparons l'utilsateur
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail($request->request->get('register_email'));
        $utilisateur->setPassword($request->request->get('register_password'));
        $utilisateur->setPassword($request->request->get('register_confirm_password'));

        // Validation
        $errors = $validator->validate($utilisateur);

        //  je Vérifie que les mots de passe correspondent
        if ($request->request->get('register_password') !== $request->request->get('register_confirm_password')) 
        {
            // $errorMessages[] = "Les mots de passe ne correspondent pas !";
            $this->addFlash('registrationErrorMessages', "Les mots de passe ne correspondent pas !");
            return $this->redirectToRoute('app_login');
        }

        if (count($errors) > 0)
        {
            foreach ($errors as $error) 
            {
                // $errorMessages[] = $error->getMessage();
                $this->addFlash('registrationErrorMessages', $error->getMessage());
            }
            
            return $this->redirectToRoute('app_login');
        }

        $utilisateur->setPassword(
            $passwordHasher->hashPassword($utilisateur, $request->request->get('register_password'))
        );

        // Sauvegarder l'utilisateur dans la base de données
        $entityManager->persist($utilisateur);
        $entityManager->flush();

        // Rediriger ou afficher un message
        $this->addFlash('success', "Votre compte est bien créé, vous maintenant vous connecter.");
        return $this->redirectToRoute('app_login');
    }

}
