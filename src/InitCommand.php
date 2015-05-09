<?php

namespace nbcutechnology\Pubstack;

use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class InitCommand extends Command {
  /**
   * Configure the command options.
   *
   * @return void
   */
  protected function configure()
  {
    $this->setName('init')
      ->setDescription('Download pubstack.')
      ->addOption('clean', null, InputOption::VALUE_NONE, 'If set, the command will remove your Pubstack directory and start over.');
  }

  /**
   * Execute the command.
   *
   * @param  \Symfony\Component\Console\Input\InputInterface  $input
   * @param  \Symfony\Component\Console\Output\OutputInterface  $output
   * @return void
   */
  public function execute(InputInterface $input, OutputInterface $output) {
    // Useful for working on pubstack-shell.
    if ($input->getOption('clean')) {
      // Since it'd be easy for some shell script to change the PUBSTACK_PATH
      // variable, confirm this every time.
      $helper = $this->getHelper('question');
      $question = new ConfirmationQuestion('Are you sure you want to delete ' . $_ENV['PUBSTACK_PATH'] . '? This operation cannot be undone.', false);
      if (!$helper->ask($input, $output, $question)) {
        return;
      }

      // Remove the existing pubstack directory.
      $process = new Process('rm -rf ' . $_ENV['PUBSTACK_PATH']);
      $process->run();

      if (!$process->isSuccessful()) {
        throw new \RuntimeException($process->getErrorOutput());
      }
    }

    // Only complain if --clean isn't specified.
    if (is_dir($_ENV['PUBSTACK_PATH']) && !$input->getOption('clean')) {
      throw new \RuntimeException("Pubstack has already been initialized.");
    }

    $output->writeln('<comment>Cloning pubstack...</comment>');
    $process = new Process('git clone ' . $_ENV['PUBSTACK_REPO'] . ' ' . $_ENV['PUBSTACK_PATH']);
    $process->run();

    if (!$process->isSuccessful()) {
      throw new \RuntimeException($process->getErrorOutput());
    }

    $output->writeln('<info>Done!</info>');
    $output->writeln('<comment>Now run "pubstack configure"</comment>');
  }
}
