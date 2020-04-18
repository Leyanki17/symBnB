<?php

namespace App\Form;

use App\Entity\User;
use App\Form\GeneralForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserType extends GeneralForm
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',
                TextType::class, 
                $this->getConfiguration("Prénom","Entre votre prénom....")
            )
            ->add('lastname',
                TextType::class,
                $this->getConfiguration("Nom", "Entre votre noms")
            )
            ->add('email',
                EmailType::class,
                $this->getConfiguration("Email", "Entrer votre adresse email...")
            )
            ->add('password',
                PasswordType::class,
                $this->getConfiguration('Mot de passe', "Entrer votre mot de passe")
            )
            ->add('confirmPassword',
                PasswordType::class,
                $this->getConfiguration('Confirmation Mot de passe', "confirmer votre  votre mot de passe")
            )
            ->add('introduction',
                TextType::class,
                $this->getConfiguration('Introduction','Donnez une descrition resumé de vous')
            )
            ->add('description',
                TextareaType::class,
                $this->getConfiguration("description","Donner une description compléte sur vous")
            )
            ->add('avatar_url',
                UrlType::class,
                $this->getConfiguration('Url avatar', 
                    "Entrer l'url de votre image d'avatar",
                    [
                        'required' => false,
                    ]
                )
            )
            ->add('slug',
                TextType::class,
                $this->getConfiguration('Slug',
                    "Entrez votre slug ...",
                    [
                       'required' => false,
                    ]
                )
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
