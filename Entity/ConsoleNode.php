<?php

namespace MadrakIO\PersistentCommandBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ConsoleNode.
 */
abstract class ConsoleNode implements ConsoleNodeInterface
{
    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MadrakIO\PersistentCommandBundle\Entity\ConsoleNodeProcessInterface", mappedBy="consoleNode", cascade={"remove"})
     */
    protected $processes;

    /**
     * @var string
     *
     * @ORM\Column(name="hostname", type="string", length=150)
     */
    protected $hostname;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, options={"default": "standard"})
     */
    protected $type = 'standard';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50, options={"default": "online"})
     */
    protected $status = 'online';

    public function __construct()
    {
        $this->processes = new ArrayCollection();
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
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
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
    public function isOnline()
    {
        return $this->status == 'online';
    }
}
