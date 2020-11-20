<?php

namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Book;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleAutoUserType extends ArticleType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                "label" => 'Catégorie',
                "label_attr" => ['class' => 'labelForm'],
                "class" => Category::class,
                "choice_label" => "name"
            ])
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
                "label" => "Ecrit par",
                "label_attr" => [ "class" => "labelForm"],
                "disabled" => true,
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

}