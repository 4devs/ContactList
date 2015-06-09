<?php

namespace FDevs\ContactList\Provider;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use FDevs\ContactList\Exception\NotFoundException;

class DoctrineProvider implements ContactProviderInterface
{
    /** @var ObjectRepository */
    private $repo;

    /** @var string */
    private $className;

    /**
     * init
     *
     * @param string        $className
     * @param ObjectManager $manager
     */
    public function __construct($className, ObjectManager $manager)
    {
        $this->className = $className;
        $this->repo = $manager->getRepository($className);
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        $contact = $this->repo->findOneBy(['slug' => $name]);
        if (!$contact) {
            throw new NotFoundException(sprintf('The contact "%s" is not defined.', $name));
        }

        return $contact;
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        try {
            $contact = $this->get($name);

            return $contact !== null;
        } catch (NotFoundException $e) {
            return false;
        }
    }
}
