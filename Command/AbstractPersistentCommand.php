<?php

namespace MadrakIO\PersistentCommandBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MadrakIO\PersistentCommandBundle\Entity\ConsoleNodeInterface;
use MadrakIO\PersistentCommandBundle\Entity\ConsoleNodeProcessInterface;

abstract class AbstractPersistentCommand extends ContainerAwareCommand
{
    const MSG_CONSOLE_NODE_NOT_FOUND = 'The ConsoleNode %s was not found.';
    const MSG_CONSOLE_NODE_NOT_ONLINE = 'The ConsoleNode %s is %s instead of online.';
    const MSG_PROCESS_ALREADY_RUNNING_ON_NODE = 'The Process %s is already running on %s.';
    const MSG_FAILED_REQUIREMENT = 'At least one requirement was not met. The command (%s) can not run.';

    protected static $consoleNodeEntity;
    protected static $consoleNodeProcessEntity;
    protected $output;
    protected $input;
    protected $entityManager;
    protected $consoleNode;
    protected $consoleNodeProcess;

    abstract protected function runProcess();

    protected function checkRequirements()
    {
        return true;
    }

    protected function setup(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->entityManager = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        self::$consoleNodeEntity = $this->getContainer()->getParameter('madrak_io_persistent_command.console_node_class');
        self::$consoleNodeProcessEntity = $this->getContainer()->getParameter('madrak_io_persistent_command.console_node_process_class');

        $this->loadConsoleNode();

        if ($this->checkRequirements() === false) {
            $this->writeLog(self::MSG_FAILED_REQUIREMENT, [$this->getName()]);

            exit;
        }
    }

    protected function finish()
    {
        $this->entityManager->remove($this->consoleNodeProcess);
        $this->entityManager->flush($this->consoleNodeProcess);
    }

    protected function loadConsoleNode()
    {
        $this->consoleNode = $this->getConsoleNodeRepository()->findOneBy(['hostname' => gethostname()]);

        if (($this->consoleNode instanceof ConsoleNodeInterface) === false) {
            $this->output->writeln(vsprintf(self::MSG_CONSOLE_NODE_NOT_FOUND, [gethostname()]));

            exit;
        }

        if ($this->consoleNode->isOnline() === false) {
            $this->output->writeln(vsprintf(self::MSG_CONSOLE_NODE_NOT_ONLINE, [$this->consoleNode->getHostname(), $this->consoleNode->getStatus()]));

            exit;
        }
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setup($input, $output);
        $this->createConsoleNodeProcess();
        $this->runProcess();
        $this->finish();
    }

    protected function writeLog($message, array $arguments = [])
    {
        $this->output->writeln('['.date('m-d-Y h:i:s').'] '.vsprintf($message, $arguments));
    }

    protected function getConsoleNodeRepository()
    {
        return $this->entityManager->getRepository(self::$consoleNodeEntity);
    }

    protected function getConsoleNodeProcessRepository()
    {
        return $this->entityManager->getRepository(self::$consoleNodeProcessEntity);
    }
}
