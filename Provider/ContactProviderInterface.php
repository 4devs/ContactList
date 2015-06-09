<?php

namespace FDevs\ContactList\Provider;

use FDevs\ContactList\Exception\NotFoundException;
use FDevs\ContactList\ContactInterface;

interface ContactProviderInterface
{
    /**
     * get contact
     *
     * @param string $slug
     *
     * @return ContactInterface
     * @throws NotFoundException if the contact does not exists
     */
    public function get($slug);

    /**
     * has contact
     *
     * @param string $slug
     *
     * @return bool
     */
    public function has($slug);
}