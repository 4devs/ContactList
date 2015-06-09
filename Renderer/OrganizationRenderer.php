<?php

namespace FDevs\ContactList\Renderer;

use FDevs\ContactList\ConnectInterface;
use FDevs\ContactList\ContactInterface;
use FDevs\ContactList\Model\Address;
use FDevs\ContactList\Model\Connect;
use FDevs\ContactList\Model\Contact;
use FDevs\Locale\Model\LocaleText;
use FDevs\Locale\TranslatorInterface;

class OrganizationRenderer implements RendererInterface
{
    /** @var TranslatorInterface */
    private $translator;

    /**
     * init
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function renderContact(ContactInterface $contact, array $options = [])
    {
        $data = '';
        if ($contact instanceof Contact) {
            $data .= '<div itemscope itemtype="http://schema.org/Organization">';
            $data .= $this->renderName($contact->getName(), $this->getLocale($options));
            $data .= $this->renderAddress($contact->getAddress(), $options);

            $connectList = $contact->getConnectList();
            if (count($connectList)) {
                $data .= '<ul>';
                foreach ($connectList as $connect) {
                    $data .= $this->renderConnect($connect, $options);
                }
                $data .= '</ul>';
            }
            $data .= '</div>';
        }

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function renderAddress($address, array $options = [])
    {
        $address = $this->translator->transChoice($address, $this->getLocale($options));
        $text = '';
        if ($address instanceof Address) {
            $text .= '<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
            $text .= $address->getStreet() ? ' <span itemprop="streetAddress">'.$address->getStreet().'</span>' : '';
            $text .= $address->getCode() ? ' <span itemprop="postalCode">'.$address->getCode().'</span>' : '';
            $text .= $address->getBox() ? ' <span itemprop="postOfficeBoxNumber">'.$address->getBox().'</span>' : '';
            $text .= $address->getRegion() ? ' <span itemprop="addressRegion">'.$address->getRegion().'</span>' : '';
            $text .= $address->getLocality() ? ' <span itemprop="addressLocality">'.$address->getLocality().'</span>' : '';
            $text .= $address->getCountry() ? ' <span itemprop="addressCountry">'.$address->getCountry().'</span>' : '';
            $text .= '</div>';
        }

        return $text;
    }

    /**
     * {@inheritdoc}
     */
    public function renderList($contactList, array $options = [])
    {
        $data = '';
        /** @var ContactInterface $contact */
        foreach ($contactList as $contact) {
            $data .= $this->renderContact($contact, $options);
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function renderConnect(ConnectInterface $connect, array $options = [])
    {
        $text = '';
        if ($connect instanceof Connect) {
            $text .= '<li><a href="'.$connect->getLink().'" title="'.$connect->getText().'"><i class="fa fa-'.$connect->getType().'"></i>'.$connect->getText().'</a></li>';
        }

        return $text;
    }

    /**
     * get locale
     *
     * @param array $options
     *
     * @return string
     */
    private function getLocale(array $options)
    {
        return empty($options['locale']) ? '' : $options['locale'];
    }

    /**
     * render name
     *
     * @param mixed  $name
     * @param string $locale
     *
     * @return string
     */
    private function renderName($name, $locale)
    {
        $text = $this->translator->transChoice($name, $locale);

        return $text instanceof LocaleText ? ' <span itemprop="name">'.$text->getText().'</span>' : '';
    }
}
