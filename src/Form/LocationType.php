<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'label' => 'Miasto',
                'attr' => [
                    'placeholder' => 'Podaj miasto',
                ],
            ])
            ->add('country', ChoiceType::class, [
                'label' => 'Kraj',
                'choices' => [
                    'Polska' => 'PL',
                    'Niemcy' => 'DE',
                    'Wielka Brytania' => 'GB',
                    'Stany Zjednoczone' => 'US',
                    'Francja' => 'FR',
                    'Włochy' => 'IT',
                ],
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'Szerokość geograficzna',
                'scale' => 7,
                'attr' => [
                    'placeholder' => 'np. 53.4285430',
                ],
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'Długość geograficzna',
                'scale' => 7,
                'attr' => [
                    'placeholder' => 'np. 14.5528120',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
            'validation_groups' => function ($form) {
                $data = $form->getData();

                if (null !== $data && null !== $data->getId()) {
                    return ['Default', 'edit'];
                }

                return ['Default', 'new'];
            },
        ]);
    }
}
