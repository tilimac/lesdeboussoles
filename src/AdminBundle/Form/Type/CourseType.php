<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('duration', 'time', array('label' => 'Durée'))
            ->add('lenght', 'number', array('label' => 'Longueur'))
            ->add('heightDifference', 'number', array('label' => 'Dénivelé'))
            ->add('dificulty', 'choice', array(
                'label' => 'Difficulté',
                'choices' => array('Facile', 'Moyen', 'Difficile')
            ))
            ->add('gpx', 'file', array(
                'required'  => false,
                'data_class' => null
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Course',
        ));
    }

    public function getName() {
        return 'app_course';
    }
}
