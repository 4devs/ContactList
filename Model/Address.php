<?php

namespace FDevs\ContactList\Model;

use FDevs\ContactList\AddressInterface;
use FDevs\Locale\LocaleInterface;
use FDevs\Locale\LocaleTrait;

class Address implements LocaleInterface, AddressInterface
{
    use LocaleTrait;

    /** @var string */
    protected $country;

    /** @var string */
    protected $locality;

    /** @var string */
    protected $region;

    /** @var string */
    protected $box;

    /** @var string */
    protected $code;

    /** @var string */
    protected $street;

    /**
     * {@inheritDoc}
     */
    public function isEmpty()
    {
        return !trim($this->code.$this->country.$this->locality.$this->region.$this->box.$this->street);
    }

    /**
     * get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * {@inheritDoc}
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * get locality
     *
     * @return string
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * {@inheritDoc}
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * set region
     *
     * @param string $region
     *
     * @return self
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * get box
     *
     * @return string
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * {@inheritDoc}
     */
    public function setBox($box)
    {
        $this->box = $box;

        return $this;
    }

    /**
     * get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritDoc}
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * {@inheritDoc}
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }
}
