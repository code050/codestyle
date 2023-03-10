<?php

declare(strict_types=1);

namespace Code050\Codestyle\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InitializeCodestyleCommand extends Command
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input->getOption('arbitrary-flag')) {
            $output->writeln('The flag was used');
        }

        return 0;
    }

    protected function configure(): void
    {
        $this->setDefinition(
            [
                new InputOption('arbitrary-flag', null, InputOption::VALUE_NONE, 'Example flag'),
                new InputArgument('foo', InputArgument::OPTIONAL, 'Optional arg'),
            ],
        );
    }
}
