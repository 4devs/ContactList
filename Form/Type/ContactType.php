<?php

namespace FDevs\ContactList\Form\Type;

use FDevs\ContactList\Model\Contact;
use FDevs\Geo\Form\Type\PointType;
use FDevs\Locale\Form\Type\TransTextType;
use FDevs\Locale\Form\Type\TransType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('slug', TextType::class)
            ->add('name', TransTextType::class, ['required' => false, 'label' => 'Contact name'])
            ->add('address', TransType::class, ['required' => false, 'locale_type' => AddressType::class])
            ->add('location', PointType::class, ['required' => false, 'label' => 'Coordinates'])
            ->add('show', CheckboxType::class, ['required' => false])
            ->add('connectList', CollectionType::class, ['type' => ConnectType::class, 'allow_delete' => true, 'allow_add' => true]);
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'translation_domain' => 'FDevsContactList',

        ]);
    }
}
