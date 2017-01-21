<?php

namespace BackofficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HikeType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text', array('label' => 'Titre'))
            ->add('locality', 'text', array('label' => 'Lieu'))
            ->add('date', 'datetime', array('label' => 'Date et heure de départ'))
            ->add('distance', 'number', array('label' => 'Distance'))
            ->add('start', 'text', array('label' => 'Début', 'data' => 'Parking sous la salle Jean Moulin, au Crès'))
            ->add('description', 'textarea', array('label' => 'Description', 'attr' => array('class' => 'tinymce')))
            ->add('description', 'textarea', array('label' => 'Description', 'attr' => array('class' => 'tinymce')))
            ->add('canceled', 'choice', array('label' => 'Etat', 'choices' => array('Maintenu', 'Annulé', 'Reporté')))
            ->add('images', 'collection', array(
                // each item in the array will be an "email" field
                'type'   => new ImageType(),
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
                'prototype' => true
            ))
            ->add('courses', CollectionType::class, array(
                'entry_type' => CourseType::class,
                'allow_add' => true,
            ))
            ->add('save', 'submit');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontofficeBundle\Entity\Hike',
        ));
    }

    public function getName() {
        return 'app_hike';
    }
}
