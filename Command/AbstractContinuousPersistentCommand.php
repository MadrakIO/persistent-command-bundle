<?php

namespace MadrakIO\PersistentCommandBundle\Command;

use DateTime;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use MadrakIO\PersistentCommandBundle\Entity\ConsoleNodeProcessInterface;

abstract class AbstractContinuousPersistentCommand extends AbstractPersistentCommand
{
    const MSG_CONSOLE_PROCESS_DISAPPEARED = 'The ConsoleProcess for %s on %s has disappeared. The command will stop.';
    const MSG_COMMAND_NOT_RUNNING = 'The %s command is not running on %s.';
    const MSG_COMMAND_MAY_HAVE_CRASHED = 'The %s command on %s may have crashed as the PID does not appear to refer to an active process.';
    const MSG_COMMAND_STATUS_RUNNING = 'The ConsoleProcess for %s on %s is currently in the following status: %s.';
    const MSG_COMMAND_STOP_ISSUED = 'The %s command has been issued a stop request.';
    const MSG_COMMAND_KILLED = 'The %s command on %s has been killed.';
    const MSG_COMMAND_CANNOT_BE_KILLED = 'The %s command on %s could not be killed.';
    const MSG_COMMAND_CLEANED = 'The %s command on %s has been cleaned. A new process can now be launched.';
    const MSG_INSTRUCTION_OPTIONS = 'Available instructions are: start, status, stop, kill, clean.';

    protected function configure()
    {
        $this
            ->addArgument(
                'instruction',
                InputArgument::REQUIRED,
                self::MSG_INSTRUCTION_OPTIONS);
    }

    protected function refreshConsoleNodeProcess()
    {
        $this->consoleNodeProcess = $this->getConsoleNodeProcessRepository()->findOneBy(['id' => $this->consoleNodeProcess->getId()]);

        if (($this->consoleNodeProcess instanceof ConsoleNodeProcessInterface) === false) {
            $this->writeLog(self::MSG_CONSOLE_PROCESS_DISAPPEARED, [$this->getName(), $this->consoleNode->getHostName()]);

            exit;
        }

        $this->entityManager->refresh($this->consoleNodeProcess);

        $this->consoleNodeProcess->setDatePinged(new DateTime());
        $this->entityManager->persist($this->consoleNodeProcess);
        $this->entityManager->flush($this->consoleNodeProcess);
    }

    protected function getRelatedConsoleNodeProcess()
    {
        $consoleNodeProcess = $this->getConsoleNodeProcessRepository()->findOneBy(['name' => $this->getName(), 'consoleNode' => $this->consoleNode]);

        if (($consoleNodeProcess instanceof ConsoleNodeProcessInterface) === false) {
            $this->writeLog(self::MSG_COMMAND_NOT_RUNNING, [$this->getName(), $this->consoleNode->getHostName()]);

            exit;
        }

        if (posix_getpgid($consoleNodeProcess->getPid()) === false) {
            $this->writeLog(self::MSG_COMMAND_MAY_HAVE_CRASHED, [$this->getName(), $this->consoleNode->getHostName()]);
        }

        return $consoleNodeProcess;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setup($input, $output);

        switch ($input->getArgument('instruction')) {
            case 'start':
                $this->createConsoleNodeProcess();

                do {
                    $this->runProcess();
                    $this->refreshConsoleNodeProcess();
                } while ($this->consoleNodeProcess->isRunning());

                $this->finish();

                break;
            case 'status':
                $consoleNodeProcess = $this->getRelatedConsoleNodeProcess();
                $this->writeLog(self::MSG_COMMAND_STATUS_RUNNING, [$this->getName(), $this->consoleNode->getHostname(), $consoleNodeProcess->getStatus()]);

                break;
            case 'stop':
                $consoleNodeProcess = $this->getRelatedConsoleNodeProcess();
                $consoleNodeProcess->setStatus('stopping');
                $this->entityManager->persist($consoleNodeProcess);
                $this->entityManager->flush($consoleNodeProcess);

                $this->writeLog(self::MSG_COMMAND_STOP_ISSUED, [$this->getName(), $this->consoleNode->getHostname()]);

                break;
            case 'kill':
                $consoleNodeProcess = $this->getRelatedConsoleNodeProcess();
                if (posix_kill($consoleNodeProcess->getPid(), SIGKILL)) {
                    $this->writeLog(self::MSG_COMMAND_KILLED, [$this->getName(), $this->consoleNode->getHostname()]);
                    $this->entityManager->remove($consoleNodeProcess);
                    $this->entityManager->flush($consoleNodeProcess);
                } else {
                    $this->writeLog(self::MSG_COMMAND_CANNOT_BE_KILLED, [$this->getName(), $this->consoleNode->getHostname()]);
                }

                break;
            case 'clean':
                $consoleNodeProcess = $this->getRelatedConsoleNodeProcess();
                $this->entityManager->remove($consoleNodeProcess);
                $this->entityManager->flush($consoleNodeProcess);

                $this->writeLog(self::MSG_COMMAND_CLEANED, [$this->getName(), $this->consoleNode->getHostname()]);

                break;
            default:
                $this->writeLog(self::MSG_INSTRUCTION_OPTIONS);

                break;
        }
    }
}
