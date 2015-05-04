<?php
namespace Pico\NewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Pico\NewsBundle\Entity\NewsImages;
use Pico\NewsBundle\Form\Type\NewsImagesFormType;

class ArticleFormType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $option){
        $builder
            ->add("title")
            ->add("content")
            ->add("image", new NewsImagesFormType(), array(
                "data_class" => "Pico\NewsBundle\Entity\NewsImages"));
    }

    public function getName(){
        return "article";
    }
}
