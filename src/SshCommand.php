<?php

namespace nbcutechnology\Pubstack;

use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SshCommand extends Command {

  /**
   * Configure the command.
   */
  protected function configure() {
    $this->setName('ssh')->setDescription('Login to the Pubstack vm via SSH');
  }

  /**
   * Execute the command.
   *
   * @param InputInterface $input
   * @param OutputInterface $output
   */
  public function execute(InputInterface $input, OutputInterface $output) {
    chdir($_ENV['PUBSTACK_PATH']);
    passthru('VAGRANT_DOTFILE_PATH=' . $_ENV['VAGRANT_DOTFILE_PATH'] . ' vagrant ssh');
  }
}
