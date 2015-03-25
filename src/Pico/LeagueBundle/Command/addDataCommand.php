<?php
namespace Pico\LeagueBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Pico\UserBundle\Entity\User;
use Pico\LeagueBundle\Form\EquipeType;
use Pico\LeagueBundle\Entity\Equipe;
use Pico\LeagueBundle\Entity\Sport;
use Pico\LeagueBundle\Entity\League;
use Pico\LeagueBundle\Entity\Club;
use Pico\LeagueBundle\Entity\UserToEquipe;

class addDataCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('test:addData')->setDescription('Ajouter des valeurs de test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("#############################\n## Action d'ajout de datas ##\n#############################");
        $entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();
        $output->writeln('Ajout d\'un utilisateur de test ... ');
        
        $userManager = $this->getContainer()->get('fos_user.user_manager');
        
        // Ajout du user de test
        if (! $userTest = $userManager->findUserByUsername('picoplan')) {
            $userTest = $userManager->createUser();
        }
        $factory = $this->getContainer()->get('security.encoder_factory');
        $encoder = $factory->getEncoder($userTest);
        $password = $encoder->encodePassword('test', $userTest->getSalt());
        $userTest->setPassword($password);
        $userTest->setUsername('picoplan');
        $userTest->setEmail('usertest@picoplan.fr');
        $userTest->setFirstName('Pico');
        $userTest->setLastName('Plan');
        $userTest->setPhone('01 23 45 67 89');
        $userTest->setLocked(false);
        $userTest->setEnabled(true);
        $userTest->addRole('ROLE_USER');
        $userManager->updateUser($userTest);
        $output->writeln('Done');
        $output->writeln('Ajout des sports ... ');
        // Ajout de sports
        if(!$Sport = $entityManager->getRepository('PicoLeagueBundle:Sport')->findOneBy(array('nom'=>'Rugby'))){
            $Sport = new Sport();
        }
        $Sport->setNom('Rugby');
        $Sport->setDescription('Un sport de gentlemen joué par des hooligans');
        $entityManager->persist($Sport);
        
        if(!$Sport2 = $entityManager->getRepository('PicoLeagueBundle:Sport')->findOneBy(array('nom'=>'Foot'))){
            $Sport2 = new Sport();
        }
        $Sport2->setNom('Foot');
        $Sport2->setDescription('Onze a courrir deriere un seul balon');
        $entityManager->persist($Sport2);
        
        // Ajout de leagues
        $output->writeln('Done');
        $output->writeln('Ajout des Leagues ... ');
        if(!$League = $entityManager->getRepository('PicoLeagueBundle:League')->findOneBy(array('nom'=>'Rugby'))){
            $League = new League();
        }
        $League->setNom('Rugby');
        $League->setDescription('La ligue des rugbyman');
        $League->setSport($Sport);
        $League->setUserCreator($userTest);
        $entityManager->persist($League);
        
        // Aout de club
        $output->writeln('Done');
        $output->writeln('Ajout des clubs ... ');
        if(!$Club = $entityManager->getRepository('PicoLeagueBundle:Club')->findOneBy(array('nom'=>'Le club de Ynov'))){
            $Club = new Club();
        }
        $Club->setUserCreator($userTest);
        $Club->setNom('Le club de Ynov');
        $Club->setAdresse('42 rue de Ynov - 75020 - Paris');
        $Club->setDescription('Club de geek !');
        $entityManager->persist($Club);
        
        // Ajout d'equipes
        $output->writeln('Done');
        $output->writeln('Ajout d\'equipes ... ');
        if(!$Equipe = $entityManager->getRepository('PicoLeagueBundle:Equipe')->findOneBy(array('nom'=>'Les vrais rugbyman !'))){
            $Equipe = new Equipe();
        }
        $Equipe->setSport($Sport);
        $Equipe->setClub($Club);
        $Equipe->setNom('Les vrais rugbyman !');
        $Equipe->setDescription('Pour les casse cou');
        $Equipe->setListeModo(array(
            $userTest
        ));
        $entityManager->persist($Equipe);
        if(!$Equipe = $entityManager->getRepository('PicoLeagueBundle:Equipe')->findOneBy(array('nom'=>'Les vrais Footeux !'))){
            $Equipe = new Equipe();
        }
        $Equipe->setSport($Sport2);
        $Equipe->setClub($Club);
        $Equipe->setNom('Les vrais Footeux !');
        $Equipe->setDescription('Expert en gardiennage');
        $Equipe->setListeModo(array(
            $userTest
        ));
        $entityManager->persist($Equipe);
        $output->writeln('Done');
        $output->writeln('Application des modifications ...');
        // On balance en base
        $entityManager->flush();
        $output->writeln('Done');
    }
}