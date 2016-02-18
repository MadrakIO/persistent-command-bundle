<?php

namespace MadrakIO\PersistentCommandBundle\Entity;

interface ConsoleNodeInterface
{
    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set hostname.
     *
     * @param string $hostname
     *
     * @return ConsoleNode
     */
    public function setHostname($hostname);

    /**
     * Get hostname.
     *
     * @return string
     */
    public function getHostname();

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return ConsoleNode
     */
    public function setType($type);

    /**
     * Get type.
     *
     * @return string
     */
    public function getType();
    /**
     * Set status.
     *
     * @param string $status
     *
     * @return ConsoleNode
     */
    public function setStatus($status);

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Check if a node is online.
     *
     * @return bool
     */
    public function isOnline();
}
