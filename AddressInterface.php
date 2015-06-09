<?php
namespace FDevs\ContactList;


interface AddressInterface
{
    /**
     * set country. For example, Russia. You can also provide the two-letter ISO 3166-1 alpha-2 country code.
     *
     * @param string $country
     *
     * @return self
     */
    public function setCountry($country);

    /**
     * set locality. For example, Moscow.
     *
     * @param string $locality
     *
     * @return self
     */
    public function setLocality($locality);

    /**
     * set region. For example, Moscow region.
     *
     * @param string $region
     *
     * @return self
     */
    public function setRegion($region);

    /**
     * set post office box number for PO box addresses.
     *
     * @param string $box
     *
     * @return self
     */
    public function setBox($box);

    /**
     * set postal code. For example, 103132.
     *
     * @param string $code
     *
     * @return self
     */
    public function setCode($code);

    /**
     * set street address. For example, st. Ilinka 23
     *
     * @param string $street
     *
     * @return self
     */
    public function setStreet($street);

    /**
     * is empty address
     *
     * @return bool
     */
    public function isEmpty();
}
