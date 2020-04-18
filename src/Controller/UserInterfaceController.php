<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserInterfaceController extends AbstractController
{
    /**
     * @Route("/user/{slug}", name="show_user_interface")
     */
    public function show(User $user)
    {
        return $this->render('user_interface/show.html.twig',[
            'user' => $user 
        ]);
    }
}
