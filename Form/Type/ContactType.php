<?php

namespace FDevs\ContactList\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug', 'text')
            ->add('name', 'trans_text', ['required' => false,'label'=>'Contact name'])
            ->add('address', 'trans', ['required' => false, 'locale_type' => 'address'])
            ->add('location', 'geo_point', ['required' => false,'label'=>'Coordinates'])
            ->add('show', 'checkbox', ['required' => false])
            ->add('connectList', 'collection', ['type' => 'connect', 'allow_delete' => true, 'allow_add' => true]);
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'FDevs\ContactList\Model\Contact',
            'translation_domain' => 'FDevsContactList'

        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'contact';
    }

}
