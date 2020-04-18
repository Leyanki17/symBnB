<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
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

class GeneralForm extends AbstractType
{

    /**
     * Permet de personnaliser un champs du formulaire
     *
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    protected function getConfiguration($label,$placeholder,$options= []){
        return array_merge( [
                'label' =>  $label,
                'attr' => [
                    'placeholder' => $placeholder
                ]],
                $options
        );
    }
 
}
