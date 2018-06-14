<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 14/06/18
 * Time: 10:35
 */

namespace AppBundle\Form;


use AppBundle\Entity\Equipement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VeloEquipementType extends AbstractType
{
    /**
     * {@inheritdoc} Including all fields from Review entity.
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('equipements' ,EntityType::class, array(
                'required'=>false,
                'label'=> false,
                'class'=>Equipement::class,
                'expanded'=>true,
                'multiple'=>true,
                'choice_label'=>'equipement',
                'label_attr'=>array(
                    'class'=>'row col-sm-12')));
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
        return 'appbundle_VeloEquipment';
    }


}