<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre",
                "label_attr" => [ "class" => "labelForm"]
                ])
            ->add('resume', TextareaType::class, [
                "label" => "Résumé",
                "label_attr" => [ "class" => "labelForm"]
            ])
            ->add('nbOfPages', IntegerType::class, [
                "label" => "Nombre de Pages",
                "label_attr" => [ "class" => "labelForm"]
            ])
            ->add('publishedDate', DateType::class, [
                "label" => "Date de publication",
                "label_attr" => [ "class" => "labelForm"],
                "attr" => ["style" => "display:inline-block;"]
            ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
