<?php

namespace FrontofficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('firstName', 'text', array('label' => 'Prénom'))
                ->add('lastName', 'text', array('label' => 'Nom'))
                ->add('save', 'submit', array('label' => 'Enregistrer'));
    }

    public function getParent() {
        return 'fos_user_registration';
    }

    public function getName() {
        return 'app_user_registration';
    }
}
