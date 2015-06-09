<?php
namespace FDevs\ContactList\Twig;

use Doctrine\Common\Collections\Collection;
use FDevs\ContactList\Model\Address;
use FDevs\ContactList\Model\Connect;
use FDevs\ContactList\Model\Contact;

class ContactExtension extends \Twig_Extension
{
    /** @var Helper */
    private $helper;

    /**
     * init
     *
     * @param Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'fdevs_contact_list_connect';
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'contact',
                [$this, 'contactFunction'],
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'address',
                [$this, 'addressFunction'],
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'connect',
                [$this, 'connectFunction'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    /**
     * twig render block
     *
     * @param Contact|string $data
     * @param string         $prefix
     * @param string         $locale
     *
     * @return string
     */
    public function contactFunction($data, $prefix = '', $locale = '')
    {
        return $this->helper->render($data, ['prefix' => $prefix, 'locale' => $locale]);
    }

    /**
     * twig render block
     *
     * @param Connect $data
     * @param string  $prefix
     * @param string  $locale
     *
     * @return string
     */
    public function connectFunction(Connect $data, $prefix = '', $locale = '')
    {
        return $this->helper->getRenderer()->renderConnect($data, ['prefix' => $prefix, 'locale' => $locale]);
    }

    /**
     * @param Collection|array|Address[] $data
     * @param string                     $prefix
     * @param string                     $locale
     *
     * @return string
     */
    public function addressFunction($data, $prefix = '', $locale = '')
    {
        return $this->helper->getRenderer()->renderAddress($data, ['prefix' => $prefix, 'locale' => $locale]);
    }

}
