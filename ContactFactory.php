<?php

namespace FDevs\ContactList;

use FDevs\ContactList\Exception\UnsupportedClassException;
use FDevs\Locale\LocaleInterface;

class ContactFactory implements FactoryInterface
{
    /** @var string */
    private $contactClass = 'FDevs\ContactList\Model\Contact';

    /** @var string */
    private $connectClass = 'FDevs\ContactList\Model\Connect';

    /** @var string */
    private $addressClass = 'FDevs\ContactList\Model\Address';

    /** @var array */
    private $interface = [
        'connect' => 'FDevs\ContactList\ConnectInterface',
        'contact' => 'FDevs\ContactList\ContactInterface',
        'address' => 'FDevs\ContactList\AddressInterface',
    ];

    /**
     * {@inheritDoc}
     */
    public function createContact($slug)
    {
        /** @var \FDevs\ContactList\ContactInterface $contact */
        $contact = new $this->contactClass();
        $contact->setSlug($slug);

        return $contact;
    }

    /**
     * {@inheritDoc}
     */
    public function createConnect($type, $text, $link)
    {
        /** @var \FDevs\ContactList\ConnectInterface $connect */
        $connect = new $this->connectClass();
        $connect->setType($type);
        $connect->setText($text);
        $connect->setLink($link);

        return $connect;
    }

    /**
     * {@inheritDoc}
     */
    public function createAddress($country, $locality, $region, $box, $code, $street, $locale = 'en')
    {
        /** @var \FDevs\ContactList\AddressInterface $address */
        $address = new $this->addressClass();
        $address->setCountry($country);
        $address->setLocality($locality);
        $address->setRegion($region);
        $address->setBox($box);
        $address->setCode($code);
        $address->setStreet($street);

        if ($address instanceof LocaleInterface) {
            $address->setLocale($locale);
        }

        return $address;
    }

    /**
     * {@inheritDoc}
     */
    public function addAddress(ContactInterface $contact, $country, $locality, $region, $box, $code, $street, $locale = 'en')
    {
        $address = $this->createAddress($country, $locality, $region, $box, $code, $street, $locale);
        $contact->addAddress($address);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addConnect(ContactInterface $contact, $type, $text, $link)
    {
        $connect = $this->createConnect($type, $text, $link);
        $contact->addConnect($connect);

        return $this;
    }

    /**
     * set contact class
     *
     * @param string $contactClass
     *
     * @return $this
     */
    public function setContactClass($contactClass)
    {
        if (!$this->isSupportClass($contactClass, 'contact')) {
            throw $this->unsupportedException($contactClass, 'contact');
        }
        $this->contactClass = $contactClass;

        return $this;
    }

    /**
     * set connect class
     *
     * @param string $connectClass
     *
     * @return $this
     */
    public function setConnectClass($connectClass)
    {
        if (!$this->isSupportClass($connectClass, 'connect')) {
            throw $this->unsupportedException($connectClass, 'connect');
        }
        $this->connectClass = $connectClass;

        return $this;
    }

    /**
     * set address class
     *
     * @param string $addressClass
     *
     * @return $this
     */
    public function setAddressClass($addressClass)
    {
        if (!$this->isSupportClass($addressClass, 'address')) {
            throw $this->unsupportedException($addressClass, 'address');
        }
        $this->addressClass = $addressClass;

        return $this;
    }

    /**
     * unsupported Exception
     *
     * @param string $class
     * @param string $type
     *
     * @return UnsupportedClassException
     */
    private function unsupportedException($class, $type)
    {
        return new UnsupportedClassException(sprintf('class "%s" must implements "%s"', $class, $this->interface[$type]));
    }

    /**
     * in support class
     *
     * @param string $className
     * @param string $type
     *
     * @return bool
     */
    private function isSupportClass($className, $type)
    {
        return isset($this->interface[$type]) && in_array($this->interface[$type], class_implements($className));
    }
}
