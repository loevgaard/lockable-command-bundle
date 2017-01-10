<?php
namespace Loevgaard\LockableCommandBundle\EventListener;

use Loevgaard\LockableCommandBundle\Command\LockableCommandInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\LockHandler;

class LockableCommandEventListener
{
    public function onConsoleCommand(ConsoleCommandEvent $event) {
        $locker = $this->getLocker($event);
        if($locker) {
            if(!$locker->lock()) {
                $event->getOutput()->writeln('Command locked', Output::VERBOSITY_VERBOSE);
                $event->disableCommand();
                return;
            }
        }
    }

    public function onConsoleTerminate(ConsoleTerminateEvent $event) {
        $locker = $this->getLocker($event);
        if($locker) {
            $locker->release();
        }
    }

    /**
     * @param ConsoleEvent $event
     * @return LockHandler|null
     */
    private function getLocker(ConsoleEvent $event) {
        $command        = $event->getCommand();
        $lockHandler    = null;

        if($command instanceof LockableCommandInterface) {
            $lockHandler = new LockHandler($command->getName());
        }
        return $lockHandler;
    }
}