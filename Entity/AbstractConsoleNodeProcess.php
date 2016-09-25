<?php

namespace MadrakIO\PersistentCommandBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * ConsoleNodeProcess.
 */
abstract class AbstractConsoleNodeProcess implements ConsoleNodeProcessInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
   protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    protected $name;

    /**
     * @var int
     *
     * @ORM\Column(name="pid", type="integer")
     */
    protected $pid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_started", type="datetime")
     */
    protected $dateStarted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_pinged", type="datetime", nullable=true)
     */
    protected $datePinged = null;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50, options={"default": "running"})
     */
    protected $status = 'running';

    /**
     * @var ConsoleNode
     *
     * @ORM\ManyToOne(targetEntity="MadrakIO\PersistentCommandBundle\Entity\ConsoleNodeInterface", inversedBy="processes")
     * @ORM\JoinColumn(name="console_node_id", referencedColumnName="id", nullable=false)
     */
    protected $consoleNode;

    public function __construct()
    {
        $this->dateStarted = new DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * {@inheritdoc}
     */
    public function setDateStarted(DateTime $dateStarted)
    {
        $this->dateStarted = $dateStarted;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateStarted()
    {
        return $this->dateStarted;
    }

    /**
     * {@inheritdoc}
     */
    public function setDatePinged(DateTime $datePinged = null)
    {
        $this->datePinged = $datePinged;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatePinged()
    {
        return $this->datePinged;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function setConsoleNode(ConsoleNodeInterface $consoleNode)
    {
        $this->consoleNode = $consoleNode;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getConsoleNode()
    {
        return $this->consoleNode;
    }

    /**
     * {@inheritdoc}
     */
    public function isRunning()
    {
        return $this->status == 'running';
    }
}
