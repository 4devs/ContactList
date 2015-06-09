<?php

namespace FDevs\ContactList;

interface ContactInterface
{
    /**
     * set slug
     *
     * @param string $slug
     *
     * @return self
     */
    public function setSlug($slug);

    /**
     * get slug
     *
     * @return string
     */
    public function getSlug();

    /**
     * is show
     *
     * @return bool
     */
    public function isShow();

    /**
     * add connect
     *
     * @param ConnectInterface $connect
     *
     * @return self
     */
    public function addConnect(ConnectInterface $connect);

    /**
     * add address
     *
     * @param AddressInterface $address
     *
     * @return self
     */
    public function addAddress(AddressInterface $address);
}
