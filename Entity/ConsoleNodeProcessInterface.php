<?php

namespace MadrakIO\PersistentCommandBundle\Entity;

use DateTime;

interface ConsoleNodeProcessInterface
{
    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return ConsoleNodeProcess
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set pid.
     *
     * @param int $pid
     *
     * @return ConsoleNodeProcess
     */
    public function setPid($pid);

    /**
     * Get pid.
     *
     * @return int
     */
    public function getPid();

    /**
     * Set dateStarted.
     *
     * @param \DateTime $dateStarted
     *
     * @return ConsoleNodeProcess
     */
    public function setDateStarted(DateTime $dateStarted);

    /**
     * Get dateStarted.
     *
     * @return \DateTime
     */
    public function getDateStarted();

    /**
     * Set datePinged.
     *
     * @param \DateTime $datePinged
     *
     * @return ConsoleNodeProcess
     */
    public function setDatePinged(DateTime $datePinged = null);

    /**
     * Get datePinged.
     *
     * @return \DateTime
     */
    public function getDatePinged();

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return ConsoleNodeProcess
     */
    public function setStatus($status);

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set consoleNode.
     *
     * @param ConsoleNode $consoleNode
     *
     * @return ConsoleNodeProcess
     */
    public function setConsoleNode(ConsoleNode $consoleNode);

    /**
     * Get consoleNode.
     *
     * @return ConsoleNode
     */
    public function getConsoleNode();

    /**
     * Check if a process is running.
     *
     * @return bool
     */
    public function isRunning();
}
