<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Password;
use App\Form\GeneralForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends GeneralForm
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastPassword',
                PasswordType::class,
                $this->getConfiguration('Mot de passe', "Entrer votre mot de passe actuel")
            )
            ->add('newPassword',
                PasswordType::class,
                $this->getConfiguration('Mot de passe', "Entrer votre nouveau mot de passe")
            )
            ->add('confirmNewPassword',
                PasswordType::class,
                $this->getConfiguration('Confirmation Mot de passe', "confirmer votre nouveau votre mot de passe")
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Password::class,
        ]);
    }
}
