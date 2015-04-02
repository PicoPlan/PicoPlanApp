<?php
namespace Pico\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfilePictureFormType extends AbstractType {
    public function buildform(FormBuilderInterface $builder, array $options){
        $builder
            ->add("picture")
            ->add("upload", "submit");
    }

    public function getName(){
        return "profile_picture";
    }
}