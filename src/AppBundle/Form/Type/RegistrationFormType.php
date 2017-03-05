<?php
namespace AppBundle\Form\Type;
use AppBundle\Entity\Member;
use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RegistrationFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        /*$dateTimeNow = new \DateTime();
        $yearMax = $dateTimeNow->format('Y');
        $yearMin = $yearMax-100;*/
        $builder
            ->add('invitation', 'AppBundle\Form\Type\InvitationFormType')
            ->add('members', CollectionType::class, array(
                'entry_type' => MemberFormType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->add('accept', 'checkbox', array(
                'label' => 'J\'accepte le règlement et la politique de confidentialité',
                'mapped' => false
            ))
            ->remove('username');


        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();

            /* @var User $user */
            foreach ($user->getMembers() as $member) {
                /* @var Member $member */
                $member->setUser($user);
            }

            /*if (!$user) {
                return;
            }

            // Check whether the user has chosen to display his email or not.
            // If the data was submitted previously, the additional value that is
            // included in the request variables needs to be removed.
            if (true === $user['show_email']) {
                $form->add('email', EmailType::class);
            } else {
                unset($user['email']);
                $event->setData($user);
            }*/
        });
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