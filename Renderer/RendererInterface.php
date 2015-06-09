<?php

namespace FDevs\ContactList\Renderer;

use FDevs\ContactList\ConnectInterface;
use FDevs\ContactList\ContactInterface;
use FDevs\ContactList\AddressInterface;
use Doctrine\Common\Collections\Collection;

interface RendererInterface
{
    /**
     * Renders one contact.
     *
     * @param ContactInterface $contact
     * @param array            $options
     *
     * @return string
     */
    public function renderContact(ContactInterface $contact, array $options = []);

    /**
     * Renders address list.
     *
     * @param array|Collection|AddressInterface[] $addressList
     * @param array                               $options
     *
     * @return string
     */
    public function renderAddress($addressList, array $options = []);

    /**
     * render Connect
     *
     * @param ConnectInterface $connect
     * @param array            $options
     *
     * @return string
     */
    public function renderConnect(ConnectInterface $connect, array $options = []);

    /**
     * Renders contact list.
     *
     * @param array|Collection|ContactInterface[] $contactList
     * @param array                               $options
     *
     * @return string
     */
    public function renderList($contactList, array $options = []);
}