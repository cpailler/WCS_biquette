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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class VeloPointsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('coutPts', IntegerType::class, array('label' => false))
            ->add('caution',IntegerType::class, array('label' => false))
            ->add('cautionOblig', ChoiceType::class, array(
                'label'    => false,
                'required' => true,
                'expanded'=>true,
                'choices' => array(
                    'Je souhaite fixer un dépôt de garantie' => true,
                    'Je ne souhaite pas fixer de dépôt de garantie' => false)))
            ->add('assurOblig', ChoiceType::class, array(
                    'label'    => false,
                    'required' => true,
                    'expanded'=>true,
                    'choices' => array(
                        'Obligatoire' => true,
                        'Facultative (l’utilisateur peut malgré tout souscrire une assurance s’il le souhaite)' => false))
            );
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