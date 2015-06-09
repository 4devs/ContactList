<?php

namespace FDevs\ContactList;

interface ConnectInterface
{
    /**
     * set type
     *
     * @param string $type
     *
     * @return self
     */
    public function setType($type);

    /**
     * get type
     *
     * @return string
     */
    public function getType();

    /**
     * set text
     *
     * @param string $text
     *
     * @return self
     */
    public function setText($text);

    /**
     * set link
     *
     * @param string $link
     *
     * @return self
     */
    public function setLink($link);
}
