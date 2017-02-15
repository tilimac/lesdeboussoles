<?php

namespace FrontofficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        /*$dateTimeNow = new \DateTime();
        $yearMax = $dateTimeNow->format('Y');
        $yearMin = $yearMax-100;*/

        $builder
            ->add('invitation', 'FrontofficeBundle\Form\Type\InvitationFormType')
            ->add('civil', 'choice', array(
                'label' => 'Titre',
                'choices' => array(
                    'Melle',
                    'Mme',
                    'Mr'
                )
            ))
            ->add('firstName', 'text', array('label' => 'Prénom'))
            ->add('lastName', 'text', array('label' => 'Nom'))
            ->add('birthdate', 'birthday', array( 'label' => 'Date de naissance'))
            ->add('adress1', 'text', array('label' => 'Adresse'))
            ->add('adress2', 'text', array('label' => 'Complément d\'adresse'))
            ->add('zipCode', 'integer', array('label' => 'Code postal'))
            ->add('city', 'text', array('label' => 'Ville'))
            ->add('phone', 'text', array('label' => 'Téléphone'))
            ->add('accept', 'checkbox', array(
                'label' => 'J\'accepte le règlement et la politique de confidentialité',
                'mapped' => false
            ))
            ->add('save', 'submit', array('label' => 'Enregistrer'))
            ->remove('username');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return 'app_user_registration';
    }
}
