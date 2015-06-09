<?php

namespace FDevs\ContactList\Provider;

use FDevs\ContactList\Exception\NotFoundException;

class ChainProvider implements ContactProviderInterface
{
    /** @var array|ContactProviderInterface[] */
    private $providers = [];

    /**
     * init
     *
     * @param array|ContactProviderInterface[] $providers
     */
    public function __construct(array $providers)
    {
        foreach ($providers as $provider) {
            $this->addProvider($provider);
        }
    }

    /**
     * add provider
     *
     * @param ContactProviderInterface $provider
     *
     * @return $this
     */
    public function addProvider(ContactProviderInterface $provider)
    {
        $this->providers[] = $provider;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name, array $options = [])
    {
        foreach ($this->providers as $provider) {
            if ($provider->has($name, $options)) {
                return $provider->get($name, $options);
            }
        }

        throw new NotFoundException(sprintf('The contact "%s" is not defined.', $name));
    }

    /**
     * {@inheritdoc}
     */
    public function has($name, array $options = [])
    {
        foreach ($this->providers as $provider) {
            if ($provider->has($name, $options)) {
                return true;
            }
        }

        return false;
    }
}
