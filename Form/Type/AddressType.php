<?php

namespace FDevs\ContactList\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', 'text', ['required' => false])
            ->add('locality', 'text', ['required' => false])
            ->add('region', 'text', ['required' => false])
            ->add('box', 'text', ['required' => false])
            ->add('code', 'text', ['required' => false])
            ->add('street', 'text', ['required' => false]);
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'FDevs\ContactList\Model\Address',
            'translation_domain' => 'FDevsContactList'
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'fdevs_locale';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'address';
    }

}
