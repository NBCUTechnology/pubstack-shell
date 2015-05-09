<?php

namespace nbcutechnology\Pubstack;

use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class DestroyCommand extends Command {
  /**
   * Configure the command.
   */
  protected function configure() {
    $this->setName('destroy')->setDescription('Destroy the Pubstack VM.');
  }

  /**
   * Execute the command.
   *
   * @param InputInterface $input
   * @param OutputInterface $output
   */
  public function execute(InputInterface $input, OutputInterface $output) {
    // Since the vagrant destroy operation is not reversible,
    // get confirmation.
    $helper = $this->getHelper('question');
    $question = new ConfirmationQuestion('Are you sure you want to destroy your VM? This operation cannot be undone.', false);
    if (!$helper->ask($input, $output, $question)) {
      return;
    }

    $process = new Process('vagrant destroy', $_ENV['PUBSTACK_PATH'], array_merge($_SERVER, $_ENV), null, null);
    $process->run(function($type, $line) use ($output) {
      $output->write($line);
    });
  }
}
