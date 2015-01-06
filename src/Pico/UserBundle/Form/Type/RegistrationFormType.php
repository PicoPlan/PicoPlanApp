<?php

namespace Pico\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        # Adding some custom fields to forom builder #

        $builder->add('last_name');
        $builder->add('first_name');
        $builder->add('phone');
    }

    public function getParent() {

        return 'fos_user_registration';
    }

    public function getName() {

        return 'pico_user_registration';
    }
}