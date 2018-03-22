<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,array('label' => 'Titre'), array('required' => true))
            ->add('publishedAt', DateType::class)
            //->add('publishedAt', DateType::class, array('required' => true))  Seulement utile pour les Event->selectionner la date
            ->add('summary', TextType::class,array('label' => 'Résumé'), array('required' => true))
            ->add('content', TextareaType::class, array('label' => 'Post'),array('required' => false), array('attr' => array('class' => 'tinymce')))
            ->add('create', SubmitType::class,array('attr' => array('class' => 'btn btn-primary')))
            ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Post::class,
        ));
    }

}