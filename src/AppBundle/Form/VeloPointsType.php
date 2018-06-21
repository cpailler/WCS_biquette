<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 18/06/18
 * Time: 16:39
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class VeloPointsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('coutPts', IntegerType::class, array('label' => 'Points'))
            ->add('caution',IntegerType::class, array('label' => 'Dépôt de garantie'));

    }

    /**
    * {@inheritdoc}
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Velo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_veloPoints';
    }

}