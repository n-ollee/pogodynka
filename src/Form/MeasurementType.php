<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Measurement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'city',
                'label' => 'Lokalizacja',
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Data pomiaru',
            ])
            ->add('celsius', NumberType::class, [
                'label' => 'Temperatura (°C)',
                'scale' => 2,
            ])
            ->add('humidity', IntegerType::class, [
                'label' => 'Wilgotność (%)',
            ])
            ->add('pressure', IntegerType::class, [
                'label' => 'Ciśnienie (hPa)',
            ])
            ->add('windSpeed', NumberType::class, [
                'label' => 'Prędkość wiatru (km/h)',
                'scale' => 2,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
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
