<?php

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AuthorWeeklyReportSendCommand extends Command
{  
    private $userRepository;
    public function __construct(UserRepository $userRepository){
       
        parent::__construct(null);

        $this->userRepository =  $userRepository;

    }
    protected static $defaultName = 'app:author-weekly-report:send';

    protected function configure()
    {
        $this
            ->setDescription('Envoyer des rapports hebdomadaires aux auteurs')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $authors = $this->userRepository
        ->findAllSubscribedToNewsletter();
        $io->progressStart(count($authors));
        foreach($authors as $author){
            $io->progressFinish();
        }
        
        $io->progressFinish();

        $io->success('Des rapports hebdomadaires ont été envoyés aux auteurs!.');

        return 0;
    }
}
