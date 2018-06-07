<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 06/06/18
 * Time: 11:30
 */

namespace AppBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;


class VeloDescriptionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array('attr'=> array('maxlength'=>35, 'label'=>'Titre')))
            ->add('description', TextareaType::class, array('attr'=> array('maxlength'=>250, 'label'=>'Description')))
            ->add('marque', TextType::class, array('attr'=> array('label'=>'Marque')))
            ->add('modele')
            ->add('typeVelo')
            ->add('etatVelo')
            ->add('couleur')
            ->add('neuf')
            ->add('numFacture')
            ->add('magasin')
            ->add('dateAchat');
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
        return 'appbundle_VeloDescription';
    }

}