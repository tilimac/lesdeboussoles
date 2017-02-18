<?php

namespace FrontofficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use FrontofficeBundle\Form\DataTransformer\InvitationToCodeTransformer;

class InvitationRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('firstName', 'text', array('label' => 'Prénom'))
            ->add('lastName', 'text', array('label' => 'Nom'))
            ->add('mail', 'email', array('label' => 'Adresse mail'))
            ->add('save', 'submit', array('label' => 'Envoyer'));
    }

    public function getName() {
        return 'app_user_invitation_request';
    }
}
