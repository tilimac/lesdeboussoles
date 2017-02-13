<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 11/02/2017
 * Time: 16:53
 */

namespace AppBundle\Command;

use FrontofficeBundle\Entity\Member;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use FrontofficeBundle\Entity\User;

class SwitchUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "app/console")
            ->setName('user:switch')

            // the short description shown while running "php app/console list"
            ->setDescription('Switch users.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $users = $this->getContainer()->get('doctrine')
            ->getRepository('FrontofficeBundle:User')->findAll();

        foreach ($users as $user) {
            /* @var User $user */
            $output->writeln($user->getEmail());
            /* @var Member $member */
            $member = $this->getContainer()->get('doctrine')
                ->getRepository('FrontofficeBundle:Member')->findOneByMail($user->getEmail());
            if($member != null){
                $user->setPhone($member->getPhone());
                $user->setPhoneVisible($member->getPhoneVisible());
                $user->setMailVisible($member->getMailVisible());
                $user->setAdress1($member->getAdress1());
                $user->setAdress2($member->getAdress2());
                $user->setZipCode($member->getZipCode());
                $user->setCity($member->getCity());
                $user->setAdressVisible($member->getAdressVisible());
                $user->setBirthdate($member->getBirthdate());
                $user->setCivil($member->getCivil());
                $user->setFirstName($member->getFirstName());
                $user->setLastName($member->getLastName());
                $user->setEnabled($member->getEnabled());

                $manager = $this->getContainer()->get('doctrine')->getManager();
                $manager->persist($user);
                $manager->flush();
            }
        }
    }
}