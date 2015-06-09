<?php

namespace FDevs\ContactList\Renderer;

use FDevs\ContactList\ConnectInterface;
use FDevs\ContactList\ContactInterface;
use FDevs\ContactList\Model\Address;
use FDevs\Locale\TranslatorInterface;

class TwigRenderer implements RendererInterface
{
    const BASE_PREFIX = 'fdevs';
    const CONTACT_SUFFIX = 'contact';
    const CONNECT_SUFFIX = 'connect';
    const ADDRESS_SUFFIX = 'address';

    /** @var \Twig_Template */
    private $template;

    /** @var \Twig_Environment */
    private $environment;

    /** @var string */
    private $tpl;

    /** @var TranslatorInterface */
    private $translator;

    /**
     * init.
     *
     * @param \Twig_Environment   $environment
     * @param string              $tpl
     * @param TranslatorInterface $translator
     */
    public function __construct(\Twig_Environment $environment, TranslatorInterface $translator, $tpl = 'fdevs_contact.html.twig')
    {
        $this->environment = $environment;
        $this->tpl = $tpl;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function renderContact(ContactInterface $contact, array $options = [])
    {
        $prefix = [];
        if (!empty($options['prefix'])) {
            $prefix[] = $options['prefix'];
        } else {
            $options['prefix'] = $contact->getSlug();
        }
        $prefix[] = $contact->getSlug();
        $blockName = $this->getBlockName(self::CONTACT_SUFFIX, $prefix);

        return $this->getTemplate()->renderBlock($blockName, ['contact' => $contact, 'options' => $options]);
    }

    /**
     * {@inheritdoc}
     */
    public function renderConnect(ConnectInterface $connect, array $options = [])
    {
        $prefix = [];
        if (!empty($options['prefix'])) {
            $prefix[] = $options['prefix'].'_'.$connect->getType();
            $prefix[] = $options['prefix'];
        }
        $prefix[] = $connect->getType();
        $blockName = $this->getBlockName(self::CONNECT_SUFFIX, $prefix);

        return $this->getTemplate()->renderBlock($blockName, ['connect' => $connect, 'options' => $options]);
    }

    /**
     * {@inheritdoc}
     */
    public function renderAddress($addressList, array $options = [])
    {
        $data = '';
        $locale = empty($options['locale']) ? '' : $options['locale'];
        $address = $this->translator->transChoice($addressList, $locale);
        if ($address instanceof Address && !$address->isEmpty()) {
            $prefix = [];
            if (!empty($options['prefix'])) {
                $prefix[] = $options['prefix'];
                $prefix[] = $options['prefix'].'_'.$address->getLocale();
            }
            $prefix[] = $address->getLocale();
            $prefix[] = self::BASE_PREFIX.'_'.$address->getLocale();
            $blockName = $this->getBlockName(self::ADDRESS_SUFFIX, $prefix);

            $data = $this->getTemplate()->renderBlock($blockName, ['address' => $address, 'options' => $options]);
        }

        return $data;
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
     * get template
     *
     * @return \Twig_Template
     */
    private function getTemplate()
    {
        if (!$this->template) {
            $this->template = $this->environment->loadTemplate($this->tpl);
        }

        return $this->template;
    }

    /**
     * get block name
     *
     * @param string $suffix
     * @param array  $prefixList
     *
     * @return string
     */
    private function getBlockName($suffix, array $prefixList)
    {
        $blockName = self::BASE_PREFIX.'_'.$suffix;
        foreach ($prefixList as $prefix) {
            if ($this->getTemplate()->hasBlock($prefix.'_'.$suffix)) {
                $blockName = $prefix.'_'.$suffix;
                break;
            }
        }

        return $blockName;
    }
}
