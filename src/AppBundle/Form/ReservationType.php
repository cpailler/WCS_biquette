<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 02/07/18
 * Time: 16:15
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ReservationType extends AbstractType
{
    /**
     * {@inheritdoc} Including all fields from Reservation entity.
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
     * {@inheritdoc} Targeting Reservation entity
     */
    public function configureOptions (OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Reservation'
        ));
    }

    public function getBlockPrefix ()
    {
        return 'app_bundle_reservation_type';
    }

}