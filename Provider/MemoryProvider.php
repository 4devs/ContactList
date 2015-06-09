<?php

namespace FDevs\ContactList\Provider;

use FDevs\ContactList\ContactInterface;
use FDevs\ContactList\Exception\NotFoundException;

class MemoryProvider implements ContactProviderInterface
{
    /** @var array|ContactInterface */
    private $contactList = [];

    /**
     * init
     *
     * @param array $contactList
     */
    public function __construct(array $contactList = [])
    {
        foreach ($contactList as $contact) {
            $this->addContact($contact);
        }
    }

    /**
     * add contact
     *
     * @param ContactInterface $contact
     *
     * @return $this
     */
    public function addContact(ContactInterface $contact)
    {
        $this->contactList[$contact->getSlug()] = $contact;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function get($slug)
    {
        if (!isset($this->contactList[$slug])) {
            throw new NotFoundException(sprintf('The contact "%s" is not defined.', $slug));
        }

        return $this->contactList[$slug];
    }

    /**
     * {@inheritDoc}
     */
    public function has($slug)
    {
        return isset($this->contactList[$slug]);
    }
}
