<?php

namespace FrontofficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('civil', 'text', array('label' => 'Civilité','required' => false))
            ->add('firstName', 'text', array('label' => 'Prénom','required' => false))
            ->add('lastName', 'text', array('label' => 'Nom','required' => false))
            ->add('adress1', 'text', array('label' => 'Adresse 1','required' => false))
            ->add('adress2', 'text', array('label' => 'Adresse 2','required' => false))
            ->add('zipcode', 'text', array('label' => 'Code postall','required' => false))
            ->add('city', 'text', array('label' => 'Vile','required' => false))
            ->add('phone', 'text', array('label' => 'Téléphone','required' => false))
            ->add('save', 'submit', array('label' => 'Enregistrer'))
            ->remove('username');
    }

    public function getParent() {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getName() {
        return 'app_user_profile';
    }
}