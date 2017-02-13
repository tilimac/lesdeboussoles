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
