<?php

namespace BackofficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EventType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text', array('label' => 'Titre'))
            ->add('image', 'text', array('label' => 'Image'))
            ->add('dateEvent', 'datetime', array(
                'label' => 'Date',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy HH:mm',
            ))
            ->add('content', 'textarea', array('label' => 'Contenu', 'attr' => array('class' => 'tinymce')))
            ->add('save', 'submit', array('label' => 'Enregistrer'));
    }

    public function getName() {
        return 'app_event';
    }
}
