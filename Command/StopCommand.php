<?php

namespace MadrakIO\PersistentCommandBundle\Command;

class StopCommand extends AbstractCommand
{
    const COMMANDS_STOPPED_MSG = 'The process %s running on Node %s has been issued a stop command and should stop shortly.';
    const FINISHED_MSG = 'All processes running on %s have had their status set to `stop` and should stop shortly.';

    protected function configure()
    {
        parent::configure();

        $this
            ->setName('madrakio:persistentcommand:stop')
            ->setDescription("Updates all running processes on this node to the stop status.");
    }

    protected function runProcess()
    {
        $consoleProcesses = $this->getConsoleNodeProcessRepository()->findBy(['consoleNode' => $this->consoleNode]);

        foreach ($consoleProcesses as $consoleProcess) {
            $consoleProcess->setStatus('stop');
            $this->entityManager->persist($consoleProcess);
            $this->entityManager->flush($consoleProcess);

            $this->writeLog(self::COMMANDS_STOPPED_MSG, [$consoleProcess->getName(), $this->consoleNode->getHostname()]);
        }

        $this->writeLog(self::FINISHED_MSG, [$this->consoleNode->getHostname()]);
    }
}
