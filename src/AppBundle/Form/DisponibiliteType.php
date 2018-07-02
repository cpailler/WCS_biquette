<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;

class DisponibiliteType extends AbstractType
{
    /**
     * {@inheritdoc} Including all fields from Review entity.
     */
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('debut', DateType::class, array(
                'widget'=>'single_text',
                'html5'=>true
    ))
            ->add('fin', DateType::class, array(
                'widget'=>'single_text',
                'html5'=>true
    ));

    }

    /**
     * {@inheritdoc} Targeting Review entity
     */
    public function configureOptions (OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Disponibilite'
        ));
    }

    public function getBlockPrefix ()
    {
        return 'app_bundle_disponibilite_type';
    }
}
