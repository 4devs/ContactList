<?php

namespace FDevs\ContactList\Twig;

use FDevs\ContactList\ContactInterface;
use FDevs\ContactList\Provider\ContactProviderInterface;
use FDevs\ContactList\Renderer\RendererInterface;
use Symfony\Component\Templating\Helper\Helper as BaseHelper;

class Helper extends BaseHelper
{
    /** @var RendererInterface */
    private $renderer;

    /** @var ContactProviderInterface */
    private $contactProvider;

    /**
     * init
     *
     * @param RendererInterface        $renderer
     * @param ContactProviderInterface $contactProvider
     */
    public function __construct(RendererInterface $renderer, ContactProviderInterface $contactProvider)
    {
        $this->renderer = $renderer;
        $this->contactProvider = $contactProvider;
    }

    /**
     * render
     *
     * @param string|ContactInterface $contact
     * @param array                   $options
     *
     * @return string
     */
    public function render($contact, array $options = [])
    {
        if (!$contact instanceof ContactInterface) {
            $contact = $this->contactProvider->get($contact);
        }

        return $this->renderer->renderContact($contact, $options);
    }

    /**
     * get rendered
     *
     * @return RendererInterface
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'contact';
    }
}
