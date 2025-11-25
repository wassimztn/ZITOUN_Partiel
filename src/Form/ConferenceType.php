<?php

namespace App\Form;

use App\Entity\Conference;
use App\Entity\Pathologie;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('date')
            ->add('medecin', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
                'label' => 'Médecin',
            ])
            ->add('pathologie', EntityType::class, [
                'class' => Pathologie::class,
                'choice_label' => 'libelle',
                'label' => 'Pathologie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conference::class,
        ]);
    }
}
