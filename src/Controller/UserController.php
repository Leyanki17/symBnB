<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Password;
use App\Form\EditUserType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * Permet la connexion d'un utilisateur
     * 
     * @security("user!==null" ,message="Vous êtes deja connecter");
     * 
     * @Route("/user", name="user_login")
     * 
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        
        $error = $utils->getLastAuthenticationError();

        $username= $utils->getLastUsername();
        return $this->render('/user/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username,
        ]);
    }

    /**
     * Permet l'inscription d'un utilisateur
     * 
     * @security("user===null" ,message="Vous ne pouvez pas vous inscrire tout étant connecter");
     * 
     * @Route("/inscription", name="user_signup")
     * 
     * @return Response
     */
    public function signup(Request $request,ObjectManager $manager,UserPasswordEncoderInterface $encode){
        $user= new User();
        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $password= $encode->encodePassword($user,$user->getPassword());
            $user->setPassword($password);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute("user_login");
        }
        return $this->render("/user/signup.html.twig",[
            'form' => $form->createView()
        ]);
    }
    /**
     * Modification des données utilisateur
     *
     * @IsGranted("ROLE_USER")
     * 
     * @Route("user/edit", name="edit_user")
     * 
     * @return Response
     */
    public function edit(Request $request, ObjectManager $manager){

        $user= $this->getUser();

       $form = $this->createForm(EditUserType::class, $user); 
    
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
           $manager->persist($user);
           $manager->flush();
           return $this->redirectToRoute('/user/{slug}', ['slug' => $user->getSlug()]);
       }
        return $this->render('/user/edit.html.twig',[
            'form' => $form->createView(),
            'username' => $user->getFirstname().' '.$user->getLastname(),
            'slug' => $user->getSlug(),
        ]);

    }


    /**
     * Modification des données utilisateur
     *
     * @IsGranted("ROLE_USER")
     * 
     * @Route("user/edit/password", name="edit_password_user")
     * 
     * @return Response
     */
    public function editUserPassword(Request $request,UserPasswordEncoderInterface $encode,ObjectManager $manager){
        $pass= new Password();
        $user = $this->getUser();
        
        $form = $this->createForm(PasswordUpdateType::class, $pass);
        $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
            if(!password_verify($pass->getLastPassword(),$user->getPassword())){
                $form->get("lastPassword")->addError(new FormError("Veuillez renseigner le bon mot de passe"));
            }else{
                $password= $encode->encodePassword($user,$pass->getNewPassword());
                $user->setPassword($password);
                $manager->persist($user);
                $manager->flush();
                return $this->redirectToRoute('/user/{slug}', ['slug' => $user->getSlug()]);
            }
       }
        
        return $this->render('/user/edit_password.html.twig',[
            'form' => $form->createView(),
            'username' => $user->getFirstname().' '.$user->getLastname(),
        ]);
 
     }

    /**
     * Permet de se déconnecter
     * 
     * @Route("/logout", name="user_logout")
     * 
     * @return void
     */
    public function logout(){}
}

