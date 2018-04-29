<?php

namespace Flatmate\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCacheCommand extends Command
{
    protected function configure()
    {
        $this->setName('cache:clear')
             ->setDescription('Clears the cache')
             ->setHelp('This command clears the application cache');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = CONSOLE_ROOT.DIRECTORY_SEPARATOR.'cache';
        $this->deleteTree($dir);
        $output->writeln('Cache cleared');
    } 

    private function deleteTree($dir)
    {
        $files = array_diff(scandir($dir), array('.','..')); 
        foreach ($files as $file) { 
            (is_dir("$dir/$file")) ? $this->deleteTree("$dir/$file") : unlink("$dir/$file"); 
        } 
        return rmdir($dir); 
    }
}
