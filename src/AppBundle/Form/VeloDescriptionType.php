<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 06/06/18
 * Time: 11:30
 */

namespace AppBundle\Form;


use AppBundle\Entity\Couleur;
use AppBundle\Entity\EtatVelo;
use AppBundle\Entity\TypeVelo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class VeloDescriptionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array(
                'required'=>false,
                'attr'=> array(
                    'maxlength'=>35,
                    'class'=>'form-control'),
                'label'=>'Titre',
                'label_attr'=>array(
                    'class'=>'row col-sm-12')))
            ->add('description', TextareaType::class, array(
                'required'=>false,
                'attr'=> array(
                    'maxlength'=>250,
                    'class'=>'form-control'),
                'label'=>'Description',
                'label_attr'=>array(
                    'class'=>'row col-sm-12')))
            ->add('marque', TextType::class, array(
                'required'=>false,
                'attr'=> array(
                    'class'=>'form-control'),
                'label'=>'Marque',
                'label_attr'=>array(
                    'class'=>'row col-sm-12')))
            ->add('modele', TextType::class, array(
                'required'=>false,
                'attr'=> array(
                    'class'=>'form-control'),
                'label'=>'Modèle',
                'label_attr'=>array(
                    'class'=>'row col-sm-12')))
            ->add('typeVelo', EntityType::class,array(
                'required'=>false,
                'class'=>TypeVelo::class,
                'label'=>'Type de vélo',
                'label_attr'=>array(
                    'class'=>'row col-sm-12')))
            ->add('etatVelo', EntityType::class,array(
                'required'=>false,
                'class'=>EtatVelo::class,
                'label'=>'Etat du vélo',
                'label_attr'=>array(
                    'class'=>'row col-sm-12')))
            ->add('couleur' ,EntityType::class, array(
                'required'=>false,
                'class'=>Couleur::class,
                'expanded'=>true,
                'choice_label'=>false,
                'label_attr'=>array(
                    'class'=>'row col-sm-12')))
            ->add('neuf', CheckboxType::class, array(
                'required'=>false,
                'label_attr'=>array(
                    'class'=>'row col-sm-1')))
            ->add('numFacture', TextType::class, array(
                'required'=>false,
                'attr'=> array(
                    'class'=>'form-control'),
                'label'=>'Numéro de Facture',
                'label_attr'=>array(
                    'class'=>'row col-sm-12')))
            ->add('magasin', TextType::class, array(
                'required'=>false,
                'attr'=> array(
                    'class'=>'form-control'),
                'label'=>'Magasin d\'Achat',
                'label_attr'=>array(
                    'class'=>'row col-sm-12')))
            ->add('dateAchat', DateType::class, array(
                'widget' => 'choice',
                'years' => range(date('Y'), 1817),
                'required'=>false,
                'label_attr'=>array(
                    'class'=>'row col-sm-12'),
                'attr'=>array('form-control')));
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