<?php

namespace A3020\CacheBuster\Console\Command;

use Concrete\Core\Support\Facade\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CacheBuster extends Command
{
    protected function configure()
    {
        $this
            ->setName('c5:cache-buster')
            ->setDescription(t('Busts the asset cache.'))
            ->setHelp(<<<EOT
Returns codes:
  0 operation completed successfully
  1 errors occurred
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = Application::getFacadeApplication();

        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = $app->make(EventDispatcherInterface::class);

        $dispatcher->dispatch('on_cache_bust');

        $output->writeln('Aight. Asset cache is busted.');
    }
}
