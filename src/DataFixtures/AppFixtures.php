<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder= $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker =  Factory::create();
        $users= [];
        $imgUrl= "https://randomuser.me/api/portraits/";
        $userAdmin= new User();
        $adminRole= new Role();
        $adminRole->setName('ROLE_ADMIN');
       
        $userAdmin->setFirstname("flamme")
        ->setLastname("phoenix")
        ->setPassword($this->encoder->encodePassword($userAdmin,"azerty"))
        ->setEmail("flamme@gmail.com")
        ->setIntroduction($faker->sentence(6,true))
        ->setDescription ($faker-> paragraph(3,true))
        ->setAvatarUrl($imgUrl.'/men/'.mt_rand(1,99).'.jpg')
        ->addUserRole($adminRole);

        $manager->persist($adminRole);
        $manager->persist($userAdmin);

        // ajout des users
        $genre=["male","female"];
      

        for($i=0; $i<10; $i++){
            $user= new User();
            $pass= $this->encoder->encodePassword($user,"password");
            $userGenre= $faker->randomElement($genre);
            $user->setFirstname($faker->firstname($userGenre))
                 ->setLastname($faker->lastname($userGenre))
                 ->setPassword($pass)
                 ->setEmail($faker->email)
                 ->setIntroduction($faker->sentence(6,true))
                 ->setDescription ($faker-> paragraph(3,true));
            if($userGenre== 'male'){
                $user->setAvatarUrl($imgUrl.'/men/'.mt_rand(1,99).'.jpg');
            }else{
                $user->setAvatarUrl($imgUrl.'/women/'.mt_rand(1,99).'.jpg');
            }
            $manager->persist($user);
            $users[$i]= $user;
        }


        // ajout des annonces factices dans la bd
        for($i=0; $i<20;$i++){
            $ad= new Ad();
            $title = $faker->sentence();
            $img= $faker->imageUrl(600,500);
            $introduction= $faker->paragraph(2);
            $content=  "<p>".join("</p><p>",$faker->paragraphs(4))."</p>";
            $user = $users[mt_rand(0,9)];
        $ad -> setTitle($title)
            -> setImgUrl($img)
            -> setRooms(mt_rand(1,6))
            -> setPrice(mt_rand(35,300))
            -> setContent($content)
            -> setIntroduction($introduction)
            -> setUSer($user);
        $size=mt_rand(3,5);
            for($j=0; $j< $size; $j++){
                $image= new Image();
                $image->setUrl($faker->imageUrl())
                      ->setCaption($faker->sentence())
                      ->setAd($ad);
                $manager->persist($image);
            }
            $manager->persist($ad);
        };
        $manager->flush();
    }
}
