<?php

namespace FDevs\ContactList\Model;

use FDevs\ContactList\ConnectInterface;

class Connect implements ConnectInterface
{
    /** @var string */
    protected $type;

    /** @var string */
    protected $text;

    /** @var string */
    protected $link;

    /**
     * get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * set type
     *
     * @param string $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * get text
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * set text
     *
     * @param string $text
     *
     * @return self
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * get link
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * set link
     *
     * @param string $link
     *
     * @return self
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }
}
