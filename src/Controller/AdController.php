<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ad_items")
     */
    public function index(AdRepository $repo)
    {
        $ads= $repo ->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }
   
   /**
    * It will use to create a form with some one can fill Ad properties
    * 
    * @param Request $request
    * @param ObjectManager $manager
    * 
    * @IsGranted("ROLE_USER", message=" Vous devez vous connecter pour ajouter une nouvelle annonce")
    *
    * @Route ("/ads/new", name = "add_ad");
    * @return Response
    */
    public function create(Request $request, ObjectManager $manager){
        $ad= new Ad();
        $form = $this->createForm(AdType::class,$ad);
        /**
         * Permet de de gerer la requete
         */
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image );
           }
           ad.setUser($this->getUser());

          $manager->persist($ad);
          $manager->flush();
          return    $this->redirectToRoute('item_show' ,['slug' => $ad->getSlug()]);
        }          
        return $this->render("/ad/new.html.twig", [
            'form' => $form->createView()
        ]);
    }

     /**
     * permet recuperer une annoncce en fonction de son slug
     * @Route("/ads/{slug}", name="item_show")
     * @param [type] $slug
     * @param AdRepository $repo
     * @return void
     */
    public function show(Ad $post){
        return $this->render("/ad/show.html.twig",["ad" => $post]);
    }

    /**
     * Permet de modifier une annonce 
     *  
     * @param Ad $ad
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @Security( "is_granted('ROLE_USER') and user === ad.getUser()")
     * 
     * @Route("/ads/{slug}/edit", name ="edit_ad")
     * 
     * @return Response
     */
    public function edit(Ad $ad ,Request $request, ObjectManager $manager){
        $form = $this->createForm(AdType::class,$ad);
        /**
         * Permet de de gerer la requete
         */
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image );
           }
          $manager->persist($ad);
          $manager->flush();
          return    $this->redirectToRoute('item_show' ,['slug' => $ad->getSlug()]);
        }          
        return $this->render("/ad/edit.html.twig", [
            'form' => $form->createView(),
            'ad' => $ad
        ]);

    }
    /**
     * Delete Ad inside the database
     *
     * @Route("ads/{slug}/delete", name="del_ad");
     * 
     * @Security("is_granted('ROLE_USER') and user === ad.getUser()", message=" Vous n'avez pas l'autorisation de supprimer cette annonce")
     * 
     * @param Ad $ad
     * @param ObjectManager $manager
     * @return response
     */
    public function delete(Ad $ad, ObjectManager $manager){
        
        $manager->remove($ad);
        $manager->flush();

       return  $this->redirectToRoute('ad_items');
    }
    

}
