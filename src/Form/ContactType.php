<?php

namespace App\Form;

use App\Entity\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContactType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom'), array('required' => true))
            ->add('email', TextType::class, array('label' => 'Email'), array('required' => true))
            ->add('phone', TextType::class, array('label' => 'Numéro de téléphone'), array('required' => false))
            ->add('subject', TextType::class, array('label' => 'Sujet'), array('required' => true))
            ->add('message', TextareaType::class, array('label' => 'Message'), array('required' => true))
            ->add('post', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => Contact::class,
        ]);
    }
}
