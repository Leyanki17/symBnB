<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use App\Form\GeneralForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends GeneralForm
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre","Entrer votre titre"))
            ->add('slug', TextType::class, $this->getConfiguration("slug","Entrer le slug", ['required' => false]))
            ->add('imgUrl', UrlType::class, $this->getConfiguration("Lien image", "Entre le lien de l'image"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Ajouter une introduction"))
            ->add('content',TextareaType::class, $this->getConfiguration("Description","Ajouter une description détaillée de l'annonce"))
            ->add('rooms', IntegerType::class, $this->getConfiguration("Chambres","Nombre de chambre"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix/nuit", "Entrer le prix de la chambre pour une nuit"))
            ->add('images', CollectionType::Class,[
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
