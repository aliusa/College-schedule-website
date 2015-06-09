<?php

namespace Schedule\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FactionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('text')
            ->add('departament')
            ->add('factionname')
            ->add('form')
            ->add('course')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Schedule\CMSBundle\Entity\Faction'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'schedule_cmsbundle_faction';
    }
}
