<?php

namespace nbcutechnology\Pubstack;

use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProvisionCommand extends Command {

  /**
   * Configure the command.
   */
  protected function configure() {
    $this->setName('provision')->setDescription('Run the provisioning scripts for the Pubstack VM.');
  }

  /**
   * Execute the command.
   *
   * @param InputInterface $input
   * @param OutputInterface $output
   */
  public function execute(InputInterface $input, OutputInterface $output) {
    $process = new Process('vagrant provision', $_ENV['PUBSTACK_PATH'], array_merge($_SERVER, $_ENV), null, null);
    $process->run(function($type, $line) use ($output) {
      $output->write($line);
    });
  }
}
