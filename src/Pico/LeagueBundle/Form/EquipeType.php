<?php
namespace Pico\LeagueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EquipeType extends AbstractType
{

    /**
     *
     * @param FormBuilderInterface $builder            
     * @param array $options            
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('description')
            ->add('listeModo','hidden')
            ->add('listeModo_id_client', 'entity', array(
                'mapped'   => false,
                'class'    => 'PicoUserBundle:User',
                'label'    => 'Liste des moderateurs'
            ))
            ->add('sport', 'entity', array(
            'class' => 'PicoLeagueBundle:Sport',
            'property' => 'nom'
        ))
            ->add('id_club', 'hidden')
            ->add('Valider', 'submit');
    }

    /**
     *
     * @param OptionsResolverInterface $resolver            
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pico\LeagueBundle\Entity\Equipe'
        ));
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'pico_leaguebundle_equipe';
    }
}
