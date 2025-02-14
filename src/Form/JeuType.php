<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Jeu;
use Doctrine\DBAL\Types\SmallIntType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JeuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('nbParticipant')
            ->add('evenement', EntityType::class, [
                'class' => Evenement::class,
                'choice_label' => 'id',
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Plateau' => 'Plateau',
                    'Carte' => 'Carte',
                    'Duel' => 'Duel',
                ],
                'mapped' => false,
                'placeholder' => 'Choisir un type de jeu',
            ])
            /* ->add('nbDes', null)
            ->add('nbCarte') */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jeu::class,
        ]);
    }
}
