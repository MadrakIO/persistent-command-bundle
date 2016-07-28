<?php

namespace MadrakIO\PersistentCommandBundle\Command;

use MadrakIO\PersistentCommandBundle\Entity\ConsoleNodeProcessInterface;

abstract class AbstractPersistentCommand extends AbstractCommand
{
    const MSG_PROCESS_ALREADY_RUNNING_ON_NODE = 'The Process %s is already running on %s.';

    protected $consoleNodeProcess;

    protected function begin()
    {
        $this->createConsoleNodeProcess();

        return;
    }

    protected function finish()
    {
        $this->entityManager->remove($this->consoleNodeProcess);
        $this->entityManager->flush($this->consoleNodeProcess);
    }

    protected function createConsoleNodeProcess()
    {
        if ($this->getConsoleNodeProcessRepository()->findOneBy(['name' => $this->getName(), 'consoleNode' => $this->consoleNode]) instanceof ConsoleNodeProcessInterface) {
            $this->writeLog(self::MSG_PROCESS_ALREADY_RUNNING_ON_NODE, [$this->getName(), $this->consoleNode->getHostname()]);

            exit;
        }

        $this->consoleNodeProcess = new self::$consoleNodeProcessEntity();
        $this->consoleNodeProcess->setName($this->getName())
                                 ->setPid(getmypid())
                                 ->setConsoleNode($this->consoleNode);

        $this->entityManager->persist($this->consoleNodeProcess);
        $this->entityManager->flush($this->consoleNodeProcess);
    }
}
