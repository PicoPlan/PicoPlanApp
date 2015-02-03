<?php

namespace Pico\CalendarManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RepeatingeventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('repeat','checkbox', array('mapped' => false, 'required' => false))
            ->add('weekday', 'choice',array(
                                        'choices' => array(
                                            '1' => 'Lundi',
                                            '2' => 'Mardi'
                                            )))
            ->add('dateStartrepeat', 'date',array('data' => new \DateTime()))
            ->add('dateEndrepeat', 'date',array('data' => new \DateTime()))
            ->add('frequency', 'choice',array(
                                        'choices' => array(
                                            '+1 day' => 'Tout les jours',
                                            '+7 day' => 'Toute les semaines',
                                            '+14 day' => 'Tout les deux semaines',
                                            '+1 month' => 'Tout les mois'
                                            ),'required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pico\CalendarManagerBundle\Entity\Repeatingevent' ,
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pico_calendarmanagerbundle_repeatingevent';
    }
}
