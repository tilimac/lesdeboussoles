<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('civil', 'choice', array(
                'label' => 'Titre',
                'choices' => array(
                    'Melle',
                    'Mme',
                    'Mr'
                )
            ))
            ->add('firstName', 'text', array('label' => 'Prénom'))
            ->add('lastName', 'text', array('label' => 'Nom'))
            ->add('birthdate', 'birthday', array(
                'label' => 'Date de naissance',
                'years' => range(date("Y")-90, date("Y")-6)
            ))
            ->add('adress1', 'text', array('label' => 'Adresse'))
            ->add('adress2', 'text', array('label' => 'Complément d\'adresse'))
            ->add('zipCode', 'integer', array('label' => 'Code postal'))
            ->add('city', 'text', array('label' => 'Ville'))
            ->add('phone', 'text', array('label' => 'Téléphone'));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Member',
        ));
    }

    public function getName() {
        return 'app_user_member';
    }
}
