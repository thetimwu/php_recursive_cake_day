<?php namespace Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Console\Command;
/**
 * Author: Chidume Nnamdi <kurtwanger40@gmail.com>
 */
class MyCommand1 extends Command
{
    
    public function configure()
    {
        $this -> setName('getCakeDate')
            -> setDescription('Calcuate Cake day.')
            -> setHelp('This command allows you to create a list of cake dates...');
            //-> addArgument('username', InputArgument::REQUIRED, 'The username of the user.');
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this -> generateCakeDay($input, $output);
    }
}