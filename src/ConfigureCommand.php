<?php

namespace nbcutechnology\Pubstack;

use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigureCommand extends Command {

  /**
   * Configure the command.
   */
  protected function configure() {
    $this->setName('configure')->setDescription('Edit the pubstack configuration file.');
  }

  /**
   * Execute the command.
   *
   * @param InputInterface $input
   * @param OutputInterface $output
   */
  public function execute(InputInterface $input, OutputInterface $output) {
    if (!file_exists($_ENV['PUBSTACK_PATH'] . '/config.yml')) {
      copy($_ENV['PUBSTACK_PATH'] . '/config.example.yml', $_ENV['PUBSTACK_PATH'] . '/config.yml');
    }

    $command = $this->getExecutable() . ' ' . $_ENV['PUBSTACK_PATH'] . '/config.yml';
    $process = new Process($command, $_ENV['PUBSTACK_PATH'], array_merge($_SERVER, $_ENV), null, null);
    $process->run(function($type, $line) use ($output) {
      $output->write($line);
    });
  }

  /**
   * Find the correct executable to run depending on the OS.
   *
   * @return string
   */
  protected function getExecutable() {
    if (strpos(strtoupper(PHP_OS), 'WIN') === 0) {
      return 'start';
    }
    elseif (strpos(strtoupper(PHP_OS), 'DARWIN') === 0) {
      return 'open';
    }
    else {
      return 'xdg-open';
    }
  }
}
