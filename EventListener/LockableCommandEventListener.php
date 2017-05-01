<?php
namespace Loevgaard\LockableCommandBundle\EventListener;

use Loevgaard\LockableCommandBundle\Command\LockableCommandInterface;
use Loevgaard\Locker\FileLocker;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LockableCommandEventListener
{
    /** @var ContainerInterface */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onConsoleCommand(ConsoleCommandEvent $event) {
        $locker = $this->getLocker($event);
        if($locker && !$locker->lock()) {
            $event->getOutput()->writeln('Command locked, disabling command...', Output::VERBOSITY_VERBOSE);
            $event->disableCommand();
        }
    }

    public function onConsoleTerminate(ConsoleTerminateEvent $event) {
        $locker = $this->getLocker($event);
        $locker && $locker->release();
    }

    /**
     * @param ConsoleEvent $event
     * @return FileLocker|null
     */
    private function getLocker(ConsoleEvent $event) {
        $command    = $event->getCommand();
        $locker     = null;

        if($command instanceof LockableCommandInterface) {
            $locker = new FileLocker($command->getName(), $this->container->getParameter('loevgaard_lockable_command.lock_dir'));
        }
        return $locker;
    }
}