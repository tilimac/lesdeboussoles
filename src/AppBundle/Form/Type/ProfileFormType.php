<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ProfileFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('members', CollectionType::class, array(
                'entry_type' => MemberFormType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->remove('username')
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                $user = $event->getData();
                $form = $event->getForm();

                if (!$user) {
                    return;
                }

                foreach ($user->getMembers() as $member){
                    /* @var Member $member */
                    $member->setUser($user);
                }
            });
    }

    public function getParent() {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getName() {
        return 'app_user_profile';
    }
}