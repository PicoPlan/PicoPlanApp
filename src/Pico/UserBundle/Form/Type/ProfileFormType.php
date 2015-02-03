<?php

namespace Pico\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        # adds user fields according to current Entity user #

        parent::buildForm($builder, $options);


        $builder->add("last_name", "text");
        $builder->add("first_name", "text");
        $builder->add("phone", "number");
    }

    protected function buildUserForm(FormBuilderInterface $builder, array $options){
        parent::buildUserForm($builder, $options);
    }

    public function getParent() {

        return "fos_user_profile";
    }

    public function getName() {

        return "pico_user_profile";
    }
}