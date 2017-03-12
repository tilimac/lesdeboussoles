<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('members', CollectionType::class, array(
                'entry_type' => MemberFormType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->remove('username');
    }

    public function getParent() {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getName() {
        return 'app_user_profile';
    }
}