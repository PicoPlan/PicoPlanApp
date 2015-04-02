<?php
namespace Pico\NewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ArticleFormType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $option){
        $builder
            ->add("title")
            ->add("content")
            ->add("save", "submit");
    }

    public function getName(){
        return "article";
    }
}
