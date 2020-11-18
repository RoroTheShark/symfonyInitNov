<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre",
                "label_attr" => [ "class" => "labelForm"]
                ])
            ->add('body', TextareaType::class, [
                "label" => "Contenu",
                "label_attr" => [ "class" => "labelForm"]
                ])
            ->add('book', EntityType::class, [
                    "label" => "Livre",
                    "label_attr" => [ "class" => "labelForm"],
                    "class" => Book::class,
                    "choice_label" => 'title'
                    ])
            ->add('author', TextType::class, [
                "label" => "Auteur",
                "label_attr" => [ "class" => "labelForm"]
                ])
            ->add('date', DateType::class, [
                "label" => "Date",
                "label_attr" => [ "class" => "labelForm"],
                "attr" => ["style" => "display:inline-block;"]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
