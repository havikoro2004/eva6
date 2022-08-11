<?php

namespace App\Form;

use App\Entity\Planque;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code',TextType::class)
            ->add('adresse',TextareaType::class)
            ->add('country',CountryType::class)
            ->add('type',EntityType::class,[
                'class' => \App\Entity\PlanqueType::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir un type',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Planque::class,
        ]);
    }
}
