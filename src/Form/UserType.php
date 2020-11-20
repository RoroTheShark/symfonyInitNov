<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Login',
                'label_attr' => ['class' => 'labelForm']
                ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'label_attr' => ['class' => 'labelForm']
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'label_attr' => ['class' => 'labelForm']
                ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'label_attr' => ['class' => 'labelForm']
                ])
            ->add('dateOfBirth', DateType::class, [
                'label' => 'Date de naissance',
                'label_attr' => ['class' => 'labelForm'],
                'attr' => ['style' => 'display: inline-block;']
                ])
            ->add("submit", SubmitType::class, [
                'label' => 'Envoyer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
