<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'required' => true
            ])
            ->add('monthlyPrice', NumberType::class, [
                'required' => true
            ])
            ->add('dailyPrice', NumberType::class, [
                'required' => true
            ])
            ->add('seats', ChoiceType::class, [
                'choices' => range(1, 9, 1),
                'choice_label' => function ($choice) {
                    return $choice;
                },
                'required' => true
            ])
            ->add('isManual', ChoiceType::class, [
                'choices' => [
                    'Manuelle' => true,
                    'Automatique' => false
                ],
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
