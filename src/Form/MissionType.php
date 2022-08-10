<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Contact;
use App\Entity\Mission;
use App\Entity\MissionStatus;
use App\Entity\Speciality;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Countries;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code',TextType::class)
            ->add('title',TextType::class)
            ->add('description',TextareaType::class)
            ->add('country',CountryType::class)
            ->add('dateDebut',DateType::class,[
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->add('dateFin',DateType::class,[
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->add('type',EntityType::class,[
                'class' => \App\Entity\MissionType::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir un type',
            ])
            ->add('status',EntityType::class,[
                'class' =>MissionStatus::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir un status',
            ])
            ->add('speciality',EntityType::class,[
                'class' =>Speciality::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir un status',
            ])

            ->add('agentMission',EntityType::class,[
                'class' =>Agent::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => function ($agent) {

                    return $agent->getCode()
                        .' '. '('.Countries::getName($agent->getNationality()).')' ;

                }
            ])
            ->add('contactMission',EntityType::class,[
                'class' =>Contact::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => function ($contact) {

                    return $contact->getCode()
                        .' '. '('.Countries::getName($contact->getNationality()).') ' ;

                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
