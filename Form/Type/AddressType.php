<?php

namespace FDevs\ContactList\Form\Type;

use FDevs\ContactList\Model\Address;
use FDevs\Locale\Form\Type\LocaleType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('country', TextType::class, ['required' => false])
            ->add('locality', TextType::class, ['required' => false])
            ->add('region', TextType::class, ['required' => false])
            ->add('box', TextType::class, ['required' => false])
            ->add('code', TextType::class, ['required' => false])
            ->add('street', TextType::class, ['required' => false]);
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
            'translation_domain' => 'FDevsContactList',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return LocaleType::class;
    }
}
