<?php

namespace FrontofficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('firstName', 'text', array('label' => 'Prénom'))
                ->add('lastName', 'text', array('label' => 'Nom'))
                ->add('phoneNumber', 'text', array('label' => 'Nom'))
                ->add('mail', 'text', array('label' => 'Nom'))
                ->add('message', 'textarea', array('label' => 'Nom'));
    }

    public function getName() {
        return 'app_user_profile';
    }
}
