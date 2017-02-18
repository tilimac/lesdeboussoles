<?php

namespace BackofficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvitationFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('email', 'text', array('label' => 'Adresse mail de l\'invité'))
            ->add('save', 'submit', array('label' => 'Envoyer'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontofficeBundle\Entity\Invitation',
        ));
    }

    public function getName() {
        return 'app_invitation';
    }
}
