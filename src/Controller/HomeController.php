<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


    class HomeController extends AbstractController{

        /**
         * @Route("/hello", name="hello")
         * @Route("/hello/{name}", name="hello_partial")
         * @Route("hello/{name}/age/{age}", name="hello_complete", requirements={"age"= ".+"})
         */
        public function hello($name= "inconnu", $age = 0){
            return $this->render(
                'hello.html.twig',
                [
                    "name" => $name,
                    "age" => $age
                ]
                );
        }
        /**
         * @Route("/", name="homepage")
         */
        public function home(){
            return $this->render(
                "home.html.twig",
                [
                    "title" => "Bienvenu sur la page",
                    "users" => ["jordan " => 21, "brice" => 22, "franck" => "16" ]
                ]
            );
        }
    }
?>