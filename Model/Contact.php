<?php

namespace FDevs\ContactList\Model;

use FDevs\ContactList\AddressInterface;
use FDevs\ContactList\ConnectInterface;
use FDevs\ContactList\ContactInterface;
use FDevs\Locale\Model\LocaleText;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FDevs\Geo\Model\Point;
use FDevs\Locale\Util\CollectionLocale;

class Contact implements ContactInterface
{
    /** @var mixed */
    protected $id;

    /** @var string */
    protected $slug;

    /** @var bool */
    protected $show = false;

    /** @var Point */
    protected $location;

    /** @var array|Collection|Address[] */
    protected $address = [];

    /** @var array|Collection|LocaleText[] */
    protected $name = [];

    /** @var array|Collection|Connect[] */
    protected $connectList = [];

    /**
     * init
     */
    public function __construct()
    {
        $this->name = new ArrayCollection();
        $this->connectList = new ArrayCollection();
        $this->address = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->slug ?: 'New Contact';
    }

    /**
     * Get id
     *
     * @return mixed $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set address
     *
     * @param Collection|array|Address[] $address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addAddress(AddressInterface $address)
    {
        CollectionLocale::addLocaleToCollection($this->address, $address);

        return $this;
    }

    /**
     * Get address
     *
     * @return Collection|array|Address[]
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set location
     *
     * @param Point $location
     *
     * @return self
     */
    public function setLocation(Point $location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return Point
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add name
     *
     * @param LocaleText $name
     *
     * @return $this
     */
    public function addName(LocaleText $name)
    {
        CollectionLocale::addLocaleToCollection($this->name, $name);

        return $this;
    }

    /**
     * Remove name
     *
     * @param LocaleText $name
     *
     * @return $this
     */
    public function removeName(LocaleText $name)
    {
        $this->name->removeElement($name);

        return $this;
    }

    /**
     * Get name
     *
     * @return array|Collection|LocaleText[]
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add connectList
     *
     * @param Connect $connectList
     *
     * @return $this
     */
    public function addConnectList(Connect $connectList)
    {
        $this->connectList[] = $connectList;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addConnect(ConnectInterface $connect)
    {
        $this->addConnectList($connect);

        return $this;
    }

    /**
     * Remove connectList
     *
     * @param Connect $connectList
     *
     * @return $this
     */
    public function removeConnectList(Connect $connectList)
    {
        $this->connectList->removeElement($connectList);

        return $this;
    }

    /**
     * Get connectList
     *
     * @return array|Collection|Connect[] $connectList
     */
    public function getConnectList()
    {
        return $this->connectList;
    }

    /**
     * Set showInContactList
     *
     * @param boolean $show
     *
     * @return self
     */
    public function setShow($show)
    {
        $this->show = (bool) $show;

        return $this;
    }

    /**
     * is show
     *
     * @return boolean
     */
    public function isShow()
    {
        return $this->show;
    }
}
