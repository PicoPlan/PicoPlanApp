<?php

namespace Pico\CalendarManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('description', 'text')
            ->add('datetimeStart', 'datetime',array('data' => new \DateTime()))
            ->add('datetimeEnd', 'datetime',array('data' => new \DateTime()))
            ->add('repeating', new RepeatingeventType(), array('mapped' => false))
            ->add('save', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pico\CalendarManagerBundle\Entity\Event' ,
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pico_calendarmanagerbundle_event';
    }
}
