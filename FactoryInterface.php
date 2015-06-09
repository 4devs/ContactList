<?php

namespace FDevs\ContactList;


interface FactoryInterface
{
    /**
     * create contact
     *
     * @param string $slug
     *
     * @return ContactInterface
     */
    public function createContact($slug);

    /**
     * create connect
     *
     * @param string $type
     * @param string $text
     * @param string $link
     *
     * @return ConnectInterface
     */
    public function createConnect($type, $text, $link);

    /**
     * add connect
     *
     * @param ContactInterface $contact
     * @param string           $type
     * @param string           $text
     * @param string           $link
     *
     * @return self
     */
    public function addConnect(ContactInterface $contact, $type, $text, $link);

    /**
     * create address
     *
     * @param string $country  country. For example, Russia. You can also provide the two-letter ISO 3166-1 alpha-2 country code.
     * @param string $locality locality. For example, Moscow.
     * @param string $region   region. For example, Moscow region.
     * @param string $box      post office box number for PO box addresses.
     * @param string $code     postal code. For example, 103132.
     * @param string $street   street address. For example, st. Ilinka 23
     * @param string $locale
     *
     * @return AddressInterface
     */
    public function createAddress($country, $locality, $region, $box, $code, $street, $locale = 'en');

    /**
     * add address
     *
     * @param ContactInterface $contact
     * @param string           $country  country. For example, Russia. You can also provide the two-letter ISO 3166-1 alpha-2 country code.
     * @param string           $locality locality. For example, Moscow.
     * @param string           $region   region. For example, Moscow region.
     * @param string           $box      post office box number for PO box addresses.
     * @param string           $code     postal code. For example, 103132.
     * @param string           $street   street address. For example, st. Ilinka 23
     * @param string           $locale
     *
     * @return self
     */
    public function addAddress(ContactInterface $contact, $country, $locality, $region, $box, $code, $street, $locale = 'en');
}
